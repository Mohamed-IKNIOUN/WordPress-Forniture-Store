<?php
/**
 * Animated Text Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Animated_Text_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Animated_Text_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Animated Text', 'jeg-elementor-kit' );
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
		$this->segments['segment_text'] = array(
			'name'     => esc_html__( 'Text', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_text_normal'] = array(
			'name'      => esc_html__( 'Normal Text', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_text_animated'] = array(
			'name'      => esc_html__( 'Animated Text', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_highlight'] = array(
			'name'       => esc_html__( 'Highlight', 'jeg-elementor-kit' ),
			'priority'   => 14,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_text_style',
					'operator' => '==',
					'value'    => 'highlighted',
				),
			),
		);

		$this->segments['style_typing'] = array(
			'name'       => esc_html__( 'Typing', 'jeg-elementor-kit' ),
			'priority'   => 15,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_text_style',
					'operator' => '==',
					'value'    => 'rotating',
				),
				array(
					'field'    => 'sg_text_rotating',
					'operator' => '==',
					'value'    => 'typing',
				),
			),
		);

		$this->segments['style_clip'] = array(
			'name'       => esc_html__( 'Clip', 'jeg-elementor-kit' ),
			'priority'   => 16,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_text_style',
					'operator' => '==',
					'value'    => 'rotating',
				),
				array(
					'field'    => 'sg_text_rotating',
					'operator' => '==',
					'value'    => 'clip',
				),
			),
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_text_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Style', 'jeg-elementor-kit' ),
			'default' => 'rotating',
			'segment' => 'segment_text',
			'options' => array(
				'none'        => 'None',
				'highlighted' => 'Highlighted',
				'rotating'    => 'Rotating',
			),
		);

		$this->options['sg_text_shape'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Shape', 'jeg-elementor-kit' ),
			'default'    => 'circle',
			'segment'    => 'segment_text',
			'options'    => array(
				'circle'           => 'Circle',
				'curly'            => 'Curly',
				'underline'        => 'Underline',
				'double'           => 'Double',
				'double-underline' => 'Double Underline',
				'underline-zigzag' => 'Underline Zigzag',
				'diagonal'         => 'Diagonal',
				'strikethrough'    => 'Strikethrough',
				'x'                => 'X',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_text_style',
					'operator' => '==',
					'value'    => 'highlighted',
				),
			),
		);

		$this->options['sg_text_rotating'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Rotating', 'jeg-elementor-kit' ),
			'default'    => 'typing',
			'segment'    => 'segment_text',
			'options'    => array(
				'typing'      => 'Typing',
				'clip'        => 'Clip',
				'flip'        => 'Flip',
				'swirl'       => 'Swirl',
				'blinds'      => 'Blinds',
				'bounce'      => 'Bounce',
				'swing'       => 'Swing',
				'rubber-band' => 'Rubber Band',
				'drop-in'     => 'Drop In',
				'wave'        => 'Wave',
				'slide-left'  => 'Slide Left',
				'slide-right' => 'Slide Right',
				'slide-up'    => 'Slide Up',
				'slide-down'  => 'Slide Down',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_text_style',
					'operator' => '==',
					'value'    => 'rotating',
				),
			),
		);

		$this->options['sg_text_letter_speed'] = array(
			'type'       => 'number',
			'title'      => esc_html__( 'Letter Speed', 'jeg-elementor-kit' ),
			'segment'    => 'segment_text',
			'default'    => 100,
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'dependency' => array(
				array(
					'field'    => 'sg_text_style',
					'operator' => '==',
					'value'    => 'rotating',
				),
				array(
					'field'    => 'sg_text_rotating',
					'operator' => 'in',
					'value'    => array( 'typing', 'swirl', 'blinds', 'wave' ),
				),
			),
		);

		$this->options['sg_text_delay_change'] = array(
			'type'       => 'number',
			'title'      => esc_html__( 'Delay on Change', 'jeg-elementor-kit' ),
			'segment'    => 'segment_text',
			'default'    => 2500,
			'options'    => array(
				'min'  => 0,
				'max'  => 5000,
				'step' => 1,
			),
			'dependency' => array(
				array(
					'field'    => 'sg_text_style',
					'operator' => '==',
					'value'    => 'rotating',
				),
			),
		);

		$this->options['sg_text_clip_duration'] = array(
			'type'       => 'number',
			'title'      => esc_html__( 'Clip Duration', 'jeg-elementor-kit' ),
			'segment'    => 'segment_text',
			'default'    => 2000,
			'options'    => array(
				'min'  => 0,
				'max'  => 5000,
				'step' => 1,
			),
			'dependency' => array(
				array(
					'field'    => 'sg_text_style',
					'operator' => '==',
					'value'    => 'rotating',
				),
				array(
					'field'    => 'sg_text_rotating',
					'operator' => '==',
					'value'    => 'clip',
				),
			),
		);

		$this->options['sg_text_delay_delete'] = array(
			'type'       => 'number',
			'title'      => esc_html__( 'Delay on Delete', 'jeg-elementor-kit' ),
			'segment'    => 'segment_text',
			'default'    => 500,
			'options'    => array(
				'min'  => 0,
				'max'  => 5000,
				'step' => 1,
			),
			'dependency' => array(
				array(
					'field'    => 'sg_text_style',
					'operator' => '==',
					'value'    => 'rotating',
				),
				array(
					'field'    => 'sg_text_rotating',
					'operator' => '==',
					'value'    => 'typing',
				),
			),
		);

		$this->options['sg_text_before'] = array(
			'type'      => 'text',
			'title'     => esc_html__( 'Before Text', 'jeg-elementor-kit' ),
			'segment'   => 'segment_text',
			'default'   => esc_html__( 'This is ', 'jeg-elementor-kit' ),
			'separator' => 'before',
		);

		$this->options['sg_text_animated'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Animated Text', 'jeg-elementor-kit' ),
			'segment'    => 'segment_text',
			'default'    => esc_html__( 'dummy', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_text_style!',
					'operator' => '==',
					'value'    => 'rotating',
				),
			),
		);

		$this->options['sg_text_rotating_list'] = array(
			'type'        => 'repeater',
			'title'       => esc_html__( 'Rotating Text', 'jeg-elementor-kit' ),
			'segment'     => 'segment_text',
			'title_field' => '{{ sg_text_rotating_list_text }}',
			'fields'      => array(
				'sg_text_rotating_list_text' => array(
					'type'    => 'text',
					'segment' => 'sg_text_rotating_list',
					'title'   => esc_html__( 'Text', 'jeg-elementor-kit' ),
					'default' => esc_html__( 'dummy', 'jeg-elementor-kit' ),
				),
			),
			'default'     => array(
				array( 'sg_text_rotating_list_text' => esc_html__( 'dummy', 'jeg-elementor-kit' ) ),
				array( 'sg_text_rotating_list_text' => esc_html__( 'animated', 'jeg-elementor-kit' ) ),
				array( 'sg_text_rotating_list_text' => esc_html__( 'rotating', 'jeg-elementor-kit' ) ),
			),
			'dependency'  => array(
				array(
					'field'    => 'sg_text_style',
					'operator' => '==',
					'value'    => 'rotating',
				),
			),
		);

		$this->options['sg_text_after'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'After Text', 'jeg-elementor-kit' ),
			'segment' => 'segment_text',
			'default' => esc_html__( ' text', 'jeg-elementor-kit' ),
		);

		$this->options['sg_text_link'] = array(
			'type'      => 'link',
			'title'     => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment'   => 'segment_text',
			'separator' => 'before',
		);

		$this->options['sg_text_html_tag'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'HTML Tag', 'jeg-elementor-kit' ),
			'default' => 'p',
			'segment' => 'segment_text',
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

		$this->options['sg_text_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'segment_text',
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
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text',
			'attribute'  => 'text-align',
			'default'    => 'center',
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_text_normal_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_text_normal',
			'selectors' => '.jeg-elementor-kit.jkit-animated-text .animated-text .normal-text',
		);

		$this->options['sg_text_normal_color_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Color Style', 'jeg-elementor-kit' ),
			'default' => 'color',
			'segment' => 'style_text_normal',
			'options' => array(
				'color'    => 'Color',
				'gradient' => 'Gradient',
			),
		);

		$this->options['st_text_normal_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_text_normal',
		);

		$this->options['st_text_normal_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_text_normal',
		);

		$this->options['st_text_normal_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_text_normal',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text .animated-text .normal-text.style-color',
			'dependency' => array(
				array(
					'field'    => 'sg_text_normal_color_style',
					'operator' => '==',
					'value'    => 'color',
				),
			),
		);

		$this->options['st_text_normal_normal_gradient'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Normal Gradient', 'jeg-elementor-kit' ),
			'segment'    => 'style_text_normal',
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text .animated-text .normal-text.style-gradient',
			'options'    => array( 'gradient' ),
			'dependency' => array(
				array(
					'field'    => 'sg_text_normal_color_style',
					'operator' => '==',
					'value'    => 'gradient',
				),
			),
		);

		$this->options['st_text_normal_normal_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Normal Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_text_normal',
			'selectors' => '.jeg-elementor-kit.jkit-animated-text .animated-text .normal-text',
		);

		$this->options['st_text_normal_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_text_normal',
		);

		$this->options['st_text_normal_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_text_normal',
		);

		$this->options['st_text_normal_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_text_normal',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text .animated-text:hover .normal-text.style-color',
			'dependency' => array(
				array(
					'field'    => 'sg_text_normal_color_style',
					'operator' => '==',
					'value'    => 'color',
				),
			),
		);

		$this->options['st_text_normal_hover_gradient'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Hover Gradient', 'jeg-elementor-kit' ),
			'segment'    => 'style_text_normal',
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text .animated-text:hover .normal-text.style-gradient',
			'options'    => array( 'gradient' ),
			'dependency' => array(
				array(
					'field'    => 'sg_text_normal_color_style',
					'operator' => '==',
					'value'    => 'gradient',
				),
			),
		);

		$this->options['st_text_normal_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Hover Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_text_normal',
			'selectors' => '.jeg-elementor-kit.jkit-animated-text .animated-text:hover .normal-text',
		);

		$this->options['st_text_normal_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_text_normal',
		);

		$this->options['st_text_normal_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_text_normal',
		);

		$this->options['st_text_animated_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_text_animated',
			'selectors' => '.jeg-elementor-kit.jkit-animated-text .animated-text .dynamic-text',
		);

		$this->options['sg_text_animated_color_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Color Style', 'jeg-elementor-kit' ),
			'default' => 'gradient',
			'segment' => 'style_text_animated',
			'options' => array(
				'color'    => 'Color',
				'gradient' => 'Gradient',
			),
		);

		$this->options['st_text_animated_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_text_animated',
		);

		$this->options['st_text_animated_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_text_animated',
		);

		$this->options['st_text_animated_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_text_animated',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text .animated-text .dynamic-wrapper.style-color .dynamic-text',
			'dependency' => array(
				array(
					'field'    => 'sg_text_animated_color_style',
					'operator' => '==',
					'value'    => 'color',
				),
			),
		);

		$this->options['st_text_animated_normal_gradient'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Normal Gradient', 'jeg-elementor-kit' ),
			'segment'    => 'style_text_animated',
			'selectors'  => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-animated-text .animated-text .dynamic-wrapper.style-gradient:not(.typing-delete) .dynamic-text, {{WRAPPER}} .jeg-elementor-kit.jkit-animated-text .animated-text .dynamic-wrapper.style-gradient:not(.typing-delete) .dynamic-text .dynamic-text-letter',
			),
			'options'    => array( 'gradient' ),
			'dependency' => array(
				array(
					'field'    => 'sg_text_animated_color_style',
					'operator' => '==',
					'value'    => 'gradient',
				),
			),
		);

		$this->options['st_text_animated_normal_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Normal Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_text_animated',
			'selectors' => '.jeg-elementor-kit.jkit-animated-text .animated-text .dynamic-text',
		);

		$this->options['st_text_animated_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_text_animated',
		);

		$this->options['st_text_animated_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_text_animated',
		);

		$this->options['st_text_animated_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_text_animated',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text .animated-text:hover .dynamic-wrapper.style-color .dynamic-text',
			'dependency' => array(
				array(
					'field'    => 'sg_text_animated_color_style',
					'operator' => '==',
					'value'    => 'color',
				),
			),
		);

		$this->options['st_text_animated_hover_gradient'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Hover Gradient', 'jeg-elementor-kit' ),
			'segment'    => 'style_text_animated',
			'selectors'  => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-animated-text .animated-text:hover .dynamic-wrapper.style-gradient .dynamic-text, {{WRAPPER}} .jeg-elementor-kit.jkit-animated-text .animated-text:hover .dynamic-wrapper.style-gradient .dynamic-text .dynamic-text-letter',
			),
			'options'    => array( 'gradient' ),
			'dependency' => array(
				array(
					'field'    => 'sg_text_animated_color_style',
					'operator' => '==',
					'value'    => 'gradient',
				),
			),
		);

		$this->options['st_text_animated_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Hover Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_text_animated',
			'selectors' => '.jeg-elementor-kit.jkit-animated-text .animated-text:hover .dynamic-text',
		);

		$this->options['st_text_animated_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_text_animated',
		);

		$this->options['st_text_animated_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_text_animated',
		);

		$this->options['st_highlight_color_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Color Style', 'jeg-elementor-kit' ),
			'default' => 'color',
			'segment' => 'style_highlight',
			'options' => array(
				'color'    => 'Color',
				'gradient' => 'Gradient',
			),
		);

		$this->options['st_highlight_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_highlight',
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text .animated-text svg path.style-color',
			'attribute'  => 'stroke',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'st_highlight_color_style',
					'operator' => '==',
					'value'    => 'color',
				),
			),
		);

		$this->options['st_highlight_gradient_color1'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Gradient Color 1', 'jeg-elementor-kit' ),
			'segment'    => 'style_highlight',
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text .animated-text svg linearGradient stop:nth-of-type(1)',
			'attribute'  => 'stop-color',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'st_highlight_color_style',
					'operator' => '==',
					'value'    => 'gradient',
				),
			),
		);

		$this->options['st_highlight_gradient_color2'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Gradient Color 2', 'jeg-elementor-kit' ),
			'segment'    => 'style_highlight',
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text .animated-text svg linearGradient stop:nth-of-type(2)',
			'attribute'  => 'stop-color',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'st_highlight_color_style',
					'operator' => '==',
					'value'    => 'gradient',
				),
			),
		);

		$this->options['st_highlight_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_highlight',
			'default'    => 9,
			'options'    => array(
				'min'  => 0,
				'max'  => 20,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text .animated-text svg path',
			'attribute'  => 'stroke-width',
			'responsive' => true,
		);

		$this->options['st_highlight_animation_duration'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Animation Duration', 'jeg-elementor-kit' ),
			'segment'    => 'style_highlight',
			'default'    => 10,
			'responsive' => true,
			'options'    => array(
				'min'  => 0,
				'max'  => 20,
				'step' => 0.1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-animated-text .animated-text svg path' => '-moz-animation-duration: {{SIZE}}s; -webkit-animation-duration: {{SIZE}}s; -o-animation-duration: {{SIZE}}s; -ms-animation-duration: {{SIZE}}s; animation-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_highlight_rounded'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Rounded Edges', 'jeg-elementor-kit' ),
			'segment'   => 'style_highlight',
			'default'   => 'yes',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-animated-text .animated-text svg path' => 'stroke-linecap: round; stroke-linejoin: round',
				),
			),
		);

		$this->options['st_highlight_front'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Bring to Front', 'jeg-elementor-kit' ),
			'segment'   => 'style_highlight',
			'default'   => 'yes',
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-animated-text .animated-text svg'           => 'z-index: 2',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-animated-text .animated-text .dynamic-text' => 'z-index: auto',
				),
			),
		);

		$this->options['st_typing_cursor_color'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Cursor Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_typing',
			'selectors' => '.jeg-elementor-kit.jkit-animated-text[data-style=rotating][data-rotate=typing] .animated-text .dynamic-wrapper:after',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_typing_delete_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Delete Block Font Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_typing',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text[data-style=rotating][data-rotate=typing] .animated-text .dynamic-wrapper.typing-delete .dynamic-text .dynamic-text-letter',
		);

		$this->options['st_typing_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Delete Block Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_typing',
			'selectors' => '.jeg-elementor-kit.jkit-animated-text[data-style=rotating][data-rotate=typing] .animated-text .dynamic-wrapper.typing-delete',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_clip_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_clip',
			'default'    => 1,
			'options'    => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-animated-text[data-style=rotating][data-rotate=clip] .animated-text .dynamic-wrapper:after',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_clip_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Clip Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_clip',
			'selectors' => '.jeg-elementor-kit.jkit-animated-text[data-style=rotating][data-rotate=clip] .animated-text .dynamic-wrapper:after',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		parent::additional_style();
	}
}
