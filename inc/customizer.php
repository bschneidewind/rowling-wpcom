<?php
// rowling customizable theme options
class Rowling_Customize {

	public static function rowling_register( $wp_customize ) {

		//1. Define a new section (if desired) to the Theme Customizer
		$wp_customize->add_section(
		array(
			'rowling_options',
				array(
					'title' => __( 'Options for Rowling', 'rowling' ), //Visible title of section
					'priority' => 35, //Determines what order this appears in
					'capability' => 'edit_theme_options', //Capability needed to tweak
					'description' => __( 'Allows you to customize theme settings for Rowling.', 'rowling' ), //Descriptive tooltip
				),
			'rowling_logo_section',
				array(
					'title'       => __( 'Logo', 'rowling' ),
					'priority'    => 40,
					'description' => __( 'Upload a logo to replace the default site title in the header.', 'rowling' ),
				),
			)
		);

		//2. Register new settings to the WP database...
		$wp_customize->add_setting(
		array(
			'accent_color', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
				array(
					'default' => '#0093C2', //Default setting/value to save
					'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
					'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
					'sanitize_callback' => 'sanitize_hex_color',
				),
			'rowling_logo',
				array(
					'sanitize_callback' => 'esc_url_raw',
				),
			)
		);

		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control(
		array(
			new WP_Customize_Color_Control(
				$wp_customize, //Pass the $wp_customize object (required)
				'rowling_accent_color', array(
					'label' => __( 'Accent Color', 'rowling' ), //Admin-visible name of the control
					'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'settings' => 'accent_color', //Which setting to load and manipulate (serialized is okay)
					'priority' => 10, //Determines the order this control appears in for the specified section
				)
			),
			new WP_Customize_Image_Control(
				$wp_customize, 'rowling_logo', array(
					'label'    => __( 'Logo', 'rowling' ),
					'section'  => 'rowling_logo_section',
					'settings' => 'rowling_logo',
					)
				),
			)
		);

		//4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	}

	public static function rowling_header_output() {
?>

	      <!-- Customizer CSS -->
	      <style type="text/css">
	           <?php self::rowling_generate_css( 'body a, body a:hover, .blog-title a:hover, .primary-menu ul li:hover > a, .search-container .search-button:hover, .post-categories, .single .post-meta a, .single-post .post-image-caption .fa, .related-post .category, .post-content a, .post-content a:hover, .page-edit-link, .post-navigation h4 a:hover, .no-comments .fa, .comments-title-container .fa, .comment-reply-title .fa, .comments .pingbacks li a:hover, .comment-header h4 a, .comments-nav a:hover, .archive-nav a:hover, .widget-content .textwidget a:hover, .widget_archive li a:hover, .widget_categories li a:hover, .widget_meta li a:hover, .widget_nav_menu li a:hover, .widget_rss .widget-content ul a.rsswidget:hover, #wp-calendar thead th, #wp-calendar tfoot a:hover, .wrapper .search-button:hover, .credits .copyright a:hover', 'color', 'accent_color' ); ?>

	           <?php self::rowling_generate_css( '.navigation .section-inner, .sticky .sticky-tag, .post-content fieldset legend, .post-content blockquote:after, .post-content input[type="submit"], .post-content input[type="button"], .post-content input[type="reset"], .post-content input[type="submit"]:hover, .post-content input[type="button"]:hover, .post-content input[type="reset"]:hover, .post-content .page-links a:hover, .post-tags a:hover, .bypostauthor .comment-author-icon, .widget .tagcloud a:hover, .footer .widget .tagcloud a:hover, .to-the-top', 'background', 'accent_color' ); ?>
	           
	           <?php self::rowling_generate_css( '.form-submit #submit, .nav-toggle', 'background-color', 'accent_color' ); ?>

	           <?php self::rowling_generate_css( '.sticky .sticky-tag:after, .post-tags a:hover:before, .widget .tagcloud a:hover:before, .footer .widget .tagcloud a:hover:before', 'border-right-color', 'accent_color' ); ?>
	           
	           <?php self::rowling_generate_css( '.sticky .sticky-tag:after', 'border-left-color', 'accent_color' ); ?>

	           <?php self::rowling_generate_css( '.single .post-meta a:hover, .post-content a:hover, .comments-title-link a:hover, .pingbacks-title, .page-title h4, .widget-title', 'border-bottom-color', 'accent_color' ); ?>
	           
	           <?php self::rowling_generate_css( '.archive-nav a:hover', 'border-top-color', 'accent_color' ); ?>
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
		$mod    = get_theme_mod( $mod_name );
		if ( ! empty( $mod ) ) {
			$return = sprintf(
				'%s { %s:%s; } ',
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
add_action( 'customize_register', array( 'Rowling_Customize', 'rowling_register' ) );

// Output custom CSS to live site
add_action( 'wp_head', array( 'Rowling_Customize', 'rowling_header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init', array( 'Rowling_Customize', 'rowling_live_preview' ) );