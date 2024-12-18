<?php
/**
 * Pie Chart Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Pie_Chart_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Pie_Chart_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Pie Chart', 'jeg-elementor-kit' );
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
		$this->segments['style_content'] = array(
			'name'      => esc_html__( 'Content', 'jeg-elementor-kit' ),
			'priority'  => 10,
			'kit_style' => true,
		);

		$this->segments['style_flip'] = array(
			'name'       => esc_html__( 'Flip Card', 'jeg-elementor-kit' ),
			'priority'   => 11,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_content_pie_chart_type',
					'operator' => '==',
					'value'    => 'flip',
				),
			),
		);

		$this->segments['style_chart'] = array(
			'name'      => esc_html__( 'Chart', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_content_chart'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Chart Content', 'jeg-elementor-kit' ),
			'default' => 'percentage',
			'segment' => 'segment_content',
			'options' => array(
				'none'       => esc_html__( 'None', 'jeg-elementor-kit' ),
				'percentage' => esc_html__( 'Percentage', 'jeg-elementor-kit' ),
				'icon'       => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_content_icon_type'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Icon Type', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => 'icon',
			'options'    => array(
				'icon'  => array(
					'title' => esc_html__( 'Icon', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-icons',
				),
				'image' => array(
					'title' => esc_html__( 'Image', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-image',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_chart',
					'operator' => '==',
					'value'    => 'icon',
				),
			),
		);

		$this->options['sg_content_icon_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Choose Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-chart-area',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_chart',
					'operator' => '==',
					'value'    => 'icon',
				),
				array(
					'field'    => 'sg_content_icon_type',
					'operator' => '==',
					'value'    => 'icon',
				),
			),
		);

		$this->options['sg_content_icon_image'] = array(
			'type'       => 'image',
			'title'      => esc_html__( 'Choose Image ', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => \Elementor\Utils::get_placeholder_image_src(),
			'dependency' => array(
				array(
					'field'    => 'sg_content_chart',
					'operator' => '==',
					'value'    => 'icon',
				),
				array(
					'field'    => 'sg_content_icon_type',
					'operator' => '==',
					'value'    => 'image',
				),
			),
		);

		$this->options['sg_content_image_size'] = array(
			'type'       => 'imagesize',
			'title'      => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_chart',
					'operator' => '==',
					'value'    => 'icon',
				),
				array(
					'field'    => 'sg_content_icon_type',
					'operator' => '==',
					'value'    => 'image',
				),
			),
		);

		$this->options['sg_content_percentage'] = array(
			'type'    => 'slider',
			'title'   => esc_html__( 'Percentage', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
			'default' => 80,
			'options' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		);

		$this->options['sg_content_animation_duration'] = array(
			'type'    => 'slider',
			'title'   => esc_html__( 'Animation Duration', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
			'default' => 3600,
			'options' => array(
				'min'  => 100,
				'max'  => 10000,
				'step' => 1,
			),
		);

		$this->options['sg_content_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Content', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
		);

		$this->options['sg_content_title_html_tag'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Title HTML Tag', 'jeg-elementor-kit' ),
			'default'    => 'h2',
			'segment'    => 'segment_content',
			'options'    => array(
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
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_title'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => esc_html__( 'Pie Chart', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_description'] = array(
			'type'       => 'textarea',
			'title'      => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_pie_chart_type'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Content Type', 'jeg-elementor-kit' ),
			'default'    => 'static',
			'segment'    => 'segment_content',
			'options'    => array(
				'static'      => esc_html__( 'Static', 'jeg-elementor-kit' ),
				'flip'        => esc_html__( 'Flip Card', 'jeg-elementor-kit' ),
				'float_right' => esc_html__( 'Float Right', 'jeg-elementor-kit' ),
				'float_left'  => esc_html__( 'Float Left', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
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
		$this->options['st_content_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
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
			'default'    => 'center',
			'selectors'  => '.jeg-elementor-kit.jkit-pie-chart',
			'attribute'  => 'text-align',
		);

		$this->options['st_content_justify'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Justify', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'options'    => array(
				'flex-start'    => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'        => array(
					'title' => esc_html__( 'Center', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end'      => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-right',
				),
				'space-between' => array(
					'title' => esc_html__( 'Justify', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-justify',
				),
			),
			'responsive' => true,
			'default'    => 'center',
			'selectors'  => '.jeg-elementor-kit.jkit-pie-chart .chart-float',
			'attribute'  => 'justify-content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_pie_chart_type',
					'operator' => 'in',
					'value'    => array( 'float_right', 'float_left' ),
				),
			),
		);

		$this->options['st_content_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart',
			'attribute' => 'padding',
		);

		$this->options['st_content_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart',
			'attribute' => 'margin',
		);

		$this->options['st_content_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart',
			'attribute' => 'border-radius',
		);

		$this->options['st_content__spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Content Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-pie-chart .chart-float.content-right .chart-content, {{WRAPPER}} .jeg-elementor-kit.jkit-pie-chart .chart-float.content-left .chart-diagram' => 'padding-left: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_pie_chart_type',
					'operator' => 'in',
					'value'    => array( 'float_right', 'float_left' ),
				),
			),
		);

		$this->options['st_content_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_content',
		);

		$this->options['st_content_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_content',
		);

		$this->options['st_content_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_content_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart',
		);

		$this->options['st_content_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart',
		);

		$this->options['st_content_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_content',
		);

		$this->options['st_content_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_content',
		);

		$this->options['st_content_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_content_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart:hover',
		);

		$this->options['st_content_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart:hover',
		);

		$this->options['st_content_hover_animation'] = array(
			'type'    => 'hoveranimation',
			'title'   => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment' => 'style_content',
		);

		$this->options['st_content_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_content',
		);

		$this->options['st_content_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_content',
		);

		$this->options['st_content_title_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_content_title_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Title Color', 'jeg-elementor-kit' ),
			'selectors'  => '.jeg-elementor-kit.jkit-pie-chart .pie-chart-title',
			'responsive' => true,
			'segment'    => 'style_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_content_title_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Title Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'selectors'  => '.jeg-elementor-kit.jkit-pie-chart .pie-chart-title',
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_content_title_margin'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Title Margin', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-pie-chart .pie-chart-title',
			'attribute'  => 'margin',
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_content_description_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_content_description_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Description Color', 'jeg-elementor-kit' ),
			'selectors'  => '.jeg-elementor-kit.jkit-pie-chart .pie-chart-description',
			'responsive' => true,
			'segment'    => 'style_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_content_description_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Description Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'selectors'  => '.jeg-elementor-kit.jkit-pie-chart .pie-chart-description',
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_content_description_margin'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Description Margin', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-pie-chart .pie-chart-description',
			'attribute'  => 'margin',
			'dependency' => array(
				array(
					'field'    => 'sg_content_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_flip_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_flip',
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart .content-back',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_flip_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_flip',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart .content-back',
			'attribute' => 'padding',
		);

		$this->options['st_flip_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_flip',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart .content-back',
			'attribute' => 'border-radius',
		);

		$this->options['st_flip_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_flip',
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart .content-back',
		);

		$this->options['st_flip_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_flip',
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart .content-back',
		);

		$this->options['st_chart_size_responsive_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Responsive Size', 'jeg-elementor-kit' ),
			'segment' => 'style_chart',
		);

		$this->options['st_chart_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Pie Chart Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_chart',
			'default'    => 150,
			'options'    => array(
				'min'  => 100,
				'max'  => 250,
				'step' => 1,
			),
			'dependency' => array(
				array(
					'field'    => 'st_chart_size_responsive_enable!',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_chart_size_enable'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Pie Chart Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_chart',
			'default'    => 150,
			'options'    => array(
				'min'  => 100,
				'max'  => 250,
				'step' => 1,
			),
			'responsive' => true,
			'units'      => array( 'px', 'em' ),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-pie-chart .pie-chart-wrapper' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'st_chart_size_responsive_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_chart_cutout'] = array(
			'type'    => 'slider',
			'title'   => esc_html__( 'Cutout Percentage', 'jeg-elementor-kit' ),
			'segment' => 'style_chart',
			'default' => 90,
			'options' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		);

		$this->options['st_chart_bar_color_type'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Chart Color', 'jeg-elementor-kit' ),
			'default' => 'normal',
			'segment' => 'style_chart',
			'options' => array(
				'normal'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
				'gradient' => esc_html__( 'Gradient', 'jeg-elementor-kit' ),
			),
		);

		$this->options['st_chart_bar_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Bar Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_chart',
			'dependency' => array(
				array(
					'field'    => 'st_chart_bar_color_type',
					'operator' => '==',
					'value'    => 'normal',
				),
			),
		);

		$this->options['st_chart_bar_gradient_color1'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Gradient Color 1', 'jeg-elementor-kit' ),
			'segment'    => 'style_chart',
			'dependency' => array(
				array(
					'field'    => 'st_chart_bar_color_type',
					'operator' => '==',
					'value'    => 'gradient',
				),
			),
		);

		$this->options['st_chart_bar_gradient_color2'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Gradient Color 2', 'jeg-elementor-kit' ),
			'segment'    => 'style_chart',
			'dependency' => array(
				array(
					'field'    => 'st_chart_bar_color_type',
					'operator' => '==',
					'value'    => 'gradient',
				),
			),
		);

		$this->options['st_chart_bar_background'] = array(
			'type'    => 'color',
			'title'   => esc_html__( 'Bar Background', 'jeg-elementor-kit' ),
			'segment' => 'style_chart',
		);

		$this->options['st_chart_content_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Content Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_chart',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-pie-chart .pie-chart-content'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-pie-chart .pie-chart-content svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_chart_content_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Content Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_chart',
			'selectors' => '.jeg-elementor-kit.jkit-pie-chart .pie-chart-content',
		);

		$this->options['st_chart_image_width'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Image Width (%)', 'jeg-elementor-kit' ),
			'segment'      => 'style_chart',
			'default'      => 100,
			'default_unit' => '%',
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'units'        => array( '%' ),
			'responsive'   => true,
			'selectors'    => '.jeg-elementor-kit.jkit-pie-chart .pie-chart-content img',
			'attribute'    => 'max-width',
			'dependency'   => array(
				array(
					'field'    => 'sg_content_chart',
					'operator' => '==',
					'value'    => 'icon',
				),
				array(
					'field'    => 'sg_content_icon_type',
					'operator' => '==',
					'value'    => 'image',
				),
			),
		);

		$this->options['st_chart_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_chart',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'units'      => array( 'px', 'em' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-pie-chart .pie-chart-content i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-pie-chart .pie-chart-content svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_chart',
					'operator' => '==',
					'value'    => 'icon',
				),
				array(
					'field'    => 'sg_content_icon_type',
					'operator' => '==',
					'value'    => 'icon',
				),
			),
		);

		parent::additional_style();
	}
}
