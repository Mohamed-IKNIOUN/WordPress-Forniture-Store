<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class PayNowPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_paynow';

	protected function get_script_translations() {
		return array_merge(
			parent::get_script_translations(),
			[
				'payment_cancelled' => __( 'PayNow payment cancelled.', 'woo-stripe-payment' ),
				'payment_expired'   => __( 'PayNow payment expired. Please try again.', 'woo-stripe-payment' ),
				'step1'             => sprintf(
					esc_html__( 'Click %1$s and you will be shown a QR code.', 'woo-stripe-payment' ),
					'<b>' . esc_html( $this->payment_method->order_button_text, ) . '</b>'
				),
				'step2'             => __( 'Scan the QR code using an app from participating banks and participating non-bank financial institutions.', 'woo-stripe-payment' ),
				'step3'             => __( 'The authentication process may take several moments. Once confirmed, you will be redirected to the order received page.', 'woo-stripe-payment' )
			]
		);
	}

}