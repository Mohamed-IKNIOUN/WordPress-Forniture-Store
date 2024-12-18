<?php
/**
 * Testimonials Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Testimonials_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Testimonials_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Testimonial', 'jeg-elementor-kit' );
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

		$this->segments['segment_layout'] = array(
			'name'     => esc_html__( 'Layout', 'jeg-elementor-kit' ),
			'priority' => 11,
		);

		$this->segments['segment_testimonials'] = array(
			'name'     => esc_html__( 'Testimonials', 'jeg-elementor-kit' ),
			'priority' => 12,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_wrapper'] = array(
			'name'      => esc_html__( 'Content Wrapper', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_description'] = array(
			'name'      => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_quote'] = array(
			'name'      => esc_html__( 'Quote', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		$this->segments['style_rating'] = array(
			'name'      => esc_html__( 'Rating', 'jeg-elementor-kit' ),
			'priority'  => 15,
			'kit_style' => true,
		);

		$this->segments['style_client_name'] = array(
			'name'      => esc_html__( 'Client Name', 'jeg-elementor-kit' ),
			'priority'  => 16,
			'kit_style' => true,
		);

		$this->segments['style_client_designation'] = array(
			'name'      => esc_html__( 'Client Designation', 'jeg-elementor-kit' ),
			'priority'  => 17,
			'kit_style' => true,
		);

		$this->segments['style_client_image'] = array(
			'name'      => esc_html__( 'Client Image', 'jeg-elementor-kit' ),
			'priority'  => 18,
			'kit_style' => true,
		);

		$this->segments['style_client_layout'] = array(
			'name'       => esc_html__( 'Client Layout', 'jeg-elementor-kit' ),
			'priority'   => 19,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_layout_testimonial_choose',
					'operator' => '==',
					'value'    => 'style-1',
				),
			),
		);

		$this->segments['style_arrow'] = array(
			'name'      => esc_html__( 'Arrow', 'jeg-elementor-kit' ),
			'priority'  => 20,
			'kit_style' => true,
		);

		$this->segments['style_dots'] = array(
			'name'      => esc_html__( 'Dots', 'jeg-elementor-kit' ),
			'priority'  => 21,
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
			'title'      => esc_html__( 'Spacing Horizontal', 'jeg-elementor-kit' ),
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
			'type'           => 'slider',
			'title'          => esc_html__( 'Slide to Show', 'jeg-elementor-kit' ),
			'segment'        => 'segment_setting',
			'default'        => 3,
			'tablet_default' => array(
				'size' => 2,
			),
			'mobile_default' => array(
				'size' => 1,
			),
			'options'        => array(
				'min'  => 1,
				'max'  => 5,
				'step' => 1,
			),
			'responsive'     => true,
		);

		$this->options['sg_setting_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'segment_setting',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials',
			'attribute' => 'padding',
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
				'custom'        => esc_html__( 'Custom', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_setting_arrow',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_setting_arrow_vertical_orientation'] = array(
			'type'        => 'radio',
			'title'       => esc_html__( 'Vertical Orientation', 'jeg-elementor-kit' ),
			'segment'     => 'segment_setting',
			'options'     => array(
				'top'    => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-top',
				),
				'bottom' => array(
					'title' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-bottom',
				),
			),
			'default'     => 'top',
			'toggle'      => false,
			'render_type' => 'ui',
			'dependency'  => array(
				array(
					'field'    => 'sg_setting_arrow_position',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['sg_setting_arrow_position_vertical_offset'] = array(
			'type'        => 'slider',
			'title'       => esc_html__( 'Offset', 'jeg-elementor-kit' ),
			'segment'     => 'segment_setting',
			'units'       => array( 'px', '%', 'em' ),
			'options'     => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'default'     => 20,
			'responsive'  => true,
			'selectors'   => '.jeg-elementor-kit.jkit-testimonials .tns-controls',
			'attribute'   => '{{sg_setting_arrow_vertical_orientation.VALUE}}',
			'render_type' => 'ui',
			'dependency'  => array(
				array(
					'field'    => 'sg_setting_arrow_position',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['sg_setting_arrow_horizontal_orientation'] = array(
			'type'        => 'radio',
			'title'       => esc_html__( 'Horizontal Orientation', 'jeg-elementor-kit' ),
			'segment'     => 'segment_setting',
			'options'     => array(
				'left'  => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-left',
				),
				'right' => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-right',
				),
			),
			'default'     => 'right',
			'toggle'      => false,
			'render_type' => 'ui',
			'dependency'  => array(
				array(
					'field'    => 'sg_setting_arrow_position',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['sg_setting_arrow_position_horizontal_offset'] = array(
			'type'        => 'slider',
			'title'       => esc_html__( 'Offset', 'jeg-elementor-kit' ),
			'segment'     => 'segment_setting',
			'units'       => array( 'px', '%', 'em' ),
			'options'     => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'default'     => 30,
			'responsive'  => true,
			'selectors'   => '.jeg-elementor-kit.jkit-testimonials .tns-controls',
			'attribute'   => '{{sg_setting_arrow_horizontal_orientation.VALUE}}',
			'render_type' => 'ui',
			'dependency'  => array(
				array(
					'field'    => 'sg_setting_arrow_position',
					'operator' => '==',
					'value'    => 'custom',
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

		$this->options['sg_setting_quote'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Quote', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
		);

		$this->options['sg_setting_quote_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Choose Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-quote-left',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_quote',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_setting_rating'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Rating', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
		);

		$this->options['sg_setting_rating_icon_full'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Star Rating Full', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-star',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_rating',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_setting_rating_icon_half'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Star Rating Half', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-star-half',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_rating',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_layout_testimonial_choose'] = array(
			'type'    => 'radio',
			'title'   => esc_html__( 'Choose Style', 'jeg-elementor-kit' ),
			'segment' => 'segment_layout',
			'default' => 'style-1',
			'options' => array(
				'style-1' => array(
					'title' => esc_html__( 'Style 1', 'jeg-elementor-kit' ),
					'icon'  => 'jkit-testimonials-layout-1',
				),
				'style-2' => array(
					'title' => esc_html__( 'Style 2', 'jeg-elementor-kit' ),
					'icon'  => 'jkit-testimonials-layout-2',
				),
				'style-3' => array(
					'title' => esc_html__( 'Style 3', 'jeg-elementor-kit' ),
					'icon'  => 'jkit-testimonials-layout-3',
				),
				'style-4' => array(
					'title' => esc_html__( 'Style 4', 'jeg-elementor-kit' ),
					'icon'  => 'jkit-testimonials-layout-4',
				),
			),
		);

		$this->options['sg_layout_image_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Image Position', 'jeg-elementor-kit' ),
			'default'    => 'above',
			'segment'    => 'segment_layout',
			'options'    => array(
				'above' => esc_html__( 'Above Content', 'jeg-elementor-kit' ),
				'below' => esc_html__( 'Below Content', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_layout_testimonial_choose!',
					'operator' => '==',
					'value'    => 'style-1',
				),
			),
		);

		$this->options['sg_testimonials_image_size'] = array(
			'type'    => 'imagesize',
			'title'   => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
			'segment' => 'segment_testimonials',
		);

		$this->options['sg_testimonials_list'] = array(
			'type'        => 'repeater',
			'title'       => esc_html__( 'Testimonials', 'jeg-elementor-kit' ),
			'segment'     => 'segment_testimonials',
			'title_field' => '{{ sg_testimonials_list_client_name }}',
			'fields'      => array(
				'sg_testimonials_list_client_name'   => array(
					'type'    => 'text',
					'segment' => 'sg_testimonials_list',
					'title'   => esc_html__( 'Client Name', 'jeg-elementor-kit' ),
					'default' => esc_html__( 'John Doe', 'jeg-elementor-kit' ),
				),
				'sg_testimonials_list_designation'   => array(
					'type'    => 'text',
					'segment' => 'sg_testimonials_list',
					'title'   => esc_html__( 'Designation', 'jeg-elementor-kit' ),
					'default' => esc_html__( 'Designation', 'jeg-elementor-kit' ),
				),
				'sg_testimonials_list_review'        => array(
					'type'    => 'textarea',
					'segment' => 'sg_testimonials_list',
					'title'   => esc_html__( 'Review', 'jeg-elementor-kit' ),
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'jeg-elementor-kit' ),
				),
				'sg_testimonials_list_rating'        => array(
					'type'    => 'slider',
					'title'   => esc_html__( 'Rating', 'jeg-elementor-kit' ),
					'default' => 5,
					'segment' => 'sg_testimonials_list',
					'options' => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.5,
					),
				),
				'sg_testimonials_list_client_avatar' => array(
					'type'        => 'image',
					'segment'     => 'sg_testimonials_list',
					'title'       => esc_html__( 'Client Avatar', 'jeg-elementor-kit' ),
					'description' => esc_html__( 'Recommended Size: Thumbnail', 'jeg-elementor-kit' ),
					'default'     => \Elementor\Utils::get_placeholder_image_src(),
				),
				'sg_testimonials_list_background'    => array(
					'type'      => 'background',
					'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
					'segment'   => 'sg_testimonials_list',
					'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item{{CURRENT_ITEM}} .testimonial-box',
					'options'   => array(
						'classic',
						'gradient',
					),
				),
			),
			'default'     => array(
				array(
					'sg_testimonials_list_client_avatar' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_testimonials_list_client_avatar' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_testimonials_list_client_avatar' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_testimonials_list_client_avatar' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_testimonials_list_client_avatar' => array(
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
		$this->options['st_wrapper_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_wrapper',
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
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box',
			'attribute'  => 'text-align',
		);

		$this->options['st_wrapper_fix_height'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Fix Height', 'jeg-elementor-kit' ),
			'segment' => 'style_wrapper',
		);

		$this->options['st_wrapper_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_wrapper',
			'default'    => 500,
			'options'    => array(
				'min'  => 30,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item.fix-height .testimonial-box',
			'attribute'  => 'min-height',
			'dependency' => array(
				array(
					'field'    => 'st_wrapper_fix_height',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_layout_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_wrapper_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box',
			'attribute' => 'margin',
		);

		$this->options['st_layout_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box',
			'attribute' => 'padding',
		);

		$this->options['st_layout_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box'                                     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials.style-1 .testimonials-track .testimonial-item .testimonial-box .testimonial-slider::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_layout_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box',
		);

		$this->options['st_layout_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box',
		);

		$this->options['st_layout_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box:hover',
		);

		$this->options['st_layout_hover_overlay_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Overlay', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'separator' => 'before',
		);

		$this->options['st_layout_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials:not(.style-1) .testimonials-track .testimonial-item .testimonial-box::before, {{WRAPPER}} .jeg-elementor-kit.jkit-testimonials.style-1 .testimonials-track .testimonial-item .testimonial-slider::before',
			),
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_layout_hover_direction'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Hover Direction', 'jeg-elementor-kit' ),
			'segment' => 'style_wrapper',
			'default' => 'left',
			'options' => array(
				'left'   => esc_html__( 'From Left', 'jeg-elementor-kit' ),
				'top'    => esc_html__( 'From Top', 'jeg-elementor-kit' ),
				'right'  => esc_html__( 'From Right', 'jeg-elementor-kit' ),
				'bottom' => esc_html__( 'From Bottom', 'jeg-elementor-kit' ),
				'arise'  => esc_html__( 'Arise', 'jeg-elementor-kit' ),
			),
		);

		$this->options['st_description_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .comment-content p',
		);

		$this->options['st_description_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_description',
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
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .comment-content p',
			'attribute'  => 'text-align',
		);

		$this->options['st_description_margin_1'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .comment-content p',
			'attribute' => 'margin',
		);

		$this->options['st_description_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .comment-content p',
			'attribute' => 'padding',
		);

		$this->options['st_description_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_description',
		);

		$this->options['st_description_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_description',
		);

		$this->options['st_description_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_description',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .comment-content p',
		);

		$this->options['st_description_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .comment-content p',
		);

		$this->options['st_description_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .comment-content p',
			'attribute' => 'border-radius',
		);

		$this->options['st_description_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_description',
		);

		$this->options['st_description_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_description',
		);

		$this->options['st_description_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .comment-content p' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_description_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_description',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .comment-content p',
		);

		$this->options['st_description_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .comment-content p',
		);

		$this->options['st_description_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .comment-content p',
			'attribute' => 'border-radius',
		);

		$this->options['st_description_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_description',
		);

		$this->options['st_description_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_description',
		);

		$this->options['st_quote_override_position'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Override Position', 'jeg-elementor-kit' ),
			'segment' => 'style_quote',
		);

		$this->options['st_quote_override_position_top'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Top', 'jeg-elementor-kit' ),
			'segment'    => 'style_quote',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials.quote-override .testimonials-track .testimonial-item .testimonial-box .icon-content',
			'attribute'  => 'top',
			'dependency' => array(
				array(
					'field'    => 'st_quote_override_position',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_quote_override_position_left'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Left', 'jeg-elementor-kit' ),
			'segment'    => 'style_quote',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials.quote-override .testimonials-track .testimonial-item .testimonial-box .icon-content',
			'attribute'  => 'left',
			'dependency' => array(
				array(
					'field'    => 'st_quote_override_position',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_quote_reverse_position'] = array(
			'type'         => 'checkbox',
			'title'        => esc_html__( 'Reverse Position', 'jeg-elementor-kit' ),
			'segment'      => 'style_quote',
			'prefix_class' => 'quote-reverse-position-',
			'selectors'    => array(
				'custom' => array(
					'{{WRAPPER}}.quote-reverse-position-yes .jeg-elementor-kit.jkit-testimonials.style-2 .testimonials-track .testimonial-item .testimonial-box .comment-bio' => 'flex-direction: row-reverse;',
				),
			),
			'dependency'   => array(
				array(
					'field'    => 'sg_layout_testimonial_choose',
					'operator' => '==',
					'value'    => 'style-2',
				),
				array(
					'field'    => 'st_quote_override_position!',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_quote_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_quote',
		);

		$this->options['st_quote_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_quote',
		);

		$this->options['st_quote_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_quote',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .icon-content'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .icon-content svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_quote_normal_font_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Normal Font Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_quote',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .icon-content'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .icon-content svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_quote_normal_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Normal Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_quote',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .icon-content',
			'attribute'  => 'margin-bottom',
		);

		$this->options['st_quote_normal_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_quote',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .icon-content',
			'attribute' => 'padding',
		);

		$this->options['st_quote_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_quote',
			'selectors'      => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .icon-content',
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

		$this->options['st_quote_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_quote',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .icon-content',
			'attribute' => 'border-radius',
		);

		$this->options['st_quote_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_quote',
		);

		$this->options['st_quote_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_quote',
		);

		$this->options['st_quote_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_quote',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .icon-content' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_quote_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_quote',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .icon-content'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .icon-content svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_quote_hover_font_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Hover Font Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_quote',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .icon-content'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .icon-content svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_quote_hover_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Hover Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_quote',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .icon-content',
			'attribute'  => 'margin-bottom',
		);

		$this->options['st_quote_hover_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_quote',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .icon-content',
			'attribute' => 'padding',
		);

		$this->options['st_quote_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_quote',
			'selectors'      => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .icon-content:not(.hover-gradient), {{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .icon-content.hover-gradient:before',
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

		$this->options['st_quote_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_quote',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .icon-content',
			'attribute' => 'border-radius',
		);

		$this->options['st_quote_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_quote',
		);

		$this->options['st_quote_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_quote',
		);

		$this->options['st_rating_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_rating',
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
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .rating-stars',
			'attribute'  => 'text-align',
			'dependency' => array(
				'custom' => array(
					'terms' => array(
						array(
							'name'     => 'sg_layout_testimonial_choose',
							'operator' => '!in',
							'value'    => array( 'style-2' ),
						),
					),
				),
			),
		);

		$this->options['st_rating_alignment_style_2'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_rating',
			'options'    => array(
				'flex-start' => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .comment-header',
			'attribute'  => 'justify-content',
			'dependency' => array(
				'custom' => array(
					'terms' => array(
						array(
							'name'     => 'sg_layout_testimonial_choose',
							'operator' => '===',
							'value'    => 'style-2',
						),
					),
				),
			),
		);

		$this->options['st_rating_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_rating',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .rating-stars li'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .rating-stars li svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_rating_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_rating',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .rating-stars li'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .rating-stars li svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_rating_font_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Font Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_rating',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .rating-stars li i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .rating-stars li svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_rating_margin_right'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Items Margin Right', 'jeg-elementor-kit' ),
			'segment'    => 'style_rating',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .rating-stars li:not(:last-child)',
			'attribute'  => 'margin-right',
		);

		$this->options['st_rating_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_rating',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .rating-stars',
			'attribute' => 'margin',
		);

		$this->options['st_client_name_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_name',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-info .profile-name',
			'attribute' => 'margin',
		);

		$this->options['st_client_name_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_client_name',
		);

		$this->options['st_client_name_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_client_name',
		);

		$this->options['st_client_name_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_name',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-info .profile-name',
		);

		$this->options['st_client_name_normal_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Normal Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_name',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-info .profile-name',
		);

		$this->options['st_client_name_normal_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_name',
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
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-info .profile-name',
			'attribute'  => 'text-align',
			'dependency' => array(
				'custom' => array(
					'terms' => array(
						array(
							'name'     => 'sg_layout_testimonial_choose',
							'operator' => '!in',
							'value'    => array( 'style-2' ),
						),
					),
				),
			),
		);

		$this->options['st_client_name_normal_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Normal Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_name',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-info .profile-name',
			'attribute'  => 'margin-bottom',
		);

		$this->options['st_client_name_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_client_name',
		);

		$this->options['st_client_name_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_client_name',
		);

		$this->options['st_client_name_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_name',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .profile-info .profile-name',
		);

		$this->options['st_client_name_hover_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Hover Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_name',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .profile-info .profile-name',
		);

		$this->options['st_client_name_hover_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Hover Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_name',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .profile-info .profile-name',
			'attribute'  => 'margin-bottom',
		);

		$this->options['st_client_name_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_client_name',
		);

		$this->options['st_client_name_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_client_name',
		);

		$this->options['st_client_designation_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_designation',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-info .profile-des',
			'attribute' => 'margin',
		);

		$this->options['st_client_designation_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_client_designation',
		);

		$this->options['st_client_designation_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_client_designation',
		);

		$this->options['st_client_designation_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_designation',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-info .profile-des',
		);

		$this->options['st_client_designation_normal_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Normal Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_designation',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-info .profile-des',
		);

		$this->options['st_client_designation_normal_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_designation',
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
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-info .profile-des',
			'attribute'  => 'text-align',
			'dependency' => array(
				'custom' => array(
					'terms' => array(
						array(
							'name'     => 'sg_layout_testimonial_choose',
							'operator' => '!in',
							'value'    => array( 'style-2' ),
						),
					),
				),
			),
		);

		$this->options['st_client_designation_normal_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Normal Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_designation',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-info .profile-des',
			'attribute'  => 'margin-bottom',
		);

		$this->options['st_client_designation_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_client_designation',
		);

		$this->options['st_client_designation_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_client_designation',
		);

		$this->options['st_client_designation_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_designation',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .profile-info .profile-des',
		);

		$this->options['st_client_designation_hover_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Hover Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_designation',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .profile-info .profile-des',
		);

		$this->options['st_client_designation_hover_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Hover Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_designation',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item:hover .testimonial-box .profile-info .profile-des',
			'attribute'  => 'margin-bottom',
		);

		$this->options['st_client_designation_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_client_designation',
		);

		$this->options['st_client_designation_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_client_designation',
		);

		$this->options['st_client_image_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Client Image', 'jeg-elementor-kit' ),
			'segment' => 'style_client_image',
		);

		$this->options['st_client_image_alignment'] = array(
			'type'        => 'radio',
			'title'       => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'     => 'style_client_image',
			'options'     => array(
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
			'description' => esc_html__( 'The class selector of this option is .comment-bio, so there may be elements that change. You need to change the alignment of the element manually in the available options.', 'jeg-elementor-kit' ),
			'responsive'  => true,
			'selectors'   => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials.style-1 .testimonials-track .testimonial-item .testimonial-box .testimonial-slider .comment-bio' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials.style-3 .testimonials-track .testimonial-item .testimonial-box .comment-bio' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials.style-4 .testimonials-track .testimonial-item .testimonial-box .comment-bio' => 'text-align: {{VALUE}}',
				),
			),
			'dependency'  => array(
				'custom' => array(
					'terms' => array(
						array(
							'name'     => 'sg_layout_testimonial_choose',
							'operator' => '!in',
							'value'    => array( 'style-2' ),
						),
					),
				),
			),
		);

		$this->options['st_client_image_alignment_style_2'] = array(
			'type'        => 'radio',
			'title'       => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'     => 'style_client_image',
			'options'     => array(
				'flex-start'    => array(
					'title' => esc_html__( 'Start', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'        => array(
					'title' => esc_html__( 'Center', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end'      => array(
					'title' => esc_html__( 'End', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-right',
				),
				'space-between' => array(
					'title' => esc_html__( 'Space Beetween', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-arrows-alt-h',
				),
			),
			'responsive'  => true,
			'selectors'   => '.jeg-elementor-kit.jkit-testimonials.style-2 .testimonials-track .testimonial-item .testimonial-box .comment-bio',
			'attribute'   => 'justify-content',
			'description' => esc_html__( 'This option corresponds to the Reverse Position option in the Quote section. If you activate the Reverse Position option, the alignment will be reversed. Changes to the Space Between option will be reflected if a Quote is displayed.', 'jeg-elementor-kit' ),
			'dependency'  => array(
				'custom' => array(
					'terms' => array(
						array(
							'name'     => 'sg_layout_testimonial_choose',
							'operator' => '===',
							'value'    => 'style-2',
						),
					),
				),
			),
		);

		$this->options['st_client_image_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_image',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-image img',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_client_image_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_image',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-image img',
		);

		$this->options['st_client_image_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-image img',
			'attribute' => 'border-radius',
		);

		$this->options['st_client_image_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_image',
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-image img',
		);

		$this->options['st_client_image_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-image img',
			'attribute' => 'margin',
		);

		$this->options['st_client_image_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-image img',
			'attribute' => 'padding',
		);

		$this->options['st_client_image_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_client_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-image img',
			'attribute' => 'border-radius',
		);

		$this->options['st_client_image_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_image',
			'default'    => 60,
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-image img' => 'width: {{SIZE}}px',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-image img.source-url' => 'height: {{SIZE}}px',
				),
			),
		);

		$this->options['st_client_image_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_image',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-image img, {{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .testimonials-track .testimonial-item .testimonial-box .profile-image img.source-url',
			'attribute'  => 'height',
		);

		$this->options['st_client_layout_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Client Layout', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_layout',
			'dependency' => array(
				array(
					'field'    => 'sg_layout_testimonial_choose',
					'operator' => '==',
					'value'    => 'style-1',
				),
			),
		);

		$this->options['st_client_layout_bottom_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Bottom Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_client_layout',
			'default'    => -95,
			'options'    => array(
				'min'  => -1000,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials.style-1 .testimonials-track .testimonial-item .testimonial-box .testimonial-slider .comment-bio',
			'attribute'  => 'bottom',
			'dependency' => array(
				array(
					'field'    => 'sg_layout_testimonial_choose',
					'operator' => '==',
					'value'    => 'style-1',
				),
			),
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button svg' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button span'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_arrow_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_arrow',
			'selectors'      => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button span',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button span',
			),
		);

		$this->options['st_arrow_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button span',
			),
		);

		$this->options['st_arrow_normal_opacity'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Normal Opacity', 'jeg-elementor-kit' ),
			'segment'      => 'style_arrow',
			'default'      => 100,
			'default_unit' => '%',
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive'   => true,
			'units'        => array( '%' ),
			'selectors'    => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button span' => 'opacity: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button span, {{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button i, {{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button svg' => 'transition-duration: {{SIZE}}s;',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button:hover span'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_arrow_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_arrow',
			'selectors'      => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button:hover span:not(.hover-gradient), {{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button span.hover-gradient:before',
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
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button:hover span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button:hover span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button:hover span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button:hover span',
			),
		);

		$this->options['st_arrow_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-controls button:hover span',
			),
		);

		$this->options['st_arrow_hover_opacity'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Hover Opacity', 'jeg-elementor-kit' ),
			'segment'      => 'style_arrow',
			'default'      => 100,
			'default_unit' => '%',
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive'   => true,
			'units'        => array( '%' ),
			'selectors'    => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials:hover .tns-controls button span' => 'opacity: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-testimonials .tns-nav button' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2); margin-right: calc({{SIZE}}{{UNIT}} / 2);',
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
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .tns-nav button',
			'attribute'  => 'margin-top',
			'responsive' => true,
		);

		$this->options['st_dots_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
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
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .tns-nav',
			'attribute'  => 'text-align',
			'default'    => 'center',
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
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .tns-nav button',
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
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .tns-nav button',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_dots_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_dots',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .tns-nav button',
			'attribute' => 'border-radius',
		);

		$this->options['st_dots_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
			'responsive' => true,
			'attribute'  => 'background-color',
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .tns-nav button',
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
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .tns-nav button.tns-nav-active',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_dots_active_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .tns-nav button.tns-nav-active',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_dots_active_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_dots',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-testimonials .tns-nav button.tns-nav-active',
			'attribute' => 'border-radius',
		);

		$this->options['st_dots_active_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_dots',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-testimonials .tns-nav button.tns-nav-active',
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
