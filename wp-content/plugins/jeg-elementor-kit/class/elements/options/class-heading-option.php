<?php
/**
 * Heading Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Heading_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Heading_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Heading', 'jeg-elementor-kit' );
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
		$this->segments['segment_title'] = array(
			'name'     => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->segments['segment_subtitle'] = array(
			'name'     => esc_html__( 'Subtitle', 'jeg-elementor-kit' ),
			'priority' => 11,
		);

		$this->segments['segment_description'] = array(
			'name'     => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'priority' => 12,
		);

		$this->segments['segment_shadow'] = array(
			'name'     => esc_html__( 'Shadow Text', 'jeg-elementor-kit' ),
			'priority' => 13,
		);

		$this->segments['segment_separator'] = array(
			'name'     => esc_html__( 'Separator', 'jeg-elementor-kit' ),
			'priority' => 14,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_general'] = array(
			'name'      => esc_html__( 'General', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_title'] = array(
			'name'      => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_focused'] = array(
			'name'      => esc_html__( 'Focused Title', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_subtitle'] = array(
			'name'       => esc_html__( 'Subtitle', 'jeg-elementor-kit' ),
			'priority'   => 14,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_description'] = array(
			'name'       => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'priority'   => 15,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_description_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_separator'] = array(
			'name'       => esc_html__( 'Separator', 'jeg-elementor-kit' ),
			'priority'   => 16,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_shadow'] = array(
			'name'       => esc_html__( 'Shadow Text', 'jeg-elementor-kit' ),
			'priority'   => 17,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_shadow_enable',
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
		$this->options['sg_title_concept'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Concept', 'jeg-elementor-kit' ),
			'default' => 'default',
			'segment' => 'segment_title',
			'options' => array(
				'default'   => 'Default',
				'highlight' => 'Highlight',
			),
		);

		$this->options['sg_title_before'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Before Focused Title', 'jeg-elementor-kit' ),
			'segment'    => 'segment_title',
			'default'    => esc_html__( 'Trending ', 'jeg-elementor-kit' ),
			'dependency' => array(
				'custom' => array(
					'terms' => array(
						array(
							'name'     => 'sg_title_concept',
							'operator' => 'in',
							'value'    => array( '', 'default' ),
						),
					),
				),
			),
		);

		$this->options['sg_title_focused'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Focused Title', 'jeg-elementor-kit' ),
			'segment'    => 'segment_title',
			'default'    => esc_html__( 'Stories', 'jeg-elementor-kit' ),
			'dependency' => array(
				'custom' => array(
					'terms' => array(
						array(
							'name'     => 'sg_title_concept',
							'operator' => 'in',
							'value'    => array( '', 'default' ),
						),
					),
				),
			),
		);

		$this->options['sg_title_after'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'After Focused Title', 'jeg-elementor-kit' ),
			'segment'    => 'segment_title',
			'dependency' => array(
				'custom' => array(
					'terms' => array(
						array(
							'name'     => 'sg_title_concept',
							'operator' => 'in',
							'value'    => array( '', 'default' ),
						),
					),
				),
			),
		);

		$this->options['sg_title_text'] = array(
			'type'        => 'text',
			'title'       => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'segment'     => 'segment_title',
			'default'     => esc_html__( 'Trending Stories And Another Stories', 'jeg-elementor-kit' ),
			'dependency'  => array(
				array(
					'field'    => 'sg_title_concept',
					'operator' => '==',
					'value'    => 'highlight',
				),
			),
			'description' => esc_html__( 'Use the {{text}} format for focused text.', 'jeg-elementor-kit' ),
		);

		$this->options['sg_title_html_tag'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'HTML Tag', 'jeg-elementor-kit' ),
			'default' => 'h2',
			'segment' => 'segment_title',
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

		$this->options['sg_title_focused_title_display'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Focused Title Display', 'jeg-elementor-kit' ),
			'default' => 'inline-block',
			'segment' => 'segment_title',
			'options' => array(
				'inline'       => 'Inline',
				'inline-block' => 'Inline Block',
			),
		);

		$this->options['sg_title_border_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Border', 'jeg-elementor-kit' ),
			'segment' => 'segment_title',
		);

		$this->options['sg_title_border_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Border Position', 'jeg-elementor-kit' ),
			'default'    => 'start',
			'segment'    => 'segment_title',
			'options'    => array(
				'start' => esc_html__( 'Start', 'jeg-elementor-kit' ),
				'end'   => esc_html__( 'End', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_title_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_title_float_left'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Float Left', 'jeg-elementor-kit' ),
			'segment' => 'segment_title',
		);

		$this->options['sg_title_width'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Title Width', 'jeg-elementor-kit' ),
			'segment'      => 'segment_title',
			'options'      => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive'   => true,
			'units'        => array( 'px', '%' ),
			'default_unit' => '%',
			'selectors'    => '.jeg-elementor-kit.jkit-heading.title-float-left .jkit-heading-title-wrapper',
			'attribute'    => 'width',
			'dependency'   => array(
				array(
					'field'    => 'sg_title_float_left',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_subtitle_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Subtitle', 'jeg-elementor-kit' ),
			'segment' => 'segment_subtitle',
		);

		$this->options['sg_subtitle_border_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Border Subtitle', 'jeg-elementor-kit' ),
			'segment'    => 'segment_subtitle',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_subtitle_outline_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Show Outline', 'jeg-elementor-kit' ),
			'segment'    => 'segment_subtitle',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_subtitle_border_enable!',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_subtitle_heading'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Heading Sub Title', 'jeg-elementor-kit' ),
			'segment'    => 'segment_subtitle',
			'default'    => esc_html__( 'Lorem ipsum dolor set amet', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_subtitle_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Subtitle Position', 'jeg-elementor-kit' ),
			'default'    => 'after',
			'segment'    => 'segment_subtitle',
			'options'    => array(
				'before' => esc_html__( 'Before Title', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After Title', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_title_float_left!',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_subtitle_html_tag'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'HTML Tag', 'jeg-elementor-kit' ),
			'default'    => 'h3',
			'segment'    => 'segment_subtitle',
			'options'    => array(
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
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_description_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Description', 'jeg-elementor-kit' ),
			'segment' => 'segment_description',
		);

		$this->options['sg_description'] = array(
			'type'       => 'wysiwyg',
			'title'      => esc_html__( 'Heading Description', 'jeg-elementor-kit' ),
			'default'    => esc_html__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'jeg-elementor-kit' ),
			'segment'    => 'segment_description',
			'dependency' => array(
				array(
					'field'    => 'sg_description_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_description_max_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Maximum Width', 'jeg-elementor-kit' ),
			'segment'    => 'segment_description',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-description',
			'attribute'  => 'max-width',
			'dependency' => array(
				array(
					'field'    => 'sg_description_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_shadow_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Shadow Text', 'jeg-elementor-kit' ),
			'segment' => 'segment_shadow',
		);

		$this->options['sg_shadow_content'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Content', 'jeg-elementor-kit' ),
			'segment'    => 'segment_shadow',
			'default'    => esc_html__( 'news', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_shadow_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_separator_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Separator', 'jeg-elementor-kit' ),
			'default' => 'yes',
			'segment' => 'segment_separator',
		);

		$this->options['sg_separator_style'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Separator Style', 'jeg-elementor-kit' ),
			'default'    => 'dotted',
			'segment'    => 'segment_separator',
			'options'    => array(
				'dotted'       => esc_html__( 'Dotted', 'jeg-elementor-kit' ),
				'solid'        => esc_html__( 'Solid', 'jeg-elementor-kit' ),
				'solid-star'   => esc_html__( 'Solid with Star', 'jeg-elementor-kit' ),
				'solid-bullet' => esc_html__( 'Solid with Bullet', 'jeg-elementor-kit' ),
				'custom'       => esc_html__( 'Custom', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_separator_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Separator Style', 'jeg-elementor-kit' ),
			'default'    => 'after',
			'segment'    => 'segment_separator',
			'options'    => array(
				'top'    => esc_html__( 'Top', 'jeg-elementor-kit' ),
				'before' => esc_html__( 'Before Title', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After Title', 'jeg-elementor-kit' ),
				'bottom' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_separator_image'] = array(
			'type'       => 'image',
			'title'      => esc_html__( 'Choose Image ', 'jeg-elementor-kit' ),
			'segment'    => 'segment_separator',
			'dependency' => array(
				array(
					'field'    => 'sg_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_separator_style',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['sg_separator_image_size'] = array(
			'type'       => 'imagesize',
			'title'      => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
			'segment'    => 'segment_separator',
			'default'    => 'thumbnail',
			'dependency' => array(
				array(
					'field'    => 'sg_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_separator_style',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_general_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_general',
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
			'selectors'  => '.jeg-elementor-kit.jkit-heading',
			'attribute'  => 'text-align',
		);

		$this->options['st_title_inline_background'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Inline Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'default'   => '',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-heading .heading-title' => '-webkit-box-decoration-break: clone; box-decoration-break: clone; display: inline;',
				),
			),
		);

		$this->options['st_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-title',
		);

		$this->options['st_title_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-title',
		);

		$this->options['st_title_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-section-title .heading-title',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_title_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-section-title',
			'attribute' => 'margin',
		);

		$this->options['st_title_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-section-title .heading-title',
			'attribute' => 'padding',
		);

		$this->options['st_title_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-section-title .heading-title',
			'attribute' => 'border-radius',
		);

		$this->options['st_title_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-section-title .heading-title',
		);

		$this->options['st_title_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-section-title .heading-title',
		);

		$this->options['st_title_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-title',
		);

		$this->options['st_title_border_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_title_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_title_border_color'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Border Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-title.border-enable:before',
			'options'    => array(
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_title_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_title_border_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'default'    => 4,
			'options'    => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
			'responsive' => true,
			'units'      => array( 'px', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-title.border-enable:before',
			'attribute'  => 'width',
			'dependency' => array(
				array(
					'field'    => 'sg_title_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_title_border_height'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'      => 'style_title',
			'default'      => 100,
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive'   => true,
			'units'        => array( 'px', '%', 'em' ),
			'default_unit' => '%',
			'selectors'    => '.jeg-elementor-kit.jkit-heading .heading-section-title.border-enable:before',
			'attribute'    => 'height',
			'dependency'   => array(
				array(
					'field'    => 'sg_title_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_title_border_vertical_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Vertical Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'default'    => 0,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-title.border-enable:before',
			'attribute'  => 'top',
			'dependency' => array(
				array(
					'field'    => 'sg_title_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_title_border_left_gap'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Left Gap', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'default'    => 30,
			'options'    => array(
				'min'  => 0,
				'max'  => 150,
				'step' => 1,
			),
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-title.border-enable.end .heading-title',
			'attribute'  => 'margin-right',
			'dependency' => array(
				array(
					'field'    => 'sg_title_border_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_title_border_position',
					'operator' => '==',
					'value'    => 'end',
				),
			),
		);

		$this->options['st_title_border_right_gap'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Right Gap', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'default'    => 30,
			'options'    => array(
				'min'  => 0,
				'max'  => 150,
				'step' => 1,
			),
			'responsive' => true,
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-title.border-enable.start .heading-title',
			'attribute'  => 'margin-left',
			'dependency' => array(
				array(
					'field'    => 'sg_title_border_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_title_border_position',
					'operator' => '==',
					'value'    => 'start',
				),
			),
		);

		$this->options['st_focused_color_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Color Style', 'jeg-elementor-kit' ),
			'default' => 'color',
			'segment' => 'style_focused',
			'options' => array(
				'color'    => 'Color',
				'gradient' => 'Gradient',
			),
		);

		$this->options['st_focused_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_focused',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-title > span',
			'dependency' => array(
				array(
					'field'    => 'st_focused_color_style',
					'operator' => '==',
					'value'    => 'color',
				),
			),
		);

		$this->options['st_focused_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_focused',
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-title > span',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'st_focused_color_style',
					'operator' => '==',
					'value'    => 'color',
				),
			),
		);

		$this->options['st_focused_gradient_color'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_focused',
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-title > span.style-gradient',
			'options'    => array(
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'st_focused_color_style',
					'operator' => '==',
					'value'    => 'gradient',
				),
			),
		);

		$this->options['st_focused_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_focused',
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-title > span',
		);

		$this->options['st_focused_text_decoration_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Text Decoration Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_focused',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-title > span',
			'attribute'  => 'text-decoration-color',
		);

		$this->options['st_focused_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_focused',
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-title > span',
		);

		$this->options['st_focused_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_focused',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-title > span',
			'attribute' => 'padding',
		);

		$this->options['st_subtitle_color_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Color Style', 'jeg-elementor-kit' ),
			'default' => 'color',
			'segment' => 'style_subtitle',
			'options' => array(
				'color'    => 'Color',
				'gradient' => 'Gradient',
			),
		);

		$this->options['st_subtitle_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle',
			'dependency' => array(
				array(
					'field'    => 'st_subtitle_color_style',
					'operator' => '==',
					'value'    => 'color',
				),
			),
		);

		$this->options['st_subtitle_gradient_color'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle.style-gradient',
			'options'    => array(
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'st_subtitle_color_style',
					'operator' => '==',
					'value'    => 'gradient',
				),
			),
		);

		$this->options['st_subtitle_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_subtitle',
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle',
		);

		$this->options['st_subtitle_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_subtitle',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle',
			'attribute' => 'margin',
		);

		$this->options['st_subtitle_border_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_border_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'default'    => 3,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-heading .heading-section-subtitle.border-enable:before' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-heading .heading-section-subtitle.border-enable:after'  => 'height: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_border_vertical_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Vertical Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'options'    => array(
				'min'  => -20,
				'max'  => 20,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-heading .heading-section-subtitle.border-enable:before' => 'transform: -webkit-transform: translateY({{SIZE}}{{UNIT}}); -o-transform: translateY({{SIZE}}{{UNIT}}); -moz-transform: translateY({{SIZE}}{{UNIT}}); -ms-transform: translateY({{SIZE}}{{UNIT}}); transform: translateY({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-heading .heading-section-subtitle.border-enable:after'  => 'transform: -webkit-transform: translateY({{SIZE}}{{UNIT}}); -o-transform: translateY({{SIZE}}{{UNIT}}); -moz-transform: translateY({{SIZE}}{{UNIT}}); -ms-transform: translateY({{SIZE}}{{UNIT}}); transform: translateY({{SIZE}}{{UNIT}});',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_border_left_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Border Left', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_border_left_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle.border-enable:before',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_border_left_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'default'    => 40,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle.border-enable:before',
			'attribute'  => 'width',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_border_left_margin'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle.border-enable:before',
			'attribute'  => 'margin',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_border_right_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Border Right', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_border_right_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle.border-enable:after',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_border_right_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'default'    => 40,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle.border-enable:after',
			'attribute'  => 'width',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_border_right_margin'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle.border-enable:after',
			'attribute'  => 'margin',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_border_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_outline_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Outline', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_outline_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_subtitle_border_enable!',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_outline_border'] = array(
			'type'       => 'border',
			'title'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle.outline-enable',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_outline_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_subtitle_border_enable!',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_outline_padding'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle.outline-enable',
			'attribute'  => 'padding',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_outline_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_subtitle_border_enable!',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_outline_margin'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle.outline-enable',
			'attribute'  => 'margin',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_outline_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_subtitle_border_enable!',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_subtitle_outline_border_radius'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'    => 'style_subtitle',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-subtitle.outline-enable',
			'attribute'  => 'border-radius',
			'dependency' => array(
				array(
					'field'    => 'sg_subtitle_outline_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_subtitle_border_enable!',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_description_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_description',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-heading .heading-section-description',
		);

		$this->options['st_description_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-section-description',
		);

		$this->options['st_description_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-section-description',
			'attribute' => 'margin',
		);

		$this->options['sg_separator_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_separator',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper.style-dotted, {{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper.style-solid, {{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper.style-solid-star, {{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper.style-solid-bullet' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_separator_style!',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['sg_separator_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_separator',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper:not(.style-custom), {{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper.style-dotted:after' => 'height: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_separator_style!',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['st_separator_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_separator',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-heading .heading-section-separator',
			'attribute' => 'margin',
		);

		$this->options['st_separator_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_separator',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper.style-dotted, {{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper.style-solid'                        => 'background: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper.style-dotted:after'                                                                                              => 'background-color: {{VALUE}}; box-shadow: 9px 0 0 0 {{VALUE}}, 18px 0 0 0 {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper.style-solid-bullet, {{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper.style-solid-star'             => 'background: linear-gradient(90deg, {{VALUE}} 0, {{VALUE}} 38%, rgba(255,255,255,0) 38%, rgba(255,255,255,0) 62%, {{VALUE}} 62%, {{VALUE}} 100%)',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper.style-solid-bullet:after, {{WRAPPER}} .jeg-elementor-kit.jkit-heading .separator-wrapper.style-solid-star:after' => 'background-color: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_separator_style!',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['st_shadow_position'] = array(
			'type'               => 'dimension',
			'title'              => esc_html__( 'Position', 'jeg-elementor-kit' ),
			'segment'            => 'style_shadow',
			'units'              => array( 'px', '%', 'em', 'rem', 'vw' ),
			'selectors'          => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-heading .shadow-text' => 'top: {{TOP}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
				),
			),
			'allowed_dimensions' => array( 'top', 'left' ),
			'default'            => array(
				'top'      => '-48',
				'right'    => '',
				'bottom'   => '',
				'left'     => '18',
				'unit'     => '%',
				'isLinked' => false,
			),
		);

		$this->options['st_shadow_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_shadow',
			'selectors' => '.jeg-elementor-kit.jkit-heading .shadow-text',
		);

		$this->options['st_shadow_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_shadow',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-heading .shadow-text',
			'attribute'  => '-webkit-text-fill-color',
		);

		$this->options['st_shadow_border_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Border Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_shadow',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-heading .shadow-text',
			'attribute'  => '-webkit-text-stroke-color',
		);

		$this->options['st_shadow_border_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Border Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_shadow',
			'options'    => array(
				'min'  => 0,
				'max'  => 80,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-heading .shadow-text',
			'attribute'  => '-webkit-text-stroke-width',
		);

		parent::additional_style();
	}
}
