<?php
/**
 * The template used for displaying content
 *
 * @package Rowling
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'post clearfix' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>

		<div class="post-image">
			<?php if ( is_sticky() ) : //Show the banner/star for sticky posts  ?>
				<a class="sticky-tag" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
					<span class="fa fw fa-star"></span>
				</a>
			<?php endif; ?>

			<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">	
				<?php the_post_thumbnail( 'post-image-thumb' ); ?>
			</a>
		</div> <!-- /post-image -->

	<?php endif; ?>

	<div class="post-header">
		<?php if ( has_category() ) : ?>
			<p class="post-categories"><?php the_category( ', ' ); ?></p>
		<?php endif; ?>

		<?php if ( get_the_title() ) : ?>
			<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<?php endif; ?>

		<p class="post-meta">
			<a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a> 
			<?php 
				if ( comments_open() ) {
					echo ' &mdash; ';
					comments_popup_link( '0 Comments', '1 Comment', '% Comments' ); 
				} 
			?>
		</p>
	</div> <!-- /post-header -->
</div> <!-- /post -->