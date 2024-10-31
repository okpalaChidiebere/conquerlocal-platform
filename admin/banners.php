<?php
/**
 * Banners
 *
 * @link    https://github.com/vendasta/conquer-local-academy-platform
 * @since   1.1.0
 *
 * @package Conquer_Local_Platform
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Conquer_Local_Banner class.
 *
 * @since 1.1.0
 */
class Conquer_Local_Admin_Banners {
    /**
	 * Add "Banners" menu.
	 *
	 * @since 1.1.0
	 */
	public function admin_menu() {		
        add_submenu_page(
            CL_PLUGIN_SLUG,
            'Conquer Local Platform - Banners',
            'All Banners', 
            'manage_options', 
            'edit.php?post_type=clp_banners',
        );
	}

    public function display_banner_content(){
        require_once CL_PLUGIN_DIR . 'admin/partials/dashboard.php';	
    }

    /**
	 * Move "All Banners" submenu under our plugin's main menu.
	 *
	 * @since  1.1.0
	 * @param  string $parent_file The parent file.
	 * @return string $parent_file The parent file.
	 */
	public function parent_file( $parent_file ) {	
		global $submenu_file, $current_screen;

		if ( 'clp_banners' == $current_screen->post_type ) {
			$submenu_file = 'edit.php?post_type=clp_banners';
			$parent_file  = CL_PLUGIN_SLUG;
		}
		return $parent_file;
	}

    /**
	 * Register the custom post type "clp_banners".
	 *
	 * @since 1.1.0
	 */
	public function register_post_type() {
        
        $labels = array(
			'name'                       => _x( 'CL Banners', 'Custom Post General Name' ),
			'singular_name'              => _x( 'Banner', 'Custom Post Singular Name' ),
			'menu_name'                  => __( 'CL Banners' ),
			'all_items'                  => __( 'All Banners' ),
			'parent_item'                => __( 'Parent Banner' ),
			'parent_item_colon'          => __( 'Parent Banner:' ),
			'new_item_name'              => __( 'New Banner Name' ),
			'add_new_item'               => __( 'Add New Banner' ),
			'edit_item'                  => __( 'Edit Banner' ),
			'update_item'                => __( 'Update Banner' ),
			'view_item'                  => __( 'View Banner' ),
			'separate_items_with_commas' => __( 'Separate Banners with commas' ),
			'add_or_remove_items'        => __( 'Add or remove Banners' ),
			'choose_from_most_used'      => __( 'Choose from the most used' ),
			'popular_items'              => __( 'Popular Banners' ),
			'search_items'               => __( 'Search Banners' ),
			'not_found'                  => __( 'No Banners found' ),
			'no_terms'                   => __( 'No Banners' ),
			'items_list'                 => __( 'Banners list' ),
			'items_list_navigation'      => __( 'Banners list navigation' ),
		);
        $args = array(
            'label'                 => __( 'Banner'  ),
			'description'           => __( 'Banner Description' ),
            'labels'                     => $labels,
            'supports'              => array( 'title', 'editor' ),
            'taxonomies'            => array(),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => false,  //this will maintain the active menu "All banners" whenever edit.php?post_type=clp_banners is in the url. If this is false, WP will pin this custom post typeon the sideMenu outside the menu of the conquerlocal-platform plugin
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'map_meta_cap'          => true, // we sety this to true because we want to define capabilities on who has access to the 'Add new banner' page
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capabilities'          => array(
				'manage_terms' => 'manage_options',
				'edit_terms'   => 'manage_options',				
				'delete_terms' => 'manage_options'
				// 'assign_terms' => 'edit_videos'
			)
        );

        register_post_type( 'clp_banners', $args );
    }

    /**
	 * Disable Gutenberg on our custom post type "clp_banners".
	 *
	 * @since  1.1.0
	 * @param  bool   $use_block_editor Default status.
	 * @param  string $post_type        The post type being checked.
	 * @return bool   $use_block_editor Filtered editor status.
	 */
	public function disable_gutenberg( $use_block_editor, $post_type ) {
		if ( 'clp_banners' === $post_type ) return false;
		return $use_block_editor;
	}

    /**
	 * Register meta boxes.
	 *
	 * @since 1.1.0
	 */
	public function add_meta_boxes() {
		add_meta_box( 
			CL_PLUGIN_SLUG,
			__( 'Banner Settings' ), 
			array( $this, 'display_meta_box_banner_meta_data' ), 
			'clp_banners', 
			'normal', 
			'high' 
		);	
	}

    /**
	 * Display "Banner Settings" meta box.
	 *
	 * @since 1.1.0
	 * @param WP_Post $post WordPress Post object.
	 */
	public function display_meta_box_banner_meta_data( $post ) {		
		$post_meta = get_post_meta( $post->ID );

		$image        		= isset( $post_meta['image'] ) ? $post_meta['image'][0] : '';
		$banner_cta    		= isset( $post_meta['banner_cta'] ) ? $post_meta['banner_cta'][0] : '';
		$banner_cta_link    = isset( $post_meta['banner_cta_link'] ) ? $post_meta['banner_cta_link'][0] : '';

		require_once CL_PLUGIN_DIR . 'admin/partials/banner-settings.php';
	}

    /**
	 * Save meta data.
	 *
	 * @since  1.1.0
	 * @param  int     $post_id Post ID.
	 * @param  WP_Post $post    The post object.
	 * @return int     $post_id If the save was successful or not.
	 */
	public function save_meta_data( $post_id, $post ) {	
		if ( ! isset( $_POST['post_type'] ) ) {
        	return $post_id;
    	}
	
		// Check this is the "aiovg_videos" custom post type
    	if ( 'clp_banners' != $post->post_type ) {
        	return $post_id;
    	}
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        	return $post_id;
		}

        // Check the logged in user has permission to edit this post
    	if ( ! current_user_can( 'administrator' ) ) {
        	return $post_id;
    	}

		// Check if "clp_banner_submitbox_nonce" nonce is set
    	if ( isset( $_POST['clp_banner_submitbox_nonce'] ) ) {		
			// Verify that the nonce is valid
    		if ( wp_verify_nonce( $_POST['clp_banner_submitbox_nonce'], 'clp_save_banner_submitbox' ) ) {			
				// OK to save meta data.

				//if the current post being edited is marked as featured
				if( isset( $_POST['featured'] ) ){
					//Unmark the previous post; if any
					$post_list = get_posts(array(
						'post_type' => 'clp_banners',
						'fields' => 'ids',
						// 'numberposts'      => 1,
						'meta_query' => array(
							array(
								'key'   => 'featured',
								'value' => 1,
							)
						)
					));

					if( ! empty( $post_list ) ){
						foreach ( $post_list as $id ) {
							update_post_meta( $id, 'featured', 0 );
						}
					}
				}

				//set the current post as marked
				$featured = isset( $_POST['featured'] ) ? 1 : 0;
    			update_post_meta( $post_id, 'featured', $featured );				
			}			
		} else {
			$featured = (int) get_post_meta( $post_id, 'featured', true );
			update_post_meta( $post_id, 'featured', $featured );
		}
        
        // Check if "clp_banner_meta_data_nonce" nonce is set
    	if ( isset( $_POST['clp_banner_meta_data_nonce'] ) ) {
            // Verify that the nonce is valid
    		if ( wp_verify_nonce( $_POST['clp_banner_meta_data_nonce'], 'clp_save_banner_meta_data' ) ) {	
                // OK to save meta data	
                $b_cta = isset( $_POST['banner_cta'] ) ? sanitize_text_field( $_POST['banner_cta'] ) : '';
				update_post_meta( $post_id, 'banner_cta', $b_cta );

				$b_cta_link = isset( $_POST['banner_cta_link'] ) ? clp_sanitize_url( $_POST['banner_cta_link'] ) : '';
				update_post_meta( $post_id, 'banner_cta_link', $b_cta_link );

                $image    = '';
				$image_id = 0;
				if ( ! empty( $_POST['image'] ) ) {
					$image    = clp_sanitize_url( $_POST['image'] );
					$image_id = attachment_url_to_postid( $image, 'image' );
				}
                update_post_meta( $post_id, 'image', $image );
				update_post_meta( $post_id, 'image_id', $image_id );
            }
        }

    }

	/**
	 * Retrieve the table columns.
	 *
	 * @since  1.0.0
	 * @param  array $columns Array of default table columns.
	 * @return array          Filtered columns array.
	 * @see https://developer.wordpress.org/reference/hooks/manage_post_type_posts_columns/
	 */
	public function get_post_columns( $columns ) {	
		$columns = array(
			'cb' => $columns['cb'],
			'image' => __( 'Image' ),
			'title' => __( 'Title' ),
			'misc'    => __( 'Misc' ),
			// 'author' => __( 'Author' ),
			'date' => __( 'Date' )
		);
		return $columns;		
	}

	/**
	 * This function renders the custom columns in the list table.
	 *
	 * @since 1.0.0
	 * @param string $column  The name of the column.
	 * @param string $post_id Post ID.
	 */
	public function custom_post_column_content( $column, $post_id ) {
		switch ( $column ) {
			case 'image':
				// Image column
				$image_url = get_post_meta( $post_id, 'image', true );
				$image_id  = get_post_meta( $post_id, 'image_id', true );
				printf(
					'<img src="%s" alt="" style="width: 75px;" />',
					cl_get_image_url( $image_id, 'thumbnail', $image_url )
				);
				break;
			case 'misc':
				//custom Author
				$post_author_id = get_post_field( 'post_author', $post_id );
				$user = get_userdata( $post_author_id );

				printf(
					'<span class="author column-author">%s: <a href="%s">%s</a></span>',
					esc_html__( 'Author' ),
					esc_url( admin_url( 'edit.php?post_type=clp_banners&author=' . $post_author_id ) ),
					esc_html( $user->display_name )
				);

				$featured = (int) get_post_meta( $post_id, 'featured', true );
				// Featured
				if ( $featured ) {
					printf( 
						'<br /><span class="aiovg-featured-meta">%s: %s</span>', 
						esc_html__( 'Featured' ),
						 '&#x2713;'
					);
				}
				break;
		}
	}

	/**
	 * Adds custom meta fields in the "Publish" meta box.
	 *
	 * @since 1.1.0
	 */
	public function post_submitbox_misc_actions() {	
		global $post, $post_type;
		
		if ( 'clp_banners' == $post_type ) {
			$post_id  = $post->ID;
			$featured = get_post_meta( $post_id, 'featured', true );

			require_once CL_PLUGIN_DIR . 'admin/partials/banner-submitbox.php';
		}		
	}
}
