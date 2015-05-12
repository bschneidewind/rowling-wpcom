<?php
/**
 * The partial used for displaying the sidebar when called
 *
 * @package Rowling
 */
if ( ! is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div class="sidebar">
		<?php the_widget( 'WP_Widget_Search' ); ?>
		<?php the_widget( 'WP_Widget_Categories' ); ?>
		<?php the_widget( 'WP_Widget_Recent_Comments' ); ?>
	</div>
<?php endif; ?>

<div class="sidebar" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->