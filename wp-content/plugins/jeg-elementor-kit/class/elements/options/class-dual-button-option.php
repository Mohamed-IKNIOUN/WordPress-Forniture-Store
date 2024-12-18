<?php
/**
 * Dual Button Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.10.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Dual_Button_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Dual_Button_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Dual Button', 'jeg-elementor-kit' );
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
		$this->segments['segment_dual'] = array(
			'name'     => esc_html__( 'Dual Button', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->segments['segment_one'] = array(
			'name'     => esc_html__( 'Button One', 'jeg-elementor-kit' ),
			'priority' => 11,
		);

		$this->segments['segment_two'] = array(
			'name'     => esc_html__( 'Button Two', 'jeg-elementor-kit' ),
			'priority' => 12,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_one'] = array(
			'name'      => esc_html__( 'Button One', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_two'] = array(
			'name'      => esc_html__( 'Button Two', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_middle'] = array(
			'name'       => esc_html__( 'Middle Button', 'jeg-elementor-kit' ),
			'priority'   => 13,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_dual_middle_text_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_dual_middle_text_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Middle Text', 'jeg-elementor-kit' ),
			'segment' => 'segment_dual',
		);

		$this->options['sg_dual_middle_text'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Middle Text', 'jeg-elementor-kit' ),
			'default'    => 'Or',
			'segment'    => 'segment_dual',
			'dependency' => array(
				array(
					'field'    => 'sg_dual_middle_text_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_dual_alignment'] = array(
			'type'        => 'radio',
			'title'       => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'default'     => 'center',
			'segment'     => 'segment_dual',
			'options'     => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'responsive'  => true,
			'render_type' => 'ui',
		);

		$this->options['st_dual_width'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Button Width', 'jeg-elementor-kit' ),
			'segment'      => 'segment_dual',
			'default'      => 40,
			'options'      => array(
				'min'  => 300,
				'max'  => 1200,
				'step' => 1,
			),
			'responsive'   => true,
			'units'        => array( 'px', '%' ),
			'default_unit' => '%',
			'selectors'    => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper',
			'attribute'    => 'width',
		);

		$this->options['st_dual_gap'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Button Gap', 'jeg-elementor-kit' ),
			'segment'    => 'segment_dual',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-btn:not(:last-child)',
			'attribute'  => 'margin-right',
			'dependency' => array(
				array(
					'field'    => 'sg_dual_middle_text_enable!',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_one_text'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Text', 'jeg-elementor-kit' ),
			'default' => 'Button',
			'segment' => 'segment_one',
		);

		$this->options['sg_one_link'] = array(
			'type'    => 'link',
			'title'   => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment' => 'segment_one',
		);

		$this->options['sg_one_icon_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Icon', 'jeg-elementor-kit' ),
			'segment' => 'segment_one',
		);

		$this->options['sg_one_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_one',
			'dependency' => array(
				array(
					'field'    => 'sg_one_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_one_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_one',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_one_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_one_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'segment_one',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 5,
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one.icon-position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one.icon-position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_one_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_two_text'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Text', 'jeg-elementor-kit' ),
			'default' => 'Button',
			'segment' => 'segment_two',
		);

		$this->options['sg_two_link'] = array(
			'type'    => 'link',
			'title'   => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment' => 'segment_two',
		);

		$this->options['sg_two_icon_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Icon', 'jeg-elementor-kit' ),
			'segment' => 'segment_two',
		);

		$this->options['sg_two_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_two',
			'dependency' => array(
				array(
					'field'    => 'sg_two_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_two_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_two',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_two_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_two_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'segment_two',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 5,
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two.icon-position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two.icon-position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_two_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_one_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_one',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one',
		);

		$this->options['st_one_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_one',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_one_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_one_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_one',
		);

		$this->options['st_one_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_one',
		);

		$this->options['st_one_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_one',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_one_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_one',
			'selectors'      => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one',
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

		$this->options['st_one_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_one',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one',
		);

		$this->options['st_one_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_one',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one',
		);

		$this->options['st_one_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_one',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one',
			'attribute' => 'border-radius',
		);

		$this->options['st_one_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_one',
		);

		$this->options['st_one_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_one',
		);

		$this->options['st_one_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_one',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_one_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_one',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_one_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_one',
			'selectors'      => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one:not(.hover-gradient):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one.hover-gradient:before',
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

		$this->options['st_one_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_one',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one:hover',
		);

		$this->options['st_one_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_one',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one:hover',
		);

		$this->options['st_one_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_one',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_one_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_one',
		);

		$this->options['st_one_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_one',
		);

		$this->options['st_one_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_one',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one',
			'attribute' => 'padding',
			'separator' => 'before',
		);

		$this->options['st_one_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_one',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one',
			'attribute' => 'margin',
		);

		$this->options['sg_one_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'default'    => 'center',
			'segment'    => 'style_one',
			'options'    => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-one',
			'attribute'  => 'text-align',
		);

		$this->options['st_two_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_two',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two',
		);

		$this->options['st_two_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_two',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_two_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_two_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_two',
		);

		$this->options['st_two_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_two',
		);

		$this->options['st_two_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_two',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_two_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_two',
			'selectors'      => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two',
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

		$this->options['st_two_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_two',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two',
		);

		$this->options['st_two_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_two',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two',
		);

		$this->options['st_two_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_two',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two',
			'attribute' => 'border-radius',
		);

		$this->options['st_two_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_two',
		);

		$this->options['st_two_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_two',
		);

		$this->options['st_two_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_two',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_two_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_two',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_two_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_two',
			'selectors'      => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two:not(.hover-gradient):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two.hover-gradient:before',
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

		$this->options['st_two_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_two',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two:hover',
		);

		$this->options['st_two_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_two',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two:hover',
		);

		$this->options['st_two_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_two',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_two_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_two',
		);

		$this->options['st_two_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_two',
		);

		$this->options['st_two_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_two',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two',
			'attribute' => 'padding',
			'separator' => 'before',
		);

		$this->options['st_two_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_two',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two',
			'attribute' => 'margin',
		);

		$this->options['sg_two_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'default'    => 'center',
			'segment'    => 'style_two',
			'options'    => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-two',
			'attribute'  => 'text-align',
		);

		$this->options['st_middle_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_middle',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-middle-text',
		);

		$this->options['st_middle_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_middle',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-middle-text',
		);

		$this->options['st_middle_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_middle',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-middle-text',
		);

		$this->options['st_middle_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_middle',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-middle-text',
			'attribute' => 'border-radius',
		);

		$this->options['st_middle_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_middle',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-middle-text',
			'separator' => 'before',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_middle_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_middle',
			'selectors' => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-middle-text',
		);

		$this->options['st_middle_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_middle',
			'options'    => array(
				'min'  => 0,
				'max'  => 140,
				'step' => 1,
			),
			'default'    => 40,
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-middle-text',
			'attribute'  => 'width',
		);

		$this->options['st_middle_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_middle',
			'options'    => array(
				'min'  => 0,
				'max'  => 140,
				'step' => 1,
			),
			'default'    => 40,
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-dual-button .jkit-dual-button-wrapper .jkit-dual-button-middle-text',
			'attribute'  => 'height',
		);

		parent::additional_style();
	}
}
