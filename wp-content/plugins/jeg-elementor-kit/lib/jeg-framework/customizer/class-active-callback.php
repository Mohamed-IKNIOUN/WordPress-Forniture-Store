<?php
/**
 * @author      Jegtheme
 * @license     https://opensource.org/licenses/MIT
 */

namespace Jeg\Customizer;

use Jeg\Util\Setting;

class Active_Callback {

	/**
	 * @var Active_Callback
	 */
	private static $instance;

	/**
	 * @var bool
	 */
	private $active_flag = true;

	/**
	 * @var Customizer
	 */
	private $customizer;

	/**
	 * @return Active_Callback
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Get Customizer Instance
	 *
	 * @return Customizer
	 */
	public function get_customizer() {
		if ( null === $this->customizer ) {
			$this->customizer = Customizer::get_instance();
		}

		return $this->customizer;
	}

	/**
	 * @param $option
	 *
	 * @return mixed|void
	 */
	public function get_option( $option ) {
		$data = explode( '[', rtrim( $option, ']' ) );

		if ( 1 === count( $data ) ) {
			return get_option( $option );
		} else {
			$option = get_option( $data[0] );

			return $option[ $data[1] ];
		}
	}

	/**
	 * Figure out whether the current object should be displayed or not.
	 *
	 * @param array
	 *
	 * @return boolean
	 */
	public function evaluate( $active_callback ) {
		$this->active_flag = true;
		$fields            = $this->get_customizer()->get_fields();

		foreach ( $active_callback as $active ) {
			$field = $fields[ $active['setting'] ];
			$type  = isset( $field['option_type'] ) ? $field['option_type'] : '';

			if ( 'option' === $type ) {
				$current_setting = $this->get_option( $active['setting'] );
			} else {
				$current_setting = Setting::get( $active['setting'] );
			}

			$this->active_flag = $this->active_flag && $this->compare( $active['value'], $current_setting, $active['operator'] );
		}

		return $this->active_flag;
	}

	/**
	 * Evaluate by id
	 *
	 * @param string $id Setting ID to evaluate.
	 *
	 * @return bool
	 */
	public function evaluate_by_id( $id ) {
		$this->active_flag = true;

		$fields = $this->get_customizer()->get_all_fields();

		if ( isset( $fields[ $id ] ) ) {
			$field = $fields[ $id ];

			if ( isset( $field['active_callback'] ) ) {
				$active_callback = $field['active_callback'];

				foreach ( $active_callback as $active ) {
					$current_setting   = Setting::get( $active['setting'], $fields[ $active['setting'] ]['default'] );
					$this->active_flag = $this->active_flag && $this->compare( $active['value'], $current_setting, $active['operator'] );
				}
			}
		}

		return $this->active_flag;
	}

	/**
	 * Compares the 2 values given the condition
	 *
	 * @param mixed  $value1 The 1st value in the comparison.
	 * @param mixed  $value2 The 2nd value in the comparison.
	 * @param string $operator The operator we'll use for the comparison.
	 *
	 * @return boolean whether The comparison has succeded (true) or failed (false).
	 */
	public function compare( $value1, $value2, $operator ) {
		switch ( $operator ) {
			case '===':
				$show = ( $value1 === $value2 ) ? true : false;
				break;
			case '==':
			case '=':
			case 'equals':
			case 'equal':
				$show = ( $value1 === $value2 ) ? true : false;
				break;
			case '!==':
				$show = ( $value1 !== $value2 ) ? true : false;
				break;
			case '!=':
			case 'not equal':
				$show = ( $value1 !== $value2 ) ? true : false;
				break;
			case '>=':
			case 'greater or equal':
			case 'equal or greater':
				$show = ( $value1 >= $value2 ) ? true : false;
				break;
			case '<=':
			case 'smaller or equal':
			case 'equal or smaller':
				$show = ( $value1 <= $value2 ) ? true : false;
				break;
			case '>':
			case 'greater':
				$show = ( $value1 > $value2 ) ? true : false;
				break;
			case '<':
			case 'smaller':
				$show = ( $value1 < $value2 ) ? true : false;
				break;
			case 'contains':
			case 'in':
				if ( is_array( $value1 ) && ! is_array( $value2 ) ) {
					$array  = $value1;
					$string = $value2;
				} elseif ( is_array( $value2 ) && ! is_array( $value1 ) ) {
					$array  = $value2;
					$string = $value1;
				}
				if ( isset( $array ) && isset( $string ) ) {
					if ( ! in_array( $string, $array, true ) ) {
						$show = false;
					}
				} else {
					if ( false === strrpos( $value1, $value2 ) && false === strpos( $value2, $value1 ) ) {
						$show = false;
					}
				}
				break;
			default:
				$show = ( $value1 === $value2 ) ? true : false;

		}

		if ( isset( $show ) ) {
			return $show;
		}

		return true;
	}

}
