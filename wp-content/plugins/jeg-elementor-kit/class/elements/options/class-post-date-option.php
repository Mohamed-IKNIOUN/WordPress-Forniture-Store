<?php
/**
 * Post Date Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Post_Date_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Post_Date_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Post Date', 'jeg-elementor-kit' );
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
		$this->segments['segment_date'] = array(
			'name'     => esc_html__( 'Post Date', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_date'] = array(
			'name'      => esc_html__( 'Post Date', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_date_type'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Post Date Type', 'jeg-elementor-kit' ),
			'default' => 'published',
			'segment' => 'segment_date',
			'options' => array(
				'published' => esc_html__( 'Published Date', 'jeg-elementor-kit' ),
				'modified'  => esc_html__( 'Modified Date', 'jeg-elementor-kit' ),
				'both'      => esc_html__( 'Show Both', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_date_format'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Post Date Format', 'jeg-elementor-kit' ),
			'default' => 'default',
			'segment' => 'segment_date',
			'options' => array(
				'ago'     => esc_attr__( 'Relative Date/Time Format (ago)', 'jeg-elementor-kit' ),
				'default' => esc_attr__( 'WordPress Default Format', 'jeg-elementor-kit' ),
				'custom'  => esc_attr__( 'Custom Format', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_date_format_custom'] = array(
			'type'        => 'text',
			'title'       => esc_html__( 'Post Date Custom Format', 'jeg-elementor-kit' ),
			/* translators: %s: https://wordpress.org/support/article/formatting-date-and-time/ */
			'description' => wp_kses( sprintf( __( 'Insert custom date format for single post meta. For more detail about this format, please refer to <a href="%s" target="_blank">Developer Codex</a>.', 'jeg-elementor-kit' ), 'https://wordpress.org/support/article/formatting-date-and-time/' ), wp_kses_allowed_html() ),
			'default'     => get_option( 'date_format' ),
			'segment'     => 'segment_date',
			'dependency'  => array(
				array(
					'field'    => 'sg_date_format',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);

		$this->options['sg_date_html_tag'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'HTML Tag', 'jeg-elementor-kit' ),
			'default' => 'p',
			'segment' => 'segment_date',
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

		$this->options['sg_date_link_to'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Link To', 'jeg-elementor-kit' ),
			'default' => 'none',
			'segment' => 'segment_date',
			'options' => array(
				'none'   => esc_html__( 'None', 'jeg-elementor-kit' ),
				'home'   => esc_html__( 'Home URL', 'jeg-elementor-kit' ),
				'post'   => esc_html__( 'Post URL', 'jeg-elementor-kit' ),
				'date'   => esc_html__( 'Date URL', 'jeg-elementor-kit' ),
				'custom' => esc_html__( 'Custom URL', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_date_link_to_custom'] = array(
			'type'       => 'link',
			'title'      => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment'    => 'segment_date',
			'dependency' => array(
				array(
					'field'    => 'sg_date_link_to',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_date_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_date',
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
			'selectors'  => '.jeg-elementor-kit.jkit-post-date',
			'attribute'  => 'text-align',
		);

		$this->options['st_date_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_date',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-post-date .post-date, {{WRAPPER}} .jeg-elementor-kit.jkit-post-date .post-date a',
			),
		);

		$this->options['st_date_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_date',
		);

		$this->options['st_date_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_date',
		);

		$this->options['st_date_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_date',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-date .post-date, {{WRAPPER}} .jeg-elementor-kit.jkit-post-date .post-date a' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_date_normal_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Normal Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_date',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-post-date .post-date, {{WRAPPER}} .jeg-elementor-kit.jkit-post-date .post-date a',
			),
		);

		$this->options['st_date_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_date',
		);

		$this->options['st_date_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_date',
		);

		$this->options['st_date_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_date',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-date:hover .post-date, {{WRAPPER}} .jeg-elementor-kit.jkit-post-date:hover .post-date a' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_date_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Hover Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_date',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-post-date:hover .post-date, {{WRAPPER}} .jeg-elementor-kit.jkit-post-date:hover .post-date a',
			),
		);

		$this->options['st_date_hover_animation'] = array(
			'type'    => 'hoveranimation',
			'title'   => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment' => 'style_date',
		);

		$this->options['st_date_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_date',
		);

		$this->options['st_date_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_date',
		);

		parent::additional_style();
	}
}
