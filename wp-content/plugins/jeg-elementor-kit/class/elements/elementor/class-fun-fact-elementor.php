<?php
/**
 * Fun Fact Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Fun_Fact_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Fun_Fact_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_fun_fact';
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-funfact' );
	}
}
