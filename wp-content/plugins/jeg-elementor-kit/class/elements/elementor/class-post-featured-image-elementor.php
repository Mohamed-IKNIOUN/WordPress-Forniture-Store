<?php
/**
 * Post Featured Image Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Post_Featured_Image_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Post_Featured_Image_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_post_featured_image';
	}
}
