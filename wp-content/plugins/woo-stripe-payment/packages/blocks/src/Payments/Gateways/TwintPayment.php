<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class TwintPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_twint';

}