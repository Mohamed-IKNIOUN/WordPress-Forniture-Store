<?php
/**
 * Product Categories Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Product_Categories_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Product_Categories_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_product_categories';
	}

	/**
	 * Set keywords.
	 */
	public function get_keywords() {
		return array( 'woocommerce', 'product', 'categories', 'category', 'collection' );
	}
}
