<?php
/**
 * The search results page template
 *
 * @package Rowling
 */
 
get_header(); ?>

<div class="wrapper section-inner clearfix">
	<div class="content">

	<?php if ( have_posts() ) : ?>
		<div class="page-title clearfix">
			<h4><?php printf( __( 'Search results: %s', '_s' ), get_search_query() ); ?></h4>

			<?php 
			if( $wp_query->max_num_pages > 1 ) :
			$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
			$maxpage = $wp_query->max_num_pages;
			printf( __( '<p>Page %u<span class="sep">/</span>%s</p>' ), intval( $paged ), intval( $maxpage ) );
			endif; 
			?>
		</div> <!-- /page-title -->

		<div class="posts" id="posts">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
		</div> <!-- /posts -->

		<?php rowling_archive_navigation(); ?>

	<?php else : ?>

		<div class="page-title clearfix">
			<h4><?php printf( __( 'Search results: %s', '_s' ), get_search_query() ); ?></h4>
		</div> <!-- /page-title -->

		<div class="post single single-post clearfix">
			<div class="post-inner">
				<div class="post-content">
					<p><?php esc_html_e( 'No results. Try again, would you kindly?', 'rowling' ); ?></p>
					<?php get_search_form(); ?>
				</div> <!-- /post-content -->
			</div> <!-- /post-inner -->
		</div> <!-- /post -->

	<?php endif; ?>
	</div> <!-- /content -->
	<?php get_sidebar(); ?>
</div> <!-- /wrapper.section-inner -->
<?php get_footer();
