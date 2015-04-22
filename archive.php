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
			<h4><?php if ( is_day() ) : ?>
				<?php printf( __( 'Date: %s', 'rowling' ), '' . get_the_date( get_option( 'date_format' ) ) . '' ); ?>
			<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Month: %s', 'rowling' ), '' . get_the_date( 'F Y' ) . '' ); ?>
			<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Year: %s', 'rowling' ), '' . get_the_date( 'Y' ) . '' ); ?>
			<?php elseif ( is_category() ) : ?>
				<?php printf( __( 'Category: %s', 'rowling' ), '' . single_cat_title( '', false ) . '' ); ?>
			<?php elseif ( is_tag() ) : ?>
				<?php printf( __( 'Tag: %s', 'rowling' ), '' . single_tag_title( '', false ) . '' ); ?>
			<?php elseif ( is_author() ) : ?>
				<?php printf( esc_html__( 'Author: %s', 'rowling' ), '<span class="vcard">' . esc_html( get_the_author() ) . '</span>' ); ?>	
			<?php else : ?>
				<?php esc_html_e( 'Archive', 'rowling' ); ?>
			<?php endif; ?></h4>
				
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