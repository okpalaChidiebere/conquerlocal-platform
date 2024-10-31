<?php
/**
 * Plugin Name: 	ConquerLocal Platform
 * Plugin URI: 		https://github.com/vendasta/conquerlocal-platform
 * Description:    	The ConquerLocal Platform adds Help Center Search to WordPress. ConquerLocal Events, and more!
 * Version: 		1.2.1
 * Author: 			Chidiebere Okpala Collins
 * Author URI: 		https://github.com/vendasta/
 * Text Domain: 	conquerlocal-platform
 * Domain Path: 	languages
 *
 * @package			Conquer_Local_Platform
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// The current version of the plugin
if ( !defined( 'CL_PLUGIN_VERSION' ) ) {
    define( 'CL_PLUGIN_VERSION', '1.2.2*' );
}
// The unique identifier of the plugin
if ( !defined( 'CL_PLUGIN_SLUG' ) ) {
    define( 'CL_PLUGIN_SLUG', 'conquer-local' );
}
// Path to the plugin directory
if ( !defined( 'CL_PLUGIN_DIR' ) ) {
    define( 'CL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
// URL of the plugin
if ( !defined( 'CL_PLUGIN_URL' ) ) {
    define( 'CL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// URL of the plugin
if ( !defined( 'CL_PLUGIN_FILE_NAME' ) ) {
    define( 'CL_PLUGIN_FILE_NAME', plugin_basename( __FILE__ ) );
}

if ( ! class_exists( 'Conquer_Local_Platform' ) ) :
	/**
	 * Main Conquer_Local_Platform Class.
	 *
	 * @since 0.1.0
	 */
	final class Conquer_Local_Platform {
		/**
		 * This plugin's instance.
		 *
		 * @var Conquer_Local_Platform
		 * @since 1.0.0
		 */
		private static $instance;

		/**
		 * Main Conquer_Local_Platform Instance.
		 *
		 * Insures that only one instance of Conquer_Local_Platform exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 0.1.0
		 * @static
		 * @return object|Conquer_Local_Platform The one true Conquer_Local_Platform
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Conquer_Local_Platform ) ) {
				self::$instance = new Conquer_Local_Platform();
				self::$instance->includes();
				self::$instance->define_public_hooks();
				self::$instance->define_admin_hooks();
			}
			return self::$instance;
		}

		/**
		 * Includes all necessary PHP files
		 *
		 * This function is responsible for including all necessary PHP files.
		 *
		 * @access private
		 * @since 0.1.0
		 * @return void
		 */
		private function includes() {
			/**
			 * The file that holds the general helper functions.
			 */
			require_once CL_PLUGIN_DIR . 'includes/functions.php';

			//class responsible for Conquer Local Blocks
			require_once CL_PLUGIN_DIR . 'includes/class-conquer-local-register-blocks.php';

			//class responsible for Help center search
			require_once CL_PLUGIN_DIR . 'includes/help-center-search.php';

			/**
			 * The class(es) responsible for defining all actions that occur in the public-facing
			 * side of the site. Eg Shortcodes
			 */
			require_once CL_PLUGIN_DIR . 'public/public.php';
			require_once CL_PLUGIN_DIR . 'public/search.php';
			require_once CL_PLUGIN_DIR . 'public/join-cl-today.php';
			require_once CL_PLUGIN_DIR . 'public/podcasts.php';
			require_once CL_PLUGIN_DIR . 'public/events.php';
			require_once CL_PLUGIN_DIR . 'public/community-discussions.php';
			require_once CL_PLUGIN_DIR . 'public/banners.php';

			/**
			 * The classes responsible for defining all actions that occur in the admin area.
			 */
			require_once CL_PLUGIN_DIR . 'admin/admin.php';
			require_once CL_PLUGIN_DIR . 'admin/banners.php';
		}

		/**
		 * Register all of the hooks related to the admin area functionality
		 * of the plugin.
		 *
		 * @since  1.1.0
		 * @access private
		 */
		private function define_admin_hooks() {
			/** All Admin Hooks Here */

			// Hooks common to all admin pages
			$admin = new Conquer_Local_Admin();
			add_action( 'admin_menu', array( $admin, 'admin_menu' ) );
			add_filter( 'plugin_action_links_' . CL_PLUGIN_FILE_NAME, array( $admin, 'plugin_action_links' ) );

			// Hooks specific to the banners page
			$admin_banners = new Conquer_Local_Admin_Banners();
			add_action( 'admin_menu', array( $admin_banners, 'admin_menu' ) );
			add_action( 'init', array( $admin_banners, 'register_post_type' ) );
			add_filter( 'parent_file', array( $admin_banners, 'parent_file' ) );
			add_action( 'post_submitbox_misc_actions', array( $admin_banners, 'post_submitbox_misc_actions' ) );
			add_action( 'add_meta_boxes', array( $admin_banners, 'add_meta_boxes' ) );
			/** diable gutenberg on our custom post type page
			 * 
			 * You must override  use_block_editor_for_post_type and gutenberg_can_edit_post_type at thesame time to 
			 * fully disable gutenberg otherwise your site will crash
			 */
			add_filter( 'use_block_editor_for_post_type', array( $admin_banners, 'disable_gutenberg' ), 10, 2 ); 
			add_filter( 'gutenberg_can_edit_post_type', array( $admin_banners, 'disable_gutenberg' ), 10, 2 );
			/** end disabling gutenberg */	
			add_action( 'save_post', array( $admin_banners, 'save_meta_data' ), 10, 2 );
			add_filter( 'manage_clp_banners_posts_columns', array( $admin_banners, 'get_post_columns' ) ); //adding, removing, and/or re-ordering columns
			add_action( 'manage_clp_banners_posts_custom_column', array( $admin_banners, 'custom_post_column_content' ), 10, 2); //populating the columns
		}

		/**
		 * Register all of the hooks related to the public-facing functionality
		 * of the plugin.
		 *
		 * @since  0.1.0
		 * @access private
		 */
		private function define_public_hooks() {
			// Hooks common to all public pages
			
			add_action( 'wp_enqueue_scripts', function(){
				wp_enqueue_style( 
					CL_PLUGIN_SLUG . '-public', //conquer-local-public
					CL_PLUGIN_URL . 'public/assets/public.css', 
					array(), 
					CL_PLUGIN_VERSION, 
					'all' 
				);
				wp_enqueue_script( CL_PLUGIN_SLUG . '-plugin-script', CL_PLUGIN_URL . 'public/assets/clp-scripts.js', array(), CL_PLUGIN_VERSION );
				wp_localize_script( CL_PLUGIN_SLUG . '-plugin-script', 'frontend_clp_object',
					array( 
						'login_url' => wp_login_url(),
					)
				);				
			});

			/** Initialize Shortcodes */
			$search = new Conquer_Local_Search();
			$cl_today = new Conquer_Local_Join_Cl_Today();
			$podcats = new Conquer_Local_Podcasts();
			$events = new Conquer_Local_Events();
			$discussions = new Conquer_Local_Community_Discussions();
			$banners = new Conquer_Local_Banners();

		}
	}

endif;

/**
 * The main function for returning instance
 *
 * @return object The one and only true instance.
 * @since 0.1.0
 */
function conquerlocal() {
	return Conquer_Local_Platform::instance();
}


require_once CL_PLUGIN_DIR . 'includes/activation.php';
register_activation_hook( __FILE__, 'conquer_local_plugin_activate' );
require_once CL_PLUGIN_DIR . 'includes/deactivation.php';
register_deactivation_hook( __FILE__, 'conquer_local_plugin_deactivate' );
// Run plugin
conquerlocal();
