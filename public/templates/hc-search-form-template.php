<?php
/**
 * Help Center Search Form
 *
 * @link    https://github.com/vendasta
 * @since   1.1.1
 *
 * @package Conquer_Local_Platform
 * 
 */

 $style = '';

 if( $attributes[ 'sidebar' ] === 'yes' ){
    $style .= 'border: 1px solid #DADADA !important;  border-radius: 4px; width: 100%;';
    $attributes[ 'color' ] = '#777777';
 }
?>
<form method="get" style="margin-bottom: 0px; width: 100%;" action="<?php echo esc_url( Help_Center_Search::instance()->search_page_url() ); ?>">
    <input type="text" name="clps" class="cl-block-search-form-input" style="--hc-form-color: <?php echo $attributes['color'].'; '.$style;?>" placeholder="<?php esc_attr_e( 'Search ...', 'conquer-local' ); ?>" value="<?php echo clp_get_search_query(); ?>"/>
</form>