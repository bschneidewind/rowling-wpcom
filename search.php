<?php
/**
 * The search results page template
 *
 * @package Rowling
 */
 
 get_header(); ?>

<div class="wrapper section-inner">

	<div class="content">
		
		<?php if ( have_posts() ) : ?>
		
			<div class="page-title">
			
				<h4><?php esc_html_e( 'Search results:', 'rowling'); echo ' "' . get_search_query() . '"'; ?></h4>
				
				<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				
				if ( '1' < $wp_query->max_num_pages ) : ?>
				
					<p><?php esc_html_e( 'Page', 'rowling' ); echo ' ' . $paged . '<span class="sep">/</span>' . $wp_query->max_num_pages; ?></p>
				
				<?php endif; ?>
				
				<div class="clear"></div>
								
			</div> <!-- /page-title -->
					
			<div class="posts" id="posts">
				
				<?php while ( have_posts() ) : the_post(); ?>
		    	
		    		<?php get_template_part( 'content', get_post_format() ); ?>
		    			        		            
		        <?php endwhile; ?>
							
			</div> <!-- /posts -->
			
			<?php rowling_archive_navigation(); ?>
			
		<?php else : ?>	
						
			<div class="page-title">
		
				<h4>
					<?php esc_html_e( 'Search results:', 'rowling' ); echo ' "' . get_search_query() . '"'; ?>
				</h4>
				
				<div class="clear"></div>
				
			</div> <!-- /page-title -->
						
			<div class="post single single-post">
			
				<div class="post-inner">
			
					<div class="post-content">
					
						<p><?php esc_html_e( 'No results. Try again, would you kindly?', 'rowling' ); ?></p>
						
						<?php get_search_form(); ?>
					
					</div> <!-- /post-content -->
				
				</div> <!-- /post-inner -->
				
				<div class="clear"></div>
			
			</div> <!-- /post -->
	
		<?php endif; ?>

	</div> <!-- /content -->
	
	<?php get_sidebar(); ?>

</div> <!-- /wrapper.section-inner -->
		
<?php get_footer();
