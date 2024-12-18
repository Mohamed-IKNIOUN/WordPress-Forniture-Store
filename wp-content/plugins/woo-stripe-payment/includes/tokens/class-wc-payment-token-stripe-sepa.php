<?php

defined( 'ABSPATH' ) || exit();

/**
 *
 * @since   3.2.4
 * @package Stripe/Tokens
 * @author  PaymentPlugins
 *
 */
class WC_Payment_Token_Stripe_Sepa extends WC_Payment_Token_Stripe_Local {

	use WC_Payment_Token_Payment_Method_Trait {
		save_payment_method as attach_payment_method;
	}

	protected $type = 'Stripe_Sepa';

	protected $stripe_data = array(
		'bank_code'           => '',
		'last4'               => '',
		'mandate_url'         => '',
		'mandate'             => '',
		'payment_method_type' => ''
	);

	public function details_to_props( $details ) {
		$type = $details['type'] ?? '';
		switch ( $type ) {
			case 'sepa_debit':
				$this->set_last4( $details['sepa_debit']['last4'] );
				$this->set_bank_code( $details['sepa_debit']['bank_code'] );
				$this->set_mandate( isset( $details['sepa_debit']['mandate'] ) ? $details['sepa_debit']['mandate'] : '' );
				$this->set_mandate_url( isset( $details['sepa_debit']['mandate_url'] ) ? $details['sepa_debit']['mandate_url'] : '' );
				break;
			default:
				$type = $details['type'];
				$this->set_last4( $details[ $type ]['iban_last4'] ?? '' );
				$this->set_bank_code( $details[ $type ]['bank_code'] ?? '' );
				$this->set_mandate( $details[ $type ]['generated_sepa_debit_mandate'] ?? '' );
				if ( ! empty( $details[ $type ]['generated_sepa_debit'] ) ) {
					$gateways = WC()->payment_gateways()->payment_gateways();
					$sepa     = $gateways['stripe_sepa'] ?? null;
					$this->set_gateway_id( 'stripe_sepa' );
					$this->set_token( $details[ $type ]['generated_sepa_debit'] );
					$this->set_format( 'type_ending_last4' );
					if ( $sepa ) {
						$this->set_format( $sepa->get_option( 'method_format' ) );
					}
				}
		}
		$this->set_payment_method_type( $type );
	}

	public function set_last4( $value ) {
		$this->set_prop( 'last4', $value );
	}

	public function get_last4( $context = 'view' ) {
		return $this->get_prop( 'last4', $context );
	}

	public function set_bank_code( $value ) {
		$this->set_prop( 'bank_code', $value );
	}

	public function get_bank_code( $context = 'view' ) {
		return $this->get_prop( 'bank_code', $context );
	}

	public function set_mandate_url( $value ) {
		$this->set_prop( 'mandate_url', $value );
	}

	public function set_mandate( $value ) {
		$this->set_prop( 'mandate', $value );
	}

	public function get_mandate_url( $context = 'view' ) {
		return $this->get_prop( 'mandate_url', $context );
	}

	public function get_mandate( $context = '$view' ) {
		return $this->get_prop( 'mandate', $context );
	}

	public function get_brand( $context = 'view' ) {
		return __( 'SEPA', 'woo-stripe-payment' );
	}

	public function get_formats() {
		return wp_parse_args( array(
			'type_ending_last4' => array(
				'label'   => __( 'Gateway Title', 'woo-stripe-payment' ),
				'example' => 'Sepa ending in 0005',
				'format'  => __( '{brand} ending in {last4}', 'woo-stripe-payment' ),
			),
			'type_last4'        => array(
				'label'   => __( 'Type Last 4', 'woo-stripe-payment' ),
				'example' => 'Sepa 0005',
				'format'  => '{brand} {last4}',
			),
		), parent::get_formats() );
	}

	public function set_payment_method_type( $value ) {
		$this->set_prop( 'payment_method_type', $value );
	}

	public function get_payment_method_type() {
		$value = $this->get_prop( 'payment_method_type' );

		return empty( $value ) ?? 'sepa_debit';
	}

	public function save_payment_method() {
		switch ( $this->get_payment_method_type() ) {
			case 'sepa_debit':
				return $this->attach_payment_method();
			default:
				return null;
		}
	}

}