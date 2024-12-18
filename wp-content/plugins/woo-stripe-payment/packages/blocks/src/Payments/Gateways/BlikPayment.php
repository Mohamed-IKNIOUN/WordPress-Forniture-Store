<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class BlikPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_blik';

	protected function get_script_translations() {
		return array_merge(
			parent::get_script_translations(),
			[
				'enter_blik_code' => __( 'Please enter your 6 digit BLIK code.', 'woo-stripe-payment' ),
				'timer_msg'       => __( 'Your transaction will expire in:', 'woo-stripe-payment' ),
				'step1'           => __( 'Request your 6-digit code from your banking application.', 'woo-stripe-payment' ),
				'step2'           => sprintf(
					__( 'Enter the code into the input fields below. Click %1$s once you have entered the code.', 'woo-stripe-payment' ),
					'<b>' . $this->payment_method->order_button_text . '</b>'
				),
				'step3'           => __( 'You will receive a notification on your mobile device asking you to authorize the payment.', 'woo-stripe-payment' )
			]
		);
	}

}