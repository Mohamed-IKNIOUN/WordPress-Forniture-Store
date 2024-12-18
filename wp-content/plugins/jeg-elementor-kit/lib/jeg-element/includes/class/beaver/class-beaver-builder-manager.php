<?php
/**
 * Beaver Manager
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Beaver;

use Jeg\Element\Element;
use Jeg\Element\Elements\Elements_Option_Abstract;

/**
 * Class Elementor_Abstract
 *
 * @package Jeg\Element\Elementor
 */
class Beaver_Builder_Manager {
	/**
	 * Beaver_Builder_Manager constructor.
	 */
	public function __construct() {
		add_filter( 'init', array( $this, 'register_module' ) );
		add_filter( 'fl_builder_render_module_content', array( $this, 'module_content' ), null, 2 );
		add_action( 'fl_builder_custom_fields', array( $this, 'custom_fields' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'custom_field_scripts' ) );
		add_filter( 'jeg_widget_backend_script', array( $this, 'widget_backend_script_load' ) );
	}

	/**
	 * Check if Beaver Builder Active
	 *
	 * @return bool
	 */
	private function is_fl_builder_active() {
		return isset( $_GET['fl_builder'] ) || isset( $post_data['fl_builder'] );
	}

	/**
	 * Render Backend Script
	 *
	 * @param boolean $flag Flag for loading backend script.
	 *
	 * @return bool
	 */
	public function widget_backend_script_load( $flag ) {
		if ( $this->is_fl_builder_active() ) {
			return true;
		}

		return $flag;
	}

	/**
	 * Custom Field Script
	 */
	public function custom_field_scripts() {
		if ( class_exists( 'FLBuilderModel' ) && \FLBuilderModel::is_builder_active() ) {
			wp_enqueue_style( 'jeg-beaver', JEG_ELEMENT_URL . '/assets/css/beaver-builder.css', null, JEG_ELEMENT_VERSION );
			wp_enqueue_script( 'jeg-elementor', JEG_ELEMENT_URL . '/assets/js/elementor/elementor-control-select.js', null, JEG_ELEMENT_VERSION, true );
			wp_enqueue_script( 'jeg-beaver', JEG_ELEMENT_URL . '/assets/js/beaver-builder/beaver-builder.js', null, JEG_ELEMENT_VERSION, true );
		}
	}

	/**
	 * Register Beaver Builder module
	 */
	public function register_module() {
		$elements = Element::instance()->manager->populate_elements();

		foreach ( $elements as $key => $element ) {
			if ( isset( $element['beaver'] ) ) {
				$options = Element::instance()->manager->get_element_option( $key );
				\FLBuilder::register_module( $element['beaver'], $this->prepare_option( $options ) );
			}
		}
	}

	/**
	 * Additional Custom Control
	 *
	 * @param array $fields Array of control.
	 *
	 * @return array
	 */
	public function custom_fields( $fields ) {
		$fields['toggle']     = JEG_ELEMENT_DIR . '/includes/class/beaver/control/toggle.php';
		$fields['slider']     = JEG_ELEMENT_DIR . '/includes/class/beaver/control/slider.php';
		$fields['number']     = JEG_ELEMENT_DIR . '/includes/class/beaver/control/number.php';
		$fields['alert']      = JEG_ELEMENT_DIR . '/includes/class/beaver/control/alert.php';
		$fields['dynamic']    = JEG_ELEMENT_DIR . '/includes/class/beaver/control/dynamic-select.php';
		$fields['radioimage'] = JEG_ELEMENT_DIR . '/includes/class/beaver/control/radio-image.php';

		return $fields;
	}

	/**
	 * Get Toogle Content for Element
	 *
	 * @param string $id ID of element.
	 * @param array  $fields Field content.
	 *
	 * @return array
	 */
	public function get_toggle_select_content( $id, $fields ) {
		$toggles = array();

		foreach ( $fields as $key => $field ) {
			if ( isset( $field['dependency'] ) ) {
				foreach ( $field['dependency'] as $dependency ) {
					if ( $dependency['field'] === $id ) {

						if ( '===' === $dependency['operator'] || '==' === $dependency['operator'] ) {
							if ( is_array( $dependency['value'] ) ) {
								foreach ( $dependency['value'] as $value ) {
									if ( ! isset( $toggles[ $value ] ) ) {
										$toggles[ $value ]           = array();
										$toggles[ $value ]['fields'] = array();
									}

									$toggles[ $value ]['fields'][] = $key;
								}
							} else {
								if ( ! isset( $toggles[ $dependency['value'] ] ) ) {
									$toggles[ $dependency['value'] ]           = array();
									$toggles[ $dependency['value'] ]['fields'] = array();
								}

								$toggles[ $dependency['value'] ]['fields'][] = $key;
							}
						}

						if ( 'in' === $dependency['operator'] ) {
							foreach ( $dependency['value'] as $value ) {
								if ( ! isset( $toggles[ $value ] ) ) {
									$toggles[ $value ]           = array();
									$toggles[ $value ]['fields'] = array();
								}

								$toggles[ $value ]['fields'][] = $key;
							}
						}
					}
				}
			}
		}

		return $toggles;
	}

	/**
	 * Get Toogle Content for Element
	 *
	 * @param string $id ID of element.
	 * @param array  $fields Field content.
	 *
	 * @return array
	 */
	public function get_toggle_checkbox_content( $id, $fields ) {
		$toggles = array();

		foreach ( $fields as $key => $field ) {
			if ( isset( $field['dependency'] ) ) {
				foreach ( $field['dependency'] as $dependency ) {
					if ( $dependency['field'] === $id ) {
						$state = $dependency['value'] ? '1' : '0';

						if ( isset( $toggles[ $state ] ) ) {
							$toggles[ $state ]           = array();
							$toggles[ $state ]['fields'] = array();
						}

						$toggles[ $state ]['fields'][] = $key;
					}
				}
			}
		}

		return $toggles;
	}

	/**
	 * Prepare field for beaver segment.
	 * Todo: Kurang dependency untuk Radio Image
	 *
	 * @param array  $fields Array of options.
	 * @param string $segment Name of segment need to be filtered.
	 *
	 * @return array
	 */
	public function prepare_field( $fields, $segment ) {
		$settings = array();

		foreach ( $fields as $id => $option ) {
			if ( $option['segment'] === $segment ) {
				switch ( $option['type'] ) {
					case 'textarea':
						$settings[ $id ] = array(
							'type'    => 'textarea',
							'label'   => $option['title'],
							'default' => isset( $option['default'] ) ? $option['default'] : '',
							'rows'    => '6',
							'help'    => isset( $option['description'] ) ? $option['description'] : '',
						);
						break;
					case 'color':
						$settings[ $id ] = array(
							'type'       => 'color',
							'label'      => $option['title'],
							'default'    => isset( $option['default'] ) ? $option['default'] : '',
							'show_reset' => true,
							'show_alpha' => true,
							'help'       => isset( $option['description'] ) ? $option['description'] : '',
						);
						break;
					case 'html':
						$settings[ $id ] = array(
							'type'    => 'code',
							'label'   => $option['title'],
							'default' => isset( $option['default'] ) ? $option['default'] : '',
							'editor'  => 'html',
							'rows'    => '18',
							'help'    => isset( $option['description'] ) ? $option['description'] : '',
						);
						break;
					case 'select':
						$multiple = isset( $option['multiple'] ) ? $option['multiple'] : 1;
						$toggle   = $this->get_toggle_select_content( $id, $fields );

						if ( isset( $option['options'] ) && 'jeg_get_custom_term_option' === $option['options'] ) {
							$options = call_user_func_array( $option['options'], array( '', $option['slug'] ) );
						} else {
							$options = jeg_field_select_option( $option );
						}

						if ( ! isset( $option['ajax'] ) && 1 === $multiple ) {
							$settings[ $id ] = array(
								'type'    => 'select',
								'label'   => $option['title'],
								'default' => isset( $option['default'] ) ? $option['default'] : '',
								'options' => $option['options'],
								'help'    => isset( $option['description'] ) ? $option['description'] : '',
							);
						} else {
							$settings[ $id ] = array(
								'type'      => 'dynamic',
								'label'     => $option['title'],
								'default'   => isset( $option['default'] ) ? $option['default'] : '',
								'options'   => wp_json_encode( $options ),
								'multi'     => $multiple,
								'ajax'      => isset( $option['ajax'] ) ? $option['ajax'] : '',
								'nonce'     => isset( $option['nonce'] ) ? $option['nonce'] : '',
								'retriever' => isset( $option['options'] ) ? $option['options'] : '',
								'help'      => isset( $option['description'] ) ? $option['description'] : '',
							);
						}

						if ( ! empty( $toggle ) ) {
							$settings[ $id ]['toggle'] = $toggle;
						}
						break;
					case 'iconpicker':
						$settings[ $id ] = array(
							'type'        => 'icon',
							'label'       => $option['title'],
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'show_remove' => true,
							'help'        => isset( $option['description'] ) ? $option['description'] : '',
						);
						break;
					case 'image':
					case 'attach_image':
						$settings[ $id ] = array(
							'type'        => 'photo',
							'label'       => $option['title'],
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'show_remove' => true,
							'help'        => isset( $option['description'] ) ? $option['description'] : '',
						);
						break;
					case 'checkbox':
						$toggle = $this->get_toggle_checkbox_content( $id, $fields );

						$settings[ $id ] = array(
							'type'    => 'toggle',
							'label'   => $option['title'],
							'default' => isset( $option['default'] ) ? $option['default'] : '',
							'help'    => isset( $option['description'] ) ? $option['description'] : '',
						);

						if ( ! empty( $toggle ) ) {
							$settings[ $id ]['toggle'] = $toggle;
						}
						break;
					case 'slider':
						$settings[ $id ] = array(
							'type'    => 'slider',
							'label'   => $option['title'],
							'default' => isset( $option['default'] ) ? $option['default'] : '',
							'options' => $option['options'],
							'help'    => isset( $option['description'] ) ? $option['description'] : '',
						);
						break;
					case 'number':
						$settings[ $id ] = array(
							'type'    => 'number',
							'label'   => $option['title'],
							'default' => isset( $option['default'] ) ? $option['default'] : '',
							'options' => $option['options'],
							'help'    => isset( $option['description'] ) ? $option['description'] : '',
						);
						break;
					case 'alert':
						$settings[ $id ] = array(
							'type'    => 'alert',
							'label'   => $option['title'],
							'default' => isset( $option['default'] ) ? $option['default'] : '',
							'help'    => isset( $option['description'] ) ? $option['description'] : '',
						);
						break;
					case 'radioimage':
						$settings[ $id ] = array(
							'type'    => 'radioimage',
							'label'   => $option['title'],
							'default' => isset( $option['default'] ) ? $option['default'] : '',
							'options' => $option['options'],
							'help'    => isset( $option['description'] ) ? $option['description'] : '',
						);
						break;
					default:
						$settings[ $id ] = array(
							'type'      => 'text',
							'label'     => $option['title'],
							'default'   => isset( $option['default'] ) ? $option['default'] : '',
							'maxlength' => '9999',
							'help'      => isset( $option['description'] ) ? $option['description'] : '',
						);

				}
			}
		}

		return $settings;
	}

	/**
	 * Prepare option to Beaver Builder Format
	 *
	 * @param Elements_Option_Abstract $options Array of options.
	 *
	 * @return array
	 */
	public function prepare_option( $options ) {
		$fields   = $options->get_options();
		$segments = jeg_sort_segment( $options->get_segments() );
		$settings = array();

		foreach ( $segments as $key => $segment ) {
			$settings[ $segment['id'] ] = array(
				'title'    => $segment['name'],
				'sections' => array(
					'general' => array(
						'title'  => '',
						'fields' => $this->prepare_field( $fields, $segment['id'] ),
					),
				),
			);
		}

		return $settings;
	}

	/**
	 * Render Module Content
	 *
	 * @param string                  $out Output rendered by frontend.
	 * @param Beaver_Builder_Abstract $module Module Instance.
	 *
	 * @return mixed
	 */
	public function module_content( $out, $module ) {
		if ( $module instanceof Beaver_Builder_Abstract ) {
			$view     = Element::instance()->manager->get_element_view( $module->get_beaver_id() );
			$settings = $module->settings;

			return $view->build_element( (array) $settings );
		}

		return $out;
	}
}
