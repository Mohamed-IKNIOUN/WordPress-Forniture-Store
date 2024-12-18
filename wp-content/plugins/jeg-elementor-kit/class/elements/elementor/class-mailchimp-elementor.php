<?php
/**
 * Mailchimp Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.3.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Mailchimp_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Mailchimp_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_mailchimp';
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-mailchimp' );
	}
}
