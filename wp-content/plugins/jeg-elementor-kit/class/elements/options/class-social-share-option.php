<?php
/**
 * Social Share Option Class
 *
 * @author Jegtheme
 * @since 1.6.0
 * @package jeg-elementor-kit
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Social Share Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Social_Share_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Social Share', 'jeg-elementor-kit' );
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
		$this->segments['segment_social'] = array(
			'name'     => esc_html__( 'Social Media', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_social'] = array(
			'name'      => esc_html__( 'Social Media', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_social_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Style', 'jeg-elementor-kit' ),
			'segment' => 'segment_social',
			'default' => 'icon',
			'options' => array(
				'icon' => esc_html__( 'Icon', 'jeg-elementor-kit' ),
				'text' => esc_html__( 'Text', 'jeg-elementor-kit' ),
				'both' => esc_html__( 'Both', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_social_shape'] = array(
			'type'         => 'select',
			'title'        => esc_html__( 'Shape', 'jeg-elementor-kit' ),
			'segment'      => 'segment_social',
			'default'      => 'none',
			'prefix_class' => 'jkit-social-shape shape-',
			'options'      => array(
				'none'    => esc_html__( 'None', 'jeg-elementor-kit' ),
				'rounded' => esc_html__( 'Rounded', 'jeg-elementor-kit' ),
				'square'  => esc_html__( 'Square', 'jeg-elementor-kit' ),
				'circle'  => esc_html__( 'Circle', 'jeg-elementor-kit' ),
			),
			'dependency'   => array(
				array(
					'field'    => 'sg_social_style',
					'operator' => '==',
					'value'    => 'icon',
				),
			),
		);

		$this->options['sg_social_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Style', 'jeg-elementor-kit' ),
			'segment'    => 'segment_social',
			'default'    => 'before',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_social_style',
					'operator' => '==',
					'value'    => 'both',
				),
			),
		);

		$this->options['sg_social_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'segment_social',
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list span.icon-position-after > i, {{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list span.icon-position-after > svg'     => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list span.icon-position-before > i, {{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list span.icon-position-before > svg '  => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_social_style',
					'operator' => '==',
					'value'    => 'both',
				),
			),
		);

		$this->options['sg_social_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'segment_social',
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
			'selectors'  => '.jeg-elementor-kit.jkit-social-share',
			'attribute'  => 'text-align',
		);

		$this->options['sg_social_list'] = array(
			'type'        => 'repeater',
			'title'       => esc_html__( 'Add Social Media', 'jeg-elementor-kit' ),
			'segment'     => 'segment_social',
			'title_field' => '{{ sg_social_brand }}',
			'fields'      => array(
				'sg_social_icon'                      => array(
					'type'    => 'iconpicker',
					'title'   => esc_html__( 'Icon', 'jeg-elementor-kit' ),
					'segment' => 'sg_social_list',
					'deafult' => array(
						'value'   => 'fab fa-facebook-f',
						'library' => 'fa-brands',
					),
				),
				'sg_social_brand'                     => array(
					'type'    => 'select',
					'title'   => esc_html__( 'Social Media', 'jeg-elementor-kit' ),
					'segment' => 'sg_social_list',
					'default' => 'facebook',
					'options' => array(
						'facebook'      => esc_html__( 'Facebook', 'jeg-elementor-kit' ),
						'twitter'       => esc_html__( 'Twitter', 'jeg-elementor-kit' ),
						'pinterest'     => esc_html__( 'Pinterest', 'jeg-elementor-kit' ),
						'linkedin'      => esc_html__( 'LinkedIn', 'jeg-elementor-kit' ),
						'tumblr'        => esc_html__( 'Tumblr', 'jeg-elementor-kit' ),
						'vkontakte'     => esc_html__( 'VKontakte', 'jeg-elementor-kit' ),
						'odnoklassniki' => esc_html__( 'Odnoklassniki', 'jeg-elementor-kit' ),
						'moimir'        => esc_html__( 'Moimir', 'jeg-elementor-kit' ),
						'livejournal'   => esc_html__( 'Live Journal', 'jeg-elementor-kit' ),
						'blogger'       => esc_html__( 'Blogger', 'jeg-elementor-kit' ),
						'digg'          => esc_html__( 'Digg', 'jeg-elementor-kit' ),
						'evernote'      => esc_html__( 'Evernote', 'jeg-elementor-kit' ),
						'reddit'        => esc_html__( 'Reddit', 'jeg-elementor-kit' ),
						'pocket'        => esc_html__( 'Pocket', 'jeg-elementor-kit' ),
						'surfingbird'   => esc_html__( 'Surfingbird', 'jeg-elementor-kit' ),
						'liveinternet'  => esc_html__( 'Live Internet', 'jeg-elementor-kit' ),
						'buffer'        => esc_html__( 'Buffer', 'jeg-elementor-kit' ),
						'instapaper'    => esc_html__( 'Instapaper', 'jeg-elementor-kit' ),
						'xing'          => esc_html__( 'Xing', 'jeg-elementor-kit' ),
						'wordpress'     => esc_html__( 'WordPress', 'jeg-elementor-kit' ),
						'baidu'         => esc_html__( 'Baidu', 'jeg-elementor-kit' ),
						'renren'        => esc_html__( 'Renren', 'jeg-elementor-kit' ),
						'weibo'         => esc_html__( 'Weibo', 'jeg-elementor-kit' ),
						'skype'         => esc_html__( 'Skype', 'jeg-elementor-kit' ),
						'telegram'      => esc_html__( 'Telegram', 'jeg-elementor-kit' ),
						'viber'         => esc_html__( 'Viber', 'jeg-elementor-kit' ),
						'whatsapp'      => esc_html__( 'Whatsapp', 'jeg-elementor-kit' ),
						'line'          => esc_html__( 'Line', 'jeg-elementor-kit' ),
					),
				),
				'sg_social_label'                     => array(
					'type'        => 'text',
					'title'       => esc_html__( 'Label', 'jeg-elementor-kit' ),
					'segment'     => 'sg_social_list',
					'label_block' => false,
					'default'     => esc_html__( 'Facebook', 'jeg-elementor-kit' ),
				),
				'sg_social_tabs_start'                => array(
					'type'    => 'control_tabs_start',
					'segment' => 'sg_social_list',
				),
				'sg_social_normal_tab_start'          => array(
					'type'    => 'control_tab_start',
					'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
					'segment' => 'sg_social_list',
				),
				'sg_social_normal_color'              => array(
					'type'      => 'color',
					'title'     => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_list',
					'selectors' => array(
						'custom' => array(
							'{{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}} a'     => 'color: {{VALUE}};',
							'{{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}} a svg' => 'fill: {{VALUE}};',
						),
					),
				),
				'sg_social_normal_background'         => array(
					'type'           => 'background',
					'title'          => esc_html__( 'Normal Background Color', 'jeg-elementor-kit' ),
					'segment'        => 'sg_social_list',
					'selectors'      => '.jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}} a',
					'options'        => array(
						'classic',
						'gradient',
					),
					'fields_options' => array(
						'background' => array(
							'render_type' => 'template',
						),
					),
				),
				'sg_social_normal_border'             => array(
					'type'      => 'border',
					'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_list',
					'selectors' => '.jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}} a',
				),
				'sg_social_normal_boxshadow'          => array(
					'type'      => 'boxshadow',
					'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_list',
					'selectors' => '.jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}} a',
				),
				'sg_social_normal_textshadow'         => array(
					'type'      => 'textshadow',
					'title'     => esc_html__( 'Normal Text Shadow', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_list',
					'selectors' => '.jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}} a',
				),
				'sg_social_normal_tab_end'            => array(
					'type'    => 'control_tab_end',
					'segment' => 'sg_social_list',
				),
				'sg_social_hover_tab_start'           => array(
					'type'    => 'control_tab_start',
					'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
					'segment' => 'sg_social_list',
				),
				'sg_social_hover_transition_duration' => array(
					'type'      => 'slider',
					'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_list',
					'options'   => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					),
					'selectors' => array(
						'custom' => array(
							'{{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}} a' => 'transition-duration: {{SIZE}}s;',
						),
					),
				),
				'sg_social_hover_color'               => array(
					'type'      => 'color',
					'title'     => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_list',
					'selectors' => '.jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}}:hover a',
				),
				'sg_social_hover_background'          => array(
					'type'           => 'background',
					'title'          => esc_html__( 'Hover Background Color', 'jeg-elementor-kit' ),
					'segment'        => 'sg_social_list',
					'selectors'      => '.jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}}:hover a:not(.hover-gradient), {{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}} a.hover-gradient:before',
					'options'        => array(
						'classic',
						'gradient',
					),
					'fields_options' => array(
						'background' => array(
							'render_type' => 'template',
						),
					),
				),
				'sg_social_hover_border'              => array(
					'type'      => 'border',
					'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_list',
					'selectors' => '.jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}}:hover a',
				),
				'sg_social_hover_boxshadow'           => array(
					'type'      => 'boxshadow',
					'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_list',
					'selectors' => '.jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}}:hover a',
				),
				'sg_social_hover_textshadow'          => array(
					'type'      => 'textshadow',
					'title'     => esc_html__( 'Hover Text Shadow', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_list',
					'selectors' => '.jeg-elementor-kit.jkit-social-share .social-share-list > li{{CURRENT_ITEM}}:hover a',
				),
				'sg_social_hover_tab_end'             => array(
					'type'    => 'control_tab_end',
					'segment' => 'sg_social_list',
				),
				'sg_social_tabs_end'                  => array(
					'type'    => 'control_tabs_end',
					'segment' => 'sg_social_list',
				),
			),
			'default'     => array(
				array(
					'sg_social_icon'  => array(
						'value'   => 'fab fa-facebook-f',
						'library' => 'fa-brands',
					),
					'sg_social_brand' => 'facebook',
					'sg_social_label' => esc_html__( 'Facebook', 'jeg-elementor-kit' ),
				),
				array(
					'sg_social_icon'  => array(
						'value'   => 'fab fa-twitter',
						'library' => 'fa-brands',
					),
					'sg_social_brand' => 'twitter',
					'sg_social_label' => esc_html__( 'Twitter', 'jeg-elementor-kit' ),
				),
				array(
					'sg_social_icon'  => array(
						'value'   => 'fab fa-linkedin-in',
						'library' => 'fa-brands',
					),
					'sg_social_brand' => 'linkedin',
					'sg_social_label' => esc_html__( 'LinkedIn', 'jeg-elementor-kit' ),
				),
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_social_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
			'selectors'  => '.jeg-elementor-kit.jkit-social-share .social-share-list > li a',
			'dependency' => array(
				array(
					'field'    => 'sg_social_style!',
					'operator' => '==',
					'value'    => 'icon',
				),
			),
		);

		$this->options['st_social_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
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
			'selectors'  => '.jeg-elementor-kit.jkit-social-share .social-share-list > li a',
			'attribute'  => 'text-align',
		);

		$this->options['st_social_display'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Display', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
			'default'    => 'inline-block',
			'responsive' => true,
			'options'    => array(
				'inline-block' => esc_html__( 'Inline Block', 'jeg-elementor-kit' ),
				'block'        => esc_html__( 'Block', 'jeg-elementor-kit' ),
			),
			'selectors'  => '.jeg-elementor-kit.jkit-social-share .social-share-list > li',
			'attribute'  => 'display',
		);

		$this->options['st_social_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_social',
			'units'     => array( 'px', 'em', '%' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list > li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-social-share'                           => '--icon-padding-left: {{LEFT}}{{UNIT}}; --icon-padding-right: {{RIGHT}}{{UNIT}}; --icon-padding-top: {{TOP}}{{UNIT}}; --icon-padding-bottom: {{BOTTOM}}{{UNIT}};',
				),
			),
		);

		$this->options['st_social_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_social',
			'units'     => array( 'px', 'em', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-social-share .social-share-list > li',
			'attribute' => 'margin',
			'default'   => array(
				'top'      => '5',
				'right'    => '5',
				'bottom'   => '5',
				'left'     => '5',
				'unit'     => 'px',
				'isLinked' => true,
			),
		);

		$this->options['st_social_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_social',
			'units'     => array( 'px', 'em', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-social-share .social-share-list > li a',
			'attribute' => 'border-radius',
		);

		$this->options['st_social_height_width'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Use Height Width', 'jeg-elementor-kit' ),
			'segment' => 'style_social',
		);

		$this->options['st_social_height_width_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'selectors'  => '.jeg-elementor-kit.jkit-social-share .social-share-list > li a',
			'attribute'  => 'width',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'st_social_height_width',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_social_height_width_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-social-share .social-share-list > li a',
			'attribute'  => 'height',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'st_social_height_width',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_social_height_width_line_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Line Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-social-share .social-share-list > li a',
			'attribute'  => 'line-height',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'st_social_height_width',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_social_style',
					'operator' => '==',
					'value'    => 'icon',
				),
			),
		);

		$this->options['st_social_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-social-share',
			'attribute'  => '--icon-size',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'sg_social_style!',
					'operator' => '==',
					'value'    => 'text',
				),
			),
		);

		$this->options['st_social_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_social',
		);

		$this->options['st_social_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_social',
		);

		$this->options['st_social_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list > li a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list > li a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_social_normal_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_social',
			'selectors'      => '.jeg-elementor-kit.jkit-social-share .social-share-list > li a',
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

		$this->options['st_social_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_social',
		);

		$this->options['st_social_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_social',
		);

		$this->options['st_social_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_social',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list > li a' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_social_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list > li:hover a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list > li:hover a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_social_hover_background'] = array(
			'type'           => 'background',
			'title'          => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_social',
			'selectors'      => '.jeg-elementor-kit.jkit-social-share .social-share-list > li:hover a:not(.hover-gradient), {{WRAPPER}} .jeg-elementor-kit.jkit-social-share .social-share-list > li a.hover-gradient:before',
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

		$this->options['st_social_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_social',
		);

		$this->options['st_social_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_social',
		);

		parent::additional_style();
	}
}
