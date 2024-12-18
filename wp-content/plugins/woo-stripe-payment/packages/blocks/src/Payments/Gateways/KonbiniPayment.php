<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class KonbiniPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_konbini';

	protected function get_script_translations() {
		return array_merge(
			parent::get_script_translations(),
			[
				'step1' => sprintf(
					__( 'Click %1$s and you will be presented with your Konbini payment code and confirmation number.', 'woo-stripe-payment' ),
					'<b>' . $this->payment_method->order_button_text . '</b>'
				),
				'step2' => __( 'Your order email will contain a link to your Konbini voucher which has your payment code and confirmation number.', 'woo-stripe-payment' ),
				'step3' => __( 'At the convenience store, provide the payment code and confirmation number to the payment machine or cashier.', 'woo-stripe-payment' ),
				'step4' => __( 'After the payment is complete, keep the receipt for your records.', 'woo-stripe-payment' )
			]
		);
	}

}