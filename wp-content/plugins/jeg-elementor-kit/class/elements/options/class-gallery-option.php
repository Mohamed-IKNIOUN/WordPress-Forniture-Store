<?php
/**
 * Gallery Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Gallery_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Gallery_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Gallery', 'jeg-elementor-kit' );
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

		$this->segments['segment_filter'] = array(
			'name'     => esc_html__( 'Filter', 'jeg-elementor-kit' ),
			'priority' => 12,
		);

		$this->segments['segment_gallery'] = array(
			'name'     => esc_html__( 'Gallery', 'jeg-elementor-kit' ),
			'priority' => 13,
		);

		$this->segments['segment_loadmore'] = array(
			'name'     => esc_html__( 'Load More', 'jeg-elementor-kit' ),
			'priority' => 14,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_container'] = array(
			'name'      => esc_html__( 'Container', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_control'] = array(
			'name'       => esc_html__( 'Control', 'jeg-elementor-kit' ),
			'priority'   => 12,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_setting_filter',
					'operator' => '==',
					'value'    => 'filter',
				),
			),
		);

		$this->segments['style_item'] = array(
			'name'      => esc_html__( 'Item', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_item_hover'] = array(
			'name'      => esc_html__( 'Item Hover', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		$this->segments['style_item_card'] = array(
			'name'       => esc_html__( 'Item Card', 'jeg-elementor-kit' ),
			'priority'   => 15,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_setting_layout!',
					'operator' => '==',
					'value'    => 'overlay',
				),
			),
		);

		$this->segments['style_thumbnail'] = array(
			'name'       => esc_html__( 'Thumbnail', 'jeg-elementor-kit' ),
			'priority'   => 16,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_setting_layout!',
					'operator' => '==',
					'value'    => 'overlay',
				),
			),
		);

		$this->segments['style_video_play'] = array(
			'name'      => esc_html__( 'Video Play Icon', 'jeg-elementor-kit' ),
			'priority'  => 17,
			'kit_style' => true,
		);

		$this->segments['style_icon'] = array(
			'name'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'priority'  => 18,
			'kit_style' => true,
		);

		$this->segments['style_loadmore'] = array(
			'name'      => esc_html__( 'Load More', 'jeg-elementor-kit' ),
			'priority'  => 19,
			'kit_style' => true,
		);

		$this->segments['style_price_rating'] = array(
			'name'      => esc_html__( 'Price & Rating', 'jeg-elementor-kit' ),
			'priority'  => 20,
			'kit_style' => true,
		);

		$this->segments['style_category'] = array(
			'name'      => esc_html__( 'Category', 'jeg-elementor-kit' ),
			'priority'  => 21,
			'kit_style' => true,
		);

		$this->segments['style_search'] = array(
			'name'       => esc_html__( 'Search', 'jeg-elementor-kit' ),
			'priority'   => 22,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_setting_filter',
					'operator' => '==',
					'value'    => 'search',
				),
			),
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_setting_item_show'] = array(
			'type'    => 'slider',
			'title'   => esc_html__( 'Item to Show', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
			'default' => 6,
			'options' => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
		);

		$this->options['sg_setting_duration'] = array(
			'type'    => 'slider',
			'title'   => esc_html__( 'Animation Duration', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
			'default' => 500,
			'options' => array(
				'min'  => 100,
				'max'  => 10000,
				'step' => 1,
			),
		);

		$this->options['sg_setting_column'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Column', 'jeg-elementor-kit' ),
			'segment'    => 'segment_setting',
			'default'    => 3,
			'options'    => array(
				'min'  => 1,
				'max'  => 6,
				'step' => 1,
			),
			'responsive' => true,
		);

		$this->options['sg_setting_grid'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Grid', 'jeg-elementor-kit' ),
			'default' => 'grid',
			'segment' => 'segment_setting',
			'options' => array(
				'grid'    => esc_html__( 'Grid', 'jeg-elementor-kit' ),
				'masonry' => esc_html__( 'Masonry', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_setting_image_height'] = array(
			'type'        => 'slider',
			'title'       => esc_html__( 'Image Height', 'jeg-elementor-kit' ),
			'segment'     => 'segment_setting',
			'default'     => 300,
			'options'     => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive'  => true,
			'selectors'   => '.jeg-elementor-kit.jkit-gallery[data-grid="grid"] .gallery-items .gallery-item-wrap .grid-item .thumbnail-wrap',
			'attribute'   => 'height',
			'render_type' => 'template',
			'dependency'  => array(
				array(
					'field'    => 'sg_setting_grid',
					'operator' => '==',
					'value'    => 'grid',
				),
			),
		);

		$this->options['sg_setting_layout'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Layout', 'jeg-elementor-kit' ),
			'default' => 'overlay',
			'segment' => 'segment_setting',
			'options' => array(
				'overlay' => esc_html__( 'Overlay', 'jeg-elementor-kit' ),
				'card'    => esc_html__( 'Card', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_setting_filter'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Filter', 'jeg-elementor-kit' ),
			'default' => 'filter',
			'segment' => 'segment_setting',
			'options' => array(
				'filter' => esc_html__( 'Filter', 'jeg-elementor-kit' ),
				'search' => esc_html__( 'Search & Filter', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_setting_hover'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Hover Style', 'jeg-elementor-kit' ),
			'default'    => 'overlay',
			'segment'    => 'segment_setting',
			'options'    => array(
				'none'  => esc_html__( 'None', 'jeg-elementor-kit' ),
				'slide' => esc_html__( 'Slide In Up', 'jeg-elementor-kit' ),
				'fade'  => esc_html__( 'Fade In', 'jeg-elementor-kit' ),
				'zoom'  => esc_html__( 'Zoom In', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_setting_layout',
					'operator' => '==',
					'value'    => 'overlay',
				),
			),
		);

		$this->options['sg_setting_hover_transition'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Hover Transition', 'jeg-elementor-kit' ),
			'segment'   => 'segment_setting',
			'default'   => 500,
			'options'   => array(
				'min'  => 100,
				'max'  => 10000,
				'step' => 1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap'                                                              => 'transition: {{SIZE}}ms',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-overlay.overlay-slide .item-caption-over .item-title'   => 'transition: {{SIZE}}ms',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-overlay.overlay-slide .item-caption-over .item-content' => 'transition: {{SIZE}}ms',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-overlay.overlay-zoom .item-caption-over'                => 'transition: {{SIZE}}ms',
				),
			),
		);

		$this->options['sg_setting_link_to'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Link To', 'jeg-elementor-kit' ),
			'default' => 'button',
			'segment' => 'segment_setting',
			'options' => array(
				'none'     => esc_html__( 'None', 'jeg-elementor-kit' ),
				'link'     => esc_html__( 'Link', 'jeg-elementor-kit' ),
				'media'    => esc_html__( 'Media', 'jeg-elementor-kit' ),
				'lightbox' => esc_html__( 'Lightbox', 'jeg-elementor-kit' ),
				'button'   => esc_html__( 'Button', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_setting_link_media_open_tab'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Open New Tab', 'jeg-elementor-kit' ),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_link_to',
					'operator' => '==',
					'value'    => 'media',
				),
			),
		);

		$this->options['sg_setting_link_media_nofollow'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Add Nofollow', 'jeg-elementor-kit' ),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_link_to',
					'operator' => '==',
					'value'    => 'media',
				),
			),
		);

		$this->options['sg_setting_link_media_attribute'] = array(
			'type'        => 'text',
			'title'       => esc_html__( 'Custom Attributes', 'jeg-elementor-kit' ),
			'segment'     => 'segment_setting',
			'description' => esc_html__( 'Set custom attributes for the link element. Separate attribute keys from values using the | (pipe) character. Separate key-value pairs with a comma.', 'jeg-elementor-kit' ),
			'dependency'  => array(
				array(
					'field'    => 'sg_setting_link_to',
					'operator' => '==',
					'value'    => 'media',
				),
			),
		);

		$this->options['sg_setting_icon_lightbox'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Lightbox Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-search-plus',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_link_to',
					'operator' => '==',
					'value'    => 'button',
				),
			),
		);

		$this->options['sg_setting_icon_link'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Link Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-link',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_link_to',
					'operator' => '==',
					'value'    => 'button',
				),
			),
		);

		$this->options['sg_setting_popup_caption'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Pop Up Caption', 'jeg-elementor-kit' ),
			'segment'    => 'segment_setting',
			'dependency' => array(
				array(
					'field'    => 'sg_setting_link_to',
					'operator' => 'in',
					'value'    => array( 'button', 'lightbox' ),
				),
			),
		);

		$this->options['sg_setting_html_tag'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Title HTML Tag', 'jeg-elementor-kit' ),
			'default' => 'h5',
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

		$this->options['sg_filter_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Filter', 'jeg-elementor-kit' ),
			'segment' => 'segment_filter',
		);

		$this->options['sg_filter_all_label'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'All Label', 'jeg-elementor-kit' ),
			'default'    => esc_html__( 'All', 'jeg-elementor-kit' ),
			'segment'    => 'segment_filter',
			'dependency' => array(
				array(
					'field'    => 'sg_filter_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_filter_list'] = array(
			'type'       => 'repeater',
			'title'      => esc_html__( 'Filter List', 'jeg-elementor-kit' ),
			'segment'    => 'segment_filter',
			'fields'     => array(
				'sg_filter_list_name' => array(
					'type'    => 'text',
					'segment' => 'sg_filter_list',
					'title'   => esc_html__( 'Filter Name', 'jeg-elementor-kit' ),
				),
			),
			'default'    => array(
				array(
					'sg_filter_list_name' => esc_html__( 'Gallery Item', 'jeg-elementor-kit' ),
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_filter_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_gallery_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Photo Gallery', 'jeg-elementor-kit' ),
			'default' => 'yes',
			'segment' => 'segment_gallery',
		);

		$this->options['sg_gallery_image_size'] = array(
			'type'       => 'imagesize',
			'title'      => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
			'segment'    => 'segment_gallery',
			'default'    => 'large',
			'dependency' => array(
				array(
					'field'    => 'sg_gallery_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_gallery_list'] = array(
			'type'        => 'repeater',
			'title'       => esc_html__( 'Gallery List', 'jeg-elementor-kit' ),
			'segment'     => 'segment_gallery',
			'title_field' => '{{ sg_gallery_list_item_name }}',
			'fields'      => array(
				'sg_gallery_list_enable_video'     => array(
					'type'    => 'checkbox',
					'title'   => esc_html__( 'Enable Video Gallery', 'jeg-elementor-kit' ),
					'segment' => 'sg_gallery_list',
				),
				'sg_gallery_list_video_link'       => array(
					'type'       => 'link',
					'segment'    => 'sg_gallery_list',
					'title'      => esc_html__( 'Video Link', 'jeg-elementor-kit' ),
					'dependency' => array(
						array(
							'field'    => 'sg_gallery_list_enable_video',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'sg_gallery_list_video_to'         => array(
					'type'       => 'select',
					'title'      => esc_html__( 'Video Play Link to', 'jeg-elementor-kit' ),
					'default'    => 'lightbox',
					'segment'    => 'sg_gallery_list',
					'options'    => array(
						'link'     => esc_html__( 'Link', 'jeg-elementor-kit' ),
						'lightbox' => esc_html__( 'Lightbox', 'jeg-elementor-kit' ),
					),
					'dependency' => array(
						array(
							'field'    => 'sg_gallery_list_enable_video',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'sg_gallery_list_video_icon'       => array(
					'type'       => 'iconpicker',
					'title'      => esc_html__( 'Video Play Icon', 'jeg-elementor-kit' ),
					'default'    => array(
						'value'   => 'far fa-play-circle',
						'library' => 'fa-regular',
					),
					'segment'    => 'sg_gallery_list',
					'dependency' => array(
						array(
							'field'    => 'sg_gallery_list_enable_video',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'sg_gallery_list_control_name'     => array(
					'type'        => 'text',
					'segment'     => 'sg_gallery_list',
					'title'       => esc_html__( 'Control Name', 'jeg-elementor-kit' ),
					'description' => esc_html__( 'For Multi Control Name, please separate it with a comma.', 'jeg-elementor-kit' ),
				),
				'sg_gallery_list_item_name'        => array(
					'type'    => 'text',
					'segment' => 'sg_gallery_list',
					'title'   => esc_html__( 'Item Name', 'jeg-elementor-kit' ),
				),
				'sg_gallery_list_enable_price'     => array(
					'type'    => 'checkbox',
					'title'   => esc_html__( 'Enable Price', 'jeg-elementor-kit' ),
					'segment' => 'sg_gallery_list',
				),
				'sg_gallery_list_price'            => array(
					'type'       => 'text',
					'segment'    => 'sg_gallery_list',
					'title'      => esc_html__( 'Price', 'jeg-elementor-kit' ),
					'dependency' => array(
						array(
							'field'    => 'sg_gallery_list_enable_price',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'sg_gallery_list_enable_rating'    => array(
					'type'    => 'checkbox',
					'title'   => esc_html__( 'Enable Rating', 'jeg-elementor-kit' ),
					'segment' => 'sg_gallery_list',
				),
				'sg_gallery_list_rating_icon_full' => array(
					'type'       => 'iconpicker',
					'title'      => esc_html__( 'Star Rating Full', 'jeg-elementor-kit' ),
					'segment'    => 'sg_gallery_list',
					'default'    => array(
						'value'   => 'fas fa-star',
						'library' => 'fa-solid',
					),
					'dependency' => array(
						array(
							'field'    => 'sg_gallery_list_enable_rating',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'sg_gallery_list_rating_icon_half' => array(
					'type'       => 'iconpicker',
					'title'      => esc_html__( 'Star Rating Half', 'jeg-elementor-kit' ),
					'segment'    => 'sg_gallery_list',
					'default'    => array(
						'value'   => 'fas fa-star-half',
						'library' => 'fa-solid',
					),
					'dependency' => array(
						array(
							'field'    => 'sg_gallery_list_enable_rating',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'sg_gallery_list_rating'           => array(
					'type'       => 'slider',
					'title'      => esc_html__( 'Rating', 'jeg-elementor-kit' ),
					'default'    => 5,
					'segment'    => 'sg_gallery_list',
					'options'    => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.5,
					),
					'dependency' => array(
						array(
							'field'    => 'sg_gallery_list_enable_rating',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'sg_gallery_list_enable_category'  => array(
					'type'    => 'checkbox',
					'title'   => esc_html__( 'Enable Category', 'jeg-elementor-kit' ),
					'segment' => 'sg_gallery_list',
				),
				'sg_gallery_list_category'         => array(
					'type'       => 'text',
					'segment'    => 'sg_gallery_list',
					'title'      => esc_html__( 'Category', 'jeg-elementor-kit' ),
					'dependency' => array(
						array(
							'field'    => 'sg_gallery_list_enable_category',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'sg_gallery_list_content'          => array(
					'type'    => 'wysiwyg',
					'segment' => 'sg_gallery_list',
					'title'   => esc_html__( 'Item Content', 'jeg-elementor-kit' ),
				),
				'sg_gallery_list_image'            => array(
					'type'    => 'image',
					'segment' => 'sg_gallery_list',
					'title'   => esc_html__( 'Image', 'jeg-elementor-kit' ),
				),
				'sg_gallery_list_enable_lightbox'  => array(
					'type'       => 'checkbox',
					'title'      => esc_html__( 'Enable Lightbox', 'jeg-elementor-kit' ),
					'default'    => 'yes',
					'segment'    => 'sg_gallery_list',
					'dependency' => array(
						array(
							'field'    => 'sg_gallery_list_enable_video!',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'sg_gallery_list_enable_link'      => array(
					'type'       => 'checkbox',
					'title'      => esc_html__( 'Link Button', 'jeg-elementor-kit' ),
					'default'    => 'yes',
					'segment'    => 'sg_gallery_list',
					'dependency' => array(
						array(
							'field'    => 'sg_gallery_list_enable_video!',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'sg_gallery_list_link'             => array(
					'type'       => 'link',
					'segment'    => 'sg_gallery_list',
					'title'      => esc_html__( 'Link Button', 'jeg-elementor-kit' ),
					'dependency' => array(
						array(
							'field'    => 'sg_gallery_list_enable_link',
							'operator' => '==',
							'value'    => true,
						),
						array(
							'field'    => 'sg_gallery_list_enable_video!',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
			),
			'default'     => array(
				array(
					'sg_gallery_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_gallery_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_gallery_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_gallery_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_gallery_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
			),
			'dependency'  => array(
				array(
					'field'    => 'sg_gallery_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_loadmore_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Load More', 'jeg-elementor-kit' ),
			'segment' => 'segment_loadmore',
		);

		$this->options['sg_loadmore_item_show'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Items per Page', 'jeg-elementor-kit' ),
			'segment'    => 'segment_loadmore',
			'default'    => 6,
			'options'    => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'dependency' => array(
				array(
					'field'    => 'sg_loadmore_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_loadmore_button_text'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Button Text', 'jeg-elementor-kit' ),
			'segment'    => 'segment_loadmore',
			'default'    => esc_html__( 'Load More', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_loadmore_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_loadmore_nomore_text'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'No More Text', 'jeg-elementor-kit' ),
			'segment'    => 'segment_loadmore',
			'default'    => esc_html__( 'No More Item', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_loadmore_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_loadmore_button_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Button Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_loadmore',
			'dependency' => array(
				array(
					'field'    => 'sg_loadmore_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_loadmore_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_loadmore',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_loadmore_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_loadmore_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'segment_loadmore',
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
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .load-more-items',
			'attribute'  => 'text-align',
			'dependency' => array(
				array(
					'field'    => 'sg_loadmore_enable',
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
		$this->options['st_container_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-gallery',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_container_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery',
			'attribute' => 'padding',
		);

		$this->options['st_container_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery',
			'attribute' => 'margin',
		);

		$this->options['st_container_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery',
			'attribute' => 'border-radius',
		);

		$this->options['st_container_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-gallery',
		);

		$this->options['st_container_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-gallery',
		);

		$this->options['st_control_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li',
			'attribute' => 'padding',
		);

		$this->options['st_control_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li',
			'attribute' => 'margin',
		);

		$this->options['st_control_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li',
		);

		$this->options['st_control_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_control',
		);

		$this->options['st_control_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'General', 'jeg-elementor-kit' ),
			'segment' => 'style_control',
		);

		$this->options['st_control_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'General Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_control',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li',
		);

		$this->options['st_control_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_control_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li',
			'attribute' => 'border-radius',
		);

		$this->options['st_control_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li',
		);

		$this->options['st_control_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li',
		);

		$this->options['st_control_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_control',
		);

		$this->options['st_control_active_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Active', 'jeg-elementor-kit' ),
			'segment' => 'style_control',
		);

		$this->options['st_control_active_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Active Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_control',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li.active',
		);

		$this->options['st_control_active_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Active Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li.active',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_control_active_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Active Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li.active',
			'attribute' => 'border-radius',
		);

		$this->options['st_control_active_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Active Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li.active',
		);

		$this->options['st_control_active_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Active Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .filter-controls ul li.active',
		);

		$this->options['st_control_active_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_control',
		);

		$this->options['st_control_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_control',
		);

		$this->options['st_item_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_item',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item',
			'attribute' => 'padding',
		);

		$this->options['st_item_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_item',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item',
			'attribute' => 'margin',
		);

		$this->options['st_item_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_item',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item',
			'attribute' => 'border-radius',
		);

		$this->options['st_item_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_item',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item',
		);

		$this->options['st_item_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_item',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_item_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_item',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item',
		);

		$this->options['st_item_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_hover',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-hover-bg, {{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap:hover .grid-item .caption-wrap.style-overlay',
			),
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_item_hover_opacity'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Opacity', 'jeg-elementor-kit' ),
			'segment'    => 'style_item_hover',
			'options'    => array(
				'min'  => 0,
				'max'  => 1,
				'step' => 0.1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap:hover .grid-item .caption-wrap.style-overlay' => 'opacity: {{SIZE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-hover-bg'      => 'opacity: {{SIZE}};',
				),
			),
		);

		$this->options['st_item_hover_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_hover',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
			'attribute' => 'padding',
		);

		$this->options['st_item_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_hover',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-hover-bg',
			),
		);

		$this->options['st_item_hover_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_item_hover',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-overlay .item-caption-over' => 'text-align: {{VALUE}};',
				),
			),
		);

		$this->options['st_item_title_typography_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Title Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_hover',
			'separator' => 'before',
		);

		$this->options['st_item_title_typography_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_item_hover',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-overlay .item-caption-over .item-title' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_item_title_typography_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_item_hover',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-overlay .item-caption-over .item-title:hover' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_item_title_typography_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_hover',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-overlay .item-caption-over .item-title',
			),
		);

		$this->options['st_item_content_typography_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Content Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_hover',
			'separator' => 'before',
		);

		$this->options['st_item_content_typography_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_item_hover',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-overlay .item-caption-over .item-content' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_item_content_typography_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_item_hover',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-overlay .item-caption-over .item-content:hover' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_item_content_typography_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_hover',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-overlay .item-caption-over .item-content',
			),
		);

		$this->options['st_video_play_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_video_play',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', 'em' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .video-wrap a'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .video-wrap a svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_video_play_icon_size_hover'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size Hover', 'jeg-elementor-kit' ),
			'segment'    => 'style_video_play',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', 'em' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap:hover .grid-item .video-wrap a'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap:hover .grid-item .video-wrap a svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_video_play_icon_transition'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Icon Transition', 'jeg-elementor-kit' ),
			'segment'   => 'style_video_play',
			'default'   => 500,
			'options'   => array(
				'min'  => 100,
				'max'  => 10000,
				'step' => 1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap:hover .grid-item .video-wrap a' => 'transition: {{SIZE}}ms;',
				),
			),
		);

		$this->options['st_video_play_icon_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_video_play',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .video-wrap a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .video-wrap svg' => 'fill: {{VALUE}};',
				),
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

		$this->options['st_icon_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-caption-over .item-buttons a span, {{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-button .item-buttons a span',
			),
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_icon_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-caption-over .item-buttons a span'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-button .item-buttons a span'                      => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-caption-over .item-buttons a span svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-button .item-buttons a span svg'                  => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_normal_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-caption-over .item-buttons a span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-button .item-buttons a span'                  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_icon_normal_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-caption-over .item-buttons a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-button .item-buttons a'                  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_icon_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-caption-over .item-buttons a span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-button .item-buttons a span'                  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_icon_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-caption-over .item-buttons a span, {{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-button .item-buttons a span',
			),
		);

		$this->options['st_icon_normal_font_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Normal Icon Font Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'units'      => array( 'px', 'em' ),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .item-buttons a span'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .item-buttons a span svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
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

		$this->options['st_icon_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-caption-over .item-buttons a span:hover, {{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-button .item-buttons a span:hover',
			),
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_icon_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-caption-over .item-buttons a span:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-button .item-buttons a span:hover'                      => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-caption-over .item-buttons a span:hover svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-button .item-buttons a span:hover svg'                  => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-caption-over .item-buttons a span:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-button .item-buttons a span:hover'                  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
			'attribute' => 'border-radius',
		);

		$this->options['st_icon_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .item-caption-over .item-buttons a span:hover, {{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-button .item-buttons a span:hover',
			),
		);

		$this->options['st_icon_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_icon',
		);

		$this->options['st_icon_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_icon',
		);

		$this->options['st_loadmore_margin_top'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Top', 'jeg-elementor-kit' ),
			'segment'    => 'style_loadmore',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .load-more-items',
			'attribute'  => 'margin-top',
		);

		$this->options['st_loadmore_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_loadmore',
		);

		$this->options['st_loadmore_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_loadmore',
		);

		$this->options['st_loadmore_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_loadmore',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_loadmore_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_loadmore',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_loadmore_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_loadmore',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more',
			'attribute' => 'border-radius',
		);

		$this->options['st_loadmore_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_loadmore',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more',
		);

		$this->options['st_loadmore_normal_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Normal Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_loadmore',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more',
		);

		$this->options['st_loadmore_normal_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Normal Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_loadmore',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more .load-more-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more .load-more-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_loadmore_normal_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Normal Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_loadmore',
			'units'      => array( 'px', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more .load-more-icon.icon-position-before, {{WRAPPER}} .jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more .load-more-icon.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more .load-more-icon.icon-position-after, {{WRAPPER}} .jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more .load-more-icon.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_loadmore_normal_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_loadmore',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more',
			'attribute' => 'padding',
		);

		$this->options['st_loadmore_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_loadmore',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more',
		);

		$this->options['st_loadmore_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_loadmore',
		);

		$this->options['st_loadmore_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_loadmore',
		);

		$this->options['st_loadmore_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_loadmore',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_loadmore_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_loadmore',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_loadmore_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_loadmore',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_loadmore_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_loadmore',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .load-more-items .jkit-gallery-load-more:hover',
		);

		$this->options['st_loadmore_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_loadmore',
		);

		$this->options['st_loadmore_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_loadmore',
		);

		$this->options['st_thumbnail_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery.layout-card .gallery-items .gallery-item-wrap .grid-item .thumbnail-wrap',
			'attribute' => 'border-radius',
		);

		$this->options['st_thumbnail_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_thumbnail',
			'selectors' => '.jeg-elementor-kit.jkit-gallery.layout-card .gallery-items .gallery-item-wrap .grid-item .thumbnail-wrap',
		);

		$this->options['st_item_card_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_card',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-card',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_item_card_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_card',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-card',
			'attribute' => 'padding',
		);

		$this->options['st_item_card_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_card',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-card',
			'attribute' => 'border-radius',
		);

		$this->options['st_item_card_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_card',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-card',
		);

		$this->options['st_item_card_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_card',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-card',
		);

		$this->options['st_item_card_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_item_card',
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
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-card',
			'attribute'  => 'text-align',
		);

		$this->options['st_item_card_title_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Title Typography', 'jeg-elementor-kit' ),
			'segment' => 'style_item_card',
		);

		$this->options['st_item_card_title_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Title Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_item_card',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-card .item-caption-over .item-title',
		);

		$this->options['st_item_card_title_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Title Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_item_card',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-card .item-caption-over .item-title:hover',
		);

		$this->options['st_item_card_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_card',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-card .item-caption-over .item-title',
		);

		$this->options['st_item_card_content_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Content Typography', 'jeg-elementor-kit' ),
			'segment' => 'style_item_card',
		);

		$this->options['st_item_card_content_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Content Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_item_card',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-card .item-caption-over .item-content',
		);

		$this->options['st_item_card_content_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Title Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_item_card',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-card .item-caption-over .item-content:hover',
		);

		$this->options['st_item_card_content_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_item_card',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap.style-card .item-caption-over .item-content',
		);

		$this->options['st_price_rating_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_price_rating',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .caption-head',
			'attribute' => 'padding',
		);

		$this->options['st_price_rating_price_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Price', 'jeg-elementor-kit' ),
			'segment'   => 'style_price_rating',
			'separator' => 'before',
		);

		$this->options['st_price_rating_price_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_price_rating',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .caption-head .item-price',
		);

		$this->options['st_price_rating_price_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_price_rating',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .caption-head .item-price',
		);

		$this->options['st_price_rating_rating_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Rating', 'jeg-elementor-kit' ),
			'segment'   => 'style_price_rating',
			'separator' => 'before',
		);

		$this->options['st_price_rating_rating_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_price_rating',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .caption-head .item-rating',
		);

		$this->options['st_price_rating_rating_star_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Star Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_price_rating',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .caption-head .item-rating li'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .caption-head .item-rating li svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_price_rating_rating_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_price_rating',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .caption-head .item-rating',
		);

		$this->options['st_price_rating_rating_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Start Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_price_rating',
			'units'      => array( 'px', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .caption-head .item-rating i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-wrap .caption-head .item-rating svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_category_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_category',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-category span',
		);

		$this->options['st_category_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-category span',
		);

		$this->options['st_category_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-category span',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_category_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-category span',
			'attribute' => 'margin',
		);

		$this->options['st_category_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-category span',
			'attribute' => 'padding',
		);

		$this->options['st_category_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_category',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .gallery-items .gallery-item-wrap .grid-item .caption-category span',
			'attribute' => 'border-radius',
		);

		$this->options['st_search_control_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Controls', 'jeg-elementor-kit' ),
			'segment' => 'style_search',
		);

		$this->options['st_search_control_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger span',
		);

		$this->options['st_search_control_icon'] = array(
			'type'    => 'iconpicker',
			'title'   => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'default' => array(
				'value'   => 'fas fa-angle-down',
				'library' => 'fa-solid',
			),
			'segment' => 'style_search',
		);

		$this->options['st_search_control_icon_position'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default' => 'after',
			'segment' => 'style_search',
			'options' => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
		);

		$this->options['st_search_control_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_search',
			'units'      => array( 'px', 'em' ),
			'default'    => 10,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger.icon-position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger.icon-position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger.icon-position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger.icon-position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_search_control_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_search',
			'units'      => array( 'px', 'em' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_search_control_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_search',
			'units'      => array( 'px', '%' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap',
			'attribute'  => 'flex-basis',
		);

		$this->options['st_search_control_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_search',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_search_control_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger',
			'attribute' => 'border-radius',
		);

		$this->options['st_search_control_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap',
			'attribute' => 'margin',
		);

		$this->options['st_search_control_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger',
		);

		$this->options['st_search_separator_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Separator', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'separator' => 'before',
		);

		$this->options['st_search_separator_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Separator Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_search',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger',
			'attribute'  => 'border-right-width',
		);

		$this->options['st_search_separator_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Separator Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_search',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap button.search-filter-trigger',
			'attribute'  => 'border-right-color',
		);

		$this->options['st_search_form_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Form', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'separator' => 'before',
		);

		$this->options['st_search_form_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .jkit-gallery-search-box',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_search_form_placeholder'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Placeholder', 'jeg-elementor-kit' ),
			'default' => esc_html__( 'Search Gallery Item...', 'jeg-elementor-kit' ),
			'segment' => 'style_search',
		);

		$this->options['st_search_form_placeholder_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_search',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .jkit-gallery-search-box input::placeholder',
		);

		$this->options['st_search_form_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_search',
			'units'      => array( 'px', '%' ),
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .jkit-gallery-search-box',
			'attribute'  => 'flex-basis',
		);

		$this->options['st_search_form_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'units'     => array( 'px', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .jkit-gallery-search-box',
			'attribute' => 'border-radius',
		);

		$this->options['st_search_form_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .jkit-gallery-search-box',
		);

		$this->options['st_search_dropdown_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Dropdown', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'separator' => 'before',
		);

		$this->options['st_search_dropdown_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_search',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap ul.search-filter-controls li',
		);

		$this->options['st_search_dropdown_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_search',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap ul.search-filter-controls li:hover',
		);

		$this->options['st_search_dropdown_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap ul.search-filter-controls',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_search_dropdown_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'selectors' => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap ul.search-filter-controls li',
		);

		$this->options['st_search_dropdown_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'units'     => array( 'px', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap ul.search-filter-controls li',
			'attribute' => 'padding',
		);

		$this->options['st_search_dropdown_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_search',
			'units'     => array( 'px', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-gallery .search-filters-wrap .filter-wrap ul.search-filter-controls',
			'attribute' => 'border-radius',
		);

		parent::additional_style();
	}
}
