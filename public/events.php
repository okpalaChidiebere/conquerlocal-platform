<?php
/**
 * Events
 *
 *
 * @package Conquer_Local_Platform
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Conquer_Local_Events{
	
	/**
	 * Get things started.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		// Register shortcode(s)
		add_shortcode( "clp_event", array( $this, "run_shortcode_cl_event" ) );
	}

    /**
	 * Run the shortcode [clp_event].
	 *
	 * @since 0.1.0
	 * @param array $atts An associative array of attributes.
	 */
	public function run_shortcode_cl_event( $atts, $content = null ) {	
		$attributes = shortcode_atts( array(
			'event_title' => 'something',
			'date' => 'something else',
			'date_description' => 'something else',
			'registration_link' => '#',
			'card_image' => 'https://academy.conquerlocal.com/wp-content/uploads/2021/11/CL-header-Sess.jpg',
		), $atts );

        //If the shortcode produces a lot of HTML then ob_start can be used to capture output and convert it to a string
        // https://codex.wordpress.org/Shortcode_API
        ob_start();
		include apply_filters( 'cl_load_template', CL_PLUGIN_DIR . "public/templates/events-template.php" );
		return ob_get_clean();	
    }
}