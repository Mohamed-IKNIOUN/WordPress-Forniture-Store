<?php

namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;

class PromptPayPayment extends \PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment {

	protected $name = 'stripe_promptpay';

	protected function get_script_translations() {
		return array_merge(
			parent::get_script_translations(),
			[
				'step1'             => sprintf( esc_html__( 'Click %1$s and you will be shown a QR code.', 'woo-stripe-payment' ), '<b>' . esc_html( $this->payment_method->order_button_text, ) . '</b>' ),
				'step2'             => __( 'Scan the QR code using a payment app that supports PromptPay.', 'woo-stripe-payment' ),
				'step3'             => __( 'The authentication process may take several moments. Once confirmed, you will be redirected to the order received page.', 'woo-stripe-payment' ),
				'payment_cancelled' => __( 'PromptPay payment cancelled.', 'woo-stripe-payment' )
			]
		);
	}

}