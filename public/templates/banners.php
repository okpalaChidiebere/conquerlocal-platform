<?php
/**
 * Banners
 *
 * @link    https://github.com/vendasta
 * @since   1.1.0
 *
 * @package Conquer_Local_Platform
 */

/**
 * @see https://developer.wordpress.org/reference/classes/wp_query/
 */
$args = array(  
    'post_type' => 'clp_banners',
    'no_found_rows' => true, 
    'post_status' => 'publish',
);

if ( count( $attributes['include'] ) ) { // Include banner IDs
    $args['post__in'] = $attributes['include']; //like: 'post__in'   => array( 1, 4, 200 )
}else{
    $args['posts_per_page'] = 3; // we want only the three recent post by default
    $args['order'] = 'DESC';
    $args['order_by'] = 'date';
}

$post_list = get_posts($args);
$banners = array();
$mBanners = array();

foreach ( $post_list as $post ) {
    $image = get_post_meta( $post->ID, 'image', true );
    $cta_button = get_post_meta( $post->ID, 'banner_cta', true );
    $cta_button_link = get_post_meta( $post->ID, 'banner_cta_link', true );
    $featured = (int) get_post_meta( $post->ID, 'featured', true );

    $mPost = array(
        'title' => $post->post_title,
        'body' => $post->post_content,
        'cta_button_link' => $cta_button_link,
        'cta_button' => $cta_button, 
        'image' => $image,
        'featured' => $featured,
        'id' => $post->ID
    );
    
    array_push($banners, $mPost);
} 

if( count( $attributes['include'] ) ){
    //we keep the order of the banners in the order thesame order of the ids included in the shortcode
    foreach ( $attributes['include'] as $id ) {
        $mBanners = array_merge($mBanners, array_filter($banners, function($p) use ($id){ return $p['id'] === $id;}));
    }
}else{
   //get the featured banner
   $featured_banner = array_filter($banners, function($b){ return $b['featured'];});
   $unfeatured_banner = array_filter($banners, function($b){ return !$b['featured'];});
   $mBanners = array_merge($featured_banner, $unfeatured_banner);
}

if( count($banners) ):
?>
<div class="slideshow-container">     
    <?php foreach( $mBanners as $banner ): ?>            
        <div class="custom-slides-wrapper fade">
            <div class="custom-slide community-promo" style="background-color: #0B2745; padding: 0px">
                <div class="custom-slide-left" style="padding: 0px 0px 0px 50px;">
                    <h1>
                        <span class="has-inline-color has-white-color" style="font-weight: 700;"><?php echo $banner['title']; ?></span>
                    </h1>
                    <p><?php echo $banner['body']; ?></p>
                    <div class="wp-block-buttons">
                        <div class="wp-block-button is-style-fill">
                            <a data-action="user-clicked-start-snapshot-lesson-banner-button" class="wp-block-button__link has-text-color has-background" href="<?php echo $banner['cta_button_link']; ?>" style="background-color: #48a06a;" rel="noreferrer noopener">
                                <?php echo $banner['cta_button']; ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="custom-slide-right custom-slide-right-banner" style="align-items:center;">
                    <div style=" width:100%; padding: 0 50px 0 15px; max-height:550px;">
                        <img src="<?php echo $banner['image']; ?>" alt="Vendasta Executive Report" width="100%" height="100%" style="max-height:550px;">
                    </div>
                </div>
            </div>
        </div>         
    <?php endforeach; ?>
    <?php if ( count($banners) > 1 ): ?>
    <div class="custom-banner-dots-container">
        <?php for ($x = 0; $x < count($banners); $x++) {
            echo '<span class="custom-banner-dot"></span>';
        }?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
