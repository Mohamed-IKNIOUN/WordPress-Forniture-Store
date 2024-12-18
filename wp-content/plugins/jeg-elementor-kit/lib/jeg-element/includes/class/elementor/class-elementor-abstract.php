<?php
/**
 * Jeg News Element Widget Abstract
 *
 * @package jeg-news-element
 *
 * @author Jegstudio
 *
 * @since 1.0.0
 */

namespace Jeg\Element\Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Jeg\Element\Element;
use Jeg\Element\Elements\Elements_Option_Abstract;

/**
 * Class Widget_Abstract
 *
 * @package Jeg\Element\Widget
 */
abstract class Elementor_Abstract extends Widget_Base {
	/**
	 * Get element name.
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->get_elementor_id();
	}

	/**
	 * Get ID of this widget
	 *
	 * @return string
	 */
	abstract public function get_elementor_id();

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return $this->get_elementor_id();
	}

	/**
	 * Get element title.
	 *
	 * @return string Element title.
	 */
	public function get_title() {
		return $this->get_option_instance()->get_element_name();
	}

	/**
	 * Get Element Option Instance
	 *
	 * @return Elements_Option_Abstract
	 */
	public function get_option_instance() {
		return Element::instance()->manager->get_element_option( $this->get_elementor_id() );
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		$category = $this->get_option_instance()->get_category();

		return array( jeg_slug_category( $category ) );
	}

	/**
	 * Whether the reload preview is required.
	 *
	 * @return bool Whether the reload preview is required.
	 */
	public function is_reload_preview_required() {
		return true;
	}

	/**
	 * Register controls.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$instance = $this->get_option_instance();
		$this->build_option( $instance->get_segments(), $instance->get_options() );
	}

	/**
	 * Build Element Option for Elementor
	 *
	 * @param array $segments Collection of group / segment.
	 * @param array $options  Collection of control field.
	 */
	public function build_option( $segments, $options ) {
		$segments = jeg_sort_segment( $segments );

		foreach ( $segments as $segment ) {
			if ( 'design' === $segment['id'] ) {
				$section = array(
					'label' => esc_html__( 'Style', 'jeg-elementor-kit' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				);
			} elseif ( 'content-filter' === $segment['id'] ) {
				$section = array(
					'label' => esc_html__( 'Setting', 'jeg-elementor-kit' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				);
			} else {
				$section = array(
					'label' => $segment['name'],
					'tab'   => Controls_Manager::TAB_CONTENT,
				);
			}

			$this->start_controls_section( $segment['id'], $section );
			$this->parse_control_option( $options, $segment['id'] );
			$this->parse_typography_control_option( $segment['id'] );
			$this->end_controls_section();
		}
	}

	/**
	 * Create control
	 *
	 * @param array  $options          Collection of control field.
	 * @param string $segment          Segment ID.
	 * @param bool   $repeater_options Repeater Check.
	 */
	public function parse_control_option( $options, $segment, $repeater_options = false ) {
		$repeater = new Repeater();

		foreach ( $options as $id => $option ) {
			if ( $option['segment'] === $segment ) {
				switch ( $option['type'] ) {
					case 'textarea':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::TEXTAREA,
							'default'     => isset( $option['default'] ) ? $option['default'] : 0,
							'label_block' => true,
							'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
							'description' => isset( $option['description'] ) ? $option['description'] : '',
						);

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;
					case 'color':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::COLOR,
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
							'description' => isset( $option['description'] ) ? $option['description'] : '',
						);

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;
					case 'radioimage':
						// Todo: need to test.
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::CHOOSE,
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'options'     => $this->parse_radioimage_option( $option['options'], $id ),
							'label_block' => true,
							'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
							'description' => isset( $option['description'] ) ? $option['description'] : '',
						);

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;
					case 'image':
					case 'attach_image':
						$multiple = isset( $option['multiple'] ) ? $option['multiple'] : 1;

						if ( 1 === $multiple ) {
							$args = array(
								'label'       => $option['title'],
								'type'        => Controls_Manager::MEDIA,
								'default'     => array(
									'url' => isset( $option['default'] ) ? $option['default'] : '',
								),
								'label_block' => true,
								'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
								'description' => isset( $option['description'] ) ? $option['description'] : '',
							);
						} else {
							$args = array(
								'label'       => $option['title'],
								'type'        => Controls_Manager::GALLERY,
								'default'     => isset( $option['default'] ) ? $option['default'] : array(),
								'label_block' => true,
								'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
								'description' => isset( $option['description'] ) ? $option['description'] : '',
							);
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;
					case 'checkbox':
						$default = isset( $option['default'] ) ? $option['default'] : 0;

						if ( $default ) {
							$default = 'yes';
						}

						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::SWITCHER,
							'default'     => $default,
							'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
							'description' => isset( $option['description'] ) ? $option['description'] : '',
						);

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;
					case 'slider':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::SLIDER,
							'default'     => array(
								'size' => isset( $option['default'] ) ? $option['default'] : 0,
							),
							'range'       => array(
								'px' => array(
									'min'  => $option['options']['min'],
									'max'  => $option['options']['max'],
									'step' => $option['options']['step'],
								),
							),
							'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
							'description' => isset( $option['description'] ) ? $option['description'] : '',
						);

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;
					case 'number':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::NUMBER,
							'default'     => isset( $option['default'] ) ? $option['default'] : 0,
							'min'         => $option['options']['min'],
							'max'         => $option['options']['max'],
							'step'        => $option['options']['step'],
							'label_block' => true,
							'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
							'description' => isset( $option['description'] ) ? $option['description'] : '',
						);

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;
					case 'html':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::CODE,
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'language'    => 'html',
							'label_block' => true,
							'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
							'description' => isset( $option['description'] ) ? $option['description'] : '',
						);

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;
					case 'alert':
						$args = array(
							'label'       => $option['title'],
							'type'        => 'alert',
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'label_block' => true,
							'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
							'description' => isset( $option['description'] ) ? $option['description'] : '',
						);

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;
					case 'iconpicker':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::ICON,
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'label_block' => true,
							'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
							'description' => isset( $option['description'] ) ? $option['description'] : '',
						);

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;
					case 'repeater':
						$args = array(
							'label'   => $option['title'],
							'type'    => Controls_Manager::REPEATER,
							'fields'  => $this->parse_control_option( $option['fields'], $id, true ),
							'default' => isset( $option['default'] ) ? $option['default'] : array(),
						);

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;
					case 'select':
						$options  = jeg_field_select_option( $option );
						$multiple = isset( $option['multiple'] ) ? $option['multiple'] : 1;

						if ( ! isset( $option['ajax'] ) && 1 === $multiple ) {
							$args = array(
								'label'       => $option['title'],
								'type'        => Controls_Manager::SELECT,
								'default'     => isset( $option['default'] ) ? $option['default'] : '',
								'options'     => $options,
								'label_block' => true,
								'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
								'description' => isset( $option['description'] ) ? $option['description'] : '',
							);
						} else {
							if ( isset( $option['options'] ) && 'jeg_get_custom_term_option' === $option['options'] ) {
								$options = call_user_func_array( $option['options'], array( '', $option['slug'] ) );
							}

							$args = array(
								'label'       => $option['title'],
								'type'        => 'dynamic-select',
								'default'     => isset( $option['default'] ) ? $option['default'] : '',
								'label_block' => true,
								'multiple'    => $multiple,
								'ajax'        => isset( $option['ajax'] ) ? $option['ajax'] : '',
								'slug'        => isset( $option['slug'] ) ? $option['slug'] : '',
								'nonce'       => isset( $option['nonce'] ) ? $option['nonce'] : '',
								'retriever'   => isset( $option['options'] ) ? $option['options'] : '',
								'options'     => wp_json_encode( $options ),
								'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
								'description' => isset( $option['description'] ) ? $option['description'] : '',
							);
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;
					default:
						$args          = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::TEXT,
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'label_block' => true,
							'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
							'description' => isset( $option['description'] ) ? $option['description'] : '',
						);
						$custom_option = apply_filters( 'jeg_custom_control_elementor', array() );

						if ( ! empty( $custom_option ) ) {
							foreach ( $custom_option as $type ) {
								if ( $option['type'] === $type ) {
									$args = array(
										'label'       => $option['title'],
										'type'        => $type,
										'default'     => isset( $option['default'] ) ? $option['default'] : '',
										'label_block' => true,
										'condition'   => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
										'description' => isset( $option['description'] ) ? $option['description'] : '',
									);

									if ( isset( $option['nonce'] ) ) {
										$args['nonce'] = $option['nonce'];
									}

									if ( isset( $option['ajax'] ) ) {
										$args['ajax'] = $option['ajax'];
									}

									if ( $repeater_options ) {
										$repeater->add_control( $id, $args );
									} else {
										$this->add_control( $id, $args );
									}

									$args = array();
								}
							}
						}

						if ( ! empty( $args ) ) {
							if ( $repeater_options ) {
								$repeater->add_control( $id, $args );
							} else {
								$this->add_control( $id, $args );
							}
						}

						break;
				}
			}
		}

		if ( $repeater_options ) {
			return $repeater->get_controls();
		}
	}

	/**
	 * Make dependency fit with elementor
	 *
	 * @param  array $dependency Dependency.
	 * @return array
	 */
	public function parse_dependency_option( $dependency ) {
		$dependencies = array();

		foreach ( $dependency as $depend ) {
			$value                            = true === $depend['value'] ? 'yes' : $depend['value'];
			$dependencies[ $depend['field'] ] = $value;
		}

		return $dependencies;
	}

	/**
	 * Radio Image option for Elementor
	 *
	 * @param  array  $options Array of option.
	 * @param  string $param   Parameter name.
	 * @return array
	 */
	public function parse_radioimage_option( $options, $param ) {
		$new_value = array();

		foreach ( $options as $key => $item ) {
			$new_value[ $key ] = array(
				'icon' => $param,
			);
		}

		return $new_value;
	}

	/**
	 * @param $group
	 */
	private function parse_typography_control_option( $group ) {
		if ( 'design' === $group ) {
			$this->get_option_instance()->set_typography_option( $this );
		}
	}

	/**
	 * Render Element
	 */
	protected function render() {
		$settings = $this->get_parsed_dynamic_settings();

		echo ( $this->get_view_instance()->build_element( $settings ) );
	}

	/**
	 * Get Element View Instance
	 *
	 * @return \Jeg\Element\Elements\Elements_View_Abstract
	 */
	public function get_view_instance() {
		return Element::instance()->manager->get_element_view( $this->get_elementor_id() );
	}
}
