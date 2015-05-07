<?php

function rowling_jetpack_setup() {
	/**
	 * Add theme support for Infinite Scroll.
	 * See: http://jetpack.me/support/infinite-scroll/
	 */
	add_theme_support( 'infinite-scroll', array(
		'infinite-scroll', array(
			'type' => 'scroll',
			'footer_widgets' => false,
			'container' => 'content',
			'wrapper' => true,
			'render' => false,
			'footer' => 'page',
			'posts_per_page' => false,
			)
		)
	);

	/**
	 * Add theme support for Responsive Videos.
	 */
	add_theme_support( 'jetpack-responsive-videos' );

	/**
	 * Add theme support for default print styles
	 */
	add_theme_support( 'print-styles' );

	/**
	 * Add theme support for Logo upload.
	 */
	add_image_size( 'rowling-logo', 300, 80 );
	add_theme_support( 'site-logo', array( 'size' => 'rowling-logo' ) );
}
add_action( 'after_setup_theme', 'rowling_jetpack_setup' );
