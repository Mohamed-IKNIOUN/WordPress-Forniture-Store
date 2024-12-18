<?php

namespace PaymentPlugins\Stripe\WooCommerceSubscriptions;

use PaymentPlugins\Stripe\RequestContext;

class FrontendRequests {

	public function is_change_payment_method() {
		return \WC_Subscriptions_Change_Payment_Gateway::$is_request_to_change_payment;
	}

	public function is_checkout_with_free_trial( RequestContext $context ) {
		if ( WC()->cart ) {
			return $context->is_checkout() && \WC_Subscriptions_Cart::cart_contains_free_trial() && WC()->cart->total == 0;
		}

		return false;
	}

	public function is_checkout_with_free_coupon( RequestContext $context ) {
		if ( WC()->cart ) {
			return $context->is_checkout() && WC()->cart->get_total( 'edit' ) == 0
			       && \WC_Subscriptions_Cart::cart_contains_subscription();
		}

		return false;
	}

	public function is_checkout_with_subscription( RequestContext $context ) {
		return $context->is_checkout() && \WC_Subscriptions_Cart::cart_contains_subscription();
	}

	public function is_order_pay_with_subscription( RequestContext $context ) {
		return $context->is_order_pay() && \WC_Subscriptions_Cart::cart_contains_subscription();
	}

	public function is_order_pay_with_free_trial( RequestContext $context ) {
		if ( $context->is_order_pay() ) {
			global $wp;
			$order = wc_get_order( absint( $wp->query_vars['order-pay'] ) );

			return $order && wcs_order_contains_subscription( $order ) && $order->get_total() == 0;
		}

		return false;
	}

}