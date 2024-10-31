<?php
/**
 * Join Conquer Local Today
 *
 *
 * @package Conquer_Local_Platform
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Conquer_Local_Join_Cl_Today{
	
	/**
	 * Get things started.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		// Register shortcode(s)
		add_shortcode( "clp_join_cl_today", array( $this, "run_shortcode_join_cl_today" ) );
	}

    /**
	 * Run the shortcode [clp_join_cl_today].
	 *
	 * @since 0.1.0
	 * @param array $atts An associative array of attributes.
	 */
	public function run_shortcode_join_cl_today( $atts, $content = null ) {	
        $attributes = array();
		/**
		 * We want to render this view when the user is on the backend or not logged in
		 * @see https://github.com/WordPress/gutenberg/issues/8846 on best way to know when a user is on the backend
		 */
		if ( clp_is_backend() || !is_user_logged_in() ) {
			// Process output
			ob_start();
			include apply_filters( 'cl_load_template', CL_PLUGIN_DIR . "public/templates/conquer-local-today-template.php" );
			return ob_get_clean();
		}	
		
		 return;	
    }

}