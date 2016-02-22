<?php

namespace bbResolutions;

/**
 * @since 0.1
 */
class Manager {

	/**
	 * The resolutions list.
	 *
	 * @var array
	 * @since 0.1
	 */
	private static $resolutions = array();


	/*** Methods **************************************************************/

	/**
	 * @return array
	 * @since 0.1
	 */
	public static function get_all() {
		return self::$resolutions;
	}

	/**
	 * @return array
	 * @since 0.1
	 */
	public static function filter( array $args, $operator = 'AND' ) {
		return wp_list_filter( self::get_all(), $args, $operator );
	}

	/**
	 * @return object|null
	 * @since 0.1
	 */
	public static function get_by_key( $key ) {

		if ( isset( self::$resolutions[ $key ] ) ) {
			return self::$resolutions[ $key ];
		}

	}

	/**
	 * @return object|null
	 * @since 0.1
	 */
	public static function get_by_value( $value ) {

		$resolutions = self::filter( array(
			'value' => $value,
		), 'OR' );

		if ( empty( $resolutions ) ) {
			return;
		}

		$resolutions = reset( $resolutions );

		return $resolutions;

	}

	/**
	 * @return bool
	 * @since 0.1
	 */
	public static function register( $key, array $args ) {

		if ( isset( self::$resolutions[ $key ] ) ) {
			return false;
		}

		$args = (object) array_merge( array(
			'label'     => '', // String
			'value'     => '', // String
			'sticker'   => '', // String
		), $args );

		$args->key = $key; // The key clone.

		if ( empty( $args->value ) ) {

			$args->value = $args->key; // Always unique.

		} else {

			$resolution = self::get_by_value( $args->value );

			if ( ! is_null( $resolution ) ) {
				return false;
			}

		}

		self::$resolutions[ $key ] = $args;

		return true;

	}

	/**
	 * @return bool
	 * @since 0.1
	 */
	public static function unregister( $key ) {

		if ( ! isset( self::$resolutions[ $key ] ) ) {
			return false;
		}

		unset( self::$resolutions[ $key ] );

		return true;

	}

}
