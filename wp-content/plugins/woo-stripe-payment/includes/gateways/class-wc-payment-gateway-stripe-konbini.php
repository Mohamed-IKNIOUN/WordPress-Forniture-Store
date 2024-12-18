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
class WC_Payment_Gateway_Stripe_Konbini extends WC_Payment_Gateway_Stripe_Local_Payment {

	use WC_Stripe_Local_Payment_Intent_Trait;

	use WC_Stripe_Voucher_Payment_Trait;

	protected $payment_method_type = 'konbini';

	public $synchronous = false;

	public $is_voucher_payment = true;

	public function __construct() {
		$this->local_payment_type = 'konbini';
		$this->currencies         = array( 'JPY' );
		$this->countries          = array( 'JP' );
		$this->id                 = 'stripe_konbini';
		$this->tab_title          = __( 'Konbini', 'woo-stripe-payment' );
		$this->method_title       = __( 'Konbini (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'Konbini gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		$this->icon               = stripe_wc()->assets_url( 'img/konbini.svg' );
		parent::__construct();
	}

	public function get_local_payment_settings() {
		return array_merge( parent::get_local_payment_settings(), array(
			'expiration_days' => array(
				'title'       => __( 'Expiration Days', 'woo-stripe-payment' ),
				'type'        => 'select',
				'default'     => '3',
				'options'     => array_reduce( range( 0, 60 ), function ( $carry, $item ) {
					$carry[ $item ] = sprintf( _n( '%s day', '%s days', $item, 'woo-stripe-payment' ), $item );

					return $carry;
				}, array() ),
				'desc_tip'    => true,
				'description' => __( 'The number of days before the voucher expires.', 'woo-stripe-payment' )
			),
			'email_link'      => array(
				'title'       => __( 'Voucher Link In Email', 'woo-stripe-payment' ),
				'type'        => 'checkbox',
				'default'     => 'yes',
				'desc_tip'    => true,
				'description' => __( 'If enabled, the voucher link will be included in the order on-hold email sent to the customer.', 'woo-stripe-payment' )
			)
		) );
	}

	public function add_stripe_order_args( &$args, $order, $intent = null ) {
		$args['payment_method_options'] = array(
			'konbini' => array(
				'confirmation_number' => $this->sanitize_confirmation_number( $order->get_billing_phone() ),
				'expires_after_days'  => $this->get_option( 'expiration_days', 3 ),
				'product_description' => substr( sprintf( __( 'Order %1$s', 'woo-stripe-payment' ), $order->get_order_number() ), 0, 22 )
			)
		);
	}

	public function get_payment_intent_confirmation_args( $intent, $order ) {
		return array(
			'return_url'             => $this->get_complete_payment_return_url( $order ),
			'payment_method_options' => array(
				'konbini' => array(
					'confirmation_number' => $this->sanitize_confirmation_number( $order->get_billing_phone() )
				)
			)
		);
	}

	/**
	 * @param $value
	 *
	 * @since 3.3.38
	 * @return array|string|string[]|null
	 */
	private function sanitize_confirmation_number( $value ) {
		return preg_replace( '/[^\d]/', '', $value );
	}

	public function validate_local_payment_available( $currency, $billing_country, $total ) {
		return 120 <= $total && $total <= 300000;
	}

}
