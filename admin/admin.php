<?php
/**
 * The admin-specific functionality of the plugin.
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
 * Conquer_Local_Admin class.
 *
 * @since 1.1.0
 */
class Conquer_Local_Admin {

    public function __construct() {

        //Add admin scripts needed
        add_action( 'admin_enqueue_scripts', function(){
            wp_enqueue_style( 
                CL_PLUGIN_SLUG . '-admin',
                CL_PLUGIN_URL . 'admin/assets/admin.css', 
                array(), 
                CL_PLUGIN_VERSION, 
                'all' 
            );
            wp_enqueue_script( CL_PLUGIN_SLUG . '-admin-script', CL_PLUGIN_URL . 'admin/assets/admin.js', array(), CL_PLUGIN_VERSION, false );
        });
	}

    /**
     * Add a custom settings link that directs to the first menu page. 
     * The settings link is located in the plugin page
     * 
     * @since 1.1.0
     */
    public function plugin_action_links( $links ){
        $mylinks = array(
            '<a href="' . admin_url( 'admin.php?page=conquer-local' ) . '">Settings</a>',
        );
        return array_merge( $links, $mylinks );	
    }

    /**
    * Add plugin's main menu and "Overview" menu.
    *
    * @since 1.1.0
    */
    public function admin_menu() {	
        add_menu_page(
            'Conquer Local Platform', //page Title on top of the admin babse
            'Conquer Local', //menu title that appear in the admin side bar
            'manage_options',  //we want only admins to be able to see this page
            CL_PLUGIN_SLUG, //unique slug that shows on the url to load the menu page
            array( $this, 'display_banner_content' ), //this function displays the content of the page
            'dashicons-store',
            6
        );	

        add_submenu_page(  CL_PLUGIN_SLUG, 'Overview', 'Overview', 'manage_options', CL_PLUGIN_SLUG, array( $this, 'display_overview_content' ) );
    }

    public function display_overview_content(){
        require_once CL_PLUGIN_DIR . 'admin/partials/overview.php';	
    }
}

