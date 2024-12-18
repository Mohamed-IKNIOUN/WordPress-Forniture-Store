<?php
/**
 * Post Terms Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Post_Terms_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Post_Terms_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Post Terms', 'jeg-elementor-kit' );
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
		$this->segments['segment_term'] = array(
			'name'     => esc_html__( 'Post Terms', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_term'] = array(
			'name'      => esc_html__( 'Post Terms', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_term_taxonomy'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Taxonomy', 'jeg-elementor-kit' ),
			'default' => 'category',
			'segment' => 'segment_term',
			'options' => array(
				'category'    => esc_html__( 'Category', 'jeg-elementor-kit' ),
				'post_tag'    => esc_html__( 'Post Tag', 'jeg-elementor-kit' ),
				'post_format' => esc_html__( 'Post Format', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_term_separator'] = array(
			'type'        => 'text',
			'title'       => esc_html__( 'Separator', 'jeg-elementor-kit' ),
			'segment'     => 'segment_term',
			'default'     => ', ',
			'label_block' => false,
		);

		$this->options['sg_term_html_tag'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'HTML Tag', 'jeg-elementor-kit' ),
			'default' => 'span',
			'segment' => 'segment_term',
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

		$this->options['sg_term_link_to'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Link To', 'jeg-elementor-kit' ),
			'default' => 'none',
			'segment' => 'segment_term',
			'options' => array(
				'none' => esc_html__( 'None', 'jeg-elementor-kit' ),
				'term' => esc_html__( 'Terms', 'jeg-elementor-kit' ),
			),
		);
	}

	/**
	 * Add Additional Style.
	 */
	public function additional_style() {
		$this->options['st_term_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_term',
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
			'selectors'  => '.jeg-elementor-kit.jkit-post-terms',
			'attribute'  => 'text-align',
		);

		$this->options['st_term_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_term',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-post-terms .post-terms, {{WRAPPER}} .jeg-elementor-kit.jkit-post-terms .term-list, {{WRAPPER}} .jeg-elementor-kit.jkit-post-terms .term-list a',
			),
		);

		$this->options['st_term_tabs_start'] = array(
			'type'    => 'control_tabs_start',
			'segment' => 'style_term',
		);

		$this->options['st_term_normal_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment' => 'style_term',
		);

		$this->options['st_term_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_term',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-terms .post-terms, {{WRAPPER}} .jeg-elementor-kit.jkit-post-terms .term-list, {{WRAPPER}} .jeg-elementor-kit.jkit-post-terms .term-list a' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_term_normal_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Normal Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_term',
			'selectors' => '.jeg-elementor-kit.jkit-post-terms .term-list',
		);

		$this->options['st_term_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_term',
		);

		$this->options['st_term_hover_tab_start'] = array(
			'type'    => 'control_tab_start',
			'title'   => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment' => 'style_term',
		);

		$this->options['st_term_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_term',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-terms .term-list:hover, {{WRAPPER}} .jeg-elementor-kit.jkit-post-terms .term-list:hover a' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_term_hover_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Hover Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_term',
			'selectors' => '.jeg-elementor-kit.jkit-post-terms .term-list:hover',
		);

		$this->options['st_term_hover_animation'] = array(
			'type'    => 'hoveranimation',
			'title'   => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment' => 'style_term',
		);

		$this->options['st_term_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_term',
		);

		$this->options['st_term_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_term',
		);

		parent::additional_style();
	}
}
