<?php
/**
 * Post Block Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Post_BLock_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Post_Block_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_post_block';
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-pagination' );
	}
}
