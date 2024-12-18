<?php
/**
 * Animated Text Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Animated_Text_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Animated_Text_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_animated_text';
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-animatedtext' );
	}
}
