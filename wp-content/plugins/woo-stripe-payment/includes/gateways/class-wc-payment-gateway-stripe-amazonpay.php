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
class WC_Payment_Gateway_Stripe_AmazonPay extends WC_Payment_Gateway_Stripe_Local_Payment {

	use WC_Stripe_Local_Payment_Intent_Trait;

	protected $payment_method_type = 'amazon_pay';

	public function __construct() {
		$this->local_payment_type = 'amazon_pay';
		$this->currencies         = array( 'USD' );
		$this->countries          = array( 'US' );
		$this->id                 = 'stripe_amazonpay';
		$this->tab_title          = __( 'Amazon Pay', 'woo-stripe-payment' );
		$this->method_title       = __( 'Amazon Pay (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'Amazon Pay gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		$this->icon               = stripe_wc()->assets_url( 'img/amazon_pay.svg' );
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
