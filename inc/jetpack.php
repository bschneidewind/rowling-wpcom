<?php

add_theme_support( 'infinite-scroll', array(
	'type' => 'scroll',
	'footer_widgets' => false,
	'container' => 'content',
	'wrapper' => true,
	'render' => false,
	'footer' => 'page',
	'posts_per_page' => false,
	)
);
add_theme_support( 'jetpack-responsive-videos' );
add_theme_support( 'print-styles' );
add_theme_support( 'site-logo' );