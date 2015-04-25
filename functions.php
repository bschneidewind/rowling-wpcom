<?php

// Theme setup
add_action( 'after_setup_theme', 'rowling_setup' );

function rowling_setup() {

	// Automatic feed
	add_theme_support( 'automatic-feed-links' );

	// Title tag
	add_theme_support( 'title-tag' );

	// Title tag backwards compatibility
	if ( ! function_exists( '_wp_render_title_tag' ) ) {
		function rowling_theme_slug_render_title() { ?>
			<title><?php wp_title('|', true, 'right'); ?></title>
		<?php 
		}
		add_action( 'wp_head', 'rowling_theme_slug_render_title' );
	}

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

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
	  require_once( $locale_file );
}


// Register and enqueue Javascript files
add_action( 'wp_enqueue_scripts', 'rowling_load_javascript_files' );

function rowling_load_javascript_files() {
	if ( !is_admin() ) {	
		wp_enqueue_script( 'rowling_flexslider', get_template_directory_uri().'/js/flexslider.js', array('jquery'), '', true );	
		wp_enqueue_script( 'rowling_doubletap', get_template_directory_uri().'/js/doubletaptogo.js', array('jquery'), '', true );
		wp_enqueue_script( 'rowling_global', get_template_directory_uri().'/js/global.js', array('jquery'), '', true );
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	}
}


// Register and enqueue styles
add_action('wp_print_styles', 'rowling_load_style');

function rowling_load_style() {
	if ( !is_admin() ) {
	    wp_enqueue_style( 'rowling_googleFonts', '//fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic|Merriweather:700,900,400italic' );
	    wp_enqueue_style( 'rowling_fontawesome', get_template_directory_uri() . '/fa/css/font-awesome.css' );
	    wp_enqueue_style( 'rowling_style', get_stylesheet_uri() );
	}
}


// Add editor styles
add_action( 'init', 'rowling_add_editor_styles' );

function rowling_add_editor_styles() {
    add_editor_style( 'rowling-editor-styles.css' );
    $font_url = '//fonts.googleapis.com/css?family=Lato:400,700,900|Playfair+Display:400,700,400italic';
    add_editor_style( str_replace( ',', '%2C', $font_url ) );
}


// Add footer widget areas
add_action( 'widgets_init', 'rowling_sidebar_reg' ); 

function rowling_sidebar_reg() {
	register_sidebar(array(
	  'name' => __( 'Sidebar', 'rowling' ),
	  'id' => 'sidebar',
	  'description' => __( 'Widgets in this area will be shown in the sidebar.', 'rowling' ),
	  'before_title' => '<h3 class="widget-title">',
	  'after_title' => '</h3>',
	  'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
	  'after_widget' => '</div><div class="clear"></div></div>'
	));
}



// Add theme widgets
require_once (get_template_directory() . '/widgets/recent-posts.php');

// Delist the default WordPress widgets replaced by custom theme widgets
add_action('widgets_init', 'rowling_unregister_default_widgets', 11);
 
function rowling_unregister_default_widgets() {
	unregister_widget('WP_Widget_Recent_Posts');
}


// Check whether the browser supports JavaScript
add_action( 'wp_head', 'rowling_html_js_class', 1 );

function rowling_html_js_class () {
    echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
}


// Related posts function
function rowling_related_posts($number_of_posts) { ?>
	
	<div class="related-posts">
		
		<p class="related-posts-title"><?php esc_html_e('Read Next','rowling'); ?> &rarr;</p>
		
		<div class="row">
						
			<?php // Check for posts in the same category
					
				global $post;
				$cat_ID = array();
				$categories = get_the_category();
				foreach($categories as $category) {
					array_push($cat_ID,$category->cat_ID);
				}
				
				$related_posts = new WP_Query( apply_filters(
				'rowling_related_posts_args', array(
				        'posts_per_page'		=>	$number_of_posts,
				        'post_status'			=>	'publish',
				        'category__in'			=>	$cat_ID,
				        'post__not_in'			=>	array($post->ID),
				        'meta_key'				=>	'_thumbnail_id',
				        'ignore_sticky_posts'	=>	true
				) ) );
				
				if ($related_posts->have_posts()) :
					
					while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
					
					<?php global $post; ?>
				
					<a class="related-post" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						
						<?php if ( has_post_thumbnail() ) : ?>
							
							<?php the_post_thumbnail('post-image-thumb') ?>
							
						<?php endif; ?>
							<p class="category">
							<?php
								$category = get_the_category();
								if ( isset( $category[0]->cat_name ) ):
									esc_attr( $category[0]->cat_name );
								endif;
							?>
							</p>
				
						<h3 class="title"><?php the_title(); ?></h3>
							
					</a>
				
				<?php endwhile; ?>
					
			<?php else: // If there are no other posts in the post categories, get random posts ?>
			
				<?php
						
					$related_posts = new WP_Query( apply_filters(
					'rowling_related_posts_args', array(
					        'posts_per_page'		=>	$number_of_posts,
					        'post_status'			=>	'publish',
					        'orderby'				=>	'rand',
					        'post__not_in'			=>	array($post->ID),
							'meta_key'				=>	'_thumbnail_id',
					        'ignore_sticky_posts'	=>	true
					) ) );
					
					if ($related_posts->have_posts()) :
						
						while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
						
						<?php global $post; ?>
					
						<a class="related-post" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							
							<?php if ( has_post_thumbnail() ) : ?>
								
								<?php the_post_thumbnail('post-image-thumb') ?>
								
							<?php endif; ?>
							
							<p class="category">
								<?php
									$category = get_the_category();
									if ( isset( $category[0]->cat_name ) ):
										esc_attr( $category[0]->cat_name );
									endif;
								?>
							</p>
					
							<h3 class="title"><?php the_title(); ?></h3>
								
						</a>
					
					<?php endwhile; ?>
					
				<?php endif; ?>
		
			<?php endif; ?>
		
		</div> <!-- /row -->
		
		<?php wp_reset_query(); ?>

	</div> <!-- /related-posts -->
	
	<?php
}



// Archive navigation function
function rowling_archive_navigation() {
	
	global $wp_query;
	
	if ( $wp_query->max_num_pages > 1 ) : ?>
				
		<div class="archive-nav">
				
			<?php 
				if ( get_previous_posts_link() ) echo '<li class="archive-nav-newer">' . get_previous_posts_link( '&larr; ' . __('Previous', 'rowling')) . '</li>';
				$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
				$max   = intval( $wp_query->max_num_pages );
			
				/**	Add current page to the array */
				if ( $paged >= 1 )
					$links[] = $paged;
			
				/**	Add the pages around the current page to the array */
				if ( $paged >= 3 ) {
					$links[] = $paged - 1;
					$links[] = $paged - 2;
				}
			
				if ( ( $paged + 2 ) <= $max ) {
					$links[] = $paged + 2;
					$links[] = $paged + 1;
				}
			
				/**	Link to first page, plus ellipses if necessary */
				if ( ! in_array( 1, $links ) ) {
					$class = 1 == $paged ? ' active' : '';
			
					printf( '<li class="number%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
			
					if ( ! in_array( 2, $links ) )
						echo '<li>...</li>';
				}
			
				/**	Link to current page, plus 2 pages in either direction if necessary */
				sort( $links );
				foreach ( (array) $links as $link ) {
					$class = $paged == $link ? ' active' : '';
					printf( '<li class="number%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
				}
			
				/**	Link to last page, plus ellipses if necessary */
				if ( ! in_array( $max, $links ) ) {
					if ( ! in_array( $max - 1, $links ) )
						echo '<li class="number">...</li>' . "\n";
			
					$class = $paged == $max ? ' active' : '';
					printf( '<li class="number%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
				}
							
				if ( get_next_posts_link() ) echo '<li class="archive-nav-older">' . get_next_posts_link( __('Next', 'rowling') . ' &rarr;') . '</li>'; 
			?>
			
			<div class="clear"></div>
						
		</div> <!-- /archive-nav -->
						
	<?php endif;
}


// Custom read more link text
add_filter( 'the_content_more_link', 'rowling_modify_read_more_link' );

function rowling_modify_read_more_link() {
	return '<p><a class="more-link" href="' . get_permalink() . '">' . __('Read More','rowling') . '</a></p>';
}


// Add body class if is_single and has_featured_image
add_filter('body_class','rowling_is_single_featured_image');
 
function rowling_is_single_featured_image( $classes ){
 
    if ( is_single() && has_post_thumbnail() ){
        $classes[] = 'has-featured-image';
    }
    
    return $classes;
}


// Get comment excerpt length
function rowling_get_comment_excerpt($comment_ID = 0, $num_words = 20) {
	$comment = get_comment( $comment_ID );
	$comment_text = strip_tags($comment->comment_content);
	$blah = explode(' ', $comment_text);
	if (count($blah) > $num_words) {
		$k = $num_words;
		$use_dotdotdot = 1;
	} else {
		$k = count($blah);
		$use_dotdotdot = 0;
	}
	$excerpt = '';
	for ($i=0; $i<$k; $i++) {
		$excerpt .= $blah[$i] . ' ';
	}
	$excerpt .= ($use_dotdotdot) ? '...' : '';
	return apply_filters('get_comment_excerpt', $excerpt);
}


// Style the admin area
add_action('admin_head', 'rowling_admin_area_style');

function rowling_admin_area_style() { 
   echo '
   <style type="text/css">
	
		#postimagediv #set-post-thumbnail img {
			max-width: 100%;
			height: auto;
		}
	
	</style>';
}


// Flexslider function for format-gallery
function rowling_flexslider($size) {

	if ( is_page()) :
		$attachment_parent = $post->ID;
	else : 
		$attachment_parent = get_the_ID();
	endif;

	if($images = get_posts(array(
		'post_parent'    => $attachment_parent,
		'post_type'      => 'attachment',
		'numberposts'    => -1, // show all
		'post_status'    => null,
		'post_mime_type' => 'image',
                'orderby'        => 'menu_order',
                'order'           => 'ASC',
	))) { ?>
	
		<?php if ( !is_single() ) : // Make it a link if it's an archive ?>
	
			<a class="flexslider" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				
		<?php else : // ...and just a div if it's a single post ?>
		
			<div class="flexslider">
				
		<?php endif; ?>
		
			<ul class="slides">
	
				<?php foreach($images as $image) { 
					$attimg = wp_get_attachment_image($image->ID,$size); ?>
					
					<li>
						<?php echo esc_url( $attimg ); ?>
						<?php if ( !empty($image->post_excerpt) && is_single()) : ?>
							
							<?php printf( '<p class="post-image-caption"><span class="fa fw fa-camera"></span>%s</p>', esc_html( $image->post_excerpt ) ); ?>
													
						<?php endif; ?>
					</li>
					
				<?php }; ?>
		
			</ul>
			
		<?php 
			if ( !is_single() )
				echo '</a>';
			else
				echo '</div>';
				
	}
}


// Rowling comment function
if ( ! function_exists( 'rowling_comment' ) ) :

function rowling_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	
		<?php __( 'Pingback:', 'rowling' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'rowling' ), '<span class="edit-link">', '</span>' ); ?>
		
	</li>
	<?php
			break;
		default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	
		<div id="comment-<?php comment_ID(); ?>" class="comment">
			
			<?php echo get_avatar( $comment, 160 ); ?>
			
			<?php if ( $comment->user_id === $post->post_author ) : ?>
					
				<a class="comment-author-icon" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" title="<?php esc_html_e('Comment by post author','rowling'); ?>"><div class="fa fw fa-user"></div></a>
			
			<?php endif; ?>
			
			<div class="comment-inner">
			
				<div class="comment-header">
											
					<h4><?php echo get_comment_author_link(); ?></h4>
				
				</div> <!-- /comment-header -->
				
				<div class="comment-content post-content">
			
					<?php comment_text(); ?>
					
				</div><!-- /comment-content -->
				
				<div class="comment-meta">
					
					<div class="fleft">
						<div class="fa fw fa-clock-o"></div><a class="comment-date-link" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" title="<?php echo get_comment_date() . ' at ' . get_comment_time(); ?>"><?php echo get_comment_date(get_option('date_format')); ?></a>
						<?php edit_comment_link( __( 'Edit', 'rowling' ), '<div class="fa fw fa-wrench"></div>', '' ); ?>
					</div>
					
					<?php if ( '0' == $comment->comment_approved ) : ?>
				
						<div class="comment-awaiting-moderation fright">
							<div class="fa fw fa-exclamation-circle"></div><?php esc_html_e( 'Awaiting moderation', 'rowling' ); ?>
						</div>
						
					<?php else : ?>
						
						<?php 
							comment_reply_link( array( 
								'reply_text' 	=>  	__('Reply','rowling'),
								'depth'			=> 		$depth, 
								'max_depth' 	=> 		$args['max_depth'],
								'before'		=>		'<div class="fright"><div class="fa fw fa-reply"></div>',
								'after'			=>		'</div>'
								) 
							); 
						?>
					
					<?php endif; ?>
					
					<div class="clear"></div>
					
				</div> <!-- /comment-meta -->
								
			</div> <!-- /comment-inner -->
										
		</div><!-- /comment-## -->
				
	<?php
		break;
	endswitch;
}
endif;


// rowling theme options
class Rowling_Customize {

   public static function rowling_register ( $wp_customize ) {
   
      //1. Define a new section (if desired) to the Theme Customizer
      $wp_customize->add_section( 'rowling_options', 
         array(
            'title' => __( 'Options for Rowling', 'rowling' ), //Visible title of section
            'priority' => 35, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to customize theme settings for Rowling.', 'rowling'), //Descriptive tooltip
         ) 
      );
      
      $wp_customize->add_section( 'rowling_logo_section' , array(
		    'title'       => __( 'Logo', 'rowling' ),
		    'priority'    => 40,
		    'description' => __('Upload a logo to replace the default site title in the header.', 'rowling'),
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
	           <?php self::rowling_generate_css('body a', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('body a:hover', 'color', 'accent_color'); ?>

	           <?php self::rowling_generate_css('.blog-title a:hover', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.navigation .section-inner', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.primary-menu ul li:hover > a', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.search-container .search-button:hover', 'color', 'accent_color'); ?>
	           
	           <?php self::rowling_generate_css('.sticky .sticky-tag', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.sticky .sticky-tag:after', 'border-right-color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.sticky .sticky-tag:after', 'border-left-color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-categories', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.single .post-meta a', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.single .post-meta a:hover', 'border-bottom-color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.single-post .post-image-caption .fa', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.related-post .category', 'color', 'accent_color'); ?>
	           
	           <?php self::rowling_generate_css('.post-content a', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-content a:hover', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-content a:hover', 'border-bottom-color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-content blockquote:after', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-content fieldset legend', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-content input[type="submit"]', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-content input[type="button"]', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-content input[type="reset"]', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-content input[type="submit"]:hover', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-content input[type="button"]:hover', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-content input[type="reset"]:hover', 'background', 'accent_color'); ?>
	           
	           <?php self::rowling_generate_css('.page-edit-link', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-content .page-links a:hover', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-tags a:hover', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-tags a:hover:before', 'border-right-color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.post-navigation h4 a:hover', 'color', 'accent_color'); ?>
	           
	           <?php self::rowling_generate_css('.no-comments .fa', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.comments-title-container .fa', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.comment-reply-title .fa', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.comments-title-link a', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.comments-title-link a:hover', 'border-bottom-color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.comments .pingbacks li a:hover', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.comment-header h4 a', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.bypostauthor .comment-author-icon', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.form-submit #submit', 'background-color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.comments-nav a:hover', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.pingbacks-title', 'border-bottom-color', 'accent_color'); ?>

	           <?php self::rowling_generate_css('.page-title h4', 'border-bottom-color', 'accent_color'); ?>	           
	           <?php self::rowling_generate_css('.archive-nav a:hover', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.archive-nav a:hover', 'border-top-color', 'accent_color'); ?>
				
			   <?php self::rowling_generate_css('.widget-title', 'border-bottom-color', 'accent_color'); ?>	           
	           <?php self::rowling_generate_css('.widget-content .textwidget a:hover', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.widget_archive li a:hover', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.widget_categories li a:hover', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.widget_meta li a:hover', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.widget_nav_menu li a:hover', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.widget_rss .widget-content ul a.rsswidget:hover', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('#wp-calendar thead th', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('#wp-calendar tfoot a:hover', 'color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.widget .tagcloud a:hover', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.widget .tagcloud a:hover:before', 'border-right-color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.footer .widget .tagcloud a:hover', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.footer .widget .tagcloud a:hover:before', 'border-right-color', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.wrapper .search-button:hover', 'color', 'accent_color'); ?>
	           
	           <?php self::rowling_generate_css('.to-the-top', 'background', 'accent_color'); ?>
	           <?php self::rowling_generate_css('.credits .copyright a:hover', 'color', 'accent_color'); ?>

	           <?php self::rowling_generate_css('.nav-toggle', 'background-color', 'accent_color'); ?>
				
				
	      </style> 
	      
	      <!--/Customizer CSS-->
	      
      <?php
   }
   
   public static function rowling_live_preview() {
      wp_enqueue_script( 
           'rowling-themecustomizer', // Give the script a unique ID
           get_template_directory_uri() . '/js/theme-customizer.js', // Define the path to the JS file
           array(  'jquery', 'customize-preview' ), // Define dependencies
           '', // Define a version (optional) 
           true // Specify whether to put in footer (leave this true)
      );
   }

   public static function rowling_generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( ! empty( $mod ) ) {
         $return = sprintf('%s { %s:%s; }',
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
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'Rowling_Customize' , 'rowling_register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'Rowling_Customize' , 'rowling_header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'Rowling_Customize' , 'rowling_live_preview' ) );

/**
* Load WordPress.com items
*/
require get_template_directory() . '/inc/wpcom.php';

/**
* Load Jetpack items
*/
require get_template_directory() . '/inc/jetpack.php';