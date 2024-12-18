<?php
/**
 * Post List Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.2.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Post_List_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Post_List_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Post List', 'jeg-elementor-kit' );
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
		$this->set_content_filter_option( $this->number_post );
		$this->pagination_option( $this->number_post_ajax );
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

		$this->set_pagination_segment();
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

		$this->segments['style_title'] = array(
			'name'      => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_image'] = array(
			'name'       => esc_html__( 'Image', 'jeg-elementor-kit' ),
			'priority'   => 13,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_image_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_icon'] = array(
			'name'       => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'priority'   => 14,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_image_enable!',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_content_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_meta'] = array(
			'name'       => esc_html__( 'Meta', 'jeg-elementor-kit' ),
			'priority'   => 15,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_meta_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_preload'] = array(
			'name'      => esc_html__( 'Preload', 'jeg-elementor-kit' ),
			'priority'  => 16,
			'kit_style' => true,
		);

		$this->segments['style_pagination'] = array(
			'name'       => esc_html__( 'Pagination', 'jeg-elementor-kit' ),
			'priority'   => 17,
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

		$this->options['sg_content_column'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Column', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => 1,
			'options'    => array(
				'min'  => 1,
				'max'  => 3,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist.layout-horizontal .jkit-posts' => 'grid-template-columns: repeat({{SIZE}}, minmax(0, 1fr));',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_layout',
					'operator' => '==',
					'value'    => 'horizontal',
				),
			),
		);

		$this->options['sg_content_column_gap'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Column Gap', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-postlist.layout-horizontal .jkit-posts',
			'attribute'  => 'grid-column-gap',
			'dependency' => array(
				array(
					'field'    => 'sg_content_layout',
					'operator' => '==',
					'value'    => 'horizontal',
				),
			),
		);

		$this->options['sg_content_image_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Featured Image', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
		);

		$this->options['sg_content_background_image_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Background Featured Image', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
		);

		$this->options['sg_content_image_size'] = array(
			'type'    => 'imagesize',
			'title'   => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
			'default' => 'large',
		);

		$this->options['sg_content_icon_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Show Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => 'yes',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_content_image_enable!',
					'operator' => '==',
					'value'    => true,
				),
			),
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
					'field'    => 'sg_content_image_enable!',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_content_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_meta_enable'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Show Meta', 'jeg-elementor-kit' ),
			'segment'   => 'segment_content',
			'separator' => 'before',
		);

		$this->options['sg_content_meta_date_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Show Meta Date', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_meta_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_meta_date_type'] = array(
			'type'        => 'select',
			'title'       => esc_html__( 'Post Date Type', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Choose which post date type that you want to use.', 'jeg-elementor-kit' ),
			'default'     => 'published',
			'segment'     => 'segment_content',
			'options'     => array(
				'published' => esc_html__( 'Published Date', 'jeg-elementor-kit' ),
				'modified'  => esc_html__( 'Modified Date', 'jeg-elementor-kit' ),
				'both'      => esc_html__( 'Show Both', 'jeg-elementor-kit' ),
			),
			'dependency'  => array(
				array(
					'field'    => 'sg_content_meta_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_content_meta_date_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_meta_date_format'] = array(
			'type'        => 'select',
			'title'       => esc_html__( 'Post Date Format', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Choose which date format you want to use for single post.', 'jeg-elementor-kit' ),
			'default'     => 'default',
			'segment'     => 'segment_content',
			'options'     => array(
				'ago'     => esc_attr__( 'Relative Date/Time Format (ago)', 'jeg-elementor-kit' ),
				'default' => esc_attr__( 'WordPress Default Format', 'jeg-elementor-kit' ),
				'custom'  => esc_attr__( 'Custom Format', 'jeg-elementor-kit' ),
			),
			'dependency'  => array(
				array(
					'field'    => 'sg_content_meta_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_content_meta_date_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_meta_date_format_custom'] = array(
			'type'        => 'text',
			'title'       => esc_html__( 'Post Date Custom Format', 'jeg-elementor-kit' ),
			/* translators: %s: https://wordpress.org/support/article/formatting-date-and-time/ */
			'description' => wp_kses( sprintf( __( 'Insert custom date format for single post meta. For more detail about this format, please refer to <a href="%s" target="_blank">Developer Codex</a>.', 'jeg-elementor-kit' ), 'https://wordpress.org/support/article/formatting-date-and-time/' ), wp_kses_allowed_html() ),
			'default'     => get_option( 'date_format' ),
			'segment'     => 'segment_content',
			'dependency'  => array(
				array(
					'field'    => 'sg_content_meta_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_content_meta_date_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_content_meta_date_format',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['sg_content_meta_date_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Meta Date Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-clock',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_meta_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_content_meta_date_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_meta_category_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Show Meta Category', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_meta_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_meta_category_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Meta Category Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-tag',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_meta_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_content_meta_category_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_meta_position'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Meta Position', 'jeg-elementor-kit' ),
			'default' => 'top',
			'segment' => 'segment_content',
			'options' => array(
				'top'    => esc_html__( 'Top', 'jeg-elementor-kit' ),
				'bottom' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
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
			'selectors'  => '.jeg-elementor-kit.jkit-postlist article',
			'attribute'  => 'text-align',
		);

		$this->options['st_content_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a',
			'attribute' => 'padding',
		);

		$this->options['st_content_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a',
			'attribute' => 'margin',
		);

		$this->options['st_content_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'options'    => array(
				'min'  => 0,
				'max'  => 5000,
				'step' => 1,
			),
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-postlist article a',
			'attribute'  => 'width',
			'dependency' => array(
				array(
					'field'    => 'sg_content_layout',
					'operator' => '==',
					'value'    => 'vertical',
				),
			),
		);

		$this->options['st_content_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_content',
		);

		$this->options['st_content_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_content',
		);

		$this->options['st_content_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-postlist article',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_content_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-postlist article',
		);

		$this->options['st_content_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article',
			'attribute' => 'border-radius',
		);

		$this->options['st_content_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-postlist article',
		);

		$this->options['st_content_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_content',
		);

		$this->options['st_content_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_content',
		);

		$this->options['st_content_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-postlist article:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_content_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-postlist article:hover',
		);

		$this->options['st_content_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_content_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-postlist article:hover',
		);

		$this->options['st_content_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_content',
		);

		$this->options['st_content_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_content',
		);

		$this->options['st_content_overlay'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Image Overlay', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_content_background_image_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_content_overlay_color'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-postlist.bg-image article a:after',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_background_image_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_content_overlay_hover_color'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Hover Background Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-postlist.bg-image article:hover a:after',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_background_image_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_title_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
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
			'selectors'  => '.jeg-elementor-kit.jkit-postlist article a .jkit-postlist-title',
			'attribute'  => 'text-align',
		);

		$this->options['st_title_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-postlist article a .jkit-postlist-title',
		);

		$this->options['st_title_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-postlist article:hover a .jkit-postlist-title',
		);

		$this->options['st_title_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .jkit-postlist-title' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_title_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a .jkit-postlist-title',
			'attribute' => 'padding',
		);

		$this->options['st_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a .jkit-postlist-title',
		);

		$this->options['sg_image_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'default'    => 200,
			'options'    => array(
				'min'  => 1,
				'max'  => 200,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-postlist article a img',
			'attribute'  => 'width',
		);

		$this->options['st_image_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a img',
			'attribute' => 'margin',
			'default'   => array(
				'top'      => '0',
				'right'    => '15',
				'bottom'   => '0',
				'left'     => '0',
				'unit'     => 'px',
				'isLinked' => false,
			),
		);

		$this->options['st_image_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_image',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a img',
			'attribute' => 'border-radius',
		);

		$this->options['st_meta_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta',
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
			'selectors'  => '.jeg-elementor-kit.jkit-postlist article a .meta-lists',
			'attribute'  => 'text-align',
		);

		$this->options['st_meta_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_meta',
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a .meta-lists span',
		);

		$this->options['st_meta_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta',
			'options'    => array(
				'min'  => 1,
				'max'  => 100,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .meta-lists span i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .meta-lists span svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_meta_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta',
			'options'    => array(
				'min'  => 1,
				'max'  => 100,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .meta-lists span i, {{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .meta-lists span svg' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_meta_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_meta',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a .meta-lists span',
			'attribute' => 'padding',
		);

		$this->options['st_meta_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_meta',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a .meta-lists span',
			'attribute' => 'margin',
		);

		$this->options['st_meta_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_meta',
		);

		$this->options['st_meta_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_meta',
		);

		$this->options['st_meta_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .meta-lists span'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .meta-lists span svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_meta_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_meta',
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a .meta-lists span',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_meta_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_meta',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a .meta-lists span',
			'attribute' => 'border-radius',
		);

		$this->options['st_meta_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_meta',
		);

		$this->options['st_meta_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_meta',
		);

		$this->options['st_meta_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article:hover a .meta-lists span'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article:hover a .meta-lists span svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_meta_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_meta',
			'selectors' => '.jeg-elementor-kit.jkit-postlist article:hover a .meta-lists span',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_meta_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_meta',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article:hover a .meta-lists span',
			'attribute' => 'border-radius',
		);

		$this->options['st_meta_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_meta',
		);

		$this->options['st_meta_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_meta',
		);

		$this->options['st_icon_vertical_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Vertical Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'flex-start' => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-angle-double-up',
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-sort',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-angle-double-down',
				),
			),
			'responsive' => true,
			'default'    => 'center',
			'selectors'  => '.jeg-elementor-kit.jkit-postlist article a .icon-list',
			'attribute'  => 'align-self',
		);

		$this->options['st_icon_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a .icon-list',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_icon_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-postlist article a .icon-list',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_icon_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-postlist article a .icon-list',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_icon_line_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Line Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-postlist article a .icon-list',
			'attribute'  => 'line-height',
			'responsive' => true,
		);

		$this->options['st_icon_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a .icon-list',
			'attribute' => 'margin',
		);

		$this->options['st_icon_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist article a .icon-list',
			'attribute' => 'border-radius',
		);

		$this->options['st_icon_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .icon-list i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .icon-list svg' => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article:hover a .icon-list i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article:hover a .icon-list svg' => 'fill: {{VALUE}};',
				),
			),
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .icon-list i, {{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .icon-list svg' => 'transition-duration: {{SIZE}}s;',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .icon-list i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist article a .icon-list svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_pagination_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination',
			'attribute' => 'margin',
		);

		$this->options['st_pagination_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
			'attribute' => 'padding',
		);

		$this->options['st_pagination_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_pagination',
			'selectors'  => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button a',
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
			'selectors'    => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.icon-position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.icon-position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button svg' => 'width: {{SIZE}}{{UNIT}};',
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
			'selectors'  => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-nextprev-normal' => 'display: inline-flex; gap: {{SIZE}}{{UNIT}}',
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

		$this->options['st_preload_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_preload',
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-preloader-overlay',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_preload_dot_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Dots Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_preload',
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-preloader-overlay span',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
			'separator' => 'before',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button, {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button svg'                                                                                         => 'fill: {{VALUE}}',
				),
			),
		);

		$this->options['st_pagination_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
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
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
			'attribute' => 'border-radius',
		);

		$this->options['st_pagination_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
		);

		$this->options['st_pagination_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev) a, {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)' => 'color: {{VALUE}}',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev) svg' => 'fill: {{VALUE}}',
				),
			),
		);

		$this->options['st_pagination_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)',
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
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)',
			'attribute' => 'border-radius',
		);

		$this->options['st_pagination_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)',
		);

		$this->options['st_pagination_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)',
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
			'selectors'    => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
			'attribute'    => 'opacity',
		);

		$this->options['st_pagination_disabled_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_pagination',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_pagination_disabled_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
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
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
			'attribute' => 'border-radius',
		);

		$this->options['st_pagination_disabled_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
		);

		$this->options['st_pagination_disabled_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postlist .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
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
