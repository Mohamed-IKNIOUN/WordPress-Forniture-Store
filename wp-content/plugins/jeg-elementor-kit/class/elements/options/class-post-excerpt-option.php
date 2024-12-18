<?php
/**
 * Post Excerpt Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Post_Excerpt_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Post_Excerpt_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Post Excerpt', 'jeg-elementor-kit' );
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
		$this->segments['segment_excerpt'] = array(
			'name'     => esc_html__( 'Post Excerpt', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_excerpt'] = array(
			'name'      => esc_html__( 'Post Excerpt', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_excerpt_html_tag'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'HTML Tag', 'jeg-elementor-kit' ),
			'default' => 'p',
			'segment' => 'segment_excerpt',
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

		$this->options['sg_excerpt_link_to'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Link To', 'jeg-elementor-kit' ),
			'default' => 'none',
			'segment' => 'segment_excerpt',
			'options' => array(
				'none'   => esc_html__( 'None', 'jeg-elementor-kit' ),
				'home'   => esc_html__( 'Home URL', 'jeg-elementor-kit' ),
				'post'   => esc_html__( 'Post URL', 'jeg-elementor-kit' ),
				'custom' => esc_html__( 'Custom URL', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_excerpt_link_to_custom'] = array(
			'type'       => 'link',
			'title'      => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment'    => 'segment_excerpt',
			'dependency' => array(
				array(
					'field'    => 'sg_excerpt_link_to',
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
		$this->options['st_excerpt_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_excerpt',
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
			'selectors'  => '.jeg-elementor-kit.jkit-post-excerpt',
			'attribute'  => 'text-align',
		);

		$this->options['st_excerpt_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_excerpt',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-post-excerpt .post-excerpt, {{WRAPPER}} .jeg-elementor-kit.jkit-post-excerpt .post-excerpt a',
			),
		);

		$this->options['st_excerpt_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_excerpt',
		);

		$this->options['st_excerpt_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_excerpt',
		);

		$this->options['st_excerpt_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_excerpt',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-excerpt .post-excerpt, {{WRAPPER}} .jeg-elementor-kit.jkit-post-excerpt .post-excerpt a' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_excerpt_normal_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Normal Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_excerpt',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-post-excerpt .post-excerpt, {{WRAPPER}} .jeg-elementor-kit.jkit-post-excerpt .post-excerpt a',
			),
		);

		$this->options['st_excerpt_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_excerpt',
		);

		$this->options['st_excerpt_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_excerpt',
		);

		$this->options['st_excerpt_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_excerpt',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-excerpt:hover .post-excerpt, {{WRAPPER}} .jeg-elementor-kit.jkit-post-excerpt:hover .post-excerpt a' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_excerpt_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Hover Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_excerpt',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-post-excerpt:hover .post-excerpt, {{WRAPPER}} .jeg-elementor-kit.jkit-post-excerpt:hover .post-excerpt a',
			),
		);

		$this->options['st_excerpt_hover_animation'] = array(
			'type'    => 'hoveranimation',
			'title'   => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment' => 'style_excerpt',
		);

		$this->options['st_excerpt_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_excerpt',
		);

		$this->options['st_excerpt_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_excerpt',
		);

		parent::additional_style();
	}
}
