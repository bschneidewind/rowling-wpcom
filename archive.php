<?php
/**
 * The template for displaying the archives
 *
 * @package Rowling
 */

get_header(); ?>

	<div class="wrapper section-inner clearfix">
		<div class="content">
			<div class="page-title clearfix">
				<?php the_archive_title( '<h4>', '</h4>' ); ?>

				<?php if ( $wp_query->max_num_pages > 1 ) : $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
				$maxpage = $wp_query->max_num_pages;
				printf( __( '<p>Page %u<span class="sep">/</span>%s</p>' ), intval( $paged ), intval( $maxpage ) );
				endif;
				?>

			</div> <!-- /page-title -->

			<?php if ( have_posts() ) : rewind_posts(); ?>

				<div class="posts" id="posts">
					<?php while ( have_posts() ) : the_post(); ?>
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
					<?php endwhile; ?>
				</div> <!-- /posts -->

				<?php rowling_archive_navigation(); ?>
			<?php endif; ?>
		</div> <!-- /content -->
		<?php get_sidebar(); ?>
	</div> <!-- /wrapper.section-inner -->
<?php get_footer();
