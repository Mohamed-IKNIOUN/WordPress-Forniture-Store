<?php

namespace PaymentPlugins\WooCommerce\PPCP\Conversion;

use PaymentPlugins\PayPalSDK\PaymentSource;
use PaymentPlugins\PayPalSDK\Token;
use PaymentPlugins\WooCommerce\PPCP\Admin\Settings\APISettings;
use PaymentPlugins\WooCommerce\PPCP\Constants;

class WooCommercePPCPAngellEYE extends GeneralPayPalPlugin {

	public $id = 'angelleye_ppcp';

	protected $payment_token_id = '_payment_tokens_id';

	/**
	 * @param \PaymentPlugins\PayPalSDK\PaymentSource $payment_source
	 * @param \WC_Order                               $order
	 */
	public function get_payment_source_from_order( $payment_source, $order ) {
		if ( $payment_source->getToken() && $payment_source->getToken()->getId() ) {
			if ( strpos( $payment_source->getToken()->getId(), 'B-' ) === false ) {
				$payment_source->getToken()->setType( Token::PAYMENT_METHOD_TOKEN );
			}
		} else {
			$payment_token_id = $order->get_meta( $this->payment_token_id );
			if ( ! $payment_token_id ) {
				$customer_id = $this->get_customer_id( $order->get_customer_id() );
				if ( $customer_id ) {
					$response = $this->client->paymentTokensV3->all( [ 'customer_id' => $customer_id ] );
					if ( ! is_wp_error( $response ) && $response->payment_tokens->count() > 0 ) {
						$token                = $response->payment_tokens->get( 0 );
						$payment_source       = new PaymentSource(
							[
								'paypal' => new Token(
									[ 'vault_id' => $token->id ]
								)
							]
						);
						$this->payment_source = $payment_source;
					}
				}
			} else {
				$payment_source = new PaymentSource(
					[
						'token' => new Token(
							[ 'id' => $payment_token_id, 'type' => TOKEN::PAYMENT_METHOD_TOKEN ]
						)
					]
				);
			}
		}

		return $payment_source;
	}


	private function get_customer_id( $user_id ) {
		if ( $user_id > 0 ) {
			$key = 'angelleye_ppcp_paypal_customer_id';
			if ( wc_ppcp_get_container()->get( APISettings::class )->is_sandbox() ) {
				$key = 'sandbox_' . $key;
			}

			return get_user_meta( $user_id, $key, true );
		}

		return null;
	}

	protected function get_payment_meta_label() {
		return __( 'Payment Token ID', 'pymntpl-paypal-woocommerce' );
	}

}