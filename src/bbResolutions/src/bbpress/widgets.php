<?php

namespace bbResolutions;

add_action('widgets_init', 'bbResolutions\register_widgets', 20);

/**
 * Register plugin's widgets.
 * 
 * @return void
 * @since  0.2.3
 */
function register_widgets()
{
    register_widget('bbResolutions\Widgets\Topics_Widget');
}
