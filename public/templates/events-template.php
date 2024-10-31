<?php

/**
 * Events
 *
 * @link    https://github.com/vendasta
 * @since   0.1.0
 *
 * @package Conquer_Local_Platform
 */
?>
<div class="cl-block-suggestions-grid-block" style="width: 100%; height: <?php echo empty($content) ? '100%' : 'auto'; ?>; padding: 0px; margin: 0px;">
    <div class="cl-block-card cl-block-cl-event-card">
        <div class="cl-block-cl-event-card-thumbnail">
            <img src="<?php echo esc_attr( $attributes['card_image'] ); ?>" style="height: 100%; object-fit: <?php echo empty($content) ? 'contain' : 'cover'; ?>; width: 100%;">
        </div>
        <a target="_blank" href="<?php echo $attributes['registration_link']; ?>" style="color: inherit;" rel="noopener">
            <div style="margin: 15px 10px;">
                <span class="cl-block-gwv-course-title cl-pt-color raleway-title" style="font-size: 18px;"> <?php echo esc_attr( $attributes['event_title'] ); ?></span>
                <div class="cl-st-color">
                    <i class="bb-icon-calendar"></i>
                    <span style="font-size: 14px;"><?php echo esc_attr( $attributes['date'] ); ?></span>
                </div>
                <div class="cl-st-color">
                    <i class="bb-icon-clock"></i>
                    <span style="font-size: 14px;"><?php echo esc_attr( $attributes['date_description'] ); ?></span>
                </div>
                <?php if(!empty($content)): ?>
                    <div>
                        <?php echo $content; ?>
                    </div>
                    <div style="margin-top: 20px;"><a target="_blank" href="<?php echo esc_attr( $attributes['registration_link'] ); ?>" rel="noopener">Register Here</a></div>
                <?php endif; ?>
            </div>
        </a>
    </div>
</div>