<?php
/**
 * Community_Discussions
 *
 *
 * @package Conquer_Local_Platform
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Conquer_Local_Community_Discussions{
	
	/**
	 * Get things started.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		// Register shortcode(s)
		add_shortcode( "clp_community_discussions", array( $this, "run_shortcode_community_discussions" ) );
	}

    /**
	 * Run the shortcode [clp_community_discussions].
	 *
	 * @since 0.1.0
	 * @param array $atts An associative array of attributes.
	 */
	public function run_shortcode_community_discussions( $atts, $content = null ) {	
        $attributes = array();

        //If the shortcode produces a lot of HTML then ob_start can be used to capture output and convert it to a string
        // https://codex.wordpress.org/Shortcode_API
        ob_start();
		include apply_filters( 'cl_load_template', CL_PLUGIN_DIR . "public/templates/community-discussions-template.php" );
		return ob_get_clean();	
    }
}