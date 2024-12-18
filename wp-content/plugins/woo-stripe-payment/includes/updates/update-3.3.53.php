<?php

defined( 'ABSPATH' ) || exit();

if ( function_exists( 'WC' ) ) {
	/**
	 * This conversion is necessary because of the new Affirm and Afterpay checkout page messaging options.
	 */
	$payment_gateways = WC()->payment_gateways()->payment_gateways();
	$ids              = [ 'stripe_affirm', 'stripe_afterpay' ];
	foreach ( $ids as $id ) {
		$payment_gateway = isset( $payment_gateways[ $id ] ) ? $payment_gateways[ $id ] : null;
		if ( $payment_gateway ) {
			$value = $payment_gateway->get_option( 'payment_sections', array() );
			if ( ! is_array( $value ) ) {
				$value = array();
			}
			$value[] = 'checkout';
			$payment_gateway->update_option( 'payment_sections', $value );
		}
	}

	/**
	 * The purpose of this update is to migrate the payment_sections settings for Apple Pay, GPay, and PaymentRequest
	 * so they align with the new Cart & Checkout Blocks. Previously, these payment methods would show up on the cart and checkout
	 * block if they were just enabled. They ignored the payment sections setting where as going forward, they will use the payment_sections
	 * settings
	 */
	$args = [
		[ 'checkout', '<\!--(\s+)?+wp:woocommerce\/checkout', 'checkout_banner' ],
		[ 'cart', '<\!--(\s+)?+wp:woocommerce\/cart', 'cart' ]
	];
	if ( version_compare( WC()->version, '8.3.0', '>=' ) ) {
		foreach ( $args as $list ) {
			list( $page, $regex, $type ) = $list;
			$page_id = wc_get_page_id( $page );
			$ids     = [ 'stripe_applepay', 'stripe_googlepay', 'stripe_payment_request' ];
			if ( $page_id ) {
				$post = get_post( $page_id );
				if ( $post && $post instanceof WP_Post ) {
					$content = $post->post_content;
					// see if the checkout page is using blocks.
					if ( preg_match( "/${regex}/", $content ) ) {
						// checkout page is using Block, so update Apple Pay, GPay, and Payment Request Settings.
						foreach ( $ids as $id ) {
							/**
							 * @var \WC_Payment_Gateway_Stripe $payment_gateway
							 */
							$payment_gateway = isset( $payment_gateways[ $id ] ) ? $payment_gateways[ $id ] : null;
							if ( $payment_gateway ) {
								$payment_sections = $payment_gateway->get_option( 'payment_sections', array() );
								/**
								 * If the payment method is enabled, but Express Checkout isn't enabled, that means they were using
								 * Express Checkout for Blocks
								 */
								if ( $payment_gateway->enabled === 'yes' && ! in_array( $type, $payment_sections, true ) ) {
									$payment_sections[] = $type;
									$payment_gateway->update_option( 'payment_sections', $payment_sections );
								}
							}
						}
					}
				}
			}
		}
	}
}