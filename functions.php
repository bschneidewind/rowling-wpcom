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
	set_post_thumbnail_size ( 88, 88, true );

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
	wp_register_style( 'rowling_fontawesome', get_template_directory_uri() . '/assets/fonts/fa/css/font-awesome.css' );
	wp_register_style( 'rowling_google_lato', '//fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic|Merriweather:700,900,400italic' );
	wp_register_style( 'rowling_style', get_stylesheet_uri() );
	
	// Register all scripts
	wp_register_script( 'rowling_doubletap', get_template_directory_uri() . '/assets/js/doubletaptogo.js', array( 'jquery' ), '', true );
	wp_register_script( 'rowling_flexslider', get_template_directory_uri() . '/assets/js/flexslider.js', array( 'jquery' ), '', true );	
	wp_register_script( 'rowling_global', get_template_directory_uri() . '/assets/js/global.js', array( 'jquery' ), '', true );
	
	wp_enqueue_script( 'rowling_doubletap' );
	wp_enqueue_script( 'rowling_flexslider' );	
	wp_enqueue_script( 'rowling_global' );
	
	wp_enqueue_style( 'rowling_fontawesome' );
	wp_enqueue_style( 'rowling_google_lato' );
    wp_enqueue_style( 'rowling_style' );

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

// Register and enqueue admin stylesheet
add_action( 'admin_enqueue_scripts', 'load_admin_styles' );

function load_admin_styles() {
	wp_register_style( 'rowling_admin_style', get_template_directory_uri() . '/assets/css/admin-style.css' );
	wp_enqueue_style( 'rowling_admin_style' );
}

// Add editor styles
add_action( 'admin_init', 'rowling_add_editor_styles' );

function rowling_add_editor_styles() {
    $font_url = '//fonts.googleapis.com/css?family=Lato:400,700,900|Playfair+Display:400,700,400italic';
    add_editor_style( str_replace( ',', '%2C', $font_url ) );
    add_editor_style( '/assets/css/rowling-editor-styles.css' );
}

// Add sidebar widget areas
add_action( 'widgets_init', 'rowling_sidebar_reg' ); 

function rowling_sidebar_reg() {
	register_sidebar( array(
	  'name' => __( 'Sidebar', 'rowling' ),
	  'id' => 'sidebar',
	  'description' => __( 'Widgets in this area will be shown in the sidebar.', 'rowling' ),
	  'before_title' => '<h3 class="widget-title">',
	  'after_title' => '</h3>',
	  'before_widget' => '<div class="widget %2$s"><div class="widget-content clearfix">',
	  'after_widget' => '</div></div>'
	));
}

// Delist the default WordPress recent posts widget
add_action( 'widgets_init', 'rowling_unregister_default_widgets', 11 );
 
function rowling_unregister_default_widgets() {
	unregister_widget('WP_Widget_Recent_Posts');
}

// Add theme widgets
require_once ( get_template_directory() . '/widgets/recent-posts.php' );

// Custom read more link text
add_filter( 'the_content_more_link', 'rowling_modify_read_more_link' );

function rowling_modify_read_more_link() {
	return '<p><a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'rowling' ) . '</a></p>';
}

// rowling customizable theme options
class Rowling_Customize {

   public static function rowling_register ( $wp_customize ) {

      //1. Define a new section (if desired) to the Theme Customizer
      $wp_customize->add_section( 'rowling_options', 
         array(
            'title' => __( 'Options for Rowling', 'rowling' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __( 'Allows you to customize theme settings for Rowling.', 'rowling' ), //Descriptive tooltip
         ) 
      );

      $wp_customize->add_section( 'rowling_logo_section' , array(
		    'title'       => __( 'Logo', 'rowling' ),
		    'priority'    => 40,
		    'description' => __( 'Upload a logo to replace the default site title in the header.', 'rowling' ),
	  ) );

      //2. Register new settings to the WP database...
      $wp_customize->add_setting( 'accent_color', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
         array(
            'default' => '#0093C2', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
      		'sanitize_callback' => 'sanitize_hex_color'
         ) 
      );

	  $wp_customize->add_setting( 'rowling_logo', 
      	array( 
      		'sanitize_callback' => 'esc_url_raw'
      	) 
      );

      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'rowling_accent_color', //Set a unique ID for the control
         array(
            'label' => __( 'Accent Color', 'rowling' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'accent_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 10, //Determines the order this control appears in for the specified section
         ) 
      ) );

      $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'rowling_logo', array(
		    'label'    => __( 'Logo', 'rowling' ),
		    'section'  => 'rowling_logo_section',
		    'settings' => 'rowling_logo',
	  ) ) );

      //4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
      $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
      $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
   }

   public static function rowling_header_output() {
      ?>

	      <!-- Customizer CSS --> 
	      <style type="text/css">
	           <?php self::rowling_generate_css( 'body a', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( 'body a:hover', 'color', 'accent_color' ); ?>

	           <?php self::rowling_generate_css( '.blog-title a:hover', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.navigation .section-inner', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.primary-menu ul li:hover > a', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.search-container .search-button:hover', 'color', 'accent_color' ); ?>
	           
	           <?php self::rowling_generate_css( '.sticky .sticky-tag', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.sticky .sticky-tag:after', 'border-right-color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.sticky .sticky-tag:after', 'border-left-color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-categories', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.single .post-meta a', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.single .post-meta a:hover', 'border-bottom-color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.single-post .post-image-caption .fa', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.related-post .category', 'color', 'accent_color' ); ?>
	           
	           <?php self::rowling_generate_css( '.post-content a', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-content a:hover', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-content a:hover', 'border-bottom-color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-content blockquote:after', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-content fieldset legend', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-content input[type="submit"]', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-content input[type="button"]', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-content input[type="reset"]', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-content input[type="submit"]:hover', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-content input[type="button"]:hover', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-content input[type="reset"]:hover', 'background', 'accent_color' ); ?>
	           
	           <?php self::rowling_generate_css( '.page-edit-link', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-content .page-links a:hover', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-tags a:hover', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-tags a:hover:before', 'border-right-color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.post-navigation h4 a:hover', 'color', 'accent_color' ); ?>
	           
	           <?php self::rowling_generate_css( '.no-comments .fa', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.comments-title-container .fa', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.comment-reply-title .fa', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.comments-title-link a', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.comments-title-link a:hover', 'border-bottom-color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.comments .pingbacks li a:hover', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.comment-header h4 a', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.bypostauthor .comment-author-icon', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.form-submit #submit', 'background-color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.comments-nav a:hover', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.pingbacks-title', 'border-bottom-color', 'accent_color' ); ?>

	           <?php self::rowling_generate_css( '.page-title h4', 'border-bottom-color', 'accent_color' ); ?>	           
	           <?php self::rowling_generate_css( '.archive-nav a:hover', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.archive-nav a:hover', 'border-top-color', 'accent_color' ); ?>
				
			   <?php self::rowling_generate_css( '.widget-title', 'border-bottom-color', 'accent_color' ); ?>	           
	           <?php self::rowling_generate_css( '.widget-content .textwidget a:hover', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.widget_archive li a:hover', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.widget_categories li a:hover', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.widget_meta li a:hover', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.widget_nav_menu li a:hover', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.widget_rss .widget-content ul a.rsswidget:hover', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '#wp-calendar thead th', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '#wp-calendar tfoot a:hover', 'color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.widget .tagcloud a:hover', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.widget .tagcloud a:hover:before', 'border-right-color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.footer .widget .tagcloud a:hover', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.footer .widget .tagcloud a:hover:before', 'border-right-color', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.wrapper .search-button:hover', 'color', 'accent_color' ); ?>
	           
	           <?php self::rowling_generate_css( '.to-the-top', 'background', 'accent_color' ); ?>
	           <?php self::rowling_generate_css( '.credits .copyright a:hover', 'color', 'accent_color' ); ?>

	           <?php self::rowling_generate_css( '.nav-toggle', 'background-color', 'accent_color' ); ?>
	      </style> 
	      <!--/Customizer CSS-->
      <?php
   } // end of public static function rowling_header_output

   public static function rowling_live_preview() {
      wp_enqueue_script( 
           'rowling-themecustomizer', // Give the script a unique ID
           get_template_directory_uri() . 'assets/js/theme-customizer.js', // Define the path to the JS file
           array(  'jquery', 'customize-preview' ), // Define dependencies
           '', // Define a version (optional) 
           true // Specify whether to put in footer (leave this true)
      );
   } // end of public static function rowling_live_preview

   public static function rowling_generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {
      $return = '';
      $mod = get_theme_mod( $mod_name );
      if ( ! empty( $mod ) ) {
         $return = sprintf( '%s { %s:%s; } ',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            esc_html( $return );
         }
      }
      return $return;
    }
} // end of public static function rowling_generate_css

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'Rowling_Customize' , 'rowling_register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'Rowling_Customize' , 'rowling_header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'Rowling_Customize' , 'rowling_live_preview' ) );

// Setup WordPress.com specific items
require get_template_directory() . '/inc/wpcom.php';

// Setup Jetpack specific items
require get_template_directory() . '/inc/jetpack.php';

// Setup theme specific functions
require get_template_directory() . '/inc/template-tags.php';