<?php
/**
 * Icon Box Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Icon_Box_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Icon_Box_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Icon Box', 'jeg-elementor-kit' );
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
			'name'     => esc_html__( 'Icon Box', 'jeg-elementor-kit' ),
			'priority' => 11,
		);

		$this->segments['segment_readmore'] = array(
			'name'     => esc_html__( 'Read More', 'jeg-elementor-kit' ),
			'priority' => 12,
		);

		$this->segments['segment_badge'] = array(
			'name'     => esc_html__( 'Badge', 'jeg-elementor-kit' ),
			'priority' => 13,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_container'] = array(
			'name'      => esc_html__( 'Icon Box Container', 'jeg-elementor-kit' ),
			'priority'  => 10,
			'kit_style' => true,
		);

		$this->segments['style_content'] = array(
			'name'      => esc_html__( 'Content', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_icon'] = array(
			'name'       => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'priority'   => 12,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_icon_type!',
					'operator' => '==',
					'value'    => 'none',
				),
			),

		);
		$this->segments['style_button'] = array(
			'name'       => esc_html__( 'Button', 'jeg-elementor-kit' ),
			'priority'   => 13,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_readmore_enable_button',
					'operator' => '==',
					'value'    => true,
				),
			),

		);
		$this->segments['style_background'] = array(
			'name'      => esc_html__( 'Background Overlay', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);
		$this->segments['style_badge']      = array(
			'name'       => esc_html__( 'Badge', 'jeg-elementor-kit' ),
			'priority'   => 15,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_badge_show',
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
		$this->options['sg_setting_enable_hover_watermark'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Hover Water Mark', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
		);

		$this->options['sg_setting_hover_watermark_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Hover Watermark Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'far fa-map',
				'library' => 'fa-regular',
			),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_enable_hover_watermark',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_setting_icon_position'] = array(
			'type'        => 'radio',
			'title'       => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'segment'     => 'segment_setting',
			'options'     => array(
				'left'   => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-left',
				),
				'top'    => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-top',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-right',
				),
				'bottom' => array(
					'title' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-bottom',
				),
			),
			'responsive'  => true,
			'description' => esc_html__( 'Since version 2.4.5, this option has responsive options. If you don\'t choose any, the default value is `Top` or your old value.', 'jeg-elementor-kit' ),
		);

		$this->options['sg_setting_content_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Content Alignment', 'jeg-elementor-kit' ),
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
			'selectors'  => '.jeg-elementor-kit.jkit-icon-box .jkit-icon-box-wrapper',
			'attribute'  => 'text-align',
			'default'    => 'center',
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

		$this->options['sg_setting_equal_height_responsive'] = array(
			'type'         => 'select',
			'title'        => esc_html__( 'Equal Height', 'jeg-elementor-kit' ),
			'default'      => 'disable',
			'segment'      => 'segment_setting',
			'options'      => array(
				'disable' => esc_html__( 'Disable', 'jeg-elementor-kit' ),
				'enable'  => esc_html__( 'Enable', 'jeg-elementor-kit' ),
			),
			'prefix_class' => 'jkit-equal-height-',
			'selectors'    => array(
				'custom' => array(
					'{{WRAPPER}}.jkit-equal-height-enable, {{WRAPPER}}.jkit-equal-height-enable .elementor-widget-container, {{WRAPPER}}.jkit-equal-height-enable .jeg-elementor-kit.jkit-icon-box, {{WRAPPER}}.jkit-equal-height-enable .jeg-elementor-kit.jkit-icon-box .jkit-icon-box-wrapper' => 'height: 100%;',
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

		$this->options['sg_icon_header'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Header Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'far fa-user',
				'library' => 'fa-regular',
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
			'dependency' => array(
				array(
					'field'    => 'sg_icon_type',
					'operator' => '==',
					'value'    => 'image',
				),
			),
		);

		$this->options['sg_icon_text'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'segment' => 'segment_icon',
			'default' => esc_html__( 'Icon Box', 'jeg-elementor-kit' ),
		);

		$this->options['sg_icon_description'] = array(
			'type'    => 'textarea',
			'title'   => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'segment' => 'segment_icon',
			'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
		);

		$this->options['sg_readmore_enable_button'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Button', 'jeg-elementor-kit' ),
			'default' => false,
			'segment' => 'segment_readmore',
		);

		$this->options['sg_readmore_enable_globallink'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Global Link', 'jeg-elementor-kit' ),
			'default'    => false,
			'segment'    => 'segment_readmore',
			'dependency' => array(
				array(
					'field'    => 'sg_readmore_enable_button!',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_readmore_globallink'] = array(
			'type'    => 'link',
			'title'   => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment' => 'segment_readmore',
		);

		$this->options['sg_readmore_enable_hover_button'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Enable Hover Button', 'jeg-elementor-kit' ),
			'default'    => false,
			'segment'    => 'segment_readmore',
			'dependency' => array(
				array(
					'field'    => 'sg_readmore_enable_button',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_readmore_button_label'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'segment'    => 'segment_readmore',
			'default'    => esc_html__( 'Learn More', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_readmore_enable_button',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_readmore_button_enable_icon'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Enable Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_readmore',
			'dependency' => array(
				array(
					'field'    => 'sg_readmore_enable_button',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_readmore_button_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-book',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_readmore',
			'dependency' => array(
				array(
					'field'    => 'sg_readmore_enable_button',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_readmore_button_enable_icon',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_readmore_button_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_readmore',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_readmore_enable_button',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_readmore_button_enable_icon',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_badge_show'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Badge', 'jeg-elementor-kit' ),
			'segment' => 'segment_badge',
		);

		$this->options['sg_badge_text'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Text', 'jeg-elementor-kit' ),
			'segment'    => 'segment_badge',
			'default'    => esc_html__( 'BADGE', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_badge_show',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_badge_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Position', 'jeg-elementor-kit' ),
			'default'    => 'centerleft',
			'segment'    => 'segment_badge',
			'options'    => array(
				'topleft'      => esc_html__( 'Top Left', 'jeg-elementor-kit' ),
				'topright'     => esc_html__( 'Top Right', 'jeg-elementor-kit' ),
				'topcenter'    => esc_html__( 'Top Center', 'jeg-elementor-kit' ),
				'centerleft'   => esc_html__( 'Center Left', 'jeg-elementor-kit' ),
				'bottomleft'   => esc_html__( 'Bottom Left', 'jeg-elementor-kit' ),
				'bottomcenter' => esc_html__( 'Bottom Center', 'jeg-elementor-kit' ),
				'bottomright'  => esc_html__( 'Bottom Right', 'jeg-elementor-kit' ),
				'custom'       => esc_html__( 'Custom', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_badge_show',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_badge_position_horizontal_orientation'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Horizontal Orientation', 'jeg-elementor-kit' ),
			'segment'    => 'segment_badge',
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
					'field'    => 'sg_badge_position',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['sg_badge_position_horizontal_offset'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Offset', 'jeg-elementor-kit' ),
			'segment'    => 'segment_badge',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 8,
			'selectors'  => array(
				'custom' => array( '{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box-badge.custom' => '{{sg_badge_position_horizontal_orientation.VALUE}}: {{SIZE}}{{UNIT}};' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_badge_position',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['sg_badge_position_vertical_orientation'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Vertical Orientation', 'jeg-elementor-kit' ),
			'segment'    => 'segment_badge',
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
					'field'    => 'sg_badge_position',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['sg_badge_position_vertical_offset'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Offset', 'jeg-elementor-kit' ),
			'segment'    => 'segment_badge',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 9,
			'selectors'  => array(
				'custom' => array( '{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box-badge.custom' => '{{sg_badge_position_vertical_orientation.VALUE}}: {{SIZE}}{{UNIT}};' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_badge_position',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_container_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_container',
		);

		$this->options['st_container_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_container',
		);

		$this->options['st_container_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_container',
			'selectors'      => '.jeg-elementor-kit.jkit-icon-box .jkit-icon-box-wrapper',
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

		$this->options['st_container_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .jkit-icon-box-wrapper',
			'attribute' => 'padding',
		);

		$this->options['st_container_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .jkit-icon-box-wrapper',
		);

		$this->options['st_container_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .jkit-icon-box-wrapper',
		);

		$this->options['st_container_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .jkit-icon-box-wrapper',
			'attribute' => 'border-radius',
		);

		$this->options['st_container_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_container',
		);

		$this->options['st_container_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_container',
		);

		$this->options['st_container_hover_transition_duration'] = array(
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .jkit-icon-box-wrapper' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_container_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_container',
			'selectors'      => '.jeg-elementor-kit.jkit-icon-box:hover .jkit-icon-box-wrapper:not(.hover-gradient), {{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .jkit-icon-box-wrapper.hover-gradient:after',
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

		$this->options['st_container_hover_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box:hover .jkit-icon-box-wrapper',
			'attribute' => 'padding',
		);

		$this->options['st_container_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box:hover .jkit-icon-box-wrapper',
		);

		$this->options['st_container_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box:hover .jkit-icon-box-wrapper',
		);

		$this->options['st_container_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box:hover .jkit-icon-box-wrapper',
			'attribute' => 'border-radius',
		);

		$this->options['st_container_hover_animation'] = array(
			'type'    => 'hoveranimation',
			'title'   => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment' => 'style_container',
		);

		$this->options['st_container_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_container',
		);

		$this->options['st_container_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_container',
		);

		$this->options['st_content_title_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'segment' => 'style_content',
		);

		$this->options['st_content_title_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .title',
			'attribute' => 'margin',
		);

		$this->options['st_content_title_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .title',
			'attribute' => 'padding',
		);

		$this->options['st_content_title_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-icon-box .title',
		);

		$this->options['st_content_title_color_hover'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color Hover', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-icon-box:hover .title',
		);

		$this->options['st_content_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .title',
		);

		$this->options['st_content_description_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'separator' => 'before',
		);

		$this->options['st_content_description_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-icon-box .icon-box.icon-box-body .icon-box-description',
		);

		$this->options['st_content_description_color_hover'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color Hover', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-icon-box:hover .icon-box.icon-box-body .icon-box-description',
		);

		$this->options['st_content_description_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box.icon-box-body .icon-box-description',
		);

		$this->options['st_content_description_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box.icon-box-body .icon-box-description',
			'attribute' => 'margin',
		);

		$this->options['st_content_watermark_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Watermark', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'separator' => 'before',
		);

		$this->options['st_content_watermark_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Watermark Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .hover-watermark i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .hover-watermark svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_content_watermark_font_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Watermark Font Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'default'    => 100,
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .hover-watermark i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .hover-watermark svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'responsive' => true,
		);

		$this->options['sg_icon_color_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Color Style', 'jeg-elementor-kit' ),
			'default' => 'color',
			'segment' => 'style_icon',
			'options' => array(
				'color'    => 'Color',
				'gradient' => 'Gradient',
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

		$this->options['st_icon_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box > .icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box > .icon svg' => 'fill: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_color_style',
					'operator' => '==',
					'value'    => 'color',
				),
			),
		);

		$this->options['st_icon_gradient'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Gradient Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box > .icon.style-gradient, {{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box > .icon.style-gradient svg',
			),
			'options'    => array(
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_color_style',
					'operator' => '==',
					'value'    => 'gradient',
				),
			),
		);

		$this->options['st_icon_bg_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Background Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-icon-box .icon-box > .icon',
			'attribute'  => 'background-color',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_color_style',
					'operator' => '==',
					'value'    => 'color',
				),
			),
		);

		$this->options['st_icon_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box > .icon',
		);

		$this->options['st_icon_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box > .icon',
			'attribute' => 'border-radius',
		);

		$this->options['st_icon_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box > .icon',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box:hover .icon-box > .icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box:hover .icon-box > .icon svg' => 'fill: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_color_style',
					'operator' => '==',
					'value'    => 'color',
				),
			),
		);

		$this->options['st_icon_hover_gradient'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Hover Gradient Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'selectors'  => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box:hover .icon-box > .icon.style-gradient, {{WRAPPER}} .jeg-elementor-kit.jkit-icon-box:hover .icon-box > .icon.style-gradient svg',
			),
			'options'    => array(
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_icon_color_style',
					'operator' => '==',
					'value'    => 'gradient',
				),
			),
		);

		$this->options['st_icon_hover_bg_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Background Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-icon-box:hover .icon-box > .icon',
			'attribute'  => 'background-color',
			'dependency' => array(
				array(
					'field'    => 'sg_icon_color_style',
					'operator' => '==',
					'value'    => 'color',
				),
			),
		);

		$this->options['st_icon_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box:hover .icon-box > .icon',
		);

		$this->options['st_icon_hover_animation'] = array(
			'type'    => 'hoveranimation',
			'title'   => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment' => 'style_icon',
		);

		$this->options['st_icon_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box > .icon:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_icon_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box > .icon:hover',
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
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box > .icon i'   => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box > .icon svg' => 'width: {{SIZE}}{{UNIT}}',
				),
			),
			'responsive' => true,
			'separator'  => 'before',
		);

		$this->options['st_icon_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Icon Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box > .icon',
			'attribute' => 'margin',
		);

		$this->options['st_icon_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Icon Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box > .icon',
			'attribute' => 'padding',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box > .icon' => '-webkit-transform: rotate({{SIZE}}deg); -o-transform: rotate({{SIZE}}deg); -moz-transform: rotate({{SIZE}}deg); -ms-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
				),
			),
			'attribute'  => 'rotation',
			'responsive' => true,
		);

		$this->options['st_icon_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'default'    => 40,
			'options'    => array(
				'min'  => 10,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-icon-box .icon-box > .icon',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_icon_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 10,
				'max'  => 200,
				'step' => 1,
			),
			'default'    => 40,
			'selectors'  => '.jeg-elementor-kit.jkit-icon-box .icon-box > .icon',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_icon_line_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Line Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 10,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-icon-box .icon-box > .icon',
			'attribute'  => 'line-height',
			'responsive' => true,
		);

		$this->options['st_button_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Button Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link',
			'attribute' => 'padding',
		);

		$this->options['st_button_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Button Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link',
			'attribute' => 'margin',
		);

		$this->options['st_button_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link',
		);

		$this->options['st_button_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Button Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'default'    => 15,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'responsive' => true,
		);

		$this->options['st_button_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Button Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box-button .icon-position-after a.icon-box-link i, {{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box-button .icon-position-after a.icon-box-link svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box-button .icon-position-before a.icon-box-link i, {{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box-button .icon-position-before a.icon-box-link svg' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			),
			'responsive' => true,
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

		$this->options['st_button_normal_text_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link, {{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link svg'                                                                              => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_button',
			'selectors'      => '.jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link',
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

		$this->options['st_button_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link',
		);

		$this->options['st_button_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link',
			'attribute' => 'border-radius',
		);

		$this->options['st_button_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box .icon-box-button a.icon-box-link' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_button_hover_text_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box:hover .icon-box-button a.icon-box-link, {{WRAPPER}} .jeg-elementor-kit.jkit-icon-box:hover .icon-box-button a.icon-box-link i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-icon-box:hover .icon-box-button a.icon-box-link svg'                                                                                    => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_button',
			'selectors'      => '.jeg-elementor-kit.jkit-icon-box:hover .icon-box-button a.icon-box-link:not(.hover-gradient), {{WRAPPER}} .jeg-elementor-kit.jkit-icon-box:hover .icon-box-button a.icon-box-link.hover-gradient:before',
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
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box:hover .icon-box-button a.icon-box-link',
		);

		$this->options['st_button_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box:hover .icon-box-button a.icon-box-link',
			'attribute' => 'border-radius',
		);

		$this->options['st_button_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box:hover .icon-box-button a.icon-box-link',
		);

		$this->options['st_button_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_button',
		);

		$this->options['st_button_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_button',
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
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .jkit-icon-box-wrapper:before',
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
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .jkit-icon-box-wrapper:hover:before',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_background_hover_direction'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Hover Direction', 'jeg-elementor-kit' ),
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

		$this->options['st_badge_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_badge',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-icon-box .icon-box-badge .badge-text',
		);

		$this->options['st_badge_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_badge',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box-badge .badge-text',
			'attribute' => 'margin',
		);

		$this->options['st_badge_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_badge',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box-badge .badge-text',
			'attribute' => 'padding',
		);

		$this->options['st_badge_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_badge',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box-badge .badge-text',
			'attribute' => 'border-radius',
		);

		$this->options['st_badge_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_badge',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box-badge .badge-text',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_badge_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_badge',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box-badge .badge-text',
		);

		$this->options['st_badge_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_badge',
			'selectors' => '.jeg-elementor-kit.jkit-icon-box .icon-box-badge .badge-text',
		);

		parent::additional_style();
	}
}
