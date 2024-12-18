<?php
/**
 * Off Canvas Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.7.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Off_Canvas_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Off_Canvas_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_off_canvas';
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-offcanvas' );
	}
}
