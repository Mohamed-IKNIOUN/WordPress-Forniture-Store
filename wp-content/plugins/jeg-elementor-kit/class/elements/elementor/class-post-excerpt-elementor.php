<?php
/**
 * Post Excerpt Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Post_Excerpt_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Post_Excerpt_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_post_excerpt';
	}
}
