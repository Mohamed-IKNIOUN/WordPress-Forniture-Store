<?php
/**
 * Beaver Manager
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Divi;

use Jeg\Element\Element;

/**
 * Class Divi_Builder_Manager
 *
 * @package Jeg\Element\Divi
 */
class Divi_Builder_Manager {
	/**
	 * Divi_Builder_Manager constructor.
	 */
	public function __construct() {
		$this->register_module();
	}

	/**
	 * Register Divi Builder Add On
	 */
	public function register_module() {
		$elements = Element::instance()->manager->populate_elements();

		foreach ( $elements as $key => $element ) {
			if ( isset( $element['divi'] ) ) {
				$class = $element['divi'];
				if ( class_exists( $class ) ) {
					new $class();
				}
			}
		}
	}
}
