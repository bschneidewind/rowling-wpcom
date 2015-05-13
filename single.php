<?php
/**
 * The template used for displaying single posts
 *
 * @package Rowling
 */

get_header(); ?>

<div class="wrapper section-inner clearfix">
	<div class="content">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
				get_template_part( 'content', get_post_format() ); ?>
				<div class="single-post-nav clearfix">
					<div class="fleft">
						<?php previous_post_link(); ?>
					</div>
					<div class="fright">
						<?php next_post_link(); ?>
					</div>
				</div>
				<?php comments_template( '', true );
			endwhile; endif; ?>
	</div> <!-- /content -->
	<?php get_sidebar(); ?>
</div> <!-- /wrapper -->
<?php get_footer();
