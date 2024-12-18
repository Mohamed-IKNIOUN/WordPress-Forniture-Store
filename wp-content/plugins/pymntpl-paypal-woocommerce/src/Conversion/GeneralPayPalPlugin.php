<?php

namespace PaymentPlugins\WooCommerce\PPCP\Conversion;

use PaymentPlugins\PayPalSDK\PayPalClient;
use PaymentPlugins\PayPalSDK\Token;
use PaymentPlugins\WooCommerce\PPCP\Constants;
use PaymentPlugins\WooCommerce\PPCP\PluginIntegrationController;

abstract class GeneralPayPalPlugin {

	/**
	 * @var string
	 */
	public $id;

	/**
	 * @var string
	 */
	protected $payment_token_id;

	public $is_plugin = false;

	protected $client;

	protected $label;

	/**
	 * @var \PaymentPlugins\PayPalSDK\PaymentSource
	 */
	protected $payment_source;

	public function __construct( PayPalClient $client ) {
		$this->client = $client;
	}

	/**
	 * @param \PaymentPlugins\PayPalSDK\PaymentSource $payment_source
	 * @param \WC_Order                               $order
	 */
	public function get_payment_source_from_order( $payment_source, $order ) {
		$token = $payment_source->getToken();
		if ( ! $token->getId() ) {
			$id = $order->get_meta( $this->payment_token_id );
			if ( $id ) {
				$token->setId( $id );
				$this->payment_source = $payment_source;
			}
		}

		return $payment_source;
	}

	/**
	 * @param string    $payment_method
	 * @param \WC_Order $order
	 */
	public function get_payment_method( $payment_method, $order ) {
		if ( $payment_method === $this->id ) {
			$payment_method  = 'ppcp';
			$this->is_plugin = true;
		}

		return $payment_method;
	}

	/**
	 * @param array     $payment_meta
	 * @param \WC_Order $subscription
	 */
	public function add_subscription_payment_meta( $payment_meta, $subscription ) {
		if ( isset( $payment_meta['ppcp'] ) ) {
			if ( $this->is_plugin ) {
				if ( empty( $payment_meta['ppcp']['post_meta'][ $this->payment_token_id ]['value'] ) ) {
					$id = $subscription->get_meta( $this->payment_token_id );
					if ( $id ) {
						$payment_meta['ppcp']['post_meta'][ $this->payment_token_id ]['value'] = $id;
					}
				}
				$payment_meta['ppcp']['post_meta'][ $this->payment_token_id ]['label'] = $this->get_payment_meta_label();
			}
		}

		return $payment_meta;
	}

	protected function get_payment_meta_label() {
		return __( 'Billing Agreement ID', 'pymntpl-paypal-woocommerce' );
	}

	/**
	 * @param \WC_Subscription $subscription
	 *
	 * @return void
	 */
	public function update_subscription_meta( \WC_Subscription $subscription ) {
		if ( $this->payment_source ) {
			if ( $this->payment_source->getToken() ) {
				$subscription->update_meta_data( $this->payment_token_id, $this->payment_source->getToken()->getId() );
				$subscription->save();
			} elseif ( $this->payment_source->getPayPal() ) {
				$subscription->update_meta_data( $this->payment_token_id, $this->payment_source->getPayPal()->vault_id );
				$subscription->save();
			}
		}
	}

}