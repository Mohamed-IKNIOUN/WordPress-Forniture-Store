<?php
/**
 * Client Logo Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Client_Logo_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Client_Logo_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Client Logo', 'jeg-elementor-kit' );
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

		$this->segments['segment_logo'] = array(
			'name'     => esc_html__( 'Logo', 'jeg-elementor-kit' ),
			'priority' => 11,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_container'] = array(
			'name'      => esc_html__( 'Container', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_logo'] = array(
			'name'      => esc_html__( 'Logo', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_arrow'] = array(
			'name'      => esc_html__( 'Arrow', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_dots'] = array(
			'name'      => esc_html__( 'Dots', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_setting_margin'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'segment_setting',
			'default'    => 10,
			'options'    => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'responsive' => true,
		);

		$this->options['sg_setting_slide_show'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Slide to Show', 'jeg-elementor-kit' ),
			'segment'    => 'segment_setting',
			'default'    => 3,
			'options'    => array(
				'min'  => 1,
				'max'  => 10,
				'step' => 1,
			),
			'responsive' => true,
		);

		$this->options['sg_setting_autoplay'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Autoplay', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
		);

		$this->options['sg_setting_autoplay_speed'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Speed (ms)', 'jeg-elementor-kit' ),
			'segment'    => 'segment_setting',
			'default'    => 3500,
			'options'    => array(
				'min'  => 1000,
				'max'  => 15000,
				'step' => 100,
			),
			'dependency' => array(
				array(
					'field'    => 'sg_setting_autoplay',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_setting_autoplay_pause'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Pause on Hover', 'jeg-elementor-kit' ),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_autoplay',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_setting_arrow'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Arrow', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
		);

		$this->options['sg_setting_arrow_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Position', 'jeg-elementor-kit' ),
			'default'    => 'bottom-middle',
			'segment'    => 'segment_setting',
			'options'    => array(
				'bottom-middle' => esc_html__( 'Bottom Middle', 'jeg-elementor-kit' ),
				'bottom-edge'   => esc_html__( 'Bottom Edge', 'jeg-elementor-kit' ),
				'middle-edge'   => esc_html__( 'Middle Edge', 'jeg-elementor-kit' ),
				'top-left'      => esc_html__( 'Top Left', 'jeg-elementor-kit' ),
				'top-right'     => esc_html__( 'Top Right', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_setting_arrow',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_setting_arrow_left'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Arrow Left', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-angle-left',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_arrow',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_setting_arrow_right'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Arrow Right', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-angle-right',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_arrow',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_setting_dots'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Dots', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
		);

		$this->options['sg_logo_image_size'] = array(
			'type'    => 'imagesize',
			'title'   => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
			'segment' => 'segment_logo',
			'default' => 'medium',
		);

		$this->options['sg_logo_list'] = array(
			'type'        => 'repeater',
			'title'       => esc_html__( 'Repeater List', 'jeg-elementor-kit' ),
			'segment'     => 'segment_logo',
			'title_field' => '{{ sg_logo_list_title }}',
			'fields'      => array(
				'sg_logo_list_title'        => array(
					'type'    => 'text',
					'segment' => 'sg_logo_list',
					'title'   => esc_html__( 'Title', 'jeg-elementor-kit' ),
					'default' => esc_html__( 'Title', 'jeg-elementor-kit' ),
				),
				'sg_logo_list_image'        => array(
					'type'    => 'image',
					'segment' => 'sg_logo_list',
					'title'   => esc_html__( 'Client Logo', 'jeg-elementor-kit' ),
				),
				'sg_logo_list_hover_enable' => array(
					'type'    => 'checkbox',
					'segment' => 'sg_logo_list',
					'title'   => esc_html__( 'Enable Hover Logo', 'jeg-elementor-kit' ),
				),
				'sg_logo_list_hover_logo'   => array(
					'type'       => 'image',
					'segment'    => 'sg_logo_list',
					'title'      => esc_html__( 'Hover Logo', 'jeg-elementor-kit' ),
					'dependency' => array(
						array(
							'field'    => 'sg_logo_list_hover_enable',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'sg_logo_list_link_enable'  => array(
					'type'    => 'checkbox',
					'segment' => 'sg_logo_list',
					'title'   => esc_html__( 'Enable Link', 'jeg-elementor-kit' ),
				),
				'sg_logo_list_link'         => array(
					'type'       => 'link',
					'segment'    => 'sg_logo_list',
					'title'      => esc_html__( 'Link', 'jeg-elementor-kit' ),
					'dependency' => array(
						array(
							'field'    => 'sg_logo_list_link_enable',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
			),
			'default'     => array(
				array(
					'sg_logo_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_logo_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_logo_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_logo_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_logo_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_container_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-client-logo',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_container_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-client-logo',
			'attribute' => 'padding',
		);

		$this->options['st_container_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-client-logo',
			'attribute' => 'margin',
		);

		$this->options['st_container_min_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Min Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_container',
			'default'    => 0,
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-client-logo .client-track .image-list',
			'attribute'  => 'min-height',
			'responsive' => true,
		);

		$this->options['st_logo_fix_height'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Fix Height', 'jeg-elementor-kit' ),
			'segment' => 'style_logo',
		);

		$this->options['st_logo_fix_height_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_logo',
			'default'    => 100,
			'options'    => array(
				'min'  => 0,
				'max'  => 400,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-client-logo .tns-item img',
			'attribute'  => 'height',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'st_logo_fix_height',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_logo_fix_height_object_fit'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Object Fit', 'jeg-elementor-kit' ),
			'default'    => 'cover',
			'segment'    => 'style_logo',
			'options'    => array(
				'cover'      => esc_html__( 'Cover', 'jeg-elementor-kit' ),
				'contain'    => esc_html__( 'Contain', 'jeg-elementor-kit' ),
				'fill'       => esc_html__( 'Fill', 'jeg-elementor-kit' ),
				'scale-down' => esc_html__( 'Scale Down', 'jeg-elementor-kit' ),
				'none'       => esc_html__( 'None', 'jeg-elementor-kit' ),
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-client-logo .tns-item img',
			'attribute'  => 'object-fit',
			'dependency' => array(
				array(
					'field'    => 'st_logo_fix_height',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_logo_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_logo',
		);

		$this->options['st_logo_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_logo',
		);

		$this->options['st_logo_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .client-slider .image-list',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_logo_normal_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .client-slider .image-list',
			'attribute' => 'padding',
		);

		$this->options['st_logo_normal_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .client-slider .image-list',
			'attribute' => 'margin',
		);

		$this->options['st_logo_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .client-slider .image-list',
			'attribute' => 'border-radius',
		);

		$this->options['st_logo_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .client-slider.tns-slide-active .image-list',
		);

		$this->options['st_logo_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .client-slider .image-list',
		);

		$this->options['st_logo_normal_opacity'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Normal Opacity', 'jeg-elementor-kit' ),
			'segment'      => 'style_logo',
			'default'      => 100,
			'default_unit' => '%',
			'responsive'   => true,
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'    => '.jeg-elementor-kit.jkit-client-logo .client-slider .image-list',
			'attribute'    => 'opacity',
			'units'        => array( '%' ),
		);

		$this->options['st_logo_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_logo',
		);

		$this->options['st_logo_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_logo',
		);

		$this->options['st_logo_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .client-slider .image-list' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_logo_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .client-slider:hover .image-list',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_logo_hover_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .client-slider:hover .image-list',
			'attribute' => 'padding',
		);

		$this->options['st_logo_hover_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .client-slider:hover .image-list',
			'attribute' => 'margin',
		);

		$this->options['st_logo_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .client-slider:hover .image-list',
			'attribute' => 'border-radius',
		);

		$this->options['st_logo_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .client-slider.tns-slide-active:hover .image-list',
		);

		$this->options['st_logo_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_logo',
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .client-slider:hover .image-list',
		);

		$this->options['st_logo_hover_opacity'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Hover Opacity', 'jeg-elementor-kit' ),
			'segment'      => 'style_logo',
			'default'      => 100,
			'default_unit' => '%',
			'responsive'   => true,
			'units'        => array( '%' ),
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'    => '.jeg-elementor-kit.jkit-client-logo .client-slider:hover .image-list',
			'attribute'    => 'opacity',
		);

		$this->options['st_logo_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_logo',
		);

		$this->options['st_logo_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_logo',
		);

		$this->options['st_arrow_font_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Font Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_arrow',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button span'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_arrow',
		);

		$this->options['st_arrow_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_arrow',
		);

		$this->options['st_arrow_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_arrow',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button span'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_arrow_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_arrow',
			'selectors'      => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button span',
			),
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

		$this->options['st_arrow_normal_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_normal_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button span',
			),
		);

		$this->options['st_arrow_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button span',
			),
		);

		$this->options['st_arrow_normal_opacity'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Normal Opacity', 'jeg-elementor-kit' ),
			'segment'      => 'style_arrow',
			'default'      => 100,
			'default_unit' => '%',
			'responsive'   => true,
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'units'        => array( '%' ),
			'selectors'    => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button span' => 'opacity: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_arrow',
		);

		$this->options['st_arrow_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_arrow',
		);

		$this->options['st_arrow_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button span, {{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button i, {{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button svg' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_arrow_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_arrow',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button:hover span'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_arrow_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_arrow',
			'selectors'      => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button:hover span:not(.hover-gradient), {{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button span.hover-gradient:before',
			),
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

		$this->options['st_arrow_hover_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'units'     => array( 'px', '%', 'em' ),
			'attribute' => 'padding',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button:hover span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_hover_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button:hover span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button:hover span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button:hover span',
			),
		);

		$this->options['st_arrow_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-controls button:hover span',
			),
		);

		$this->options['st_arrow_hover_opacity'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Hover Opacity', 'jeg-elementor-kit' ),
			'segment'      => 'style_arrow',
			'default'      => 100,
			'default_unit' => '%',
			'responsive'   => true,
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'attribute'    => 'opacity',
			'units'        => array( '%' ),
			'selectors'    => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo:hover .tns-controls button span' => 'opacity: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_arrow',
		);

		$this->options['st_arrow_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_arrow',
		);

		$this->options['st_dots_spacing_horizontal'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Spacing Horizontal', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-client-logo .tns-nav button' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2); margin-right: calc({{SIZE}}{{UNIT}} / 2);',
				),
			),
			'responsive' => true,
		);

		$this->options['st_dots_spacing_vertical'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Spacing Vertical', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-client-logo .tns-nav button',
			'attribute'  => 'margin-top',
			'responsive' => true,
		);

		$this->options['st_dots_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_dots',
		);

		$this->options['st_dots_general_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'General', 'jeg-elementor-kit' ),
			'segment' => 'style_dots',
		);

		$this->options['st_dots_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-client-logo .tns-nav button',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_dots_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-client-logo .tns-nav button',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_dots_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_dots',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .tns-nav button',
			'attribute' => 'border-radius',
		);

		$this->options['st_dots_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
			'responsive' => true,
			'attribute'  => 'background-color',
			'selectors'  => '.jeg-elementor-kit.jkit-client-logo .tns-nav button',
		);

		$this->options['st_dots_general_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_dots',
		);

		$this->options['st_dots_active_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Active', 'jeg-elementor-kit' ),
			'segment' => 'style_dots',
		);

		$this->options['st_dots_active_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Active Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-client-logo .tns-nav button.tns-nav-active',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_dots_active_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Active Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-client-logo .tns-nav button.tns-nav-active',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_dots_active_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Active Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_dots',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-client-logo .tns-nav button.tns-nav-active',
			'attribute' => 'border-radius',
		);

		$this->options['st_dots_active_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Active Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-client-logo .tns-nav button.tns-nav-active',
			'attribute'  => 'background-color',
		);

		$this->options['st_dots_active_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_dots',
		);

		$this->options['st_dots_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_dots',
		);

		parent::additional_style();
	}
}
