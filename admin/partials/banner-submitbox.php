<?php

/**
 * Banners: Add new fields in the "Publish" metabox.
 *
 * @link    https://github.com/vendasta/conquer-local-academy-platform
 * @since   1.1.0
 *
 * @package Conquer_Local_Platform
 */
?>
    
<?php if ( current_user_can( 'administrator' ) ) :	
	wp_nonce_field( 'clp_save_banner_submitbox', 'clp_banner_submitbox_nonce' ); // Add a nonce field  value="1"
	?>
	<div class="misc-pub-section">
		<label>
			<input type="checkbox" name="featured" value="1" <?php checked( $featured, 1 ); ?> />
			<?php esc_html_e( "Mark as" ); ?>
			<strong><?php esc_html_e( "Featured" ); ?></strong>
		</label>
	</div>

	<hr />
<?php endif; ?>
<div class="misc-pub-section misc-pub-aiovg-shortcode">
	<label>
		<strong><?php esc_html_e( "Banner Shortcode" ); ?></strong>
    	<input type="text" class="widefat" readonly="readonly" value="[clp_banners include=<?php echo (int) $post_id; ?>]" />
    </label>
</div>