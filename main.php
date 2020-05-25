<?php
/**
 * Plugin Name: bbResolutions
 * Plugin URI: https://github.com/nash-ye/bbresolutions
 * Description: A bbPress plugin to let you set topic resolutions.
 * Author: Nashwan Doaqan
 * Author URI: https://profiles.wordpress.org/alex-ye/
 * Version: 0.7-beta-1
 * Text Domain: bbresolutions
 * Domain Path: /locales
 *
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Copyright (c) 2014 - 2020 Nashwan Doaqan.  All rights reserved.
 */

/**
 * Plugin's version number.
 * 
 * @var   string
 * @since 0.1
 */
define('bbResolutions\VERSION', '0.7-beta-1');

/**
 * Plugin's codename.
 * 
 * @var   string
 * @since 0.1
 */
define('bbResolutions\CODENAME', 'dexter');

/**
 * Plugin's directory URL.
 * 
 * @var   string
 * @since 0.7
 */
define('bbResolutions\PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Plugin's directory path.
 * 
 * @var   string
 * @since 0.7
 */
define('bbResolutions\PLUGIN_PATH', plugin_dir_path(__FILE__));

require trailingslashit(bbResolutions\PLUGIN_PATH) . 'freemius.php';
require trailingslashit(bbResolutions\PLUGIN_PATH) . 'vendor/autoload.php';

// Load Freemius
bbr_fs();
do_action('bbr_fs_loaded');

// Hey Dexter!
bbResolutions\Main::instance();
