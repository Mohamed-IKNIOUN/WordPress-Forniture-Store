<?php

namespace PaymentPlugins\WooCommerce\PPCP\Conversion;

use PaymentPlugins\PayPalSDK\PaymentSource;
use PaymentPlugins\PayPalSDK\PayPalClient;
use PaymentPlugins\PayPalSDK\Token;

/**
 * https://wordpress.org/plugins/woocommerce-paypal-payments/
 */
class WooCommercePayPalPayments extends GeneralPayPalPlugin {

	public $id = 'ppcp-gateway';

	protected $payment_token_id = 'payment_token_id';

	/**
	 * @param \PaymentPlugins\PayPalSDK\PaymentSource $payment_source
	 * @param \WC_Order                               $order
	 *
	 * @return \PaymentPlugins\PayPalSDK\PaymentSource
	 */
	public function get_payment_source_from_order( $payment_source, $order ) {
		if ( $payment_source->getToken() && $payment_source->getToken()->getId() ) {
			$payment_source->getToken()->setType( Token::PAYMENT_METHOD_TOKEN );
		} else {
			$payment_token_id = $order->get_meta( $this->payment_token_id );
			if ( ! $payment_token_id ) {
				$customer_id = $this->get_customer_id( $order->get_customer_id(), 'v2' );
				if ( $customer_id ) {
					/**
					 * @var $tokens \PaymentPlugins\PayPalSDK\Collection
					 */
					$response = $this->client->paymentTokens->all( [ 'customer_id' => $customer_id ] );
					if ( ! is_wp_error( $response ) && $response->payment_tokens->count() > 0 ) {
						$token                = $response->payment_tokens->get( 0 );
						$payment_source       = new PaymentSource(
							[
								'token' => new Token(
									[ 'id' => $token->id, 'type' => Token::PAYMENT_METHOD_TOKEN ]
								)
							]
						);
						$this->payment_source = $payment_source;
					} else {
						$customer_id = $this->get_customer_id( $order->get_customer_id(), 'v3' );
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
					}
				}
			} else {
				$payment_source = new PaymentSource(
					[
						'token' => new Token(
							[ 'id' => $payment_token_id, 'type' => Token::PAYMENT_METHOD_TOKEN ]
						)
					]
				);
			}
		}

		return $payment_source;
	}

	private function get_customer_id( $user_id, $version ) {
		if ( $version === 'v2' ) {
			$keys = [ 'ppcp_customer_id', 'ppcp_guest_customer_id' ];
		} else {
			$keys = [ '_ppcp_target_customer_id' ];
		}
		$id = null;
		if ( $user_id > 0 ) {
			foreach ( $keys as $key ) {
				$id = get_user_meta( $user_id, $key, true );
				if ( $id ) {
					return $id;
				}
			}
			$settings = get_option( 'woocommerce-ppcp-settings', [] );
			$settings = array_merge( [ 'prefix' => 'WC-' ], $settings );
			$id       = $settings['prefix'] . $user_id;
		}

		return $id;
	}

	protected function get_payment_meta_label() {
		return __( 'Payment Token ID', 'pymntpl-paypal-woocommerce' );
	}

}