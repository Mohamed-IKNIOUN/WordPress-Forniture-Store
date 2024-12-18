<?php
/**
 * Team Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Team_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Team_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_team';
	}

	/**
	 * Enqueue custom scripts.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-team', 'sweetalert2' );
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
