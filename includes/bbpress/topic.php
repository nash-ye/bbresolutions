<?php

namespace bbResolutions;

/*** Control Functions ********************************************************/

/**
 * @return string|NULL
 * @since 0.1
 */
function get_topic_resolution_key( $topic_id ) {

	$object = get_topic_resolution_object( $topic_id );

	if ( empty( $object ) ) {
		return FALSE;
	}

	return $object->key;

}

/**
 * @return string|bool
 * @since 0.1
 */
function get_topic_resolution_value( $topic_id ) {

	$topic_id = bbp_get_topic_id( $topic_id );

	if ( empty( $topic_id ) ) {
		return FALSE;
	}

	return get_post_meta( $topic_id, 'bbr_topic_resolution', TRUE );

}

/**
 * @return object|NULL
 * @since 0.1
 */
function get_topic_resolution_object( $topic_id ) {

	$value = get_topic_resolution_value( $topic_id );

	if ( ! empty( $value ) ) {
		return Manager::get_by_value( $value );
	}

}

/**
 * @return bool
 * @since 0.1
 */
function update_topic_resolution( $topic_id, $new_resolution ) {

	$topic_id = bbp_get_topic_id( $topic_id );

	if ( empty( $topic_id ) ) {
		return FALSE;
	}

	if ( ! is_object( $new_resolution ) ) {
		$new_resolution = Manager::get_by_key( $new_resolution );
	}

	if ( empty( $new_resolution ) ) {
		 return FALSE;
	}

	$old_resolution = get_topic_resolution_object( $topic_id );

	if ( $old_resolution && $new_resolution->value == $old_resolution->value ) {
		 return TRUE;
	}

	do_action( 'bbr_pre_update_topic_resolution', $topic_id, $new_resolution, $old_resolution );

	$updated = update_post_meta( $topic_id, 'bbr_topic_resolution', $new_resolution->value );

	do_action( 'bbr_update_topic_resolution', $topic_id, $new_resolution, $old_resolution, $updated );

	return $updated;

}

/**
 * @retrun bool
 * @since 0.1
 */
function delete_topic_resolution( $topic_id ) {

	$topic_id = bbp_get_topic_id( $topic_id );

	if ( empty( $topic_id ) ) {
		 return FALSE;
	}

	do_action( 'bbr_pre_delete_topic_resolution', $topic_id );

	$deleted = delete_post_meta( $topic_id, 'bbr_topic_resolution' );

	do_action( 'bbr_delete_topic_resolution', $topic_id, $deleted );

	return $deleted;

}

/*** Actions Functions ********************************************************/

add_action( 'template_redirect', 'bbResolutions\topic_actions_handler', 11 );

/**
 * @return void
 * @since 0.1
 */
function topic_actions_handler() {

	if ( ! isset( $_POST['bbr_action'] ) ) {
		return FALSE;
	}

	if ( 'bbr_update_topic_resolution' !== $_POST['bbr_action'] ) {
		return FALSE;
	}

	if ( ! isset( $_POST['bbr_nonce'] ) ) {
		return FALSE;
	}

	if ( ! wp_verify_nonce( $_POST['bbr_nonce'], 'bbr_topic_resolution' ) ) {
		return FALSE;
	}

	if ( ! isset( $_POST['bbr_topic_id'] ) ) {
		return FALSE;
	}

	$topic_id = intval( $_POST['bbr_topic_id'] );

	if ( ! $topic_id || ! bbp_is_topic( $topic_id ) ) {
		return FALSE;
	}

	if ( ! current_user_can( 'edit_topic', $topic_id ) ) {
		return FALSE;
	}

	if ( ! isset( $_POST['bbr_topic_resolution'] ) ) {
		return FALSE;
	}

	update_topic_resolution( $topic_id, $_POST['bbr_topic_resolution'] );

    // Redirect to the topic page.
    wp_safe_redirect( bbp_get_topic_permalink( $topic_id ) );

    // For good measure
    exit();

}

/*** View Functions ***********************************************************/

/**
 * @return void
 * @since 0.1
 */
function topic_resolution_feedback( $topic_id = 0 ) {

	$topic_id = bbp_get_topic_id( $topic_id );

	if ( empty( $topic_id ) ) {
		return;
	}

	$template = apply_filters( 'bbr_template_topic_resolution_feedback', FALSE );

	if ( ! empty( $template ) && file_exists( $template ) ) {

		include $template;

	} else {

		$topic_resolution = get_topic_resolution_object( $topic_id );

		if ( ! empty( $topic_resolution ) ) { ?>

			<div class="bbr-feedback">

				<div class="bbr-inner-message bbr-topic-resolution-message">
					<?php printf( __( 'Topic Resolution: %s', 'bbr' ), '<span class="bbr-topic-resolution">' . $topic_resolution->label . '<span>' ) ?>
				</div>

			</div><?php

		}

	}

}

/**
 * @return void
 * @since 0.1
 */
function topic_resolution_field( $topic_id = 0 ) {

	$topic_id = bbp_get_topic_id( $topic_id );

	if ( empty( $topic_id ) ) {
		return;
	}

	?>

	<div class="bbps-field-wrapper">

		<label for="bbr-topic-resolution">
			<?php esc_html_e( 'Resolution:', 'bbr' ) ?>
		</label>

		<?php

			resolutions_dropdown( array(
				'selected' => get_topic_resolution_key( $topic_id ),
				'name' => 'bbr_topic_resolution',
				'id' => 'bbr-topic-resolution',
			) );

		?>

	</div><?php

}

add_action( 'bbp_template_before_single_topic', 'bbResolutions\topic_resolution_form' );

/**
 * @return void
 * @since 0.1
 */
function topic_resolution_form( $topic_id = 0 ) {

	$topic_id = bbp_get_topic_id( $topic_id );

	if ( ! $topic_id ) {
		return;
	}

	if ( current_user_can( 'edit_topic', $topic_id ) ) {

		$template = apply_filters( 'bbr_template_topic_resolution_form', FALSE );

		if ( ! empty( $template ) && file_exists( $template ) ) {

			include $template;

		} else { ?>

			<div class="bbr-form-wrapper">

				<form method="POST" action="<?php echo esc_url( home_url( '/' ) ) ?>" class="bbr-form bbr-form-topic-resolution">

					<?php topic_resolution_field( $topic_id ) ?>

					<div class="bbr-submit-wrapper">
						<input type="submit" value="<?php esc_attr_e( 'Update', 'bbr' ) ?>" />
					</div>

					<input type="hidden" name="bbr_topic_id" value="<?php echo esc_attr( $topic_id ) ?>" />
					<input type="hidden" name="bbr_action" value="bbr_update_topic_resolution" />

					<?php wp_nonce_field( 'bbr_topic_resolution', 'bbr_nonce' ) ?>

				</form>

			</div><?php

		}

	} else {

		topic_resolution_feedback();

	}

}