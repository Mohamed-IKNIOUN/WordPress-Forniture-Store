<?php
/**
 * Social Share Elementor Class
 *
 * @author Jegtheme
 * @since 1.6.0
 * @package jeg-elementor-kit
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Social Share Elementor Class
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Social_Share_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_social_share';
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-social-share', 'goodshare' );
	}
}
