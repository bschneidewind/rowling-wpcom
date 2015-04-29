<?php
/**
 * The template used for displaying gallery content
 *
 * @package Rowling
 */
?>
	
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