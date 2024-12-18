<?php

namespace PaymentPlugins\Stripe\Webhooks;

class DeferredWebhookHandler {

	public function initialize() {
		add_action( 'wc_stripe_process_deferred_webhook', [ $this, 'process' ], 10, 2 );
	}

	public function process( $type, $order_id ) {
		switch ( $type ) {
			case 'payment_intent.succeeded':
				$order = wc_get_order( absint( $order_id ) );
				if ( $order ) {
					$payment_gateways = WC()->payment_gateways()->payment_gateways();
					/**
					 * @var \WC_Payment_Gateway_Stripe $payment_method
					 */
					$payment_method = $payment_gateways[ $order->get_payment_method() ] ?? null;
					if ( $payment_method ) {
						// The order has already been processed, exit here.
						if ( $payment_method->has_order_lock( $order ) || $order->get_date_paid() ) {
							return;
						}
						$payment_method->set_order_lock( $order );
						$result = $payment_method->payment_object->process_payment( $order );
						if ( ! is_wp_error( $result ) && $result->complete_payment ) {
							$payment_method->payment_object->payment_complete( $order, $result->charge );
						}
					}
				}
				break;
		}
	}

}