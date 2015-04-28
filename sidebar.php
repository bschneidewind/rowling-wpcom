<?php
/**
 * The partial used for displaying the sidebar when called
 *
 * @package Rowling
 */
?>

<div class="sidebar">
<?php
if ( is_active_sidebar( 'sidebar' ) ) {
	dynamic_sidebar( 'sidebar' );
} else {

	// Fallback if the sideabr widget area is empty
	echo '<div class="widgets">';

	// Search widget
	if ( ! is_404() ) { // hides the search widget on 404 pages (search is present in content area)
		the_widget(
		'WP_Widget_Search',
			array(
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
				'before_widget' => '<div class="widget widget_search"><div class="widget-content clearfix">',
				'after_widget' => '</div></div>',
			)
		);
	}

	// Recent posts widget
	the_widget(
	'rowling_recent_posts',
		array(
			'number_of_posts'  => '5',
			'widget_title'  => __( 'Recent Posts', 'rowling' ),
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'before_widget' => '<div class="widget widget_rowling_recent_posts"><div class="widget-content clearfix">',
			'after_widget' => '</div></div>',
		)
	);

	// Categories widget
	the_widget(
	'WP_Widget_Categories',
		array(
			'count'   => '1',
			'hierarchical' => '1',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'before_widget' => '<div class="widget widget_categories"><div class="widget-content clearfix">',
			'after_widget' => '</div></div>',
		)
	);

	// Archives Widget
	the_widget(
	'WP_Widget_Archives',
		array(
			'count'   => '1',
			'hierarchical' => '1',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'before_widget' => '<div class="widget widget_archive"><div class="widget-content clearfix">',
			'after_widget' => '</div></div>',
		)
	);

	echo '</div>';
}
?>
</div>