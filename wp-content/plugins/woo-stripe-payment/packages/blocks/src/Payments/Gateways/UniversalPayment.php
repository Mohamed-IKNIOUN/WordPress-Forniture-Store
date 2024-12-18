<?php

namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;

use Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema;
use PaymentPlugins\Blocks\Stripe\Assets\Api as AssetsApi;
use PaymentPlugins\Blocks\Stripe\StoreApi\EndpointData;
use PaymentPlugins\Stripe\Controllers\PaymentIntent;
use PaymentPlugins\Stripe\Installments\InstallmentController;
use PaymentPlugins\Stripe\RequestContext;

class UniversalPayment extends \PaymentPlugins\Blocks\Stripe\Payments\AbstractStripePayment {

	protected $name = 'stripe_upm';

	/**
	 * @var InstallmentController
	 */
	private $installments;

	/**
	 * @var \PaymentPlugins\Stripe\Controllers\PaymentIntent
	 */
	private $payment_intent_ctrl;

	public function __construct( AssetsApi $assets_api, PaymentIntent $controller, InstallmentController $installments ) {
		parent::__construct( $assets_api );
		$this->payment_intent_ctrl = $controller;
		$this->installments        = $installments;
	}

	public function get_payment_method_script_handles() {
		$this->assets_api->register_script( 'wc-stripe-block-upm', 'build/wc-stripe-upm.js' );

		return array( 'wc-stripe-block-upm' );
	}

	public function get_payment_method_data() {
		$data = [
			'installmentsActive'    => $this->installments->is_available(),
			'paymentElementOptions' => array(
				'layout' => array(
					'type' => $this->get_setting( 'layout_type', 'tabs' )
				)
			)
		];
		if ( $this->get_setting( 'layout_type', 'tabs' ) === 'accordion' ) {
			$data['paymentElementOptions']['layout']['radios']               = wc_string_to_bool( $this->get_setting( 'layout_radios', 'no' ) );
			$data['paymentElementOptions']['layout']['spacedAccordionItems'] = wc_string_to_bool( $this->get_setting( 'spaced_items', 'no' ) );
		}

		return array_merge(
			parent::get_payment_method_data(),
			$data
		);
	}

	public function get_endpoint_data() {
		$endpoint_data = new EndpointData();
		$endpoint_data->set_namespace( $this->get_name() );
		$endpoint_data->set_endpoint( CartSchema::IDENTIFIER );
		$endpoint_data->set_schema_type( ARRAY_A );
		$endpoint_data->set_data_callback( [ $this, 'get_cart_extension_data' ] );

		return $endpoint_data;
	}

	public function get_cart_extension_data() {
		$this->payment_intent_ctrl->set_request_context( new RequestContext( RequestContext::CHECKOUT ) );

		return [
			'elementOptions' => $this->payment_method->get_element_options()
		];
	}

	public function is_payment_method_active( $name ) {
		$payment_methods = $this->payment_method->get_enabled_payment_methods();

		return is_array( $payment_methods )
		       && isset( $payment_methods[ $name ]['enabled'] )
		       && $payment_methods[ $name ]['enabled'] === true;
	}

	protected function get_script_translations() {
		return [
			'installments' => [
				'pay'           => __( 'Pay in installments:', 'woo-stripe-payment' ),
				'loading'       => __( 'Loading installments...', 'woo-stripe-payment' ),
				'complete_form' => __( 'Fill out card form for eligibility.', 'woo-stripe-payment' )
			]
		];
	}

}