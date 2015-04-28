<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Rowling
 */
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
	return;
}

if ( have_comments() ) : ?>

	<div class="comments-container">
		<div class="comments-inner">
			<a name="comments"></a>
			<div class="comments-title-container clearfix">
				<h3 class="comments-title">
					<?php printf( _nx( '1 comment', '%1$s comments', get_comments_number(), 'rowling' ), number_format_i18n( get_comments_number() ) ); ?>
				</h3>

				<?php if ( comments_open() ) : ?>
				<p class="comments-title-link">
					<a href="#respond" title="<?php esc_attr_e( 'Add comment', 'rowling' ); ?>" class="comment-respond"><?php esc_html_e( 'Add Comment &rarr;', 'rowling' ); ?></a>
				</p>
				<?php endif; ?>
			</div>

			<div class="comments">
				<ol class="commentlist">
				    <?php wp_list_comments( array( 'type' => 'comment', 'callback' => 'rowling_comment' ) ); ?>
				</ol>

			<?php if ( ! empty( $comments_by_type['pings'] ) ) : ?>
			
				<div class="pingbacks">
					<h3 class="pingbacks-title">
						<?php printf( _nx( 'One Pingback', '%1$s Pingbacks', count( $wp_query->comments_by_type['pings'] ), 'pingbacks-title', 'rowling' ), number_format_i18n( count( $wp_query->comments_by_type['pings'] ) ) ); ?>
					</h3>

					<ol class="pingbacklist">
					    <?php wp_list_comments( array( 'type' => 'pings', 'callback' => 'rowling_comment' ) ); ?>
					</ol>
				</div> <!-- /pingbacks -->

			<?php endif; ?>
			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			
				<div class="comments-nav clearfix" role="navigation">
					<div class="fleft">
						<?php previous_comments_link( '&larr; ' . __( 'Previous', 'rowling' ) ); ?>
					</div>
					<div class="fright">
						<?php next_comments_link( __( 'Next', 'rowling' ) . ' &rarr;' ); ?>
					</div>
				</div> <!-- /comment-nav -->

			<?php endif; ?>

			</div> <!-- /comments -->
		</div> <!-- /comments-inner -->
	</div> <!-- /comments-container -->
	
<?php endif; ?>

<?php if ( ! comments_open() && ! is_page() ) : ?>
	<p class="no-comments"><span class="fa fw fa-times"></span><?php esc_html_e( 'Comments are Closed', 'rowling' ); ?></p>	
<?php elseif ( comments_open() ) : ?>
	<div class="respond-container">
		<?php comment_form(); ?>
	</div> <!-- /respond-container -->
<?php endif;
