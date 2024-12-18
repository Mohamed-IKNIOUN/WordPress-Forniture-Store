<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use Automattic\WooCommerce\Blocks\Payments\PaymentContext;
use Automattic\WooCommerce\Blocks\Payments\PaymentResult;
use PaymentPlugins\Blocks\Stripe\Assets\Api as AssetsApi;
use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class WeChatPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_wechat';

	public function __construct( AssetsApi $assets_api ) {
		parent::__construct( $assets_api );
	}

	public function get_payment_method_data() {
		return array_merge( parent::get_payment_method_data(), array(
			'instructions' => [
				sprintf( __( 'Click %1$s to initiate the WeChat payment.', 'woo-stripe-payment' ), $this->payment_method->order_button_text ),
				esc_html__( 'A QR code will render on this page.', 'woo-stripe-payment' ),
				esc_html__( 'Scan the QR code and authenticate the payment using your WeChat Pay app', 'woo-stripe-payment' ),
				esc_html__( 'After you authenticate, stay on this page until it redirects to the order received page.', 'woo-stripe-payment' )
			]
		) );
	}

}