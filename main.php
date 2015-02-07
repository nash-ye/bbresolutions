<?php
/**
 * Plugin Name: bbResolutions
 * Plugin URI: https://github.com/nash-ye/bbResolutions
 * Description: A bbPress plugin to let you set topic resolutions.
 * Author: Nashwan Doaqan
 * Author URI: http://nashwan-d.com
 * Version: 0.2.3
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
const VERSION = '0.2.3';

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

		if ( did_action( 'bbp_after_setup_actions' ) ) {
			$this->after_bbpress_setup();
		} else {
			add_action( 'bbp_after_setup_actions', array( $this, 'after_bbpress_setup' ) );
		}

		if ( did_action( 'bp_after_setup_actions' ) ) {
			$this->after_buddypress_setup();
		} else {
			add_action( 'bp_after_setup_actions', array( $this, 'after_buddypress_setup' ) );
		}

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
		load_plugin_textdomain( 'bbResolutions', FALSE, basename( __DIR__ ) . '/languages' );

	}

	/**
	 * @return void
	 * @since 0.2
	 */
	public function register_defaults() {

		Manager::register( 'not-support', array(
			'label'     => __( 'Not a Question', 'bbResolutions' ),
			'value'     => '1',
		) );

		Manager::register( 'not-resolved', array(
			'label'     =>  __( 'Not Resolved', 'bbResolutions' ),
			'value'     => '2',
		) );

		Manager::register( 'resolved', array(
			'label'     =>  __( 'Resolved', 'bbResolutions' ),
			'sticker'   => __( '[Resolved]', 'bbResolutions' ),
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
			require plugin_dir_path( __FILE__ ) . 'includes/bbpress/widgets.php';
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