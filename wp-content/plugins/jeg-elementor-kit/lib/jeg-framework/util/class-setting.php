<?php
/**
 * Retrieve Setting for Header Builder
 *
 * @author Jegtheme
 * @since 1.0.0
 * @package header-builder
 */

namespace Jeg\Util;

use Jeg\Customizer\Customizer;

/**
 * Class Setting
 *
 * @package Jeg\Util
 */
class Setting {

	/**
	 * Get value of option
	 *
	 * @param string $id name of setting.
	 * @param mixed  $default default option.
	 *
	 * @return mixed
	 */
	protected static function get_option( $id, $default ) {
		$data = explode( '[', rtrim( $id, ']' ) );

		if ( 1 === count( $data ) ) {
			return get_option( $id, $default );
		} else {
			$option = get_option( $data[0] );
			$key    = $data[1];

			if ( isset( $option[ $key ] ) ) {
				return $option[ $key ];
			} else {
				return $default;
			}
		}
	}

	/**
	 * Get value of theme option (get theme mod)
	 *
	 * @param string $id name of setting.
	 * @param mixed  $default default option.
	 *
	 * @return mixed
	 */
	protected static function get_theme_mod( $id, $default ) {
		return get_theme_mod( $id, $default );
	}

	/**
	 * Get Value of setting (either use option or option)
	 *
	 * @param string $id name of setting.
	 * @param mixed  $default default option.
	 *
	 * @return mixed
	 */
	public static function get( $id, $default = null ) {
		$value  = null;
		$fields = Customizer::get_instance()->get_all_fields();

		if ( isset( $fields[ $id ] ) ) {
			$field = $fields[ $id ];
			$type  = isset( $field['option_type'] ) ? $field['option_type'] : 'theme_mod';

			if ( 'option' === $type ) {
				$value = self::get_option( $id, $default );
			} else {
				$value = self::get_theme_mod( $id, $default );
			}
		}

		return apply_filters( 'jeg_setting_value', $value, $id );
	}

}
