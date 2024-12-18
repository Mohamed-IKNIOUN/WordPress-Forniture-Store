<?php
/**
 * Post List Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.2.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Post_List_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Post_List_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_post_list';
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
