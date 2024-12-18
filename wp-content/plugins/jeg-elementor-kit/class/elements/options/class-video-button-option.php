<?php
/**
 * Video Button Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.2.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Video_Button_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Video_Button_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Video Button', 'jeg-elementor-kit' );
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
		$this->segments['segment_video'] = array(
			'name'     => esc_html__( 'Video', 'jeg-elementor-kit' ),
			'priority' => 10,
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

		$this->segments['style_button'] = array(
			'name'      => esc_html__( 'Button', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_border'] = array(
			'name'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_shadow'] = array(
			'name'      => esc_html__( 'Shadow', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		$this->segments['style_icon'] = array(
			'name'       => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'priority'   => 15,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_video_button_style',
					'operator' => '==',
					'value'    => array( 'icon', 'both' ),
				),
			),
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_video_button_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Color Style', 'jeg-elementor-kit' ),
			'default' => 'icon',
			'segment' => 'segment_video',
			'options' => array(
				'text' => esc_html__( 'Text', 'jeg-elementor-kit' ),
				'icon' => esc_html__( 'Icon', 'jeg-elementor-kit' ),
				'both' => esc_html__( 'Both', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_video_button_title'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Button Title', 'jeg-elementor-kit' ),
			'default'    => esc_html__( 'Play Video', 'jeg-elementor-kit' ),
			'segment'    => 'segment_video',
			'dependency' => array(
				array(
					'field'    => 'sg_video_button_style',
					'operator' => 'in',
					'value'    => array( 'text', 'both' ),
				),
			),
		);

		$this->options['sg_video_button_icon_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Enable Icon', 'jeg-elementor-kit' ),
			'default'    => 'yes',
			'segment'    => 'segment_video',
			'dependency' => array(
				array(
					'field'    => 'sg_video_button_style',
					'operator' => 'in',
					'value'    => array( 'icon', 'both' ),
				),
			),
		);

		$this->options['sg_video_button_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Button Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'far fa-play-circle',
				'library' => 'fa-regular',
			),
			'segment'    => 'segment_video',
			'dependency' => array(
				array(
					'field'    => 'sg_video_button_style',
					'operator' => 'in',
					'value'    => array( 'icon', 'both' ),
				),
				array(
					'field'    => 'sg_video_button_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_video_button_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_video',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_video_button_style',
					'operator' => '==',
					'value'    => 'both',
				),
				array(
					'field'    => 'sg_video_button_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_video_glow_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Glow Effect', 'jeg-elementor-kit' ),
			'default' => 'yes',
			'segment' => 'segment_video',
		);

		$this->options['sg_video_type'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Video Type', 'jeg-elementor-kit' ),
			'default' => 'youtube',
			'segment' => 'segment_video',
			'options' => array(
				'self_hosted' => esc_html__( 'Self Hosted', 'jeg-elementor-kit' ),
				'youtube'     => esc_html__( 'Youtube', 'jeg-elementor-kit' ),
				'vimeo'       => esc_html__( 'Vimeo', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_video_url'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Video URL', 'jeg-elementor-kit' ),
			'default'    => 'https://www.youtube.com/watch?v=MLpWrANjFbI',
			'segment'    => 'segment_video',
			'dependency' => array(
				array(
					'field'    => 'sg_video_type!',
					'operator' => '!==',
					'value'    => 'self_hosted',
				),
			),
		);

		$this->options['sg_video_hosted'] = array(
			'type'        => 'attach_media',
			'title'       => esc_html__( 'Video Hosted', 'jeg-elementor-kit' ),
			'segment'     => 'segment_video',
			'media_types' => array( 'video' ),
			'dependency'  => array(
				array(
					'field'    => 'sg_video_type',
					'operator' => '==',
					'value'    => 'self_hosted',
				),
			),
		);

		$this->options['sg_video_start_time'] = array(
			'type'       => 'number',
			'title'      => esc_html__( 'Start Time', 'jeg-elementor-kit' ),
			'segment'    => 'segment_video',
			'dependency' => array(
				array(
					'field'    => 'sg_video_type',
					'operator' => '==',
					'value'    => 'youtube',
				),
			),
		);

		$this->options['sg_video_end_time'] = array(
			'type'       => 'number',
			'title'      => esc_html__( 'End Time', 'jeg-elementor-kit' ),
			'segment'    => 'segment_video',
			'dependency' => array(
				array(
					'field'    => 'sg_video_type',
					'operator' => '==',
					'value'    => 'youtube',
				),
			),
		);

		$this->options['sg_video_auto_play'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Auto Play', 'jeg-elementor-kit' ),
			'segment' => 'segment_video',
		);

		$this->options['sg_video_mute'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Mute', 'jeg-elementor-kit' ),
			'segment' => 'segment_video',
		);

		$this->options['sg_video_loop'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Loop', 'jeg-elementor-kit' ),
			'segment' => 'segment_video',
		);

		$this->options['sg_video_player_control'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Player Control', 'jeg-elementor-kit' ),
			'segment' => 'segment_video',
		);

		$this->options['sg_video_intro_title'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Intro Title', 'jeg-elementor-kit' ),
			'segment'    => 'segment_video',
			'dependency' => array(
				array(
					'field'    => 'sg_video_type',
					'operator' => '==',
					'value'    => 'vimeo',
				),
			),
		);

		$this->options['sg_video_intro_portrait'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Intro Portrait', 'jeg-elementor-kit' ),
			'segment'    => 'segment_video',
			'dependency' => array(
				array(
					'field'    => 'sg_video_type',
					'operator' => '==',
					'value'    => 'vimeo',
				),
			),
		);

		$this->options['sg_video_intro_byline'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Intro Byline', 'jeg-elementor-kit' ),
			'segment'    => 'segment_video',
			'dependency' => array(
				array(
					'field'    => 'sg_video_type',
					'operator' => '==',
					'value'    => 'vimeo',
				),
			),
		);

		$this->options['sg_video_hosted_poster'] = array(
			'type'       => 'attach_image',
			'title'      => esc_html__( 'Poster', 'jeg-elementor-kit' ),
			'segment'    => 'segment_video',
			'dependency' => array(
				array(
					'field'    => 'sg_video_type',
					'operator' => '==',
					'value'    => 'self_hosted',
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
			'selectors'  => '.jeg-elementor-kit.jkit-video-button',
			'attribute'  => 'text-align',
			'default'    => 'center',
		);

		$this->options['st_button_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn',
			'attribute' => 'padding',
		);

		$this->options['st_button_title_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Title Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'selectors'  => '.jeg-elementor-kit.jkit-video-button span',
			'dependency' => array(
				array(
					'field'    => 'sg_video_button_style',
					'operator' => 'in',
					'value'    => array( 'text', 'both' ),
				),
			),
		);

		$this->options['st_button_height_width_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable Height Width', 'jeg-elementor-kit' ),
			'default' => 'yes',
			'segment' => 'style_button',
		);

		$this->options['st_button_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'default'    => 60,
			'options'    => array(
				'min'  => 1,
				'max'  => 200,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn',
			'attribute'  => 'height',
			'dependency' => array(
				array(
					'field'    => 'st_button_height_width_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_button_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'default'    => 60,
			'options'    => array(
				'min'  => 1,
				'max'  => 200,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn',
			'attribute'  => 'width',
			'dependency' => array(
				array(
					'field'    => 'st_button_height_width_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_button_line_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Line Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'default'    => 70,
			'options'    => array(
				'min'  => 1,
				'max'  => 200,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn',
			'attribute'  => 'line-height',
			'dependency' => array(
				array(
					'field'    => 'st_button_height_width_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
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

		$this->options['st_button_normal_text_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn i, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn svg'                                                                            => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_normal_glow_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Glow Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.glow-enable:not(.hover-gradient):after, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.glow-enable:not(.hover-gradient):before, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.glow-enable.hover-gradient > span:after, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.glow-enable.hover-gradient > span:before' => 'color: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_video_glow_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_button_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_button',
			'selectors'      => '.jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn',
			'options'        => array(
				'classic',
				'gradient',
			),
			'fields_options' => array(
				'background' => array(
					'render_type' => 'template',
				),
			),
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

		$this->options['st_button_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_button_hover_text_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn:hover i, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn:hover span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn:hover svg'                                                                                  => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_hover_glow_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Glow Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.glow-enable:not(.hover-gradient):hover:after, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.glow-enable:not(.hover-gradient):hover:before, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.glow-enable.hover-gradient:hover > span:after, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.glow-enable.hover-gradient:hover > span:before' => 'color: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_video_glow_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_button_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_button',
			'selectors'      => '.jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn:not(.hover-gradient):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.hover-gradient:before',
			'options'        => array(
				'classic',
				'gradient',
			),
			'fields_options' => array(
				'background' => array(
					'render_type' => 'template',
				),
			),
		);

		$this->options['st_button_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_button',
		);

		$this->options['st_button_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_button',
		);

		$this->options['st_border_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_border',
		);

		$this->options['st_border_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_border',
		);

		$this->options['st_border_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_border',
			'selectors' => '.jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn',
		);

		$this->options['st_border_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_border',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.glow-enable:after, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.glow-enable:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_border_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_border',
		);

		$this->options['st_border_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_border',
		);

		$this->options['st_border_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_border',
			'selectors' => '.jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn:hover',
		);

		$this->options['st_border_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_border',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn:hover, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.glow-enable:hover:after, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn.glow-enable:hover:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_border_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_border',
		);

		$this->options['st_border_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_border',
		);

		$this->options['st_shadow_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_shadow',
			'selectors' => '.jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn',
		);

		$this->options['st_shadow_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_shadow',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-video-button i, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button span',
			),
		);

		$this->options['st_icon_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-video-button i, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button svg',
			'attribute' => 'padding',
		);

		$this->options['st_button_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'default'    => 30,
			'options'    => array(
				'min'  => 1,
				'max'  => 200,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_video_button_style',
					'operator' => 'in',
					'value'    => array( 'icon', 'both' ),
				),
			),
		);

		$this->options['st_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'units'      => array( 'px', '%', 'em' ),
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button span.icon-position-before i' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button span.icon-position-after i'  => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_video_button_style',
					'operator' => '==',
					'value'    => 'both',
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

		$this->options['st_icon_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn i, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn svg',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_icon_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn i, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$this->options['st_icon_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn:hover i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn:hover i, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn:hover svg',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_icon_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn:hover i, {{WRAPPER}} .jeg-elementor-kit.jkit-video-button .jkit-video-popup-btn:hover svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
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

		parent::additional_style();
	}
}
