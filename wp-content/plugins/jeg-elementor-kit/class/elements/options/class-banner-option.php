<?php
/**
 * Banner Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Banner_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Banner_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Banner', 'jeg-elementor-kit' );
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
		$this->set_style_option();

		parent::set_options();
	}

	/**
	 * Option segments
	 */
	public function set_segments() {
		$this->segments['segment_banner'] = array(
			'name'     => esc_html__( 'Banner', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->segments['segment_button'] = array(
			'name'     => esc_html__( 'Button', 'jeg-elementor-kit' ),
			'priority' => 11,
		);

		$this->segments['segment_box_sale'] = array(
			'name'     => esc_html__( 'Box Sale', 'jeg-elementor-kit' ),
			'priority' => 12,
		);

		$this->segments['segment_link'] = array(
			'name'     => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'priority' => 13,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_banner'] = array(
			'name'      => esc_html__( 'Banner', 'jeg-elementor-kit' ),
			'priority'  => 10,
			'kit_style' => true,
		);

		$this->segments['style_content'] = array(
			'name'      => esc_html__( 'Content', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_box_sale'] = array(
			'name'      => esc_html__( 'Box Sale', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);
	}

	/**
	 * Option segments
	 */
	public function set_element_options() {
		$this->options['sg_banner_image'] = array(
			'type'    => 'image',
			'title'   => esc_html__( 'Image', 'jeg-elementor-kit' ),
			'segment' => 'segment_banner',
			'default' => \Elementor\Utils::get_placeholder_image_src(),
		);

		$this->options['sg_banner_image_size'] = array(
			'type'    => 'imagesize',
			'title'   => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
			'segment' => 'segment_banner',
		);

		$this->options['sg_banner_title'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'segment' => 'segment_banner',
			'default' => 'Title',
		);

		$this->options['sg_banner_subtitle'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Subtitle', 'jeg-elementor-kit' ),
			'segment' => 'segment_banner',
			'default' => 'Subtitle',
		);

		$this->options['sg_banner_show_description'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Description', 'jeg-elementor-kit' ),
			'default' => '',
			'segment' => 'segment_banner',
		);

		$this->options['sg_banner_description'] = array(
			'type'       => 'wysiwyg',
			'title'      => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'default'    => '',
			'segment'    => 'segment_banner',
			'default'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur blandit sapien lectus, a mollis ante dapibus sit amet. Quisque eget vulputate massa. Orci varius natoque.',
			'dependency' => array(
				array(
					'field'    => 'sg_banner_show_description',
					'operator' => '==',
					'value'    => 'yes',
				),
			),
		);

		$this->options['sg_button_text'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Button Text', 'jeg-elementor-kit' ),
			'segment' => 'segment_button',
			'default' => 'Button',
		);

		$this->options['sg_button_link'] = array(
			'type'    => 'link',
			'title'   => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment' => 'segment_button',
			'url'     => '#',
		);

		$this->options['sg_button_icon_type'] = array(
			'type'    => 'radio',
			'title'   => esc_html__( 'Icon Type', 'jeg-elementor-kit' ),
			'segment' => 'segment_button',
			'default' => 'icon',
			'options' => array(
				'none' => array(
					'title' => esc_html__( 'None', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-ban',
				),
				'icon' => array(
					'title' => esc_html__( 'Icon', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-icons',
				),
			),
		);

		$this->options['sg_button_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Select Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'jki jki-arrow-right-solid',
				'library' => 'jkiticon',
			),
			'segment'    => 'segment_button',
			'dependency' => array(
				array(
					'field'    => 'sg_button_icon_type',
					'operator' => '==',
					'value'    => 'icon',
				),
			),
		);

		$this->options['sg_button_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'options'    => array(
				'before' => esc_html__( 'Before Text', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After Text', 'jeg-elementor-kit' ),
			),
			'default'    => 'after',
			'segment'    => 'segment_button',
			'dependency' => array(
				array(
					'field'    => 'sg_button_icon_type',
					'operator' => '==',
					'value'    => 'icon',
				),
			),
		);

		$this->options['sg_box_sale_before_text'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Before Text', 'jeg-elementor-kit' ),
			'segment' => 'segment_box_sale',
		);

		$this->options['sg_box_sale_text'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Text', 'jeg-elementor-kit' ),
			'segment' => 'segment_box_sale',
		);

		$this->options['sg_box_sale_unit'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Unit', 'jeg-elementor-kit' ),
			'segment' => 'segment_box_sale',
		);

		$this->options['sg_link_type'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Link Type', 'jeg-elementor-kit' ),
			'options' => array(
				'all'         => esc_html__( 'All Banner', 'jeg-elementor-kit' ),
				'only_button' => esc_html__( 'Only Button Text', 'jeg-elementor-kit' ),
			),
			'default' => 'all',
			'segment' => 'segment_link',
		);
	}

	/**
	 * Option segments
	 */
	public function set_style_option() {
		$this->options['st_banner_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_banner',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper',
			'attribute' => 'padding',
		);

		$this->options['st_banner_background_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Background Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_banner',
			'options'    => array(
				''              => esc_html__( 'Default', 'jeg-elementor-kit' ),
				'left top'      => esc_html__( 'Left Top', 'jeg-elementor-kit' ),
				'left center'   => esc_html__( 'Left Center', 'jeg-elementor-kit' ),
				'left bottom'   => esc_html__( 'Left Bottom', 'jeg-elementor-kit' ),
				'right top'     => esc_html__( 'Right Top', 'jeg-elementor-kit' ),
				'right center'  => esc_html__( 'Right Center', 'jeg-elementor-kit' ),
				'right bottom'  => esc_html__( 'Right Bottom', 'jeg-elementor-kit' ),
				'center top'    => esc_html__( 'Center Top', 'jeg-elementor-kit' ),
				'center center' => esc_html__( 'Center Center', 'jeg-elementor-kit' ),
				'center bottom' => esc_html__( 'Center Bottom', 'jeg-elementor-kit' ),
			),
			'default'    => '',
			'selectors'  => '.jeg-elementor-kit.jkit-banner .jkit-banner-image',
			'attribute'  => 'background-position',
			'responsive' => true,
		);

		$this->options['st_banner_background_repeat'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Background Repeat', 'jeg-elementor-kit' ),
			'segment'    => 'style_banner',
			'options'    => array(
				'no-repeat' => esc_html__( 'No-Repeat', 'jeg-elementor-kit' ),
				'repeat'    => esc_html__( 'Repeat', 'jeg-elementor-kit' ),
				'repeat-x'  => esc_html__( 'Repeat-x', 'jeg-elementor-kit' ),
				'repeat-y'  => esc_html__( 'Repeat-y', 'jeg-elementor-kit' ),
			),
			'default'    => 'no-repeat',
			'selectors'  => '.jeg-elementor-kit.jkit-banner .jkit-banner-image',
			'attribute'  => 'background-repeat',
			'responsive' => true,
		);

		$this->options['st_banner_background_size'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Background Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_banner',
			'options'    => array(
				'cover'   => esc_html__( 'Cover', 'jeg-elementor-kit' ),
				'contain' => esc_html__( 'Contain', 'jeg-elementor-kit' ),
				'auto'    => esc_html__( 'Auto', 'jeg-elementor-kit' ),
			),
			'default'    => 'cover',
			'selectors'  => '.jeg-elementor-kit.jkit-banner .jkit-banner-image',
			'attribute'  => 'background-size',
			'responsive' => true,
		);

		$this->options['st_banner_background_overlay'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Overlay', 'jeg-elementor-kit' ),
			'segment'   => 'style_banner',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-image:before',
		);

		$this->options['st_banner_css_filters'] = array(
			'type'      => 'css_filter',
			'title'     => esc_html__( 'CSS Filters', 'jeg-elementor-kit' ),
			'segment'   => 'style_banner',
			'default'   => '',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-image',
		);

		$this->options['st_content_height'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', 'em' ),
			'options'   => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'default'   => 400,
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content',
			'attribute' => 'height',
		);

		$this->options['st_content_text_align'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Text Align', 'jeg-elementor-kit' ),
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
			'selectors'  => '.jeg-elementor-kit.jkit-banner .jkit-banner-content-inner',
			'attribute'  => 'text-align',
			'responsive' => true,
		);

		$this->options['st_content_horizontal_position'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Horizontal Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
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
			'default'    => 'flex-start',
			'selectors'  => '.jeg-elementor-kit.jkit-banner .jkit-banner-content',
			'attribute'  => 'justify-content',
			'toggle'     => false,
			'responsive' => true,
		);

		$this->options['st_content_vertical_position'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Vertical Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'options'    => array(
				'flex-start' => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'jki jki-arrow-alt-circle-up-solid',
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-center',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
					'icon'  => 'jki jki-arrow-alt-circle-down-solid',
				),
			),
			'default'    => 'flex-start',
			'selectors'  => '.jeg-elementor-kit.jkit-banner .jkit-banner-content',
			'attribute'  => 'align-items',
			'toggle'     => false,
			'responsive' => true,
		);

		$this->options['st_content_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content-inner',
		);

		$this->options['st_content_padding_wrapper'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding Wrapper', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content',
			'attribute' => 'padding',
		);

		$this->options['st_content_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding Inner', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content-inner',
			'attribute' => 'padding',
		);

		$this->options['st_content_title_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'separator' => 'before',
		);

		$this->options['st_content_title_spacing'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Spacing', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'options'   => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content .jkit-banner-content-inner .jkit-banner-title',
			'attribute' => 'margin-bottom',
		);

		$this->options['st_content_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content .jkit-banner-content-inner .jkit-banner-title',
		);

		$this->options['st_content_title_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content .jkit-banner-content-inner .jkit-banner-title',
		);

		$this->options['st_content_subtitle_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Subtitle', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'separator' => 'before',
		);

		$this->options['st_content_subtitle_spacing'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Spacing', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'options'   => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content .jkit-banner-content-inner .jkit-banner-subtitle',
			'attribute' => 'margin-bottom',
		);

		$this->options['st_content_subtitle_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content .jkit-banner-content-inner .jkit-banner-subtitle',
		);

		$this->options['st_content_subtitle_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content .jkit-banner-content-inner .jkit-banner-subtitle',
		);

		$this->options['st_content_description_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'separator' => 'before',
		);

		$this->options['st_content_description_spacing'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Spacing', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'options'   => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content .jkit-banner-content-inner .jkit-banner-description',
			'attribute' => 'margin-bottom',
		);

		$this->options['st_content_description_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content .jkit-banner-content-inner .jkit-banner-description',
		);

		$this->options['st_content_description_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content .jkit-banner-content-inner .jkit-banner-description',
		);

		$this->options['st_content_button_link_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Button Link', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'separator' => 'before',
		);

		$this->options['st_content_button_link_spacing'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Spacing', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'options'   => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content .jkit-banner-content-inner .jkit-banner-button-link',
			'attribute' => 'margin-bottom',
		);

		$this->options['st_content_button_link_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content .jkit-banner-content-inner .jkit-banner-button-link',
		);

		$this->options['st_content_button_link_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-content .jkit-banner-content-inner .jkit-banner-button-link',
		);

		$this->options['st_box_sale_before_text'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Before Text', 'jeg-elementor-kit' ),
			'segment'   => 'style_box_sale',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper .jkit-banner-box-sale .jkit-banner-box-sale-before-text',
		);

		$this->options['st_box_sale_text'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Text', 'jeg-elementor-kit' ),
			'segment'   => 'style_box_sale',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper .jkit-banner-box-sale .jkit-banner-box-sale-text',
		);

		$this->options['st_box_sale_text_unit'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Unit', 'jeg-elementor-kit' ),
			'segment'   => 'style_box_sale',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper .jkit-banner-box-sale .jkit-banner-box-sale-unit',
		);

		$this->options['st_box_sale_text_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_box_sale',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper .jkit-banner-box-sale',
			'separator' => 'before',
		);

		$this->options['st_box_sale_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_box_sale',
			'options'   => array(
				'classic',
				'gradient',
			),
			'exclude'   => array( 'image' ),
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper .jkit-banner-box-sale',
		);

		$this->options['st_box_sale_vertical_orientation'] = array(
			'type'      => 'radio',
			'title'     => esc_html__( 'Vertical Orientation', 'jeg-elementor-kit' ),
			'segment'   => 'style_box_sale',
			'options'   => array(
				'top'    => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-top',
				),
				'bottom' => array(
					'title' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
					'icon'  => 'eicon-v-align-bottom',
				),
			),
			'default'   => 'top',
			'toggle'    => false,
			'separator' => 'before',
		);

		$this->options['st_box_sale_spacing_vertical'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Spacing Vertical', 'jeg-elementor-kit' ),
			'segment'   => 'style_box_sale',
			'units'     => array( 'px', '%' ),
			'options'   => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'default'   => 20,
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper .jkit-banner-box-sale',
			'attribute' => '{{st_box_sale_vertical_orientation.VALUE}}',
		);

		$this->options['st_box_sale_horizontal_orientation'] = array(
			'type'    => 'radio',
			'title'   => esc_html__( 'Horizontal Orientation', 'jeg-elementor-kit' ),
			'segment' => 'style_box_sale',
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

		$this->options['st_box_sale_spacing_horizontal'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Spacing Horizontal', 'jeg-elementor-kit' ),
			'segment'   => 'style_box_sale',
			'units'     => array( 'px', '%' ),
			'options'   => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'default'   => 30,
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper .jkit-banner-box-sale',
			'attribute' => '{{st_box_sale_horizontal_orientation.VALUE}}',
		);

		// $this->options['st_box_sale_width'] = array(
		// 'type'      => 'slider',
		// 'title'     => esc_html__( 'Width', 'jeg-elementor-kit' ),
		// 'segment'   => 'style_box_sale',
		// 'units'     => array( 'px', '%' ),
		// 'options'   => array(
		// 'min'  => 0,
		// 'max'  => 500,
		// 'step' => 1,
		// ),
		// 'default'   => 400,
		// 'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper .jkit-banner-box-sale',
		// 'attribute' => 'width',
		// 'separator' => 'before',
		// );

		// $this->options['st_box_sale_height'] = array(
		// 'type'      => 'slider',
		// 'title'     => esc_html__( 'Height', 'jeg-elementor-kit' ),
		// 'segment'   => 'style_box_sale',
		// 'units'     => array( 'px', '%' ),
		// 'options'   => array(
		// 'min'  => 0,
		// 'max'  => 500,
		// 'step' => 1,
		// ),
		// 'default'   => 400,
		// 'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper .jkit-banner-box-sale',
		// 'attribute' => 'height',
		// );

		$this->options['st_box_sale_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_box_sale',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper .jkit-banner-box-sale',
			'attribute' => 'width',
			'separator' => 'before',
		);

		$this->options['st_box_sale_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_box_sale',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper .jkit-banner-box-sale',
			'attribute' => 'border-radius',
		);

		$this->options['st_box_sale_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_box_sale',
			'selectors' => '.jeg-elementor-kit.jkit-banner .jkit-banner-wrapper .jkit-banner-box-sale',
			'attribute' => 'padding',
		);

		parent::additional_style();
	}
}
