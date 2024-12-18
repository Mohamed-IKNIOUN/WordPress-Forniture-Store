<?php
/**
 * Nav Menu Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Nav_Menu_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Nav_Menu_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Nav Menu', 'jeg-elementor-kit' );
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
		$this->segments['segment_menu'] = array(
			'name'     => esc_html__( 'Menu Settings', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->segments['segment_mobile_menu'] = array(
			'name'     => esc_html__( 'Mobile Menu Settings', 'jeg-elementor-kit' ),
			'priority' => 11,
		);
		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_menu_wrapper'] = array(
			'name'      => esc_html__( 'Menu Wrapper', 'jeg-elementor-kit' ),
			'priority'  => 10,
			'kit_style' => true,
		);

		$this->segments['style_menu_item'] = array(
			'name'      => esc_html__( 'Menu Item Style', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_submenu_item'] = array(
			'name'      => esc_html__( 'Sub Menu Item Style', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_submenu_panel'] = array(
			'name'      => esc_html__( 'Sub Menu Panel Style', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_hamburger_menu'] = array(
			'name'      => esc_html__( 'Hamburger Menu Style', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		$this->segments['style_mobile_menu'] = array(
			'name'      => esc_html__( 'Mobile Menu Logo', 'jeg-elementor-kit' ),
			'priority'  => 15,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_menu_choose'] = array(
			'type'        => 'select',
			'title'       => esc_html__( 'Menu', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Choose which menu you want to show.', 'jeg-elementor-kit' ),
			'segment'     => 'segment_menu',
			'options'     => jkit_get_menu_option(),
		);

		$this->options['sg_menu_direction'] = array(
			'type'        => 'radio',
			'title'       => esc_html__( 'Display Direction', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Menu Direction .', 'jeg-elementor-kit' ),
			'segment'     => 'segment_menu',
			'options'     => array(
				'flex'  => array(
					'title' => esc_html__( 'Horizontal', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-arrows-alt-h',
				),
				'block' => array(
					'title' => esc_html__( 'Vertical', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-arrows-alt-v',
				),
			),
			'default'     => 'flex',
			'selectors'   => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu > ul, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper:not(.active) .jkit-menu, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper:not(.active) .jkit-menu > li > a' => 'display: {{VALUE}};',
				),
			),
		);

		$this->options['sg_menu_alignment'] = array(
			'type'        => 'radio',
			'title'       => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Set menu alignment.', 'jeg-elementor-kit' ),
			'segment'     => 'segment_menu',
			'options'     => array(
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
					'title' => esc_html__( 'Justified', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-justify',
				),
			),
			'responsive'  => true,
			'default'     => 'flex-start',
			'selectors'   => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu',
			'attribute'   => 'justify-content',
			'dependency'  => array(
				array(
					'field'    => 'sg_menu_direction',
					'operator' => '==',
					'value'    => 'flex',
				),
			),
		);

		$this->options['sg_menu_alignment_initial'] = array(
			'type'        => 'radio',
			'title'       => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Set menu alignment.', 'jeg-elementor-kit' ),
			'segment'     => 'segment_menu',
			'options'     => array(
				'left'    => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'  => array(
					'title' => esc_html__( 'Center', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'   => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-right',
				),
				'justify' => array(
					'title' => esc_html__( 'Justified', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-justify',
				),
			),
			'responsive'  => true,
			'default'     => 'left',
			'selectors'   => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu',
			'attribute'   => 'text-align',
			'dependency'  => array(
				array(
					'field'    => 'sg_menu_direction',
					'operator' => '==',
					'value'    => 'block',
				),
			),
		);

		$this->options['sg_menu_sub_position'] = array(
			'type'        => 'radio',
			'title'       => esc_html__( 'Sub Menu Position', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Set sub menu position.', 'jeg-elementor-kit' ),
			'segment'     => 'segment_menu',
			'options'     => array(
				'right'  => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-left',
				),
				'bottom' => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-top',
				),
				'left'   => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-right',
				),
				'top'    => array(
					'title' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-bottom',
				),
			),
			'default'     => 'top',
			'selectors'   => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .menu-item .sub-menu' => 'left: unset; top: unset; right: unset; bottom: unset; {{VALUE}}: 100%;',
				),
			),
		);

		$this->options['sg_menu_extra_sub_position'] = array(
			'type'        => 'radio',
			'title'       => esc_html__( 'Extra Sub Menu Position', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Set extra sub menu position.', 'jeg-elementor-kit' ),
			'segment'     => 'segment_menu',
			'options'     => array(
				'right'  => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-left',
				),
				'bottom' => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-top',
				),
				'left'   => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-right',
				),
				'top'    => array(
					'title' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-bottom',
				),
			),
			'default'     => 'left',
			'selectors'   => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .menu-item .sub-menu .menu-item .sub-menu' => 'left: unset; top: unset; right: unset; bottom: unset; {{VALUE}}: 100%;',
				),
			),
		);

		$this->options['sg_menu_breakpoint'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Responsive Breakpoint', 'jeg-elementor-kit' ),
			'default' => 'tablet',
			'segment' => 'segment_menu',
			'options' => array(
				'tablet' => esc_html__( 'Tablet', 'jeg-elementor-kit' ),
				'mobile' => esc_html__( 'Mobile', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_mobile_menu_logo'] = array(
			'type'    => 'image',
			'title'   => esc_html__( 'Mobile Menu Logo', 'jeg-elementor-kit' ),
			'segment' => 'segment_mobile_menu',
		);

		$this->options['sg_mobile_menu_logo_size'] = array(
			'type'    => 'imagesize',
			'title'   => esc_html__( 'Mobile Menu Logo Size', 'jeg-elementor-kit' ),
			'segment' => 'segment_mobile_menu',
		);

		$this->options['sg_mobile_menu_link'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Menu Link', 'jeg-elementor-kit' ),
			'default' => 'default',
			'segment' => 'segment_mobile_menu',
			'options' => array(
				'default' => esc_html__( 'Default (Home)', 'jeg-elementor-kit' ),
				'custom'  => esc_html__( 'Custom URL', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_mobile_menu_custom_link'] = array(
			'type'       => 'link',
			'title'      => esc_html__( 'Custom Link', 'jeg-elementor-kit' ),
			'segment'    => 'segment_mobile_menu',
			'dependency' => array(
				array(
					'field'    => 'sg_mobile_menu_link',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['sg_mobile_menu_icon'] = array(
			'type'    => 'iconpicker',
			'title'   => esc_html__( 'Mobile Menu Icon', 'jeg-elementor-kit' ),
			'default' => array(
				'value'   => 'fas fa-bars',
				'library' => 'fa-solid',
			),
			'segment' => 'segment_mobile_menu',
		);

		$this->options['sg_mobile_close_icon'] = array(
			'type'    => 'iconpicker',
			'title'   => esc_html__( 'Mobile Close Icon', 'jeg-elementor-kit' ),
			'default' => array(
				'value'   => 'fas fa-times',
				'library' => 'fa-solid',
			),
			'segment' => 'segment_mobile_menu',
		);

		$this->options['sg_mobile_menu_submenu_click'] = array(
			'type'        => 'checkbox',
			'title'       => esc_html__( 'Sub Menu Click On Text', 'jeg-elementor-kit' ),
			'default'     => 'yes',
			'segment'     => 'segment_mobile_menu',
			'description' => esc_html( 'Enable this option to open the Sub-Menu by clicking the Text (All area of menu). Disable this option to open the Sub-Menu by clicking only the Icon.', 'jeg-elementor-kit' ),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_menu_wrapper_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Menu Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_menu_wrapper',
			'units'      => array( 'px' ),
			'options'    => array(
				'min'  => 30,
				'max'  => 500,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper:not(.active)',
			'attribute'  => 'width',
			'dependency' => array(
				array(
					'field'    => 'sg_menu_direction',
					'operator' => '==',
					'value'    => 'block',
				),
			),
		);

		$this->options['st_menu_wrapper_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Menu Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_menu_wrapper',
			'units'      => array( 'px' ),
			'default'    => 80,
			'options'    => array(
				'min'  => 30,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper',
			'attribute'  => 'height',
			'dependency' => array(
				array(
					'field'    => 'sg_menu_direction',
					'operator' => '==',
					'value'    => 'flex',
				),
			),
		);

		$this->options['st_menu_wrapper_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Menu Wrapper Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_menu_wrapper_mobile_color_tablet'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Mobile Background Color', 'jeg-elementor-kit' ),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu.break-point-mobile .jkit-menu-wrapper' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu.break-point-tablet .jkit-menu-wrapper' => 'background-color: {{VALUE}}',
				),
			),
			'responsive' => true,
			'devices'    => array( 'mobile', 'tablet' ),
			'segment'    => 'style_menu_wrapper',
			'dependency' => array(
				array(
					'field'    => 'sg_menu_breakpoint',
					'operator' => '==',
					'value'    => 'tablet',
				),
			),
		);

		$this->options['st_menu_wrapper_mobile_color_mobile'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Mobile Background Color', 'jeg-elementor-kit' ),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu.break-point-mobile .jkit-menu-wrapper' => 'background-color: {{VALUE}}',
				),
			),
			'responsive' => true,
			'devices'    => array( 'mobile' ),
			'segment'    => 'style_menu_wrapper',
			'dependency' => array(
				array(
					'field'    => 'sg_menu_breakpoint',
					'operator' => '==',
					'value'    => 'mobile',
				),
			),
		);

		$this->options['st_menu_wrapper_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper',
			'attribute' => 'padding',
		);

		$this->options['st_menu_wrapper_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper',
			'attribute' => 'margin',
		);

		$this->options['st_menu_wrapper_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper',
			'attribute' => 'border-radius',
		);

		$this->options['st_menu_item_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Menu Item Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li > a',
		);

		$this->options['st_menu_item_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Menu Item Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_menu_item',
			'options'    => array(
				'min'  => 1,
				'max'  => 200,
				'step' => 1,
			),
			'units'      => array( 'px', 'em' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li > a i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li > a svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_menu_item_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li > a',
			'attribute' => 'margin',
		);

		$this->options['st_menu_item_spacing'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li > a',
			'attribute' => 'padding',
		);

		$this->options['st_menu_item_text_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_menu_item',
		);

		$this->options['st_menu_item_text_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_menu_item',
		);

		$this->options['st_menu_item_text_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Item Text Normal Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_menu_item',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li > a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li > a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_menu_item_text_normal_bg'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Item Text Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_menu_item',
			'selectors'      => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li > a',
			'options'        => array(
				'classic',
				'gradient',
			),
			'fields_options' => array(
				'background' => array(
					'render_type'        => 'template',
					'frontend_available' => true,
				),
			),
		);

		$this->options['st_menu_item_text_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Item Text Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li > a',
		);

		$this->options['st_menu_item_text_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li > a',
			'attribute' => 'border-radius',
		);

		$this->options['st_menu_item_text_normal_border_first'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'First Child Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li:first-child > a',
		);

		$this->options['st_menu_item_text_normal_border_radius_first'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li:first-child > a',
			'attribute' => 'border-radius',
		);

		$this->options['st_menu_item_text_normal_border_last'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Last Child Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li:last-child > a',
		);

		$this->options['st_menu_item_text_normal_border_radius_last'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li:last-child > a',
			'attribute' => 'border-radius',
		);

		$this->options['st_menu_item_text_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_menu_item',
		);

		$this->options['st_menu_item_text_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_menu_item',
		);

		$this->options['st_menu_item_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li > a' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_menu_item_text_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Item Text Hover Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_menu_item',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li:hover > a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li:hover > a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_menu_item_text_hover_bg'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Item Text Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_menu_item',
			'selectors'      => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li:not(.hover-gradient, .current-menu-item):hover > a, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li.hover-gradient > a:before',
			'options'        => array(
				'classic',
				'gradient',
			),
			'fields_options' => array(
				'background' => array(
					'render_type'        => 'template',
					'frontend_available' => true,
				),
			),
		);

		$this->options['st_menu_item_text_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Item Text Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li:hover > a',
		);

		$this->options['st_menu_item_text_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li:hover > a',
			'attribute' => 'border-radius',
		);

		$this->options['st_menu_item_text_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_menu_item',
		);

		$this->options['st_menu_item_text_active_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Active', 'jeg-elementor-kit' ),
			'segment' => 'style_menu_item',
		);

		$this->options['st_menu_item_text_active_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Item Text Active Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_menu_item',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li.current-menu-item > a, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li.current-menu-ancestor > a'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li.current-menu-item > a svg, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li.current-menu-ancestor > a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_menu_item_text_active_bg'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Item Text Active Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li.current-menu-item > a, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li.current-menu-ancestor > a',
			),
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_menu_item_text_active_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Item Text Active Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li.current-menu-item > a, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li.current-menu-ancestor > a',
			),
		);

		$this->options['st_menu_item_text_active_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_menu_item',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li.current-menu-item > a, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu > li.current-menu-ancestor > a',
			'attribute' => 'border-radius',
		);

		$this->options['st_menu_item_text_active_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_menu_item',
		);

		$this->options['st_menu_item_text_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_menu_item',
		);

		$this->options['st_submenu_item_indicator_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Indicator', 'jeg-elementor-kit' ),
			'segment' => 'style_submenu_item',
		);

		$this->options['st_submenu_item_indicator'] = array(
			'type'    => 'iconpicker',
			'title'   => esc_html__( 'Indicator Item', 'jeg-elementor-kit' ),
			'default' => array(
				'value'   => 'fas fa-angle-down',
				'library' => 'fa-solid',
			),
			'segment' => 'style_submenu_item',
		);

		$this->options['st_submenu_item_indicator_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Indicator Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_submenu_item',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children > a i, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.has-mega-menu > a i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children > a svg, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.has-mega-menu > a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_submenu_item_indicator_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Indicator Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children > a i, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children > a svg, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.has-mega-menu > a i, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.has-mega-menu > a svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_submenu_item_indicator_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Indicator Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children > a i, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children > a svg, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.has-mega-menu > a i, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.has-mega-menu > a svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_submenu_item_indicator_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Indicator Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children > a i, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children > a svg, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.has-mega-menu > a i, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.has-mega-menu > a svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_submenu_item_indicator_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Indicator Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children > a i, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children > a svg, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.has-mega-menu > a i, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.has-mega-menu > a svg',
			),
		);

		$this->options['st_submenu_item_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Submenu Item', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'separator' => 'before',
		);

		$this->options['st_submenu_item_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Sub Menu Item Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li a',
		);

		$this->options['st_submenu_item_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Sub Menu Item Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_submenu_item',
			'options'    => array(
				'min'  => 1,
				'max'  => 200,
				'step' => 1,
			),
			'units'      => array( 'px', 'em' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li a i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li a svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_submenu_item_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li a',
			'attribute' => 'margin',
		);

		$this->options['st_submenu_item_spacing'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li a',
			'attribute' => 'padding',
		);

		$this->options['st_submenu_item_text_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_submenu_item',
		);

		$this->options['st_submenu_item_text_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_submenu_item',
		);

		$this->options['st_submenu_item_text_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Item Text Normal Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_submenu_item',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li > a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li > a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_submenu_item_text_normal_bg'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Item Text Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_submenu_item',
			'selectors'      => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li > a',
			'options'        => array(
				'classic',
				'gradient',
			),
			'fields_options' => array(
				'background' => array(
					'render_type'        => 'template',
					'frontend_available' => true,
				),
			),
		);

		$this->options['st_submenu_item_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Items Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li a',
		);

		$this->options['st_submenu_item_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Items Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children .sub-menu > .menu-item > a',
			'attribute' => 'border-radius',
		);

		$this->options['st_submenu_item_first_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'First Child', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'separator' => 'before',
		);

		$this->options['st_submenu_item_margin_first'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li:first-child > a',
			'attribute' => 'margin',
		);

		$this->options['st_submenu_item_border_first'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'First Child Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li:first-child > a',
		);

		$this->options['st_submenu_item_border_radius_first'] = array(
			'type'               => 'dimension',
			'title'              => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'            => 'style_submenu_item',
			'allowed_dimensions' => array( 'top', 'right' ),
			'selectors'          => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li:first-child > a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}}',
				),
			),
		);

		$this->options['st_submenu_item_last_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Last Child', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'separator' => 'before',
		);

		$this->options['st_submenu_item_margin_last'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li:last-child > a',
			'attribute' => 'margin',
		);

		$this->options['st_submenu_item_border_last'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Last Child Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li:last-child > a',
		);

		$this->options['st_submenu_item_border_radius_last'] = array(
			'type'               => 'dimension',
			'title'              => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'            => 'style_submenu_item',
			'allowed_dimensions' => array( 'bottom', 'left' ),
			'selectors'          => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li:last-child > a' => 'border-bottom-left-radius: {{LEFT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}}',
				),
			),
		);

		$this->options['st_submenu_item_text_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_submenu_item',
		);

		$this->options['st_submenu_item_text_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_submenu_item',
		);

		$this->options['st_submenu_item_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li a' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_submenu_item_text_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Item Text Hover Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_submenu_item',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li:hover > a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li:hover > a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_submenu_item_text_hover_bg'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Item Text Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_submenu_item',
			'selectors'      => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li:not(.hover-gradient, .current-menu-item):hover > a, .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li.hover-gradient > a:before',
			'options'        => array(
				'classic',
				'gradient',
			),
			'fields_options' => array(
				'background' => array(
					'render_type'        => 'template',
					'frontend_available' => true,
				),
			),
		);

		$this->options['st_submenu_item_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Items Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li:hover > a',
		);

		$this->options['st_submenu_item_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Items Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li:hover > a',
			'attribute' => 'border-radius',
		);

		$this->options['st_submenu_item_text_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_submenu_item',
		);

		$this->options['st_submenu_item_text_active_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Active', 'jeg-elementor-kit' ),
			'segment' => 'style_submenu_item',
		);

		$this->options['st_submenu_item_text_active_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Item Text Active Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_submenu_item',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li.current-menu-item > a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li.current-menu-item > a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_submenu_item_text_active_bg'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Item Text Active Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu > li.current-menu-item > a',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_submenu_item_active_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Items Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li.current-menu-item a',
		);

		$this->options['st_submenu_item_active_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Items Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_item',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu .sub-menu li.current-menu-item a',
			'attribute' => 'border-radius',
		);

		$this->options['st_submenu_item_text_active_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_submenu_item',
		);

		$this->options['st_submenu_item_text_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_submenu_item',
		);

		$this->options['st_submenu_panel_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_panel',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children .sub-menu',
			'attribute' => 'margin',
		);

		$this->options['st_submenu_panel_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_panel',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children .sub-menu',
			'attribute' => 'padding',
		);

		$this->options['st_submenu_panel_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_panel',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children .sub-menu',
		);

		$this->options['st_submenu_panel_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_panel',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children .sub-menu',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_submenu_panel_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_panel',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children .sub-menu',
			'attribute' => 'border-radius',
		);

		$this->options['st_submenu_panel_container_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Container Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_submenu_panel',
			'default'    => 220,
			'options'    => array(
				'min'  => 1,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children .sub-menu',
			'attribute'  => 'min-width',
		);

		$this->options['st_submenu_panel_box_shadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_submenu_panel',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-menu li.menu-item-has-children .sub-menu',
		);

		$this->options['st_hamburger_menu_position'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_hamburger_menu',
			'options'    => array(
				'left'  => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-left',
				),
				'right' => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'responsive' => true,
			'default'    => 'right',
			'selectors'  => '.jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu',
			'attribute'  => 'float',
		);

		$this->options['st_hamburger_menu_icon_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Hamburger Icon', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'separator' => 'before',
		);

		$this->options['st_hamburger_menu_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_hamburger_menu',
			'units'      => array( 'px', '%' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu',
			'attribute'  => 'width',
		);

		$this->options['st_hamburger_menu_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_hamburger_menu',
			'units'      => array( 'px' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_hamburger_menu_icon_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_hamburger_menu',
		);

		$this->options['st_hamburger_menu_icon_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_hamburger_menu',
		);

		$this->options['st_hamburger_menu_icon_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Icon Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_hamburger_menu',
			'selectors'      => '.jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu',
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

		$this->options['st_hamburger_menu_icon_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Icon Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu',
		);

		$this->options['st_hamburger_menu_icon_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Icon Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu',
			'attribute' => 'border-radius',
		);

		$this->options['st_hamburger_menu_icon_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Icon Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_hamburger_menu',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_hamburger_menu_icon_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_hamburger_menu',
		);

		$this->options['st_hamburger_menu_icon_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_hamburger_menu',
		);

		$this->options['st_hamburger_menu_icon_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_hamburger_menu_icon_background_hover'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Icon Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_hamburger_menu',
			'selectors'      => '.jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu:not(.hover-gradient):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu.hover-gradient:before',
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

		$this->options['st_hamburger_menu_icon_border_hover'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Icon Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu:hover',
		);

		$this->options['st_hamburger_menu_icon_border_radius_hover'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Icon Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_hamburger_menu_icon_color_hover'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Icon Hover Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_hamburger_menu',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_hamburger_menu_icon_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_hamburger_menu',
		);

		$this->options['st_hamburger_menu_icon_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_hamburger_menu',
		);

		$this->options['st_hamburger_menu_icon_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu',
			'attribute' => 'margin',
		);

		$this->options['st_hamburger_menu_icon_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-hamburger-menu',
			'attribute' => 'padding',
		);

		$this->options['st_hamburger_menu_close_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Close Icon', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'separator' => 'before',
		);

		$this->options['st_hamburger_menu_close_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_hamburger_menu',
			'units'      => array( 'px', '%' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu',
			'attribute'  => 'width',
		);

		$this->options['st_hamburger_menu_close_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_hamburger_menu',
			'units'      => array( 'px' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu i'  => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_hamburger_menu_close_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_hamburger_menu',
		);

		$this->options['st_hamburger_menu_close_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_hamburger_menu',
		);

		$this->options['st_hamburger_menu_close_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Close Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_hamburger_menu',
			'selectors'      => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu',
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

		$this->options['st_hamburger_menu_close_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Close Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu',
		);

		$this->options['st_hamburger_menu_close_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Close Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu',
			'attribute' => 'border-radius',
		);

		$this->options['st_hamburger_menu_close_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Close Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_hamburger_menu',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_hamburger_menu_close_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_hamburger_menu',
		);

		$this->options['st_hamburger_menu_close_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_hamburger_menu',
		);

		$this->options['st_hamburger_menu_close_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_hamburger_menu_close_background_hover'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Close Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_hamburger_menu',
			'selectors'      => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu:not(.hover-gradient):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu.hover-gradient:before',
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

		$this->options['st_hamburger_menu_close_border_hover'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Close Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu:hover',
		);

		$this->options['st_hamburger_menu_close_border_radius_hover'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Close Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_hamburger_menu_close_color_hover'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Close Hover Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_hamburger_menu',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_hamburger_menu_close_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_hamburger_menu',
		);

		$this->options['st_hamburger_menu_close_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_hamburger_menu',
		);

		$this->options['st_hamburger_menu_close_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu',
			'attribute' => 'margin',
		);

		$this->options['st_hamburger_menu_close_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_hamburger_menu',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-close-menu',
			'attribute' => 'padding',
		);

		$this->options['st_mobile_menu_max_width'] = array(
			'type'           => 'slider',
			'title'          => esc_html__( 'Max Width', 'jeg-elementor-kit' ),
			'segment'        => 'style_mobile_menu',
			'options'        => array(
				'min'  => 0,
				'max'  => 360,
				'step' => 1,
			),
			'tablet_default' => array(
				'size' => 260,
			),
			'mobile_default' => array(
				'size' => 240,
			),
			'responsive'     => true,
			'selectors'      => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-nav-site-title .jkit-nav-logo img',
			'attribute'      => 'max-width',
		);

		$this->options['st_mobile_menu_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_mobile_menu',
			'options'    => array(
				'min'  => 0,
				'max'  => 360,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-nav-site-title .jkit-nav-logo img',
			'attribute'  => 'width',
		);

		$this->options['st_mobile_menu_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_mobile_menu',
			'options'    => array(
				'min'  => 0,
				'max'  => 360,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-nav-site-title .jkit-nav-logo img',
			'attribute'  => 'height',
		);

		$this->options['st_mobile_menu_object_fit'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Object Fit', 'jeg-elementor-kit' ),
			'default'    => 'cover',
			'segment'    => 'style_mobile_menu',
			'options'    => array(
				'cover'      => esc_html__( 'Cover', 'jeg-elementor-kit' ),
				'contain'    => esc_html__( 'Contain', 'jeg-elementor-kit' ),
				'fill'       => esc_html__( 'Fill', 'jeg-elementor-kit' ),
				'scale-down' => esc_html__( 'Scale Down', 'jeg-elementor-kit' ),
				'none'       => esc_html__( 'None', 'jeg-elementor-kit' ),
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-nav-site-title .jkit-nav-logo img',
			'attribute'  => 'object-fit',
		);

		$this->options['st_mobile_menu_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_mobile_menu',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-nav-site-title .jkit-nav-logo',
			'attribute' => 'margin',
		);

		$this->options['st_mobile_menu_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_mobile_menu',
			'selectors' => '.jeg-elementor-kit.jkit-nav-menu .jkit-menu-wrapper .jkit-nav-identity-panel .jkit-nav-site-title .jkit-nav-logo',
			'attribute' => 'padding',
		);

		parent::additional_style();
	}
}
