<?php
/**
 * Category List Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.3.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Category_List_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Category_List_Option extends Option_Abstract {
	/**
	 * Default number of post
	 *
	 * @var int
	 */
	protected $number_post = 3;

	/**
	 * Default number of post ajax
	 *
	 * @var int
	 */
	protected $number_post_ajax = 3;

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
		return esc_html__( 'JKit - Category List', 'jeg-elementor-kit' );
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
		$this->set_content_filter_segment();

		$this->segments['segment_content'] = array(
			'name'     => esc_html__( 'Content Setting', 'jeg-elementor-kit' ),
			'priority' => 5,
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

		$this->segments['style_icon'] = array(
			'name'       => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'priority'   => 13,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_icon_enable',
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
		$this->options['include_category'] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_category',
			'options'     => 'jeg_get_category_option',
			'nonce'       => wp_create_nonce( 'jeg_find_category' ),
			'title'       => esc_html__( 'Include Category', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Choose which category you want to show. If not specified, all category will be shown.', 'jeg-elementor-kit' ),
			'segment'     => 'content-filter',
			'default'     => '',
		);

		$this->options['number_category'] = array(
			'type'        => 'slider',
			'title'       => esc_html__( 'Number of Category', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Limit number of category on this module.', 'jeg-elementor-kit' ),
			'segment'     => 'content-filter',
			'options'     => array(
				'min'  => 1,
				'max'  => 30,
				'step' => 1,
			),
			'default'     => $this->number_post,
			'dependency'  => array(
				array(
					'field'    => 'include_category',
					'operator' => '==',
					'value'    => '',
				),
			),
		);

		$this->options['sort_by'] = array(
			'type'        => 'select',
			'title'       => esc_html__( 'Sort by', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Sort category by this option', 'jeg-elementor-kit' ),
			'segment'     => 'content-filter',
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

		$this->options['sg_content_icon_enable'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Show Icon', 'jeg-elementor-kit' ),
			'segment'   => 'segment_content',
			'default'   => 'yes',
			'separator' => 'before',
		);

		$this->options['sg_content_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-circle',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_icon_enable',
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
			'selectors'  => '.jeg-elementor-kit.jkit-categorylist.layout-horizontal',
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
			'selectors'  => '.jeg-elementor-kit.jkit-categorylist',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-categorylist.layout-horizontal .category-list-item'                => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-categorylist.layout-vertical .category-list-item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2);',
				),
			),
		);

		$this->options['st_text_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_text',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-categorylist .category-list-item .jkit-categorylist-content',
		);

		$this->options['st_text_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_text',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-categorylist .category-list-item:hover .jkit-categorylist-content',
		);

		$this->options['st_text_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_text',
			'selectors' => '.jeg-elementor-kit.jkit-categorylist .category-list-item > a',
		);

		$this->options['st_icon_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-categorylist .category-list-item .icon-list i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-categorylist .category-list-item .icon-list svg' => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-categorylist .category-list-item:hover .icon-list i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-categorylist .category-list-item:hover .icon-list svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-categorylist .category-list-item .icon-list i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-categorylist .category-list-item .icon-list svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_icon_line_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Line Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-categorylist .category-list-item .icon-list',
			'attribute'  => 'line-height',
		);

		$this->options['st_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-categorylist .category-list-item .icon-list i, {{WRAPPER}} .jeg-elementor-kit.jkit-categorylist .category-list-item .icon-list svg' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			),
		);

		parent::additional_style();
	}
}
