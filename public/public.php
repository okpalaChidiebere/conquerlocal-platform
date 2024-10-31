<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

add_filter( 'the_title', 'clp_the_title', 99, 2 );
add_filter( 'single_post_title', 'clp_the_title', 99 );
/**
 * Change the current page title if applicable.
 *
 * @since  0.1.0
 * @param  string $title   Current page title.
 * @param  int    $post_id The post ID.
 * @return string $title   Filtered page title.
 */
function clp_the_title($title, $id = 0) {
    if ( ! in_the_loop() || ! is_main_query() ) {
        return $title;
    }

    global $post;

    if ( ! empty( $id ) ) {
        if ( $id != $post->ID ) {
            return $title;
        }
    }

    $page_settings = get_option( 'clp_page_settings' );

    // Change help center search page title
	if ( $post->ID == $page_settings['help_center_search'] ) {
            $queries = array();
			
		if ( ! empty( $_GET['clps'] ) ) {
			$queries[] = sanitize_text_field( $_GET['clps'] );				
		}

        if ( ! empty( $queries ) ) {
			$title = sprintf( 'Showing results for "%s"', implode( ', ', $queries ) );	
		}	
    }
    return $title;
}
