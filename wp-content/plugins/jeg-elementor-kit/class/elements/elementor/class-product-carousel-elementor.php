<?php
/**
 * Product Carousel Elementor Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 2.4.0
 */

namespace Jeg\Elementor_Kit\Elements\Elementor;

/**
 * Class Product_Carousel_Elementor
 *
 * @package Jeg\Elementor_Kit\Elements\Elementor
 */
class Product_Carousel_Elementor extends Elementor_Kit_Abstract {
	/**
	 * Element ID
	 *
	 * @return string
	 */
	public function get_elementor_id() {
		return 'jkit_product_carousel';
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'jkit-element-product-carousel', 'tiny-slider' );
	}

	/**
	 * Enqueue custom styles.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'tiny-slider', 'elementor-icons-fa-solid' );
	}

	/**
	 * Set keywords.
	 */
	public function get_keywords() {
		return array( 'woocommerce', 'product', 'carousel', 'slider' );
	}
}
