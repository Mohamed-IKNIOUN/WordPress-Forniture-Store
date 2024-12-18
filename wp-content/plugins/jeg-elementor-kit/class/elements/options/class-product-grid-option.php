<?php
/**
 * Product Grid Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Product_Grid_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Product_Grid_Option extends Option_WooCommerce_Abstract {
	/**
	 * Default number of post ajax
	 *
	 * @var int
	 */
	protected $number_post_ajax = 4;

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
		return esc_html__( 'JKit - Product Grid', 'jeg-elementor-kit' );
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
		$this->set_element_options();
		$this->set_wc_content_filter_option();
		$this->pagination_option( $this->number_post_ajax );
		$this->set_style_option();

		parent::set_options();
	}

	/**
	 * Option segments
	 */
	public function set_segments() {
		$this->segments['segment_content'] = array(
			'name'     => esc_html__( 'Content Setting', 'jeg-elementor-kit' ),
			'priority' => 5,
		);

		$this->segments['segment_filter'] = array(
			'name'     => esc_html__( 'Content Filter', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_pagination_segment();

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

		$this->segments['style_product_block'] = array(
			'name'      => esc_html__( 'Product Block', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_image'] = array(
			'name'      => esc_html__( 'Image', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_sale'] = array(
			'name'      => esc_html__( 'Sale', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_title'] = array(
			'name'      => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_category'] = array(
			'name'      => esc_html__( 'Category', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		$this->segments['style_amount'] = array(
			'name'      => esc_html__( 'Price', 'jeg-elementor-kit' ),
			'priority'  => 15,
			'kit_style' => true,
		);

		$this->segments['style_rating'] = array(
			'name'      => esc_html__( 'Rating', 'jeg-elementor-kit' ),
			'priority'  => 16,
			'kit_style' => true,
		);

		$this->segments['style_button'] = array(
			'name'      => esc_html__( 'Button', 'jeg-elementor-kit' ),
			'priority'  => 17,
			'kit_style' => true,
		);

		$this->segments['style_sorting'] = array(
			'name'       => esc_html__( 'Sorting', 'jeg-elementor-kit' ),
			'priority'   => 18,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_sorting',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->segments['style_preload'] = array(
			'name'      => esc_html__( 'Preload', 'jeg-elementor-kit' ),
			'priority'  => 18,
			'kit_style' => true,
		);

		$this->segments['style_pagination'] = array(
			'name'       => esc_html__( 'Pagination', 'jeg-elementor-kit' ),
			'priority'   => 19,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'pagination_mode',
					'operator' => 'in',
					'value'    => array( 'loadmore', 'scrollload', 'nextprev' ),
				),
			),
		);

		$this->set_nocontent_style_segment();
		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_content_column'] = array(
			'type'           => 'slider',
			'title'          => esc_html__( 'Column', 'jeg-elementor-kit' ),
			'segment'        => 'segment_content',
			'default'        => 4,
			'tablet_default' => array(
				'size' => 3,
			),
			'mobile_default' => array(
				'size' => 1,
			),
			'options'        => array(
				'min'  => 1,
				'max'  => 10,
				'step' => 1,
			),
			'responsive'     => true,
			'selectors'      => array(
				'custom' => array(
					'{{WRAPPER}} .jkit-product-grid' => '--product-grid-column: {{SIZE}}',
				),
			),
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
				'price'    => esc_html__( 'Price', 'jeg-elementor-kit' ),
				'rating'   => esc_html__( 'Rating', 'jeg-elementor-kit' ),
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

		$this->options['sg_content_sorting'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Sorting', 'jeg-elementor-kit' ),
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
		$this->options['st_wrapper_row_gap'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Row Gap', 'jeg-elementor-kit' ),
			'segment'    => 'style_wrapper',
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-product-grid .jkit-products',
			'attribute'  => 'grid-row-gap',
			'responsive' => true,
		);

		$this->options['st_wrapper_column_gap'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Column Gap', 'jeg-elementor-kit' ),
			'segment'    => 'style_wrapper',
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-product-grid .jkit-products',
			'attribute'  => 'grid-column-gap',
			'responsive' => true,
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
			'selectors' => '.jeg-elementor-kit.jkit-product-grid',
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
			'default'    => 'left',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-products, {{WRAPPER}} .jeg-elementor-kit.jkit-product-carousel .jkit-products .button' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .star-rating' => '--rating-margin-{{VALUE}}: 0',
				),
			),
			'responsive' => true,
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
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product',
		);

		$this->options['st_product_block_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product',
			'attribute' => 'padding',
		);

		$this->options['st_product_block_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product',
			'attribute' => 'border-radius',
		);

		$this->options['st_product_block_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product',
		);

		$this->options['st_product_block_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product',
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

		$this->options['st_product_block_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'background', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product:hover',
		);

		$this->options['st_product_block_hover_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product:hover',
			'attribute' => 'padding',
		);

		$this->options['st_product_block_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_product_block_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product:hover',
		);

		$this->options['st_product_block_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_block',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product:hover',
		);

		$this->options['st_product_block_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_product_block',
		);

		$this->options['st_product_block_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_product_block',
		);

		$this->options['st_image_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-image',
			'attribute' => 'margin',
		);

		$this->options['st_image_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-image',
			'attribute' => 'padding',
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

		$this->options['st_image_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-image',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_image_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-image',
			'attribute' => 'border-radius',
		);

		$this->options['st_image_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-image',
		);

		$this->options['st_image_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-image',
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

		$this->options['st_image_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-link:hover .product-image',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_image_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-link:hover .product-image',
			'attribute' => 'border-radius',
		);

		$this->options['st_image_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-link:hover .product-image',
		);

		$this->options['st_image_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-link:hover .product-image',
		);

		$this->options['st_image_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_image',
		);

		$this->options['st_image_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_image',
		);

		$this->options['st_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-title',
		);

		$this->options['st_title_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-title',
		);

		$this->options['st_title_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-title',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_title_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-title',
			'attribute' => 'margin',
		);

		$this->options['st_title_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-title',
			'attribute' => 'padding',
		);

		$this->options['st_title_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-title',
			'attribute' => 'border-radius',
		);

		$this->options['st_title_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-title',
		);

		$this->options['st_title_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-title',
		);

		$this->options['st_title_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-title',
		);

		$this->options['st_category_inline_background'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Inline Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'default'   => '',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .product-categories' => '-webkit-box-decoration-break: clone; box-decoration-break: clone; display: inline;',
				),
			),
		);

		$this->options['st_category_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-categories a',
		);

		$this->options['st_category_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-categories a',
		);

		$this->options['st_category_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-categories',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_category_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-categories',
			'attribute' => 'margin',
		);

		$this->options['st_category_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-categories',
			'attribute' => 'padding',
		);

		$this->options['st_category_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-categories',
			'attribute' => 'border-radius',
		);

		$this->options['st_category_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-categories',
		);

		$this->options['st_category_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-categories',
		);

		$this->options['st_category_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-categories',
		);

		$this->options['st_amount_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_amount',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .price',
		);

		$this->options['st_amount_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_amount',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .price',
		);

		$this->options['st_amount_second_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Second Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_amount',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .price del',
		);

		$this->options['st_amount_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_amount',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .price',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_amount_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_amount',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .price',
			'attribute' => 'margin',
		);

		$this->options['st_amount_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_amount',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .price',
			'attribute' => 'padding',
		);

		$this->options['st_amount_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_amount',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .price',
			'attribute' => 'border-radius',
		);

		$this->options['st_amount_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_amount',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .price',
		);

		$this->options['st_amount_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_amount',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .price',
		);

		$this->options['st_amount_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_amount',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .price',
		);

		$this->options['st_sale_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_sale',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.onsale',
			'attribute'  => 'width',
		);

		$this->options['st_sale_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( ' Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_sale',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.onsale' => 'height: {{SIZE}}{{UNIT}}; --jkit-onsale-height: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_sale_horizontal_orientation'] = array(
			'type'    => 'radio',
			'title'   => esc_html__( 'Horizontal Orientation', 'jeg-elementor-kit' ),
			'segment' => 'style_sale',
			'options' => array(
				'left'  => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-left',
				),
				'right' => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-h-align-right',
				),
			),
			'default' => 'right',
			'toggle'  => false,
		);

		$this->options['st_sale_horizontal_offset'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Offset', 'jeg-elementor-kit' ),
			'segment'    => 'style_sale',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 8,
			'selectors'  => array(
				'custom' => array( '{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.onsale' => '{{st_sale_horizontal_orientation.VALUE}}: {{SIZE}}{{UNIT}};' ),
			),
		);

		$this->options['st_sale_vertical_orientation'] = array(
			'type'    => 'radio',
			'title'   => esc_html__( 'Vertical Orientation', 'jeg-elementor-kit' ),
			'segment' => 'style_sale',
			'options' => array(
				'top'    => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-top',
				),
				'bottom' => array(
					'title' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-bottom',
				),
			),
			'default' => 'top',
			'toggle'  => false,
		);

		$this->options['st_sale_vertical_offset'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Offset', 'jeg-elementor-kit' ),
			'segment'    => 'style_sale',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 9,
			'selectors'  => array(
				'custom' => array( '{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.onsale' => '{{st_sale_vertical_orientation.VALUE}}: {{SIZE}}{{UNIT}};' ),
			),
		);

		$this->options['st_sale_gap_offset'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Gap', 'jeg-elementor-kit' ),
			'segment'    => 'style_sale',
			'responsive' => true,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 5,
			'selectors'  => array(
				'custom' => array( '{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.onsale' => '--jkit-onsale-gap: {{SIZE}}px' ),
			),
		);

		$this->options['st_sale_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_sale',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.onsale',
		);

		$this->options['st_sale_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Sale Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_sale',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.text',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
			'separator' => 'before',
		);

		$this->options['st_sale_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Sale Badge Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_sale',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.text',
		);

		$this->options['st_percentage_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Percentage Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_sale',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.percent',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
			'separator' => 'before',
		);

		$this->options['st_percentage_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Percentage Badge Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_sale',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.percent',
		);

		$this->options['st_sale_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_sale',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.onsale',
			'attribute' => 'margin',
			'separator' => 'before',
		);

		$this->options['st_sale_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_sale',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.onsale',
			'attribute' => 'padding',
		);

		$this->options['st_sale_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_sale',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.onsale',
			'attribute' => 'border-radius',
		);

		$this->options['st_sale_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_sale',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.onsale',
		);

		$this->options['st_sale_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_sale',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .woocommerce ul.products li.product .product-link span.onsale',
		);

		$this->options['st_rating_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Star Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_rating',
			'default'    => 13,
			'options'    => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-product-grid .star-rating',
			'attribute'  => 'font-size',
		);

		$this->options['st_rating_margin'] = array(
			'type'               => 'dimension',
			'title'              => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'            => 'style_rating',
			'units'              => array( 'px', '%', 'em' ),
			'allowed_dimensions' => 'vertical',
			'selectors'          => '.jeg-elementor-kit.jkit-product-grid .star-rating',
			'attribute'          => 'margin',
		);

		$this->options['st_rating_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_rating',
		);

		$this->options['st_rating_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_rating',
		);

		$this->options['st_rating_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_rating',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .star-rating',
		);

		$this->options['st_rating_border_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Border Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_rating',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .star-rating::before',
		);

		$this->options['st_rating_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_rating',
		);

		$this->options['st_rating_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_rating',
		);

		$this->options['st_rating_hover_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_rating',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-product:hover .star-rating',
		);

		$this->options['st_rating_hover_border_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Border Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_rating',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-product:hover .star-rating:before',
		);

		$this->options['st_rating_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_rating',
		);

		$this->options['st_rating_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_rating',
		);

		$this->options['st_button_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button',
			'attribute' => 'margin',
		);

		$this->options['st_button_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button',
			'attribute' => 'padding',
		);

		$this->options['st_button_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button',
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
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button',
		);

		$this->options['st_button_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_button_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button',
			'attribute' => 'border-radius',
		);

		$this->options['st_button_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button',
		);

		$this->options['st_button_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button',
		);

		$this->options['st_button_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button',
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

		$this->options['st_button_hover_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button:hover',
		);

		$this->options['st_button_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_button_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_button_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button:hover',
		);

		$this->options['st_button_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button:hover',
		);

		$this->options['st_button_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product .button:hover',
		);

		$this->options['st_button_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_button',
		);

		$this->options['st_button_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_button',
		);

		$this->options['st_sorting_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_sorting',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-order',
			'attribute' => 'margin',
		);

		$this->options['st_sorting_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_sorting',
			'units'     => array( 'px', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .product-order .orderby' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .product-order::before' => 'top: {{TOP}}{{UNIT}};',
				),
			),
		);

		$this->options['st_sorting_float'] = array(
			'type'      => 'select',
			'title'     => esc_html__( 'Float', 'jeg-elementor-kit' ),
			'segment'   => 'style_sorting',
			'default'   => 'right',
			'options'   => array(
				'left'  => esc_html__( 'Left', 'jeg-elementor-kit' ),
				'right' => esc_html__( 'Right', 'jeg-elementor-kit' ),
			),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-order',
			'attribute' => 'float',
		);

		$this->options['st_sorting_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_sorting',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-order .orderby',
		);

		$this->options['st_sorting_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Font Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_sorting',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-order .orderby',
		);

		$this->options['st_sorting_icon_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Icon Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_sorting',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-order::before',
		);

		$this->options['st_sorting_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_sorting',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-order .orderby',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_sorting_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_sorting',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-order .orderby',
			'attribute' => 'border-radius',
		);

		$this->options['st_sorting_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_sorting',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .product-order .orderby',
		);

		$this->options['st_preload_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_preload',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-preloader-overlay',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_preload_dot_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Dots Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_preload',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-preloader-overlay span',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
			'separator' => 'before',
		);

		$this->options['st_pagination_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination',
			'attribute' => 'margin',
		);

		$this->options['st_pagination_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
			'attribute' => 'padding',
		);

		$this->options['st_pagination_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_pagination',
			'selectors'  => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button a',
			'dependency' => array(
				'custom' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'terms' => array(
								array(
									'name'     => 'pagination_mode',
									'operator' => '==',
									'value'    => 'nextprev',
								),
								array(
									'name'     => 'pagination_button_display',
									'operator' => '!==',
									'value'    => 'icon',
								),
							),
						),
						array(
							'terms' => array(
								array(
									'name'     => 'pagination_mode',
									'operator' => 'in',
									'value'    => array( 'loadmore', 'scrollload' ),
								),
							),
						),
					),
				),
			),
		);

		$this->options['st_pagination_width'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'      => 'style_pagination',
			'default'      => 100,
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'units'        => array( '%', 'px', 'em' ),
			'default_unit' => '%',
			'responsive'   => true,
			'selectors'    => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button',
			'attribute'    => 'width',
			'dependency'   => array(
				array(
					'field'    => 'pagination_mode!',
					'operator' => '==',
					'value'    => 'nextprev',
				),
			),
		);

		$this->options['st_pagination_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_pagination',
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.icon-position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.icon-position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'pagination_mode!',
					'operator' => '==',
					'value'    => 'nextprev',
				),
			),
		);

		$this->options['st_pagination_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_pagination',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'units'      => array( 'px', 'em' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				'custom' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'terms' => array(
								array(
									'name'     => 'pagination_mode',
									'operator' => '==',
									'value'    => 'nextprev',
								),
								array(
									'name'     => 'pagination_button_display',
									'operator' => '==',
									'value'    => 'icon',
								),
							),
						),
						array(
							'terms' => array(
								array(
									'name'     => 'pagination_mode',
									'operator' => 'in',
									'value'    => array( 'loadmore', 'scrollload' ),
								),
							),
						),
					),
				),
			),
		);

		$this->options['st_pagination_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_pagination',
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
			'selectors'  => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination',
			'attribute'  => 'text-align',
			'dependency' => array(
				'custom' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'terms' => array(
								array(
									'name'     => 'pagination_mode',
									'operator' => '==',
									'value'    => 'nextprev',
								),
								array(
									'name'     => 'pagination_style',
									'operator' => '!==',
									'value'    => 'edge',
								),
							),
						),
						array(
							'terms' => array(
								array(
									'name'     => 'pagination_mode',
									'operator' => 'in',
									'value'    => array( 'loadmore', 'scrollload' ),
								),
							),
						),
					),
				),
			),
		);

		$this->options['st_pagination_button_gap'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Gap', 'jeg-elementor-kit' ),
			'segment'      => 'style_pagination',
			'units'        => array( 'px', 'em' ),
			'default_unit' => 'px',
			'options'      => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive'   => true,
			'selectors'    => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-nextprev-normal' => 'display: inline-flex; gap: {{SIZE}}{{UNIT}}',
				),
			),
			'dependency'   => array(
				'custom' => array(
					'relation' => 'and',
					'terms'    => array(
						array(
							'name'     => 'pagination_mode',
							'operator' => '==',
							'value'    => 'nextprev',
						),
						array(
							'name'     => 'pagination_style',
							'operator' => '!==',
							'value'    => 'edge',
						),
					),
				),
			),
		);

		$this->options['st_pagination_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_pagination',
		);

		$this->options['st_pagination_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_pagination',
		);
		$this->options['st_pagination_normal_color']     = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_pagination',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button, {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_pagination_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_pagination_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
			'attribute' => 'border-radius',
		);

		$this->options['st_pagination_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
		);

		$this->options['st_pagination_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
		);

		$this->options['st_pagination_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_pagination',
		);

		$this->options['st_pagination_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_pagination',
		);

		$this->options['st_pagination_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_pagination',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev) a, {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev) svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_pagination_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_pagination_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)',
			'attribute' => 'border-radius',
		);

		$this->options['st_pagination_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)',
		);

		$this->options['st_pagination_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)',
		);

		$this->options['st_pagination_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_pagination',
		);

		$this->options['st_pagination_disabled_tab_start'] = array(
			'type'       => 'control_tab_start',
			'title'      => esc_html__( 'Disabled', 'jeg-elementor-kit' ),
			'segment'    => 'style_pagination',
			'dependency' => array(
				array(
					'field'    => 'pagination_mode',
					'operator' => '==',
					'value'    => 'nextprev',
				),
			),
		);

		$this->options['st_pagination_disabled_opacity'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Opacity', 'jeg-elementor-kit' ),
			'segment'      => 'style_pagination',
			'units'        => array( '%' ),
			'default_unit' => '%',
			'default'      => 50,
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'    => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
			'attribute'    => 'opacity',
		);

		$this->options['st_pagination_disabled_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_pagination',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_pagination_disabled_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_pagination_disabled_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
			'attribute' => 'border-radius',
		);

		$this->options['st_pagination_disabled_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
		);

		$this->options['st_pagination_disabled_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-product-grid .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
		);

		$this->options['st_pagination_disabled_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_pagination',
		);

		$this->options['st_pagination_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_pagination',
		);

		$this->nocontent_style();
		parent::additional_style();
	}
}
