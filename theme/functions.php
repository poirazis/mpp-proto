<?php


/**
 * Proto Campaing Child Theme
 * @version 1.0.0
 */

include_once( get_stylesheet_directory() . '/templates/template-tags.php' );
include_once( get_stylesheet_directory() . '/helpers/helpers.php' );

/**
 * Enqueue Styles
 */

function proto_child_enqueue_styles() {
	wp_enqueue_style( 'child-theme', get_stylesheet_directory_uri() . '/style.css', array(), 100 );
}

add_action( 'wp_enqueue_scripts', 'proto_child_enqueue_styles' );

function proto_child_enqueue_gutenberg_styles() {
	wp_enqueue_style( 'child-theme', get_theme_file_uri( '/editor-style.css' ), false, '1.0', 'all' );
}

add_action( 'enqueue_block_editor_assets', 'proto_child_enqueue_gutenberg_styles' );

/**
 * Show only policy_proposal items on Policy Sector Archives
 */

 function pc_filter_archive_post_types ( $query ) {

	   // Make sure this only fires when we want it too
	   if ( !is_admin() && $query->is_main_query() && $query->is_tax('polsector')) {
		   $query->set('post_type', 'policy_proposal');

	   }

 }  

 add_action ('pre_get_posts', 'pc_filter_archive_post_types');