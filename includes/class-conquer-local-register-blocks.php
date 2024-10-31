<?php
/**
 * Register blocks.
 *
 * @package Conquer_Local_Platform
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load registration for our blocks.
 *
 * @since 1.6.0
 */
class Conquer_Local_Register_Blocks {

	/**
	 * This plugin's instance.
	 *
	 * @var Conquer_Local_Register_Blocks
	 */
	private static $instance;



	/**
	 * Registers the plugin.
	 *
	 * @return Conquer_Local_Register_Blocks
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new Conquer_Local_Register_Blocks();
		}

		return self::$instance;
	}

	/**
	 * The Constructor.
	 */
	public function __construct() {

		if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
			add_filter( 'block_categories_all',  array( $this, 'block_categories' ));
		} else {
			add_filter( 'block_categories', array( $this, 'block_categories' ) );
		}

		add_action( 'init', array( $this, 'register_block_types' ), 99 );
        add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
	}

    /**
     * Register our custom Gutenberg block category.
	 * 
	 * @see https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#managing-block-categories
     * @param  array $categories Default Gutenberg block categories.
    * @return array             Modified Gutenberg block categories.
    */
    public function block_categories( $categories ) {		
        return array_merge(
            $categories,
            [
                [
                    'slug'  => 'conquer-local',
                    'title' => __( 'Conquer Local Platform Blocks' ),
               ],
            ]
        );	
    }

    public function enqueue_block_editor_assets() {
        $assets = include_once CL_PLUGIN_DIR . '/blocks/build/index.asset.php';

		$top_3_searches = clp_get_help_center_popular_searches();
		$attributes = array(
			'i18n'       => array(
				'block_search_name'       => CL_PLUGIN_SLUG . '/search',
				'block_search_title'       => 'Conquer Local - Search',
				'block_search_description' => 'Display a Search Form that uses the Help Center API',
				'block_suggestions_name'       => CL_PLUGIN_SLUG . '/suggestions',
				'block_suggestions_title'       => 'Conquer Local - Suggestions',
				'block_suggestions_description' => 'Display Conquer Local quick actions container',
				'block_suggestions_row_name'       => CL_PLUGIN_SLUG . '/suggestions-row',
				'block_suggestions_row_title'       => 'Conquer Local - Suggestions Row Item',
				'block_suggestions_row_description' => 'Display Conquer Local quick actions items card',
				'block_learner_path_name'       => CL_PLUGIN_SLUG . '/learner-path',
				'block_learner_path_title'       => 'Conquer Local - Learner Path',
				'block_learner_path_description' => 'Display the container courses learner path',
				'block_learner_path_row_name'       => CL_PLUGIN_SLUG . '/learner-path-row',
				'block_learner_path_row_title'       => 'Conquer Local - Learner Path Row Item',
				'block_learner_path_row_description' => 'Display each courses learner path for partners \'work to be done\'',
				'block_cl_today_name'       => CL_PLUGIN_SLUG . '/cl-today',
				'block_cl_today_title'       => 'Conquer Local - Join Conquer Local Today',
				'block_cl_today_description' => 'Display the aproximated count of partners, aproximated count of courses',
				'block_podcasts_name'       => CL_PLUGIN_SLUG . '/podcasts',
				'block_podcasts_title'       => 'Conquer Local - Podcasts',
				'block_podcasts_description' => 'Display the Conquer Local podcasts block',
				'block_community_discussions_name'       => CL_PLUGIN_SLUG . '/community-discussions',
				'block_community_discussions_title'       => 'Conquer Local - Community Discussions',
				'block_community_discussions_description' => 'Display the topics from wpForo',
				'block_cl_events_name'       => CL_PLUGIN_SLUG . '/cl-events',
				'block_cl_events_title'       => 'Conquer Local - Events',
				'block_cl_events_description' => 'Display the Conquer Local events',
				'success_stories_name'		=> CL_PLUGIN_SLUG .'/success-stories',
				'success_stories_title'		=> 'Conquer Local - Success Stories',
				'success_stories_description'	=> 'Features Vendasta partners success stories',
			),
			'search'	=> array(
				'popular_searches'				=> $top_3_searches
			)
		);

        //enqueue the block js file
        wp_register_script( 
            CL_PLUGIN_SLUG . '-js', 
            CL_PLUGIN_URL . '/blocks/build/index.js',
            $assets['dependencies'],
            /**the version number of the new build. This helps you browser to efficiently load the new js verison */
            $assets['version']
        );

		wp_enqueue_style( 
			CL_PLUGIN_SLUG . '-public', 
			CL_PLUGIN_URL . 'public/assets/public.css', 
			array(), 
			CL_PLUGIN_VERSION
		);

		//you are able to make some php data in JS through an object :)
		wp_localize_script( 
			CL_PLUGIN_SLUG . '-js', 
			'cl_blocks', 
			$attributes
		);
    }

	/**
	 * Add actions to enqueue assets.
	 *
	 * @access public
	 */
	public function register_block_types() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		register_block_type( CL_PLUGIN_SLUG . '/search', array(
			'attributes'      => array(
				'popular_searches'  => array(
					'type'  => 'array',
					'items' => array(
						'type' => 'string',
					),
				),
				'background_image'  => array(
					'type'  => 'string',
				)
			),
			'editor_script' => CL_PLUGIN_SLUG . '-js',
			// 'editor_style'  => $slug . '-editor',
			'render_callback' => array( $this, 'render_search_block' ),
		) );

		register_block_type( CL_PLUGIN_SLUG . '/suggestions', array(
			'editor_script' => CL_PLUGIN_SLUG . '-js',
		) );

		register_block_type( CL_PLUGIN_SLUG . '/learner-path', array(
			'editor_script' => CL_PLUGIN_SLUG . '-js',
		) );

		register_block_type( CL_PLUGIN_SLUG . '/cl-today', array(
			'editor_script' => CL_PLUGIN_SLUG . '-js',
			'render_callback' => array( $this, 'render_cl_today_block' ),
		) );

		register_block_type( CL_PLUGIN_SLUG . '/podcasts', array(
			'editor_script' => CL_PLUGIN_SLUG . '-js',
			'render_callback' => array( $this, 'render_podcasts_block' ),
		) );

		register_block_type( CL_PLUGIN_SLUG . '/cl-events', array(
			'editor_script' => CL_PLUGIN_SLUG . '-js',
		) );

		register_block_type( CL_PLUGIN_SLUG . '/community-discussions', array(
			'editor_script' => CL_PLUGIN_SLUG . '-js',
			'render_callback' => array( $this, 'render_community_discussions_block' ),
		) );

		register_block_type( CL_PLUGIN_SLUG . '/success-stories', array(
			'editor_script' => CL_PLUGIN_SLUG . '-js',
		) );
	}



	/**
	 * Render the community discussions block frontend.
	 *
	 * @param  array  $atts An associative array of attributes.
	 * @return string       HTML output.
	 */
	public function render_community_discussions_block( $atts ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        	return;
		}

		return do_shortcode( '[clp_community_discussions ' . $this->build_shortcode_attributes( $atts ) . ']' );
	}

	/**
	 * Render the podcasts block frontend.
	 *
	 * @param  array  $atts An associative array of attributes.
	 * @return string       HTML output.
	 */
	public function render_podcasts_block( $atts ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        	return;
		}

		return do_shortcode( '[clp_podcasts ' . $this->build_shortcode_attributes( $atts ) . ']' );
	}

	/**
	 * Render the search form block frontend.
	 *
	 * @param  array  $atts An associative array of attributes.
	 * @return string       HTML output.
	 */
	public function render_search_block( $atts ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        	return;
		}

		if ( empty( $atts['popular_searches'] ) ) {
			$atts['popular_searches'] = clp_get_help_center_popular_searches();
		}	
		return do_shortcode( '[clp_search_form ' . $this->build_shortcode_attributes( $atts ) . ']' );
	}

	/**
	 * Render the categories block frontend.
	 *
	 * @since  0.1.0
	 * @param  array  $atts An associative array of attributes.
	 * @return string       HTML output.
	 */
	public function render_cl_today_block( $atts ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        	return;
		}

		return do_shortcode( '[clp_join_cl_today ' . $this->build_shortcode_attributes( $atts ) . ']' );
	}

	/**
	 * Build shortcode attributes string.
	 * 
	 * @since  1.5.6
	 * @access private
	 * @param  array   $atts Array of attributes.
	 * @return string        Shortcode attributes string.
	 */
	private function build_shortcode_attributes( $atts ) {
		$attributes = array();
		
		foreach ( $atts as $key => $value ) {
			if ( is_null( $value ) ) {
				continue;
			}

			if ( is_bool( $value ) ) {
				$value = ( true === $value ) ? 1 : 0;
			}

			if ( is_array( $value ) ) {
				$value = implode( ',', $value );
			}

			$attributes[] = sprintf( '%s="%s"', $key, $value );
		}
		
		return implode( ' ', $attributes );
	}
}

Conquer_Local_Register_Blocks::register();
