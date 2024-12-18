<?php
/**
 * Jeg News Element Option Manager
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Option;

use Jeg\Customizer\Customizer;

/**
 * Class Option_Manager
 *
 * @package Jeg\Element\Option
 */
class Option_Manager {

	/**
	 * Option_Manager constructor.
	 */
	public function __construct() {
		add_action( 'jeg_register_customizer_option', array( $this, 'register_lazy_section' ), 91 );
		add_filter( 'jeg_register_lazy_section', array( $this, 'load_customizer' ) );
		add_filter( 'jeg_fonts_option_setting', array( $this, 'register_fonts_option' ) );
	}

	/**
	 * Register fonts option
	 *
	 * @return array
	 */
	public function register_fonts_option() {
		return array(
			'jeg[module-title-font]',
			'jeg[module-meta-font]',
			'jeg[module-content-font]',
		);
	}

	/**
	 * Register Lazy Section
	 */
	public function register_lazy_section() {
		$customizer = Customizer::get_instance();
		$this->build_module_option( $customizer );
	}

	/**
	 * Assign Panel & Section for Customizer
	 *
	 * @param Customizer $customizer Customizer Instance.
	 */
	public function build_module_option( $customizer ) {
		if ( apply_filters( 'jeg_show_default_module_customizer', true ) ) {
			$customizer->add_panel(
				array(
					'id'          => 'jeg_module_panel',
					'title'       => apply_filters( 'jeg_module_element_option_label', esc_html__( 'JEG : Module Element Option', 'jeg-elementor-kit' ) ),
					'description' => esc_html__( 'Jeg ', 'jeg-elementor-kit' ),
					'priority'    => 171,
				)
			);

			$customizer->add_section(
				array(
					'id'         => 'jeg_module_image_section',
					'title'      => esc_html__( 'Module Image Setting', 'jeg-elementor-kit' ),
					'panel'      => 'jeg_module_panel',
					'priority'   => 171,
					'type'       => 'jeg-lazy-section',
					'dependency' => array(),
				)
			);

			$customizer->add_section(
				array(
					'id'         => 'jeg_module_loader_section',
					'title'      => esc_html__( 'Module Loader', 'jeg-elementor-kit' ),
					'panel'      => 'jeg_module_panel',
					'priority'   => 171,
					'type'       => 'jeg-lazy-section',
					'dependency' => array(),
				)
			);

			$customizer->add_section(
				array(
					'id'         => 'jeg_module_meta_section',
					'title'      => esc_html__( 'Module Meta Option', 'jeg-elementor-kit' ),
					'panel'      => 'jeg_module_panel',
					'priority'   => 171,
					'type'       => 'jeg-lazy-section',
					'dependency' => array(),
				)
			);

			$customizer->add_section(
				array(
					'id'         => 'jeg_module_custom_post_type_section',
					'title'      => esc_html__( 'Module Custom Post Type', 'jeg-elementor-kit' ),
					'panel'      => 'jeg_module_panel',
					'priority'   => 171,
					'type'       => 'jeg-lazy-section',
					'dependency' => array(),
				)
			);

			$customizer->add_section(
				array(
					'id'         => 'jeg_module_font_section',
					'title'      => esc_html__( 'Module Global Font', 'jeg-elementor-kit' ),
					'panel'      => 'jeg_module_panel',
					'priority'   => 171,
					'type'       => 'jeg-lazy-section',
					'dependency' => array(),
				)
			);
		}
	}

	/**
	 * Register Customizer Control.
	 *
	 * @param array $result Collection of customizer.
	 *
	 * @return array
	 */
	public function load_customizer( $result ) {
		$array = array(
			'module_image',
			'module_loader',
			'module_meta',
			'module_font',
			'module_custom_post_type',
		);

		$path = JEG_ELEMENT_DIR . '/includes/class/option/sections/';

		foreach ( $array as $id ) {
			$result[ "jeg_{$id}_section" ][] = "{$path}{$id}.php";
		}

		return $result;
	}
}
