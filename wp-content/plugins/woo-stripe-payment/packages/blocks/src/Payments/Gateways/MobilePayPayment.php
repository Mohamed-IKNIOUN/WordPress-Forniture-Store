<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class MobilePayPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_mobilepay';

}