<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class RevolutPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_revolut';

}