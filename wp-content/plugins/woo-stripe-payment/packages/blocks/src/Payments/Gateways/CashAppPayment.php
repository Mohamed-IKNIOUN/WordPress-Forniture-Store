<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class CashAppPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_cashapp';

}