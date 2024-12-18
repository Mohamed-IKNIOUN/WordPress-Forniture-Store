<?php

namespace PaymentPlugins\Stripe\WooCommerceSubscriptions\Controllers;

use PaymentPlugins\Stripe\Utilities\PaymentMethodUtils;

class ChangePaymentGatewayController {

	private $token;

	public function initialize() {
		add_filter( 'woocommerce_subscription_note_new_payment_method_title', [ $this, 'update_new_payment_method_title' ], 10, 3 );
	}

	public function update_new_payment_method_title( $new_payment_method_title, $gateway_id, $subscription ) {
		$payment_gateways = WC()->payment_gateways()->payment_gateways();
		$payment_method   = $payment_gateways[ $gateway_id ] ?? null;
		if ( $payment_method && $payment_method instanceof \WC_Payment_Gateway_Stripe ) {
			if ( $this->token && $this->token instanceof \WC_Payment_Token_Stripe ) {
				$new_payment_method_title = $this->token->get_payment_method_title( $payment_method->get_option( 'method_format' ) );

				return $new_payment_method_title;
			}
			if ( $payment_method->use_saved_source() ) {
				$this->token = PaymentMethodUtils::get_payment_token(
					$payment_method->get_saved_source_id(),
					$subscription->get_customer_id()
				);
				if ( $this->token && $this->token instanceof \WC_Payment_Token_Stripe ) {
					$new_payment_method_title = $this->token->get_payment_method_title( $payment_method->get_option( 'method_format' ) );
				}
			} else {
				$id = $payment_method->get_new_source_token();
				if ( $id ) {
					$result = $payment_method->gateway->paymentMethods->retrieve( $id );
					if ( ! is_wp_error( $result ) ) {
						$this->token = $payment_method->get_payment_token( $result->id, $result );
						if ( $this->token ) {
							$new_payment_method_title = $this->token->get_payment_method_title( $payment_method->get_option( 'method_format' ) );
						}
					}
				}
			}
		}

		return $new_payment_method_title;
	}

}