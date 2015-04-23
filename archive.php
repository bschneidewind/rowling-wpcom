<?php
/**
 * The template for displaying the archives
 *
 * @package Rowling
 */
 
get_header(); ?>

	<div class="wrapper section-inner clearfix">
		<div class="content">
			<div class="page-title clearfix">
				<?php the_archive_title( '<h4>', '</h4>' ); ?>

				<?php if( $wp_query->max_num_pages > 1 ) :
					$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
					$maxpage = $wp_query->max_num_pages;
					printf( __( '<p>Page %u<span class="sep">/</span>%s</p>' ), intval( $paged ), intval( $maxpage ) );
					endif; ?>

			</div> <!-- /page-title -->

			<?php if ( have_posts() ) : rewind_posts(); ?>

				<div class="posts" id="posts">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
				</div> <!-- /posts -->

				<?php rowling_archive_navigation(); ?>

			<?php endif; ?>

		</div> <!-- /content -->

		<?php get_sidebar(); ?>

	</div> <!-- /wrapper.section-inner -->

<?php get_footer();
