<?php
/**
 * The partial used for displaying the sidebar when called
 *
 * @package Rowling
 */
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div class="sidebar" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->