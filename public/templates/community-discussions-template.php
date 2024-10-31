<?php

/**
 * Community discussions
 *
 * @link    https://github.com/vendasta
 * @since   0.1.0
 *
 * @package Conquer_Local_Platform
 */

$trendingPosts = get_wpforo_trending_topics();
$LatestPosts = get_wpforo_latest_topics();
$base_url = get_home_url();
$clp_is_backend = clp_is_backend();
?>

<div class="cl-block-container-fw cl-block-container-items-center">
    <div class="cl-block-container-inner-container cl-block-container-inner-center">
        <h2 class="cl-pt-color cl-block-title raleway-title">Community Discussions</h2>

        <div class="cl-block-community-discussions-switch">
            <div id="cl-block-trending-radio" class="cl-block-community-discussions-switch-item <?php echo $clp_is_backend ? "cl-block-community-discussions-switch-active-item" : ""; ?>">Trending</div>
            <div class="cl-block-community-discussions-switch-divider"></div> <!-- divider -->
            <div id="cl-block-latest-radio" class="cl-block-community-discussions-switch-item" >Latest</div>
        </div>
        <div class="cl-block-join-cl-card-container cl-block-community-discussions-thread-body">
            <?php foreach( $trendingPosts as $trendingPost ):  
                $forumName = $trendingPost->forum_name;
                $date = $trendingPost->date_posted;
                $nickname = $trendingPost->author_nickname;
            ?>
            
                <div class="cl-block-community-discussions-thread-box cl-block-trending-posts">
               
                    <div class="cl-block-community-discussions-thread-box-avatar-container">
                        <div class="cl-block-community-discussions-thread-box-avatar"><?php echo WPF()->member->get_avatar($trendingPost->userid, "", 100); ?></div>
                    </div>
                    <div class="cl-block-community-discussions-thread-box-metadata-container">
                    <div>
                        <span class="cl-st-color " style="font-size: 12px;">
                            <?php echo '<a class="cl-community-disccusion-hyperlink" href="'. $base_url .'/members/'
                            . $trendingPost->userid .'" style="color: #3F9B63;">'.$nickname.'</a>  / <a class="cl-community-disccusion-hyperlink" href="'. $base_url 
                            .'/'. $trendingPost->forum_link .'" style="color: #3F9B63;">Posted in '.$forumName.'</a> / '
                            . date('M d, Y', $date);?> 
                        </span>
                    </div>
                        <a href="<?php echo $trendingPost->permalink; ?>">
                        <span class="cl-block-gwv-course-title cl-pt-color raleway-title"><?php echo  esc_attr($trendingPost->post_title); ?></span>
                         </a>
                        <span class="cl-st-color cl-community-discussions-body" style="font-size: 14px;"><?php echo  strip_tags(preg_replace("/\[attach][^*]+\[\/attach]/","",$trendingPost->post_body)); ?></span>
                    </div>
                  
                </div>
           
			<?php endforeach; ?>
            <?php ?>
            <?php 
            if( !$clp_is_backend ){
                foreach( $LatestPosts as $LatestPost ):
                    $forumName = $LatestPost->forum_name;
                    $date = strtotime($LatestPost->date_posted);
                    $nickname = $LatestPost->author_nickname;
            ?>

                    <div class="cl-block-community-discussions-thread-box cl-block-latest-posts">
                    
                        <div class="cl-block-community-discussions-thread-box-avatar-container">
                            <div class="cl-block-community-discussions-thread-box-avatar"><?php echo WPF()->member->get_avatar($LatestPost->userid, "", 100); ?></div>
                        </div>
                        <div class="cl-block-community-discussions-thread-box-metadata-container">
                        <div>
                            <span class="cl-st-color" style="font-size: 12px;"> <?php echo '<a class="cl-community-disccusion-hyperlink" href="'. $base_url .'/members/'
                            . $trendingPost->userid .'" style="color: #3F9B63;">'.$nickname.'</a>  / <a class="cl-community-disccusion-hyperlink" href="'. $base_url 
                            .'/'. $trendingPost->forum_link .'" style="color: #3F9B63;">Posted in '.$forumName.'</a> / '
                            . date('M d, Y', $date);?>  </span>
                        </div>
                            <a href="<?php echo $base_url . "/community/" . $LatestPost->permalink; ?>">
                            <span class="cl-block-gwv-course-title cl-pt-color raleway-title"><?php echo  esc_attr($LatestPost->post_title); ?></span>
                                </a>
                            <span class="cl-st-color cl-community-discussions-body" style="font-size: 14px;"><?php echo  strip_tags(preg_replace("/\[attach][^*]+\[\/attach]/","",$LatestPost->post_body)); ?></span>
                        </div>
                    
                    </div>

			<?php 
                endforeach; 
            } ?>
        </div>
        <a href="<?php echo $base_url.'/community/'; ?>">
            <span class="cl-block-join-btn cl-block-cl-more-event-btn-secondary">View more conversations</span>
        </a>
    </div>
</div>