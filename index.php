<?php
/**
 * The main template file
 *
 * @package Rowling
 */
 
 get_header(); ?>

<div class="wrapper section-inner clearfix">
			
	<div class="content">				
																							                    
		<?php if ( have_posts() ) : ?>
		
			<?php $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			
			if ( '1' < $paged ) : ?>
			
				<div class="page-title">
					
					<h4>Archive</h4>
				
					<p><?php esc_html_e( 'Page', 'rowling' ); echo ' ' . $paged . '<span class="sep">/</span>' . $wp_query->max_num_pages; ?></p>
					
					<div class="clear"></div>
					
				</div> <!-- /page-title -->
							
			<?php endif; ?>
		
			<div class="posts" id="posts">
					
		    	<?php while (have_posts()) : the_post(); ?>
		    	
		    		<?php get_template_part( 'content', get_post_format() ); ?>
		    			        		            
		        <?php endwhile; ?>
	        	                    			
			</div> <!-- /posts -->
		
			<?php rowling_archive_navigation(); ?>
			
		<?php endif; ?>
		
	</div> <!-- /content -->
	
	<?php get_sidebar(); ?>
	
</div> <!-- /wrapper.section-inner -->
	              	        
<?php get_footer();
