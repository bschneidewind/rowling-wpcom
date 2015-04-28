<?php

class Rowling_Recent_Comments extends WP_Widget {

	function Rowling_Recent_Comments()
	{
		parent::WP_Widget( false, $name = __( 'Recent Comments', 'rowling' ), array( 'description' => __( 'Displays recent comments with user avatars.', 'rowling' ) ) );
	}

	function widget( $args, $instance )
	{

		// Outputs the content of the widget
		extract( $args ); // Make before_widget, etc available.

		$widget_title = null;
		$number_of_comments = null;
		$widget_title = esc_attr( apply_filters( 'widget_title', $instance['widget_title'] ) );
		$number_of_comments = esc_attr( $instance['number_of_comments'] );

		echo wp_kses_post( $before_widget );

		if ( ! empty( $widget_title ) ) {
			echo wp_kses_post( $before_title . $widget_title . $after_title );
		} ?>

			<ul class="rowling-widget-list">
				<?php
		if ( $number_of_comments == 0 ) $number_of_comments = 5;

		$args = array(
			'orderby'  => 'date',
			'number'   => $number_of_comments,
			'status'   => 'approve',
		);

		global $comment;

		// The Query
		$comments_query = new WP_Comment_Query;
		$comments = $comments_query->query( $args );

		// Comment Loop
		if ( $comments ) {
			foreach ( $comments as $comment ) {
			?>

							<li>
								<a href="<?php echo esc_url( get_permalink( $comment->comment_post_ID ) . '#comment' . $comment->comment_ID ); ?>" title="<?php esc_html_e( 'Comment to', 'rowling' ); echo ' ' . get_the_title( $comment->comment_post_ID ) . ', '; esc_html_e( 'posted', 'rowling' ); echo ' ' . get_the_time( get_option( 'date_format' ) ); ?>">
									<div class="post-icon">
										<?php echo get_avatar( get_comment_author_email( $comment->comment_ID ), $size = '100' ); ?>
									</div>
									<div class="inner clearfix">
										<p class="title"><span><?php comment_author(); ?></span></p>
										<p class="excerpt">"<?php echo esc_attr( rowling_get_comment_excerpt( $comment->comment_ID, 13 ) ); ?>"</p>
									</div>
								</a>
							</li>
						<?php }
		}
?>
			</ul>
		<?php echo wp_kses_post( $after_widget );
	}

	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;
		$instance['widget_title'] = strip_tags( $new_instance['widget_title'] );
		// make sure we are getting a number
		$instance['number_of_comments'] = is_int( intval( $new_instance['number_of_comments'] ) ) ? intval( $new_instance['number_of_comments'] ): 5;
		//update and save the widget
		return $instance;
	}

	function form( $instance )
	{
		// Set defaults
		if
		( ! isset( $instance['widget_title'] ) ) { 
			$instance['widget_title'] = ''; 
		}
		if
		( ! isset( $instance['number_of_comments'] ) ) { 
			$instance['number_of_comments'] = '5'; 
		}
		// Get the options into variables, escaping html characters on the way
		$widget_title = esc_attr( $instance['widget_title'] );
		$number_of_comments = esc_attr( $instance['number_of_comments'] );
?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>"><?php _e( 'Title', 'rowling' ); ?>:
			<input id="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'widget_title' ) ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $widget_title ); ?>" /></label>
		</p>

		<p>
			<label for="<?php echo wp_kses_post( $this->get_field_id( 'number_of_comments' ) ); ?>"><?php _e( 'Number of comments to display', 'rowling' ); ?>:
			<input id="<?php echo wp_kses_post( $this->get_field_id( 'number_of_comments' ) ); ?>" name="<?php echo wp_kses_post( $this->get_field_name( 'number_of_comments' ) ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $number_of_comments ); ?>" /></label>
			<small><?php _e( '(Defaults to 5 if empty)', 'rowling' ); ?></small>
		</p>

		<?php
	}
}
register_widget( 'Rowling_Recent_Comments' );