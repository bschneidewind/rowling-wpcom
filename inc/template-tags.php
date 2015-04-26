<?php
/**
 * Custom functions for this theme.
 *
 * @package rowling
*/

if ( ! function_exists( 'rowling_post_meta' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function rowling_post_meta() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( 'on %s', 'post date', 'rowling' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( 'Posted by %s', 'post author', 'rowling' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="post-meta-author"> ' . $byline . '</span><span class="post-meta-date"> ' . $posted_on . '</span>';

}
endif;

if ( ! function_exists( 'rowling_get_comment_excerpt' ) ) :
// Get comment excerpt length
function rowling_get_comment_excerpt( $comment_ID = 0, $num_words = 20 ) {
	$comment = get_comment( $comment_ID );
	$comment_text = strip_tags( $comment->comment_content );
	$blah = explode( ' ', $comment_text );
	if ( count( $blah ) > $num_words ) {
		$k = $num_words;
		$use_dotdotdot = 1;
	} else {
		$k = count( $blah );
		$use_dotdotdot = 0;
	}
	$excerpt = '';
	for ( $i=0; $i<$k; $i++ ) {
		$excerpt .= $blah[$i] . ' ';
	}
	$excerpt .= ( $use_dotdotdot ) ? '...' : '';
	return apply_filters( 'get_comment_excerpt', $excerpt );
}
endif;

if ( ! function_exists( 'rowling_flexslider' ) ) :
// Flexslider function for format-gallery
function rowling_flexslider( $size ) {

	if ( is_page() ) :
		$attachment_parent = $post->ID;
	else : 
		$attachment_parent = get_the_ID();
	endif;

	if( $images = get_posts( array(
		'post_parent'    =>		$attachment_parent,
		'post_type'      => 	'attachment',
		'numberposts'    => 	-1, // show all
		'post_status'    => 	null,
		'post_mime_type' => 	'image',
		'orderby'        => 	'menu_order',
		'order'          => 	'ASC',
	) ) ) { ?>

		<?php if ( !is_single() ) : // Make it a link if it's an archive ?>

			<a class="flexslider" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

		<?php else : // ...and just a div if it's a single post ?>

			<div class="flexslider clearfix">

		<?php endif; ?>

			<ul class="slides">

				<?php foreach( $images as $image ) { 
				$attimg = wp_get_attachment_image( $image->ID,$size ); ?>

				<li>
				<?php echo esc_url( $attimg );

				if ( !empty( $image->post_excerpt ) && is_single() ) :
					printf( '<p class="post-image-caption"><span class="fa fw fa-camera"></span>%s</p>', esc_html( $image->post_excerpt ) );
				endif; ?>
				</li>

				<?php }; ?>

			</ul>

		<?php 
		if ( !is_single() ) {
			echo '</a>';
		} else {
			echo '</div>';
		}
	}
} // end of function rowling_flexslider
endif;

if ( ! function_exists( 'rowling_comment' ) ) :
// Rowling comment function
function rowling_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<?php __( 'Pingback:', 'rowling' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'rowling' ), '<span class="edit-link">', '</span>' ); ?>
	</li>
	
	<?php break; default : global $post; ?>
	
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment">
			<?php echo get_avatar( $comment, 160 ); ?>
			<?php if ( $comment->user_id === $post->post_author ) : ?>
				<a class="comment-author-icon" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" title="<?php esc_html_e( 'Comment by post author', 'rowling' ); ?>"><span class="fa fw fa-user"></span></a>
			<?php endif; ?>

			<div class="comment-inner">
				<div class="comment-header">
					<h4><?php echo get_comment_author_link(); ?></h4>
				</div> <!-- /comment-header -->

				<div class="comment-content post-content">
					<?php comment_text(); ?>
				</div><!-- /comment-content -->

				<div class="comment-meta clearfix">
					<div class="fleft">
						<span class="fa fw fa-clock-o"></span><a class="comment-date-link" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" title="<?php echo get_comment_date() . ' at ' . get_comment_time(); ?>"><?php echo get_comment_date(get_option('date_format')); ?></a>
						<?php edit_comment_link( __( 'Edit', 'rowling' ), '<span class="fa fw fa-wrench"></span>', '' ); ?>
					</div><!-- /fleft -->

					<?php 
					if ( '0' == $comment->comment_approved ) : ?>
					
						<div class="comment-awaiting-moderation fright">
							<span class="fa fw fa-exclamation-circle"></span><?php esc_html_e( 'Awaiting moderation', 'rowling' ); ?>
						</div>

					<?php 
					else : 

						comment_reply_link( array( 
							'reply_text' 	=>  	__( 'Reply', 'rowling' ),
							'depth'			=> 		$depth, 
							'max_depth' 	=> 		$args['max_depth'],
							'before'		=>		'<div class="fright"><span class="fa fw fa-reply"></span>',
							'after'			=>		'</div>'
							) 
						);

					endif; ?>

				</div> <!-- /comment-meta -->
			</div> <!-- /comment-inner -->
		</div><!-- /comment-## -->

	<?php
	break; endswitch;
} // end of function rowling_comment
endif;

if ( ! function_exists( 'rowling_related_posts' ) ) :
// Related posts function
function rowling_related_posts( $number_of_posts ) { ?>
	
	<div class="related-posts">
		<p class="related-posts-title"><?php esc_html_e('Read Next &rarr;','rowling'); ?></p>
		<div class="row">
			
			<?php // Check for posts in the same category
				global $post;
				$cat_ID = array();
				$categories = get_the_category();
				foreach( $categories as $category ) {
					array_push( $cat_ID,$category->cat_ID );
				}

				$related_posts = new WP_Query( apply_filters(
				'rowling_related_posts_args', array(
				        'posts_per_page'		=>	$number_of_posts,
				        'post_status'			=>	'publish',
				        'category__in'			=>	$cat_ID,
				        'post__not_in'			=>	array( $post->ID ),
				        'meta_key'				=>	'_thumbnail_id',
				        'ignore_sticky_posts'	=>	true
				) ) );

				if ( $related_posts->have_posts() ) : while ( $related_posts->have_posts() ) : $related_posts->the_post();
				
					global $post; ?>

					<a class="related-post" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

						<?php if ( has_post_thumbnail() ) : ?>

							<?php the_post_thumbnail('post-image-thumb') ?>

						<?php endif; ?>

							<p class="category">
							<?php
								$category = get_the_category();
								if ( isset( $category[0]->cat_name ) ):
									esc_attr( $category[0]->cat_name );
								endif;
							?>
							</p>
							
						<?php the_title( '<h3 class="title">', '</h3>' ); ?>
							
					</a>
				
				<?php endwhile; else: // If there are no other posts in the post categories, get random posts ?>

				<?php
					$related_posts = new WP_Query( apply_filters(
					'rowling_related_posts_args', array(
					        'posts_per_page'		=>	$number_of_posts,
					        'post_status'			=>	'publish',
					        'orderby'				=>	'rand',
					        'post__not_in'			=>	array( $post->ID ),
							'meta_key'				=>	'_thumbnail_id',
					        'ignore_sticky_posts'	=>	true
					) ) );
					
					if ( $related_posts->have_posts() ) : while ( $related_posts->have_posts() ) : $related_posts->the_post();
					
						global $post; ?>

						<a class="related-post" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

							<?php if ( has_post_thumbnail() ) : ?>

								<?php the_post_thumbnail('post-image-thumb') ?>

							<?php endif; ?>

							<p class="category">
								<?php
									$category = get_the_category();
									if ( isset( $category[0]->cat_name ) ):
										esc_attr( $category[0]->cat_name );
									endif;
								?>
							</p>

							<?php the_title( '<h3 class="title">', '</h3>' ); ?>

						</a>

					<?php endwhile; endif; ?>

			<?php endif; ?>

		</div> <!-- /row -->

		<?php wp_reset_query(); ?>

	</div> <!-- /related-posts -->

	<?php
} // end of function rowling_related_posts
endif;

if ( ! function_exists( 'rowling_archive_navigation' ) ) :
// Archive navigation function
function rowling_archive_navigation() {

	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>

		<div class="archive-nav clearfix">

			<?php 
				if ( get_previous_posts_link() ) echo '<li class="archive-nav-newer">' . get_previous_posts_link( '&larr; ' . __('Previous', 'rowling')) . '</li>';
				$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
				$max   = intval( $wp_query->max_num_pages );

				/**	Add current page to the array */
				if ( $paged >= 1 )
					$links[] = $paged;

				/**	Add the pages around the current page to the array */
				if ( $paged >= 3 ) {
					$links[] = $paged - 1;
					$links[] = $paged - 2;
				}

				if ( ( $paged + 2 ) <= $max ) {
					$links[] = $paged + 2;
					$links[] = $paged + 1;
				}

				/**	Link to first page, plus ellipses if necessary */
				if ( ! in_array( 1, $links ) ) {
					$class = 1 == $paged ? ' active' : '';

					printf( '<li class="number%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

					if ( ! in_array( 2, $links ) )
						echo '<li>...</li>';
				}

				/**	Link to current page, plus 2 pages in either direction if necessary */
				sort( $links );
				foreach ( (array) $links as $link ) {
					$class = $paged == $link ? ' active' : '';
					printf( '<li class="number%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
				}

				/**	Link to last page, plus ellipses if necessary */
				if ( ! in_array( $max, $links ) ) {
					if ( ! in_array( $max - 1, $links ) )
						echo '<li class="number">...</li>' . "\n";
			
					$class = $paged == $max ? ' active' : '';
					printf( '<li class="number%s"><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
				}

				if ( get_next_posts_link() ) echo '<li class="archive-nav-older">' . get_next_posts_link( __('Next', 'rowling') . ' &rarr;') . '</li>'; ?>

		</div> <!-- /archive-nav -->

	<?php 
	endif;
}  // end of function rowling_archive_navigation
endif;
