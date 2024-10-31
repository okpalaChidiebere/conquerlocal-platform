<?php

/**
 * Banners: "Banner Settings" meta box.
 *
 * @link    https://github.com/vendasta/conquer-local-academy-platform
 * @since   1.1.0
 *
 * @package Conquer_Local_Platform
 */
?>
<div>
    <div style="display: flex; font-size: 14px;">
        <div style="flex: 1; flex-grow: .3;"><?php esc_html_e( 'Image' ); ?></div>
        <div style="flex: 1;" class="clp-media-uploader">
            <input type="text" name="image" class="text" style="width: 75%;" placeholder="<?php esc_attr_e( 'Enter your direct file URL (OR) upload your file using the button here' ); ?> &rarr;" value="<?php echo esc_attr( $image ); ?>" />
            <span class="clp-upload-media">
                <a href="javascript:;" class="button button-secondary" data-format="image">
                    <?php esc_html_e( 'Upload File' ); ?>
                </a>
            </span>
        </div>
    </div>
    <div style="display: flex; font-size: 14px; margin-top: 20px;">
        <div style="flex: 1; flex-grow: .3;"><?php esc_html_e( 'CTA Button Text' ); ?></div>
        <div style="flex: 1;">
            <input type="text" name="banner_cta" class="text" style="width: 75%;" placeholder="<?php esc_attr_e( 'Enter your CTA button text here' ); ?> &rarr;" value="<?php echo esc_attr( $banner_cta ); ?>" />
        </div>
    </div>
    <div style="display: flex; font-size: 14px; margin-top: 20px;">
        <div style="flex: 1; flex-grow: .3;"><?php esc_html_e( 'CTA Button Text Link' ); ?></div>
        <div style="flex: 1;">
            <input type="text" name="banner_cta_link" class="text" style="width: 75%;" placeholder="<?php esc_attr_e( 'Enter your CTA button link text here' ); ?> &rarr;" value="<?php echo esc_attr( $banner_cta_link ); ?>" />
        </div>
    </div>
</div>
<?php
// Add a nonce field
wp_nonce_field( 'clp_save_banner_meta_data', 'clp_banner_meta_data_nonce' ); //this will help us verify that the user sent a post request to save the settings
