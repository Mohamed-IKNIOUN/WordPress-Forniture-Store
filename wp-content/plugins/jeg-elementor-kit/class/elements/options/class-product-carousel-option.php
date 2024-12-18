<?php
/**
 * Product Carousel Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Product_Carousel_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Product_Carousel_Option extends Option_WooCommerce_Abstract {
	/**
	 * Default number of post ajax
	 *
	 * @var int
	 */
	protected $number_post_ajax = 4;

	/**
	 * Default widget selector
	 *
	 * @var string
	 */
	protected $widget_selector = 'jkit-product-carousel';

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
	public function set_compatible_column_option() {}

	/**
	 * Element name
	 *
	 * @return string
	 */
	public function get_element_name() {
		return esc_html__( 'JKit - Product Carousel', 'jeg-elementor-kit' );
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
		// $this->set_content_filter_segment();
		$this->set_style_option();
		$this->set_element_options();

		$this->set_wc_content_filter_option();

		parent::set_options();
	}

	/**
	 * Option segments
	 */
	public function set_segments() {
		$this->segments['segment_carousel'] = array(
			'name'     => esc_html__( 'Carousel Setting', 'jeg-elementor-kit' ),
			'priority' => 5,
		);

		$this->segments['segment_content'] = array(
			'name'     => esc_html__( 'Content Setting', 'jeg-elementor-kit' ),
			'priority' => 6,
		);

		$this->segments['segment_filter'] = array(
			'name'     => esc_html__( 'Content Filter', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_wrapper'] = array(
			'name'      => esc_html__( 'Wrapper', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_carousel_arrow'] = array(
			'name'      => esc_html__( 'Carousel Arrow', 'jeg-elementor-kit' ),
			'priority'  => 20,
			'kit_style' => true,
		);

		$this->segments['style_carousel_dots'] = array(
			'name'      => esc_html__( 'Carousel Dots', 'jeg-elementor-kit' ),
			'priority'  => 21,
			'kit_style' => true,
		);

		$this->set_product_block_style_segment();
		$this->set_nocontent_style_segment();
		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_carousel_margin'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Spacing Horizontal', 'jeg-elementor-kit' ),
			'segment'    => 'segment_carousel',
			'default'    => 31,
			'options'    => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'responsive' => true,
		);

		$this->options['sg_carousel_slide_show'] = array(
			'type'           => 'slider',
			'title'          => esc_html__( 'Slide to Show', 'jeg-elementor-kit' ),
			'segment'        => 'segment_carousel',
			'default'        => 4,
			'tablet_default' => array(
				'size' => 3,
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

		$this->options['sg_carousel_autoplay'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Autoplay', 'jeg-elementor-kit' ),
			'segment' => 'segment_carousel',
		);

		$this->options['sg_carousel_autoplay_speed'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Speed (ms)', 'jeg-elementor-kit' ),
			'segment'    => 'segment_carousel',
			'default'    => 3500,
			'options'    => array(
				'min'  => 1000,
				'max'  => 15000,
				'step' => 100,
			),
			'dependency' => array(
				array(
					'field'    => 'sg_carouselsetting_autoplay',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_carousel_autoplay_pause'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Pause on Hover', 'jeg-elementor-kit' ),
			'segment'    => 'segment_carousel',
			'dependency' => array(
				array(
					'field'    => 'sg_carousel_autoplay',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_carousel_arrow'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Arrow', 'jeg-elementor-kit' ),
			'segment' => 'segment_carousel',
			'default' => true,
		);

		$this->options['sg_carousel_arrow_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Position', 'jeg-elementor-kit' ),
			'segment'    => 'segment_carousel',
			'options'    => array(
				'bottom-middle' => esc_html__( 'Bottom Middle', 'jeg-elementor-kit' ),
				'bottom-edge'   => esc_html__( 'Bottom Edge', 'jeg-elementor-kit' ),
				'middle-edge'   => esc_html__( 'Middle Edge', 'jeg-elementor-kit' ),
				'top-left'      => esc_html__( 'Top Left', 'jeg-elementor-kit' ),
				'top-right'     => esc_html__( 'Top Right', 'jeg-elementor-kit' ),
			),
			'default'    => 'middle-edge',
			'dependency' => array(
				array(
					'field'    => 'sg_carousel_arrow',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_carousel_arrow_left'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Arrow Left', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'jki jki-angle-left-solid',
				'library' => 'jkiticon',
			),
			'segment'    => 'segment_carousel',
			'dependency' => array(
				array(
					'field'    => 'sg_carousel_arrow',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_carousel_arrow_right'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Arrow Right', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'jki jki-angle-right-solid',
				'library' => 'jkiticon',
			),
			'segment'    => 'segment_carousel',
			'dependency' => array(
				array(
					'field'    => 'sg_carousel_arrow',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_carousel_dots'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Dots', 'jeg-elementor-kit' ),
			'segment' => 'segment_carousel',
			'default' => true,
		);

		$this->options['sg_content_show_element'] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'title'       => esc_html__( 'Element Order', 'jeg-elementor-kit' ),
			'segment'     => 'segment_content',
			'ajax'        => true,
			'options'     => array(
				'image'    => esc_html__( 'Image', 'jeg-elementor-kit' ),
				'category' => esc_html__( 'Category', 'jeg-elementor-kit' ),
				'title'    => esc_html__( 'Title', 'jeg-elementor-kit' ),
				'rating'   => esc_html__( 'Rating', 'jeg-elementor-kit' ),
				'price'    => esc_html__( 'Price', 'jeg-elementor-kit' ),
			),
			'default'     => 'image,category,title,price,rating',
			'label_block' => true,
			'description' => esc_html__( 'Arrange the element order. You also can add and remove a certain element.', 'jeg-elementor-kit' ),
		);

		$this->options['sg_content_show_button'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Button', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
			'default' => true,
		);

		$this->options['sg_content_image_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Product Image', 'jeg-elementor-kit' ),
			'segment'   => 'segment_content',
			'separator' => 'before',
		);

		$this->options['sg_content_image_size'] = array(
			'type'        => 'imagesize',
			'title'       => esc_html__( 'Product Image Size', 'jeg-elementor-kit' ),
			'segment'     => 'segment_content',
			'label_block' => true,
		);

		$this->options['sg_content_sale'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Sale', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
			'default' => true,
		);

		$this->options['sg_content_percentage'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Sale Percentage', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
			'default' => true,
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_wrapper_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel',
			'attribute' => 'margin',
		);

		$this->options['st_wrapper_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel',
			'attribute' => 'padding',
		);

		$this->options['st_wrapper_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel',
		);

		$this->options['st_product_block_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_product_block',
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
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .jkit-products, {{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .jkit-products .button' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .star-rating' => '--rating-margin-{{VALUE}}: 0',
				),
			),
		);

		$this->options['st_product_block_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_product_block',
		);

		$this->options['st_product_block_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_product_block',
		);

		$this->options['st_product_block_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .jkit-product-block .jkit-product-block-wrapper',
		);

		$this->options['st_product_block_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .jkit-product-block .jkit-product-block-wrapper',
			'attribute' => 'margin',
		);

		$this->options['st_product_block_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .jkit-product-block .jkit-product-block-wrapper',
			'attribute' => 'padding',
		);

		$this->options['st_product_block_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .jkit-product-block .jkit-product-block-wrapper',
			'attribute' => 'border-radius',
		);

		$this->options['st_product_block_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .jkit-product-block .jkit-product-block-wrapper',
		);

		$this->options['st_product_block_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .jkit-product-block .jkit-product-block-wrapper',
		);

		$this->options['st_product_block_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_product_block',
		);

		$this->options['st_product_block_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_product_block',
		);

		$this->options['st_product_block_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .jkit-product-block .jkit-product-block-wrapper' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_product_block_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .jkit-product-block:hover .jkit-product-block-wrapper',
		);

		$this->options['st_product_block_hover_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .jkit-product-block:hover .jkit-product-block-wrapper',
			'attribute' => 'margin',
		);

		$this->options['st_product_block_hover_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .jkit-product-block:hover .jkit-product-block-wrapper',
			'attribute' => 'padding',
		);

		$this->options['st_product_block_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .jkit-product-block:hover .jkit-product-block-wrapper',
			'attribute' => 'border-radius',
		);

		$this->options['st_product_block_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .jkit-product-block:hover .jkit-product-block-wrapper',
		);

		$this->options['st_product_block_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .jkit-product-block:hover .jkit-product-block-wrapper',
		);

		$this->options['st_product_block_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_product_block',
		);

		$this->options['st_product_block_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_product_block',
		);

		$this->options['st_arrow_font_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Font Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_carousel_arrow',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 30,
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_normal_left_arrow_offset'] = array(
			'type'           => 'slider',
			'title'          => esc_html__( 'Left Arrow', 'jeg-elementor-kit' ),
			'segment'        => 'style_carousel_arrow',
			'responsive'     => true,
			'units'          => array( 'px', '%', 'em' ),
			'options'        => array(
				'min'  => -200,
				'max'  => 200,
				'step' => 1,
			),
			'default'        => -96,
			'laptop_default' => array(
				'size' => 0,
			),
			'tablet_default' => array(
				'size' => 0,
			),
			'selectors'      => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button[data-controls=prev]' => 'left: {{SIZE}}{{UNIT}}',
				),
			),
			'separator'      => 'before',
		);

		$this->options['st_arrow_normal_right_arrow_offset'] = array(
			'type'           => 'slider',
			'title'          => esc_html__( 'Right Arrow', 'jeg-elementor-kit' ),
			'segment'        => 'style_carousel_arrow',
			'responsive'     => true,
			'units'          => array( 'px', '%', 'em' ),
			'options'        => array(
				'min'  => -200,
				'max'  => 200,
				'step' => 1,
			),
			'default'        => -96,
			'laptop_default' => array(
				'size' => 0,
			),
			'tablet_default' => array(
				'size' => 0,
			),
			'selectors'      => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button[data-controls=next]' => 'right: {{SIZE}}{{UNIT}}',
				),
			),
		);

		$this->options['st_arrow_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_carousel_arrow',
		);

		$this->options['st_arrow_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_carousel_arrow',
		);

		$this->options['st_arrow_normal_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_arrow_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button',
			),
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_arrow_normal_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
			'separator' => 'before',
		);

		$this->options['st_arrow_normal_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button',
			),
		);

		$this->options['st_arrow_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button',
			),
		);

		$this->options['st_arrow_normal_opacity'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Normal Opacity', 'jeg-elementor-kit' ),
			'segment'      => 'style_carousel_arrow',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button' => 'opacity: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_carousel_arrow',
		);

		$this->options['st_arrow_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_carousel_arrow',
		);

		$this->options['st_arrow_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_arrow_hover_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button i:hover'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button svg:hover' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_arrow_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button:hover',
			),
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_arrow_hover_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_hover_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button:hover',
			),
		);

		$this->options['st_arrow_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_arrow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-controls button:hover',
			),
		);

		$this->options['st_arrow_hover_opacity'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Hover Opacity', 'jeg-elementor-kit' ),
			'segment'      => 'style_carousel_arrow',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel:hover .tns-controls button' => 'opacity: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_arrow_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_carousel_arrow',
		);

		$this->options['st_arrow_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_carousel_arrow',
		);

		$this->options['st_dots_spacing_horizontal'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Spacing Horizontal', 'jeg-elementor-kit' ),
			'segment'    => 'style_carousel_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .tns-nav button' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2); margin-right: calc({{SIZE}}{{UNIT}} / 2);',
				),
			),
			'responsive' => true,
		);

		$this->options['st_dots_spacing_vertical'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Spacing Vertical', 'jeg-elementor-kit' ),
			'segment'    => 'style_carousel_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-product-carousel .tns-nav button',
			'attribute'  => 'margin-top',
			'responsive' => true,
		);

		$this->options['st_dots_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_carousel_dots',
		);

		$this->options['st_dots_general_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'General', 'jeg-elementor-kit' ),
			'segment' => 'style_carousel_dots',
		);

		$this->options['st_dots_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_carousel_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-product-carousel .tns-nav button',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_dots_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_carousel_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-product-carousel .tns-nav button',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_dots_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_dots',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .tns-nav button',
			'attribute' => 'border-radius',
		);

		$this->options['st_dots_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_dots',
			'attribute' => 'background-color',
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .tns-nav button',
		);

		$this->options['st_dots_general_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_carousel_dots',
		);

		$this->options['st_dots_active_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Active', 'jeg-elementor-kit' ),
			'segment' => 'style_carousel_dots',
		);

		$this->options['st_dots_active_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_carousel_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-product-carousel .tns-nav button.tns-nav-active',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_dots_active_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_carousel_dots',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-product-carousel .tns-nav button.tns-nav-active',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_dots_active_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_dots',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .tns-nav button.tns-nav-active',
			'attribute' => 'border-radius',
		);

		$this->options['st_dots_active_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_carousel_dots',
			'selectors' => '.jeg-elementor-kit.jkit-product-carousel .tns-nav button.tns-nav-active',
			'attribute' => 'background-color',
		);

		$this->options['st_dots_active_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_carousel_dots',
		);

		$this->options['st_dots_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_carousel_dots',
		);

		$this->set_product_block_style_option( $this->widget_selector );
		parent::additional_style();
	}
}
