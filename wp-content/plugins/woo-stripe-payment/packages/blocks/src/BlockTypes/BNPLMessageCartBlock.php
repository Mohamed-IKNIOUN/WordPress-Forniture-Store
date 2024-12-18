<?php

namespace PaymentPlugins\Blocks\Stripe\BlockTypes;

use Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface;
use PaymentPlugins\Blocks\Stripe\Assets\Api as AssetsApi;
use PaymentPlugins\Blocks\Stripe\Payments\PaymentsApi;
use PaymentPlugins\Stripe\Utilities\PaymentMethodUtils;

class BNPLMessageCartBlock implements IntegrationInterface {

	private $payments_api;

	private $assets;

	public function __construct( PaymentsApi $payments_api, AssetsApi $assets ) {
		$this->payments_api = $payments_api;
		$this->assets       = $assets;
	}

	public function get_name() {
		return 'stripeBNPLCart';
	}

	public function initialize() {
		// TODO: Implement initialize() method.
	}

	public function get_script_handles() {
		$this->assets->register_script( 'wc-stripe-bpnl-message-cart-block', 'build/bnpl-message-cart-block.js' );

		return [ 'wc-stripe-bpnl-message-cart-block' ];
	}

	public function get_editor_script_handles() {
		return [];
	}

	public function get_script_data() {
		$data     = [];
		$gateways = PaymentMethodUtils::get_active_bnpl_gateways();
		foreach ( $gateways as $gateway ) {
			$payment_method       = $this->payments_api->get_payment_methods()[ $gateway->id ];
			$data[ $gateway->id ] = $payment_method->get_payment_method_data();
		}

		return $data;
	}

}