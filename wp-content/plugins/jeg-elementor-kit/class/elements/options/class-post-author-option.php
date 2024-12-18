<?php
/**
 * Post Author Option Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Options;

/**
 * Class Post_Author_Option
 *
 * @package Jeg\Elementor_Kit\Elements\Options
 */
class Post_Author_Option extends Option_Abstract {
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
		return esc_html__( 'JKit - Post Author', 'jeg-elementor-kit' );
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
		$this->segments['segment_author'] = array(
			'name'     => esc_html__( 'Post Author', 'jeg-elementor-kit' ),
			'priority' => 10,
		);

		$this->set_style_segment();
	}

	/**
	 * Style segments
	 */
	public function set_style_segment() {
		$this->segments['style_author'] = array(
			'name'      => esc_html__( 'Post Author', 'jeg-elementor-kit' ),
			'priority'  => 11,
			'kit_style' => true,
		);

		parent::set_style_segment();
	}

	/**
	 * Set element option
	 */
	public function set_element_options() {
		$this->options['sg_author_type'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Author', 'jeg-elementor-kit' ),
			'default' => 'display_name',
			'segment' => 'segment_author',
			'options' => array(
				'first_name'   => esc_html__( 'First Name', 'jeg-elementor-kit' ),
				'last_name'    => esc_html__( 'Last Name', 'jeg-elementor-kit' ),
				'first_last'   => esc_html__( 'First + Last Name', 'jeg-elementor-kit' ),
				'last_first'   => esc_html__( 'Last + First Name', 'jeg-elementor-kit' ),
				'nick_name'    => esc_html__( 'Nick Name', 'jeg-elementor-kit' ),
				'display_name' => esc_html__( 'Display Name', 'jeg-elementor-kit' ),
				'user_name'    => esc_html__( 'User Name', 'jeg-elementor-kit' ),
				'user_bio'     => esc_html__( 'User Bio', 'jeg-elementor-kit' ),
				'user_image'   => esc_html__( 'User Image', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_author_html_tag'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'HTML Tag', 'jeg-elementor-kit' ),
			'default' => 'p',
			'segment' => 'segment_author',
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

		$this->options['sg_author_link_to'] = array(
			'type'    => 'select',
			'title'   => esc_html__( 'Link To', 'jeg-elementor-kit' ),
			'default' => 'none',
			'segment' => 'segment_author',
			'options' => array(
				'none'   => esc_html__( 'None', 'jeg-elementor-kit' ),
				'home'   => esc_html__( 'Home URL', 'jeg-elementor-kit' ),
				'post'   => esc_html__( 'Post URL', 'jeg-elementor-kit' ),
				'author' => esc_html__( 'Author URL', 'jeg-elementor-kit' ),
				'custom' => esc_html__( 'Custom URL', 'jeg-elementor-kit' ),
			),
		);

		$this->options['sg_author_link_to_custom'] = array(
			'type'       => 'link',
			'title'      => esc_html__( 'Link', 'jeg-elementor-kit' ),
			'segment'    => 'segment_author',
			'dependency' => array(
				array(
					'field'    => 'sg_author_link_to',
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
		$this->options['st_author_alignment'] = array(
			'type'       => 'radio',
			'title'      => esc_html__( 'Alignment', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
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
			'selectors'  => '.jeg-elementor-kit.jkit-post-author',
			'attribute'  => 'text-align',
		);

		$this->options['st_author_typography'] = array(
			'type'       => 'typography',
			'title'      => esc_html__( 'Typography', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'selectors'  => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-post-author .post-author, {{WRAPPER}} .jeg-elementor-kit.jkit-post-author .post-author a',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_author_type!',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_tabs_start'] = array(
			'type'       => 'control_tabs_start',
			'segment'    => 'style_author',
			'dependency' => array(
				array(
					'field'    => 'sg_author_type!',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_normal_tab_start'] = array(
			'type'       => 'control_tab_start',
			'title'      => esc_html__( 'Normal', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'dependency' => array(
				array(
					'field'    => 'sg_author_type!',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_normal_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Normal Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-author .post-author, {{WRAPPER}} .jeg-elementor-kit.jkit-post-author .post-author a' => 'color: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_author_type!',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_normal_textshadow'] = array(
			'type'       => 'textshadow',
			'title'      => esc_html__( 'Normal Text Shadow', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'selectors'  => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-post-author .post-author, {{WRAPPER}} .jeg-elementor-kit.jkit-post-author .post-author a',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_author_type!',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_normal_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_author',
		);

		$this->options['st_author_hover_tab_start'] = array(
			'type'       => 'control_tab_start',
			'title'      => esc_html__( 'Hover', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'dependency' => array(
				array(
					'field'    => 'sg_author_type!',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_hover_color'] = array(
			'type'       => 'color',
			'title'      => esc_html__( 'Hover Color', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-author:hover .post-author, {{WRAPPER}} .jeg-elementor-kit.jkit-post-author:hover .post-author a' => 'color: {{VALUE}};',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_author_type!',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_hover_textshadow'] = array(
			'type'       => 'textshadow',
			'title'      => esc_html__( 'Hover Text Shadow', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'selectors'  => array(
				'custom' => '{{WRAPPER}} .jeg-elementor-kit.jkit-post-author:hover .post-author, {{WRAPPER}} .jeg-elementor-kit.jkit-post-author:hover .post-author a',
			),
			'dependency' => array(
				array(
					'field'    => 'sg_author_type!',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_hover_tab_end'] = array(
			'type'    => 'control_tab_end',
			'segment' => 'style_author',
		);

		$this->options['st_author_tabs_end'] = array(
			'type'    => 'control_tabs_end',
			'segment' => 'style_author',
		);

		$this->options['st_author_size'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Size', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'options'    => array(
				'min'  => 0,
				'max'  => 256,
				'step' => 1,
			),
			'units'      => array( 'px', 'em', '%' ),
			'responsive' => true,
			'selectors'  => '.jeg-elementor-kit.jkit-post-author .post-author img',
			'attribute'  => 'max-width',
			'dependency' => array(
				array(
					'field'    => 'sg_author_type',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_opacity'] = array(
			'type'         => 'slider',
			'title'        => esc_html__( 'Opacity', 'jeg-elementor-kit' ),
			'segment'      => 'style_author',
			'options'      => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
			'units'        => array( '%' ),
			'default_unit' => '%',
			'responsive'   => true,
			'selectors'    => '.jeg-elementor-kit.jkit-post-author .post-author img',
			'attribute'    => 'opacity',
			'dependency'   => array(
				array(
					'field'    => 'sg_author_type',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_rotate'] = array(
			'type'       => 'slider',
			'title'      => esc_html__( 'Rotate', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'options'    => array(
				'min'  => -360,
				'max'  => 360,
				'step' => 1,
			),
			'responsive' => true,
			'selectors'  => array(
				'custom' => array(
					'{{WRAPPER}} .jeg-elementor-kit.jkit-post-author .post-author img' => '-moz-transform: rotate({{SIZE}}deg); -webkit-transform: rotate({{SIZE}}deg); -o-transform: rotate({{SIZE}}deg); -ms-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
				),
			),
			'dependency' => array(
				array(
					'field'    => 'sg_author_type',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_boxshadow'] = array(
			'type'       => 'boxshadow',
			'title'      => esc_html__( 'Box Shadow', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'selectors'  => '.jeg-elementor-kit.jkit-post-author .post-author img',
			'dependency' => array(
				array(
					'field'    => 'sg_author_type',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_border'] = array(
			'type'       => 'border',
			'title'      => esc_html__( 'Border', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'selectors'  => '.jeg-elementor-kit.jkit-post-author .post-author img',
			'dependency' => array(
				array(
					'field'    => 'sg_author_type',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_border_radius'] = array(
			'type'       => 'dimension',
			'title'      => esc_html__( 'Border Radius', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'units'      => array( 'px', '%', 'em' ),
			'selectors'  => '.jeg-elementor-kit.jkit-post-author .post-author img',
			'attribute'  => 'border-radius',
			'dependency' => array(
				array(
					'field'    => 'sg_author_type',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		$this->options['st_author_hover_animation'] = array(
			'type'       => 'hoveranimation',
			'title'      => esc_html__( 'Hover Animation', 'jeg-elementor-kit' ),
			'segment'    => 'style_author',
			'dependency' => array(
				array(
					'field'    => 'sg_author_type',
					'operator' => '==',
					'value'    => 'user_image',
				),
			),
		);

		parent::additional_style();
	}
}
