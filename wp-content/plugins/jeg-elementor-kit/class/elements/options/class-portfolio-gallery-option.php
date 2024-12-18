<?php
/**
 * Portfolio Gallery Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Portfolio_Gallery_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Portfolio_Gallery_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Portfolio Gallery', 'jeg-elementor-kit' );
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
		$this->segments['segment_setting'] = array(
			'name'     => esc_html__( 'Setting', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->segments['segment_gallery'] = array(
			'name'     => esc_html__( 'Gallery', 'jeg-elementor-kit' ),
			'priority' => 11,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_container'] = array(
			'name'      => esc_html__( 'Container', 'jeg-elementor-kit' ),
			'priority'  => 10,
			'kit_style' => true,
		);

		$this->segments['style_title'] = array(
			'name'      => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		$this->segments['style_more'] = array(
			'name'      => esc_html__( 'View More', 'jeg-elementor-kit' ),
			'priority'  => 12,
			'kit_style' => true,
		);

		$this->segments['style_active'] = array(
			'name'      => esc_html__( 'Active Item', 'jeg-elementor-kit' ),
			'priority'  => 13,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_setting_behavior'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Active Behavior', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
			'default' => 'hover',
			'options' => array(
				'hover' => esc_html__( 'On Hover', 'jeg-elementor-kit' ),
				'click' => esc_html__( 'On Click', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_setting_title_tag'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Title HTML Tag', 'jeg-elementor-kit' ),
			'default' => 'h2',
			'segment' => 'segment_setting',
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

		$this->options['sg_setting_column'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Column', 'jeg-elementor-kit' ),
			'segment'    => 'segment_setting',
			'default'    => 5,
			'options'    => array(
				'min'  => 1,
				'max'  => 10,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-portfolio-gallery .row-item' => '-ms-flex: 0 0 calc(100% / {{SIZE}}); flex: 0 0 calc(100% / {{SIZE}}); max-width: calc(100% / {{SIZE}});',
				),
			),
		);

		$this->options['sg_setting_more_enable'] = array(
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Enable View More', 'jeg-elementor-kit' ),
			'segment' => 'segment_setting',
		);

		$this->options['sg_gallery_image_size'] = array(
			'type'    => 'imagesize',
			'title'   => esc_html__( 'Image Size', 'jeg-elementor-kit' ),
			'default' => 'large',
			'segment' => 'segment_gallery',
		);

		$this->options['sg_gallery_list'] = array(
			'type'        => 'repeater',
			'title'       => esc_html__( 'Gallery List', 'jeg-elementor-kit' ),
			'segment'     => 'segment_gallery',
			'title_field' => '{{ sg_gallery_list_title }}',
			'fields'      => array(
				'sg_gallery_list_title'              => array(
					'type'    => 'text',
					'segment' => 'sg_gallery_list',
					'title'   => esc_html__( 'Title', 'jeg-elementor-kit' ),
					'default' => esc_html__( 'Title', 'jeg-elementor-kit' ),
				),
				'sg_gallery_list_subtitle'           => array(
					'type'    => 'text',
					'segment' => 'sg_gallery_list',
					'title'   => esc_html__( 'Sub Title', 'jeg-elementor-kit' ),
					'default' => esc_html__( 'Sub Title', 'jeg-elementor-kit' ),
				),
				'sg_gallery_list_more_link'          => array(
					'type'    => 'link',
					'segment' => 'sg_gallery_list',
					'title'   => esc_html__( 'View More Link', 'jeg-elementor-kit' ),
				),
				'sg_gallery_list_more_text'          => array(
					'type'    => 'text',
					'segment' => 'sg_gallery_list',
					'title'   => esc_html__( 'View More Text', 'jeg-elementor-kit' ),
					'default' => esc_html__( 'View More', 'jeg-elementor-kit' ),
				),
				'sg_gallery_list_more_icon'          => array(
					'type'    => 'iconpicker',
					'segment' => 'sg_gallery_list',
					'title'   => esc_html__( 'Load More Icon', 'jeg-elementor-kit' ),
					'default' => array(
						'value'   => 'fas fa-angle-right',
						'library' => 'fa-solid',
					),
				),
				'sg_gallery_list_more_icon_position' => array(
					'type'    => 'select',
					'segment' => 'sg_gallery_list',
					'title'   => esc_html__( 'Load More Icon Position', 'jeg-elementor-kit' ),
					'default' => 'after',
					'options' => array(
						'before' => esc_html__( 'Before', 'jeg-elementor-kit' ),
						'after'  => esc_html__( 'After', 'jeg-elementor-kit' ),
					),
				),
				'sg_gallery_list_image'              => array(
					'type'    => 'image',
					'segment' => 'sg_gallery_list',
					'title'   => esc_html__( 'Image', 'jeg-elementor-kit' ),
					'default' => \Elementor\Utils::get_placeholder_image_src(),
				),
				'sg_gallery_list_current'            => array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Set Current Item', 'jeg-elementor-kit' ),
					'segment'     => 'sg_gallery_list',
					'description' => esc_html__( 'Current item will be set to the last item', 'jeg-elementor-kit' ),
				),
			),
			'default'     => array(
				array(
					'sg_gallery_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_gallery_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_gallery_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_gallery_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
				array(
					'sg_gallery_list_image' => array(
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					),
				),
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_container_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery',
			'attribute' => 'margin',
		);

		$this->options['st_container_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery',
			'attribute' => 'padding',
		);

		$this->options['st_container_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery',
			'attribute' => 'border-radius',
		);

		$this->options['st_container_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_container_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery',
		);

		$this->options['st_container_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_container',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery',
		);

		$this->options['st_container_row_height'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Row Height', 'jeg-elementor-kit' ),
			'segment'      => 'style_container',
			'default'      => 90,
			'units'        => array( 'px', 'em', 'vh' ),
			'default_unit' => 'vh',
			'options'      => array(
				'min'  => 1,
				'max'  => 1000,
				'step' => 1,
			),
			'responsive'   => true,
			'selectors'    => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item',
			'attribute'    => 'height',
		);

		$this->options['st_title_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_title',
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
			'selectors'  => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-info',
			'attribute'  => 'text-align',
		);

		$this->options['st_title_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-info',
			'attribute' => 'padding',
		);

		$this->options['st_title_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'separator' => 'before',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-info:after',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_title_title_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Title', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'separator' => 'before',
		);

		$this->options['st_title_title_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Title Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-info .info-title',
		);

		$this->options['st_title_title_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Title Color', 'jeg-elementor-kit' ),
			'selectors'  => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-info .info-title',
			'responsive' => true,
			'segment'    => 'style_title',
		);

		$this->options['st_title_hover_title_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Title Color', 'jeg-elementor-kit' ),
			'selectors'  => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item:hover .row-item-info .info-title',
			'responsive' => true,
			'segment'    => 'style_title',
		);

		$this->options['st_title_title_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Title Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-info .info-title',
		);

		$this->options['st_title_hover_title_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Hover Title Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item:hover .row-item-info .info-title',
		);

		$this->options['st_title_subtitle_heading'] = array(
			'type'      => 'heading',
			'title'     => esc_html__( 'Sub Title', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'separator' => 'before',
		);

		$this->options['st_title_subtitle_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Sub Title Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-info .info-subtitle',
		);

		$this->options['st_title_subtitle_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Sub Title Color', 'jeg-elementor-kit' ),
			'selectors'  => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-info .info-subtitle',
			'responsive' => true,
			'segment'    => 'style_title',
		);

		$this->options['st_title_hover_subtitle_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Sub Title Hover Color', 'jeg-elementor-kit' ),
			'selectors'  => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item:hover .row-item-info .info-subtitle',
			'responsive' => true,
			'segment'    => 'style_title',
		);

		$this->options['st_title_subtitle_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Sub Title Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-info .info-title',
		);

		$this->options['st_title_subtitle_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Sub Title Hover Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_title',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item:hover .row-item-info .info-title',
		);

		$this->options['st_more_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_more',
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
			'default'    => 'right',
			'selectors'  => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more',
			'attribute'  => 'text-align',
		);

		$this->options['st_more_margin'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Margin', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more a',
			'attribute' => 'margin',
		);

		$this->options['st_more_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more a',
		);

		$this->options['st_more_icon_spacing'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Spacing', 'jeg-elementor-kit' ),
			'segment'    => 'style_more',
			'default'    => 5,
			'options'    => array(
				'min'  => 1,
				'max'  => 50,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-portfolio-gallery .row-item-more.position-after i, {{WRAPPER}} .jeg-elementor-kit.jkit-portfolio-gallery .row-item-more.position-after svg'   => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-portfolio-gallery .row-item-more.position-before i, {{WRAPPER}} .jeg-elementor-kit.jkit-portfolio-gallery .row-item-more.position-before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_more_icon_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Icon Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_more',
			'options'    => array(
				'min'  => 1,
				'max'  => 200,
				'step' => 1,
			),
			'units'      => array( 'px', 'em' ),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-portfolio-gallery .row-item-more i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-portfolio-gallery .row-item-more svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->options['st_more_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_more',
		);

		$this->options['st_more_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_more',
		);

		$this->options['st_more_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_more',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-portfolio-gallery .row-item-more a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-portfolio-gallery .row-item-more a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_more_normal_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Normal Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more a',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_more_normal_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more a',
			'attribute' => 'padding',
		);

		$this->options['st_more_normal_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Normal Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more a',
			'attribute' => 'border-radius',
		);

		$this->options['st_more_normal_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Normal Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more a',
		);

		$this->options['st_more_normal_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Normal Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more a',
		);

		$this->options['st_more_normal_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Normal Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more a',
		);

		$this->options['st_more_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_more',
		);

		$this->options['st_more_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_more',
		);

		$this->options['st_more_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'responsive' => true,
			'segment'    => 'style_more',
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-portfolio-gallery .row-item-more:hover a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .jeg-elementor-kit.jkit-portfolio-gallery .row-item-more:hover a svg' => 'fill: {{VALUE}};',
				),
			),
		);

		$this->options['st_more_hover_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Hover Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more:hover a',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		$this->options['st_more_hover_padding'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Padding', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more:hover a',
			'attribute' => 'padding',
		);

		$this->options['st_more_hover_border_radius'] = array(
			'type'      => 'dimension',
			'title'     => esc_html__( 'Hover Border Radius', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'units'     => array( 'px', '%', 'em' ),
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more:hover a',
			'attribute' => 'border-radius',
		);

		$this->options['st_more_hover_border'] = array(
			'type'      => 'border',
			'title'     => esc_html__( 'Hover Border', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more:hover a',
		);

		$this->options['st_more_hover_boxshadow'] = array(
			'type'      => 'boxshadow',
			'title'     => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more:hover a',
		);

		$this->options['st_more_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Hover Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_more',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item-more:hover a',
		);

		$this->options['st_more_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_more',
		);

		$this->options['st_more_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_more',
		);

		$this->options['st_active_background'] = array(
			'type'      => 'background',
			'title'     => esc_html__( 'Background', 'jeg-elementor-kit' ),
			'segment'   => 'style_active',
			'selectors' => '.jeg-elementor-kit.jkit-portfolio-gallery .row-item.current-item:before',
			'options'   => array(
				'classic',
				'gradient',
			),
		);

		parent::additional_style();
	}
}
