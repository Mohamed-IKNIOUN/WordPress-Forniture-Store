<?php
/**
 * Post Content Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.2.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Post_Content_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Post_Content_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_post_content';
	}
}
