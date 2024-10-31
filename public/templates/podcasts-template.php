<?php
/**
 * Podcasts
 *
 * @link    https://github.com/vendasta
 * @since   0.1.0
 *
 * @package Conquer_Local_Platform
 */

$podcast_page = get_home_url().'/podcasts/';
?>
<div class="cl-block-container-page-fw cl-block-container-items-center" style="background: #072337; color: #FFFFFF">
    <div class="cl-block-container-inner-container cl-podcasts-block-container" style="align-items: center; padding: 50px 0px;">
        <h2 class="cl-pt-color cl-block-title raleway-title" style="color: #FFFFFF">Learn On the Go with the Conquer Local Podcast</h2>
        <p class="cl-mobile-text">
            Listen to the top marketers, sales and business leaders for tactical advice
        </p>
        <div class="cl-block-join-cl-card-container cl-block-join-card-container-podcast-mobile cl-block-join-card-container-podcast-desk">
            <div class="cl-block-podcast-featured-card">
                <a class="cl-block-podcast-featured-left" href="<?php echo $podcast_page; ?>">
                    <img src="<?php echo $featuredPodcast['thumbnail']; ?>" width="100%" height="100%">
                </a>
                <div class="cl-block-podcast-featured-right">
                    <a href="<?php echo $podcast_page; ?>">
                        <span class="cl-block-title cl-block-podcast-featured-title raleway-title">
                            <?php echo $featuredPodcast['title']; ?>
                        </span>
                    </a>
                    <div class="cl-block-podcast-featured-metadata">
                        <span class="cl-podcast-title-mobile">Conquer Local with Jeff Tomlin</span>
                        <span class="cl-block-podcast-featured-metadata-center">
                            Entrepreneurship
                        </span>
                        <span class="cl-mobile-time"><?php echo $featuredPodcast['durationInMinutes']; ?> min</span>
                    </div>
                    <div class="cl-podcast-more-btn">
                        <span class="cl-block-podcast-featured-description"><?php echo $featuredPodcast['description']; ?></span>
                        <a href="<?php echo $podcast_page; ?>" style="color: #3F9B63; display: flex; align-self: end">
                            more
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo $podcast_page; ?>">
                            <span class="cl-block-join-btn cl-block-cl-more-event-btn-secondary">
                                Listen on Conquer Local
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="cl-block-podcast-unfeatured-card-wrapper">
                <?php foreach( $unfeaturedPodcasts as $unfeaturedPodcast ): ?>
                    <div class="cl-block-podcast-unfeatured-card">
                        <a class="cl-block-podcast-unfeatured-card-video" href="<?php echo $podcast_page; ?>">
                            <img src="<?php echo  $unfeaturedPodcast['thumbnail']; ?>" width="100%" height="100%">
                        </a>
                        <a class="cl-block-title cl-block-podcast-unfeatured-card-title raleway-title" href="<?php echo $podcast_page; ?>">
                            <?php echo $unfeaturedPodcast['title']; ?>
                        </a>
                        <span class="cl-block-podcast-unfeatured-card-duration">
                            <?php echo $unfeaturedPodcast['durationInMinutes']; ?> min
                        </span>
                    </div>
			    <?php endforeach; ?>
            </div>
        </div>
        <a href="<?php echo $podcast_page; ?>">
            <span class="cl-block-join-btn cl-block-cl-more-podcasts-btn">View all podcasts →</span>
        </a> 
        
    </div>
</div>