<?php
/**
 * Fired during plugin deactivation.
 *
 * @link    https://github.com/vendasta
 * @since   0.1.0
 *
 * @package Conquer_Local_Platform
 */

function conquer_local_plugin_deactivate(){
    $settingOptions = array( 'clp_page_settings' );
 
    // Clear up our settings
    foreach ( $settingOptions as $settingName ) {
        delete_option( $settingName );
    }
}