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
class WC_Payment_Gateway_Stripe_Swish extends WC_Payment_Gateway_Stripe_Local_Payment {

	protected $payment_method_type = 'swish';

	use WC_Stripe_Local_Payment_Intent_Trait;

	public function __construct() {
		$this->local_payment_type = 'swish';
		$this->currencies         = array( 'SEK' );
		$this->countries          = array( 'SE' );
		$this->id                 = 'stripe_swish';
		$this->tab_title          = __( 'Swish', 'woo-stripe-payment' );
		$this->method_title       = __( 'Swish (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'Swish gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		$this->icon               = stripe_wc()->assets_url( 'img/swish.svg' );
		parent::__construct();
	}

}
