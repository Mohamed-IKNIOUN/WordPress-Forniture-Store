<?php
/**
 * Fun Fact Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Fun_Fact_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Fun_Fact_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Fun Fact', 'jeg-elementor-kit' );
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
		$this->segments['segment_setting'] = array(
			'name'     => esc_html__( 'Setting', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->segments['segment_icon'] = array(
			'name'     => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'priority' => 11,
		);

		$this->segments['segment_content'] = array(
			'name'     => esc_html__( 'Content', 'jeg-elementor-kit' ),
			'priority' => 12,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_icon'] = array(
			'name'       => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'priority'   => 11,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_icon_type!',
					'operator' => '==',
					'value'    => 'none',
				),
			),
		);

		$this->segments['style_content'] = array(
			'name'      => esc_html__( 'Content', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_super'] = array(
			'name'      => esc_html__( 'Super', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_background'] = array(
			'name'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_setting_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Text Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'segment_setting',
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
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact',
			'attribute'  => 'text-align',
			'default'    => 'center',
		);

		$this->options['sg_setting_justify_content'] = array(
			'type'      => 'select',
			'title'     => esc_html__( 'Justify Content', 'jeg-elementor-kit' ),
			'default'   => 'normal',
			'segment'   => 'segment_setting',
			'options'   => array(
				'normal'        => 'Normal',
				'center'        => 'Center',
				'flex-start'    => 'Flex Start',
				'flex-end'      => 'Flex End',
				'space-between' => 'Space Between',
				'space-arroung' => 'Space Arround',
				'space-evenly'  => 'Space Evenly',
			),
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner',
			'attribute' => 'justify-content',
		);

		$this->options['sg_setting_align_items'] = array(
			'type'      => 'select',
			'title'     => esc_html__( 'Align Items', 'jeg-elementor-kit' ),
			'default'   => 'normal',
			'segment'   => 'segment_setting',
			'options'   => array(
				'normal'     => 'Normal',
				'center'     => 'Center',
				'flex-start' => 'Flex Start',
				'flex-end'   => 'Flex End',
				'stretch'    => 'Stretch',
				'baseline'   => 'Baseline',
			),
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner',
			'attribute' => 'align-items',
		);

		$this->options['sg_setting_html_tag'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Title HTML Tag', 'jeg-elementor-kit' ),
			'default' => 'h2',
			'segment' => 'segment_setting',
			'options' => array(
				'h1'   => 'H1',
				'h2'   => 'H2',
				'h3'   => 'H3',
				'h4'   => 'H4',
				'h5'   => 'H5',
				'h6'   => 'H6',
				'div'  => 'div',
				'span' => 'span',
				'p'    => 'p',
			),
		);

		$this->options['sg_setting_number_aniamtion_duration'] = array(
			'type'    => 'slider',
			'title'   => esc_html__( 'Number Animation Duration', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
			'default' => 3500,
			'options' => array(
				'min'  => 0,
				'max'  => 10000,
				'step' => 1,
			),
		);

		$this->options['sg_setting_enable_hover_border_bottom'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Hover Border Bottom', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
		);

		$this->options['sg_setting_hover_border_bottom_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Border Bottom Color', 'jeg-elementor-kit' ),
			'segment'    => 'segment_setting',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .border-bottom',
			'attribute'  => 'background-color',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_enable_hover_border_bottom',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_setting_hover_direction'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Hover Direction', 'jeg-elementor-kit' ),
			'default'    => 'top',
			'segment'    => 'segment_setting',
			'default'    => 'left',
			'options'    => array(
				'left'  => esc_html__( 'From Left', 'jeg-elementor-kit' ),
				'right' => esc_html__( 'From Right', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_setting_enable_hover_border_bottom',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_icon_type'] = array(
			'type'    => 'radio',
			'title'   => esc_html__( 'Icon Type', 'jeg-elementor-kit' ),
			'segment' => 'segment_icon',
			'default' => 'icon',
			'options' => array(
				'none'  => array(
					'title' => esc_html__( 'None', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-ban',
				),
				'icon'  => array(
					'title' => esc_html__( 'Icon', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-icons',
				),
				'image' => array(
					'title' => esc_html__( 'Image', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-image',
				),
			),
		);

		$this->options['sg_icon_choose'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Choose Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-grip-horizontal',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_type',
					'operator' => '==',
					'value'    => 'icon',
				),
			),
		);

		$this->options['sg_icon_image'] = array(
			'type'       => 'image',
			'title'      => esc_html__( 'Choose Image ', 'jeg-elementor-kit' ),
			'segment'    => 'segment_icon',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_type',
					'operator' => '==',
					'value'    => 'image',
				),
			),
		);

		$this->options['sg_icon_image_size'] = array(
			'type'       => 'imagesize',
			'title'      => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
			'segment'    => 'segment_icon',
			'default'    => 'thumbnail',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_type',
					'operator' => '==',
					'value'    => 'image',
				),
			),
		);

		$this->options['sg_icon_image_position'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Icon/Image Position', 'jeg-elementor-kit' ),
			'segment'    => 'segment_icon',
			'options'    => array(
				'row'            => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-left',
				),
				'column'         => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-top',
				),
				'row-reverse'    => array(
					'title' => esc_html__( 'right', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-right',
				),
				'column-reverse' => array(
					'title' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-bottom',
				),
			),
			'default'    => 'column',
			'toggle'     => false,
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner',
			'attribute'  => 'flex-direction',
			'responsive' => true,
		);

		$this->options['sg_content_number_prefix'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Number Prefix', 'jeg-elementor-kit' ),
			'default' => '$',
			'segment' => 'segment_content',
		);

		$this->options['sg_content_number'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Number', 'jeg-elementor-kit' ),
			'default' => '789',
			'segment' => 'segment_content',
		);

		$this->options['sg_content_number_suffix'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Number Suffix', 'jeg-elementor-kit' ),
			'default' => 'M',
			'segment' => 'segment_content',
		);

		$this->options['sg_content_title'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'default' => esc_html__( 'Fun Fact', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
		);

		$this->options['sg_setting_enable_super'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Super', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
		);

		$this->options['sg_content_super'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Super', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => '+',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_enable_super',
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
		$this->options['st_icon_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-fun-fact .fun-fact-inner > .icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-fun-fact .fun-fact-inner > .icon svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_bg_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Background Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner > .icon',
			'attribute'  => 'background-color',
		);

		$this->options['st_icon_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner > .icon',
		);

		$this->options['st_icon_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner > .icon',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-fun-fact:hover .fun-fact-inner > .icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-fun-fact:hover .fun-fact-inner > .icon svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_hover_bg_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Background Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact:hover .fun-fact-inner > .icon',
			'attribute'  => 'background-color',
		);

		$this->options['st_icon_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact:hover .fun-fact-inner > .icon',
		);

		$this->options['st_icon_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact:hover .fun-fact-inner > .icon',
			'attribute' => 'border-radius',
		);

		$this->options['st_icon_hover_animation'] = array(
			'type'    => 'hoveranimation',
			'title'   => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'default'    => 40,
			'options'    => array(
				'min'  => 6,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'separator'  => 'before',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-fun-fact .fun-fact-inner > .icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-fun-fact .fun-fact-inner > .icon svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_icon_rotate'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Rotate', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 360,
				'step' => 1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-fun-fact .fun-fact-inner > .icon' => '-webkit-transform: rotate({{SIZE}}deg); -o-transform: rotate({{SIZE}}deg); -moz-transform: rotate({{SIZE}}deg); -ms-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
				),
			),
			'attribute'  => 'rotation',
			'responsive' => true,
		);

		$this->options['st_icon_image_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Image Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner > .icon img',
			'attribute'  => 'width',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'sg_icon_type',
					'operator' => '==',
					'value'    => 'image',
				),
			),
		);

		$this->options['st_icon_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner > .icon',
			'attribute' => 'margin',
		);

		$this->options['st_icon_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner > .icon',
			'attribute' => 'padding',
		);

		$this->options['st_icon_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner > .icon',
		);

		$this->options['st_content_number_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Number Count', 'jeg-elementor-kit' ),
			'segment' => 'style_content',
		);

		$this->options['st_content_number_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Number Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper',
		);

		$this->options['st_content_number_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Number Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper',
		);

		$this->options['st_content_number_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper',
			'attribute'  => 'margin-bottom',
			'responsive' => true,
		);

		$this->options['st_content_number_right_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Right Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper .number',
			'attribute'  => 'margin-right',
			'responsive' => true,
		);

		$this->options['st_content_prefix_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Prefix', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'separator' => 'before',
		);

		$this->options['st_content_prefix_margin'] = array(
			'type'               => 'dimension',
			'title'              => esc_html__( 'Prefix Margin', 'jeg-elementor-kit' ),
			'segment'            => 'style_content',
			'allowed_dimensions' => array( 'left', 'right' ),
			'units'              => array( 'px', '%', 'em' ),
			'selectors'          => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper .prefix',
			'attribute'          => 'margin',
		);

		$this->options['st_content_prefix_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Prefix Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper .prefix',
		);

		$this->options['st_content_prefix_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Prefix Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper .prefix',
		);

		$this->options['st_content_suffix_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Suffix', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'separator' => 'before',
		);

		$this->options['st_content_suffix_margin'] = array(
			'type'               => 'dimension',
			'title'              => esc_html__( 'Prefix Margin', 'jeg-elementor-kit' ),
			'segment'            => 'style_content',
			'allowed_dimensions' => array( 'left', 'right' ),
			'units'              => array( 'px', '%', 'em' ),
			'selectors'          => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper .suffix',
			'attribute'          => 'margin',
		);

		$this->options['st_content_suffix_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Suffix Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper .suffix',
		);

		$this->options['st_content_suffix_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Suffix Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper .suffix',
		);

		$this->options['st_content_title_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'separator' => 'before',
		);

		$this->options['st_content_title_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .title',
			'attribute'  => 'margin-bottom',
			'responsive' => true,
		);

		$this->options['st_content_title_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Title Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .title',
		);

		$this->options['st_content_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Title Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .title',
		);

		$this->options['st_content_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Content', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'separator' => 'before',
		);

		$this->options['st_content_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content',
			'attribute' => 'padding',
		);

		$this->options['st_super_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_super',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper .super',
		);

		$this->options['st_super_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_super',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper .super',
		);

		$this->options['st_super_top'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Top', 'jeg-elementor-kit' ),
			'segment'    => 'style_super',
			'default'    => -5,
			'options'    => array(
				'min'  => -100,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper .super',
			'attribute'  => 'top',
			'responsive' => true,
		);

		$this->options['st_super_left'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Horizontal Space', 'jeg-elementor-kit' ),
			'segment'    => 'style_super',
			'default'    => 0,
			'options'    => array(
				'min'  => -5,
				'max'  => 20,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper .super',
			'attribute'  => 'left',
			'responsive' => true,
		);

		$this->options['st_super_vertical_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Vertical Position', 'jeg-elementor-kit' ),
			'default'    => 'super',
			'segment'    => 'style_super',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-fun-fact .fun-fact-inner .content .number-wrapper .super',
			'attribute'  => 'vertical-align',
			'options'    => array(
				'super'    => esc_html__( 'Top', 'jeg-elementor-kit' ),
				'baseline' => esc_html__( 'Middle', 'jeg-elementor-kit' ),
				'sub'      => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
			),
		);

		$this->options['st_background_type'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_background',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_background_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_background',
			'units'     => array( 'px', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact',
			'attribute' => 'padding',
		);

		$this->options['st_background_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_background',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact',
		);

		$this->options['st_background_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_background',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact',
		);

		$this->options['st_background_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_background',
			'units'     => array( 'px', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact',
			'attribute' => 'border-radius',
		);

		$this->options['st_background_hover_animation'] = array(
			'type'    => 'hoveranimation',
			'title'   => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment' => 'style_background',
		);

		$this->options['st_background_overlay_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Background Overlay', 'jeg-elementor-kit' ),
			'segment'   => 'style_background',
			'separator' => 'before',
		);

		$this->options['st_background_overlay_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_background',
		);

		$this->options['st_background_overlay_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_background',
		);

		$this->options['st_background_overlay_color'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_background',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact:before',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_background_overlay_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_background',
		);

		$this->options['st_background_overlay_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_background',
		);

		$this->options['st_background_overlay_hover_color'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_background',
			'selectors' => '.jeg-elementor-kit.jkit-fun-fact:hover:before',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_background_hover_direction'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Hover Background Overlay Direction', 'jeg-elementor-kit' ),
			'segment' => 'style_background',
			'default' => 'left',
			'options' => array(
				'left'   => esc_html__( 'From Left', 'jeg-elementor-kit' ),
				'top'    => esc_html__( 'From Top', 'jeg-elementor-kit' ),
				'right'  => esc_html__( 'From Right', 'jeg-elementor-kit' ),
				'bottom' => esc_html__( 'From Bottom', 'jeg-elementor-kit' ),
				'arise'  => esc_html__( 'Arise', 'jeg-elementor-kit' ),
			),
		);

		$this->options['st_background_overlay_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_background',
		);

		$this->options['st_background_overlay_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_background',
		);

		parent::additional_style();
	}
}
