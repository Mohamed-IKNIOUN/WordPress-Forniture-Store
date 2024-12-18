<?php
/**
 * Portfolio Gallery Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Portfolio_Gallery_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Portfolio_Gallery_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_portfolio_gallery';
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-portfoliogallery' );
	}
}
