<?php

function pnp_setup() {
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	if ( ! isset( $content_width ) ) {
		$content_width = 640; /* pixels */
	}

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Casper, use a find and replace
	 * to change 'casper' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'casper', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'casper' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );


	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'casper_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
	) );

	function new_excerpt_more( $more ) {
		if ( false != get_theme_mod( 'casper_read_more_link')) {
			return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . get_theme_mod( 'casper_read_more_link') . '</a>';
		} else {
			return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __( '&hellip;&nbsp;<span class="meta-nav">&rarr;</span>', 'casper' ) . '</a>';
		}
	}
	add_filter( 'excerpt_more', 'new_excerpt_more' );

	// Enable automatic theme updates
	add_filter( 'auto_update_theme', '__return_true' );
}

add_action( 'after_setup_theme', 'pnp_setup' );
