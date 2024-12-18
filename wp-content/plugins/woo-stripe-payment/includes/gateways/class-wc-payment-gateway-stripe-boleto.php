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
class WC_Payment_Gateway_Stripe_Boleto extends WC_Payment_Gateway_Stripe_Local_Payment {

	use WC_Stripe_Local_Payment_Intent_Trait;

	use WC_Stripe_Voucher_Payment_Trait;

	protected $payment_method_type = 'boleto';

	public $synchronous = false;

	public $is_voucher_payment = true;

	public function __construct() {
		$this->local_payment_type = 'boleto';
		$this->currencies         = array( 'BRL' );
		$this->countries          = $this->limited_countries = array( 'BR' );
		$this->id                 = 'stripe_boleto';
		$this->tab_title          = __( 'Boleto', 'woo-stripe-payment' );
		$this->method_title       = __( 'Boleto (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'Boleto gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		$this->icon               = stripe_wc()->assets_url( 'img/boleto.svg' );
		parent::__construct();
		$this->template_name = 'boleto.php';
	}

	public function get_local_payment_settings() {
		return array_merge( parent::get_local_payment_settings(), array(
			'expiration_days' => array(
				'title'       => __( 'Expiration Days', 'woo-stripe-payment' ),
				'type'        => 'select',
				'default'     => '3',
				'options'     => array_reduce( range( 0, 14 ), function ( $carry, $item ) {
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
			'boleto' => array(
				'expires_after_days' => $this->get_option( 'expiration_days', 3 )
			)
		);
	}

}
