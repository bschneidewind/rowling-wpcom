<?php
/**
 * The template used for displaying page the 404 error page
 *
 * @package Rowling
 */
 
 get_header(); ?>

	<div class="wrapper section-inner">
	
		<div class="content">
	
			<div class="post single single-post">
	
				<p class="post-categories"><?php esc_html_e( 'Error 404','rowling' ); ?></p>
	
				<div class="post-header">
	
				    <h2 class="post-title"><?php esc_html_e( 'These are Not the Results You\'re Looking For','rowling' ); ?></h2>
	
				</div> <!-- /post-header -->
	
				<div class="post-inner">
	
					<div class="post-content">
	
						<p><?php esc_html_e( 'It seems like you have tried to open a page that doesn\'t exist. It could have been deleted, moved, or it never existed at all. Either way, you\'re welcome to search for what you are looking for with the form below.', 'rowling' ); ?></p>
	
						<p><?php printf( __( 'You can also return to the %s home page %s and continue your search from there.','rowling' ), '<a href="' . get_home_url() .  '">', '</a>' ); ?></p>
	
						<p><?php get_search_form(); ?></p>
	
					</div> <!-- /post-content -->
	
				</div> <!-- /post-inner -->
	
			</div> <!-- /post -->
	
		</div> <!-- /content -->
	
		<?php get_sidebar(); ?>
	
		<div class="clear"></div>
	
	</div> <!-- /wrapper.section-inner -->

<?php get_footer();