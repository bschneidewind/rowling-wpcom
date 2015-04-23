<?php
/**
 * The template for displaying the archives
 *
 * @package Rowling
 */
 
get_header(); ?>

<div class="wrapper section-inner">
	<div class="content">
		<div class="page-title">
			<?php the_archive_title( '<h4>', '</h4>' ); ?>
				
				<?php $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					if ( '1' < $wp_query->max_num_pages ) : ?>
				
					<p><?php esc_html_e( 'Page', 'rowling' ); echo ' ' . $paged . '<span class="sep">/</span>' . $wp_query->max_num_pages; ?></p>
					
					<div class="clear"></div>
				
				<?php endif; ?>
				
				<div class="clear"></div>
				
			</div> <!-- /page-title -->
			
			<?php if ( have_posts() ) : ?>
			
				<?php rewind_posts(); ?>
					
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