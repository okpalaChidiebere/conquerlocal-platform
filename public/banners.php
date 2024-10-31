<?php
/**
 * Banners
 *
 * @package Conquer_Local_Platform
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Conquer_Local_Banners{
	
	/**
	 * Get things started.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		// Register shortcode(s)
		add_shortcode( "clp_banners", array( $this, "run_shortcode_banners" ) );
	}

    /**
	 * Run the shortcode [clp_banners].
	 *
	 * @since 0.1.0
	 * @param array $atts An associative array of attributes.
	 */
	public function run_shortcode_banners( $atts, $content = null ) {	
        $attributes = array(
			'include'       => isset( $atts['include'] ) ? array_map( 'intval', explode( ',', $atts['include'] ) ) : array(),
		);

        ob_start();
		include apply_filters( 'cl_load_template', CL_PLUGIN_DIR . "public/templates/banners.php" );
		return ob_get_clean();	
    }
}