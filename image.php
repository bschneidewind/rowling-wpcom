<?php
/**
 * The template for displaying image attachments
 *
 * @package Rowling
 * $content_width is defined in functions.php
 *
 */

get_header(); ?>

<div class="wrapper section-inner clearfix">
	<div class="content">

		<?php while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'post single single-post' ); ?>>
			<?php the_title( '<div class="post-header"><h2 class="post-title">', '</h2></div>' ); ?>
			
			<div class="related-posts">
				<p class="related-posts-title">
					<?php esc_html_e( 'View Next &rarr;', 'rowling' ); ?>
				</p>
				<div class="nav-previous">
					<?php previous_image_link( false, __( 'Previous Image', 'rowling' ) ); ?>
				</div>
				<hr>
				<div class="nav-next">
					<?php next_image_link( false, __( 'Next Image', 'rowling' ) ); ?>
				</div>
			</div>

			<div class="post-inner">
				<div class="post-content clearfix">
					<div class="entry-attachment">
						<?php echo wp_get_attachment_image( $post->ID, 'post-image' ); ?>
						<?php if ( has_excerpt() ) : ?>
							<div class="entry-caption">
								<?php the_excerpt(); ?>
							</div><!-- .entry-caption -->
						<?php endif; ?>
					</div><!-- .entry-attachment -->
				
					<?php
					the_content();
					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'rowling' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'rowling' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					) );
					?>
				</div> <!-- /post-content -->
				<?php edit_post_link( __( 'Edit', 'rowling' ), '<p class="page-edit-link"><span class="fa fw fa-wrench"></span>', '</p>' ); ?>
			</div> <!-- /post-inner -->

			<?php comments_template( '', true ); ?>
		</div> <!-- /post -->
		<?php endwhile; ?>
	</div> <!-- /content -->
	<?php get_sidebar(); ?>
</div> <!-- /wrapper.section-inner -->

<?php get_footer();
