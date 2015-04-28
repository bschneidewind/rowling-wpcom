<?php
/**
 * The template used for displaying single posts
 *
 * @package Rowling
 */

get_header(); ?>

<div class="wrapper section-inner clearfix">
	<div class="content">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'single' ); ?>>
			<div class="post-header">

				<?php if ( has_category() ) : ?>
				<p class="post-categories"><?php the_category( ', ' ); ?></p>
				<?php endif; ?>

				<?php the_title( '<h2 class="post-title">', '</h2>' ); ?>

				<div class="post-meta">
					<?php rowling_post_meta(); ?>

					<?php if ( comments_open() ) : ?>
						<span class="post-comments">
							<span class="fa fw fa-comment"></span><?php comments_popup_link( __( 'Leave a comment', 'rowling' ), __( '1 Comment', 'rowling' ), __( '% Comments', 'rowling' ) ); ?>
						</span>
					<?php endif; ?>
				</div> <!-- /post-meta -->

			</div> <!-- /post-header -->

			<?php
			$post_format = get_post_format();
			if ( $post_format == 'gallery' ) :
				rowling_flexslider( 'post-image' );
			elseif ( has_post_thumbnail() ) : ?>
			
						<div class="post-image clearfix">
							<?php printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), the_post_thumbnail( 'post-image img-responsive' ) ); ?>
							<?php
			$get_description = get_post( get_post_thumbnail_id() )->post_excerpt;
			if ( ! empty( $get_description ) ) {
				printf( '<p class="post-image-caption"><span class="fa fw fa-camera"></span>%s</p>', esc_html( $get_description ) );
			} ?>
			</div> <!-- /post-image -->

			<?php endif; ?>

			<?php rowling_related_posts( '3' ); // Number of related posts to display ?>

			<div class="post-inner">
				<div class="post-content clearfix">
					<?php the_content(); ?>
				</div>
					<?php edit_post_link( __( 'Edit', 'rowling' ), '<p class="page-edit-link"><span class="fa fw fa-wrench"></span>', '</p>' ); ?>
					<?php $args = array(
						'before'  => '<p class="page-links clearfix"><span class="title">' . __( 'Pages:', 'rowling' ) . '</span>',
						'after'   => '</p>',
						'link_before' => '<span>',
						'link_after' => '</span>',
						'separator'  => '',
						'pagelink'  => '%',
						'echo'   => 1,
					);
					wp_link_pages( $args );
					?>

				<?php if ( has_tag() ) : ?>
				<div class="post-tags">
					<?php the_tags( '', '' ); ?>
				</div>
				<?php endif; ?>

				<div class="post-author">
					<a class="avatar" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
					</a>
					<h4 class="title"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a></h4>
					<p class="description"><?php the_author_meta( 'description' ); ?></p>
				</div> <!-- /post-author -->

			</div> <!-- /post-inner -->
		</div> <!-- /post -->
		<?php comments_template( '', true ); ?>
		<?php endwhile; endif; ?>
	</div> <!-- /content -->
	<?php get_sidebar(); ?>
</div> <!-- /wrapper -->
<?php get_footer();
