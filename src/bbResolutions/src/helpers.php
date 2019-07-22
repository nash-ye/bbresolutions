<?php

namespace bbResolutions;

/**
 * Output HTML attributes list.
 *
 * @param array $atts An associative array of attributes and their values.
 * @param array $args An array of arguments to be applied on the function output.
 * 
 * @since 0.1
 */
function html_atts(array $atts, array $args = array())
{
    echo get_html_atts($atts, $args);
}

/**
 * Convert an associative array to HTML attributes list.
 *
 * Convert an associative array of attributes and their values 'attribute => value'
 * to an inline list of HTML attributes.
 *
 * @param array $atts An associative array of attributes and their values.
 * @param array $args An array of arguments to be applied on the function output.
 * 
 * @return string
 * @since  0.1
 */
function get_html_atts(array $atts, array $args = array())
{
    $output = '';

    if (empty($atts)) {
        return $output;
    }

    $args = array_merge(array(
        'after' => '',
        'before' => ' ',
        'escape' => true,
    ), (array) $args);

    foreach ($atts as $key => $value) {
        $key = esc_html($key);

        if (is_bool($value)) {
            if ($value === true) {
                $value = $key;
            } else {
                continue;
            }
        } elseif (is_array($value)) {
            $value = array_filter($value);
            $value = implode(' ', $value);
        }

        if ($args['escape']) {
            switch (strtolower($key)) {
                case 'src':
                case 'href':
                    $value = esc_url($value);
                    break;
                default:
                    $value = esc_attr($value);
                    break;
            }
        }

        $output .= $key . '="' . $value . '" ';
    }

    if (empty($output)) {
        return $output;
    }

    return $args['before'] . trim($output) . $args['after'];
}

/**
 * @return void
 * @since  0.1
 */
function resolutions_dropdown(array $args = array())
{
    echo get_resolutions_dropdown($args);
}

/**
 * @return string
 * @since  0.1
 */
function get_resolutions_dropdown(array $args = array())
{
    $args = array_merge(array(
        'id'          => '',
        'name'        => '',
        'atts'        => array(
            'class' => 'bbr-resolutions-dropdown',
        ),
        'selected'    => '',
        'resolutions' => 'all',
        'show_none'   => true,
    ), $args);

    if ('all' === $args['resolutions']) {
        $args['resolutions'] = Manager::get_all();
    }

    $args['atts'] = array_merge($args['atts'], array(
        'name' => $args['name'],
        'id' => $args['id'],
    ));

    $output = '<select'. get_html_atts($args['atts']) .'>';

    if ($args['show_none']) {
        $output .= '<option value="">' . esc_html__('None', 'bbresolutions') . '</option>';
    }

    if (is_array($args['resolutions'])) {
        foreach ($args['resolutions'] as $resolution) {
            $option_label = esc_html($resolution->label);

            $option_atts = get_html_atts(array(
                'value' => $resolution->key,
                'selected' => ($args['selected'] == $resolution->key),
            ));

            $output .= "<option{$option_atts}>{$option_label}</option>";
        }
    }

    $output .= '</select>';

    return $output;
}
