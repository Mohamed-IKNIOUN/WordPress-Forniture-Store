<?php
/**
 * Tabs Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.8.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Tabs_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Tabs_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_tabs';
	}

	/**
	 * Enqueue custom scripts.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-tabs' );
	}
}
