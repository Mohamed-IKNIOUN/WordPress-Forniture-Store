<?php
/**
 * Search Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.10.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Search_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Search_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_search';
	}

	/**
	 * Enqueue custom scripts.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-search', 'sweetalert2' );
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'sweetalert2' );
	}
}
