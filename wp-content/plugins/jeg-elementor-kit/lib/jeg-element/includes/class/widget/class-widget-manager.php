<?php
/**
 * Jeg News Element Widget Manager
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Widget;

use Jeg\Element\Element;

/**
 * Class Widget_Manager
 *
 * @package Jeg\Element\Widget
 */
class Widget_Manager {
	/**
	 * Widget_Manager constructor.
	 */
	public function __construct() {
		add_action( 'widgets_init', array( $this, 'register_widget' ) );
	}

	/**
	 * Register Widget
	 */
	public function register_widget() {
		if ( apply_filters( 'jeg_can_register_widget', true ) ) {
			$elements = Element::instance()->manager->populate_elements();

			foreach ( $elements as $key => $element ) {
				if ( isset( $element['widget'] ) ) {
					register_widget( $element['widget'] );
				}
			}
		}
	}
}
