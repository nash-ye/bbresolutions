<?php

namespace bbResolutions;

/**
 * @return string|null
 * @since 0.1
 */
function get_topic_resolution_key($topic_id)
{
    $object = get_topic_resolution_object($topic_id);

    if (empty($object)) {
        return false;
    }

    return $object->key;
}

/**
 * @return string|bool
 * @since 0.1
 */
function get_topic_resolution_value($topic_id)
{
    $topic_id = bbp_get_topic_id($topic_id);

    if (empty($topic_id)) {
        return false;
    }

    return get_post_meta($topic_id, 'bbr_topic_resolution', true);
}

/**
 * @return object|null
 * @since 0.1
 */
function get_topic_resolution_object($topic_id)
{
    $value = get_topic_resolution_value($topic_id);

    if (! empty($value)) {
        return Manager::get_by_value($value);
    }
}

/**
 * @return bool
 * @since 0.1
 */
function update_topic_resolution($topic_id, $new_resolution)
{
    $topic_id = bbp_get_topic_id($topic_id);

    if (empty($topic_id)) {
        return false;
    }

    if (! is_object($new_resolution)) {
        $new_resolution = Manager::get_by_key($new_resolution);
    }

    if (empty($new_resolution)) {
        return false;
    }

    $old_resolution = get_topic_resolution_object($topic_id);

    if ($old_resolution && $new_resolution->value == $old_resolution->value) {
        return true;
    }

    do_action('bbr_pre_update_topic_resolution', $topic_id, $new_resolution, $old_resolution);

    $updated = update_post_meta($topic_id, 'bbr_topic_resolution', $new_resolution->value);

    do_action('bbr_update_topic_resolution', $topic_id, $new_resolution, $old_resolution, $updated);

    return $updated;
}

/**
 * @retrun bool
 * @since 0.1
 */
function delete_topic_resolution($topic_id)
{
    $topic_id = bbp_get_topic_id($topic_id);

    if (empty($topic_id)) {
        return false;
    }

    do_action('bbr_pre_delete_topic_resolution', $topic_id);

    $deleted = delete_post_meta($topic_id, 'bbr_topic_resolution');

    do_action('bbr_delete_topic_resolution', $topic_id, $deleted);

    return $deleted;
}
