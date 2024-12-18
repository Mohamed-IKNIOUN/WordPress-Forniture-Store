<?php
/**
 * Video Button Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.2.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Video_Button_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Video_Button_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_video_button';
	}

	/**
	 * Enqueue custom scripts.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-videobutton', 'sweetalert2' );
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
