<?php

/*
 * Plugin Name: Webfronten Site Codes
 * Plugin URI: 
 * Description: Site specific code changes for websites build by Webfronten.
 * Version: 1.0.3
 * Author: Torben Heikel Vinther
 * Author URI: http://www.webfronten.dk/
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

// Disable File Edits
define('DISALLOW_FILE_EDIT', true);

// Show Site Name
function wbf_show_sitename( ) {
   return get_bloginfo( 'name' );
}
add_shortcode( 'site_name', 'wbf_show_sitename' );
