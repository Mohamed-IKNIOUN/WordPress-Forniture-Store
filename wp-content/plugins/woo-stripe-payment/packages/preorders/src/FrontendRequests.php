<?php

namespace PaymentPlugins\Stripe\WooCommercePreOrders;

use PaymentPlugins\Stripe\RequestContext;

class FrontendRequests {

	public function is_checkout_with_preorder_requires_tokenization( RequestContext $context ) {
		return $context->is_checkout()
		       && \WC_Pre_Orders_Cart::cart_contains_pre_order()
		       && \WC_Pre_Orders_Product::product_is_charged_upon_release( \WC_Pre_Orders_Cart::get_pre_order_product() );
	}

	public function is_order_pay_with_preorder_requires_tokenization( RequestContext $context ) {
		if ( $context->is_order_pay() ) {
			global $wp;
			$order = wc_get_order( absint( $wp->query_vars['order-pay'] ) );

			return $order && \WC_Pre_Orders_Order::order_contains_pre_order( $order )
			       && \WC_Pre_Orders_Order::order_will_be_charged_upon_release( $order );
		}

		return false;
	}

}