<?php
/**
 * The default page template
 *
 * @package Rowling
 */

get_header(); ?>

<div class="wrapper section-inner">

	<div class="content">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class( 'post single single-post' ); ?>>

				<div class="post-header">

				    <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

				</div> <!-- /post-header -->

				<?php if ( has_post_thumbnail() ) : ?>

					<div class="post-image">

						<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">

							<?php the_post_thumbnail( 'post-image' ); ?>

						</a>

						<?php if ( !empty( get_post( get_post_thumbnail_id() )->post_excerpt ) ) : ?>

							<p class="post-image-caption"><span class="fa fw fa-camera"></span><?php echo get_post( get_post_thumbnail_id() )->post_excerpt; ?></p>

						<?php endif; ?>

					</div> <!-- /post-image -->

				<?php endif; ?>

				<div class="post-inner">

					<div class="post-content">

						<?php the_content(); ?>

						<?php edit_post_link( __( 'Edit', 'rowling' ), '<p class="page-edit-link"><span class="fa fw fa-wrench"></span>', '</p>' ); ?>

					</div> <!-- /post-content -->

				</div> <!-- /post-inner -->

				<?php comments_template( '', true ); ?>

			</div> <!-- /post -->

	   	<?php endwhile; else: ?>

			<p><?php esc_html_e( 'We couldn\'t find any posts that matched your query. Please try again.', 'rowling' ); ?></p>

		<?php endif; ?>

	</div> <!-- /content -->

	<?php get_sidebar(); ?>

</div> <!-- /wrapper.section-inner -->

<?php get_footer(); ?>