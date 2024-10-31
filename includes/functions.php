<?php

/**
 * Helper Functions.
 *
 * @link    https://github.com/vendasta
 * @since   0.1.0
 *
 * @package Conquer_Local_Platform
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Get default plugin settings.
 *
 * @since  0.1.0
 * @return array $defaults Array of plugin settings.
 */
function clp_get_default_settings() {
    $defaults = array(
        'clp_page_settings' => clp_insert_custom_pages(),
    );
    return $defaults;
}

/**
 * Insert required custom pages and return their IDs as array.
 * 
 * @since  0.1.0
 * @return array Array of created page IDs.
 */
function clp_insert_custom_pages() {
    if ( false == get_option( 'clp_page_settings' ) ) {
        $pages = array();
		$page_definitions = clp_get_custom_pages_list();
        foreach ( $page_definitions as $slug => $page ) {
			$page_check = get_page_by_title( $page['title'] );

			if ( ! isset( $page_check->ID ) ) {
				$id = wp_insert_post(
					array(
						'post_title'     => $page['title'],
						'post_content'   => $page['content'],
						'post_status'    => 'publish',
						'post_author'    => 1,
						'post_type'      => 'page',
						'comment_status' => 'closed'
					)
				);
					
				$pages[ $slug ] = $id;	
			} else {
				$pages[ $slug ] = $page_check->ID;	
			}		
		}

    }else{
        $pages = get_option( 'clp_page_settings' );
    }
    return $pages;
}

function clp_get_help_center_popular_searches(){
	global $wpdb;

	$query_document = "
    SELECT keyword, count(1) 
	FROM `bb_search_logs`
	group by 1
	order by 2 desc
    ";
    $query_result = $wpdb->get_results($query_document);

	//return the top 3 search keyword
	return array_map(
		function($item) { return  $item->keyword; },
		array_slice($query_result,0,3)
	);
}

/**
 * file_get_contents() was having permission issues in website-pro remote server. 
 * so we use regular curl request in php to get the xml
 * @since  0.1.0
 */
function get_xml_from_url($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $xmlstr = curl_exec($ch);
    curl_close($ch);
    return $xmlstr;
}

/**
 * Get 5 recent uploaded podcasts at Vendasta itunes podcast.
 * @see https://podcasts.apple.com/ca/podcast/conquer-local-with-george-leith/id1327121811
 * 
 * @since  0.1.0
 * @return array $fiveMostRecentItems Array of  5 recent podcasts from Vendasta podcast rss feed.
 * @see https://feeds.redcircle.com/4f451305-e5b4-4878-b293-63e3057356b8
 */
function clp_get_remote_five_recent_podcasts(){
	$xml = get_xml_from_url('https://feeds.redcircle.com/4f451305-e5b4-4878-b293-63e3057356b8');
	$doc = new DOMDocument();
	$doc->preserveWhiteSpace = false;
	$doc->loadXML( $xml );

	// Initialize XPath    
	$xpath = new DOMXpath( $doc);
	// Register the itunes namespace
	$xpath->registerNamespace( 'itunes', 'http://www.itunes.com/dtds/podcast-1.0.dtd' );

	$items = $doc->getElementsByTagName('item'); 
	$fiveMostRecentItems = array();
	for($i = 0 ; $i < 6; $i++){
		$podcastItem = array();
		$podcastItem['title'] = $xpath->query( 'title', $items[$i])->item(0)->nodeValue;
		$podcastItem['description'] = $xpath->query( 'content:encoded', $items[$i])->item(0)->nodeValue;
		$podcastItem['durationInMinutes'] = floor( intval( $xpath->query( 'itunes:duration', $items[$i])->item(0)->nodeValue ) / 60 );
		$podcastItem['guid'] = $xpath->query( 'guid', $items[$i])->item(0)->nodeValue;
		$podcastItem['featured'] = $i > 0 ? 0 : 1;

		$image = $xpath->query( 'itunes:image', $items[$i])->item(0);
		$podcastItem['thumbnail'] = $image->attributes->getNamedItem('href')->value;

		array_push($fiveMostRecentItems, $podcastItem);
	}

	return $fiveMostRecentItems;
}

/**
 * Check to see if the user on the backend
 */
function clp_is_backend(){
	return defined('REST_REQUEST') && true === REST_REQUEST && 'edit' === filter_input( INPUT_GET, 'context', FILTER_SANITIZE_STRING );
}

/**
 * Get the list of custom plugin pages.
 * 
 * @since  0.1.0
 * @return array $pages Array of pages.
 */
function clp_get_custom_pages_list() {
    $pages = array(
		'help_center_search' => array( 
			'title'   => 'Help Center Search', 
			'content' => '[clp_search]' 
		),
	);

	return apply_filters( 'clp_get_custom_pages_list', $pages );
}

function cl_search_filters() {
	Help_Center_Search::instance()->print_tabs();
}

/**
 * Output Conquer Local Search results for current subnavigation selection.
 */
function cl_search_results() {
	Help_Center_Search::instance()->print_results();
}

function get_wpforo_latest_topics(){
	global $wpdb;
  
	$q = "select t1.userid, t1.modified as date_posted, t2.display_name as author_nickname, t1.title as post_title, t4.body as post_body, t3.slug as forum_link, t3.title as forum_name, concat(t3.slug,'/',t1.slug ) as permalink
	FROM `wp_wpforo_topics` t1 
	left join wp_users t2 on t2.ID = t1.userid 
	left join wp_wpforo_forums t3 on t3.forumid = t1.forumid 
	left join wp_wpforo_posts t4 on t1.first_postid = t4.postid 
	order by t1.modified 
	desc limit 5";
  
	$results = $wpdb->get_results($q);
  
	return $results;
  }
  
  function get_wpforo_trending_topics(){
	global $wpdb;
	$q = "select w.userid as userid, w.permalink, w.date as date_posted, t3.display_name as author_nickname, p.title as post_title, p.body as post_body, t4.slug as forum_link, t4.title as forum_name
	from wp_wpforo_activity w
	right join wp_wpforo_posts p 
	on w.itemid = p.postid
	left join wp_users t3
	on w.userid = t3.ID
	left join wp_wpforo_forums t4
	on t4.forumid = p.forumid
	where w.type = 'new_reply'
	and w.id = (
	  select max(w1.id)
		from wp_wpforo_activity w1 
		  right join wp_wpforo_posts p1
		on w1.itemid = p1.postid
		where p.topicid = p1.topicid
		and w1.type = 'new_reply'
	)
	order by created desc
	limit 5";
  
	$results = $wpdb->get_results($q);
  
	return $results;
  
  }

/**
 * Get image URL using the attachment ID.
 *
 * @since  1.1.0
 * @param  int    $id      Attachment ID.
 * @param  string $size    Size of the image.
 * @param  string $default Default image URL.
 * @param  string $type    "gallery" or "player".
 * @return string $url     Image URL.
 */
function cl_get_image_url( $id, $size, $default = '', $type = 'gallery' ){
	$url = '';
	
	// Get image from attachment
	if ( $id ) {
		$attributes = wp_get_attachment_image_src( (int) $id, $size );
		if ( ! empty( $attributes ) ) {
			$url = $attributes[0];
		}
	}
	
	// Set default image
	if ( ! empty( $default ) ) {
		$default = cl_resolve_url( $default );
	} else {
		if ( 'gallery' == $type ) {
			$default = CL_PLUGIN_URL . 'public/assets/images/placeholder-image.png';
		}
	}	
	
	if ( empty( $url ) ) {
		$url = $default;
	}
	
	// Return image url
	return $url;
}

/**
 * Resolve relative file paths as absolute URLs.
 * 
 * @since  1.1.0
 * @param  string $url Input file URL.
 * @return string $url Absolute file URL.
 */
function cl_resolve_url( $url ) {
	$host = parse_url( $url, PHP_URL_HOST );

	// Is relative path?
	if ( empty( $host ) ) {
		$url = get_site_url( null, $url );
	}

	return $url;
}

/**
 * Sanitize the URLs. Accepts relative file paths, spaces.
 *
 * @since  1.1.0
 * @param  string $value Input value.
 * @return string        Sanitized value.
 */
function clp_sanitize_url( $value ) {
	$value = sanitize_text_field( urldecode( $value ) );
	return $value;	
}

/**
 * Filters the contents of the search query variable.
 *
 * @since 1.1.1
 *
 * @param bool $escaped
 */
function clp_get_search_query( $escaped = true ) {
	$query = isset( $_GET['clps'] ) ? $_GET['clps'] : '';

	if ( $escaped ) {
		$query = esc_attr( $query );
	}
	
	return $query;
}