<?php

defined( 'ABSPATH' ) || exit();

/**
 *
 * @since  3.1.0
 * @author Payment Plugins
 *
 */
class WC_Stripe_Gateway_Conversion {

	public static function init() {
		add_filter( 'woocommerce_order_get_payment_method', array( __CLASS__, 'convert_payment_method' ), 10, 2 );
		add_filter( 'woocommerce_subscription_get_payment_method', array( __CLASS__, 'convert_payment_method' ), 10, 2 );
	}

	/**
	 *
	 * @param string   $payment_method
	 * @param WC_Order $order
	 */
	public static function convert_payment_method( $current_payment_method, $order ) {
		$payment_method = $current_payment_method;
		switch ( $current_payment_method ) {
			case 'stripe':
			case 'fkwcs_stripe':
				$payment_method = 'stripe_cc';
				break;
			case 'fkwcs_stripe_sepa':
				$payment_method = 'stripe_sepa';
				break;
		}
		// Another Stripe plugin is active, don't convert $payment_method as that could affect
		// checkout functionality.
		if ( did_action( 'woocommerce_checkout_order_processed' ) ) {
			return $current_payment_method;
		}

		return $payment_method;
	}

}

WC_Stripe_Gateway_Conversion::init();
