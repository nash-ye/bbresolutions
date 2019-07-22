<?php

namespace bbResolutions;

/**
 * @return void
 * @since 0.1
 */
function topic_resolution_feedback($topic_id = 0)
{
    $topic_id = bbp_get_topic_id($topic_id);

    if (empty($topic_id)) {
        return;
    }

    if (! apply_filters('bbr_show_topic_resolution_feedback', true, $topic_id)) {
        return;
    }

    $template = apply_filters('bbr_template_topic_resolution_feedback', false);

    if (! empty($template) && file_exists($template)) {
        include $template;
    } else {
        $topic_resolution = get_topic_resolution_object($topic_id);

        if (! empty($topic_resolution)) {
            ?>
			<div class="bbr-feedback">
				<div class="bbr-inner-message bbr-topic-resolution-message">
                    <?php printf(__('Topic Resolution: %s', 'bbresolutions'), '<span class="bbr-topic-resolution">' . $topic_resolution->label . '<span>') ?>
				</div>
            </div>
            <?php
        }
    }
}

add_action('bbp_template_before_single_topic', 'bbResolutions\topic_resolution_form');

/**
 * @return void
 * @since 0.1
 */
function topic_resolution_form($topic_id = 0)
{
    $topic_id = bbp_get_topic_id($topic_id);

    if (! $topic_id) {
        return;
    }

    if (current_user_can('edit_topic', $topic_id) && apply_filters('bbr_show_topic_resolution_form', true, $topic_id)) {
        $template = apply_filters('bbr_template_topic_resolution_form', false);

        if (! empty($template) && file_exists($template)) {
            include $template;
        } else {
            ?>
			<div class="bbr-form-wrapper">
				<form method="POST" action="<?php echo esc_url(home_url('/')) ?>" class="bbr-form bbr-form-topic-resolution">
					<div class="bbr-field-wrapper">
						<label for="bbr-topic-resolution"><?php esc_html_e('Resolution:', 'bbresolutions') ?></label>
						<?php
                            resolutions_dropdown(array(
                                'selected' => get_topic_resolution_key($topic_id),
                                'name'     => 'bbr_topic_resolution',
                                'id'       => 'bbr-topic-resolution',
							));
						?>
					</div>
					<div class="bbr-submit-wrapper">
						<input type="submit" value="<?php esc_attr_e('Update', 'bbresolutions') ?>" />
					</div>
					<input type="hidden" name="bbr_topic_id" value="<?php echo esc_attr($topic_id) ?>" />
					<input type="hidden" name="bbr_action" value="bbr_update_topic_resolution" />
					<?php wp_nonce_field('bbr_topic_resolution', 'bbr_nonce') ?>
				</form>
            </div>
            <?php
        }
    } else {
        topic_resolution_feedback();
    }
}

add_action('bbp_theme_before_topic_title', 'bbResolutions\topic_resolution_sticker');

/**
 * @return void
 * @since 0.2
 */
function topic_resolution_sticker($topic_id = 0)
{
    echo get_topic_resolution_sticker($topic_id);
}

/**
 * @return string
 * @since 0.2
 */
function get_topic_resolution_sticker($topic_id = 0)
{
    $topic_id = bbp_get_topic_id($topic_id);

    if (empty($topic_id)) {
        return;
    }

    $resolution = get_topic_resolution_object($topic_id);

    if ($resolution !== null && ! empty($resolution->sticker)) {
        $atts = array(
            'class' => "bbr-resolution-sticker bbr-resolution-{$resolution->key}-sticker",
            'title' => $resolution->label,
        );

        return '<span' . get_html_atts($atts) . '>' . $resolution->sticker . '</span>';
    }
}
