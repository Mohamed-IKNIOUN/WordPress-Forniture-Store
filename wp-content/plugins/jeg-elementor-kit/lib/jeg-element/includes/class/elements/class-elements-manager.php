<?php
/**
 * Jeg News Element Image Class
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Elements;

/**
 * Class Module_Manager
 *
 * @package Jeg\Element\Modules
 */
class Elements_Manager {
	/**
	 * Element Option
	 *
	 * @var array
	 */
	private $options = array();

	/**
	 * Element count. Increase everytime item added.
	 *
	 * @var int
	 */
	private $element_count;

	/**
	 * Hold unique article on each array.
	 *
	 * @var array
	 */
	private $unique_article;

	/**
	 * Hold width of column
	 *
	 * @var array
	 */
	private $width = array();

	/**
	 * Module_Manager constructor.
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'load_elements_option' ) );
		add_action( 'after_setup_theme', array( $this, 'render_shortcode' ) );

		add_filter( 'pre_do_shortcode_tag', array( $this, 'register_column_width' ), null, 3 );
		add_filter( 'do_shortcode_tag', array( $this, 'reset_column_width' ), null, 2 );
	}

	/**
	 * Filters the output created by a shortcode callback.
	 *
	 * @param string $output Shortcode output.
	 * @param string $tag Shortcode name.
	 *
	 * @return string
	 * @since 4.7.0
	 */
	public function reset_column_width( $output, $tag ) {
		$flag = apply_filters( 'jeg_shortcode_reset_width', false, $tag );

		if ( $flag ) {
			array_pop( $this->width );
		}

		return $output;
	}

	/**
	 * Filters whether to call a shortcode callback.
	 *
	 * Passing a truthy value to the filter will effectively short-circuit the
	 * shortcode generation process, returning that value instead.
	 *
	 * @param bool|string  $return Short-circuit return value. Either false or the value to replace the shortcode with.
	 * @param string       $tag Shortcode name.
	 * @param array|string $attr Shortcode attributes array or empty string.
	 *
	 * @return boolean
	 * @since 4.7.0
	 */
	public function register_column_width( $return, $tag, $attr ) {
		$width = apply_filters( 'jeg_get_shortcode_width', null, $tag, $attr );

		if ( ! is_null( $width ) ) {
			array_push( $this->width, $width );
		}

		return $return;
	}

	/**
	 * Get current width.
	 *
	 * @return int
	 */
	public function get_current_width() {
		$width = 12;

		if ( ! empty( $this->width ) ) {
			$current_width = 12;

			foreach ( $this->width as $width ) {
				$current_width = $width / 12 * $current_width;
			}

			return ceil( $current_width );
		}

		return apply_filters( 'jeg_get_current_column_width', $width );
	}

	/**
	 * Load Module Option
	 */
	public function load_elements_option() {
		if ( apply_filters( 'jeg_load_element_option', false ) ) {
			$elements = $this->populate_elements();

			foreach ( $elements as $id => $element ) {
				$this->get_element_option( $id );
			}
		}
	}

	/**
	 * Get All Element Options
	 *
	 * @return array
	 */
	public function get_element_options() {
		return $this->options;
	}

	/**
	 * Element Option.
	 * If option not created yet, we need to force creating the instance.
	 *
	 * @param string $id ID of element option.
	 *
	 * @return Elements_Option_Abstract
	 */
	public function get_element_option( $id ) {
		if ( ! isset( $this->options[ $id ] ) ) {
			$elements             = $this->populate_elements();
			$element              = $elements[ $id ];
			$class                = $element['option'];
			$this->options[ $id ] = new $class( $id, $element );
		}

		return $this->options[ $id ];
	}

	/**
	 * Element View Instance.
	 *
	 * @param string $id ID of element option.
	 *
	 * @return Elements_View_Abstract
	 */
	public function get_element_view( $id ) {
		$elements = $this->populate_elements();
		$element  = $elements[ $id ];
		$class    = $element['view'];

		return new $class( $id, $element );
	}

	/**
	 * Return all element registered
	 *
	 * @return array
	 */
	public function populate_elements() {
		return apply_filters( 'jeg_register_elements', array() );
	}

	/**
	 * Render shortcode
	 */
	public function render_shortcode() {
		if ( apply_filters( 'jeg_render_shortcode', false ) ) {
			$class = $this;

			foreach ( $this->populate_elements() as $id => $element ) {
				add_shortcode(
					$id,
					function ( $attr, $content ) use ( $id, $class ) {
						$instance = $class->get_element_view( $id );

						if ( $instance instanceof Elements_View_Abstract ) {
							return $instance->build_element( $attr, $content );
						} else {
							return null;
						}
					}
				);
			}
		}
	}

	/**
	 * Get Column Class
	 *
	 * @return string
	 */
	public function get_column_class() {
		$class_name = 'jeg_col_1o3';
		$width      = $this->get_current_width();

		if ( $width < 6 ) {
			$class_name = 'jeg_col_1o3';
		} elseif ( $width >= 6 && $width <= 8 ) {
			$class_name = 'jeg_col_2o3';
		} elseif ( $width > 8 && $width <= 12 ) {
			$class_name = 'jeg_col_3o3';
		}

		return $class_name;
	}

	/**
	 * Increase Element Count
	 */
	public function increase_element_count() {
		$this->element_count ++;
	}

	/**
	 * Get current element count.
	 *
	 * @return int
	 */
	public function get_element_count() {
		return $this->element_count;
	}

	/**
	 * Get unique array on each group.
	 *
	 * @param string $group Group name.
	 *
	 * @return array|mixed
	 */
	public function get_unique_article( $group ) {
		if ( isset( $this->unique_article[ $group ] ) ) {
			return $this->unique_article[ $group ];
		} else {
			return array();
		}
	}

	/**
	 * Set container width
	 *
	 * @param $width
	 */
	public function set_width( $width ) {
		$this->width = $width;
	}

	/**
	 * Force Set Width
	 *
	 * @param $width
	 */
	public function force_set_width( $width ) {
		$this->set_width( array( $width ) );
	}

	/**
	 * Add Unique article into group.
	 *
	 * @param string        $group Name of group.
	 * @param array|integer $unique Post to add into group.
	 */
	public function add_unique_article( $group, $unique ) {
		if ( ! isset( $this->unique_article[ $group ] ) ) {
			$this->unique_article[ $group ] = array();
		}

		if ( is_array( $unique ) ) {
			$this->unique_article[ $group ] = array_merge( $this->unique_article[ $group ], $unique );
		} else {
			array_push( $this->unique_article[ $group ], $unique );
		}
	}
}
