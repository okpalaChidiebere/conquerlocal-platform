<?php
/**
 * Search Form
 *
 * @link    https://github.com/vendasta
 * @since   0.1.0
 *
 * @package Conquer_Local_Platform
 */

 $image_style = '';

 if(! empty( $attributes[ 'background_image' ] )){
    $image_style  = 'background-image: url('. $attributes[ 'background_image' ] .'); ';
    $image_style .= 'background-size: cover; background-position: center; background-repeat: no-repeat;';
 }
?>
<div class="cl-block-container-page-fw cl-block-search-form-container" style="<?php echo $image_style; ?>">
    <h3 class="cl-block-search-form-header raleway-title">Conquer Local</h3>
    <div class="cl-block-search-form-input-container">
        <div><i class="bb-icon-search cl-block-icon"></i></div>
        <div class="cl-block-search-form-input-wrapper">
            <?php echo do_shortcode( '[hc_search_form]' ); ?>
        </div>
    </div>
    <?php if( !empty( $attributes['popular_searches'] )): ?>
        <div class="cl-block-search-form-popular-search-container">
            <div class="cl-block-search-popular-search-text">
            <span>Popular searches</span>
            </div>
            <?php foreach( $attributes['popular_searches'] as $keyword ) : ?>
                <a href="<?php echo esc_url( Help_Center_Search::instance()->search_page_url($keyword) ); ?>">
                    <span class="cl-block-search-form-popular-search">
                        <?php echo esc_attr( $keyword ); ?>		
                    </span> 
                </a> 
            <?php endforeach ?>
        </div>
	<?php endif; ?>
</div>