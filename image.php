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

		<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
		?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<nav id="image-navigation" class="navigation image-navigation">
						<div class="nav-links">
							<div class="nav-previous"><?php previous_image_link( false, __( 'Previous Image', 'rowling' ) ); ?></div><div class="nav-next"><?php next_image_link( false, __( 'Next Image', 'rowling' ) ); ?></div>
						</div><!-- .nav-links -->
					</nav><!-- .image-navigation -->

					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header><!-- .entry-header -->

					<div class="entry-content">

						<div class="entry-attachment">
							<?php
								echo wp_get_attachment_image( get_the_ID() );
							?>

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
					</div><!-- .entry-content -->

					<footer class="entry-footer">
						<div class="post-meta">
							<?php rowling_post_meta(); ?>
							<?php if ( comments_open() ) : ?>
								<span class="post-comments">
									<span class="fa fw fa-comment"></span><?php comments_popup_link( __( 'Leave a comment', '_s' ), __( '1 Comment', '_s' ), __( '% Comments', '_s' ) ); ?>
								</span>
							<?php endif; ?>
						</div> <!-- /post-meta -->
					
						<?php edit_post_link( __( 'Edit', 'rowling' ), '<p class="page-edit-link"><span class="fa fw fa-wrench"></span>', '</p>' ); ?>
					</footer><!-- .entry-footer -->

				</article><!-- #post-## -->

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

					// Previous/next post navigation.
					the_post_navigation( array(
						'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'rowling' ),
					) );

				// End the loop.
				endwhile;
			?>

	</div> <!-- /content -->

	<?php get_sidebar(); ?>

</div> <!-- /wrapper.section-inner -->

<?php get_footer();
