<?php
/**
 * Post Comment Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Post_Comment_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Post_Comment_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_post_comment';
	}
}
