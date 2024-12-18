<?php
/**
 * Elements Option WooCommerce Abstract Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Option_WooCommerce_Abstract
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Option_WooCommerce_Abstract extends Option_Abstract {
	/**
	 * Set WooCommerce content filter option
	 *
	 * @param int  $number Default number of element.
	 * @param bool $hide_number_post Hide number of post flag if we don't allow user to change number directly.
	 */
	public function set_wc_content_filter_option( $number = 8, $hide_number_post = false ) {
		$dependency = array(
			'field'    => 'sort_by',
			'operator' => 'in',
			'value'    => array(
				'post_type',
				'latest',
				'oldest',
				'alphabet_asc',
				'alphabet_desc',
				'random',
				'random_week',
				'random_month',
				'most_comment',
				'most_comment_day',
				'most_comment_week',
				'most_comment_month',
				'popular_post_day',
				'popular_post_week',
				'popular_post_month',
				'popular_post',
				'rate',
				'like',
				'share',
			),
		);

		if ( ! $hide_number_post ) {
			$this->options['number_post'] = array(
				'type'        => 'slider',
				'title'       => esc_html__( 'Number of Product', 'jeg-elementor-kit' ),
				'description' => esc_html__( 'Show number of product for this element.', 'jeg-elementor-kit' ),
				'segment'     => 'segment_filter',
				'options'     => array(
					'min'  => 1,
					'max'  => 50,
					'step' => 1,
				),
				'default'     => $number,
			);
		}

		$this->options['post_offset'] = array(
			'type'        => 'number',
			'title'       => esc_html__( 'Product Offset', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Number of product offset (start of content).', 'jeg-elementor-kit' ),
			'segment'     => 'segment_filter',
			'options'     => array(
				'min'  => 0,
				'max'  => PHP_INT_MAX,
				'step' => 1,
			),
			'default'     => 0,
			'dependency'  => array(
				$dependency,
			),
		);

		$this->options['wc_include_post'] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_cpt',
			'options'     => 'jeg_get_cpt_option',
			'nonce'       => wp_create_nonce( 'jeg_find_cpt' ),
			'slug'        => 'product',
			'title'       => esc_html__( 'Include Product ID', 'jeg-elementor-kit' ),
			'description' => wp_kses( __( 'Tips :<br/> - You can search product id by inputing the product title, clicking search title, and you will have your product id.<br/>- You can also directly insert your product id, and click enter to add it on the list.', 'jeg-elementor-kit' ), wp_kses_allowed_html() ),
			'segment'     => 'segment_filter',
			'default'     => '',
			'label_block' => true,
			'dependency'  => array(
				$dependency,
			),
		);

		$this->options['wc_exclude_post'] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_cpt',
			'options'     => 'jeg_get_cpt_option',
			'nonce'       => wp_create_nonce( 'jeg_find_cpt' ),
			'slug'        => 'product',
			'title'       => esc_html__( 'Exclude Product ID', 'jeg-elementor-kit' ),
			'description' => wp_kses( __( 'Tips :<br/> - You can search product id by inputing title, clicking search title, and you will have your product id.<br/>- You can also directly insert your product id, and click enter to add it on the list.', 'jeg-elementor-kit' ), wp_kses_allowed_html() ),
			'segment'     => 'segment_filter',
			'default'     => '',
			'label_block' => true,
			'dependency'  => array(
				$dependency,
			),
		);

		$this->options['wc_include_category'] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_custom_term',
			'options'     => 'jeg_get_custom_term_option',
			'nonce'       => wp_create_nonce( 'jeg_find_custom_term' ),
			'slug'        => 'product_cat',
			'title'       => esc_html__( 'Include Product Category', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Choose which product category you want to show on this element.', 'jeg-elementor-kit' ),
			'segment'     => 'segment_filter',
			'default'     => '',
			'label_block' => true,
		);

		$this->options['wc_exclude_category'] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_custom_term',
			'options'     => 'jeg_get_custom_term_option',
			'nonce'       => wp_create_nonce( 'jeg_find_custom_term' ),
			'slug'        => 'product_cat',
			'title'       => esc_html__( 'Exclude Product Category', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Choose excluded product category for this element.', 'jeg-elementor-kit' ),
			'segment'     => 'segment_filter',
			'default'     => '',
			'label_block' => true,
		);

		$this->options['wc_include_tag'] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_custom_term',
			'options'     => 'jeg_get_custom_term_option',
			'nonce'       => wp_create_nonce( 'jeg_find_custom_term' ),
			'slug'        => 'product_tag',
			'title'       => esc_html__( 'Include Tags', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Write to search product tag.', 'jeg-elementor-kit' ),
			'segment'     => 'segment_filter',
			'default'     => '',
			'label_block' => true,
		);

		$this->options['wc_exclude_tag'] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_custom_term',
			'options'     => 'jeg_get_custom_term_option',
			'nonce'       => wp_create_nonce( 'jeg_find_custom_term' ),
			'slug'        => 'product_tag',
			'title'       => esc_html__( 'Exclude Tags', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Write to search product tag.', 'jeg-elementor-kit' ),
			'segment'     => 'segment_filter',
			'default'     => '',
			'label_block' => true,
		);

		$this->options['sort_by'] = array(
			'type'        => 'select',
			'title'       => esc_html__( 'Sort By', 'jeg-elementor-kit' ),
			'description' => wp_kses( __( 'Sort product by this option.', 'jeg-elementor-kit' ), wp_kses_allowed_html() ),
			'segment'     => 'segment_filter',
			'default'     => 'latest',
			'options'     => array(
				'latest'        => esc_html__( 'Latest Product', 'jeg-elementor-kit' ),
				'oldest'        => esc_html__( 'Oldest Product', 'jeg-elementor-kit' ),
				'alphabet_asc'  => esc_html__( 'Alphabet Asc', 'jeg-elementor-kit' ),
				'alphabet_desc' => esc_html__( 'Alphabet Desc', 'jeg-elementor-kit' ),
				'random'        => esc_html__( 'Random Product', 'jeg-elementor-kit' ),
				'random_week'   => esc_html__( 'Random Product (7 Days)', 'jeg-elementor-kit' ),
				'random_month'  => esc_html__( 'Random Product (30 Days)', 'jeg-elementor-kit' ),
				'popularity'    => esc_html__( 'Popular Product', 'jeg-elementor-kit' ),
				'rating'        => esc_html__( 'Rating Product', 'jeg-elementor-kit' ),
			),
			'label_block' => true,
		);
	}

	/**
	 * Set WooCommerce product block style segment
	 */
	public function set_product_block_style_segment() {
		$this->segments['style_product_block'] = array(
			'name'      => esc_html__( 'Product Block', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_product_image'] = array(
			'name'      => esc_html__( 'Product Image', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_product_title'] = array(
			'name'      => esc_html__( 'Product Title', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_product_category'] = array(
			'name'      => esc_html__( 'Product Category', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		$this->segments['style_product_amount'] = array(
			'name'      => esc_html__( 'Product Amount', 'jeg-elementor-kit' ),
			'priority'  => 15,
			'kit_style' => true,
		);

		$this->segments['style_product_sale'] = array(
			'name'      => esc_html__( 'Product Sale', 'jeg-elementor-kit' ),
			'priority'  => 16,
			'kit_style' => true,
		);

		$this->segments['style_product_rating'] = array(
			'name'      => esc_html__( 'Product Rating', 'jeg-elementor-kit' ),
			'priority'  => 17,
			'kit_style' => true,
		);

		$this->segments['style_product_button'] = array(
			'name'      => esc_html__( 'Product Button', 'jeg-elementor-kit' ),
			'priority'  => 18,
			'kit_style' => true,
		);
	}

	/**
	 * Set WooCommerce product block style option
	 *
	 * @param string $widget_name Widget name for class selector.
	 */
	public function set_product_block_style_option( $widget_name ) {
		$this->options['st_product_image_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-image',
			'attribute' => 'margin',
		);

		$this->options['st_product_image_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-image',
			'attribute' => 'padding',
		);

		$this->options['st_product_image_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_product_image',
		);

		$this->options['st_product_image_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_product_image',
		);

		$this->options['st_product_image_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_image',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-image',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_product_image_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-image',
			'attribute' => 'border-radius',
		);

		$this->options['st_product_image_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_image',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-image',
		);

		$this->options['st_product_image_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_image',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-image',
		);

		$this->options['st_product_image_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_product_image',
		);

		$this->options['st_product_image_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_product_image',
		);

		$this->options['st_product_image_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_image',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-image-block:hover .jkit-product-image',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_product_image_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-image-block:hover .jkit-product-image',
			'attribute' => 'border-radius',
		);

		$this->options['st_product_image_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_image',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-image-block:hover .jkit-product-image',
		);

		$this->options['st_product_image_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_image',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-image-block:hover .jkit-product-image',
		);

		$this->options['st_product_image_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_product_image',
		);

		$this->options['st_product_image_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_product_image',
		);

		$this->options['st_product_title_inline_background'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Inline Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_title',
			'default'   => '',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.' . $widget_name . ' .product-title' => '-webkit-box-decoration-break: clone; box-decoration-break: clone; display: inline;',
				),
			),
		);

		$this->options['st_product_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_title',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product-title',
		);

		$this->options['st_product_title_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_title',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product-title',
		);

		$this->options['st_product_title_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_title',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product-title',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_product_title_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product-title',
			'attribute' => 'margin',
		);

		$this->options['st_product_title_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product-title',
			'attribute' => 'padding',
		);

		$this->options['st_product_title_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product-title',
			'attribute' => 'border-radius',
		);

		$this->options['st_product_title_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_title',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product-title',
		);

		$this->options['st_product_title_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_title',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product-title',
		);

		$this->options['st_product_title_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_title',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product-title',
		);

		$this->options['st_product_category_inline_background'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Inline Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_category',
			'default'   => '',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.' . $widget_name . ' .jkit-product-categories' => '-webkit-box-decoration-break: clone; box-decoration-break: clone; display: inline;',
				),
			),
		);

		$this->options['st_product_category_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_category',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-categories',
		);

		$this->options['st_product_category_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_category',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-categories',
		);

		$this->options['st_product_category_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_category',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-categories',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_product_category_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_category',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-categories',
			'attribute' => 'margin',
		);

		$this->options['st_product_category_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_category',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-categories',
			'attribute' => 'padding',
		);

		$this->options['st_product_category_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_category',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-categories',
			'attribute' => 'border-radius',
		);

		$this->options['st_product_category_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_category',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-categories',
		);

		$this->options['st_product_category_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_category',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-categories',
		);

		$this->options['st_product_category_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_category',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-product-categories',
		);

		$this->options['st_product_amount_inline_background'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Inline Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_amount',
			'default'   => '',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.' . $widget_name . ' .price' => '-webkit-box-decoration-break: clone; box-decoration-break: clone; display: inline;',
				),
			),
		);

		$this->options['st_product_amount_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_amount',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .price',
		);

		$this->options['st_product_amount_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_amount',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .price',
		);

		$this->options['st_product_amount_second_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Second Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_amount',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .price del',
		);

		$this->options['st_product_amount_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_amount',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .price',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_product_amount_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_amount',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .price',
			'attribute' => 'margin',
		);

		$this->options['st_product_amount_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_amount',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .price',
			'attribute' => 'padding',
		);

		$this->options['st_product_amount_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_amount',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .price',
			'attribute' => 'border-radius',
		);

		$this->options['st_product_amount_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_amount',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .price',
		);

		$this->options['st_product_amount_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_amount',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .price',
		);

		$this->options['st_product_amount_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_amount',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .price',
		);

		$this->options['st_product_sale_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_product_sale',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale',
			'attribute'  => 'width',
		);

		$this->options['st_product_sale_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( ' Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_product_sale',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale' => 'height: {{SIZE}}{{UNIT}}; --jkit-onsale-height: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_product_sale_horizontal_orientation'] = array(
			'type'    => 'radio',
			'title'   => esc_html__( 'Horizontal Orientation', 'jeg-elementor-kit' ),
			'segment' => 'style_product_sale',
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

		$this->options['st_product_sale_horizontal_offset'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Offset', 'jeg-elementor-kit' ),
			'segment'    => 'style_product_sale',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 8,
			'selectors'  => array(
				'custom' => array( '{{WRAPPER}} .jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale' => '{{st_product_sale_horizontal_orientation.VALUE}}: {{SIZE}}{{UNIT}};' ),
			),
		);

		$this->options['st_product_sale_vertical_orientation'] = array(
			'type'    => 'radio',
			'title'   => esc_html__( 'Vertical Orientation', 'jeg-elementor-kit' ),
			'segment' => 'style_product_sale',
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

		$this->options['st_product_sale_vertical_offset'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Offset', 'jeg-elementor-kit' ),
			'segment'    => 'style_product_sale',
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 9,
			'selectors'  => array(
				'custom' => array( '{{WRAPPER}} .jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale' => '{{st_product_sale_vertical_orientation.VALUE}}: {{SIZE}}{{UNIT}};' ),
			),
		);

		$this->options['st_product_sale_gap_offset'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Gap', 'jeg-elementor-kit' ),
			'segment'    => 'style_product_sale',
			'responsive' => true,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => 5,
			'selectors'  => array(
				'custom' => array( '{{WRAPPER}} .jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale' => '--jkit-onsale-gap: {{SIZE}}px' ),
			),
		);

		$this->options['st_product_sale_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale',
		);

		$this->options['st_product_sale_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Sale', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'separator' => 'before',
		);

		$this->options['st_product_sale_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale.text',
		);

		$this->options['st_product_sale_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale.text',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_product_sale_percentage_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Percetage', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'separator' => 'before',
		);

		$this->options['st_product_sale_percentage_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale.percent',
		);

		$this->options['st_product_sale_percentage_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale.percent',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_product_sale_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale',
			'attribute' => 'margin',
			'separator' => 'before',
		);

		$this->options['st_product_sale_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale',
			'attribute' => 'padding',
		);

		$this->options['st_product_sale_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale',
			'attribute' => 'border-radius',
		);

		$this->options['st_product_sale_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale',
		);

		$this->options['st_product_sale_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale',
		);

		$this->options['st_product_sale_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_sale',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .jkit-products .jkit-product-block span.onsale',
		);

		$this->options['st_product_rating_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Star Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_product_rating',
			'default'    => 13,
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.' . $widget_name . ' .star-rating' => 'font-size:{{SIZE}}px; height:{{SIZE}}px',
				),
			),
			'attribute'  => 'font-size',
		);

		$this->options['st_product_rating_margin'] = array(
			'type'               => 'dimension',
			'title'              => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'            => 'style_product_rating',
			'units'              => array( 'px', '%', 'em' ),
			'allowed_dimensions' => 'vertical',
			'selectors'          => '.jeg-elementor-kit.' . $widget_name . ' .star-rating',
			'attribute'          => 'margin',
		);

		$this->options['st_product_rating_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_product_rating',
		);

		$this->options['st_product_rating_normal_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_product_rating',
		);

		$this->options['st_product_rating_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_rating',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .star-rating',
		);

		$this->options['st_product_rating_second_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Second Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_rating',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .star-rating:before',
		);

		$this->options['st_product_rating_normal_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_product_rating',
		);

		$this->options['st_product_rating_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_product_rating',
		);

		$this->options['st_product_rating_hover_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_rating',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .jkit-product-link:hover .star-rating',
		);

		$this->options['st_product_rating_hover_second_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Second Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_rating',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .jkit-product-link:hover .star-rating:before',
		);

		$this->options['st_product_rating_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_product_rating',
		);

		$this->options['st_product_rating_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_product_rating',
		);

		$this->options['st_product_button_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button',
			'attribute' => 'margin',
		);

		$this->options['st_product_button_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button',
			'attribute' => 'padding',
		);

		$this->options['st_product_button_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button',
		);

		$this->options['st_product_button_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_product_button',
		);

		$this->options['st_product_button_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_product_button',
		);

		$this->options['st_product_button_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button',
		);

		$this->options['st_product_button_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_product_button_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button',
			'attribute' => 'border-radius',
		);

		$this->options['st_product_button_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button',
		);

		$this->options['st_product_button_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button',
		);

		$this->options['st_product_button_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button',
		);

		$this->options['st_product_button_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_product_button',
		);

		$this->options['st_product_button_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_product_button',
		);

		$this->options['st_product_button_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.' . $widget_name . ' .product .button' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_product_button_hover_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button:hover',
		);

		$this->options['st_product_button_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_product_button_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_product_button_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button:hover',
		);

		$this->options['st_product_button_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button:hover',
		);

		$this->options['st_product_button_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_product_button',
			'selectors' => '.jeg-elementor-kit.' . $widget_name . ' .product .button:hover',
		);

		$this->options['st_product_button_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_product_button',
		);

		$this->options['st_product_button_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_product_button',
		);

		$this->nocontent_style();
	}
}
