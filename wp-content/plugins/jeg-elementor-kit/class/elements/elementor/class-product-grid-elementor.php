<?php
/**
 * Product Grid Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Product_Grid_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Product_Grid_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_product_grid';
	}

	/**
	 * Enqueue custom script.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-pagination' );
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'jkit-icons' );
	}

	/**
	 * Set keywords.
	 */
	public function get_keywords() {
		return array( 'woocommerce', 'product', 'grid' );
	}
}
