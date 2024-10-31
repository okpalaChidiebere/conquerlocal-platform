<?php
/**
 * Podcasts
 *
 *
 * @package Conquer_Local_Platform
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Conquer_Local_Podcasts{
	
	/**
	 * Get things started.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		// Register shortcode(s)
		add_shortcode( "clp_podcasts", array( $this, "run_shortcode_podcasts" ) );
	}

    /**
	 * Run the shortcode [clp_podcasts].
	 *
	 * @since 0.1.0
	 * @param array $atts An associative array of attributes.
	 */
	public function run_shortcode_podcasts( $atts, $content = null ) {	
        $attributes = array();

		$podcasts = clp_get_remote_five_recent_podcasts();

		$featuredPodcastList = array_filter ($podcasts, function ($podcast){
			return $podcast['featured'];
		});
		$featuredPodcast = count($featuredPodcastList) ? $featuredPodcastList[0] : $podcasts[0];
		$unfeaturedPodcasts =  count($featuredPodcastList) ? array_filter ($podcasts, function ($podcast){
			return !$podcast['featured'];
		}) : array_slice($podcasts,1,4);

        //If the shortcode produces a lot of HTML then ob_start can be used to capture output and convert it to a string
        // https://codex.wordpress.org/Shortcode_API
        ob_start();
		include apply_filters( 'cl_load_template', CL_PLUGIN_DIR . "public/templates/podcasts-template.php" );
		return ob_get_clean();	
    }

}