<?php
/**
 * Nav Menu Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Nav_Menu_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Nav_Menu_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_nav_menu';
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-navmenu' );
	}
}
