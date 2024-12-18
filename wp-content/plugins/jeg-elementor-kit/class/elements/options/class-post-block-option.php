<?php
/**
 * Post Block Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Post_Block_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Post_Block_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Post Block', 'jeg-elementor-kit' );
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
		$this->segments['style_wrapper'] = array(
			'name'      => esc_html__( 'Container', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_post_item'] = array(
			'name'      => esc_html__( 'Post Item', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_thumbnail'] = array(
			'name'      => esc_html__( 'Thumbnail', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_thumbnail_container'] = array(
			'name'      => esc_html__( 'Thumbnail Container', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		$this->segments['style_content'] = array(
			'name'      => esc_html__( 'Content Container', 'jeg-elementor-kit' ),
			'priority'  => 15,
			'kit_style' => true,
		);

		$this->segments['style_category'] = array(
			'name'       => esc_html__( 'Category', 'jeg-elementor-kit' ),
			'priority'   => 16,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_category_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_title'] = array(
			'name'      => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'priority'  => 17,
			'kit_style' => true,
		);

		$this->segments['style_excerpt'] = array(
			'name'       => esc_html__( 'Excerpt', 'jeg-elementor-kit' ),
			'priority'   => 18,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_excerpt_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_readmore'] = array(
			'name'       => esc_html__( 'Read More', 'jeg-elementor-kit' ),
			'priority'   => 19,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_readmore_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_comment'] = array(
			'name'       => esc_html__( 'Comment', 'jeg-elementor-kit' ),
			'priority'   => 20,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_comment_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_meta'] = array(
			'name'       => esc_html__( 'Post Meta', 'jeg-elementor-kit' ),
			'priority'   => 21,
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
			'priority'  => 22,
			'kit_style' => true,
		);

		$this->segments['style_pagination'] = array(
			'name'       => esc_html__( 'Pagination', 'jeg-elementor-kit' ),
			'priority'   => 23,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'pagination_mode',
					'operator' => 'in',
					'value'    => array( 'loadmore', 'scrollload', 'nextprev' ),
				),
			),
		);

		$this->segments['style_meta_bottom'] = array(
			'name'       => esc_html__( 'Meta Bottom', 'jeg-elementor-kit' ),
			'priority'   => 23,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_readmore_enable!',
					'operator' => '==',
					'value'    => false,
				),
				array(
					'field'    => 'sg_content_comment_enable!',
					'operator' => '==',
					'value'    => false,
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
		$this->options['sg_content_postblock_type'] = array(
			'type'    => 'radio',
			'title'   => esc_html__( 'Block Type', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
			'default' => 'type-1',
			'options' => array(
				'type-1' => array(
					'title' => esc_html__( 'Type 1', 'jeg-elementor-kit' ),
					'icon'  => 'jkit-postblock-type-1',
				),
				'type-2' => array(
					'title' => esc_html__( 'Type 2', 'jeg-elementor-kit' ),
					'icon'  => 'jkit-postblock-type-2',
				),
				'type-3' => array(
					'title' => esc_html__( 'Type 3', 'jeg-elementor-kit' ),
					'icon'  => 'jkit-postblock-type-3',
				),
				'type-4' => array(
					'title' => esc_html__( 'Type 4', 'jeg-elementor-kit' ),
					'icon'  => 'jkit-postblock-type-4',
				),
				'type-5' => array(
					'title' => esc_html__( 'Type 5', 'jeg-elementor-kit' ),
					'icon'  => 'jkit-postblock-type-5',
				),
			),
		);

		$this->options['sg_content_element_order'] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'title'       => esc_html__( 'Element Order', 'jeg-elementor-kit' ),
			'segment'     => 'segment_content',
			'ajax'        => true,
			'options'     => array(
				'title'   => esc_html__( 'Title', 'jeg-elementor-kit' ),
				'meta'    => esc_html__( 'Meta', 'jeg-elementor-kit' ),
				'excerpt' => esc_html__( 'Excerpt', 'jeg-elementor-kit' ),
				'read'    => esc_html__( 'Read More', 'jeg-elementor-kit' ),
			),
			'default'     => 'title,meta,excerpt,read',
			'label_block' => true,
			'description' => esc_html__( 'Arrange the element order. You also can add and remove a certain element.', 'jeg-elementor-kit' ),
		);

		$this->options['sg_content_breakpoint'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Responsive Breakpoint', 'jeg-elementor-kit' ),
			'default'    => 'tablet',
			'segment'    => 'segment_content',
			'options'    => array(
				'tablet'        => esc_html__( 'Tablet', 'jeg-elementor-kit' ),
				'mobile'        => esc_html__( 'Mobile', 'jeg-elementor-kit' ),
				'no-responsive' => esc_html__( 'No Responsive', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_postblock_type',
					'operator' => 'in',
					'value'    => array( 'type-1', 'type-4' ),
				),
			),
		);

		$this->options['sg_content_image_size'] = array(
			'type'    => 'imagesize',
			'title'   => esc_html__( 'Image Thumbnail Size', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
		);

		$this->options['sg_content_column'] = array(
			'type'           => 'slider',
			'title'          => esc_html__( 'Column', 'jeg-elementor-kit' ),
			'segment'        => 'segment_content',
			'default'        => 1,
			'tablet_default' => array(
				'size' => 1,
			),
			'mobile_detault' => array(
				'size' => 1,
			),
			'options'        => array(
				'min'  => 1,
				'max'  => 3,
				'step' => 1,
			),
			'responsive'     => true,
			'selectors'      => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-posts' => 'grid-template-columns: repeat({{SIZE}}, minmax(0, 1fr));',
				),
			),
		);

		$this->options['sg_content_title_html_tag'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Title HTML Tag', 'jeg-elementor-kit' ),
			'default' => 'h3',
			'segment' => 'segment_content',
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

		$this->options['sg_content_category_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Category', 'jeg-elementor-kit' ),
			'segment'   => 'segment_content',
			'separator' => 'before',
		);

		$this->options['sg_content_category_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Category', 'jeg-elementor-kit' ),
			'default' => 'yes',
			'segment' => 'segment_content',
		);

		$this->options['sg_content_excerpt_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Excerpt', 'jeg-elementor-kit' ),
			'segment'   => 'segment_content',
			'separator' => 'before',
		);

		$this->options['sg_content_excerpt_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Excerpt', 'jeg-elementor-kit' ),
			'default' => 'yes',
			'segment' => 'segment_content',
		);

		$this->options['sg_content_excerpt_length'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Excerpt Length', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => 20,
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_excerpt_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_excerpt_more'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Excerpt More', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => '...',
			'dependency' => array(
				array(
					'field'    => 'sg_content_excerpt_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_readmore_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Read More', 'jeg-elementor-kit' ),
			'segment'   => 'segment_content',
			'separator' => 'before',
		);

		$this->options['sg_content_readmore_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Read More Button', 'jeg-elementor-kit' ),
			'default' => 'yes',
			'segment' => 'segment_content',
		);

		$this->options['sg_content_readmore_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Read More Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-arrow-right',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_readmore_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_readmore_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'after',
			'segment'    => 'segment_content',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_readmore_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_readmore_text'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Read More Text', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => esc_html__( 'Read More', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_content_readmore_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_comment_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Comment Icon', 'jeg-elementor-kit' ),
			'segment'   => 'segment_content',
			'separator' => 'before',
		);

		$this->options['sg_content_comment_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Comment Icon', 'jeg-elementor-kit' ),
			'default' => 'yes',
			'segment' => 'segment_content',
		);

		$this->options['sg_content_comment_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Comment Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-comment',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_comment_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_comment_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_content',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_comment_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_meta_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Post Meta', 'jeg-elementor-kit' ),
			'segment'   => 'segment_content',
			'separator' => 'before',
		);

		$this->options['sg_content_meta_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Post Meta', 'jeg-elementor-kit' ),
			'default' => 'yes',
			'segment' => 'segment_content',
		);

		$this->options['sg_content_meta_author_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Enable Post Meta Author', 'jeg-elementor-kit' ),
			'default'    => 'yes',
			'segment'    => 'segment_content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_meta_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_meta_author_by_text'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Meta Author "by" Text', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => esc_html__( 'by', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_content_meta_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_content_meta_author_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_meta_author_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Meta Author Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-user',
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
					'field'    => 'sg_content_meta_author_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_meta_author_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_content',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_meta_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_content_meta_author_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_meta_date_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Enable Post Meta Date', 'jeg-elementor-kit' ),
			'default'    => 'yes',
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

		$this->options['sg_content_meta_date_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_content',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
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
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_wrapper_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-postblock',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_wrapper_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock',
			'attribute' => 'padding',
		);

		$this->options['st_wrapper_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock',
			'attribute' => 'margin',
		);

		$this->options['st_wrapper_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock',
			'attribute' => 'border-radius',
		);

		$this->options['st_wrapper_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-postblock',
		);

		$this->options['st_wrapper_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-postblock',
		);

		$this->options['st_post_item_gap'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Column Gap', 'jeg-elementor-kit' ),
			'segment'    => 'style_post_item',
			'default'    => 40,
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-posts',
			'attribute'  => 'grid-column-gap',
		);

		$this->options['st_post_item_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_post_item',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_post_item_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_post_item',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post',
			'attribute' => 'padding',
		);

		$this->options['st_post_item_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_post_item',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post',
			'attribute' => 'margin',
		);

		$this->options['st_post_item_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_post_item',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post',
			'attribute' => 'border-radius',
		);

		$this->options['st_post_item_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_post_item',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post',
		);

		$this->options['st_post_item_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_post_item',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post',
		);

		$this->options['st_thumbnail_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-thumb',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_thumbnail_background_overlay'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Overlay', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-thumb .thumbnail-container:before',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_thumbnail_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-thumb',
			'attribute' => 'padding',
		);

		$this->options['st_thumbnail_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-thumb',
			'attribute' => 'margin',
		);

		$this->options['st_thumbnail_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-thumb',
			'attribute' => 'border-radius',
		);

		$this->options['st_thumbnail_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-thumb',
		);

		$this->options['st_thumbnail_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-thumb',
		);

		$this->options['st_thumbnail_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_thumbnail',
			'units'      => array( '%' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-1 .jkit-thumb' => '-ms-flex: 0 0 {{SIZE}}%;',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-1 .jkit-thumb' => 'flex: 0 0 {{SIZE}}%;',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-4 .jkit-thumb' => '-ms-flex: 0 0 {{SIZE}}%;',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-4 .jkit-thumb' => 'flex: 0 0 {{SIZE}}%;',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_postblock_type',
					'operator' => 'in',
					'value'    => array( 'type-1', 'type-4' ),
				),
			),
		);

		$this->options['st_thumbnail_container_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Image Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_thumbnail_container',
			'default'    => 300,
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-thumb .thumbnail-container',
			'attribute'  => 'height',
		);

		$this->options['st_thumbnail_container_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail_container',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-thumb .thumbnail-container',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_thumbnail_container_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-thumb .thumbnail-container',
			'attribute' => 'border-radius',
		);

		$this->options['st_thumbnail_container_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail_container',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-thumb .thumbnail-container',
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
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-postblock-content',
			'attribute'  => 'text-align',
		);

		$this->options['st_content_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-postblock-content',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_postblock_type!',
					'operator' => '==',
					'value'    => 'type-5',
				),
			),
		);

		$this->options['st_content_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-postblock-content',
			'attribute' => 'padding',
		);

		$this->options['st_content_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-postblock-content',
			'attribute' => 'margin',
		);

		$this->options['st_content_border_radius'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-postblock-content',
			'attribute'  => 'border-radius',
			'dependency' => array(
				array(
					'field'    => 'sg_content_postblock_type!',
					'operator' => '==',
					'value'    => 'type-5',
				),
			),
		);

		$this->options['st_content_border'] = array(
			'type'       => 'border',
			'title'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-postblock-content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_postblock_type!',
					'operator' => '==',
					'value'    => 'type-5',
				),
			),
		);

		$this->options['st_content_boxshadow'] = array(
			'type'       => 'boxshadow',
			'title'      => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-postblock-content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_postblock_type!',
					'operator' => '==',
					'value'    => 'type-5',
				),
			),
		);

		$this->options['st_category_position'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_category',
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
			'default'    => 'center',
			'dependency' => array(
				array(
					'field'    => 'sg_content_postblock_type',
					'operator' => '==',
					'value'    => 'type-3',
				),
			),
		);

		$this->options['st_category_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-category span a, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-3 .jkit-post-category span a',
			),
		);

		$this->options['st_category_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_category',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-category a'                  => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-2 .jkit-post-category a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-5 .jkit-post-category a' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_category_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-category, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-3 .jkit-post-category',
			),
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_category_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'units'     => array( 'px', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-category'                  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-3 .jkit-post-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_category_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'units'     => array( 'px', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-category'                  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-3 .jkit-post-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-5 .jkit-post-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_category_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post-category',
			'attribute' => 'border-radius',
		);

		$this->options['st_category_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post-category',
		);

		$this->options['st_category_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post-category',
		);

		$this->options['st_title_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'selectors'  => '.jeg-elementor-kit.jkit-postblock.postblock-type-4 .jkit-post-title a',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_postblock_type',
					'operator' => '==',
					'value'    => 'type-4',
				),
			),
		);

		$this->options['st_title_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-title'                  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-4 .jkit-post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_title_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_title',
		);

		$this->options['st_title_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_title',
		);

		$this->options['st_title_normal_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Normal Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-title a, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-4 .jkit-post-title a',
			),
		);

		$this->options['st_title_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-post-title a',
		);

		$this->options['st_title_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_title',
		);

		$this->options['st_title_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_title',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-title a, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-4 .jkit-post-title a' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_title_hover_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Hover Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-title a:hover, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock.postblock-type-4 .jkit-post-title a:hover',
			),
		);

		$this->options['st_title_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-post-title a:hover',
		);

		$this->options['st_title_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_title',
		);

		$this->options['st_title_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_title',
		);

		$this->options['st_excerpt_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_excerpt',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post-excerpt',
		);

		$this->options['st_excerpt_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_excerpt',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-post-excerpt p',
		);

		$this->options['st_excerpt_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_excerpt',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post-excerpt',
			'attribute' => 'margin',
		);

		$this->options['st_readmore_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_readmore',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-readmore',
		);

		$this->options['st_readmore_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_readmore',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-readmore',
			'attribute' => 'padding',
		);

		$this->options['st_readmore_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_readmore',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-readmore',
			'attribute' => 'margin',
		);

		$this->options['st_readmore_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_readmore',
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-readmore.icon-position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-readmore.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-readmore.icon-position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-readmore.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_readmore_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_readmore',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-readmore i'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-readmore svg'   => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_readmore_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_readmore',
		);

		$this->options['st_readmore_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_readmore',
		);

		$this->options['st_readmore_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_readmore',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-readmore',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_readmore_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_readmore',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-readmore'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-readmore svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_readmore_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_readmore',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-readmore',
			'attribute' => 'border-radius',
		);

		$this->options['st_readmore_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_readmore',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-readmore',
		);

		$this->options['st_readmore_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_readmore',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-readmore',
		);

		$this->options['st_readmore_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_readmore',
		);

		$this->options['st_readmore_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_readmore',
		);

		$this->options['st_readmore_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_readmore',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-readmore:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_readmore_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_readmore',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-readmore:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-readmore:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_readmore_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_readmore',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-readmore:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_readmore_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_readmore',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-readmore:hover',
		);

		$this->options['st_readmore_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_readmore',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-readmore:hover',
		);

		$this->options['st_readmore_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_readmore',
		);

		$this->options['st_readmore_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_readmore',
		);

		$this->options['st_comment_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_comment',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-meta-bottom .jkit-meta-comment a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-meta-bottom .jkit-meta-comment a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_comment_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_comment',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-meta-bottom .jkit-meta-comment a'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-meta-bottom .jkit-meta-comment svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_comment_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_comment',
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-comment.icon-position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-comment.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-comment.icon-position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-comment.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_comment_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_comment',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post-meta-bottom .jkit-meta-comment',
			'attribute' => 'padding',
		);

		$this->options['st_comment_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_comment',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post-meta-bottom .jkit-meta-comment',
			'attribute' => 'margin',
		);

		$this->options['st_meta_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_meta',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post-meta',
		);

		$this->options['st_meta_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-meta'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-meta svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_meta_author_name_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Author Name Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta',
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-post-meta a',
			'dependency' => array(
				array(
					'field'    => 'sg_content_meta_author_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_meta_author_name_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Author Name Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-meta a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-post-meta a svg' => 'fill: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_content_meta_author_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_meta_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_meta',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-post-meta',
			'attribute' => 'margin',
		);

		$this->options['st_meta_author_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Author Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta',
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-author.icon-position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-author.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-author.icon-position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-author.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_meta_date_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Date Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta',
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-date.icon-position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-date.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-date.icon-position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-date.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_meta_author_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Author Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-author i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-author svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_meta_date_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Date Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-date i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-meta-date svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_preload_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_preload',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-preloader-overlay',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_preload_dot_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Dots Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_preload',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-preloader-overlay span',
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
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination',
			'attribute' => 'margin',
		);

		$this->options['st_pagination_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
			'attribute' => 'padding',
		);

		$this->options['st_pagination_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_pagination',
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button a',
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
			'selectors'    => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.icon-position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.icon-position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button svg' => 'width: {{SIZE}}{{UNIT}};',
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
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-nextprev-normal' => 'display: inline-flex; gap: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button svg'                                                                                          => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_pagination_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
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
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
			'attribute' => 'border-radius',
		);

		$this->options['st_pagination_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
		);

		$this->options['st_pagination_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev) a, {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev) svg'                                                                                                => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_pagination_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)',
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
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)',
			'attribute' => 'border-radius',
		);

		$this->options['st_pagination_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)',
		);

		$this->options['st_pagination_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button:hover:not(.jkit-block-nextprev), {{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev a:hover:not(.disabled)',
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
			'selectors'    => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
			'attribute'    => 'opacity',
		);

		$this->options['st_pagination_disabled_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_pagination',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_pagination_disabled_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
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
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
			'attribute' => 'border-radius',
		);

		$this->options['st_pagination_disabled_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
		);

		$this->options['st_pagination_disabled_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_pagination',
			'selectors' => '.jeg-elementor-kit.jkit-postblock .jkit-block-pagination .jkit-pagination-button.jkit-block-nextprev .disabled',
		);

		$this->options['st_pagination_disabled_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_pagination',
		);

		$this->options['st_pagination_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_pagination',
		);

		$this->options['st_meta_bottom_alignment'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_meta_bottom',
			'options'    => array(
				'flex-start'    => esc_html__( 'Left', 'jeg-elementor-kit' ),
				'center'        => esc_html__( 'Center', 'jeg-elementor-kit' ),
				'flex-end'      => esc_html__( 'Right', 'jeg-elementor-kit' ),
				'space-between' => esc_html__( 'Justified', 'jeg-elementor-kit' ),
			),
			'responsive' => true,
			'default'    => 'space-between',
			'selectors'  => '.jeg-elementor-kit.jkit-postblock .jkit-post-meta-bottom',
			'attribute'  => 'justify-content',
		);

		$this->nocontent_style();
		parent::additional_style();
	}
}
