<?php
/**
 * Accordion Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Accordion_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Accordion_Option extends Option_Abstract {
	/**
	 * Show color scheme flag for element.
	 *
	 * @return bool
	 */
	public function show_color_scheme() {
		return false;
	}

	/**
	 * Compatibility column
	 *
	 * @return array
	 */
	public function compatible_column() {
		return array();
	}

	/**
	 * Override function to remove compatible column alert
	 */
	public function set_compatible_column_option() {
	}

	/**
	 * Element name
	 *
	 * @return string
	 */
	public function get_element_name() {
		return esc_html__( 'JKit - Accordion', 'jeg-elementor-kit' );
	}

	/**
	 * Element category
	 *
	 * @return string
	 */
	public function get_category() {
		return esc_html__( 'Jeg Elementor Kit', 'jeg-elementor-kit' );
	}

	/**
	 * Element options
	 */
	public function set_options() {
		$this->set_style_option();
		$this->set_element_options();

		parent::set_options();
	}

	/**
	 * Option segments
	 */
	public function set_segments() {
		$this->segments['segment_accordion'] = array(
			'name'     => esc_html__( 'Accordion', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->segments['segment_icon'] = array(
			'name'     => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'priority' => 11,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_wrapper'] = array(
			'name'      => esc_html__( 'Wrapper', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_title'] = array(
			'name'      => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_description'] = array(
			'name'      => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_border'] = array(
			'name'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		$this->segments['style_icon'] = array(
			'name'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'priority'  => 15,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_accordion_list'] = array(
			'type'        => 'repeater',
			'title'       => esc_html__( 'Content List', 'jeg-elementor-kit' ),
			'segment'     => 'segment_accordion',
			'title_field' => '{{ sg_accordion_list_title }}',
			'fields'      => array(
				'sg_accordion_list_title'   => array(
					'type'    => 'text',
					'segment' => 'sg_accordion_list',
					'title'   => esc_html__( 'Title', 'jeg-elementor-kit' ),
				),
				'sg_accordion_list_content' => array(
					'type'    => 'wysiwyg',
					'segment' => 'sg_accordion_list',
					'title'   => esc_html__( 'Content Description', 'jeg-elementor-kit' ),
				),
				'sg_accordion_list_open'    => array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Keep Slide Open', 'jeg-elementor-kit' ),
					'description' => esc_html__( 'Keep this slide open on the first load.', 'jeg-elementor-kit' ),
					'segment'     => 'sg_accordion_list',
				),
			),
			'default'     => array(
				array(
					'sg_accordion_list_title'   => esc_html__( 'Lorem ipsum dolor sit amet', 'jeg-elementor-kit' ),
					'sg_accordion_list_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.', 'jeg-elementor-kit' ),
				),
				array(
					'sg_accordion_list_title'   => esc_html__( 'Far far away, behind the word mountains', 'jeg-elementor-kit' ),
					'sg_accordion_list_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.', 'jeg-elementor-kit' ),
				),
				array(
					'sg_accordion_list_title'   => esc_html__( 'The quick, brown fox jumps over a lazy dog', 'jeg-elementor-kit' ),
					'sg_accordion_list_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.', 'jeg-elementor-kit' ),
				),
			),
		);

		$this->options['sg_accordion_open'] = array(
			'type'        => 'checkbox',
			'title'       => esc_html__( 'Keep First Slide Open', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Keep first slide open on the first load.', 'jeg-elementor-kit' ),
			'segment'     => 'segment_accordion',
		);

		$this->options['sg_accordion_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Style', 'jeg-elementor-kit' ),
			'default' => 'default',
			'segment' => 'segment_accordion',
			'options' => array(
				'default' => esc_html__( 'Default', 'jeg-elementor-kit' ),
				'curve'   => esc_html__( 'Side Curve', 'jeg-elementor-kit' ),
				'box'     => esc_html__( 'Box Icon', 'jeg-elementor-kit' ),
				'shadow'  => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_icon_position'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default' => 'right',
			'segment' => 'segment_icon',
			'options' => array(
				'left'  => esc_html__( 'Left', 'jeg-elementor-kit' ),
				'right' => esc_html__( 'Right', 'jeg-elementor-kit' ),
				'both'  => esc_html__( 'Both', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_icon_number'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Show Number', 'jeg-elementor-kit' ),
			'segment'    => 'segment_icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'right',
				),
			),
		);

		$this->options['sg_icon_right'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Right Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-chevron-down',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => array( 'right', 'both' ),
				),
			),
		);

		$this->options['sg_icon_right_active'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Right Icon Active', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-chevron-up',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => array( 'right', 'both' ),
				),
			),
		);

		$this->options['sg_icon_left'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Left Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-chevron-down',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => array( 'left', 'both' ),
				),
			),
		);

		$this->options['sg_icon_left_active'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Left Icon Active', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-chevron-up',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => array( 'left', 'both' ),
				),
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_wrapper_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper',
			'attribute' => 'margin',
		);

		$this->options['st_wrapper_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper',
			'attribute' => 'padding',
		);

		$this->options['st_wrapper_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_wrapper_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_wrapper',
		);

		$this->options['st_wrapper_open_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Open', 'jeg-elementor-kit' ),
			'segment' => 'style_wrapper',
		);

		$this->options['st_wrapper_open_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Open Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_wrapper',
			'selectors'      => '.jeg-elementor-kit.jkit-accordion .card-wrapper.expand:not(.background-gradient), {{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper.background-gradient:after',
			'options'        => array(
				'classic',
				'gradient',
			),
			'fields_options' => array(
				'background' => array(
					'render_type' => 'template',
				),
			),
		);

		$this->options['st_wrapper_open_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper.expand',
		);

		$this->options['st_wrapper_open_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper.expand',
			'attribute' => 'border-radius',
		);

		$this->options['st_wrapper_open_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper.expand',
		);

		$this->options['st_wrapper_open_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_wrapper',
		);

		$this->options['st_wrapper_close_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Close', 'jeg-elementor-kit' ),
			'segment' => 'style_wrapper',
		);

		$this->options['st_wrapper_close_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Open Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_wrapper',
			'selectors'      => '.jeg-elementor-kit.jkit-accordion .card-wrapper:not(.background-gradient), {{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper.background-gradient:before',
			'options'        => array(
				'classic',
				'gradient',
			),
			'fields_options' => array(
				'background' => array(
					'render_type' => 'template',
				),
			),
		);

		$this->options['st_wrapper_close_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper',
		);

		$this->options['st_wrapper_close_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper',
			'attribute' => 'border-radius',
		);

		$this->options['st_wrapper_close_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper',
		);

		$this->options['st_wrapper_close_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_wrapper',
		);

		$this->options['st_wrapper_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_wrapper',
		);

		$this->options['st_wrapper_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_wrapper_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_wrapper_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover',
		);

		$this->options['st_wrapper_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_wrapper_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover',
		);

		$this->options['st_wrapper_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_wrapper',
		);

		$this->options['st_wrapper_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_wrapper',
		);

		$this->options['st_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button',
		);

		$this->options['st_title_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button, {{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header.background-gradient' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_title_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_title',
		);

		$this->options['st_title_open_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Open', 'jeg-elementor-kit' ),
			'segment' => 'style_title',
		);

		$this->options['st_title_open_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Open Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper.expand .card-header .card-header-button',
		);

		$this->options['st_title_open_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Open Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_title',
			'selectors'      => '.jeg-elementor-kit.jkit-accordion .card-wrapper.expand .card-header:not(.background-gradient) .card-header-button, {{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header.background-gradient:after',
			'options'        => array(
				'classic',
				'gradient',
			),
			'fields_options' => array(
				'background' => array(
					'render_type' => 'template',
				),
			),
		);

		$this->options['st_title_open_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Open Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper.expand .card-header .card-header-button',
		);

		$this->options['st_title_open_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Open Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper.expand .card-header .card-header-button, {{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header.background-gradient::after',
			'attribute' => 'border-radius',
		);

		$this->options['st_title_open_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Open Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper.expand .card-header .card-header-button',
		);

		$this->options['st_title_open_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper.expand .card-header .card-header-button',
			'attribute' => 'margin',
		);

		$this->options['st_title_open_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_title',
		);

		$this->options['st_title_close_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Close', 'jeg-elementor-kit' ),
			'segment' => 'style_title',
		);

		$this->options['st_title_close_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Close Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper:not(.expand) .card-header .card-header-button',

		);

		$this->options['st_title_close_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Close Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_title',
			'selectors'      => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header:not(.background-gradient) .card-header-button, {{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header.background-gradient:before',
			'options'        => array(
				'classic',
				'gradient',
			),
			'fields_options' => array(
				'background' => array(
					'render_type' => 'template',
				),
			),
		);

		$this->options['st_title_close_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Close Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:not(.expand) .card-header .card-header-button',
		);

		$this->options['st_title_close_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Close Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:not(.expand) .card-header .card-header-button, {{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header.background-gradient::before',
			'attribute' => 'border-radius',
		);

		$this->options['st_title_close_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Close Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:not(.expand) .card-header .card-header-button',
		);

		$this->options['st_title_close_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:not(.expand) .card-header .card-header-button',
			'attribute' => 'margin',
		);

		$this->options['st_title_close_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_title',
		);

		$this->options['st_title_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_title',
		);

		$this->options['st_title_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_title_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button',
		);

		$this->options['st_title_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_title_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button',
		);

		$this->options['st_title_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button',
		);

		$this->options['st_title_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_title',
		);

		$this->options['st_title_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_title',
		);

		$this->options['st_title_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button',
			'attribute' => 'padding',
			'separator' => 'before',
		);

		$this->options['st_title_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'options'    => array(
				'min'  => -30,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button',
			'attribute'  => 'margin-bottom',
		);

		$this->options['st_description_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_description',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-expand .card-body',
		);

		$this->options['st_description_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-expand .card-body',
		);

		$this->options['st_description_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-expand .card-body',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_description_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-expand .card-body',
			'attribute' => 'border-radius',
		);

		$this->options['st_description_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-expand .card-body',
			'attribute' => 'padding',
		);

		$this->options['st_description_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_description',
		);

		$this->options['st_description_open_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Open', 'jeg-elementor-kit' ),
			'segment' => 'style_description',
		);

		$this->options['st_description_open_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-expand .card-body',
			'attribute' => 'margin',
		);

		$this->options['st_description_open_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_description',
		);

		$this->options['st_description_close_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Close', 'jeg-elementor-kit' ),
			'segment' => 'style_description',
		);

		$this->options['st_description_close_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper.expand .card-expand .card-body',
			'attribute' => 'margin',
		);

		$this->options['st_description_close_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_description',
		);

		$this->options['st_description_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_description',
		);

		$this->options['st_border_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_border',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper',
		);

		$this->options['st_border_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_border',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper',
			'attribute' => 'border-radius',
		);

		$this->options['st_border_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_border',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper',
		);

		$this->options['st_icon_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"]',
			'attribute' => 'margin',
		);

		$this->options['st_icon_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] > [class*="icon"]',
			'attribute' => 'padding',
		);

		$this->options['st_icon_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_open_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Open', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_open_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Open Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .active-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .active-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_icon_open_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Open Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .active-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .active-icon svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_open_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'options'   => array(
				'classic',
				'gradient',
			),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .active-icon',
		);

		$this->options['st_icon_open_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .active-icon',
		);

		$this->options['st_icon_open_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .active-icon',
			'attribute' => 'border-radius',
		);

		$this->options['st_icon_open_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .active-icon',
		);

		$this->options['st_icon_open_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_close_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Close', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_close_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Close Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .normal-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .normal-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_icon_close_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Close Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .normal-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .normal-icon svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_close_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'options'   => array(
				'classic',
				'gradient',
			),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .normal-icon',
		);

		$this->options['st_icon_close_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .normal-icon',
		);

		$this->options['st_icon_close_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .normal-icon',
			'attribute' => 'border-radius',
		);

		$this->options['st_icon_close_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] .normal-icon',
		);

		$this->options['st_icon_close_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button [class*="icon-group"] [class*="-icon"]' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_icon_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button [class*="icon-group"] [class*="-icon"]'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button [class*="icon-group"] [class*="-icon"] svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'options'   => array(
				'classic',
				'gradient',
			),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button [class*="icon-group"] [class*="-icon"]',
		);

		$this->options['st_icon_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button [class*="icon-group"] [class*="-icon"]',
		);

		$this->options['st_icon_hover_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button [class*="icon-group"] [class*="-icon"]',
			'attribute' => 'border-radius',
		);

		$this->options['st_icon_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button [class*="icon-group"] [class*="-icon"]',
		);

		$this->options['st_icon_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion.style-box .card-wrapper .card-header .card-header-button:before',
			'separator'  => 'before',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_accordion_style',
					'operator' => '==',
					'value'    => 'box',
				),
			),
		);

		$this->options['st_icon_overide'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Overide Icon Style', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
			),
		);

		$this->options['st_icon_overide_left_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Left', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_margin'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group',
			'attribute'  => 'margin',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_padding'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group > [class*="icon"]',
			'attribute'  => 'padding',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_tabs_start'] = array(
			'type'       => 'control_tabs_start',
			'segment'    => 'style_icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_open_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Open', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_left_open_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Open Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .active-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .active-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_open_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Open Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .active-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .active-icon svg' => 'fill: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_open_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'classic',
				'gradient',
			),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .active-icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_open_border'] = array(
			'type'       => 'border',
			'title'      => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .active-icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_open_border_radius'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .active-icon',
			'attribute'  => 'border-radius',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_open_boxshadow'] = array(
			'type'       => 'boxshadow',
			'title'      => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .active-icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_open_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_left_close_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Close', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_left_close_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Close Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .normal-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .normal-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_close_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Close Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .normal-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .normal-icon svg' => 'fill: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_close_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'classic',
				'gradient',
			),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .normal-icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_close_border'] = array(
			'type'       => 'border',
			'title'      => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .normal-icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_close_border_radius'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .normal-icon',
			'attribute'  => 'border-radius',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_close_boxshadow'] = array(
			'type'       => 'boxshadow',
			'title'      => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group .normal-icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_close_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_left_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_left_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .left-icon-group [class*="-icon"]' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_icon_overide_left_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button .left-icon-group [class*="-icon"]'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button .left-icon-group [class*="-icon"] svg' => 'fill: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_hover_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'classic',
				'gradient',
			),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button .left-icon-group [class*="-icon"]',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_hover_border'] = array(
			'type'       => 'border',
			'title'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button .left-icon-group [class*="-icon"]',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_hover_border_radius'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button .left-icon-group [class*="-icon"]',
			'attribute'  => 'border-radius',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_hover_boxshadow'] = array(
			'type'       => 'boxshadow',
			'title'      => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button .left-icon-group [class*="-icon"]',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_left_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_left_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_right_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Right', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_margin'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group',
			'attribute'  => 'margin',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_padding'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group > [class*="icon"]',
			'attribute'  => 'padding',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_tabs_start'] = array(
			'type'       => 'control_tabs_start',
			'segment'    => 'style_icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_open_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Open', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_right_open_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Open Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .active-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .active-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_open_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Open Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .active-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .active-icon svg' => 'fill: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_open_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'classic',
				'gradient',
			),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .active-icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_open_border'] = array(
			'type'       => 'border',
			'title'      => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .active-icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_open_border_radius'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .active-icon',
			'attribute'  => 'border-radius',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_open_boxshadow'] = array(
			'type'       => 'boxshadow',
			'title'      => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .active-icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_open_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_right_close_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Close', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_right_close_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Close Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .normal-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .normal-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_close_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Close Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .normal-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .normal-icon svg' => 'fill: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_close_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'classic',
				'gradient',
			),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .normal-icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_close_border'] = array(
			'type'       => 'border',
			'title'      => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .normal-icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_close_border_radius'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .normal-icon',
			'attribute'  => 'border-radius',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_close_boxshadow'] = array(
			'type'       => 'boxshadow',
			'title'      => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group .normal-icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_close_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_right_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_right_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper .card-header .card-header-button .right-icon-group [class*="-icon"]' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_icon_overide_right_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button .right-icon-group [class*="-icon"]'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button .right-icon-group [class*="-icon"] svg' => 'fill: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_hover_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'classic',
				'gradient',
			),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button .right-icon-group [class*="-icon"]',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_hover_border'] = array(
			'type'       => 'border',
			'title'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button .right-icon-group [class*="-icon"]',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_hover_border_radius'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button .right-icon-group [class*="-icon"]',
			'attribute'  => 'border-radius',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_hover_boxshadow'] = array(
			'type'       => 'boxshadow',
			'title'      => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-accordion .card-wrapper:hover .card-header .card-header-button .right-icon-group [class*="-icon"]',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_position',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'st_icon_overide',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['st_icon_overide_right_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_overide_right_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_icon',
		);

		parent::additional_style();
	}
}
