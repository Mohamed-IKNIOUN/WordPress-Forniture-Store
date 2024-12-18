<?php
/**
 * Post Content Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.2.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Post_Content_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Post_Content_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Post Content', 'jeg-elementor-kit' );
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

		parent::set_options();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_content'] = array(
			'name'      => esc_html__( 'Post Content Style', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
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
				'left'    => array(
					'title' => esc_html__( 'Left', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-left',
				),
				'center'  => array(
					'title' => esc_html__( 'Center', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-center',
				),
				'right'   => array(
					'title' => esc_html__( 'Right', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-right',
				),
				'justify' => array(
					'title' => esc_html__( 'Justify', 'jeg-elementor-kit' ),
					'icon'  => 'fas fa-align-justify',
				),
			),
			'responsive' => true,
			'default'    => 'left',
			'selectors'  => '.jeg-elementor-kit.jkit-post-content',
			'attribute'  => 'text-align',
		);

		$this->options['st_content_typography'] = array(
			'type'      => 'typography',
			'title'     => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-post-content, {{WRAPPER}} .jeg-elementor-kit.jkit-post-content a, {{WRAPPER}} .jeg-elementor-kit.jkit-post-content ul li',
			),
		);

		$this->options['st_content_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Text Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_content',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-content, {{WRAPPER}} .jeg-elementor-kit.jkit-post-content a' => 'color: {{VALUE}};',
				),
			),
		);

		$this->options['st_content_textshadow'] = array(
			'type'      => 'textshadow',
			'title'     => esc_html__( 'Text Shadow', 'jeg-elementor-kit' ),
			'segment'   => 'style_content',
			'selectors' => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-post-content, {{WRAPPER}} .jeg-elementor-kit.jkit-post-content a',
			),
		);

		parent::additional_style();
	}
}
