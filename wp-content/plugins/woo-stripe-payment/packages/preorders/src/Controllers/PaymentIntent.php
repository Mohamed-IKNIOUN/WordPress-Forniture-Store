<?php

namespace PaymentPlugins\Stripe\WooCommercePreOrders\Controllers;

use PaymentPlugins\Stripe\RequestContext;
use PaymentPlugins\Stripe\WooCommercePreOrders\FrontendRequests;

class PaymentIntent {

	private $request;

	public function __construct( FrontendRequests $request ) {
		$this->request = $request;
		$this->initialize();
	}

	private function initialize() {
		add_filter( 'wc_stripe_create_setup_intent', [ $this, 'maybe_create_setup_intent' ], 10, 2 );
	}

	public function maybe_create_setup_intent( $bool, RequestContext $context ) {
		if ( ! $bool ) {
			if ( $this->request->is_checkout_with_preorder_requires_tokenization( $context ) ) {
				$bool = true;
			} elseif ( $this->request->is_order_pay_with_preorder_requires_tokenization( $context ) ) {
				$bool = true;
			}
		}

		return $bool;
	}

}