<?php
/**
 * Team Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Team_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Team_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Team', 'jeg-elementor-kit' );
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
		$this->segments['segment_member'] = array(
			'name'     => esc_html__( 'Team Member', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->segments['segment_social'] = array(
			'name'     => esc_html__( 'Social Profiles', 'jeg-elementor-kit' ),
			'priority' => 11,
		);

		$this->segments['segment_popup'] = array(
			'name'     => esc_html__( 'Pop Up Detail', 'jeg-elementor-kit' ),
			'priority' => 12,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_content'] = array(
			'name'      => esc_html__( 'Content', 'jeg-elementor-kit' ),
			'priority'  => 10,
			'kit_style' => true,
		);

		$this->segments['style_image'] = array(
			'name'      => esc_html__( 'Image', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_name'] = array(
			'name'      => esc_html__( 'Name', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_position'] = array(
			'name'      => esc_html__( 'Position', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_description'] = array(
			'name'      => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		$this->segments['style_social'] = array(
			'name'      => esc_html__( 'Social Profiles', 'jeg-elementor-kit' ),
			'priority'  => 15,
			'kit_style' => true,
		);

		$this->segments['style_control'] = array(
			'name'       => esc_html__( 'Modal Controls', 'jeg-elementor-kit' ),
			'priority'   => 16,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_popup_show',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_close'] = array(
			'name'       => esc_html__( 'Close Icon', 'jeg-elementor-kit' ),
			'priority'   => 17,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_popup_show',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_hover_content'] = array(
			'name'       => esc_html__( 'Hover Content', 'jeg-elementor-kit' ),
			'priority'   => 18,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => '==',
					'value'    => 'hover-social',
				),
			),
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_member_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Style', 'jeg-elementor-kit' ),
			'segment' => 'segment_member',
			'default' => 'default',
			'options' => array(
				'default'          => esc_html__( 'Default', 'jeg-elementor-kit' ),
				'overlay'          => esc_html__( 'Overlay', 'jeg-elementor-kit' ),
				'hover-social'     => esc_html__( 'Hover on Social', 'jeg-elementor-kit' ),
				'title-horizontal' => esc_html__( 'Title & Social Horizontal', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_member_overlay_style'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Overlay Style', 'jeg-elementor-kit' ),
			'segment'    => 'segment_member',
			'default'    => 'bottom',
			'options'    => array(
				'bottom' => esc_html__( 'From Bottom', 'jeg-elementor-kit' ),
				'scale'  => esc_html__( 'Scale', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => '==',
					'value'    => 'overlay',
				),
			),
		);

		$this->options['sg_member_overlay_content_alignment'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Overlay Content Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'segment_member',
			'default'    => 'center',
			'options'    => array(
				'center' => esc_html__( 'Center', 'jeg-elementor-kit' ),
				'bottom' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => '==',
					'value'    => 'overlay',
				),
			),
		);

		$this->options['sg_member_image'] = array(
			'type'    => 'image',
			'title'   => esc_html__( 'Choose Image ', 'jeg-elementor-kit' ),
			'segment' => 'segment_member',
			'default' => \Elementor\Utils::get_placeholder_image_src(),
		);

		$this->options['sg_member_image_size'] = array(
			'type'    => 'imagesize',
			'title'   => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
			'segment' => 'segment_member',
		);

		$this->options['sg_member_html_tag'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Member Name HTML Tag', 'jeg-elementor-kit' ),
			'default' => 'h2',
			'segment' => 'segment_member',
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

		$this->options['sg_member_name'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Member Name', 'jeg-elementor-kit' ),
			'segment' => 'segment_member',
			'default' => esc_html__( 'John Doe', 'jeg-elementor-kit' ),
		);

		$this->options['sg_member_position'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Position', 'jeg-elementor-kit' ),
			'segment' => 'segment_member',
			'default' => esc_html__( 'Designer', 'jeg-elementor-kit' ),
		);

		$this->options['sg_member_show_description'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Description', 'jeg-elementor-kit' ),
			'segment' => 'segment_member',
		);

		$this->options['sg_member_description'] = array(
			'type'       => 'textarea',
			'title'      => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'segment'    => 'segment_member',
			'default'    => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_member_show_description',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_member_enable_hover_border_bottom'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Enable Hover Border Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'segment_member',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
			),
		);

		$this->options['sg_member_hover_border_bottom_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Border Bottom Color', 'jeg-elementor-kit' ),
			'segment'    => 'segment_member',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .border-bottom',
			'attribute'  => 'background-color',
			'dependency' => array(
				array(
					'field'    => 'sg_member_enable_hover_border_bottom',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
			),
		);

		$this->options['sg_member_hover_direction'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Hover Direction', 'jeg-elementor-kit' ),
			'default'    => 'top',
			'segment'    => 'segment_member',
			'default'    => 'left',
			'options'    => array(
				'left'  => esc_html__( 'From Left', 'jeg-elementor-kit' ),
				'right' => esc_html__( 'From Right', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_member_enable_hover_border_bottom',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
			),
		);

		$this->options['sg_social_show'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Social Profiles', 'jeg-elementor-kit' ),
			'segment' => 'segment_social',
			'default' => 'yes',
		);

		$this->options['sg_social_icon'] = array(
			'type'        => 'repeater',
			'title'       => esc_html__( 'Social Icon', 'jeg-elementor-kit' ),
			'segment'     => 'segment_social',
			'title_field' => '{{ sg_social_label }}',
			'fields'      => array(
				'sg_social_icon'              => array(
					'type'    => 'iconpicker',
					'title'   => esc_html__( 'Icon', 'jeg-elementor-kit' ),
					'segment' => 'sg_social_icon',
				),
				'sg_social_label'             => array(
					'type'    => 'text',
					'title'   => esc_html__( 'Label', 'jeg-elementor-kit' ),
					'segment' => 'sg_social_icon',
				),
				'sg_social_link'              => array(
					'type'    => 'link',
					'segment' => 'sg_social_icon',
					'title'   => esc_html__( 'Link', 'jeg-elementor-kit' ),
				),
				'sg_social_tabs_start'        => array(
					'type'    => 'control_tabs_start',
					'segment' => 'sg_social_icon',
				),
				'sg_social_normal_tab_start'  => array(
					'type'    => 'control_tab_start',
					'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
					'segment' => 'sg_social_icon',
				),
				'sg_social_normal_color'      => array(
					'type'      => 'color',
					'title'     => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_icon',
					'selectors' => array(
						'custom' => array(
							'{{WRAPPER}} .jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}} a'     => 'color: {{VALUE}};',
							'{{WRAPPER}} .jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}} a svg' => 'fill: {{VALUE}};',
						),
					),
				),
				'sg_social_normal_background' => array(
					'type'           => 'background',
					'title'          => esc_html__( 'Normal Background Color', 'jeg-elementor-kit' ),
					'segment'        => 'sg_social_icon',
					'selectors'      => '.jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}} a',
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
				'sg_social_normal_border'     => array(
					'type'      => 'border',
					'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_icon',
					'selectors' => '.jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}} a',
				),
				'sg_social_normal_boxshadow'  => array(
					'type'      => 'boxshadow',
					'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_icon',
					'selectors' => '.jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}} a',
				),
				'sg_social_normal_textshadow' => array(
					'type'      => 'textshadow',
					'title'     => esc_html__( 'Normal Text Shadow', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_icon',
					'selectors' => '.jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}} a',
				),
				'sg_social_normal_tab_end'    => array(
					'type'    => 'control_tab_end',
					'segment' => 'sg_social_icon',
				),
				'sg_social_hover_tab_start'   => array(
					'type'    => 'control_tab_start',
					'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
					'segment' => 'sg_social_icon',
				),
				'sg_social_hover_color'       => array(
					'type'      => 'color',
					'title'     => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_icon',
					'selectors' => array(
						'custom' => array(
							'{{WRAPPER}} .jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}}:hover a'     => 'color: {{VALUE}};',
							'{{WRAPPER}} .jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}}:hover a svg' => 'fill: {{VALUE}};',
						),
					),
				),
				'sg_social_hover_background'  => array(
					'type'           => 'background',
					'title'          => esc_html__( 'Hover Background Color', 'jeg-elementor-kit' ),
					'segment'        => 'sg_social_icon',
					'selectors'      => '.jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}}:not(.hover-gradient):hover a, {{WRAPPER}} .jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}}.hover-gradient a:before',
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
				'sg_social_hover_border'      => array(
					'type'      => 'border',
					'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_icon',
					'selectors' => '.jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}}:hover a',
				),
				'sg_social_hover_boxshadow'   => array(
					'type'      => 'boxshadow',
					'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_icon',
					'selectors' => '.jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}}:hover a',
				),
				'sg_social_hover_textshadow'  => array(
					'type'      => 'textshadow',
					'title'     => esc_html__( 'Hover Text Shadow', 'jeg-elementor-kit' ),
					'segment'   => 'sg_social_icon',
					'selectors' => '.jeg-elementor-kit.jkit-team .social-list .social-icon{{CURRENT_ITEM}}:hover a',
				),
				'sg_social_hover_tab_end'     => array(
					'type'    => 'control_tab_end',
					'segment' => 'sg_social_icon',
				),
				'sg_social_tabs_end'          => array(
					'type'    => 'control_tabs_end',
					'segment' => 'sg_social_icon',
				),
			),
			'default'     => array(
				array(
					'sg_social_icon'  => array(
						'value'   => 'fab fa-facebook-f',
						'library' => 'fa-brands',
					),
					'sg_social_label' => esc_html__( 'Facebook', 'jeg-elementor-kit' ),
					'sg_social_link'  => array(
						'url' => 'https://facebook.com',
					),
				),
				array(
					'sg_social_icon'  => array(
						'value'   => 'fab fa-twitter',
						'library' => 'fa-brands',
					),
					'sg_social_label' => esc_html__( 'Twitter', 'jeg-elementor-kit' ),
					'sg_social_link'  => array(
						'url' => 'https://twitter.com',
					),
				),
				array(
					'sg_social_icon'  => array(
						'value'   => 'fab fa-pinterest-p',
						'library' => 'fa-brands',
					),
					'sg_social_label' => esc_html__( 'Pinterest', 'jeg-elementor-kit' ),
					'sg_social_link'  => array(
						'url' => 'https://pinterest.com',
					),
				),
			),
			'dependency'  => array(
				array(
					'field'    => 'sg_social_show',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_popup_show'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Pop Up', 'jeg-elementor-kit' ),
			'segment' => 'segment_popup',
		);

		$this->options['sg_popup_phone'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Phone', 'jeg-elementor-kit' ),
			'segment'    => 'segment_popup',
			'default'    => esc_html__( '+1 (234) 567-879', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_popup_show',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_popup_email'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Email', 'jeg-elementor-kit' ),
			'segment'    => 'segment_popup',
			'default'    => esc_html__( 'info@example.com', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_popup_show',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_popup_close_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Close Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-times',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_popup',
			'dependency' => array(
				array(
					'field'    => 'sg_popup_show',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_popup_close_icon_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'segment_popup',
			'options'    => array(
				'left'  => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-left',
				),
				'right' => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-right',
				),
			),
			'responsive' => true,
			'default'    => 'left',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close' => '{{VALUE}}: 10px;',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_popup_show',
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
			'default'    => 'center',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-title-horizontal .profile-body .title-wrapper' => 'text-align: {{VALUE}};',
				),
			),
		);

		$this->options['st_content_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-team .profile-card',
			'attribute' => 'padding',
		);

		$this->options['st_content_content_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Content Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-team .profile-body',
			'attribute' => 'padding',
		);

		$this->options['st_content_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-card, {{WRAPPER}} .jeg-elementor-kit.jkit-team.overlay-scale .profile-card:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_content_minheight_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Use Min Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
			),
		);

		$this->options['st_content_minheight'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Min Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'options'    => array(
				'min'  => 10,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team.style-default .profile-card, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-hover-social .profile-card' => 'min-height: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
				array(
					'field'    => 'st_content_minheight_enable',
					'operator' => '==',
					'value'    => true,
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
			'type'           => 'background',
			'title'          => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_content',
			'selectors'      => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-box .profile-card, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-overlay .profile-card:before, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-hover-social .profile-card:before',
			),
			'options'        => array(
				'classic',
				'gradient',
			),
			'dependency'     => array(
				array(
					'field'    => 'sg_member_style!',
					'operator' => '==',
					'value'    => 'title-horizontal',
				),
			),
			'fields_options' => array(
				'background' => array(
					'render_type' => 'template',
				),
			),
		);

		$this->options['st_content_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-team .profile-card',
		);

		$this->options['st_content_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-team .profile-card',
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
			'type'           => 'background',
			'title'          => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'        => 'style_content',
			'selectors'      => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-team:hover .profile-box .profile-card:not(.hover-gradient), {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-overlay .profile-card:before, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-hover-social:hover .profile-card:before, {{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-box .profile-card.hover-gradient:before',
			),
			'options'        => array(
				'classic',
				'gradient',
			),
			'dependency'     => array(
				array(
					'field'    => 'sg_member_style!',
					'operator' => '==',
					'value'    => 'title-horizontal',
				),
			),
			'fields_options' => array(
				'background' => array(
					'render_type' => 'template',
				),
			),
		);

		$this->options['st_content_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-team .profile-card:hover',
		);

		$this->options['st_content_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => '.jeg-elementor-kit.jkit-team:hover .profile-card',
		);

		$this->options['st_content_hover_scale'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Hover Scale', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'options'    => array(
				'min'  => 0,
				'max'  => 1,
				'step' => 0.1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team.style-overlay.overlay-scale .profile-card:hover:before' => '-moz-transform: scale({{SIZE}});',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team.style-overlay.overlay-scale .profile-card:hover:before' => '-ms-transform: scale({{SIZE}});',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team.style-overlay.overlay-scale .profile-card:hover:before' => '-o-transform: scale({{SIZE}});',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team.style-overlay.overlay-scale .profile-card:hover:before' => '-webkit-transform: scale({{SIZE}});',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team.style-overlay.overlay-scale .profile-card:hover:before' => 'transform: scale({{SIZE}});',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => '==',
					'value'    => 'overlay',
				),
				array(
					'field'    => 'sg_member_overlay_style',
					'operator' => '==',
					'value'    => 'scale',
				),
			),
		);

		$this->options['st_content_hover_animation'] = array(
			'type'    => 'hoveranimation',
			'title'   => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment' => 'style_content',
		);

		$this->options['st_content_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_content',
		);

		$this->options['st_content_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_content',
		);

		$this->options['st_image_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Image Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'options'    => array(
				'min'  => 10,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-box .profile-card .profile-header img, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-overlay .profile-card > img, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-hover-social .profile-card > img, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-title-horizontal .profile-card img' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_image_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Image Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'options'    => array(
				'min'  => 10,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-box .profile-card .profile-header img, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-overlay .profile-card > img, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-hover-social .profile-card > img, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-title-horizontal .profile-card img' => 'height: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_image_rotation'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Image Rotation', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'options'    => array(
				'min'  => 0,
				'max'  => 360,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-box .profile-card .profile-header img, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-overlay .profile-card > img, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-hover-social .profile-card > img, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-title-horizontal .profile-card img' => '-moz-transform: rotate({{SIZE}}deg); -webkit-transform: rotate({{SIZE}}deg); -o-transform: rotate({{SIZE}}deg); -ms-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
				),
			),
		);

		$this->options['st_image_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'selectors'  => '.jeg-elementor-kit.jkit-team .profile-box .profile-card .profile-header img',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
			),
		);

		$this->options['st_image_padding'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-team .profile-box .profile-card .profile-header img',
			'attribute'  => 'padding',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
			),
		);

		$this->options['st_image_border_radius'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-box .profile-card .profile-header img, {{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-box .profile-card .profile-header .image-hover-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
			),
		);

		$this->options['st_image_border'] = array(
			'type'       => 'border',
			'title'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'selectors'  => '.jeg-elementor-kit.jkit-team .profile-box .profile-card .profile-header img',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
			),
		);

		$this->options['st_image_boxshadow'] = array(
			'type'       => 'boxshadow',
			'title'      => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'selectors'  => '.jeg-elementor-kit.jkit-team .profile-box .profile-card .profile-header img',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
			),
		);

		$this->options['st_image_css_filters'] = array(
			'type'       => 'css_filter',
			'title'      => esc_html__( 'CSS Filters', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'default'    => '',
			'selectors'  => '.jeg-elementor-kit.jkit-team .profile-box .profile-card .profile-header img',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
			),
		);

		$this->options['st_image_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team.style-default .profile-card .profile-header, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-hover-social .profile-card .profile-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
			),
		);

		$this->options['st_image_overlay_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Enable Overlay', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social', 'title-horizontal' ),
				),
			),
		);

		$this->options['st_image_overlay_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'selectors'  => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-box .profile-card .profile-header .image-hover-bg, {{WRAPPER}} .jeg-elementor-kit.jkit-team.style-title-horizontal .profile-card .image-hover-bg',
			),
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social', 'title-horizontal' ),
				),
				array(
					'field'    => 'st_image_overlay_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_image_hover_animation'] = array(
			'type'       => 'hoveranimation',
			'title'      => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment'    => 'style_image',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => 'in',
					'value'    => array( 'default', 'hover-social' ),
				),
			),
		);

		$this->options['st_name_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_name',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-body .profile-title, {{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-body .profile-title a',
			),
		);

		$this->options['st_name_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_name',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-body .profile-title'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .profile-body .profile-title a' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_name_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_name',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team:hover .profile-body .profile-title'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team:hover .profile-body .profile-title a' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_name_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_name',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .profile-body .profile-title',
			'attribute'  => 'margin-bottom',
		);

		$this->options['st_position_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_position',
			'selectors' => '.jeg-elementor-kit.jkit-team .profile-body .profile-designation',
		);

		$this->options['st_position_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_position',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .profile-body .profile-designation',
		);

		$this->options['st_position_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_position',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team:hover .profile-body .profile-designation',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style!',
					'operator' => '==',
					'value'    => 'title-horizontal',
				),
			),
		);

		$this->options['st_position_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Hover Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_position',
			'selectors' => '.jeg-elementor-kit.jkit-team:hover .profile-body .profile-designation',
		);

		$this->options['st_position_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_position',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .profile-body .profile-designation',
			'attribute'  => 'margin-bottom',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style!',
					'operator' => '==',
					'value'    => 'title-horizontal',
				),
			),
		);

		$this->options['st_position_text_direction'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Text Direction', 'jeg-elementor-kit' ),
			'default'    => '0',
			'segment'    => 'style_position',
			'options'    => array(
				'180' => esc_html__( 'Up', 'jeg-elementor-kit' ),
				'0'   => esc_html__( 'Down', 'jeg-elementor-kit' ),
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team.style-title-horizontal .profile-body .profile-designation'       => 'transform: translateX(20px) rotate({{VALUE}}deg);',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team.style-title-horizontal:hover .profile-body .profile-designation' => 'transform: translateX(0px) rotate({{VALUE}}deg);',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => '==',
					'value'    => 'title-horizontal',
				),
			),
		);

		$this->options['st_position_text_break'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Break Each Word', 'jeg-elementor-kit' ),
			'segment'    => 'style_position',
			'default'    => 'yes',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => '==',
					'value'    => 'title-horizontal',
				),
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team.style-title-horizontal .profile-body .profile-designation' => 'white-space: break-spaces; height: min-content;',
				),
			),
		);

		$this->options['st_description_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'selectors' => '.jeg-elementor-kit.jkit-team .profile-body .profile-content',
		);

		$this->options['st_description_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_description',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .profile-body .profile-content',
		);

		$this->options['st_description_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_description',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team:hover .profile-body .profile-content',
		);

		$this->options['st_description_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_description',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .profile-body .profile-content',
			'attribute'  => 'margin-bottom',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style!',
					'operator' => '==',
					'value'    => 'title-horizontal',
				),
			),
		);

		$this->options['st_description_margin_right'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Right', 'jeg-elementor-kit' ),
			'segment'    => 'style_description',
			'default'    => 15,
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team.style-title-horizontal .profile-body .profile-content',
			'attribute'  => 'margin-right',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style',
					'operator' => '==',
					'value'    => 'title-horizontal',
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
			'default'    => 'center',
			'selectors'  => '.jeg-elementor-kit.jkit-team .social-list',
			'attribute'  => 'text-align',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style!',
					'operator' => '==',
					'value'    => 'title-horizontal',
				),
			),
		);

		$this->options['st_social_display'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Display', 'jeg-elementor-kit' ),
			'default'    => 'inline-block',
			'segment'    => 'style_social',
			'options'    => array(
				'inline-block' => esc_html__( 'Horizontal', 'jeg-elementor-kit' ),
				'block'        => esc_html__( 'Vertical', 'jeg-elementor-kit' ),
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .social-list .social-icon',
			'attribute'  => 'display',
			'dependency' => array(
				array(
					'field'    => 'sg_member_style!',
					'operator' => '==',
					'value'    => 'title-horizontal',
				),
			),
		);

		$this->options['st_social_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_social',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-team .social-list .social-icon',
			'attribute' => 'margin',
		);

		$this->options['st_social_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_social',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-team .social-list .social-icon a',
			'attribute' => 'padding',
		);

		$this->options['st_social_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_social',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-team .social-list .social-icon a',
			'attribute' => 'border-radius',
		);

		$this->options['st_social_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .social-list .social-icon a'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .social-list .social-icon a svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_social_fix_height'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Fix Height & Width', 'jeg-elementor-kit' ),
			'segment' => 'style_social',
		);

		$this->options['st_social_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .social-list .social-icon a',
			'attribute'  => 'height',
			'dependency' => array(
				array(
					'field'    => 'st_social_fix_height',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_social_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .social-list .social-icon a',
			'attribute'  => 'width',
			'dependency' => array(
				array(
					'field'    => 'st_social_fix_height',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_social_line_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Line Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_social',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .social-list .social-icon a',
			'attribute'  => 'line-height',
			'dependency' => array(
				array(
					'field'    => 'st_social_fix_height',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_control_modal_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Modal', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'separator' => 'before',
		);

		$this->options['st_control_modal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-content',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_control_name_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Name', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'separator' => 'before',
		);

		$this->options['st_control_name_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_control',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-title',
		);

		$this->options['st_control_name_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-title',
		);

		$this->options['st_control_name_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_control',
			'options'    => array(
				'min'  => 10,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-title',
			'attribute'  => 'margin-bottom',
		);

		$this->options['st_control_position_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Position', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'separator' => 'before',
		);

		$this->options['st_control_position_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_control',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-position',
		);

		$this->options['st_control_position_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-position',
		);

		$this->options['st_control_position_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_control',
			'options'    => array(
				'min'  => 10,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-position',
			'attribute'  => 'margin-bottom',
		);

		$this->options['st_control_description_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'separator' => 'before',
		);

		$this->options['st_control_description_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_control',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-description',
		);

		$this->options['st_control_description_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-description',
		);

		$this->options['st_control_description_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_control',
			'options'    => array(
				'min'  => 10,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-description',
			'attribute'  => 'margin-bottom',
		);

		$this->options['st_control_phone_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Phone and Email', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'separator' => 'before',
		);

		$this->options['st_control_phone_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-list',
		);

		$this->options['st_control_phone_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_control',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-list'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-list a' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_control_phone_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_control',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-list a:hover',
		);

		$this->options['st_control_image_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Image', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'separator' => 'before',
		);

		$this->options['st_control_image_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-img img',
		);

		$this->options['st_control_social_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Social Profiles', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'separator' => 'before',
		);

		$this->options['st_control_social_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_control',
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
			'selectors'  => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .social-list',
			'attribute'  => 'text-align',
		);

		$this->options['st_control_social_display'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Display', 'jeg-elementor-kit' ),
			'default'    => 'inline-block',
			'segment'    => 'style_control',
			'options'    => array(
				'inline-block' => esc_html__( 'Horizontal', 'jeg-elementor-kit' ),
				'block'        => esc_html__( 'Vertical', 'jeg-elementor-kit' ),
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .social-list .social-icon',
			'attribute'  => 'display',
		);

		$this->options['st_control_social_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_control',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .social-list .social-icon',
			'attribute' => 'margin',
		);

		$this->options['st_close_font_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Font Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
			'options'    => array(
				'min'  => 10,
				'max'  => 300,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_close_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close',
			'attribute' => 'padding',
		);

		$this->options['st_close_fix_height'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Fix Height & Width', 'jeg-elementor-kit' ),
			'segment' => 'style_close',
		);

		$this->options['st_close_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close',
			'attribute'  => 'height',
			'dependency' => array(
				array(
					'field'    => 'st_close_fix_height',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_close_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close',
			'attribute'  => 'width',
			'dependency' => array(
				array(
					'field'    => 'st_close_fix_height',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_close_line_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Line Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close',
			'attribute'  => 'line-height',
			'dependency' => array(
				array(
					'field'    => 'st_close_fix_height',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_close_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_close',
		);

		$this->options['st_close_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_close',
		);

		$this->options['st_close_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_close_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_close_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close',
		);

		$this->options['st_close_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close',
			'attribute' => 'border-radius',
		);

		$this->options['st_close_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close',
		);

		$this->options['st_close_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_close',
		);

		$this->options['st_close_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_close',
		);

		$this->options['st_close_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_close',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_close_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_close_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close:hover',
		);

		$this->options['st_close_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_close_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_close',
			'selectors' => '.jeg-elementor-kit.jkit-team .jkit-modal-dialog .team-modal-close:hover',
		);

		$this->options['st_close_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_close',
		);

		$this->options['st_close_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_close',
		);

		$this->options['st_hover_content_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_hover_content',
			'selectors' => '.jeg-elementor-kit.jkit-team.style-hover-social .profile-body:before',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_hover_content_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_hover_content',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-team.style-hover-social .profile-body:before',
			'attribute' => 'border-radius',
		);

		$this->options['st_hover_content_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_hover_content',
			'selectors' => '.jeg-elementor-kit.jkit-team.style-hover-social .profile-body:before',
		);

		$this->options['st_hover_content_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_hover_content',
			'selectors' => '.jeg-elementor-kit.jkit-team.style-hover-social .profile-body:before',
		);

		parent::additional_style();
	}
}
