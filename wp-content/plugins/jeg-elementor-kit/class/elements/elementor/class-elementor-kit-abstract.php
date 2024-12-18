<?php
/**
 * Elements Elementor Abstract Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_control_Text_Stroke;
use Elementor\Repeater;
use Jeg\Element\Elementor\Elementor_Abstract;

/**
 * Class Elementor_Kit_Abstract
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Elementor_Kit_Abstract extends Elementor_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_abstract';
	}

	/**
	 * Override Build Element Option for Elementor from jeg-element
	 *
	 * @param array $segments Collection of group / segment.
	 * @param array $options  Collection of control field.
	 */
	public function build_option( $segments, $options ) {
		$settings  = jeg_sort_segment( $segments );
		$kit_style = array();

		foreach ( $settings as $key => $setting ) {
			if ( isset( $setting['kit_style'] ) && $setting['kit_style'] ) {
				array_push( $kit_style, $setting );
			}
		}

		foreach ( $kit_style as $style ) {
			unset( $segments[ $style['id'] ] );
		}

		parent::build_option( $segments, $options );

		foreach ( $kit_style as $style ) {
			$section = array(
				'label'     => $style['name'],
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => isset( $style['dependency'] ) ? $this->parse_dependency_option( $style['dependency'] ) : '',
			);

			$this->start_controls_section( $style['id'], $section );
			$this->parse_control_option( $options, $style['id'] );
			$this->end_controls_section();
		}
	}

	/**
	 * Override create control from jeg-element to add more options
	 *
	 * @param array  $options          Collection of control field.
	 * @param string $segment          Segment ID.
	 * @param bool   $repeater_options Repeater Check.
	 */
	public function parse_control_option( $options, $segment, $repeater_options = false ) {
		$repeater = new Repeater();

		/**
		 * Control Options Filter
		 *
		 * @since 2.6.2
		 */
		$options = apply_filters( 'jkit_parse_control_option', $options, $segment, $repeater_options );

		foreach ( $options as $id => $option ) {
			if ( $option['segment'] === $segment ) {
				switch ( $option['type'] ) {
					case 'control_tabs_start':
						$args = array();

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->start_controls_tabs( $id, $args );
						} else {
							$this->start_controls_tabs( $id, $args );
						}

						break;

					case 'control_tab_start':
						$args = array(
							'label' => $option['title'],
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->start_controls_tab( $id, $args );
						} else {
							$this->start_controls_tab( $id, $args );
						}

						break;

					case 'control_tabs_end':
						if ( $repeater_options ) {
							$repeater->end_controls_tabs();
						} else {
							$this->end_controls_tabs();
						}

						break;

					case 'control_tab_end':
						if ( $repeater_options ) {
							$repeater->end_controls_tab();
						} else {
							$this->end_controls_tab();
						}

						break;

					case 'textarea':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::TEXTAREA,
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'label_block' => true,
							'description' => isset( $option['description'] ) ? $option['description'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						$args['dynamic']['active'] = true;

						if ( isset( $option['dynamic'] ) ) {
							$args['dynamic']['active'] = $option['dynamic'];
						}

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

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
							'description' => isset( $option['description'] ) ? $option['description'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['selectors'] ) ) {
							$attr              = isset( $option['attribute'] ) ? $option['attribute'] : 'color';
							$args['selectors'] = isset( $option['selectors']['custom'] ) ? $option['selectors']['custom'] : array( '{{WRAPPER}} ' . $option['selectors'] => $attr . ': {{VALUE}};' );
						}

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( isset( $option['render_type'] ) ) {
							$args['render_type'] = $option['render_type'];
						}

						if ( isset( $option['frontend_available'] ) ) {
							$args['frontend_available'] = $option['frontend_available'];
						}

						if ( isset( $option['global'] ) ) {
							$args['global'] = $option['global'];
						}

						if ( $repeater_options ) {
							if ( isset( $option['responsive'] ) && $option['responsive'] ) {
								$repeater->add_responsive_control( $id . '_responsive', $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
							} else {
								$repeater->add_control( $id, $args );
							}
						} elseif ( isset( $option['responsive'] ) && $option['responsive'] ) {
								$default_value = isset( $option['default'] ) ? $option['default'] : '';

								$args['desktop_default'] = $default_value;

							foreach ( jkit_get_responsive_breakpoints() as $breakpoint ) {
								if ( isset( $option[ $breakpoint['key'] . '_default' ] ) ) {
									$args[ $breakpoint['key'] . '_default' ] = $option[ $breakpoint['key'] . '_default' ];
								}
							}

								$this->add_responsive_control( $id . '_responsive', $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'radioimage':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::CHOOSE,
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'options'     => $this->parse_radioimage_option( $option['options'], $id ),
							'label_block' => true,
							'description' => isset( $option['description'] ) ? $option['description'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'image':
					case 'attach_image':
					case 'attach_media':
						$multiple = isset( $option['multiple'] ) ? $option['multiple'] : 1;

						if ( 1 === $multiple ) {
							$args = array(
								'label'       => $option['title'],
								'type'        => Controls_Manager::MEDIA,
								'default'     => array(
									'url' => isset( $option['default'] ) ? $option['default'] : '',
								),
								'label_block' => true,
								'description' => isset( $option['description'] ) ? $option['description'] : '',
								'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
								'media_types' => isset( $option['media_types'] ) ? $option['media_types'] : array( 'image' ),
							);
						} else {
							$args = array(
								'label'       => $option['title'],
								'type'        => Controls_Manager::GALLERY,
								'default'     => isset( $option['default'] ) ? $option['default'] : array(),
								'label_block' => true,
								'description' => isset( $option['description'] ) ? $option['description'] : '',
								'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
							);
						}

						$args['dynamic']['active'] = true;

						if ( isset( $option['dynamic'] ) ) {
							$args['dynamic']['active'] = $option['dynamic'];
						}

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
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
							'description' => isset( $option['description'] ) ? $option['description'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['return_value'] ) ) {
							$args['return_value'] = $option['return_value'];
						}

						if ( isset( $option['selectors'] ) && ( isset( $option['attribute'] ) || isset( $option['selectors']['custom'] ) ) ) {
							$args['selectors'] = isset( $option['selectors']['custom'] ) ? $option['selectors']['custom'] : array( '{{WRAPPER}} ' . $option['selectors'] => $option['attribute'] . ': {{SIZE}}{{UNIT}};' );
						}

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( isset( $option['prefix_class'] ) ) {
							$args['prefix_class'] = $option['prefix_class'];
						}

						if ( isset( $option['render_type'] ) ) {
							$args['render_type'] = $option['render_type'];
						}

						if ( isset( $option['frontend_available'] ) ) {
							$args['frontend_available'] = $option['frontend_available'];
						}

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
							'size_units'  => isset( $option['units'] ) ? $option['units'] : array( 'px' ),
							'default'     => array(
								'unit' => isset( $option['default_unit'] ) ? $option['default_unit'] : 'px',
								'size' => isset( $option['default'] ) ? $option['default'] : '',
							),
							'range'       => array(
								'px' => array(
									'min'  => $option['options']['min'],
									'max'  => $option['options']['max'],
									'step' => $option['options']['step'],
								),
								'%'  => array(
									'min' => 0,
									'max' => 100,
								),
								'em' => array(
									'min'  => intval( $option['options']['min'] / 10 ),
									'max'  => intval( $option['options']['max'] / 10 ),
									'step' => 0.1,
								),
							),
							'description' => isset( $option['description'] ) ? $option['description'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['frontend_available'] ) ) {
							$args['frontend_available'] = $option['frontend_available'];
						}

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						foreach ( $args['size_units'] as $unit ) {
							if ( ! in_array( $unit, array( 'px', '%', 'em' ), true ) ) {
								$args['range'][ $unit ] = array(
									'min'  => $option['options']['min'],
									'max'  => $option['options']['max'],
									'step' => $option['options']['step'],
								);
							}
						}

						if ( isset( $option['selectors'] ) && ( isset( $option['attribute'] ) || isset( $option['selectors']['custom'] ) ) ) {
							$args['selectors'] = isset( $option['selectors']['custom'] ) ? $option['selectors']['custom'] : array( '{{WRAPPER}} ' . $option['selectors'] => $option['attribute'] . ': {{SIZE}}{{UNIT}};' );
						}

						if ( isset( $option['render_type'] ) ) {
							$args['render_type'] = $option['render_type'];
						}

						if ( $repeater_options ) {
							if ( isset( $option['responsive'] ) && $option['responsive'] ) {
								$repeater->add_responsive_control( $id . '_responsive', $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
							} else {
								$repeater->add_control( $id, $args );
							}
						} elseif ( isset( $option['responsive'] ) && $option['responsive'] ) {
								$default_unit = isset( $option['default_unit'] ) ? $option['default_unit'] : 'px';
								$default_size = isset( $option['default'] ) ? $option['default'] : '';

								$args['desktop_default'] = array(
									'unit' => $default_unit,
									'size' => $default_size,
								);

								foreach ( jkit_get_responsive_breakpoints() as $breakpoint ) {
									$default_size = isset( $option[ $breakpoint['key'] . '_default' ]['size'] ) ? $option[ $breakpoint['key'] . '_default' ]['size'] : '';
									$default_unit = isset( $option[ $breakpoint['key'] . '_default' ]['unit'] ) ? $option[ $breakpoint['key'] . '_default' ]['unit'] : $default_unit;

									if ( '' !== $default_size ) {
										$args[ $breakpoint['key'] . '_default' ]['size'] = $default_size;
									}

									if ( '' !== $default_unit ) {
										$args[ $breakpoint['key'] . '_default' ]['unit'] = $default_unit;
									}
								}

								$this->add_responsive_control( $id . '_responsive', $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'number':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::NUMBER,
							'default'     => isset( $option['default'] ) ? $option['default'] : 0,
							'description' => isset( $option['description'] ) ? $option['description'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['options']['min'] ) ) {
							$args['min'] = $option['options']['min'];
						}

						if ( isset( $option['options']['max'] ) ) {
							$args['max'] = $option['options']['max'];
						}

						if ( isset( $option['options']['step'] ) ) {
							$args['step'] = $option['options']['step'];
						}

						if ( isset( $option['selectors'] ) && ( isset( $option['attribute'] ) || isset( $option['selectors']['custom'] ) ) ) {
							$args['selectors'] = isset( $option['selectors']['custom'] ) ? $option['selectors']['custom'] : array( '{{WRAPPER}} ' . $option['selectors'] => $option['attribute'] . ': {{VALUE}};' );
						}

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							if ( isset( $option['responsive'] ) && $option['responsive'] ) {
								$repeater->add_responsive_control( $id . '_responsive', $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
							} else {
								$repeater->add_control( $id, $args );
							}
						} elseif ( isset( $option['responsive'] ) && $option['responsive'] ) {
								$default_value = isset( $option['default'] ) ? $option['default'] : '';

								$args['desktop_default'] = $default_value;

							foreach ( jkit_get_responsive_breakpoints() as $breakpoint ) {
								if ( isset( $option[ $breakpoint['key'] . '_default' ] ) ) {
									$args[ $breakpoint['key'] . '_default' ] = $option[ $breakpoint['key'] . '_default' ];
								}
							}

								$this->add_responsive_control( $id . '_responsive', $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
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
							'description' => isset( $option['description'] ) ? $option['description'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

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
							'description' => isset( $option['description'] ) ? $option['description'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'iconpicker':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::ICONS,
							'default'     => isset( $option['default'] ) ? $option['default'] : array(),
							'label_block' => true,
							'description' => isset( $option['description'] ) ? $option['description'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'repeater':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::REPEATER,
							'fields'      => $this->parse_control_option( $option['fields'], $id, true ),
							'default'     => isset( $option['default'] ) ? $option['default'] : array(),
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
							'title_field' => isset( $option['title_field'] ) ? $option['title_field'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'select':
					case 'select2':
						$options = jeg_field_select_option( $option );
						$args    = array(
							'label'       => $option['title'],
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'label_block' => isset( $option['label_block'] ) ? $option['label_block'] : false,
							'description' => isset( $option['description'] ) ? $option['description'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( ! isset( $option['ajax'] ) ) {
							if ( isset( $option['multiple'] ) || 'select2' === $option['type'] ) {
								$args['type']     = Controls_Manager::SELECT2;
								$args['multiple'] = isset( $option['multiple'] ) ? $option['multiple'] : true;
							} else {
								$args['type'] = Controls_Manager::SELECT;
							}
							$args['options'] = $options;
						} else {
							if ( isset( $option['options'] ) && 'jeg_get_custom_term_option' === $option['options'] ) {
								$options = call_user_func_array( $option['options'], array( '', $option['slug'] ) );
							}

							$args['type']      = 'dynamic-select';
							$args['multiple']  = isset( $option['multiple'] ) ? $option['multiple'] : 1;
							$args['ajax']      = isset( $option['ajax'] ) ? $option['ajax'] : '';
							$args['slug']      = isset( $option['slug'] ) ? $option['slug'] : '';
							$args['nonce']     = isset( $option['nonce'] ) ? $option['nonce'] : '';
							$args['retriever'] = isset( $option['options'] ) ? $option['options'] : '';
							$args['options']   = wp_json_encode( $options );
						}

						if ( 'content-filter' === $segment || 'segment_filter' === $segment ) {
							$args['label_block'] = true;
						}

						if ( isset( $option['prefix_class'] ) ) {
							$args['prefix_class'] = $option['prefix_class'];
						}

						if ( isset( $option['selectors'] ) ) {
							if ( isset( $option['attribute'] ) ) {
								$args['selectors'] = array(
									'{{WRAPPER}} ' . $option['selectors'] => $option['attribute'] . ': {{VALUE}}',
								);
							} elseif ( isset( $option['selectors']['custom'] ) ) {
								$args['selectors'] = $option['selectors']['custom'];
							}
						}

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( isset( $option['render_type'] ) ) {
							$args['render_type'] = $option['render_type'];
						}

						if ( $repeater_options ) {
							if ( isset( $option['responsive'] ) && $option['responsive'] ) {
								$repeater->add_responsive_control( $id . '_responsive', $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
							} else {
								$repeater->add_control( $id, $args );
							}
						} elseif ( isset( $option['responsive'] ) && $option['responsive'] ) {
								$default_value = isset( $option['default'] ) ? $option['default'] : '';

								$args['desktop_default'] = $default_value;

							foreach ( jkit_get_responsive_breakpoints() as $breakpoint ) {
								if ( isset( $option[ $breakpoint['key'] . '_default' ] ) ) {
									$args[ $breakpoint['key'] . '_default' ] = $option[ $breakpoint['key'] . '_default' ];
								}
							}

								$this->add_responsive_control( $id . '_responsive', $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'heading':
						$args = array(
							'label'     => $option['title'],
							'type'      => Controls_Manager::HEADING,
							'separator' => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'imagesize':
						$args = array(
							'label'     => $option['title'],
							'name'      => $id . '_imagesize',
							'exclude'   => array( 'custom' ),
							'include'   => array(),
							'default'   => isset( $option['default'] ) ? $option['default'] : 'thumbnail',
							'separator' => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_group_control( Group_Control_Image_Size::get_type(), $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						} else {
							$this->add_group_control( Group_Control_Image_Size::get_type(), $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						}
						break;

					case 'dimension':
						$selectors = isset( $option['selectors']['custom'] ) ? $option['selectors']['custom'] : array( '{{WRAPPER}} ' . $option['selectors'] => $option['attribute'] . ': {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' );
						$args      = array(
							'label'              => $option['title'],
							'type'               => Controls_Manager::DIMENSIONS,
							'size_units'         => isset( $option['units'] ) ? $option['units'] : array(),
							'label_block'        => true,
							'description'        => isset( $option['description'] ) ? $option['description'] : '',
							'separator'          => isset( $option['separator'] ) ? $option['separator'] : '',
							'allowed_dimensions' => isset( $option['allowed_dimensions'] ) ? $option['allowed_dimensions'] : array( 'top', 'right', 'bottom', 'left' ),
							'default'            => isset( $option['default'] ) ? $option['default'] : array(),
							'selectors'          => $selectors,
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_responsive_control( $id . '_responsive', $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						} else {
							$default_value = isset( $option['default'] ) ? $option['default'] : array();

							$args['desktop_default'] = $default_value;

							foreach ( jkit_get_responsive_breakpoints() as $breakpoint ) {
								if ( isset( $option[ $breakpoint['key'] . '_default' ] ) ) {
									$args[ $breakpoint['key'] . '_default' ] = $option[ $breakpoint['key'] . '_default' ];
								}
							}

							$this->add_responsive_control( $id . '_responsive', $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						}
						break;

					case 'background':
						$args = array(
							'name'           => $id . '_background',
							'label'          => $option['title'],
							'types'          => isset( $option['options'] ) ? $option['options'] : array(),
							'exclude'        => isset( $option['exclude'] ) ? $option['exclude'] : '',
							'selector'       => isset( $option['selectors']['custom'] ) ? $option['selectors']['custom'] : '{{WRAPPER}} ' . $option['selectors'],
							'fields_options' => isset( $option['fields_options'] ) ? $option['fields_options'] : array(),
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_control(
								$id,
								array(
									'label'     => $option['title'],
									'type'      => Controls_Manager::HEADING,
									'condition' => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
									'separator' => isset( $option['separator'] ) ? $option['separator'] : '',
								)
							);
							$repeater->add_group_control( Group_Control_Background::get_type(), $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						} else {

							$this->add_control(
								$id,
								array(
									'label'     => $option['title'],
									'type'      => Controls_Manager::HEADING,
									'condition' => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
									'separator' => isset( $option['separator'] ) ? $option['separator'] : '',
								)
							);

							$this->add_group_control( Group_Control_Background::get_type(), $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						}

						break;

					case 'css_filter':
						$args = array(
							'name'     => $id . '_css_filter',
							'label'    => $option['title'],
							'types'    => isset( $option['options'] ) ? $option['options'] : array(),
							'selector' => isset( $option['selectors']['custom'] ) ? $option['selectors']['custom'] : '{{WRAPPER}} ' . $option['selectors'],
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_group_control( Group_Control_Css_Filter::get_type(), $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						} else {
							$this->add_group_control( Group_Control_Css_Filter::get_type(), $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						}

						break;

					case 'link':
						$args = array(
							'label'         => $option['title'],
							'type'          => Controls_Manager::URL,
							'placeholder'   => isset( $option['placeholder'] ) ? $option['placeholder'] : '',
							'show_external' => isset( $option['show_external'] ) ? $option['show_external'] : false,
							'separator'     => isset( $option['separator'] ) ? $option['separator'] : '',
							'default'       => array(
								'url'         => isset( $option['url'] ) ? $option['url'] : '',
								'is_external' => isset( $option['is_external'] ) ? $option['is_external'] : false,
								'nofollow'    => isset( $option['nofollow'] ) ? $option['nofollow'] : false,
							),
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						$args['dynamic']['active'] = true;

						if ( isset( $option['dynamic'] ) ) {
							$args['dynamic']['active'] = $option['dynamic'];
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'typography':
						$args = array(
							'name'           => $id . '_content_typography',
							'label'          => $option['title'],
							'selector'       => isset( $option['selectors']['custom'] ) ? $option['selectors']['custom'] : '{{WRAPPER}} ' . $option['selectors'],
							'separator'      => isset( $option['separator'] ) ? $option['separator'] : '',
							'exclude'        => isset( $option['exclude'] ) ? $option['exclude'] : '',
							'fields_options' => isset( $option['fields_options'] ) ? $option['fields_options'] : array(),
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						$this->add_group_control( Group_Control_Typography::get_type(), $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );

						break;

					case 'border':
						$args = array(
							'name'           => $id . '_border',
							'label'          => $option['title'],
							'selector'       => isset( $option['selectors']['custom'] ) ? $option['selectors']['custom'] : '{{WRAPPER}} ' . $option['selectors'],
							'fields_options' => isset( $option['fields_options'] ) ? $option['fields_options'] : array(),
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_group_control( Group_Control_Border::get_type(), $args );
						} else {
							$this->add_control(
								$id,
								array(
									'label'     => $option['title'],
									'type'      => Controls_Manager::HEADING,
									'condition' => isset( $option['dependency'] ) ? $this->parse_dependency_option( $option['dependency'] ) : '',
									'separator' => isset( $option['separator'] ) ? $option['separator'] : '',
								)
							);
							$this->add_group_control( Group_Control_Border::get_type(), $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						}

						break;

					case 'boxshadow':
						$args = array(
							'name'      => $id . '_box_shadow',
							'label'     => $option['title'],
							'selector'  => isset( $option['selectors']['custom'] ) ? $option['selectors']['custom'] : '{{WRAPPER}} ' . $option['selectors'],
							'separator' => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_group_control( Group_Control_Box_Shadow::get_type(), $args );
						} else {
							$this->add_group_control( Group_Control_Box_Shadow::get_type(), $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						}

						break;

					case 'textshadow':
						$args = array(
							'name'     => $id . '_text_shadow',
							'label'    => $option['title'],
							'selector' => isset( $option['selectors']['custom'] ) ? $option['selectors']['custom'] : '{{WRAPPER}} ' . $option['selectors'],
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_group_control( Group_Control_Text_Shadow::get_type(), $args );
						} else {
							$this->add_group_control( Group_Control_Text_Shadow::get_type(), $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						}

						break;

					case 'textstroke':
						$args = array(
							'name'     => $id . '_text_stroke',
							'label'    => $option['title'],
							'selector' => isset( $option['selectors']['custom'] ) ? $option['selectors']['custom'] : '{{WRAPPER}} ' . $option['selectors'],
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_group_control( Group_Control_Text_Stroke::get_type(), $args );
						} else {
							$this->add_group_control( Group_Control_Text_Stroke::get_type(), $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						}

						break;

					case 'radio':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::CHOOSE,
							'options'     => isset( $option['options'] ) ? $option['options'] : array(),
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'toggle'      => isset( $option['toggle'] ) ? $option['toggle'] : true,
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
							'description' => isset( $option['description'] ) ? $option['description'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( isset( $option['selectors'] ) ) {
							if ( isset( $option['attribute'] ) ) {
								$args['selectors'] = array(
									'{{WRAPPER}} ' . $option['selectors'] => $option['attribute'] . ': {{VALUE}}',
								);
							} elseif ( isset( $option['selectors']['custom'] ) ) {
								$args['selectors'] = $option['selectors']['custom'];
							}
						}

						if ( isset( $option['prefix_class'] ) ) {
							$args['prefix_class'] = $option['prefix_class'];
						}

						if ( isset( $option['render_type'] ) ) {
							$args['render_type'] = $option['render_type'];
						}

						if ( $repeater_options ) {
							if ( isset( $option['responsive'] ) && $option['responsive'] ) {
								$repeater->add_responsive_control( $id . '_responsive', $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
							} else {
								$repeater->add_control( $id, $args );
							}
						} elseif ( isset( $option['responsive'] ) && $option['responsive'] ) {
								$default_value = isset( $option['default'] ) ? $option['default'] : '';

								$args['desktop_default'] = $default_value;

							foreach ( jkit_get_responsive_breakpoints() as $breakpoint ) {
								if ( isset( $option[ $breakpoint['key'] . '_default' ] ) ) {
									$args[ $breakpoint['key'] . '_default' ] = $option[ $breakpoint['key'] . '_default' ];
								}
							}

								$this->add_responsive_control( $id . '_responsive', $args, array( 'position' => isset( $option['position'] ) ? $option['position'] : null ) );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'wysiwyg':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::WYSIWYG,
							'placeholder' => isset( $option['placeholder'] ) ? $option['placeholder'] : '',
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'hoveranimation':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::HOVER_ANIMATION,
							'placeholder' => isset( $option['placeholder'] ) ? $option['placeholder'] : '',
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'datetime':
						$args = array(
							'label'     => $option['title'],
							'type'      => Controls_Manager::DATE_TIME,
							'default'   => isset( $option['default'] ) ? $option['default'] : '',
							'separator' => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'css_editor':
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::CODE,
							'placeholder' => isset( $option['placeholder'] ) ? $option['placeholder'] : '',
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
							'language'    => 'css',
							'render_type' => 'ui',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					case 'raw':
						$args = array(
							'label'           => $option['title'],
							'type'            => Controls_Manager::RAW_HTML,
							'raw'             => isset( $option['raw'] ) ? $option['raw'] : '',
							'content_classes' => isset( $option['classes'] ) ? $option['classes'] : '',
						);

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

						if ( $repeater_options ) {
							$repeater->add_control( $id, $args );
						} else {
							$this->add_control( $id, $args );
						}

						break;

					default:
						$args = array(
							'label'       => $option['title'],
							'type'        => Controls_Manager::TEXT,
							'default'     => isset( $option['default'] ) ? $option['default'] : '',
							'label_block' => isset( $option['label_block'] ) ? $option['label_block'] : true,
							'description' => isset( $option['description'] ) ? $option['description'] : '',
							'separator'   => isset( $option['separator'] ) ? $option['separator'] : '',
						);

						$args['dynamic']['active'] = true;

						if ( isset( $option['dynamic'] ) ) {
							$args['dynamic']['active'] = $option['dynamic'];
						}

						if ( isset( $option['dependency'] ) ) {
							if ( isset( $option['dependency']['custom'] ) ) {
								$args['conditions'] = $option['dependency']['custom'];
							} else {
								$args['condition'] = $this->parse_dependency_option( $option['dependency'] );
							}
						}

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
}
