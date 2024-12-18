<?php
/**
 * Button Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.2.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Button_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Button_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Button', 'jeg-elementor-kit' );
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
		$this->segments['segment_content'] = array(
			'name'     => esc_html__( 'Content', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_button'] = array(
			'name'      => esc_html__( 'Button', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_border'] = array(
			'name'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_shadow'] = array(
			'name'      => esc_html__( 'Shadow', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_icon'] = array(
			'name'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_content_label'] = array(
			'type'        => 'text',
			'title'       => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'default'     => esc_html__( 'Click Here ', 'jeg-elementor-kit' ),
			'segment'     => 'segment_content',
			'label_block' => false,
		);

		$this->options['sg_content_link'] = array(
			'type'    => 'link',
			'title'   => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
		);

		$this->options['sg_content_icon_enable'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Add Icon', 'jeg-elementor-kit' ),
			'segment'   => 'segment_content',
			'separator' => 'before',
		);

		$this->options['sg_content_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Choose Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_content',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_content_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'default'    => 'center',
			'segment'    => 'segment_content',
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
			'selectors'  => '.jeg-elementor-kit.jkit-button',
			'attribute'  => 'text-align',
			'separator'  => 'before',
		);

		$this->options['sg_content_class'] = array(
			'type'        => 'text',
			'title'       => esc_html__( 'Class', 'jeg-elementor-kit' ),
			'segment'     => 'segment_content',
			'label_block' => false,
		);

		$this->options['sg_content_id'] = array(
			'type'        => 'text',
			'title'       => esc_html__( 'ID', 'jeg-elementor-kit' ),
			'segment'     => 'segment_content',
			'label_block' => false,
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_button_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_button_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper',
			'attribute' => 'padding',
		);

		$this->options['st_button_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper',
		);

		$this->options['st_button_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_button',
		);

		$this->options['st_button_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_button',
		);

		$this->options['st_button_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Normal Background Color', 'jeg-elementor-kit' ),
			'segment'        => 'style_button',
			'selectors'      => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper',
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

		$this->options['st_button_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper',
		);

		$this->options['st_button_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_button',
		);

		$this->options['st_button_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_button',
		);

		$this->options['st_button_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper, {{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper i' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_button_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Hover Background Color', 'jeg-elementor-kit' ),
			'segment'        => 'style_button',
			'selectors'      => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper:not(.hover-gradient):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper.hover-gradient:before',
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

		$this->options['st_button_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover',
		);

		$this->options['st_button_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_button',
		);

		$this->options['st_button_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_button',
		);

		$this->options['st_border_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_border',
		);

		$this->options['st_border_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_border',
		);

		$this->options['st_border_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_border',
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper',
		);

		$this->options['st_border_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_border',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper',
			'attribute' => 'border-radius',
		);

		$this->options['st_border_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_border',
		);

		$this->options['st_border_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_border',
		);

		$this->options['st_border_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_border',
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover',
		);

		$this->options['st_border_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_border',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_border_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_border',
		);

		$this->options['st_border_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_border',
		);

		$this->options['st_shadow_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_shadow',
		);

		$this->options['st_shadow_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_shadow',
		);

		$this->options['st_shadow_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_shadow',
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper',
		);

		$this->options['st_shadow_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_shadow',
		);

		$this->options['st_shadow_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_shadow',
		);

		$this->options['st_shadow_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_shadow',
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover',
		);

		$this->options['st_shadow_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_shadow',
		);

		$this->options['st_shadow_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_shadow',
		);

		$this->options['st_icon_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em', 'custom' ),
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper i, {{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper svg',
			'attribute' => 'padding',
		);

		$this->options['st_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'responsive' => true,
		);

		$this->options['st_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', '%', 'em' ),
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button.icon-position-before .jkit-button-wrapper i, {{WRAPPER}} .jeg-elementor-kit.jkit-button.icon-position-before .jkit-button-wrapper svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button.icon-position-after .jkit-button-wrapper i, {{WRAPPER}} .jeg-elementor-kit.jkit-button.icon-position-after .jkit-button-wrapper svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_icon_vertical_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Vertical Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => -100,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper i, {{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper svg' => '-webkit-transform: translateY({{SIZE}}{{UNIT}}); -ms-transform: translateY({{SIZE}}{{UNIT}}); -o-transform: translateY({{SIZE}}{{UNIT}}); -moz-transform: translateY({{SIZE}}{{UNIT}}); transform: translateY({{SIZE}}{{UNIT}});',
				),
			),
		);

		$this->options['st_icon_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper:not(:hover) > i'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper:not(:hover) > svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper > i, {{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper > svg',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_icon_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper > i, {{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper > svg',
		);

		$this->options['st_icon_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em', 'custom' ),
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper > i, {{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper > svg',
			'attribute' => 'border-radius',
		);

		$this->options['st_icon_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover i'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover > i, {{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover > svg',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_icon_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover > i, {{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover > svg',
		);

		$this->options['st_icon_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em', 'custom' ),
			'selectors' => '.jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover > i, {{WRAPPER}} .jeg-elementor-kit.jkit-button .jkit-button-wrapper:hover > svg',
			'attribute' => 'border-radius',
		);

		$this->options['st_icon_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_icon',
		);

		parent::additional_style();
	}
}
