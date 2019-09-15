<?php

/**
 * Plugin Name: Webfronten Site Codes
 * Plugin URI: https://github.com/Webfronten/Site-Codes/
 * Description: Site specific code changes for websites build by Webfronten.
 * Version: 1.2
 * Author: Webfronten
 * Author URI: https://www.webfronten.dk/
 * License: GPL v2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: webfronten-site-codes
 * Domain Path: 
 */

// Exit if accessed directly.
if( !defined( 'ABSPATH' ) ) exit;

// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');

// Display a List of Child Pages For a Parent Page
function wbf_list_child_pages() { 
	global $post; 
	if ( is_page() && $post->post_parent )
		$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
	else
		$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );
	if ( $childpages ) {
		$string = '<ul>' . $childpages . '</ul>';
	}
	return $string;
}
add_shortcode('wbf_childpages', 'wbf_list_child_pages');

// Show Site Name
function wbf_show_sitename( ) {
   return get_bloginfo( 'name' );
}
add_shortcode( 'wbf_sitename', 'wbf_show_sitename' );

// Display copyright with start and current year
function wbf_copyright() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results("
	SELECT
	YEAR(min(post_date_gmt)) AS firstdate,
	YEAR(max(post_date_gmt)) AS lastdate
	FROM
	$wpdb->posts
	WHERE
	post_status = 'publish'
	");
	$output = '';
	if($copyright_dates) {
		$copyright = "&copy; " . $copyright_dates[0]->firstdate;
		if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
			$copyright .= '-' . $copyright_dates[0]->lastdate;
		}
		$output = $copyright;
	}
	return $output;
}
add_shortcode( 'wbf_copyright', 'wbf_copyright' );
