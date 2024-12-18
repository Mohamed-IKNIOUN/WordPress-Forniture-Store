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
class WC_Payment_Gateway_Stripe_Bancontact extends WC_Payment_Gateway_Stripe_Local_Payment {

	use WC_Stripe_Local_Payment_Intent_Trait;

	protected $payment_method_type = 'bancontact';

	public $token_type = 'Stripe_Sepa';

	public function __construct() {
		$this->local_payment_type = 'bancontact';
		$this->currencies         = array( 'EUR' );
		$this->countries          = array( 'BE' );
		$this->id                 = 'stripe_bancontact';
		$this->tab_title          = __( 'Bancontact', 'woo-stripe-payment' );
		$this->method_title       = __( 'Bancontact (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'Bancontact gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		$this->icon               = stripe_wc()->assets_url( 'img/bancontact.svg' );
		parent::__construct();
	}

	public function init_supports() {
		$this->supports = array(
			'tokenization',
			'products',
			'subscriptions',
			'add_payment_method',
			'subscription_cancellation',
			'multiple_subscriptions',
			'subscription_amount_changes',
			'subscription_date_changes',
			'default_credit_card_form',
			'refunds',
			'pre-orders',
			'subscription_payment_method_change_admin',
			'subscription_reactivation',
			'subscription_suspension',
			'subscription_payment_method_change_customer',
		);
	}

}
