<?php
/**
 * Plugin Name: bbResolutions
 * Plugin URI: https://github.com/nash-ye/bbResolutions
 * Description:
 * Author: Nashwan Doaqan
 * Author URI: http://nashwan-d.com
 * Version: 0.1
 *
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Copyright (c) 2014 - 2015 Nashwan Doaqan.  All rights reserved.
 */

namespace bbResolutions;

/**
 * @var float
 * @since 0.1
 */
const VERSION = '0.1';

/**
 * @var float
 * @since 0.1
 */
const CODENAME = 'dexter';

/**
 * Get the absolute system path to the plugin directory, or a file therein.
 *
 * @param string $path
 * @return string
 * @since 0.1
 */
function get_path( $path = '' ) {

	$base = dirname( __FILE__ );

	if ( ! empty( $path ) ) {
		$path = path_join( $base, $path );
	} else {
		$path = untrailingslashit( $base );
	}

	return $path;

}

// Load core.
require get_path( 'includes/manager.php' );
require get_path( 'includes/helpers.php' );

// Register the defaults.
Manager::register_defaults();

// Load bbPress depended functions.
require get_path( 'includes/bbpress/topic.php' );