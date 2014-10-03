<?php
/**
 * Plugin Name: bbResolutions
 * Plugin URI: https://github.com/nash-ye/bbResolutions
 * Description: A bbPress plugin to let you set topic resolutions.
 * Author: Nashwan Doaqan
 * Author URI: http://nashwan-d.com
 * Version: 0.2.1
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
const VERSION = '0.2.1';

/**
 * @var string
 * @since 0.1
 */
const CODENAME = 'dexter';

/**
 * @since 0.2
 */
final class Main {

	/**
	 * @return void
	 * @since 0.2
	 */
	public function __construct() {

		$this->load_core();
		$this->load_textdomain();
		$this->register_defaults();

		add_action( 'bbp_after_setup_actions', array( $this, 'after_bbpress_setup' ) );
		add_action( 'bp_after_setup_actions', array( $this, 'after_buddypress_setup' ) );

	}

	/**
	 * @return void
	 * @since 0.2
	 */
	public function load_core() {

		// Load core functions.
		require plugin_dir_path( __FILE__ ) . 'includes/manager.php';
		require plugin_dir_path( __FILE__ ) . 'includes/helpers.php';

	}

	/**
	 * @return void
	 * @since 0.2
	 */
	public function load_textdomain() {

		// Load the plugin translated strings.
		load_plugin_textdomain( 'bbr', FALSE, basename( __DIR__ ) . '/languages' );

	}

	/**
	 * @return void
	 * @since 0.2
	 */
	public function register_defaults() {

		Manager::register( 'not-support', array(
			'label'     => __( 'Not a Question', 'bbr' ),
			'value'     => '1',
		) );

		Manager::register( 'not-resolved', array(
			'label'     =>  __( 'Not Resolved', 'bbr' ),
			'value'     => '2',
		) );

		Manager::register( 'resolved', array(
			'label'     =>  __( 'Resolved', 'bbr' ),
			'sticker'   => __( '[Resolved]', 'bbr' ),
			'value'     => '3',
		) );

	}

	/**
	 * @return void
	 * @since 0.2
	 */
	public function after_bbpress_setup() {

		if ( function_exists( 'is_bbpress' ) ) {
			require plugin_dir_path( __FILE__ ) . 'includes/bbpress/topic-control.php';
			require plugin_dir_path( __FILE__ ) . 'includes/bbpress/topic-actions.php';
			require plugin_dir_path( __FILE__ ) . 'includes/bbpress/topic-view.php';
		}

	}

	/**
	 * @return void
	 * @since 0.2
	 */
	public function after_buddypress_setup() {

		if ( function_exists( 'is_buddypress' ) ) {
			// TODO: Add support for BuddyPress plugin.
		}

	}

}

// Hey Dexter!!
new Main();