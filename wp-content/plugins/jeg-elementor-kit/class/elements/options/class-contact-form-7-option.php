<?php
/**
 * Contact Form 7 Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Contact_Form_7_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Contact_Form_7_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Contact Form 7', 'jeg-elementor-kit' );
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
	 * Get contact form list option
	 *
	 * @return array
	 */
	private function contact_form_list() {
		$wpcf7_form_list = get_posts(
			array(
				'post_type' => 'wpcf7_contact_form',
				'showposts' => 999,
			)
		);

		$lists = array();

		if ( ! empty( $wpcf7_form_list ) && ! is_wp_error( $wpcf7_form_list ) ) {
			foreach ( $wpcf7_form_list as $post ) {
				$lists[ $post->ID ] = $post->post_title;
			}
		}

		return $lists;
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

		$this->segments['style_label'] = array(
			'name'      => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_input'] = array(
			'name'      => esc_html__( 'Input', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_button'] = array(
			'name'      => esc_html__( 'Button', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		$this->segments['style_message'] = array(
			'name'      => esc_html__( 'Message', 'jeg-elementor-kit' ),
			'priority'  => 15,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		if ( ! function_exists( 'wpcf7' ) ) {
			$this->options['sg_setting_alert'] = array(
				'type'    => 'alert',
				'title'   => esc_html__( 'Please install and activate Contact Form 7 plugin to use this element.', 'jeg-elementor-kit' ),
				'segment' => 'segment_setting',
			);
		} else {
			$this->options['sg_setting_contact_form'] = array(
				'type'    => 'select',
				'title'   => esc_html__( 'Contact Form', 'jeg-elementor-kit' ),
				'segment' => 'segment_setting',
				'options' => $this->contact_form_list(),
			);
		}
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_wrapper_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_wrapper',
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
			'selectors'  => '.jeg-elementor-kit.jkit-contact-form-7',
			'attribute'  => 'text-align',
		);

		$this->options['st_wrapper_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_wrapper_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7',
		);

		$this->options['st_wrapper_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7',
		);

		$this->options['st_wrapper_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7',
			'attribute' => 'margin',
		);

		$this->options['st_wrapper_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7',
			'attribute' => 'padding',
		);

		$this->options['st_wrapper_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_wrapper',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7',
			'attribute' => 'border-radius',
		);

		$this->options['st_label_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_label',
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
			'selectors'  => '.jeg-elementor-kit.jkit-contact-form-7 form label',
			'attribute'  => 'text-align',
		);

		$this->options['st_label_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_label',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form label',
		);

		$this->options['st_label_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_label',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-contact-form-7 form label',
		);

		$this->options['st_label_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_label',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form label',
			'attribute' => 'margin',
		);

		$this->options['st_label_hint_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Hint', 'jeg-elementor-kit' ),
			'separator' => 'before',
			'segment'   => 'style_label',
		);

		$this->options['st_label_hint_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_label',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form label span',
		);

		$this->options['st_label_hint_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_label',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-contact-form-7 form label span',
		);

		$this->options['st_input_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_input_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_input_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_input',
			'default'    => 380,
			'options'    => array(
				'min'  => 0,
				'max'  => 10000,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'selectors'  => '.jeg-elementor-kit.jkit-contact-form-7 form label',
			'attribute'  => 'max-width',
			'responsive' => true,
		);

		$this->options['st_input_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_input',
			'default'    => 50,
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select' => 'height: {{SIZE}}{{UNIT}};',
				),
			),
			'responsive' => true,
		);

		$this->options['st_input_textarea_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Text Area', 'jeg-elementor-kit' ),
			'separator' => 'before',
			'segment'   => 'style_input',
		);

		$this->options['st_input_textarea_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_input',
			'default'    => 150,
			'options'    => array(
				'min'  => 0,
				'max'  => 400,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-contact-form-7 form textarea',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_input_textarea_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form textarea',
			'attribute' => 'padding',
		);

		$this->options['st_input_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_input',
		);

		$this->options['st_input_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_input',
		);

		$this->options['st_input_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select',
			),
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_input_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_input_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select',
			),
		);

		$this->options['st_input_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select',
			),
		);

		$this->options['st_input_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_input',
		);

		$this->options['st_input_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_input',
		);

		$this->options['st_input_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea:hover, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select:hover',
			),
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_input_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea:hover, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_input_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea:hover, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select:hover',
			),
		);

		$this->options['st_input_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]):hover, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea:hover, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select:hover',
			),
		);

		$this->options['st_input_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_input',
		);

		$this->options['st_input_focus_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Focus', 'jeg-elementor-kit' ),
			'segment' => 'style_input',
		);

		$this->options['st_input_focus_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Focus Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]):focus, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea:focus, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select:focus',
			),
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_input_focus_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Focus Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]):focus, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea:focus, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			),
		);

		$this->options['st_input_focus_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Focus Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]):focus, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea:focus, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select:focus',
			),
		);

		$this->options['st_input_focus_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Focus Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]):focus, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea:focus, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select:focus',
			),
		);

		$this->options['st_input_focus_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_input',
		);

		$this->options['st_input_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_input',
		);

		$this->options['st_input_typography_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'separator' => 'before',
			'segment'   => 'style_input',
		);

		$this->options['st_input_typography_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select',
			),
		);

		$this->options['st_input_typography_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_input',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio]), {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_input_placeholder_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Placeholder', 'jeg-elementor-kit' ),
			'separator' => 'before',
			'segment'   => 'style_input',
		);

		$this->options['st_input_placeholder_font_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Font Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_input',
			'default'    => 14,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'units'      => array( 'px', 'em' ),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio])::placeholder, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea::placeholder, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select::placeholder' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			),
			'attribute'  => 'font-size',
			'responsive' => true,
		);

		$this->options['st_input_placeholder_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_input',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form input:not([type=submit]):not([type=checkbox]):not([type=radio])::placeholder, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form textarea::placeholder, {{WRAPPER}} .jeg-elementor-kit.jkit-contact-form-7 form select::placeholder' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]',
		);

		$this->options['st_button_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]',
			'attribute' => 'border-radius',
		);

		$this->options['st_button_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]',
			'attribute' => 'padding',
		);

		$this->options['st_button_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]',
			'attribute' => 'margin',
		);

		$this->options['st_button_height_width'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Use Height Width', 'jeg-elementor-kit' ),
			'segment' => 'style_button',
		);

		$this->options['st_button_height_width_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'selectors'  => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]',
			'attribute'  => 'width',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'st_button_height_width',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_button_height_width_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]',
			'attribute'  => 'height',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'st_button_height_width',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_button_height_width_line_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Line Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'options'    => array(
				'min'  => 0,
				'max'  => 200,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]',
			'attribute'  => 'line-height',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'st_button_height_width',
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

		$this->options['st_button_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]',
		);

		$this->options['st_button_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_button_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]',
		);

		$this->options['st_button_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]',
		);

		$this->options['st_button_normal_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Normal Title Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]',
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

		$this->options['st_button_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]:hover',
		);

		$this->options['st_button_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_button_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]:hover',
		);

		$this->options['st_button_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Hover Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]:hover',
		);

		$this->options['st_button_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Hover Title Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form input[type=submit]:hover',
		);

		$this->options['st_button_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_button',
		);

		$this->options['st_button_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_button',
		);

		$this->options['st_message_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form .wpcf7-response-output',
		);

		$this->options['st_message_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_message',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-contact-form-7 form .wpcf7-response-output',
		);

		$this->options['st_message_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form .wpcf7-response-output',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_message_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form .wpcf7-response-output',
			'attribute' => 'border-radius',
		);

		$this->options['st_message_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'selectors' => '.jeg-elementor-kit.jkit-contact-form-7 form .wpcf7-response-output',
		);

		parent::additional_style();
	}
}
