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
class WC_Payment_Gateway_Stripe_BLIK extends WC_Payment_Gateway_Stripe_Local_Payment {

	protected $payment_method_type = 'blik';

	use WC_Stripe_Local_Payment_Intent_Trait;

	public function __construct() {
		$this->local_payment_type = 'blik';
		$this->currencies         = array( 'PLN' );
		$this->countries          = array( 'PL' );
		$this->id                 = 'stripe_blik';
		$this->tab_title          = __( 'BLIK', 'woo-stripe-payment' );
		$this->method_title       = __( 'BLIK (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'BLIK gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		$this->icon               = stripe_wc()->assets_url( 'img/blik.svg' );
		parent::__construct();
		$this->template_name = 'blik.php';
	}

}
