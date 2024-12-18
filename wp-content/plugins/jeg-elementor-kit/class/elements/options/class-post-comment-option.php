<?php
/**
 * Post Comment Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Post_Comment_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Post_Comment_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Post Comment', 'jeg-elementor-kit' );
	}

	/**
	 * Element category
	 *
	 * @return string
	 */
	public function get_category() {
		return esc_html__( 'Jeg Elementor Kit - Single Post', 'jeg-elementor-kit' );
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
		$this->segments['segment_comment'] = array(
			'name'     => esc_html__( 'Post Comment', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_form_fields'] = array(
			'name'      => esc_html__( 'Form Fields', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_title'] = array(
			'name'      => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_description'] = array(
			'name'      => esc_html__( 'Description', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_button'] = array(
			'name'      => esc_html__( 'Button', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_comment_notice'] = array(
			'type'    => 'raw',
			'title'   => '',
			'segment' => 'segment_comment',
			'raw'     => esc_html__( 'This widget uses the currently active theme comments design and layout to display the comment form and comments.', 'jeg-elementor-kit' ),
			'classes' => 'elementor-descriptor',
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_form_label_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_label_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form label',
		);

		$this->options['st_form_label_text_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form label',
		);

		$this->options['st_form_label_required_text_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Reuired Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form label .required',
		);

		$this->options['st_form_field_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Field', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'separator' => 'before',
		);

		$this->options['st_form_field_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"])',
			'attribute' => 'padding',
		);

		$this->options['st_form_field_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"])',
		);

		$this->options['st_form_field_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_field_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_field_normal_text_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"])',
		);

		$this->options['st_form_field_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"])',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_form_field_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"])',
		);

		$this->options['st_form_field_normal_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"])',
			'attribute' => 'border-radius',
		);

		$this->options['st_form_field_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Field Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"])',
		);

		$this->options['st_form_field_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_field_focus_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Focus', 'jeg-elementor-kit' ),
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_field_focus_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"])' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_form_field_focus_text_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea:focus, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"]):focus',
		);

		$this->options['st_form_field_focus_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea:focus, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"]):focus',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_form_field_focus_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea:focus, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"]):focus',
		);

		$this->options['st_form_field_focus_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea:focus, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"]):focus',
			'attribute' => 'border-radius',
		);

		$this->options['st_form_fieldhoverl_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Field Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form textarea:focus, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form input:not([type="submit"]):focus',
		);

		$this->options['st_form_field_focus_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_field_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_checkbox_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Checkbox', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'separator' => 'before',
		);

		$this->options['st_form_checkbox_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form .checkmark',
			'attribute' => 'padding',
		);

		$this->options['st_form_checkbox_icon'] = array(
			'type'    => 'iconpicker',
			'title'   => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'default' => array(
				'value'   => 'jki jki-check-light',
				'library' => 'jkiticon',
			),
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_checkbox_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_form_fields',
			'options'    => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .checkmark > i'   => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .checkmark > svg' => 'width: {{SIZE}}{{UNIT}}',
				),
			),
			'responsive' => true,
		);

		$this->options['st_form_checkbox_icon_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Icon Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_form_fields',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .checkmark > i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .checkmark > svg path' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_form_checkbox_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .checkmark' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_form_checkbox_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_checkbox_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_checkbox_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form .checkmark',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_form_checkbox_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form .checkmark',
		);

		$this->options['st_form_checkbox_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_checkbox_checked_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Checked', 'jeg-elementor-kit' ),
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_checkbox_checked_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form input[type="checkbox"]:checked ~ label .checkmark',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_form_checkbox_checked_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_form_fields',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form input[type="checkbox"]:checked ~ label .checkmark',
		);

		$this->options['st_form_checkbox_checked_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_form_fields',
		);

		$this->options['st_form_checkbox_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_form_fields',
		);

		$this->options['st_title_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-reply-title',
			'attribute' => 'margin',
		);

		$this->options['st_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-reply-title',
		);

		$this->options['st_title_text_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-post-comment #comments .comment-reply-title',
		);

		$this->options['st_description_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form .comment-notes, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .logged-in-as, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .must-log-in',
			'attribute' => 'margin',
		);

		$this->options['st_description_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form .comment-notes, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .logged-in-as, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .must-log-in',
		);

		$this->options['st_description_text_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_description',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form .comment-notes, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .logged-in-as, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .must-log-in',
		);

		$this->options['st_description_link_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'separator' => 'before',
		);

		$this->options['st_description_link_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_description',
		);

		$this->options['st_description_link_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_description',
		);

		$this->options['st_description_link_normal_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form .comment-notes a, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .logged-in-as a, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .must-log-in a',
		);

		$this->options['st_description_link_normal_text_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_description',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form .comment-notes a, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .logged-in-as a, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .must-log-in a',
		);

		$this->options['st_description_link_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_description',
		);

		$this->options['st_description_link_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_description',
		);

		$this->options['st_description_link_hover_transition_duration'] = array(
			'type'      => 'slider',
			'title'     => esc_html__( 'Transition Duration', 'jeg-elementor-kit' ),
			'segment'   => 'style_description',
			'options'   => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 0.1,
			),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .comment-notes a, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .logged-in-as a, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .must-log-in a' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_description_link_hover_text_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_description',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-post-comment #comments .comment-form .comment-notes a:hover, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .logged-in-as a:hover, {{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments .comment-form .must-log-in a:hover',
		);

		$this->options['st_description_link_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_description',
		);

		$this->options['st_description_link_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_description',
		);

		$this->options['st_button_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit',
			'attribute' => 'padding',
		);

		$this->options['st_button_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit',
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
			'type'      => 'color',
			'title'     => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit',
		);

		$this->options['st_button_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_button_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit',
		);

		$this->options['st_button_normal_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit',
			'attribute' => 'border-radius',
		);

		$this->options['st_button_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Button Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit',
		);

		$this->options['st_button_normal_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit' => 'transition-duration: {{SIZE}}s;',
				),
			),
		);

		$this->options['st_button_hover_text_color'] = array(
			'type'      => 'color',
			'title'     => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit:hover',
		);

		$this->options['st_button_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_button_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit:hover',
		);

		$this->options['st_button_hover_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_buttonhoverl_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Button Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit:hover',
		);

		$this->options['st_button_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-post-comment #comments #respond .comment-form .form-submit #submit:hover',
		);

		$this->options['st_button_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_button',
		);

		$this->options['st_button_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_button',
		);

		parent::additional_style();
	}
}
