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
class WC_Payment_Gateway_Stripe_WeChat extends WC_Payment_Gateway_Stripe_Local_Payment {

	use WC_Stripe_Local_Payment_Intent_Trait;

	protected $payment_method_type = 'wechat_pay';

	public function __construct() {
		$this->local_payment_type = 'wechat_pay';
		$this->currencies         = array( 'AUD', 'CAD', 'CHF', 'CNY', 'DKK', 'EUR', 'GBP', 'HKD', 'JPY', 'NOK', 'SEK', 'SGD', 'USD' );
		$this->id                 = 'stripe_wechat';
		$this->tab_title          = __( 'WeChat', 'woo-stripe-payment' );
		$this->token_type         = 'Stripe_Local';
		$this->method_title       = __( 'WeChat (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'WeChat gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		$this->icon               = stripe_wc()->assets_url( 'img/wechat.svg' );
		parent::__construct();
		$this->template_name = 'wechat.php';
	}

	public function init_form_fields() {
		parent::init_form_fields();
		$this->form_fields['allowed_countries']['default'] = 'all';
	}
}
