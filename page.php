<?php
/**
 * The default page template
 *
 * @package Rowling
 */

get_header(); ?>

<div class="wrapper section-inner clearfix">
	<div class="content">

	<?php while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'post single single-post' ); ?>>
			<div class="post-header">
				<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			</div> <!-- /post-header -->

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="post-image">
				<?php printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), the_post_thumbnail( 'post-image' ) ); ?>

				<?php if ( $id = get_post_thumbnail_id() ) {
					$post = get_post( $id );
					$caption = $post->post_excerpt;
				
					// escape the caption
					$caption = array_map( 'esc_html', $caption );
				
					if ( ! empty ( $caption ) )
						echo '<p class="post-image-caption"><span class="fa fw fa-camera"></span>' . $caption . '</p>';
				} ?>

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
	<?php endwhile; ?>

	</div> <!-- /content -->

	<?php get_sidebar(); ?>

</div> <!-- /wrapper.section-inner -->

<?php get_footer();
