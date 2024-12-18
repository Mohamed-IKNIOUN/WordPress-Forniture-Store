<?php
/**
 * Progress Bar Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Progress_Bar_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Progress_Bar_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Progress Bar', 'jeg-elementor-kit' );
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
		$this->segments['segment_progress'] = array(
			'name'     => esc_html__( 'Progress Bar', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_bar'] = array(
			'name'      => esc_html__( 'Bar', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_track'] = array(
			'name'      => esc_html__( 'Track', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_title'] = array(
			'name'      => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		$this->segments['style_percent'] = array(
			'name'      => esc_html__( 'Percent', 'jeg-elementor-kit' ),
			'priority'  => 14,
			'kit_style' => true,
		);

		$this->segments['style_icon'] = array(
			'name'       => esc_html__( 'Icon', 'jeg-elementor-kit' ),
			'priority'   => 15,
			'kit_style'  => true,
			'dependency' => array(
				array(
					'field'    => 'sg_progress_style',
					'operator' => '==',
					'value'    => 'inner-content',
				),
			),
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_progress_style'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Style', 'jeg-elementor-kit' ),
			'segment' => 'segment_progress',
			'options' => array(
				'default'         => esc_html__( 'Default', 'jeg-elementor-kit' ),
				'inner-content'   => esc_html__( 'Inner Content', 'jeg-elementor-kit' ),
				'bar-shadow'      => esc_html__( 'Bar Shadow', 'jeg-elementor-kit' ),
				'tooltip-style'   => esc_html__( 'Tooltip', 'jeg-elementor-kit' ),
				'tooltip-box'     => esc_html__( 'Tooltip Box', 'jeg-elementor-kit' ),
				'tooltip-rounded' => esc_html__( 'Tooltip Rounded', 'jeg-elementor-kit' ),
				'tooltip-circle'  => esc_html__( 'Tooltip Circle', 'jeg-elementor-kit' ),
				'switch'          => esc_html__( 'Switch', 'jeg-elementor-kit' ),
				'ribbon'          => esc_html__( 'Ribbon', 'jeg-elementor-kit' ),
				'stripe'          => esc_html__( 'Stripe', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_progress_icon'] = array(
			'type'       => 'iconpicker',
			'title'      => esc_html__( 'Add Icon', 'jeg-elementor-kit' ),
			'default'    => array(
				'value'   => 'fas fa-arrow-right',
				'library' => 'fa-solid',
			),
			'segment'    => 'segment_progress',
			'dependency' => array(
				array(
					'field'    => 'sg_progress_style',
					'operator' => '==',
					'value'    => 'inner-content',
				),
			),
		);

		$this->options['sg_progress_title'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'default' => 'Progress Bar',
			'segment' => 'segment_progress',
		);

		$this->options['sg_progress_percentage'] = array(
			'type'    => 'slider',
			'title'   => esc_html__( 'Percentage', 'jeg-elementor-kit' ),
			'segment' => 'segment_progress',
			'default' => 80,
			'options' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		);

		$this->options['sg_progress_duration'] = array(
			'type'    => 'slider',
			'title'   => esc_html__( 'Animation Duration', 'jeg-elementor-kit' ),
			'segment' => 'segment_progress',
			'default' => 3500,
			'options' => array(
				'min'  => 100,
				'max'  => 10000,
				'step' => 1,
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_bar_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_bar',
			'selectors' => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_bar_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_bar',
			'options'    => array(
				'min'  => 1,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar',
			'attribute'  => 'height',
			'dependency' => array(
				array(
					'field'    => 'sg_progress_style!',
					'operator' => '==',
					'value'    => 'switch',
				),
			),
		);

		$this->options['st_bar_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_bar',
			'selectors' => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar',
		);

		$this->options['st_bar_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_bar',
			'units'     => array( 'px', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar',
			'attribute' => 'border-radius',
		);

		$this->options['st_bar_padding'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'    => 'style_bar',
			'units'      => array( 'px', '%' ),
			'selectors'  => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar',
			'attribute'  => 'padding',
			'dependency' => array(
				array(
					'field'    => 'sg_progress_style!',
					'operator' => '==',
					'value'    => 'switch',
				),
			),
		);

		$this->options['st_bar_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_bar',
			'units'     => array( 'px', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar',
			'attribute' => 'margin',
		);

		$this->options['st_track_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_track',
			'selectors'  => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar .skill-track',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_progress_style!',
					'operator' => '==',
					'value'    => 'stripe',
				),
			),
		);

		$this->options['st_track_switch_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Switch Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_track',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-progress-bar .progress-group.switch .progress-skill-bar .content-group .skill-bar .skill-track:before' => 'border: 1px solid {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-progress-bar .progress-group.switch .progress-skill-bar .content-group .skill-bar .skill-track:after'  => 'background-color: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_progress_style',
					'operator' => '==',
					'value'    => 'switch',
				),
			),
		);

		$this->options['st_track_switch_background'] = array(
			'type'       => 'background',
			'title'      => esc_html__( 'Switch Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_track',
			'selectors'  => '.jeg-elementor-kit.jkit-progress-bar .progress-group.switch .progress-skill-bar .content-group .skill-bar .skill-track:before',
			'options'    => array(
				'classic',
				'gradient',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_progress_style',
					'operator' => '==',
					'value'    => 'switch',
				),
			),
		);

		$this->options['st_track_stripe_color'] = array(
			'type'        => 'color',
			'title'       => esc_html__( 'Stripe Color', 'jeg-elementor-kit' ),
			'segment'     => 'style_track',
			'responsive'  => true,
			'render_type' => 'ui',
			'dependency'  => array(
				array(
					'field'    => 'sg_progress_style',
					'operator' => '==',
					'value'    => 'stripe',
				),
			),
		);

		$this->options['st_track_stripe_background_color'] = array(
			'type'        => 'color',
			'title'       => esc_html__( 'Stripe Background Color', 'jeg-elementor-kit' ),
			'segment'     => 'style_track',
			'responsive'  => true,
			'render_type' => 'ui',
			'dependency'  => array(
				array(
					'field'    => 'sg_progress_style',
					'operator' => '==',
					'value'    => 'stripe',
				),
			),
		);

		$this->options['st_track_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_track',
			'selectors' => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar .skill-track',
		);

		$this->options['st_track_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_track',
			'units'     => array( 'px', '%' ),
			'selectors' => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar .skill-track',
			'attribute' => 'border-radius',
		);

		$this->options['st_title_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar-content .skill-title',
		);

		$this->options['st_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Title Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar-content .skill-title',
		);

		$this->options['st_title_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Title Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar-content .skill-title',
		);

		$this->options['st_percent_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_percent',
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .number-percentage',
		);

		$this->options['st_percent_background'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'    => 'style_percent',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar .skill-track .number-percentage-wrapper:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar .skill-track .number-percentage-wrapper' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-progress-bar .progress-group.stripe .progress-skill-bar .skill-bar .skill-track .number-percentage-wrapper:before, {{WRAPPER}} .jeg-elementor-kit.jkit-progress-bar .progress-group.tooltip-box .progress-skill-bar .skill-bar .skill-track .number-percentage-wrapper:before, {{WRAPPER}} .jeg-elementor-kit.jkit-progress-bar .progress-group.tooltip-rounded .progress-skill-bar .skill-bar .skill-track .number-percentage-wrapper:before, {{WRAPPER}} .jeg-elementor-kit.jkit-progress-bar .progress-group.tooltip-circle .progress-skill-bar .skill-bar .skill-track .number-percentage-wrapper:before' => 'background-color: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_progress_style',
					'operator' => 'in',
					'value'    => array( 'tooltip-style', 'tooltip-box', 'tooltip-circle', 'tooltip-rounded', 'ribbon', 'stripe' ),
				),
			),
		);

		$this->options['st_percent_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Percentage Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_percent',
			'selectors' => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .number-percentage',
		);

		$this->options['st_percent_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Percentage Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_percent',
			'selectors' => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .number-percentage',
		);

		$this->options['st_percent_wrapper_width'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Width', 'jeg-elementor-kit' ),
			'segment'    => 'style_percent',
			'options'    => array(
				'min'  => 1,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar .skill-track .number-percentage-wrapper',
			'attribute'  => 'width',
			'dependency' => array(
				array(
					'field'    => 'sg_progress_style',
					'operator' => 'in',
					'value'    => array( 'tooltip-style', 'tooltip-box', 'tooltip-circle', 'tooltip-rounded', 'ribbon', 'stripe' ),
				),
			),
		);

		$this->options['st_percent_wrapper_height'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Height', 'jeg-elementor-kit' ),
			'segment'    => 'style_percent',
			'options'    => array(
				'min'  => 1,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar .skill-track .number-percentage-wrapper',
			'attribute'  => 'height',
			'dependency' => array(
				array(
					'field'    => 'sg_progress_style',
					'operator' => 'in',
					'value'    => array( 'tooltip-style', 'tooltip-box', 'tooltip-circle', 'tooltip-rounded', 'ribbon', 'stripe' ),
				),
			),
		);

		$this->options['st_percent_wrapper_top_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Top Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_percent',
			'options'    => array(
				'min'  => -200,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar .skill-track .number-percentage-wrapper',
			'attribute'  => 'top',
			'dependency' => array(
				array(
					'field'    => 'sg_progress_style',
					'operator' => 'in',
					'value'    => array( 'tooltip-style', 'tooltip-box', 'tooltip-circle', 'tooltip-rounded', 'stripe' ),
				),
			),
		);

		$this->options['st_percent_wrapper_right_position'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Right Position', 'jeg-elementor-kit' ),
			'segment'    => 'style_percent',
			'options'    => array(
				'min'  => -200,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-progress-bar .progress-group .progress-skill-bar .skill-bar .skill-track .number-percentage-wrapper',
			'attribute'  => 'right',
			'dependency' => array(
				array(
					'field'    => 'sg_progress_style',
					'operator' => 'in',
					'value'    => array( 'tooltip-style', 'tooltip-box', 'tooltip-circle', 'tooltip-rounded', 'stripe' ),
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
					'{{WRAPPER}} .jeg-elementor-kit.jkit-progress-bar .progress-group.inner-content .progress-skill-bar .skill-bar .skill-track .skill-track-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-progress-bar .progress-group.inner-content .progress-skill-bar .skill-bar .skill-track .skill-track-icon svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_icon',
			'options'    => array(
				'min'  => 1,
				'max'  => 200,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-progress-bar .progress-group.inner-content .progress-skill-bar .skill-bar .skill-track .skill-track-icon i',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-progress-bar .progress-group.inner-content .progress-skill-bar .skill-bar .skill-track .skill-track-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-progress-bar .progress-group.inner-content .progress-skill-bar .skill-bar .skill-track .skill-track-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		parent::additional_style();
	}
}
