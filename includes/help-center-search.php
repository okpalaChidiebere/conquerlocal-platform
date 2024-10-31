<?php
use HelpCenter_Intergrations\HelpCenter_Client;

/**
 * Help_Center_Search
 *
 * @package Conquer_Local_Platform
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Help_Center_Search {

    /**
	* The variable to hold our configurations for the http request
	*
	* @var array
	*/
	public $config = array();

    /**
	* The variable to hold the environment of the config to be loaded
	*
	* @var string
	*/
	public $environment = '';

	/**
	* The variable to hold arguments used for search.
	* It will be used by other methods later on.
	*
	* The structure of array after being populated should be:
	* [
	*    'search_term' => gotten from $_GET['clps'],
	*    'search_subset' => gotten from $_GET['stf']
	*	 'current_page' => gotten from $_GET['stfpaged']
	* ]
	*
	* @var array
	*/
	public $search_args = array();

    /**
	 * The variable to hold search results.
	 * The results will be grouped into different types(e.g: articles, members, etc..)
	 *
	 * The structure of array after being populated should be:
	 * array(
	 * 	'articles'        => [
	 *       0    => [
	 *                'title'    => "",
	 *                'body'    =>  "",
     *                'origin'    => "",
	 *                'link'    =>  "",
	 *          ]   
	 *   ],
	 *  'pagingMetadata'	=> [
	 * 		'nextCursor'		=> 'MzA=',
	 * 		'hasMore'		=> true,
	 * 		'totalResults'		=> '122',
	 *   ]
	 * );
	 *        
	 * @var array
	*/
	public $http_search_results = array();


	/**
	* The variable to hold search results.
	* The results will be grouped into different types(e.g: posts, members, etc..)
	*
	* The structure of array after being populated should be:
	*        'Academy'        => [
	*            'total_match_count'    => 34,
	*            'items'                => array()
	*        ],
	*        'Resource Center'    =>
	*
	* @var array
	*/
	public $search_results = array();

  	/**
	* A constructor to prevent this class from being loaded more than once.
	*/
	private function __construct($configs, $env) {
		$this->config = $configs;
		$this->$environment = $env;
	}

     /**
		 * Insures that only one instance of Class exists in memory at any
		 * one time. Also prevents needing to define globals all over the place.
		 * @see Help_Center_Search::instance()
		 *
		 * @return object Help_Center_Search
		 */
	public static function instance() {
		// Store the instance locally to avoid private static replication
		static $instance = null;
	
		$environment = getenv("ENVIRONMENT");
		if ($environment == null) {
			$environment = "PROD";
		}
	
		$env_params = include_once CL_PLUGIN_DIR . '/includes/config.php';
		$config = $env_params[$environment];
	
		// Only run these methods if they haven't been run previously
		if ( null === $instance ) {
			$instance = new self($config, $environment);
		}
		// Always return the instance
		return $instance;
	}

	public function do_search( $args = '' ){
		$args = $this->sanitize_args( $args );

		$defaults = array(
			// the search term
			'search_term'   => '',
			// Restrict search results to only this subset. eg: posts, members, groups, etc.
			// See Setting > what to search?
			'search_subset' => 'all',
			'per_page'      => 20,
			// current page
			'current_page'  => 1,
		);
		$args = wp_parse_args( $args, $defaults );

		$this->search_args = $args;// save it for using in other methods
		$keyword = $args['search_term'];

		// bail out if nothing to search for
		if ( ! $keyword ) {
			return;
		}

		$helpCenter = new HelpCenter_Client();
		$response = $helpCenter->search_article($keyword);
		$results = json_decode($response, true);
		$this->http_search_results = $results;

		if ( ! empty( $results["articles"] ) ) {

			$this->search_results['all'] = array(
				'total_match_count' => count($results["articles"]),
				'items'             => $results["articles"],
			);

			/** Start grouping the aticles by their origin */
			//https://www.delftstack.com/howto/php/php-group-arrays/
			$grouped_articles_by_origin = array();
			foreach ($results["articles"] as $article) {
				$mOrgin = strtolower($article['origin']) === 'conquer local lesson' || strtolower($article['origin']) === 'conquer local academy' ? 'Academy' : $article['origin']; 
				$grouped_articles_by_origin[$mOrgin][] = $article;
			}
			/** End grouping the aticles by their origin */
		
			foreach ( $grouped_articles_by_origin as $origin => $grouped_articles ) {
				$this->search_results[ $origin ] = array(
					'total_match_count' => count($grouped_articles),
					'items'             => $grouped_articles,
				);
			}
		}
	}

	public function print_results() {

		if ( $this->has_search_results() ) {
			$current_tab = $this->getCurrentTab();

			$items_per_page = $this->search_args['per_page'];
		 	$curr_paged = $this->search_args['current_page'];
			$total_items = $this->search_results[ $current_tab ]['total_match_count'];

			$start = ($curr_paged * $items_per_page) - ($items_per_page - 1);
			$end = min($start + $items_per_page - 1, $total_items);

			echo "<span class='total-results'>Showing {$start} - {$end} out of {$total_items} results</span>";

			foreach ( array_splice( $this->search_results[ $current_tab ]['items'], $start - 1, $items_per_page ) as $item_id => $item ) {
				$mOrigin = strtolower($item['origin']);
				$target = $mOrigin === "resource center" ? "target='_blank'": "";
				$title = $item['title'];
				$link = $item['link'];

				switch ($mOrigin) {
					case 'conquer local member':
						echo "<div style='margin-bottom: 50px; display: flex'>
							<div style='margin-right: 20px;'>
							 	<img style='width: 90px;' alt='Profile photo of $title' loading='lazy' src='{$item['thumbnail']}'>
							</div>
							<div style='flex: 1;'>
								<h3 class='entry-title item-title' style='margin-bottom: 3px'><a class='clps-item' href='$link'>$title</a></h3>
								<div class='entry-summary' style='margin-bottom: 6px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;'>{$item['body']}</div>
								<span style='color: #425b76; height: 24px;font-size: 12px; font-weight: 600; letter-spacing: 0; line-height: 12px; box-sizing: border-box; border: 1px solid #7c98b6; background-color: #f5f8fa; padding: 3px 7px; margin-right: 12px;'>{$this->clean_origin_word( $item['origin'] )}</span>
							</div>
						</div>";
						break;

					default:
						echo "<div style='margin-bottom: 50px;'>
							<h3 class='entry-title item-title' style='margin-bottom: 3px'><a class='clps-item' href='$link' $target>$title</a></h3>
							<div class='entry-summary' style='margin-bottom: 6px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;'>{$item['body']}</div>
							<span style='color: #425b76; height: 24px;font-size: 12px; font-weight: 600; letter-spacing: 0; line-height: 12px; box-sizing: border-box; border: 1px solid #7c98b6; background-color: #f5f8fa; padding: 3px 7px; margin-right: 12px;'>{$this->clean_origin_word( $item['origin'] )}</span>
						</div>";
						break;
				}
			}
			$this->cl_search_pagination($total_items);
		} else {
			//bp_search_buffer_template_part( 'no-results' );
			echo "No results :(";
		}
	}

	private function cl_search_pagination($total_items){				
		$items_per_page = $this->search_args['per_page'];
		$curr_paged = $this->search_args['current_page'];
		$total_pages = ceil( $total_items / $items_per_page );
		$max_pages = 5;

		if ($total_pages <= $max_pages) {
			// total pages less than max so show all pages
			$startPage = 1;
			$endPage = $total_pages;
		} else {
			// total pages more than max so calculate start and end pages
			$max_pagesBeforeCurrentPage = floor($max_pages / 2);
			$max_pagesAfterCurrentPage = ceil($max_pages / 2) - 1;
			if ($curr_paged <= $max_pagesBeforeCurrentPage) {
				// current page near the start
				$startPage = 1;
				$endPage = $max_pages;
			} else if ($curr_paged + $max_pagesAfterCurrentPage >= $total_pages) {
				// current page near the end
				$startPage = $total_pages - $max_pages + 1;
				$endPage = $total_pages;
			} else {
				// current page somewhere in the middle
				$startPage = $curr_paged - $max_pagesBeforeCurrentPage;
				$endPage = $curr_paged + $max_pagesAfterCurrentPage;
			}
		}
		$a1 = array_fill( $startPage, min($max_pages, $endPage), "dummy" ); //create an array with startIndex being the $startPage
		$pages = array_keys( $a1 ); //get all the keys

		$search_url =  add_query_arg(
			array( 'stf' => $this->search_args['search_subset'] ),
			$this->search_page_url($this->search_args['search_term'])
		)
		?>
		<div style="margin: 0 auto; display: flex; align-items: center; width: fit-content;">
		    <?php  if ( $curr_paged > 1 ) : ?>
			<a href="<?php echo  add_query_arg( array( 'stfpaged' => $curr_paged - 1 ), $search_url ); ?>" data-pagenumber="222"><span><i class='bb-icon-angle-left'></i>Prev</span></a>
			<?php endif; ?>

			<?php foreach($pages as $page): 
				if($curr_paged === $page): ?>
					<span style="padding: 5px 6.5px; border-radius: 3px; border: 1px solid #2E7D31; background: #E7F5E9;">
						<?php echo $page; ?>
					</span>
			  	<?php else: ?>
					<a href="<?php echo add_query_arg( array( 'stfpaged' => $page ), $search_url ); ?>">
						<span style="padding: 5px 6.5px; border-radius: 3px; border: 1px solid transparent;">
							<?php echo $page; ?>
						</span>
					</a>
			 	<?php endif; ?>
			<?php endforeach; ?>

			<?php  if ( $curr_paged < $total_pages ) : ?>
			<a href="<?php echo add_query_arg( array( 'stfpaged' => $curr_paged + 1 ), $search_url ); ?>" class="wpf-prev-button"><span>Next<i class='bb-icon-angle-right'></i></span></a>
			<?php endif; ?>
		</div>
		<?php
	}

	public function print_tabs(){
		$search_term = $this->search_args['search_subset'];
		$search_url = $this->search_page_url($this->search_args['search_term']);
		$tab_url = $search_url;
		$active = $search_term === 'all' ? 'background-color: #EDEEF0;' : '';
		echo "
			<a href='$tab_url'>
			<div style='display: flex; flex-direction: row; align-items: center; min-height: 32px;font-size: 16px;line-height: 22px;white-space: nowrap; color: #666666; $active'>
					<i class='bb-icon-all-results'></i>
				<span style='margin-right: 10px; margin-left: 10px;'>All</span><span>({$this->search_results['all']['total_match_count']})<span/>
			</div> </a>";

			$search_results_withoutAll = array_filter($this->search_results, function($var) {
				return($var !== "all");
			}, ARRAY_FILTER_USE_KEY);
		
		foreach ( $search_results_withoutAll as $origin => $articles ) {
			$tab_url = add_query_arg( array( 'stf' => $origin ), $tab_url );
			$icon = '';

			$tempOrigin = strtolower($origin);
			switch ($tempOrigin) {
				case 'community':
					$icon = 'bb-icon-users';
					break;
				case 'academy':
					$icon = 'bb-icon-graduation-cap';
					break;
				case 'resource center':
					$icon = 'bb-icon-generic';
					break;
				case 'conquer local video':
					$icon = 'bb-icon-video';
					break;
				case 'conquer local member':
					$icon = 'bb-icon-all-members';
					break;
				case 'conquer local lesson':
					$icon = 'bb-icon-book-open';
					break;
				case 'conquer local group':
					$icon = ' bb-icon-groups';
					break;
			}

			$active = $search_term === $origin ? 'background-color: #EDEEF0' : '';
			echo "
			<a href='$tab_url'>
			<div style='display: flex; flex-direction: row; align-items: center; min-height: 32px;font-size: 16px;line-height: 22px;white-space: nowrap; color: #666666; {$active}'>
					<i class='$icon'></i>
				<span style='margin-right: 10px; margin-left: 10px;'>{$this->clean_origin_word( $origin )}</span><span>({$articles['total_match_count']})<span/>
			</div> </a>";
		}
	}
	
	/**
	 * Generate the help center search results page URL.
	 *
	 * @since  0.1.0
	 * @return string Search results page URL.
	 */
	public function search_page_url( $value = '' ) {

		//we already should have added the pages settings set during plugin activation
        $page_settings = get_option( 'clp_page_settings' );
	
        $url = '/';
        
        if ( $page_settings['help_center_search'] > 0 ) {
            $url = get_permalink( $page_settings['help_center_search'] );
        }

		if ( ! empty( $value ) ) {
			$url = esc_url(
				add_query_arg(
					array(
						'clps'  => $value,
					),
					$url
				)
			);
		}

		return htmlspecialchars_decode( $url );
	}

	private function getCurrentTab(){
		return isset( $this->search_args['search_subset'] ) ? $this->search_args['search_subset'] : 'all';
	}

	public function has_search_results() {
		$current_tab = $this->getCurrentTab();
		$items_per_page = $this->search_args['per_page'];
		$curr_paged = $this->search_args['current_page'];

		$start = ($curr_paged * $items_per_page) - ($items_per_page - 1);
		$items = array_slice( $this->search_results[ $current_tab ]['items'], $start - 1, $items_per_page );
		return isset( $items ) && ! empty( $items );
	}

  	/**
	* setup everything before starting to display content for search page.
	*/
	public function prepare_search_page() {
		$args = array();
		if ( isset( $_GET['stf'] ) && ! empty( $_GET['stf'] ) ) {
			$args['search_subset'] = $_GET['stf'];
		}

		if ( isset( $_GET['clps'] ) && ! empty( $_GET['clps'] ) ) {
			$args['search_term'] = $_GET['clps'];
		}

		if ( isset( $_GET['stfpaged'] ) && ! empty( $_GET['stfpaged'] ) ) {
			$current_page = (int) $_GET['stfpaged'];
			if ( $current_page > 0 ) {
				$args['current_page'] = $current_page;
			}
		}

		$this->do_search( $args );
	}

	public function sanitize_args( $args = '' ) {
		$args = wp_parse_args( $args, array() );
		if ( isset( $args['search_term'] ) ) {
			$args['search_term'] = sanitize_text_field( $args['search_term'] );
		}

		if ( isset( $args['search_subset'] ) ) {
			$args['search_subset'] = sanitize_text_field( $args['search_subset'] );
		}

		if ( isset( $args['current_page'] ) ) {
			$args['current_page'] = absint( $args['current_page'] );
		}

		return $args;
	}

	public function clean_origin_word( $origin ){
		if ( preg_match( "~\bConquer Local\b~", $origin ) ){

			return preg_replace("~\bConquer Local\b~", '', $origin, 1);
		}

		return $origin;
	}
}

