<?php
/**
 * Image Box Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Image_Box_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Image_Box_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Image Box', 'jeg-elementor-kit' );
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
		$this->segments['segment_image'] = array(
			'name'     => esc_html__( 'Image', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->segments['segment_body'] = array(
			'name'     => esc_html__( 'Body', 'jeg-elementor-kit' ),
			'priority' => 11,
		);

		$this->segments['segment_button'] = array(
			'name'     => esc_html__( 'Button', 'jeg-elementor-kit' ),
			'priority' => 12,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_image'] = array(
			'name'      => esc_html__( 'Image', 'jeg-elementor-kit' ),
			'priority'  => 10,
			'kit_style' => true,
		);

		$this->segments['style_body'] = array(
			'name'      => esc_html__( 'Body', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_container'] = array(
			'name'      => esc_html__( 'Container', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_button'] = array(
			'name'       => esc_html__( 'Button', 'jeg-elementor-kit' ),
			'priority'   => 13,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_button_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_floating'] = array(
			'name'       => esc_html__( 'Floating', 'jeg-elementor-kit' ),
			'priority'   => 14,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_image_content_style',
					'operator' => '==',
					'value'    => 'floating',
				),
			),
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_image_choose'] = array(
			'type'    => 'image',
			'title'   => esc_html__( 'Choose Image ', 'jeg-elementor-kit' ),
			'segment' => 'segment_image',
			'default' => \Elementor\Utils::get_placeholder_image_src(),
		);

		$this->options['sg_image_image_size'] = array(
			'type'    => 'imagesize',
			'title'   => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
			'segment' => 'segment_image',
		);

		$this->options['sg_image_content_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Content Style', 'jeg-elementor-kit' ),
			'segment' => 'segment_image',
			'default' => 'default',
			'options' => array(
				'default'  => esc_html__( 'Default', 'jeg-elementor-kit' ),
				'floating' => esc_html__( 'Floating', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_image_equal_height_responsive'] = array(
			'type'         => 'select',
			'title'        => esc_html__( 'Equal Height', 'jeg-elementor-kit' ),
			'default'      => 'disable',
			'segment'      => 'segment_image',
			'options'      => array(
				'disable' => esc_html__( 'Disable', 'jeg-elementor-kit' ),
				'enable'  => esc_html__( 'Enable', 'jeg-elementor-kit' ),
			),
			'prefix_class' => 'jkit-equal-height-',
			'selectors'    => array(
				'custom' => array(
					'{{WRAPPER}}.jkit-equal-height-enable, {{WRAPPER}}.jkit-equal-height-enable .elementor-widget-container, {{WRAPPER}}.jkit-equal-height-enable .jeg-elementor-kit.jkit-image-box, {{WRAPPER}}.jkit-equal-height-enable .jeg-elementor-kit.jkit-image-box .image-box-body .body-inner' => 'height: 100%;',
				),
			),
			'dependency'   => array(
				array(
					'field'    => 'sg_image_content_style',
					'operator' => '==',
					'value'    => 'default',
				),
			),
		);

		$this->options['sg_image_position'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Image Position', 'jeg-elementor-kit' ),
			'segment'    => 'segment_image',
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
			'selectors'  => '.jeg-elementor-kit.jkit-image-box',
			'attribute'  => 'flex-direction',
			'responsive' => true,
		);

		$this->options['sg_image_link_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Link', 'jeg-elementor-kit' ),
			'segment' => 'segment_image',
		);

		$this->options['sg_image_link'] = array(
			'type'       => 'link',
			'title'      => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment'    => 'segment_image',
			'dependency' => array(
				array(
					'field'    => 'sg_image_link_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_body_title'] = array(
			'type'    => 'text',
			'segment' => 'segment_body',
			'title'   => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'default' => esc_html__( 'Image Box', 'jeg-elementor-kit' ),
		);

		$this->options['sg_body_title_tag'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Title HTML Tag', 'jeg-elementor-kit' ),
			'default' => 'h2',
			'segment' => 'segment_body',
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

		$this->options['sg_body_title_icon'] = array(
			'type'    => 'iconpicker',
			'title'   => esc_html__( 'Title Icon', 'jeg-elementor-kit' ),
			'segment' => 'segment_body',
		);

		$this->options['sg_body_title_icon_position'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Title Icon Position', 'jeg-elementor-kit' ),
			'default' => 'before',
			'segment' => 'segment_body',
			'options' => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_body_description'] = array(
			'type'    => 'wysiwyg',
			'segment' => 'segment_body',
			'title'   => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'jeg-elementor-kit' ),
		);

		$this->options['sg_body_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'segment_body',
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
			'selectors'  => '.jeg-elementor-kit.jkit-image-box .image-box-body .body-inner',
			'attribute'  => 'text-align',
			'default'    => 'center',
		);

		$this->options['sg_body_enable_hover_border_bottom'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Hover Border Bottom', 'jeg-elementor-kit' ),
			'segment' => 'segment_body',
		);

		$this->options['st_body_height_border_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height Border Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'segment_body',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-image-box .border-bottom',
			'attribute'  => 'height',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'sg_body_enable_hover_border_bottom',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_body_hover_border_bottom_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Border Bottom Color', 'jeg-elementor-kit' ),
			'segment'    => 'segment_body',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-image-box .border-bottom',
			'attribute'  => 'background-color',
			'dependency' => array(
				array(
					'field'    => 'sg_body_enable_hover_border_bottom',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_body_hover_direction'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Hover Direction', 'jeg-elementor-kit' ),
			'default'    => 'top',
			'segment'    => 'segment_body',
			'default'    => 'left',
			'options'    => array(
				'left'  => esc_html__( 'From Left', 'jeg-elementor-kit' ),
				'right' => esc_html__( 'From Right', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_body_enable_hover_border_bottom',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_button_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Button', 'jeg-elementor-kit' ),
			'segment' => 'segment_button',
		);

		$this->options['sg_button_label'] = array(
			'type'       => 'text',
			'segment'    => 'segment_button',
			'title'      => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'default'    => esc_html__( 'Learn More', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_button_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_button_link'] = array(
			'type'       => 'link',
			'title'      => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment'    => 'segment_button',
			'dependency' => array(
				array(
					'field'    => 'sg_button_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_button_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_button',
			'dependency' => array(
				array(
					'field'    => 'sg_button_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_button_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_button',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_button_enable',
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
		$this->options['st_image_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-header img',
			'attribute' => 'padding',
		);

		$this->options['st_image_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-header, {{WRAPPER}} .jeg-elementor-kit.jkit-image-box .image-box-header img',
			'attribute' => 'border-radius',
		);

		$this->options['st_image_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', 'em', '%' ),
			'selectors'  => '.jeg-elementor-kit.jkit-image-box .image-box-header',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_image_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-image-box .image-box-header img',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_image_object_fit'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Object Fit', 'jeg-elementor-kit' ),
			'default'    => 'cover',
			'segment'    => 'style_image',
			'options'    => array(
				'cover'      => esc_html__( 'Cover', 'jeg-elementor-kit' ),
				'contain'    => esc_html__( 'Contain', 'jeg-elementor-kit' ),
				'fill'       => esc_html__( 'Fill', 'jeg-elementor-kit' ),
				'scale-down' => esc_html__( 'Scale Down', 'jeg-elementor-kit' ),
				'none'       => esc_html__( 'None', 'jeg-elementor-kit' ),
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-image-box .image-box-header img',
			'attribute'  => 'object-fit',
		);

		$this->options['st_image_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'options'    => array(
				'start'  => array(
					'title' => esc_html__( 'Start', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-left',
				),
				'center' => array(
					'title' => esc_html__( 'Center', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-center',
				),
				'end'    => array(
					'title' => esc_html__( 'End', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'selectors'  => '.jeg-elementor-kit.jkit-image-box .image-box-header',
			'attribute'  => 'align-self',
			'responsive' => true,
		);

		$this->options['st_image_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_image',
		);

		$this->options['st_image_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_image',
		);

		$this->options['st_image_normal_opacity'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Normal Opacity', 'jeg-elementor-kit' ),
			'segment'      => 'style_image',
			'default'      => 100,
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'units'        => array( '%' ),
			'default_unit' => '%',
			'selectors'    => '.jeg-elementor-kit.jkit-image-box .image-box-header img',
			'attribute'    => 'opacity',
			'responsive'   => true,
		);

		$this->options['st_image_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-header',
		);

		$this->options['st_image_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-header',
			'attribute' => 'border-radius',
		);

		$this->options['st_image_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_image',
		);

		$this->options['st_image_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_image',
		);

		$this->options['st_image_hover_opacity'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Hover Opacity', 'jeg-elementor-kit' ),
			'segment'      => 'style_image',
			'default'      => 100,
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'units'        => array( '%' ),
			'default_unit' => '%',
			'selectors'    => '.jeg-elementor-kit.jkit-image-box:hover .image-box-header img',
			'attribute'    => 'opacity',
			'responsive'   => true,
		);

		$this->options['st_image_hover_scale'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Hover Scale', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'default'    => 1.1,
			'options'    => array(
				'min'  => 1,
				'max'  => 2,
				'step' => 0.1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box:hover .image-box-header img' => '-webkit-transform: scale({{SIZE}}); -o-transform: scale({{SIZE}}); -moz-transform: scale({{SIZE}}); -ms-transform: scale({{SIZE}}); transform: scale({{SIZE}});',
				),
			),
		);

		$this->options['st_image_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'selectors' => '.jeg-elementor-kit.jkit-image-box:hover .image-box-header',
		);

		$this->options['st_image_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-image-box:hover .image-box-header',
			'attribute' => 'border-radius',
		);

		$this->options['st_image_hover_animation'] = array(
			'type'    => 'hoveranimation',
			'title'   => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment' => 'style_image',
		);

		$this->options['st_image_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_image',
		);

		$this->options['st_image_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_image',
		);

		$this->options['st_body_type'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-body .body-inner',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_body_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-body .body-inner',
		);

		$this->options['st_body_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-body .body-inner',
		);

		$this->options['st_body_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-body .body-inner',
			'attribute' => 'padding',
		);

		$this->options['st_body_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-body .body-inner',
			'attribute' => 'border-radius',
		);

		$this->options['st_body_title_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'separator' => 'before',
		);

		$this->options['st_body_title_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-body .body-title',
			'attribute' => 'margin',
		);

		$this->options['st_body_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-body .body-title',
		);

		$this->options['st_body_title_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Font Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_body',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .image-box-body .body-title i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .image-box-body .body-title svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_body_title_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_body',
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .image-box-body .body-title.icon-position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-image-box .image-box-body .body-title.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .image-box-body .body-title.icon-position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-image-box .image-box-body .body-title.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_body_title_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_body',
		);

		$this->options['st_body_title_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_body',
		);

		$this->options['st_body_title_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_body',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-image-box .image-box-body .body-title',
		);

		$this->options['st_body_title_normal_icon_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Icon Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_body',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .image-box-body .body-title i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .image-box-body .body-title svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_body_title_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_body',
		);

		$this->options['st_body_title_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_body',
		);

		$this->options['st_body_title_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .image-box-body .body-title' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_body_title_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_body',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-image-box:hover .image-box-body .body-title',
		);

		$this->options['st_body_title_hover_icon_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Icon Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_body',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box:hover .image-box-body .body-title i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box:hover .image-box-body .body-title svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_body_title_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_body',
		);

		$this->options['st_body_title_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_body',
		);

		$this->options['st_body_description_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'separator' => 'before',
		);

		$this->options['st_body_description_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-body .body-inner .body-description',
			'attribute' => 'margin',
		);

		$this->options['st_body_description_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'selectors' => '.jeg-elementor-kit.jkit-image-box .image-box-body .body-inner .body-description',
		);

		$this->options['st_body_description_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_body',
		);

		$this->options['st_body_description_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_body',
		);

		$this->options['st_body_description_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_body',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-image-box .image-box-body .body-inner .body-description',
		);

		$this->options['st_body_description_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_body',
		);

		$this->options['st_body_description_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_body',
		);

		$this->options['st_body_description_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_body',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .image-box-body .body-inner .body-description' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_body_description_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_body',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-image-box:hover .image-box-body .body-inner .body-description',
		);

		$this->options['st_body_description_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_body',
		);

		$this->options['st_body_description_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_body',
		);

		$this->options['st_container_hover_animation'] = array(
			'type'    => 'hoveranimation',
			'title'   => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment' => 'style_container',
		);

		$this->options['st_button_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a',
		);

		$this->options['st_button_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Font Size', 'jeg-elementor-kit' ),
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_button_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .button-box.icon-position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-image-box .button-box.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .button-box.icon-position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-image-box .button-box.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_button_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a',
			'attribute' => 'padding',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_button',
			'selectors'      => '.jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a',
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
			'selectors' => '.jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a',
		);

		$this->options['st_button_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a',
		);

		$this->options['st_button_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a',
			'attribute' => 'border-radius',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a' => 'transition-duration: {{SIZE}}s;',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_button',
			'selectors'      => '.jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a:not(.hover-gradient):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a.hover-gradient:before',
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
			'selectors' => '.jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a:hover',
		);

		$this->options['st_button_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a:hover',
		);

		$this->options['st_button_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-image-box .button-box .button-wrapper a:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_button_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_button',
		);

		$this->options['st_button_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_button',
		);

		$this->options['st_floating_margin_top'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Top', 'jeg-elementor-kit' ),
			'segment'    => 'style_floating',
			'default'    => -50,
			'options'    => array(
				'min'  => -100,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-image-box.style-floating .image-box-body .body-inner',
			'attribute'  => 'margin-top',
			'responsive' => true,
		);

		$this->options['st_floating_width'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'      => 'style_floating',
			'default'      => 90,
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'units'        => array( '%' ),
			'default_unit' => '%',
			'selectors'    => '.jeg-elementor-kit.jkit-image-box.style-floating .image-box-body .body-inner',
			'attribute'    => 'width',
			'responsive'   => true,
		);

		$this->options['st_floating_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_floating',
		);

		$this->options['st_floating_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_floating',
		);

		$this->options['st_floating_normal_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Normal Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_floating',
			'default'    => 90,
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-image-box.style-floating .image-box-body .body-inner',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_floating_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_floating',
		);

		$this->options['st_floating_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_floating',
		);

		$this->options['st_floating_hover_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Hover Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_floating',
			'default'    => 220,
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-image-box.style-floating:hover .image-box-body .body-inner',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_floating_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_floating',
		);

		$this->options['st_floating_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_floating',
		);

		parent::additional_style();
	}
}
