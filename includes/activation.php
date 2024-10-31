<?php
/**
 * Fired during plugin activation.
 *
 * @link    https://github.com/vendasta
 * @since   0.1.0
 *
 * @package Conquer_Local_Platform
 */

function conquer_local_plugin_activate() {
	// Insert the plugin settings and default values for the first time
	$defaults = clp_get_default_settings();

	foreach ( $defaults as $option_name => $values ) {
		if ( false == get_option( $option_name ) ) {	
			add_option( $option_name, $values );						
		}
	}	

	// Insert the plugin version
	add_option( 'clp_version', CL_PLUGIN_VERSION );

}