<?php
/**
 * Feature List Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.11.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Feature_List_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Feature_List_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Feature List', 'jeg-elementor-kit' );
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
		$this->segments['style_list'] = array(
			'name'      => esc_html__( 'List', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_icon'] = array(
			'name'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_content'] = array(
			'name'      => esc_html__( 'Content', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_setting_list'] = array(
			'type'        => 'repeater',
			'title'       => esc_html__( 'Feature List', 'jeg-elementor-kit' ),
			'segment'     => 'segment_setting',
			'title_field' => '<i class="{{ sg_setting_list_icon.value }}" aria-hidden="true"></i> {{ sg_setting_list_title }}',
			'fields'      => array(
				'sg_setting_list_icon_type'              => array(
					'type'    => 'radio',
					'title'   => esc_html__( 'Icon Type', 'jeg-elementor-kit' ),
					'segment' => 'sg_setting_list',
					'default' => 'icon',
					'options' => array(
						'icon'  => array(
							'title' => esc_html__( 'Icon', 'jeg-elementor-kit' ),
							'icon'  => 'fas fa-icons',
						),
						'image' => array(
							'title' => esc_html__( 'Image', 'jeg-elementor-kit' ),
							'icon'  => 'fas fa-image',
						),
					),
				),
				'sg_setting_list_image'                  => array(
					'type'       => 'image',
					'segment'    => 'sg_setting_list',
					'title'      => esc_html__( 'Image', 'jeg-elementor-kit' ),
					'default'    => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'dependency' => array(
						array(
							'field'    => 'sg_setting_list_icon_type',
							'operator' => '==',
							'value'    => 'image',
						),
					),
				),
				'sg_setting_list_image_size'             => array(
					'type'       => 'imagesize',
					'title'      => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
					'segment'    => 'sg_setting_list',
					'default'    => 'thumbnail',
					'dependency' => array(
						array(
							'field'    => 'sg_setting_list_icon_type',
							'operator' => '==',
							'value'    => 'image',
						),
					),
				),
				'sg_setting_list_icon'                   => array(
					'type'       => 'iconpicker',
					'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
					'default'    => array(
						'value'   => 'fas fa-check',
						'library' => 'fa-solid',
					),
					'segment'    => 'sg_setting_list',
					'dependency' => array(
						array(
							'field'    => 'sg_setting_list_icon_type',
							'operator' => '==',
							'value'    => 'icon',
						),
					),
				),
				'sg_setting_list_icon_tabs_start'        => array(
					'type'    => 'control_tabs_start',
					'segment' => 'sg_setting_list',
				),
				'sg_setting_list_icon_normal_tab_start'  => array(
					'type'    => 'control_tab_start',
					'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
					'segment' => 'sg_setting_list',
				),
				'sg_setting_list_icon_normal_box_background' => array(
					'type'      => 'background',
					'title'     => esc_html__( 'Icon Box Background', 'jeg-elementor-kit' ),
					'segment'   => 'sg_setting_list',
					'selectors' => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item{{CURRENT_ITEM}} .feature-list-icon-inner',
					'options'   => array(
						'classic',
						'gradient',
					),
				),
				'sg_setting_list_icon_normal_background' => array(
					'type'      => 'background',
					'title'     => esc_html__( 'Icon Background', 'jeg-elementor-kit' ),
					'segment'   => 'sg_setting_list',
					'selectors' => array(
						'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item{{CURRENT_ITEM}} .feature-list-icon, {{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items.shape-view-framed .feature-list-item{{CURRENT_ITEM}} .feature-list-icon',
					),
					'options'   => array(
						'classic',
						'gradient',
					),
				),
				'sg_setting_list_icon_normal_color'      => array(
					'type'       => 'color',
					'title'      => esc_html__( 'Icon Color', 'jeg-elementor-kit' ),
					'segment'    => 'sg_setting_list',
					'responsive' => true,
					'selectors'  => array(
						'custom' => array(
							'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item{{CURRENT_ITEM}} .feature-list-icon i'   => 'color: {{VALUE}};',
							'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item{{CURRENT_ITEM}} .feature-list-icon svg' => 'fill: {{VALUE}};',
						),
					),
					'dependency' => array(
						array(
							'field'    => 'sg_setting_list_icon_type',
							'operator' => '==',
							'value'    => 'icon',
						),
					),
				),
				'sg_setting_list_icon_normal_border'     => array(
					'type'       => 'border',
					'title'      => esc_html__( 'Icon Border', 'jeg-elementor-kit' ),
					'segment'    => 'sg_setting_list',
					'responsive' => true,
					'selectors'  => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item{{CURRENT_ITEM}} .feature-list-icon',
				),
				'sg_setting_list_icon_normal_tab_end'    => array(
					'type'    => 'control_tab_end',
					'segment' => 'sg_setting_list',
				),
				'sg_setting_list_icon_hover_tab_start'   => array(
					'type'    => 'control_tab_start',
					'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
					'segment' => 'sg_setting_list',
				),
				'sg_setting_list_icon_hover_box_background' => array(
					'type'      => 'background',
					'title'     => esc_html__( 'Icon Box Background', 'jeg-elementor-kit' ),
					'segment'   => 'sg_setting_list',
					'selectors' => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item{{CURRENT_ITEM}} .feature-list-icon-inner:hover',
					'options'   => array(
						'classic',
						'gradient',
					),
				),
				'sg_setting_list_icon_hover_background'  => array(
					'type'      => 'background',
					'title'     => esc_html__( 'Icon Background', 'jeg-elementor-kit' ),
					'segment'   => 'sg_setting_list',
					'selectors' => array(
						'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item{{CURRENT_ITEM}} .feature-list-icon:hover, {{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items.shape-view-framed .feature-list-item{{CURRENT_ITEM}} .feature-list-icon:hover',
					),
					'options'   => array(
						'classic',
						'gradient',
					),
				),
				'sg_setting_list_icon_hover_color'       => array(
					'type'       => 'color',
					'title'      => esc_html__( 'Icon Color', 'jeg-elementor-kit' ),
					'segment'    => 'sg_setting_list',
					'responsive' => true,
					'selectors'  => array(
						'custom' => array(
							'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item{{CURRENT_ITEM}} .feature-list-icon:hover i'   => 'color: {{VALUE}};',
							'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item{{CURRENT_ITEM}} .feature-list-icon:hover svg' => 'fill: {{VALUE}};',
						),
					),
					'dependency' => array(
						array(
							'field'    => 'sg_setting_list_icon_type',
							'operator' => '==',
							'value'    => 'icon',
						),
					),
				),
				'sg_setting_list_icon_hover_border'      => array(
					'type'       => 'border',
					'title'      => esc_html__( 'Icon Border', 'jeg-elementor-kit' ),
					'segment'    => 'sg_setting_list',
					'responsive' => true,
					'selectors'  => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item{{CURRENT_ITEM}} .feature-list-icon:hover',
				),
				'sg_setting_list_icon_hover_tab_end'     => array(
					'type'    => 'control_tab_end',
					'segment' => 'sg_setting_list',
				),
				'sg_setting_list_icon_tabs_end'          => array(
					'type'    => 'control_tabs_end',
					'segment' => 'sg_setting_list',
				),
				'sg_setting_list_title'                  => array(
					'type'      => 'text',
					'segment'   => 'sg_setting_list',
					'separator' => 'before',
					'title'     => esc_html__( 'Title', 'jeg-elementor-kit' ),
					'default'   => esc_html__( 'Feature Item', 'jeg-elementor-kit' ),
				),
				'sg_setting_list_content'                => array(
					'type'    => 'textarea',
					'title'   => esc_html__( 'Content', 'jeg-elementor-kit' ),
					'segment' => 'sg_setting_list',
					'default' => esc_html__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'jeg-elementor-kit' ),
				),
				'sg_setting_list_link'                   => array(
					'type'    => 'link',
					'title'   => esc_html__( 'Link', 'jeg-elementor-kit' ),
					'segment' => 'sg_setting_list',
				),
			),
			'default'     => array(
				array(
					'sg_setting_list_title' => esc_html__( 'Feature Item 1', 'jeg-elementor-kit' ),
					'sg_setting_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'sg_setting_list_icon'  => array(
						'value'   => 'fas fa-check',
						'library' => 'fa-solid',
					),
				),
				array(
					'sg_setting_list_title' => esc_html__( 'Feature Item 2', 'jeg-elementor-kit' ),
					'sg_setting_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'sg_setting_list_icon'  => array(
						'value'   => 'fas fa-times',
						'library' => 'fa-solid',
					),
				),
				array(
					'sg_setting_list_title' => esc_html__( 'Feature Item 3', 'jeg-elementor-kit' ),
					'sg_setting_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
					'sg_setting_list_icon'  => array(
						'value'   => 'fas fa-anchor',
						'library' => 'fa-solid',
					),
				),
			),
		);

		$this->options['sg_setting_html_tag'] = array(
			'type'      => 'select',
			'title'     => esc_html__( 'Title HTML Tag', 'jeg-elementor-kit' ),
			'default'   => 'h3',
			'segment'   => 'segment_setting',
			'separator' => 'before',
			'options'   => array(
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

		$this->options['sg_setting_icon_shape'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Icon Shape', 'jeg-elementor-kit' ),
			'default' => 'circle',
			'segment' => 'segment_setting',
			'options' => array(
				'circle'  => esc_html__( 'Circle', 'jeg-elementor-kit' ),
				'square'  => esc_html__( 'Square', 'jeg-elementor-kit' ),
				'rhombus' => esc_html__( 'Rhombus', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_setting_shape_view'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Shape View', 'jeg-elementor-kit' ),
			'default' => 'stacked',
			'segment' => 'segment_setting',
			'options' => array(
				'framed'  => esc_html__( 'Framed', 'jeg-elementor-kit' ),
				'stacked' => esc_html__( 'Stacked', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_setting_icon_position'] = array(
			'type'                 => 'radio',
			'title'                => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'segment'              => 'segment_setting',
			'default'              => 'left',
			'widescreen_default'   => 'left',
			'desktop_default'      => 'left',
			'laptop_default'       => 'left',
			'tablet_extra_default' => 'left',
			'tablet_default'       => 'left',
			'mobile_extra_default' => 'left',
			'mobile_default'       => 'left',
			'responsive'           => true,
			'render_type'          => 'ui',
			'options'              => array(
				'left'  => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-left',
				),
				'top'   => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-center',
				),
				'right' => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-right',
				),
			),
		);

		$this->options['sg_setting_connector_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Connector', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_list_space_between'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Space Between', 'jeg-elementor-kit' ),
			'segment'    => 'style_list',
			'default'    => 15,
			'options'    => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list' => '--space-between: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item:not(:first-child)' => 'padding-top: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item:not(:last-child)'  => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2);',
				),
			),
		);

		$this->options['st_list_connector_type'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Connector Type', 'jeg-elementor-kit' ),
			'default'    => 'classic',
			'segment'    => 'style_list',
			'separator'  => 'before',
			'options'    => array(
				'classic' => esc_html__( 'Classic', 'jeg-elementor-kit' ),
				'modern'  => esc_html__( 'Modern', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_setting_connector_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_list_connector_style'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Connector Style', 'jeg-elementor-kit' ),
			'default'    => 'solid',
			'segment'    => 'style_list',
			'options'    => array(
				'solid'  => esc_html__( 'Solid', 'jeg-elementor-kit' ),
				'dashed' => esc_html__( 'Dashed', 'jeg-elementor-kit' ),
				'dotted' => esc_html__( 'Dotted', 'jeg-elementor-kit' ),
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .connector'                   => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item:before'                       => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item:after'                        => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items.connector-type-modern .feature-list-item:before' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items.connector-type-modern .feature-list-item:after'  => 'border-style: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_setting_connector_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_list_connector_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Connector Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_list',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .connector'                   => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item:before'                       => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item:after'                        => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items.connector-type-modern .feature-list-item:before' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items.connector-type-modern .feature-list-item:after'  => 'border-color: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_setting_connector_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_list_connector_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Connector Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_list',
			'default'    => 1,
			'options'    => array(
				'min'  => 0,
				'max'  => 5,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .connector'                   => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item:before'                       => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item:after'                        => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items.connector-type-modern .feature-list-item:before' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items.connector-type-modern .feature-list-item:after'  => 'border-width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_setting_connector_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_list_connector_indicator_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Connector Indicator Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_list',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item:after' => 'top: calc({{SIZE}}{{UNIT}} + var(--space-between, 0px)) !important;',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item:first-child:after' => 'top: {{SIZE}}{{UNIT}} !important;',
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

		$this->options['st_icon_normal_box_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Icon Box Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon-inner',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_icon_normal_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Icon Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-feature-list .feature-list-items.shape-view-framed .feature-list-item .feature-list-icon',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_setting_shape_view',
					'operator' => '==',
					'value'    => 'framed',
				),
			),
		);

		$this->options['st_icon_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_normal_border'] = array(
			'type'       => 'border',
			'title'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon',
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

		$this->options['st_icon_hover_box_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Icon Box Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon-inner:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_icon_hover_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Icon Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => '.jeg-elementor-kit.jkit-feature-list .feature-list-items.shape-view-framed .feature-list-item .feature-list-icon:hover',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_setting_shape_view',
					'operator' => '==',
					'value'    => 'framed',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon:hover i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_hover_border'] = array(
			'type'       => 'border',
			'title'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon:hover',
		);

		$this->options['st_icon_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_circle_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'default'    => 70,
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'separator'  => 'before',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon-box .feature-list-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list' => '--icon-size: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_icon_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'default'    => 21,
			'options'    => array(
				'min'  => 0,
				'max'  => 150,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon-box .feature-list-icon',
			'attribute'  => 'font-size',
		);

		$this->options['st_icon_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon-box .feature-list-icon',
			'attribute' => 'padding',
			'default'   => array(
				'top'      => '15',
				'right'    => '15',
				'bottom'   => '15',
				'left'     => '15',
				'unit'     => 'px',
				'isLinked' => true,
			),
		);

		$this->options['st_icon_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon-inner, {{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon' => 'border-radius:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_icon_border_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Border Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'default'    => 1,
			'options'    => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-icon-inner',
			'attribute'  => 'padding',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_shape_view',
					'operator' => '==',
					'value'    => 'framed',
				),
			),
		);

		$this->options['st_icon_spacing'] = array(
			'type'                 => 'slider',
			'title'                => esc_html__( 'Spacing', 'jeg-elementor-kit' ),
			'segment'              => 'style_icon',
			'default'              => 30,
			'tablet_default'       => array(
				'size' => 20,
			),
			'mobile_default'       => array(
				'size' => 10,
			),
			'widescreen_default'   => array(
				'size' => 40,
			),
			'laptop_default'       => array(
				'size' => 30,
			),
			'tablet_extra_default' => array(
				'size' => 30,
			),
			'mobile_extra_default' => array(
				'size' => 20,
			),
			'options'              => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive'           => true,
			'selectors'            => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-content-box',
			'attribute'            => 'margin',
		);

		$this->options['st_content_title_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'segment' => 'style_content',
		);

		$this->options['st_content_title_bottom_space'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Bottom Space', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'default'    => 10,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-content-box .feature-list-title',
			'attribute'  => 'margin-bottom',
		);

		$this->options['st_content_title_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-content-box .feature-list-title, {{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-content-box .feature-list-title a' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_content_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-content-box .feature-list-title, {{WRAPPER}} .jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-content-box .feature-list-title a',
			),
		);

		$this->options['st_content_description_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'separator' => 'before',
			'segment'   => 'style_content',
		);

		$this->options['st_content_description_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-content-box .feature-list-content',
		);

		$this->options['st_content_description_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-feature-list .feature-list-items .feature-list-item .feature-list-content-box .feature-list-content',
		);

		parent::additional_style();
	}
}
