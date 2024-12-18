<?php
/**
 * Divi Builder Abstract Class
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Divi;

use Jeg\Element\Element;
use Jeg\Element\Elements\Elements_Option_Abstract;
use Jeg\Element\Elements\Elements_View_Abstract;

/**
 * Class Beaver_Builder_Abstract
 *
 * @package Jeg\Element\Beaver
 */
abstract class Divi_Builder_Abstract extends \ET_Builder_Module {
	/**
	 * Declaring fully compatible with Divi
	 *
	 * @var string
	 */
	public $vb_support = 'partial';

	/**
	 * Module Credits
	 *
	 * @var array
	 */
	protected $module_credits = array(
		'module_uri' => 'https://support.jegtheme.com/',
		'author'     => 'Jegtheme',
		'author_uri' => 'https://support.jegtheme.com/',
	);

	/**
	 * Initial constructor.
	 */
	public function init() {
		$instance   = $this->get_option_instance();
		$this->name = $instance->get_element_name();
		$this->slug = $this->get_divi_id();
	}

	/**
	 * Get Element Option Instance
	 *
	 * @return Elements_Option_Abstract
	 */
	public function get_option_instance() {
		return Element::instance()->manager->get_element_option( $this->get_divi_id() );
	}

	/**
	 * Get element view instance
	 *
	 * @return Elements_View_Abstract
	 */
	public function get_view_instance() {
		return Element::instance()->manager->get_element_view( $this->get_divi_id() );
	}

	/**
	 * Prepare field to divi format
	 * - alert
	 * - iconpicker
	 * - radioimage (Partial)
	 * - Dynamic (Partial)
	 *
	 * @param string $key Option ID.
	 * @param array  $option Divi Field Format.
	 *
	 * @return array
	 */
	public function prepare_field( $key, $option ) {
		$setting = array();

		// Ignore this option and return empty array.
		if ( 'el_id' === $key || 'el_class' === $key ) {
			return $setting;
		}

		switch ( $option['type'] ) {
			case 'alert':
				$setting = array(
					'type'        => 'warning',
					'label'       => $option['title'],
					'tab_slug'    => $this->get_segment( $option['segment'] ),
					'description' => isset( $option['description'] ) ? $option['description'] : '',
					'default'     => isset( $option['default'] ) ? $option['default'] : '',
				);
				break;
			case 'checkbox':
				$setting = array(
					'type'        => 'yes_no_button',
					'label'       => $option['title'],
					'tab_slug'    => $this->get_segment( $option['segment'] ),
					'description' => isset( $option['description'] ) ? $option['description'] : '',
					'default'     => isset( $option['default'] ) ? $option['default'] : '',
					'options'     => array(
						'on'  => esc_html__( 'Yes', 'jeg-elementor-kit' ),
						'off' => esc_html__( 'No', 'jeg-elementor-kit' ),
					),
				);
				break;
			case 'slider':
				$setting = array(
					'type'           => 'range',
					'label'          => $option['title'],
					'tab_slug'       => $this->get_segment( $option['segment'] ),
					'range_settings' => $option['options'],
					'description'    => isset( $option['description'] ) ? $option['description'] : '',
					'default'        => isset( $option['default'] ) ? $option['default'] : '',
				);
				break;
			case 'number':
				$setting = array(
					'type'           => 'number',
					'label'          => $option['title'],
					'tab_slug'       => $this->get_segment( $option['segment'] ),
					'range_settings' => $option['options'],
					'description'    => isset( $option['description'] ) ? $option['description'] : '',
					'default'        => isset( $option['default'] ) ? $option['default'] : '',
				);
				break;
			case 'radioimage':
				$options = $this->radio_image_option( $option );

				$setting = array(
					'type'        => 'select',
					'label'       => $option['title'],
					'tab_slug'    => $this->get_segment( $option['segment'] ),
					'options'     => $options,
					'description' => isset( $option['description'] ) ? $option['description'] : '',
					'default'     => isset( $option['default'] ) ? $option['default'] : '',
				);
				break;
			case 'select':
				$options  = jeg_field_select_option( $option );
				$multiple = isset( $option['multiple'] ) ? $option['multiple'] : 1;

				if ( ! isset( $option['ajax'] ) && 1 === $multiple ) {
					$setting = array(
						'type'        => 'select',
						'label'       => $option['title'],
						'tab_slug'    => $this->get_segment( $option['segment'] ),
						'options'     => $options,
						'description' => isset( $option['description'] ) ? $option['description'] : '',
						'default'     => isset( $option['default'] ) ? $option['default'] : '',
					);
				} else {
					$setting = array(
						'type'        => 'text',
						'label'       => $option['title'],
						'tab_slug'    => $this->get_segment( $option['segment'] ),
						'description' => isset( $option['description'] ) ? $option['description'] : '',
						'default'     => isset( $option['default'] ) ? $option['default'] : '',
					);
				}
				break;
			case 'color':
				$setting = array(
					'type'        => 'color-alpha',
					'label'       => $option['title'],
					'tab_slug'    => $this->get_segment( $option['segment'] ),
					'description' => isset( $option['description'] ) ? $option['description'] : '',
					'default'     => isset( $option['default'] ) ? $option['default'] : '',
				);
				break;
			case 'html':
				$setting = array(
					'type'        => 'tiny_mce',
					'label'       => $option['title'],
					'tab_slug'    => $this->get_segment( $option['segment'] ),
					'description' => isset( $option['description'] ) ? $option['description'] : '',
					'default'     => isset( $option['default'] ) ? $option['default'] : '',
				);
				break;
			case 'textarea':
				$setting = array(
					'type'        => 'textarea',
					'label'       => $option['title'],
					'tab_slug'    => $this->get_segment( $option['segment'] ),
					'description' => isset( $option['description'] ) ? $option['description'] : '',
					'default'     => isset( $option['default'] ) ? $option['default'] : '',
				);
				break;
			case 'image':
			case 'attach_image':
				$setting = array(
					'type'        => 'upload',
					'data_type'   => 'image',
					'label'       => $option['title'],
					'tab_slug'    => $this->get_segment( $option['segment'] ),
					'description' => isset( $option['description'] ) ? $option['description'] : '',
					'default'     => isset( $option['default'] ) ? $option['default'] : '',
				);
				break;
			default:
				$setting = array(
					'type'        => 'text',
					'label'       => $option['title'],
					'tab_slug'    => $this->get_segment( $option['segment'] ),
					'description' => isset( $option['description'] ) ? $option['description'] : '',
					'default'     => isset( $option['default'] ) ? $option['default'] : '',
				);
		}

		if ( isset( $option['dependency'] ) ) {
			foreach ( $option['dependency'] as $dependency ) {
				$value = $dependency['value'];

				if ( is_bool( $value ) ) {
					$value = ( $value ) ? 'on' : 'off';
				}

				if ( '===' === $dependency['operator'] || '==' === $dependency['operator'] || 'in' === $dependency['operator'] || 'contains' === $dependency['operator'] ) {
					$setting['show_if'] = array(
						$dependency['field'] => $value,
					);
				}

				if ( '!=' === $dependency['operator'] || 'not equal' === $dependency['operator'] ) {
					$setting['show_if_not'] = array(
						$dependency['field'] => $value,
					);
				}
			}
		}

		return $setting;
	}

	/**
	 * Radio image option
	 *
	 * @param array $field Field Detail.
	 *
	 * @return array
	 */
	public function radio_image_option( $field ) {
		$options = $field['options'];
		$option  = array();

		foreach ( $options as $key => $value ) {
			$name = str_replace( '_', ' ', $key );
			$name = ucfirst( $name );

			$option[ $key ] = $name;
		}

		return $option;
	}

	/**
	 * Field of builder
	 */
	public function get_fields() {
		$options = $this->get_option_instance()->get_options();
		$fields  = array();

		foreach ( $options as $key => $option ) {
			$setting = $this->prepare_field( $key, $option );
			if ( ! empty( $setting ) ) {
				$fields[ $key ] = $setting;
			}
		}

		return $fields;
	}

	/**
	 * Get field segment
	 *
	 * @param string $segment Name of segment.
	 *
	 * @return string
	 */
	public function get_segment( $segment ) {
		if ( 'design' === $segment ) {
			return 'advanced';
		}

		return $segment;
	}


	/**
	 * Get Main Tabs
	 *
	 * @return array
	 */
	public function get_main_tabs() {
		$tabs       = parent::get_main_tabs();
		$segments   = jeg_sort_segment( $this->get_option_instance()->get_segments() );
		$additional = array();

		if ( isset( $tabs['general'] ) ) {
			$additional['general'] = $tabs['general'];
			unset( $tabs['general'] );
		}

		foreach ( $segments as $segment ) {
			$additional[ $segment['id'] ] = $segment['name'];
		}

		return array_merge( $additional, $tabs );
	}

	/**
	 * Option Segment
	 *
	 * @param string $segment Match segment with our item.
	 *
	 * @return string
	 */
	public function get_option_segment( $segment ) {
		return $segment;
	}

	/**
	 * Render Element
	 *
	 * @param array  $attr List of unprocessed attributes.
	 * @param string $content Content being processed.
	 * @param string $render_slug Slug of module that is used for rendering output.
	 *
	 * @return string The module's HTML output.
	 */
	public function render( $attr, $content = null, $render_slug ) {
		$attr['el_id']    = isset( $attr['module_id'] ) ? $attr['module_id'] : '';
		$attr['el_class'] = isset( $attr['module_class'] ) ? $attr['module_class'] : '';

		if ( $this->classname && is_array( $this->classname ) ) {
			$attr['el_class'] = $attr['el_class'] . ' ' . implode( ' ', $this->classname );
		}

		return $this->get_view_instance()->build_element( $attr );
	}


	/**
	 * Shortcode Callback for Divi Builder.
	 *
	 * @param array  $atts List of Attribute.
	 * @param string $content Shortcode Content.
	 * @param string $function_name Function Name.
	 */
	public function shortcode_callback( $atts, $content = null, $function_name ) {

	}

	/**
	 * Get ID of this Element
	 *
	 * @return string
	 */
	abstract public function get_divi_id();
}
