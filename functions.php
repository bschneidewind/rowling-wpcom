<?php

// Theme setup
add_action( 'after_setup_theme', 'rowling_setup' );

function rowling_setup() {

	// Automatic feed
	add_theme_support( 'automatic-feed-links' );

	// Title tag
	add_theme_support( 'title-tag' );

	// Add post format support
	add_theme_support( 'post-formats', array( 'gallery' ) );

	// Set content-width
	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 816;

	// Post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 88, 88, true );

	add_image_size( 'post-image', 816, 9999 );
	add_image_size( 'post-image-thumb', 400, 200, true );

	// Add nav menus
	register_nav_menu( 'primary', __( 'Primary Menu', 'rowling' ) );
	register_nav_menu( 'secondary', __( 'Secondary Menu', 'rowling' ) );
	register_nav_menu( 'social', __( 'Social Menu', 'rowling' ) );

	// Make the theme translation ready
	load_theme_textdomain( 'rowling', get_template_directory() . '/languages' );

}

// Register and enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'rowling_load_assets' );

function rowling_load_assets() {
	// Register all styles
	wp_enqueue_style( 'rowling_fontawesome', get_template_directory_uri() . '/assets/fonts/fa/css/font-awesome.css' );
	wp_enqueue_style( 'rowling-fonts', rowling_fonts_url(), array(), null );
	wp_enqueue_style( 'rowling_style', get_stylesheet_uri() );

	// Register all scripts
	wp_enqueue_script( 'rowling_doubletap', get_template_directory_uri() . '/assets/js/doubletaptogo.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'rowling_global', get_template_directory_uri() . '/assets/js/global.js', array( 'jquery' ), '', true );

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

//Add google fonts to admin in the Appearance -> Header section
add_action( 'admin_print_styles-appearance_page_custom-header', 'rowling_admin_scripts_styles' );

function rowling_admin_scripts_styles() {
	wp_enqueue_style( 'rowling-fonts', rowling_fonts_url(), array(), null );
}

// Register and enqueue admin stylesheet
add_action( 'admin_enqueue_scripts', 'load_admin_styles' );

function load_admin_styles() {
	wp_enqueue_style( 'rowling_admin_style', get_template_directory_uri() . '/assets/css/admin-style.css' );
}

// Add editor styles
add_action( 'admin_init', 'rowling_add_editor_styles' );

function rowling_add_editor_styles() {
	add_editor_style( '/assets/css/rowling-editor-styles.css' );
}

// Add sidebar widget areas
add_action( 'widgets_init', 'rowling_sidebar_reg' ); 

function rowling_sidebar_reg() {
	register_sidebar(
		array(
			'name' => __( 'Sidebar', 'rowling' ),
			'id' => 'sidebar-1',
			'description' => __( 'Widgets in this area will be shown in the sidebar.', 'rowling' ),
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'before_widget' => '<div class="widget %2$s"><div class="widget-content clearfix">',
			'after_widget' => '</div></div>',
		)
	);
}

// Delist the default WordPress recent posts widget
add_action( 'widgets_init', 'rowling_unregister_default_widgets', 11 );

function rowling_unregister_default_widgets() {
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
}

// Add theme widgets
require_once ( get_template_directory() . '/widgets/recent-posts.php' );
require_once ( get_template_directory() . '/widgets/recent-comments.php' );

// Custom read more link text
add_filter( 'the_content_more_link', 'rowling_modify_read_more_link' );

function rowling_modify_read_more_link() {
	return '<p><a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'rowling' ) . '</a></p>';
}

// Setup WordPress.com specific items
require get_template_directory() . '/inc/wpcom.php';

// Setup Jetpack specific items
require get_template_directory() . '/inc/jetpack.php';

// Setup theme specific functions
require get_template_directory() . '/inc/template-tags.php';

// Setup theme customizer additions
require get_template_directory() . '/inc/customizer.php';
