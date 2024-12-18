<?php
/**
 * Countdown Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.2.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Countdown_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Countdown_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Countdown', 'jeg-elementor-kit' );
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
	 * Get template list option
	 *
	 * @return mixed
	 */
	private function template_list() {
		$options = array();

		$args = array(
			'post_type'      => 'elementor_library',
			'posts_per_page' => -1,
		);

		$page_templates = get_posts( $args );

		if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ) {
			foreach ( $page_templates as $post ) {
				$options[ $post->ID ] = $post->post_title;
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
		$this->segments['segment_content'] = array(
			'name'     => esc_html__( 'Content', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->segments['segment_expire'] = array(
			'name'     => esc_html__( 'Expired Action', 'jeg-elementor-kit' ),
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
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_day'] = array(
			'name'       => esc_html__( 'Days', 'jeg-elementor-kit' ),
			'priority'   => 12,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_day_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_hour'] = array(
			'name'       => esc_html__( 'Hours', 'jeg-elementor-kit' ),
			'priority'   => 13,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_hour_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_minute'] = array(
			'name'       => esc_html__( 'Minutes', 'jeg-elementor-kit' ),
			'priority'   => 14,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_minute_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_second'] = array(
			'name'       => esc_html__( 'Seconds', 'jeg-elementor-kit' ),
			'priority'   => 15,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_second_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->segments['style_expire'] = array(
			'name'       => esc_html__( 'Expire Message', 'jeg-elementor-kit' ),
			'priority'   => 15,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_expire_type',
					'operator' => '==',
					'value'    => 'message',
				),
			),
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_content_date'] = array(
			'type'    => 'datetime',
			'title'   => esc_html__( 'Due Date', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
		);

		$this->options['sg_content_day_enable'] = array(
			'type'      => 'checkbox',
			'title'     => esc_html__( 'Show Days', 'jeg-elementor-kit' ),
			'default'   => 'yes',
			'segment'   => 'segment_content',
			'separator' => 'before',
		);

		$this->options['sg_content_day_label'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Custom Label for Days', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => esc_html__( 'Days', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_content_day_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_hour_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Hours', 'jeg-elementor-kit' ),
			'default' => 'yes',
			'segment' => 'segment_content',
		);

		$this->options['sg_content_hour_label'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Custom Label for Hours', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => esc_html__( 'Hours', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_content_hour_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_minute_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Minutes', 'jeg-elementor-kit' ),
			'default' => 'yes',
			'segment' => 'segment_content',
		);

		$this->options['sg_content_minute_label'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Custom Label for Minutes', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => esc_html__( 'Minutes', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_content_minute_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_second_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Seconds', 'jeg-elementor-kit' ),
			'default' => 'yes',
			'segment' => 'segment_content',
		);

		$this->options['sg_content_second_label'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Custom Label for Seconds', 'jeg-elementor-kit' ),
			'segment'    => 'segment_content',
			'default'    => esc_html__( 'Seconds', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_content_second_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_content_separator_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Separator', 'jeg-elementor-kit' ),
			'segment'   => 'segment_content',
			'separator' => 'before',
		);

		$this->options['sg_content_separator_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Show Separator', 'jeg-elementor-kit' ),
			'segment' => 'segment_content',
		);

		$this->options['sg_content_separator_type'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Separator Type', 'jeg-elementor-kit' ),
			'default'    => '"|"',
			'segment'    => 'segment_content',
			'options'    => array(
				'""'  => esc_html__( 'Hide', 'jeg-elementor-kit' ),
				'"|"' => esc_html__( 'Solid', 'jeg-elementor-kit' ),
				'":"' => esc_html__( 'Dotted', 'jeg-elementor-kit' ),
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-container:not(:last-child) .timer-inner-container::after',
			'attribute'  => 'content',
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['sg_expire_type'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Expire Type', 'jeg-elementor-kit' ),
			'segment' => 'segment_expire',
			'default' => 'none',
			'options' => array(
				'none'     => esc_html__( 'None', 'jeg-elementor-kit' ),
				'message'  => esc_html__( 'Message', 'jeg-elementor-kit' ),
				'redirect' => esc_html__( 'Redirection Link', 'jeg-elementor-kit' ),
				'template' => esc_html__( 'Saved Templates', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_expire_title'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'On Expiry Title', 'jeg-elementor-kit' ),
			'segment'    => 'segment_expire',
			'default'    => esc_html__( 'Countdown is finished!', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_expire_type',
					'operator' => 'in',
					'value'    => array( 'message', 'redirect' ),
				),
			),
		);

		$this->options['sg_expire_content'] = array(
			'type'       => 'textarea',
			'title'      => esc_html__( 'On Expiry Content', 'jeg-elementor-kit' ),
			'segment'    => 'segment_expire',
			'default'    => esc_html__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'jeg-elementor-kit' ),
			'dependency' => array(
				array(
					'field'    => 'sg_expire_type',
					'operator' => 'in',
					'value'    => array( 'message', 'redirect' ),
				),
			),
		);

		$this->options['sg_expire_link'] = array(
			'type'       => 'text',
			'title'      => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment'    => 'segment_expire',
			'dependency' => array(
				array(
					'field'    => 'sg_expire_type',
					'operator' => '==',
					'value'    => 'redirect',
				),
			),
		);

		$this->options['sg_expire_template'] = array(
			'type'       => 'select',
			'title'      => esc_html__( 'Select Template', 'jeg-elementor-kit' ),
			'segment'    => 'segment_expire',
			'options'    => jkit_get_elementor_saved_template_option(),
			'dependency' => array(
				array(
					'field'    => 'sg_expire_type',
					'operator' => '==',
					'value'    => 'template',
				),
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_content_column'] = array(
			'type'           => 'slider',
			'title'          => esc_html__( 'Column', 'jeg-elementor-kit' ),
			'segment'        => 'style_content',
			'default'        => 4,
			'responsive'     => true,
			'mobile_default' => array(
				'size' => 1,
			),
			'options'        => array(
				'min'  => 1,
				'max'  => 4,
				'step' => 1,
			),
			'selectors'      => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-countdown .timer-container' => '-ms-flex: 0 0 calc(100% / {{SIZE}}); flex: 0 0 calc(100% / {{SIZE}}); max-width: calc(100% / {{SIZE}});',
				),
			),
		);

		$this->options['st_content_row_gap'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Row Gap', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'units'      => array( 'px', '%', 'em' ),
			'responsive' => true,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown',
			'attribute'  => 'row-gap',
		);

		$this->options['st_content_vertical_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Vertical Alignment', 'jeg-elementor-kit' ),
			'default'    => 'center',
			'segment'    => 'style_content',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-countdown' => '-webkit-box-align: {{VALUE}}; -ms-flex-align: {{VALUE}}; align-items: {{VALUE}}',
				),
			),
		);

		$this->options['st_content_horizontal_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Horizontal Alignment', 'jeg-elementor-kit' ),
			'default'    => 'center',
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
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown',
			'attribute'  => 'justify-content',
		);

		$this->options['st_content_label_position'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Label Position', 'jeg-elementor-kit' ),
			'segment' => 'style_content',
			'default' => 'bottom',
			'options' => array(
				'top'    => esc_html__( 'Top', 'jeg-elementor-kit' ),
				'inline' => esc_html__( 'Inline', 'jeg-elementor-kit' ),
				'bottom' => esc_html__( 'Bottom', 'jeg-elementor-kit' ),
			),
		);

		$this->options['st_content_label_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Label Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'default'    => 5,
			'options'    => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-content.label-inline>span.timer-title',
			'attribute'  => 'margin-left',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'st_content_label_position',
					'operator' => '==',
					'value'    => 'inline',
				),
			),
		);

		$this->options['st_day_digit_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Digit', 'jeg-elementor-kit' ),
			'segment' => 'style_day',
		);

		$this->options['st_day_digit_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_day',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-count',
		);

		$this->options['st_day_digit_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-count',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_day_digit_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-count',
		);

		$this->options['st_day_digit_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days timer-content .timer-count',
		);

		$this->options['st_day_digit_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-count',
		);

		$this->options['st_day_digit_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-count',
			'attribute' => 'margin',
		);

		$this->options['st_day_digit_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-count',
			'attribute' => 'padding',
		);

		$this->options['st_day_digit_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-count',
			'attribute' => 'border-radius',
		);

		$this->options['st_day_label_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'separator' => 'before',
		);

		$this->options['st_day_label_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_day',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-title',
		);

		$this->options['st_day_label_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-title',
		);

		$this->options['st_day_label_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-title',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_day_label_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-title',
		);

		$this->options['st_day_label_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days timer-content .timer-title',
		);

		$this->options['st_day_label_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-title',
			'attribute' => 'margin',
		);

		$this->options['st_day_label_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-title',
			'attribute' => 'padding',
		);

		$this->options['st_day_label_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-content .timer-title',
			'attribute' => 'border-radius',
		);

		$this->options['st_day_background_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'separator' => 'before',
		);

		$this->options['st_day_background_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-inner-container',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_day_background_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-inner-container',
		);

		$this->options['st_day_background_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-inner-container',
		);

		$this->options['st_day_background_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_day',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-inner-container',
			'attribute' => 'border-radius',
		);

		$this->options['st_day_background_vertical_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Vertical Alignment', 'jeg-elementor-kit' ),
			'default'    => 'center',
			'segment'    => 'style_day',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-countdown .timer-days .timer-inner-container' => '-webkit-box-align: {{VALUE}}; -ms-flex-align: {{VALUE}}; align-items: {{VALUE}}',
				),
			),
		);

		$this->options['st_day_background_content_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Content Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_day',
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
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-inner-container .timer-content',
			'attribute'  => 'text-align',
			'default'    => 'center',
		);

		$this->options['st_day_background_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_day',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-inner-container',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_day_background_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_day',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-days .timer-inner-container',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_day_separator_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Separator', 'jeg-elementor-kit' ),
			'segment'    => 'style_day',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_day_separator_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_day',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-days.timer-container:not(:last-child) .timer-inner-container::after',
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_day_separator_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_day',
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-days.timer-container:not(:last-child) .timer-inner-container::after',
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_day_separator_vertical_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Vertical Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_day',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-days.timer-container:not(:last-child) .timer-inner-container::after',
			'attribute'  => 'top',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_day_separator_horizontal_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Horizontal Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_day',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-days.timer-container:not(:last-child) .timer-inner-container::after',
			'attribute'  => 'left',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_hour_digit_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Digit', 'jeg-elementor-kit' ),
			'segment' => 'style_hour',
		);

		$this->options['st_hour_digit_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_hour',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-count',
		);

		$this->options['st_hour_digit_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-count',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_hour_digit_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-count',
		);

		$this->options['st_hour_digit_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours timer-content .timer-count',
		);

		$this->options['st_hour_digit_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-count',
		);

		$this->options['st_hour_digit_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-count',
			'attribute' => 'margin',
		);

		$this->options['st_hour_digit_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-count',
			'attribute' => 'padding',
		);

		$this->options['st_hour_digit_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-count',
			'attribute' => 'border-radius',
		);

		$this->options['st_hour_label_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'separator' => 'before',
		);

		$this->options['st_hour_label_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_hour',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-title',
		);

		$this->options['st_hour_label_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-title',
		);

		$this->options['st_hour_label_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-title',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_hour_label_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-title',
		);

		$this->options['st_hour_label_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours timer-content .timer-title',
		);

		$this->options['st_hour_label_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-title',
			'attribute' => 'margin',
		);

		$this->options['st_hour_label_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-title',
			'attribute' => 'padding',
		);

		$this->options['st_hour_label_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-content .timer-title',
			'attribute' => 'border-radius',
		);

		$this->options['st_hour_background_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'separator' => 'before',
		);

		$this->options['st_hour_background_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-inner-container',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_hour_background_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-inner-container',
		);

		$this->options['st_hour_background_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-inner-container',
		);

		$this->options['st_hour_background_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_hour',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-inner-container',
			'attribute' => 'border-radius',
		);

		$this->options['st_hour_background_vertical_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Vertical Alignment', 'jeg-elementor-kit' ),
			'default'    => 'center',
			'segment'    => 'style_hour',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-countdown .timer-hours .timer-inner-container' => '-webkit-box-align: {{VALUE}}; -ms-flex-align: {{VALUE}}; align-items: {{VALUE}}',
				),
			),
		);

		$this->options['st_hour_background_content_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Content Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_hour',
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
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-inner-container .timer-content',
			'attribute'  => 'text-align',
			'default'    => 'center',
		);

		$this->options['st_hour_background_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_hour',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-inner-container',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_hour_background_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_hour',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-hours .timer-inner-container',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_hour_separator_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Separator', 'jeg-elementor-kit' ),
			'segment'    => 'style_hour',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_hour_separator_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_hour',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-hours.timer-container:not(:last-child) .timer-inner-container::after',
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_hour_separator_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_hour',
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-hours.timer-container:not(:last-child) .timer-inner-container::after',
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_hour_separator_vertical_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Vertical Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_hour',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-hours.timer-container:not(:last-child) .timer-inner-container::after',
			'attribute'  => 'top',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_hour_separator_horizontal_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Horizontal Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_hour',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-hours.timer-container:not(:last-child) .timer-inner-container::after',
			'attribute'  => 'left',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_minute_digit_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Digit', 'jeg-elementor-kit' ),
			'segment' => 'style_minute',
		);

		$this->options['st_minute_digit_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_minute',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-count',
		);

		$this->options['st_minute_digit_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-count',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_minute_digit_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-count',
		);

		$this->options['st_minute_digit_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes timer-content .timer-count',
		);

		$this->options['st_minute_digit_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-count',
		);

		$this->options['st_minute_digit_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-count',
			'attribute' => 'margin',
		);

		$this->options['st_minute_digit_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-count',
			'attribute' => 'padding',
		);

		$this->options['st_minute_digit_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-count',
			'attribute' => 'border-radius',
		);

		$this->options['st_minute_label_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'separator' => 'before',
		);

		$this->options['st_minute_label_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_minute',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-title',
		);

		$this->options['st_minute_label_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-title',
		);

		$this->options['st_minute_label_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-title',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_minute_label_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-title',
		);

		$this->options['st_minute_label_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes timer-content .timer-title',
		);

		$this->options['st_minute_label_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-title',
			'attribute' => 'margin',
		);

		$this->options['st_minute_label_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-title',
			'attribute' => 'padding',
		);

		$this->options['st_minute_label_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-content .timer-title',
			'attribute' => 'border-radius',
		);

		$this->options['st_minute_background_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'separator' => 'before',
		);

		$this->options['st_minute_background_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-inner-container',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_minute_background_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-inner-container',
		);

		$this->options['st_minute_background_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-inner-container',
		);

		$this->options['st_minute_background_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_minute',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-inner-container',
			'attribute' => 'border-radius',
		);

		$this->options['st_minute_background_vertical_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Vertical Alignment', 'jeg-elementor-kit' ),
			'default'    => 'center',
			'segment'    => 'style_minute',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-countdown .timer-minutes .timer-inner-container' => '-webkit-box-align: {{VALUE}}; -ms-flex-align: {{VALUE}}; align-items: {{VALUE}}',
				),
			),
		);

		$this->options['st_minute_background_content_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Content Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_minute',
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
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-inner-container .timer-content',
			'attribute'  => 'text-align',
			'default'    => 'center',
		);

		$this->options['st_minute_background_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_minute',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-inner-container',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_minute_background_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_minute',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-minutes .timer-inner-container',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_minute_separator_heading'] = array(
			'type'       => 'heading',
			'title'      => esc_html__( 'Separator', 'jeg-elementor-kit' ),
			'segment'    => 'style_minute',
			'separator'  => 'before',
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_minute_separator_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_minute',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-minutes.timer-container:not(:last-child) .timer-inner-container::after',
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_minute_separator_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_minute',
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-minutes.timer-container:not(:last-child) .timer-inner-container::after',
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_minute_separator_vertical_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Vertical Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_minute',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-minutes.timer-container:not(:last-child) .timer-inner-container::after',
			'attribute'  => 'top',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_minute_separator_horizontal_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Horizontal Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_minute',
			'options'    => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown.separator-enable .timer-minutes.timer-container:not(:last-child) .timer-inner-container::after',
			'attribute'  => 'left',
			'responsive' => true,
			'dependency' => array(
				array(
					'field'    => 'sg_content_separator_enable',
					'operator' => '==',
					'value'    => true,
				),
			),
		);

		$this->options['st_second_digit_heading'] = array(
			'type'    => 'heading',
			'title'   => esc_html__( 'Digit', 'jeg-elementor-kit' ),
			'segment' => 'style_second',
		);

		$this->options['st_second_digit_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_second',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-count',
		);

		$this->options['st_second_digit_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-count',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_second_digit_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-count',
		);

		$this->options['st_second_digit_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds timer-content .timer-count',
		);

		$this->options['st_second_digit_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-count',
		);

		$this->options['st_second_digit_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-count',
			'attribute' => 'margin',
		);

		$this->options['st_second_digit_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-count',
			'attribute' => 'padding',
		);

		$this->options['st_second_digit_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-count',
			'attribute' => 'border-radius',
		);

		$this->options['st_second_label_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Label', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'separator' => 'before',
		);

		$this->options['st_second_label_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_second',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-title',
		);

		$this->options['st_second_label_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-title',
		);

		$this->options['st_second_label_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-title',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_second_label_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-title',
		);

		$this->options['st_second_label_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds timer-content .timer-title',
		);

		$this->options['st_second_label_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-title',
			'attribute' => 'margin',
		);

		$this->options['st_second_label_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-title',
			'attribute' => 'padding',
		);

		$this->options['st_second_label_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-content .timer-title',
			'attribute' => 'border-radius',
		);

		$this->options['st_second_background_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'separator' => 'before',
		);

		$this->options['st_second_background_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-inner-container',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_second_background_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-inner-container',
		);

		$this->options['st_second_background_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-inner-container',
		);

		$this->options['st_second_background_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_second',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-inner-container',
			'attribute' => 'border-radius',
		);

		$this->options['st_second_background_vertical_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Vertical Alignment', 'jeg-elementor-kit' ),
			'default'    => 'center',
			'segment'    => 'style_second',
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-countdown .timer-seconds .timer-inner-container' => '-webkit-box-align: {{VALUE}}; -ms-flex-align: {{VALUE}}; align-items: {{VALUE}}',
				),
			),
		);

		$this->options['st_second_background_content_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Content Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_second',
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
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-inner-container .timer-content',
			'attribute'  => 'text-align',
			'default'    => 'center',
		);

		$this->options['st_second_background_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_second',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-inner-container',
			'attribute'  => 'width',
			'responsive' => true,
		);

		$this->options['st_second_background_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_second',
			'options'    => array(
				'min'  => 0,
				'max'  => 500,
				'step' => 1,
			),
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .timer-seconds .timer-inner-container',
			'attribute'  => 'height',
			'responsive' => true,
		);

		$this->options['st_expire_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_expire',
			'default'    => 'left',
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
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .expire-message',
			'attribute'  => 'text-align',
		);

		$this->options['st_expire_title_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'segment'   => 'style_expire',
			'separator' => 'before',
		);

		$this->options['st_expire_title_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_expire',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .expire-message .expire-title',
		);

		$this->options['st_expire_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_expire',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .expire-message .expire-title',
		);

		$this->options['st_expire_title_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_expire',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .expire-message .expire-title',
			'attribute' => 'margin',
		);

		$this->options['st_expire_content_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Content', 'jeg-elementor-kit' ),
			'segment'   => 'style_expire',
			'separator' => 'before',
		);

		$this->options['st_expire_content_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_expire',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-countdown .expire-message .expire-content',
		);

		$this->options['st_expire_content_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_expire',
			'selectors' => '.jeg-elementor-kit.jkit-countdown .expire-message .expire-content',
		);

		$this->options['st_expire_content_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_expire',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-countdown .expire-message .expire-content',
			'attribute' => 'margin',
		);

		parent::additional_style();
	}
}
