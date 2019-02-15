<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Casper
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function wb_render() {
	while( have_posts() ) {
		the_post();
		get_template_part( 'content', get_post_format() );
	}
}
function casper_jetpack_setup() {
	add_theme_support('infinite-scroll', array(
		type => 'scroll', // click
		'container' => 'main',
		'footer'    => 'page',
		footer_widgets => false, // sidebar id
		wrapper => true, // 添加 wrapper
		render => false, // 'wb_render'
		posts_per_page => false // 使用默认值
	));
}
add_action( 'after_setup_theme', 'casper_jetpack_setup' );


// // infinite_scroll_has_footer_widgets filter
// function wb_infinite_scroll_has_footer_widgets() {
// 	return true;
// }

// add_filter( 'infinite_scroll_has_footer_widgets', 'wb_infinite_scroll_has_footer_widgets' );

// /**
//  * Sort all Infinite Scroll results alphabetically by post name
//  *
//  * @param array $args
//  * @filter infinite_scroll_query_args
//  * @return array
//  */
// function jetpack_infinite_scroll_query_args( $args ) {
//     $args['order']   = 'ASC';
//     $args['orderby'] = 'name';

//     return $args;
// }
// add_filter( 'infinite_scroll_query_args', 'jetpack_infinite_scroll_query_args' );
