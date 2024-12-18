<?php
/**
 * Jeg News Element Elementor Manager
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Elementor;

use Elementor\Plugin;
use Jeg\Element\Element;

/**
 * Class Elementor_Abstract
 *
 * @package Jeg\Element\Elementor
 */
class Elementor_Manager {
	/**
	 * Elementor_Manager constructor.
	 */
	public function __construct() {
		$this->setup_hook();
	}

	/**
	 * Setup hook for elementor.
	 */
	public function setup_hook() {
		add_action( 'elementor/init', array( $this, 'register_group' ) );
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_style' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'editor_script' ) );

		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.5.0', '<' ) ) {
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_module' ) );
			add_action( 'elementor/controls/controls_registered', array( $this, 'register_control' ) );
		} else {
			add_action( 'elementor/widgets/register', array( $this, 'register_module' ) );
			add_action( 'elementor/controls/register', array( $this, 'register_control' ) );
		}
	}

	/**
	 * Editor Style
	 */
	public function editor_style() {
		wp_enqueue_style( 'selectize', JEG_ELEMENT_URL . '/assets/css/selectize.default.css', null, '0.14.0' );
		wp_enqueue_style( 'jeg-elementor', JEG_ELEMENT_URL . '/assets/css/elementor-backend.css', null, JEG_ELEMENT_VERSION );
	}

	/**
	 * Editor Script
	 */
	public function editor_script() {
		wp_enqueue_script( 'jquery-ui-spinner' );
		wp_enqueue_script( 'selectize', JEG_ELEMENT_URL . '/assets/js/selectize.min.js', null, '0.14.0', true );
		wp_enqueue_script( 'jeg-elementor-select', JEG_ELEMENT_URL . ( '/assets/js/elementor/elementor-control-select.js' ), null, JEG_ELEMENT_VERSION, true );
	}

	/**
	 * Register Custom Control
	 */
	public function register_control() {
		$controls = array(
			'alert'          => 'Jeg\Element\Elementor\Control\Alert_Elementor',
			'dynamic-select' => 'Jeg\Element\Elementor\Control\Dynamic_Select_Elementor',
		);

		foreach ( $controls as $type => $classname ) {
			if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.5.0', '<' ) ) {
				\Elementor\Plugin::instance()->controls_manager->register_control( $type, new $classname() );
			} else {
				\Elementor\Plugin::instance()->controls_manager->register( new $classname() );
			}
		}
	}

	/**
	 * Register Group
	 */
	public function register_group() {
		$group   = array();
		$options = Element::instance()->manager->get_element_options();

		if ( $options ) {
			foreach ( $options as $option ) {
				$category = $option->get_category();
				$id       = jeg_slug_category( $category );

				if ( ! isset( $group[ $id ] ) ) {
					Plugin::$instance->elements_manager->add_category( $id, array( 'title' => $category ), 1 );
				}
			}
		}
	}

	/**
	 * Register Module
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Widget Manager.
	 */
	public function register_module( $widgets_manager ) {
		$elements = Element::instance()->manager->populate_elements();

		foreach ( $elements as $key => $element ) {
			if ( isset( $element['elementor'] ) ) {
				$class = $element['elementor'];
				if ( class_exists( $class ) ) {
					if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.5.0', '<' ) ) {
						$widgets_manager->register_widget_type( new $class() );
					} else {
						$widgets_manager->register( new $class() );
					}
				}
			}
		}
	}
}
