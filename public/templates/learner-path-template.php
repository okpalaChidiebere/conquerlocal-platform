<?php

/**
 * Grow With Vendasta
 *
 * @link    https://github.com/vendasta
 * @since   0.1.0
 *
 * @package Conquer_Local_Platform
 */

$get_started_courses = array(
    array(
        'bp_icon' => 'icon',
        'title' => 'Get started with Vendasta platform',
        'duration' => '6 modules / 3 hrs'
    ),
    array(
        'bp_icon' => 'icon',
        'title' => 'Set up your store for success',
        'duration' => '4 modules / 3 hrs'
    ),
    array(
        'bp_icon' => 'icon',
        'title' => 'Customize your client experience with business app',
        'duration' => '2 modules / 1 hrs'
    )
);

?>
<div class="cl-block-container-fw">
    <div class="cl-block-container-inner-container">
        <?php 
            foreach ( $get_started_courses as $get_started_course ) {       
                ?>            
                <div class="cl-block-gwv-course">
                    <div class="cl-block-gwv-course-left-wrapper">
                        <div class="cl-block-gwv-course-icon"><?php echo esc_attr( $get_started_course['bp_icon'] ); ?></div>
                        <div class="cl-block-gwv-course-title-duration-wrapper">
                            <span class="cl-block-gwv-course-title cl-pt-color"><?php echo esc_attr( $get_started_course['title'] ); ?></span>
                            <span class="cl-block-gwv-course-duration cl-st-color"><?php echo esc_attr( $get_started_course['duration'] ); ?></span>
                        </div>
                    </div>
                    <div class="cl-block-gwv-course-right-wrapper">
                        <i class="bb-icon-angle-right" style="font-size: 41px;"></i>
                    </div>
                </div>
                <?php                       
            }
            ?> 
    </div>
</div>
