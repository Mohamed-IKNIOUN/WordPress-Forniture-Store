<?php
defined( 'ABSPATH' ) || exit();

if ( ! class_exists( 'WC_Payment_Gateway_Stripe_Local_Payment' ) ) {
	return;
}

/**
 *
 * @package Stripe/Gateways
 * @author  PaymentPlugins
 *
 */
class WC_Payment_Gateway_Stripe_MobilePay extends WC_Payment_Gateway_Stripe_Local_Payment {

	use WC_Stripe_Local_Payment_Intent_Trait;

	protected $payment_method_type = 'mobilepay';

	public function __construct() {
		$this->local_payment_type = 'mobilepay';
		$this->currencies         = array( 'DKK', 'EUR', 'NOK', 'SEK' );
		$this->countries          = array( 'DK', 'FI' );
		$this->id                 = 'stripe_mobilepay';
		$this->tab_title          = __( 'MobilePay', 'woo-stripe-payment' );
		$this->method_title       = __( 'MobilePay (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'MobilePay gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		$this->icon               = stripe_wc()->assets_url( 'img/mobilepay.svg' );
		parent::__construct();
	}

	public function get_local_payment_settings() {
		return wp_parse_args(
			array(
				'charge_type' => array(
					'type'        => 'select',
					'title'       => __( 'Charge Type', 'woo-stripe-payment' ),
					'default'     => 'capture',
					'class'       => 'wc-enhanced-select',
					'options'     => array(
						'capture'   => __( 'Capture', 'woo-stripe-payment' ),
						'authorize' => __( 'Authorize', 'woo-stripe-payment' ),
					),
					'desc_tip'    => true,
					'description' => __( 'This option determines whether the customer\'s funds are captured immediately or authorized and can be captured at a later date.',
						'woo-stripe-payment' ),
				),
			),
			parent::get_local_payment_settings() );
	}

}
