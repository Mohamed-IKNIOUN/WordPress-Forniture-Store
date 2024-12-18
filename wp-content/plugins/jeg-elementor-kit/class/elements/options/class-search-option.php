<?php
/**
 * Search Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.10.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Search_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Search_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Search', 'jeg-elementor-kit' );
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
		$this->segments['segment_search'] = array(
			'name'     => esc_html__( 'Search', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_icon'] = array(
			'name'       => esc_html__( 'Search Icon', 'jeg-elementor-kit' ),
			'priority'   => 11,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_search_style',
					'operator' => '==',
					'value'    => 'popup',
				),
			),
		);

		$this->segments['style_container'] = array(
			'name'      => esc_html__( 'Search Container', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_button'] = array(
			'name'      => esc_html__( 'Search Button', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_close_button'] = array(
			'name'       => esc_html__( 'Close Button', 'jeg-elementor-kit' ),
			'priority'   => 14,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_search_style',
					'operator' => '==',
					'value'    => 'popup',
				),
			),
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_search_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Style', 'jeg-elementor-kit' ),
			'default' => 'popup',
			'segment' => 'segment_search',
			'options' => array(
				'form'  => esc_html__( 'Form', 'jeg-elementor-kit' ),
				'popup' => esc_html__( 'Pop Up', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_search_placeholder'] = array(
			'type'        => 'text',
			'title'       => esc_html__( 'Placeholder', 'jeg-elementor-kit' ),
			'default'     => 'Search...',
			'segment'     => 'segment_search',
			'label_block' => false,
		);

		$this->options['sg_search_button_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Button Style', 'jeg-elementor-kit' ),
			'default' => 'icon',
			'segment' => 'segment_search',
			'options' => array(
				'icon' => esc_html__( 'Icon', 'jeg-elementor-kit' ),
				'text' => esc_html__( 'Text', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_search_text'] = array(
			'type'        => 'text',
			'title'       => esc_html__( 'Text', 'jeg-elementor-kit' ),
			'default'     => 'Search',
			'segment'     => 'segment_search',
			'label_block' => false,
			'dependency'  => array(
				array(
					'field'    => 'sg_search_button_style',
					'operator' => '==',
					'value'    => 'text',
				),
			),
		);

		$this->options['sg_search_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-search',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_search',
			'dependency' => array(
				'custom' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'     => 'sg_search_style',
							'operator' => '==',
							'value'    => 'popup',
						),
						array(
							'name'     => 'sg_search_button_style',
							'operator' => '==',
							'value'    => 'icon',
						),
					),
				),
			),
		);

		$this->options['sg_search_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'segment_search',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 20,
			'responsive' => true,
			'units'      => array( 'px', 'em' ),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-modal i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-modal svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_search_style',
					'operator' => '==',
					'value'    => 'popup',
				),
			),
		);

		$this->options['sg_search_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'segment_search',
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
			'selectors'  => '.jeg-elementor-kit.jkit-search',
			'attribute'  => 'text-align',
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

		$this->options['st_icon_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-modal'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-modal svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_icon',
			'selectors'      => '.jeg-elementor-kit.jkit-search .jkit-search-modal',
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

		$this->options['st_icon_normal_tab_end'] = array(
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-modal' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_icon_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-modal:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-modal:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_icon',
			'selectors'      => '.jeg-elementor-kit.jkit-search .jkit-search-modal:not(.hover-gradient):hover, .jeg-elementor-kit.jkit-search .jkit-search-modal.hover-gradient:before',
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

		$this->options['st_icon_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-modal',
			'separator' => 'before',
		);

		$this->options['st_icon_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-modal',
		);

		$this->options['st_icon_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-modal',
			'attribute' => 'border-radius',
		);

		$this->options['st_icon_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-modal',
			'attribute' => 'margin',
			'default'   => array(
				'top'      => '5',
				'right'    => '5',
				'bottom'   => '5',
				'left'     => '5',
				'unit'     => 'px',
				'isLinked' => true,
			),
		);

		$this->options['st_icon_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-modal',
			'attribute' => 'padding',
			'default'   => array(
				'top'      => '0',
				'right'    => '0',
				'bottom'   => '0',
				'left'     => '0',
				'unit'     => 'px',
				'isLinked' => true,
			),
		);

		$this->options['st_icon_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'default'    => 'center',
			'segment'    => 'style_icon',
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
			'selectors'  => '.jeg-elementor-kit.jkit-search .jkit-search-modal',
			'attribute'  => 'text-align',
		);

		$this->options['st_icon_height_width'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Use Height Width', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
			'default' => 'yes',
		);

		$this->options['st_icon_height_width_width'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'      => 'style_icon',
			'options'      => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'units'        => array( 'px', 'em', '%' ),
			'selectors'    => '.jeg-elementor-kit.jkit-search .jkit-search-modal',
			'attribute'    => 'width',
			'default'      => 40,
			'default_unit' => 'px',
			'responsive'   => true,
			'dependency'   => array(
				array(
					'field'    => 'st_icon_height_width',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_icon_height_width_height'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'      => 'style_icon',
			'options'      => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'    => '.jeg-elementor-kit.jkit-search .jkit-search-modal',
			'attribute'    => 'height',
			'units'        => array( 'px', 'em', '%' ),
			'default'      => 40,
			'default_unit' => 'px',
			'responsive'   => true,
			'dependency'   => array(
				array(
					'field'    => 'st_icon_height_width',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_icon_height_width_line_height'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Line Height', 'jeg-elementor-kit' ),
			'segment'      => 'style_icon',
			'options'      => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'    => '.jeg-elementor-kit.jkit-search .jkit-search-modal',
			'attribute'    => 'line-height',
			'units'        => array( 'px', 'em', '%' ),
			'default'      => 40,
			'default_unit' => 'px',
			'responsive'   => true,
			'dependency'   => array(
				array(
					'field'    => 'st_icon_height_width',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_container_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Container Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-search .swal2-container:before',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_container_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_container',
		);

		$this->options['st_container_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_container',
		);

		$this->options['st_container_form_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Form Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit])',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_container_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_container',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit])',
		);

		$this->options['st_container_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit])',
		);

		$this->options['st_container_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit])',
		);

		$this->options['st_container_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_container',
		);

		$this->options['st_container_focus_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Focus', 'jeg-elementor-kit' ),
			'segment' => 'style_container',
		);

		$this->options['st_container_focus_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit])' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_container_focus_form_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Form Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit]):focus',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_container_focus_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_container',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit]):focus',
		);

		$this->options['st_container_focus_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit]):focus',
		);

		$this->options['st_container_focus_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit]):focus',
		);

		$this->options['st_container_focus_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_container',
		);

		$this->options['st_container_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_container',
		);

		$this->options['st_container_placeholder_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Placeholder Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_container',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit])::placeholder',
			'separator'  => 'before',
		);

		$this->options['st_container_placeholder_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Placeholder Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit])::placeholder',
		);

		$this->options['st_container_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit])',
			'attribute' => 'border-radius',
		);

		$this->options['st_container_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit])',
			'attribute' => 'padding',
		);

		$this->options['st_container_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit])',
			'attribute' => 'margin',
		);

		$this->options['st_container_max_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Max Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_container',
			'units'      => array( 'px', '%' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-modal-search-panel .jkit-search-panel' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search > .jkit-search-panel'                        => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_container_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_container',
			'units'      => array( 'px', '%' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-search .jkit-search-panel input:not([type=submit])',
			'attribute'  => 'height',
		);

		$this->options['st_button_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'units'      => array( 'px', 'em' ),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-button i'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-button svg'   => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_search_button_style',
					'operator' => '==',
					'value'    => 'icon',
				),
			),
		);

		$this->options['st_button_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'selectors'  => '.jeg-elementor-kit.jkit-search .jkit-search-button',
			'dependency' => array(
				array(
					'field'    => 'sg_search_button_style',
					'operator' => '==',
					'value'    => 'text',
				),
			),
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

		$this->options['st_button_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_button',
			'selectors'      => '.jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button',
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

		$this->options['st_button_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button',
		);

		$this->options['st_button_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_button_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_button',
			'selectors'      => '.jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button:not(.hover-gradient):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button.hover-gradient:before',
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

		$this->options['st_button_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button:hover',
		);

		$this->options['st_button_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button:hover',
		);

		$this->options['st_button_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_button',
		);

		$this->options['st_button_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_button',
		);

		$this->options['st_button_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button',
			'attribute' => 'border-radius',
			'separator' => 'before',
		);

		$this->options['st_button_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button',
			'attribute' => 'padding',
		);

		$this->options['st_button_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button',
			'attribute' => 'margin',
		);

		$this->options['st_button_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'units'      => array( 'px', '%' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button',
			'attribute'  => 'width',
		);

		$this->options['st_button_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'units'      => array( 'px', '%' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-search .jkit-search-panel .jkit-search-button',
			'attribute'  => 'height',
		);

		$this->options['st_close_button_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_close_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .swal2-close',
			'attribute' => 'margin',
		);

		$this->options['st_close_button_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_close_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .swal2-close',
			'attribute' => 'padding',
		);

		$this->options['st_close_button_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_close_button',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'units'      => array( 'px', 'em' ),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .swal2-close' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_close_button_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_close_button',
		);

		$this->options['st_close_button_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_close_button',
		);

		$this->options['st_container_close_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Close Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_close_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .swal2-close' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				),
			),
		);

		$this->options['st_close_button_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_close_button',
			'selectors' => '.jeg-elementor-kit.jkit-search .swal2-close',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_close_button_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_close_button',
			'selectors' => '.jeg-elementor-kit.jkit-search .swal2-close',
		);

		$this->options['st_close_button_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_close_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .swal2-close',
			'attribute' => 'border-radius',
		);

		$this->options['st_close_button_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_close_button',
			'selectors' => '.jeg-elementor-kit.jkit-search .swal2-close',
		);

		$this->options['st_close_button_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_close_button',
		);

		$this->options['st_close_button_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_close_button',
		);

		$this->options['st_close_button_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Close Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_close_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-search .swal2-close:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				),
			),
		);

		$this->options['st_close_button_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_close_button',
			'selectors' => '.jeg-elementor-kit.jkit-search .swal2-close:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_close_button_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_close_button',
			'selectors' => '.jeg-elementor-kit.jkit-search .swal2-close:hover',
		);

		$this->options['st_close_button_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_close_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-search .swal2-close:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_close_button_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_close_button',
			'selectors' => '.jeg-elementor-kit.jkit-search .swal2-close:hover',
		);

		$this->options['st_close_button_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_close_button',
		);

		$this->options['st_close_button_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_close_button',
		);

		$this->options['st_close_button_position_absolute'] = array(
			'type'         => 'checkbox',
			'title'        => esc_html__( 'Position Absolute', 'jeg-elementor-kit' ),
			'segment'      => 'style_close_button',
			'return_value' => 'absolute',
			'prefix_class' => 'jkit-close-position-',
			'separator'    => 'before',
		);

		$this->options['st_close_button_position_horizontal_orientation'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Horizontal Orientation', 'jeg-elementor-kit' ),
			'segment'    => 'style_close_button',
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
					'field'    => 'st_close_button_position_absolute',
					'operator' => '==',
					'value'    => 'absolute',
				),
			),
		);

		$this->options['st_close_button_position_horizontal_offset'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Offset', 'jeg-elementor-kit' ),
			'segment'    => 'style_close_button',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 1600,
				'step' => 1,
			),
			'default'    => 0,
			'selectors'  => array(
				'custom' => array( '{{WRAPPER}}.jkit-close-position-absolute .swal2-close' => '{{st_close_button_position_horizontal_orientation.VALUE}}: {{SIZE}}{{UNIT}};' ),
			),
			'dependency' => array(
				array(
					'field'    => 'st_close_button_position_absolute',
					'operator' => '==',
					'value'    => 'absolute',
				),
			),
		);

		$this->options['st_close_button_position_vertical_orientation'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Vertical Orientation', 'jeg-elementor-kit' ),
			'segment'    => 'style_close_button',
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
					'field'    => 'st_close_button_position_absolute',
					'operator' => '==',
					'value'    => 'absolute',
				),
			),
		);

		$this->options['st_close_button_position_vertical_offset'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Offset', 'jeg-elementor-kit' ),
			'segment'    => 'style_close_button',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 1600,
				'step' => 1,
			),
			'default'    => 0,
			'selectors'  => array(
				'custom' => array( '{{WRAPPER}}.jkit-close-position-absolute .swal2-close' => '{{st_close_button_position_vertical_orientation.VALUE}}: {{SIZE}}{{UNIT}};' ),
			),
			'dependency' => array(
				array(
					'field'    => 'st_close_button_position_absolute',
					'operator' => '==',
					'value'    => 'absolute',
				),
			),
		);

		parent::additional_style();
	}
}
