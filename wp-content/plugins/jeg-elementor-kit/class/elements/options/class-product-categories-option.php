<?php
/**
 * Product Categories Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Product_Categories_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Product_Categories_Option extends Option_WooCommerce_Abstract {
	/**
	 * Default number of post ajax
	 *
	 * @var int
	 */
	protected $number_post_ajax = 4;

	/**
	 * Default number of post ajax
	 *
	 * @var int
	 */
	protected $widget_selector = 'jkit-product-categories';

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
		return esc_html__( 'JKit - Product Categories', 'jeg-elementor-kit' );
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

		// $this->set_wc_content_filter_option();

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

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_content'] = array(
			'name'      => esc_html__( 'Content List', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_text'] = array(
			'name'      => esc_html__( 'Text', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_thumbnail'] = array(
			'name'       => esc_html__( 'Thumbnail', 'jeg-elementor-kit' ),
			'priority'   => 13,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_show_thumbnail',
					'operator' => '==',
					'value'    => true,
				),
			),
		);
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_content_display'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Display', 'jeg-elementor-kit' ),
			'default' => 'list',
			'segment' => 'segment_content',
			'options' => array(
				'list' => esc_html__( 'List', 'jeg-elementor-kit' ),
				'grid' => esc_html__( 'Grid', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_content_column'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Column', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => '4',
			'options'    => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-categories.display-grid' => '--product-grid-column: {{SIZE}}',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_display',
					'operator' => '==',
					'value'    => 'grid',
				),
			),
		);

		$this->options['sg_content_column_gap'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Column Gap', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => '4',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories.display-grid',
			'attribute'  => 'grid-column-gap',
			'dependency' => array(
				array(
					'field'    => 'sg_content_display',
					'operator' => '==',
					'value'    => 'grid',
				),
			),
		);

		$this->options['sg_content_row_gap'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Row Gap', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'default'    => '4',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories.display-grid',
			'attribute'  => 'grid-row-gap',
			'dependency' => array(
				array(
					'field'    => 'sg_content_display',
					'operator' => '==',
					'value'    => 'grid',
				),
			),
		);

		$this->options['sg_content_layout'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Style', 'jeg-elementor-kit' ),
			'default' => 'vertical',
			'segment' => 'segment_content',
			'options' => array(
				'vertical'   => esc_html__( 'Vertical', 'jeg-elementor-kit' ),
				'horizontal' => esc_html__( 'Horizontal', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_content_position'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Content Position', 'jeg-elementor-kit' ),
			'default' => 'after',
			'segment' => 'segment_content',
			'options' => array(
				'before' => esc_html__( 'Before Thumnbnail', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After Thumnbnail', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_content_text_layout'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Text Layout', 'jeg-elementor-kit' ),
			'default'    => 'vertical',
			'segment'    => 'segment_content',
			'options'    => array(
				'vertical'   => esc_html__( 'Vertical', 'jeg-elementor-kit' ),
				'horizontal' => esc_html__( 'Horizontal', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_layout',
					'operator' => '==',
					'value'    => 'horizontal',
				),
			),
		);

		$this->options['sg_content_show_thumbnail'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Show Thumbnail', 'jeg-elementor-kit' ),
			'segment'   => 'segment_content',
			'default'   => 'yes',
			'separator' => 'before',
		);

		$this->options['sg_content_thumbnail_size'] = array(
			'type'       => 'imagesize',
			'title'      => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_show_thumbnail',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_show_count'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Show Count', 'jeg-elementor-kit' ),
			'segment'   => 'segment_content',
			'default'   => 'yes',
			'separator' => 'before',
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
			'dependency'  => array(
				array(
					'field'    => 'wc_include_category',
					'operator' => '==',
					'value'    => '',
				),
			),
		);

		$this->options['number_category'] = array(
			'type'        => 'slider',
			'title'       => esc_html__( 'Number of Category', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Limit number of category on this module.', 'jeg-elementor-kit' ),
			'segment'     => 'segment_filter',
			'options'     => array(
				'min'  => 1,
				'max'  => 30,
				'step' => 1,
			),
			'default'     => 4,
			'dependency'  => array(
				array(
					'field'    => 'wc_include_category',
					'operator' => '==',
					'value'    => '',
				),
			),
		);

		$this->options['sort_by'] = array(
			'type'        => 'select',
			'title'       => esc_html__( 'Sort by', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Sort category by this option', 'jeg-elementor-kit' ),
			'segment'     => 'segment_filter',
			'default'     => 'latest',
			'options'     => array(
				'latest'           => esc_html__( 'Latest', 'jeg-elementor-kit' ),
				'oldest'           => esc_html__( 'Oldest', 'jeg-elementor-kit' ),
				'alphabet_asc'     => esc_html__( 'Alphabet Asc', 'jeg-elementor-kit' ),
				'alphabet_desc'    => esc_html__( 'Alphabet Desc', 'jeg-elementor-kit' ),
				'number_post_asc'  => esc_html__( 'Number Post Asc', 'jeg-elementor-kit' ),
				'number_post_desc' => esc_html__( 'Number Post Desc', 'jeg-elementor-kit' ),
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_content_justify'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'options'    => array(
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
			'responsive' => true,
			'default'    => 'flex-start',
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories.layout-horizontal',
			'attribute'  => 'justify-content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_layout',
					'operator' => '==',
					'value'    => 'horizontal',
				),
			),
		);

		$this->options['st_content_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
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
			'default'    => 'left',
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories',
			'attribute'  => 'text-align',
			'dependency' => array(
				array(
					'field'    => 'sg_content_layout',
					'operator' => '==',
					'value'    => 'vertical',
				),
			),
		);

		$this->options['st_content_space_between'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Space Between', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-categories.layout-horizontal .jkit-product-category'                => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-product-categories.layout-vertical .jkit-product-category:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2);',
				),
			),
		);

		$this->options['st_text_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_text',
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
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category-content',
			'attribute'  => 'text-align',
			'dependency' => array(
				array(
					'field'    => 'sg_content_layout',
					'operator' => '==',
					'value'    => 'horizontal',
				),
				array(
					'field'    => 'sg_content_text_layout',
					'operator' => '==',
					'value'    => 'vertical',
				),
			),
		);

		$this->options['st_text_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Wrapper Text', 'jeg-elementor-kit' ),
			'segment'   => 'style_text',
			'separator' => 'before',
		);

		$this->options['st_text_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_text',
			'selectors' => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-product-category-content',
		);

		$this->options['st_text_hover_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_text',
			'selectors' => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category:hover .jkit-product-category-content',
		);

		$this->options['st_text_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_text',
			'selectors' => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category > a .jkit-product-category-content',
		);

		$this->options['st_text_count_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Count Text', 'jeg-elementor-kit' ),
			'segment'    => 'style_text',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_content_show_count',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_text_count_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_text',
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-product-category-content .jkit-product-category-count',
			'dependency' => array(
				array(
					'field'    => 'sg_content_show_count',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_text_count_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_text',
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category:hover .jkit-product-category-content .jkit-product-category-count',
			'dependency' => array(
				array(
					'field'    => 'sg_content_show_count',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_text_count_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_text',
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category > a .jkit-product-category-count',
			'dependency' => array(
				array(
					'field'    => 'sg_content_show_count',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_thumbnail_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_thumbnail',
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
			'default'    => 'left',
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories .jkit-category-thumbnail',
			'attribute'  => 'text-align',
		);

		$this->options['st_thumbnail_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_thumbnail',
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_thumbnail_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_thumbnail',
			'units'      => array( 'px', '%', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_thumbnail_wrapper_overflow'] = array(
			'type'      => 'select',
			'title'     => esc_html__( 'Overflow', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'default'   => 'hidden',
			'options'   => array(
				'initial' => esc_html__( 'Initial', 'jeg-elementor-kit' ),
				'hidden'  => esc_html__( 'Hidden', 'jeg-elementor-kit' ),
			),
			'selectors' => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail',
			'attribute' => 'overflow',
		);

		$this->options['st_thumbnail_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail img',
			'attribute' => 'margin',
		);

		$this->options['st_thumbnail_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail img',
			'attribute' => 'padding',
		);

		$this->options['st_thumbnail_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_thumbnail',
		);

		$this->options['st_thumbnail_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_thumbnail',
		);

		$this->options['st_thumbnail_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'selectors' => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail img',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_thumbnail_border_radius'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'    => 'style_thumbnail',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail img',
			'attribute'  => 'border-radius',
			'responsive' => true,
		);

		$this->options['st_thumbnail_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'selectors' => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail img',
		);

		$this->options['st_thumbnail_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'selectors' => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail img',
		);

		$this->options['st_thumbnail_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_thumbnail',
		);

		$this->options['st_thumbnail_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_thumbnail',
		);

		$this->options['st_thumbnail_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'selectors' => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail:hover img',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
		);

		$this->options['st_thumbnail_hover_border_radius'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'    => 'style_thumbnail',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail:hover img',
			'attribute'  => 'border-radius',
			'responsive' => true,
		);

		$this->options['st_thumbnail_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'selectors' => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail:hover img',
		);

		$this->options['st_thumbnail_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'selectors' => '.jeg-elementor-kit.jkit-product-categories .jkit-product-category .jkit-category-thumbnail:hover img',
		);

		$this->options['st_thumbnail_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_thumbnail',
		);

		$this->options['st_thumbnail_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_thumbnail',
		);

		parent::additional_style();
	}
}
