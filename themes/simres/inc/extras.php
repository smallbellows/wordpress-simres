<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package simres
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function simres_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'simres_body_classes' );

/**
 * Displays the SeaTalks cpt archive in ascending order, and to show all the seatalks for the current year
 *
 */
 function simres_change_seatalk_query( $query ) {

	 $today = getdate();

	 if ( is_post_type_archive('seatalk')  && !is_admin() && $query->is_main_query() ) {
		$query->set( 'order', 'ASC' );
		$query->set( 'posts_per_page', -1 );
		$query->set('year', $today['year']);
	}
 }

add_action( 'pre_get_posts', 'simres_change_seatalk_query' );


/**
 * Display Director posts in ascending order
 *
 */

 function simres_director_query( $query ) {

		 if ( is_post_type_archive('directors')  && !is_admin() && $query->is_main_query() ) {
			 $query->set( 'order', 'ASC' );
		 }

 }

 add_action( 'pre_get_posts', 'simres_director_query' );

/**
 * Change the title displayed on archive pages
 *
 */

 function simres_filter_archive_titles() {

	 if( is_post_type_archive( 'seatalk') ) {
		 return 'seaTalk Schedule';
	 }
 }

 add_filter( 'get_the_archive_title', 'simres_filter_archive_titles');

 function simres_seatalk_highlight_css() {

	 if ( !is_singular('seatalk') ) {
		 return;
	 }

	 $highlight_color = CFS()->get('highlight_color');

	 $custom_css = ".featured { color: $highlight_color; }";

	 wp_add_inline_style( 'simres-style', $custom_css );
 }

 add_action( 'wp_enqueue_scripts', 'simres_seatalk_highlight_css' );
