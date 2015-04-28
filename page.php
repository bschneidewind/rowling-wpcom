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
				<?php the_title( '<div class="post-header"><h2 class="post-title">', '</h2></div>' ); ?>

				<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-image">
					<?php printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), the_post_thumbnail( 'post-image img-responsive' ) ); ?>
					<?php $get_description = get_post( get_post_thumbnail_id() )->post_excerpt;
					if
					( !empty( $get_description ) )
					{
						printf( '<p class="post-image-caption"><span class="fa fw fa-camera"></span>%s</p>', esc_html( $get_description ) );
					} ?>
				</div> <!-- /post-image -->
				<?php endif; ?>

				<div class="post-inner">
					<div class="post-content clearfix">
						<?php the_content(); ?>
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
