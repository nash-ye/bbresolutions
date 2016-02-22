<?php

namespace bbResolutions;

/**
 * bbResolutions Recent Topics Widget
 *
 * @uses WP_Widget
 * @since 0.2.3
 */
class Topics_Widget extends \WP_Widget {

	/**
	 * Registers the topic widget
	 *
	 * @since 0.2.3
	 */
	public function __construct() {

		parent::__construct( 'bbr_topics_widget', __( '(bbResolutions) Recent Topics', 'bbResolutions' ), array(
			'description' => __( 'A list of recent topics with an option to set the resolution.', 'bbResolutions' )
		) );

	}

	/**
	 * Displays the output, the topic list
	 *
	 * @since 0.2.3
	 */
	public function widget( $args = array(), $instance = array() ) {

		$settings = $this->parse_settings( $instance );

		$query_args = array(
			'post_type'           => bbp_get_topic_post_type(),
			'posts_per_page'      => (int) $settings['max_shown'],
			'post_status'         => array( bbp_get_public_status_id(), bbp_get_closed_status_id() ),
			'post_parent'         => $settings['forum'],
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'order'               => 'DESC',
		);

		$resolution = Manager::get_by_key( $settings['resolution'] );

		if ( ! empty( $resolution ) ) {

			$query_args['meta_query'] = array(
				array(
					'key'   => 'bbr_topic_resolution',
					'value' => $resolution->value,
				),
			);

		}

		$query = new \WP_Query( $query_args );

		if ( ! $query->have_posts() ) {
			return;
		}

		echo $args['before_widget'];

		$settings['title'] = apply_filters( 'widget_title', $settings['title'], $instance, $this->id_base );

		if ( ! empty( $settings['title'] ) ) {
			echo $args['before_title'] . $settings['title'] . $args['after_title'];
		}

		?>

		<ul>

			<?php

				while ( $query->have_posts() ) :

					$query->the_post();
					$topic_id = bbp_get_topic_id( $query->post->ID ); ?>

					<li>

						<a class="bbp-forum-title" href="<?php bbp_topic_permalink( $topic_id ) ?>"><?php bbp_topic_title( $topic_id ) ?></a>

						<?php

							if ( ! empty( $settings['show_user'] ) ) :

								$author_link = bbp_get_topic_author_link( array( 'post_id' => $topic_id, 'type' => 'both', 'size' => 14 ) );
								printf( _x( 'by %1$s', 'widgets', 'bbResolutions' ), '<span class="topic-author">' . $author_link . '</span>' );

							endif;

						?>

						<?php if ( ! empty( $settings['show_date'] ) ) : ?>
							<div><?php bbp_topic_last_active_time( $topic_id ) ?></div>
						<?php endif; ?>

					</li><?php

				endwhile;

			?>

		</ul>

		<?php echo $args['after_widget'];

		// Reset the $post global
		wp_reset_postdata();

	}

	/**
	 * Update the topic widget options
	 *
	 * @since 0.2.3
	 */
	public function update( $new_instance = array(), $old_instance = array() ) {

		$instance = $old_instance;

		foreach( array( 'title', 'forum', 'resolution' ) as $field_name ) {
			if ( isset( $new_instance[ $field_name ] ) ) {
				$instance[ $field_name ] = strip_tags( $new_instance[ $field_name ] );
			}
		}

		foreach( array( 'show_user', 'show_date' ) as $field_name ) {
			$instance[ $field_name ] = isset( $new_instance[ $field_name ] );
		}

		$instance['max_shown'] = (int) $new_instance['max_shown'];

		if ( ! is_numeric( $instance['forum'] ) ) {
			$instance['forum'] = 'any';
		}

		return $instance;

	}

	/**
	 * Output the topic widget options form
	 *
	 * @since 0.2.3
	 */
	public function form( $instance = array() ) {

		$settings = $this->parse_settings( $instance ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Title:', 'bbResolutions' ) ?></label>
			<input type="text" class="widefat" name="<?php echo $this->get_field_name( 'title' ) ?>" id="<?php echo $this->get_field_id( 'title' ) ?>" value="<?php echo esc_attr( $settings['title'] ) ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'forum' ) ?>"><?php _e( 'Forum ID:', 'bbResolutions' ) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'forum' ) ?>" name="<?php echo $this->get_field_name( 'forum' ) ?>" value="<?php echo esc_attr( $settings['forum'] ) ?>" />
			<br />
			<small><?php _e( '"0" to show only root - "any" to show all', 'bbResolutions' ) ?></small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'resolution' ) ?>"><?php _e( 'Resolution:', 'bbResolutions' ) ?></label>
			<?php resolutions_dropdown( array( 'id' => $this->get_field_id( 'resolution' ), 'name' => $this->get_field_name( 'resolution' ), 'selected' => $settings['resolution'], 'show_none' => false ) ); ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'max_shown' ) ?>"><?php _e( 'Maximum topics to show:', 'bbResolutions' ) ?></label>
			<input type="number" class="widefat" id="<?php echo $this->get_field_id( 'max_shown' ) ?>" name="<?php echo $this->get_field_name( 'max_shown' ) ?>" value="<?php echo esc_attr( $settings['max_shown'] ) ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_user' ) ?>"><?php _e( 'Show topic author:', 'bbResolutions' ) ?></label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_user' ) ?>" name="<?php echo $this->get_field_name( 'show_user' ) ?>" <?php checked( $settings['show_user'] ) ?> value="1" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_date' ) ?>"><?php _e( 'Show topic date:', 'bbResolutions' ) ?></label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_date' ) ?>" name="<?php echo $this->get_field_name( 'show_date' ) ?>" <?php checked( $settings['show_date'] ) ?> value="1" />
		</p>

		<?php
	}

	/**
	 * Merge the widget settings into defaults array.
	 *
	 * @since 0.2.3
	 */
	public function parse_settings( $instance = array() ) {

		return wp_parse_args( $instance, array(
			'title'        => __( 'Recent Topics', 'bbResolutions' ),
			'max_shown'    => 5,
			'show_date'    => false,
			'show_user'    => false,
			'forum'        => 'any',
			'resolution'   => '',
		) );

	}

}

add_action( 'widgets_init', 'bbResolutions\register_widgets', 20 );

/**
 * @return void
 * @since 0.2.3
 */
function register_widgets() {
	register_widget( 'bbResolutions\Topics_Widget' );
}
