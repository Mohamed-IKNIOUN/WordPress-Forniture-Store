<?php
/**
 * Mailchimp Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.3.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Mailchimp_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Mailchimp_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Mailchimp', 'jeg-elementor-kit' );
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
	 * Mailchimp Lists
	 *
	 * @param string $api_key Mailchimp API Key.
	 */
	public function mailchimp_list( $api_key ) {
		$options = array( '' => esc_html__( 'Select List', 'jeg-elementor-kit' ) );
		$server  = explode( '-', $api_key );

		if ( ! isset( $server[1] ) ) {
			return $options;
		}

		$url = 'https://' . $server[1] . '.api.mailchimp.com/3.0/lists';

		$response = wp_remote_get(
			$url,
			array(
				'headers' => array(
					'Authorization' => 'apikey ' . $api_key,
				),
			)
		);

		if ( is_array( $response ) && ! is_wp_error( $response ) ) {
			$body   = (array) json_decode( $response['body'] );
			$listed = isset( $body['lists'] ) ? $body['lists'] : array();

			if ( is_array( $listed ) && count( $listed ) > 0 ) {
				foreach ( $listed as $v ) {
					$options[ $v->id ] = $v->name;
				}
			}
		}

		return $options;
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
		$this->segments['segment_form'] = array(
			'name'     => esc_html__( 'Form', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_label'] = array(
			'name'      => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_input'] = array(
			'name'      => esc_html__( 'Input', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_button'] = array(
			'name'      => esc_html__( 'Button', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_icon'] = array(
			'name'      => esc_html__( 'Input Icon', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		$this->segments['style_message'] = array(
			'name'      => esc_html__( 'Message', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$user_data = get_option( 'jkit_user_data' );
		$api_key   = '';

		if ( is_array( $user_data ) && isset( $user_data['mailchimp']['api_key'] ) && ! empty( $user_data['mailchimp']['api_key'] ) ) {
			$api_key = $user_data['mailchimp']['api_key'];
		} else {
			$this->options['sg_form_alert'] = array(
				'type'        => 'alert',
				'title'       => '',
				'segment'     => 'segment_form',
				'description' => esc_html__( 'Please set Mailchimp API Key in Jeg Elementor Kit admin dashboard.', 'jeg-elementor-kit' ),
			);
		}

		$this->options['sg_form_list'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Select List', 'jeg-elementor-kit' ),
			'default' => '',
			'segment' => 'segment_form',
			'options' => $this->mailchimp_list( $api_key ),
		);

		$this->options['sg_form_name_enable'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Show Name', 'jeg-elementor-kit' ),
			'segment'   => 'segment_form',
			'separator' => 'before',
		);

		$this->options['sg_form_name_first_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'First Name', 'jeg-elementor-kit' ),
			'segment'    => 'segment_form',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_form_name_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_name_first_label'] = array(
			'type'        => 'text',
			'segment'     => 'segment_form',
			'title'       => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'label_block' => false,
			'dependency'  => array(
				array(
					'field'    => 'sg_form_name_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_name_first_placeholder'] = array(
			'type'        => 'text',
			'segment'     => 'segment_form',
			'title'       => esc_html__( 'Placeholder', 'jeg-elementor-kit' ),
			'label_block' => false,
			'dependency'  => array(
				array(
					'field'    => 'sg_form_name_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_name_first_icon_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Show Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_form',
			'default'    => 'yes',
			'dependency' => array(
				array(
					'field'    => 'sg_form_name_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_name_first_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_form',
			'default'    => array(
				'value'   => 'fas fa-user',
				'library' => 'fa-solid',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_form_name_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_form_name_first_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_name_first_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_form',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_form_name_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_form_name_first_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_name_last_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Last Name', 'jeg-elementor-kit' ),
			'segment'    => 'segment_form',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_form_name_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_name_last_label'] = array(
			'type'        => 'text',
			'segment'     => 'segment_form',
			'title'       => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'label_block' => false,
			'dependency'  => array(
				array(
					'field'    => 'sg_form_name_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_name_last_placeholder'] = array(
			'type'        => 'text',
			'segment'     => 'segment_form',
			'title'       => esc_html__( 'Placeholder', 'jeg-elementor-kit' ),
			'label_block' => false,
			'dependency'  => array(
				array(
					'field'    => 'sg_form_name_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_name_last_icon_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Show Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_form',
			'default'    => 'yes',
			'dependency' => array(
				array(
					'field'    => 'sg_form_name_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_name_last_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_form',
			'default'    => array(
				'value'   => 'fas fa-user',
				'library' => 'fa-solid',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_form_name_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_form_name_last_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_name_last_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_form',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_form_name_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_form_name_last_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_phone_enable'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Show Phone', 'jeg-elementor-kit' ),
			'segment'   => 'segment_form',
			'separator' => 'before',
		);

		$this->options['sg_form_phone_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Phone', 'jeg-elementor-kit' ),
			'segment'    => 'segment_form',
			'dependency' => array(
				array(
					'field'    => 'sg_form_phone_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_phone_label'] = array(
			'type'        => 'text',
			'segment'     => 'segment_form',
			'title'       => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'label_block' => false,
			'dependency'  => array(
				array(
					'field'    => 'sg_form_phone_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_phone_placeholder'] = array(
			'type'        => 'text',
			'segment'     => 'segment_form',
			'title'       => esc_html__( 'Placeholder', 'jeg-elementor-kit' ),
			'label_block' => false,
			'dependency'  => array(
				array(
					'field'    => 'sg_form_phone_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_phone_icon_enable'] = array(
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Show Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_form',
			'default'    => 'yes',
			'dependency' => array(
				array(
					'field'    => 'sg_form_phone_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_phone_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_form',
			'default'    => array(
				'value'   => 'fas fa-phone-alt',
				'library' => 'fa-solid',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_form_phone_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_form_phone_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_phone_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_form',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_form_phone_enable',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'field'    => 'sg_form_phone_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_email_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Email', 'jeg-elementor-kit' ),
			'segment'   => 'segment_form',
			'separator' => 'before',
		);

		$this->options['sg_form_email_label'] = array(
			'type'        => 'text',
			'segment'     => 'segment_form',
			'title'       => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'label_block' => false,
		);

		$this->options['sg_form_email_placeholder'] = array(
			'type'        => 'text',
			'segment'     => 'segment_form',
			'title'       => esc_html__( 'Placeholder', 'jeg-elementor-kit' ),
			'label_block' => false,
		);

		$this->options['sg_form_email_icon_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Icon', 'jeg-elementor-kit' ),
			'segment' => 'segment_form',
			'default' => 'yes',
		);

		$this->options['sg_form_email_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_form',
			'default'    => array(
				'value'   => 'fas fa-envelope',
				'library' => 'fa-solid',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_form_email_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_email_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_form',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_form_email_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_button_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Submit Button', 'jeg-elementor-kit' ),
			'segment'   => 'segment_form',
			'separator' => 'before',
		);

		$this->options['sg_form_button_text'] = array(
			'type'        => 'text',
			'segment'     => 'segment_form',
			'title'       => esc_html__( 'Button Text', 'jeg-elementor-kit' ),
			'label_block' => false,
			'default'     => esc_html__( 'Sign Up', 'jeg-elementor-kit' ),
		);

		$this->options['sg_form_button_icon_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Icon', 'jeg-elementor-kit' ),
			'segment' => 'segment_form',
			'default' => 'yes',
		);

		$this->options['sg_form_button_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'segment'    => 'segment_form',
			'default'    => array(
				'value'   => 'fas fa-check',
				'library' => 'fa-solid',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_form_button_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_button_icon_position'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Icon Position', 'jeg-elementor-kit' ),
			'default'    => 'before',
			'segment'    => 'segment_form',
			'options'    => array(
				'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
				'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_form_button_icon_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_form_style'] = array(
			'type'      => 'select',
			'title'     => esc_html__( 'Form Style', 'jeg-elementor-kit' ),
			'default'   => 'inline',
			'segment'   => 'segment_form',
			'separator' => 'before',
			'options'   => array(
				'inline' => esc_html__( 'Inline', 'jeg-elementor-kit' ),
				'full'   => esc_html__( 'Full Width', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_form_success_message'] = array(
			'type'        => 'text',
			'segment'     => 'segment_form',
			'title'       => esc_html__( 'Success Message', 'jeg-elementor-kit' ),
			'default'     => esc_html__( 'Successfully listed this email', 'jeg-elementor-kit' ),
			'label_block' => false,
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_label_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_label',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-input-label',
		);

		$this->options['st_label_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_label',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-mailchimp .jkit-input-label',
		);

		$this->options['st_label_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_label',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-input-label',
			'attribute' => 'margin',
		);

		$this->options['st_input_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-form-control',
		);

		$this->options['st_input_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_input',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-mailchimp .jkit-form-control',
		);

		$this->options['st_input_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-form-control',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_input_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-form-control',
			'attribute' => 'border-radius',
		);

		$this->options['st_input_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-form-control',
			'attribute' => 'padding',
		);

		$this->options['st_input_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-form-control',
		);

		$this->options['st_input_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-form-control',
		);

		$this->options['st_input_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_input',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp.style-inline .jkit-input-wrapper:not(.jkit-submit-input-holder)' => '-webkit-box-flex: {{SIZE}}{{UNIT}}; -ms-flex: 0 0 {{SIZE}}{{UNIT}}; flex: 0 0 {{SIZE}}{{UNIT}};',
				),
			),
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'sg_form_style',
					'operator' => '==',
					'value'    => 'inline',
				),
			),
		);

		$this->options['st_input_margin_right'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Right', 'jeg-elementor-kit' ),
			'segment'    => 'style_input',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-mailchimp.style-inline .jkit-input-wrapper:not(.jkit-submit-input-holder)',
			'attribute'  => 'margin-right',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'sg_form_style',
					'operator' => '==',
					'value'    => 'inline',
				),
			),
		);

		$this->options['st_input_margin_bottom'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Margin Bottom', 'jeg-elementor-kit' ),
			'segment'    => 'style_input',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-mailchimp .jkit-input-wrapper:not(.jkit-submit-input-holder)',
			'attribute'  => 'margin-bottom',
			'responsive' => true,
		);

		$this->options['st_input_placeholder_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Placeholder', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'separator' => 'before',
		);

		$this->options['st_input_placeholder_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_input',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-form-control::placeholder',
		);

		$this->options['st_input_placeholder_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_input',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-mailchimp .jkit-form-control::placeholder',
		);

		$this->options['st_button_vertical_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Vertical Alignment', 'jeg-elementor-kit' ),
			'default'    => 'center',
			'segment'    => 'style_button',
			'options'    => array(
				'flex-start' => array(
					'title' => esc_html__( 'Top', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-angle-double-up',
				),
				'center'     => array(
					'title' => esc_html__( 'Center', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-sort',
				),
				'flex-end'   => array(
					'title' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-angle-double-down',
				),
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp.style-inline .jkit-submit-input-holder' => 'align-self: {{VALUE}}',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_form_style',
					'operator' => '==',
					'value'    => 'inline',
				),
			),
		);

		$this->options['st_button_horizontal_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Horizontal Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
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
			'selectors'  => '.jeg-elementor-kit.jkit-mailchimp .jkit-submit-input-holder',
			'attribute'  => 'text-align',
			'default'    => 'center',
			'dependency' => array(
				array(
					'field'    => 'sg_form_style',
					'operator' => '==',
					'value'    => 'full',
				),
			),
		);

		$this->options['st_button_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit',
		);

		$this->options['st_button_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit',
			'attribute' => 'padding',
		);

		$this->options['st_button_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit',
			'attribute' => 'margin',
		);

		$this->options['st_button_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp.style-full .jkit-mailchimp-submit'      => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp.style-inline .jkit-submit-input-holder' => '-webkit-box-flex: {{SIZE}}{{UNIT}}; -ms-flex: 0 0 {{SIZE}}{{UNIT}}; flex: 0 0 {{SIZE}}{{UNIT}};',
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
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_button_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit',
		);

		$this->options['st_button_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit',
			'attribute' => 'border-radius',
		);

		$this->options['st_button_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit',
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
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit:hover svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_button_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit:hover',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_button_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit:hover',
		);

		$this->options['st_button_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit:hover',
			'attribute' => 'border-radius',
		);

		$this->options['st_button_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit:hover',
		);

		$this->options['st_button_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_button',
		);

		$this->options['st_button_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_button',
		);

		$this->options['st_button_icon_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'segment'   => 'style_button',
			'separator' => 'before',
		);

		$this->options['st_button_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit.position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit.position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit.position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit.position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_button_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_button',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-submit svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_icon_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-input-group-text'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-input-group-text svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-input-group-text',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Font Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-input-group-text i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-mailchimp .jkit-input-group-text svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_icon_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-input-group-text',
		);

		$this->options['st_icon_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-input-group-text',
			'attribute' => 'padding',
		);

		$this->options['st_icon_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_icon',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-input-group-text',
			'attribute' => 'border-radius',
		);

		$this->options['st_message_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-message',
			'attribute' => 'padding',
		);

		$this->options['st_message_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-message',
			'attribute' => 'margin',
		);

		$this->options['st_message_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-message',
			'attribute' => 'border-radius',
		);

		$this->options['st_message_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-message',
		);

		$this->options['st_message_success_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Success', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'separator' => 'before',
		);

		$this->options['st_message_success_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_message',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-message.success',
		);

		$this->options['st_message_success_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-message.success',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_message_success_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-message.success',
		);

		$this->options['st_message_error_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Error', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'separator' => 'before',
		);

		$this->options['st_message_error_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_message',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-message.error',
		);

		$this->options['st_message_error_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-message.error',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_message_error_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_message',
			'selectors' => '.jeg-elementor-kit.jkit-mailchimp .jkit-mailchimp-message.error',
		);

		parent::additional_style();
	}
}
