<?php
/**
 * Off Canvas Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.7.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Off_Canvas_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Off_Canvas_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Off-Canvas', 'jeg-elementor-kit' );
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

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_open'] = array(
			'name'      => esc_html__( 'Open Icon', 'jeg-elementor-kit' ),
			'priority'  => 10,
			'kit_style' => true,
		);

		$this->segments['style_close'] = array(
			'name'      => esc_html__( 'Close Icon', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_panel'] = array(
			'name'      => esc_html__( 'Off-Canvas Panel', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_setting_template'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Select Template', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
			'options' => jkit_get_elementor_saved_template_option(),
		);

		$this->options['sg_setting_overflow_hidden'] = array(
			'type'               => 'checkbox',
			'title'              => esc_html__( 'Overflow Hidden', 'jeg-elementor-kit' ),
			'segment'            => 'segment_setting',
			'frontend_available' => true,
		);

		$this->options['sg_setting_overlay_color'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Overlay Color', 'jeg-elementor-kit' ),
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .bg-overlay',
			'segment'   => 'segment_setting',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['sg_setting_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'segment_setting',
		);

		$this->options['sg_setting_open_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Open', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
		);

		$this->options['sg_setting_open_type'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Type', 'jeg-elementor-kit' ),
			'default' => 'icon',
			'segment' => 'segment_setting',
			'options' => array(
				'text' => esc_html__( 'Text', 'jeg-elementor-kit' ),
				'icon' => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_setting_open_text'] = array(
			'type'        => 'text',
			'title'       => esc_html__( 'Text', 'jeg-elementor-kit' ),
			'default'     => esc_html__( 'Open ', 'jeg-elementor-kit' ),
			'segment'     => 'segment_setting',
			'label_block' => false,
			'dependency'  => array(
				array(
					'field'    => 'sg_setting_open_type',
					'operator' => '==',
					'value'    => 'text',
				),
			),
		);

		$this->options['sg_setting_open_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-bars',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_open_type',
					'operator' => '==',
					'value'    => 'icon',
				),
			),
		);

		$this->options['sg_setting_open_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'segment_setting',
		);

		$this->options['sg_setting_close_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Close', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
		);

		$this->options['sg_setting_close_icon'] = array(
			'type'    => 'iconpicker',
			'title'   => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'default' => array(
				'value'   => 'fas fa-times',
				'library' => 'fa-solid',
			),
			'segment' => 'segment_setting',
		);

		$this->options['sg_setting_close_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'segment_setting',
		);

		$this->options['sg_setting_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'segment_setting',
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_open_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_open',
		);

		$this->options['st_open_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_open',
		);

		$this->options['st_open_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_open',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_open_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_open',
			'selectors'      => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button',
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

		$this->options['st_open_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_open',
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button',
		);

		$this->options['st_open_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_open',
		);

		$this->options['st_open_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_open',
		);

		$this->options['st_open_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_open',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_open_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_open',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_open_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_open',
			'selectors'      => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button:not(.hover-gradient):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button.hover-gradient:before',
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

		$this->options['st_open_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_open',
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button:hover',
		);

		$this->options['st_open_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_open',
		);

		$this->options['st_open_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_open',
		);

		$this->options['st_open_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_open',
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
			'selectors'  => '.jeg-elementor-kit.jkit-off-canvas .toggle-wrapper',
			'attribute'  => 'text-align',
			'default'    => 'left',
			'separator'  => 'before',
		);

		$this->options['st_open_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_open',
			'selectors'  => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_open_type',
					'operator' => '==',
					'value'    => 'text',
				),
			),
		);

		$this->options['st_open_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_open',
			'units'      => array( 'px' ),
			'default'    => 20,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_setting_open_type',
					'operator' => '==',
					'value'    => 'icon',
				),
			),
		);

		$this->options['st_open_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_open',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button',
			'attribute'  => 'width',
		);

		$this->options['st_open_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_open',
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button',
		);

		$this->options['st_open_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_open',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button',
			'attribute' => 'margin',
		);

		$this->options['st_open_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_open',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button',
			'attribute' => 'padding',
		);

		$this->options['st_open_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_open',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar-button',
			'attribute' => 'border-radius',
		);

		$this->options['st_close_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_close',
		);

		$this->options['st_close_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_close',
		);

		$this->options['st_close_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_close',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_close_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_close',
			'selectors'      => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button',
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

		$this->options['st_close_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button',
		);

		$this->options['st_close_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_close',
		);

		$this->options['st_close_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_close',
		);

		$this->options['st_close_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_close_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_close',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_close_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_close',
			'selectors'      => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button:not(.hover-gradient):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button.hover-gradient:before',
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

		$this->options['st_close_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button:hover',
		);

		$this->options['st_close_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_close',
		);

		$this->options['st_close_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_close',
		);

		$this->options['st_close_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button',
			'attribute'  => 'width',
			'separator'  => 'before',
		);

		$this->options['st_close_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
			'units'      => array( 'px' ),
			'default'    => 20,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_close_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
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
			'selectors'  => '.jeg-elementor-kit.jkit-off-canvas .widget-heading',
			'attribute'  => 'text-align',
			'default'    => 'left',
			'dependency' => array(
				array(
					'field'    => 'st_close_position_absolute!',
					'operator' => '==',
					'value'    => 'absolute',
				),
			),
		);

		$this->options['st_close_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button',
		);

		$this->options['st_close_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button',
			'attribute' => 'margin',
			'default'   => array(
				'top'      => '25',
				'right'    => '25',
				'bottom'   => '25',
				'left'     => '25',
				'unit'     => 'px',
				'isLinked' => true,
			),
		);

		$this->options['st_close_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button',
			'attribute' => 'padding',
		);

		$this->options['st_close_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .offcanvas-close-button',
			'attribute' => 'border-radius',
		);

		$this->options['st_close_position_absolute'] = array(
			'type'         => 'checkbox',
			'title'        => esc_html__( 'Position Absolute', 'jeg-elementor-kit' ),
			'segment'      => 'style_close',
			'return_value' => 'absolute',
			'prefix_class' => 'jkit-close-position-',
			'separator'    => 'before',
		);

		$this->options['st_close_position_horizontal_orientation'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Horizontal Orientation', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
			'options'    => array(
				'left'  => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-left',
				),
				'right' => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-right',
				),
			),
			'default'    => 'right',
			'toggle'     => false,
			'dependency' => array(
				array(
					'field'    => 'st_close_position_absolute',
					'operator' => '==',
					'value'    => 'absolute',
				),
			),
		);

		$this->options['st_close_position_horizontal_offset'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Offset', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 0,
			'selectors'  => array(
				'custom' => array( '{{WRAPPER}}.jkit-close-position-absolute .widget-heading' => '{{st_close_position_horizontal_orientation.VALUE}}: {{SIZE}}{{UNIT}};' ),
			),
			'dependency' => array(
				array(
					'field'    => 'st_close_position_absolute',
					'operator' => '==',
					'value'    => 'absolute',
				),
			),
		);

		$this->options['st_close_position_vertical_orientation'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Vertical Orientation', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
			'options'    => array(
				'top'    => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-top',
				),
				'bottom' => array(
					'title' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-bottom',
				),
			),
			'default'    => 'top',
			'toggle'     => false,
			'dependency' => array(
				array(
					'field'    => 'st_close_position_absolute',
					'operator' => '==',
					'value'    => 'absolute',
				),
			),
		);

		$this->options['st_close_position_vertical_offset'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Offset', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 0,
			'selectors'  => array(
				'custom' => array( '{{WRAPPER}}.jkit-close-position-absolute .widget-heading' => '{{st_close_position_vertical_orientation.VALUE}}: {{SIZE}}{{UNIT}};' ),
			),
			'dependency' => array(
				array(
					'field'    => 'st_close_position_absolute',
					'operator' => '==',
					'value'    => 'absolute',
				),
			),
		);

		$this->options['st_panel_position'] = array(
			'type'    => 'radio',
			'title'   => esc_html__( 'Position', 'jeg-elementor-kit' ),
			'segment' => 'style_panel',
			'default' => 'right',
			'options' => array(
				'top'    => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-chevron-up',
				),
				'bottom' => array(
					'title' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-chevron-down',
				),
				'left'   => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-chevron-left',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-chevron-right',
				),
			),
		);

		$this->options['st_panel_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_panel',
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .sidebar-widget',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_panel_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_panel',
			'units'      => array( 'px', '%' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 5000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar.position-left .sidebar-widget, {{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar.position-right .sidebar-widget' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'st_panel_position',
					'operator' => 'in',
					'value'    => array( 'left', 'right' ),
				),
			),
		);

		$this->options['st_panel_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_panel',
			'units'      => array( 'px', '%' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 5000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar.position-top .sidebar-widget, {{WRAPPER}} .jeg-elementor-kit.jkit-off-canvas .offcanvas-sidebar.position-bottom .sidebar-widget' => 'height: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'st_panel_position',
					'operator' => 'in',
					'value'    => array( 'top', 'bottom' ),
				),
			),
		);

		$this->options['st_panel_content_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Content Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_panel',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-off-canvas .widget-content',
			'attribute' => 'padding',
		);

		parent::additional_style();
	}
}
