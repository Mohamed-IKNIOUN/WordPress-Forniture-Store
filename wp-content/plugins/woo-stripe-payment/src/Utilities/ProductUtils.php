<?php

namespace PaymentPlugins\Stripe\Utilities;

class ProductUtils {

	/**
	 * @param \WC_Product $product
	 *
	 * @return void
	 */
	public static function get_product_variations( $product ) {
		if ( $product && $product->get_type() === 'variable' ) {
			$results = wp_cache_get( 'wc_stripe_product_variations' );
			if ( ! \is_array( $results ) ) {
				$results = [];
			}
			if ( isset( $results[ $product->get_id() ] ) ) {
				return $results[ $product->get_id() ];
			}

			$results[ $product->get_id() ] = [];

			$children = $product->get_children();

			if ( ! empty( $children ) ) {
				foreach ( $children as $child_id ) {
					$variation = wc_get_product( $child_id );
					if ( $variation ) {
						$results[ $product->get_id() ][] = $variation;
					}
				}
			}

			wp_cache_add( 'wc_stripe_product_variations', $results );

			return $results[ $product->get_id() ];
		}

		return [];
	}

}