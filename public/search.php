<?php

/**
 * Search
 *
 *
 * @package Conquer_Local_Platform
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Conquer_Local_Search{
    /**
	 * The detault shortcode attribute values.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array     $defaults An associative array of defaults.
	 */
	protected $defaults = array();
	
	/**
	 * Get things started.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Register shortcode(s)
		add_shortcode( "hc_search_form", array( $this, "run_shortcode_search_hc_search_form" ) );
		add_shortcode( "clp_search_form", array( $this, "run_shortcode_search_form" ) );
		add_shortcode( "clp_search", array( $this, "run_shortcode_search" ) );
	}

	public function run_shortcode_search_hc_search_form( $atts ){
				
		$attributes = array(
			'sidebar'       => isset( $atts['sidebar'] ) ? $atts['sidebar'] : 'no',
			'color'		=> isset( $atts['color'] ) ? $atts['color'] : '#48A06A',
		);

		ob_start();
		include apply_filters( 'cl_load_template', CL_PLUGIN_DIR . "public/templates/hc-search-form-template.php" );
		return ob_get_clean();	
	}

    /**
	 * Run the shortcode [clp_search_form].
	 *
	 * @since 1.0.0
	 * @param array $atts An associative array of attributes.
	 */
	public function run_shortcode_search_form( $atts, $content = null ) {	
		$attributes = array(
			'popular_searches'       => isset( $atts['popular_searches'] ) ? explode( ',', $atts['popular_searches'] ) : array( ),
			'background_image'		=> isset( $atts['background_image'] ) ? $atts['background_image'] : '',
		);
		// print_r($attributes);

        //If the shortcode produces a lot of HTML then ob_start can be used to capture output and convert it to a string
        // https://codex.wordpress.org/Shortcode_API
        ob_start();
		include apply_filters( 'cl_load_template', CL_PLUGIN_DIR . "public/templates/search-form-template.php" );
		return ob_get_clean();	
    }

	/**
	 * Run the shortcode [clp_search].
	 * 
	 * This shortcode is used for the dynamic page we created when the plugin is activated that has this shortcode as the content to display 
	 * search results from help-center
	 *
	 * @since 1.0.0
	 * @param array $atts An associative array of attributes.
	 */
	public function run_shortcode_search( $atts, $content = null ) {	

        // ob_start();
		include apply_filters( 'cl_load_template', CL_PLUGIN_DIR . "public/templates/search-template.php" );
		// return ob_get_clean();	
    }

}
