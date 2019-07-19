<?php
/**
 * Plugin Name: bbResolutions
 * Plugin URI: https://github.com/nash-ye/bbResolutions
 * Description: A bbPress plugin to let you set topic resolutions.
 * Author: Nashwan Doaqan
 * Author URI: https://profiles.wordpress.org/alex-ye/
 * Version: 0.3
 * Text Domain: bbresolutions
 * Domain Path: /locales
 *
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Copyright (c) 2014 - 2019 Nashwan Doaqan.  All rights reserved.
 */

namespace bbResolutions;

/**
 * @var string
 * @since 0.1
 */
define('bbResolutions\VERSION', '0.2.4');

/**
 * @var string
 * @since 0.1
 */
define('bbResolutions\CODENAME', 'dexter');

/**
 * @var string
 * @since 0.2.4
 */
define('bbResolutions\DIR_URL', plugin_dir_url(__FILE__));

/**
 * @var string
 * @since 0.2.4
 */
define('bbResolutions\DIR_PATH', plugin_dir_path(__FILE__));

/**
 * @since 0.2
 */
final class Main
{

    /**
     * @return void
     * @since 0.2
     */
    public function __construct()
    {
        $this->load_core();
        $this->load_textdomain();
        $this->register_defaults();

        if (did_action('bbp_after_setup_actions')) {
            $this->after_bbpress_setup();
        } else {
            add_action('bbp_after_setup_actions', array( $this, 'after_bbpress_setup' ));
        }

        if (did_action('bp_after_setup_actions')) {
            $this->after_buddypress_setup();
        } else {
            add_action('bp_after_setup_actions', array( $this, 'after_buddypress_setup' ));
        }
    }

    /**
     * @return void
     * @since 0.2
     */
    public function load_core()
    {
        // Load core functions.
        require trailingslashit(DIR_PATH) . 'includes/manager.php';
        require trailingslashit(DIR_PATH) . 'includes/helpers.php';
    }

    /**
     * @return void
     * @since 0.2
     */
    public function load_textdomain()
    {
        // Load the plugin translated strings.
        load_plugin_textdomain('bbresolutions', false, basename(DIR_PATH) . '/locales');
    }

    /**
     * @return void
     * @since 0.2
     */
    public function register_defaults()
    {
        Manager::register('not-support', array(
            'label'     => __('Not a Question', 'bbresolutions'),
            'value'     => '1',
        ));

        Manager::register('not-resolved', array(
            'label'     =>  __('Not Resolved', 'bbresolutions'),
            'value'     => '2',
        ));

        Manager::register('resolved', array(
            'label'     =>  __('Resolved', 'bbresolutions'),
            'sticker'   => __('[Resolved]', 'bbresolutions'),
            'value'     => '3',
        ));
    }

    /**
     * @return void
     * @since 0.2
     */
    public function after_bbpress_setup()
    {
        if (function_exists('is_bbpress')) {
            require trailingslashit(DIR_PATH) . 'includes/bbpress/topic-control.php';
            require trailingslashit(DIR_PATH) . 'includes/bbpress/topic-actions.php';
            require trailingslashit(DIR_PATH) . 'includes/bbpress/topic-view.php';
            require trailingslashit(DIR_PATH) . 'includes/bbpress/widgets.php';
        }
    }

    /**
     * @return void
     * @since 0.2
     */
    public function after_buddypress_setup()
    {
        if (function_exists('is_buddypress')) {
            // TODO: Add support for BuddyPress plugin.
        }
    }
}

// Hey Dexter!
new Main();
