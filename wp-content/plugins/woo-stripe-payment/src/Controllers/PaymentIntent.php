<?php

namespace PaymentPlugins\Stripe\Controllers;

use PaymentPlugins\Stripe\RequestContext;

class PaymentIntent {

	/**
	 * @var \WC_Stripe_Gateway
	 */
	private $client;

	/**
	 * @var array The list of payment methods ID's that are compatible
	 */
	private $payment_method_ids;

	private $retrys = 0;

	private $max_retries = 1;

	private $intent_exists;

	/**
	 * @var RequestContext
	 */
	private $request_context;

	private $element_options;

	private static $instance;

	/**
	 * @param       $client
	 * @param array $payment_method_ids
	 */
	public function __construct( $client, $payment_method_ids ) {
		$this->client             = $client;
		$this->payment_method_ids = $payment_method_ids;
		$this->initialize();
		self::$instance = $this;
	}

	public static function instance() {
		return self::$instance;
	}

	private function initialize() {
		add_action( 'woocommerce_before_pay_action', [ $this, 'set_order_pay_constants' ] );
		add_action( 'woocommerce_checkout_update_order_review', [ $this, 'update_order_review' ] );
		//add_filter( 'wc_stripe_localize_script_wc-stripe', [ $this, 'add_script_params' ], 10, 2 );
		//add_filter( 'wc_stripe_blocks_general_data', [ $this, 'add_blocks_general_data' ] );
	}

	public function set_request_context( $context ) {
		$this->request_context = $context;
	}

	public function get_request_context() {
		if ( ! $this->request_context ) {
			$this->request_context = new RequestContext();
		}

		return $this->request_context;
	}

	public function get_element_options() {
		if ( ! $this->element_options ) {
			$element_options = array(
				'mode'                  => 'payment',
				'paymentMethodCreation' => 'manual'
			);
			if ( ! $this->request_context ) {
				$this->request_context = new RequestContext();
			}
			if ( $this->is_setup_intent_needed() ) {
				$element_options['mode'] = 'setup';
			} elseif ( $this->is_subscription_mode() ) {
				$element_options['mode'] = 'subscription';
			}
			$this->element_options = $element_options;
		}

		return $this->element_options;
	}

	protected function is_payment_intent_required_for_frontend() {
		return count( $this->get_payment_method_types() ) > 0;
	}

	private function is_deferred_intent_creation() {
		//return count( $this->get_payment_method_types() ) > 0;
		return true;
	}

	private function get_payment_method_types() {
		$payment_method_types = [];
		$payment_gateways     = WC()->payment_gateways()->payment_gateways();
		foreach ( $this->payment_method_ids as $id ) {
			$payment_method = isset( $payment_gateways[ $id ] ) ? $payment_gateways[ $id ] : null;
			if ( $payment_method && $payment_method instanceof \WC_Payment_Gateway_Stripe ) {
				if ( wc_string_to_bool( $payment_method->enabled ) && $payment_method->is_deferred_intent_creation() ) {
					$payment_method_types[] = $payment_method->get_payment_method_type();
				}
			}
		}

		return $payment_method_types;
	}

	private function is_setup_intent_needed() {
		return $this->request_context->is_add_payment_method()
		       || apply_filters( 'wc_stripe_create_setup_intent', false, $this->get_request_context() );
	}

	private function is_subscription_mode() {
		return apply_filters( 'wc_stripe_deferred_intent_subscription_mode', false, $this->get_request_context() );
	}

	public function set_order_pay_constants() {
		wc_maybe_define_constant( \WC_Stripe_Constants::WOOCOMMERCE_STRIPE_ORDER_PAY, true );
	}

	public function update_order_review() {
		if ( $this->is_deferred_intent_creation() ) {
			add_filter( 'woocommerce_update_order_review_fragments', [ $this, 'add_element_options_to_fragments' ] );
		}
	}

	public function add_element_options_to_fragments( $fragments ) {
		$fragments['.wc-stripe-element-options'] = rawurlencode( base64_encode( wp_json_encode( $this->get_element_options() ) ) );

		return $fragments;
	}

	public function add_script_params( $data, $name ) {
		if ( $name === 'wc_stripe_params_v3' ) {
			$data['stripeParams']['betas'][] = 'elements_enable_deferred_intent_beta_1';
		}

		return $data;
	}

	/**
	 * @param $data
	 *
	 * @todo remove once betas and headers are no longer needed.
	 */
	public function add_blocks_general_data( $data ) {
		$data['stripeParams']['betas'][] = 'elements_enable_deferred_intent_beta_1';

		return $data;
	}

	public function set_intent_exists( $bool ) {
		$this->intent_exists = $bool;
	}

}