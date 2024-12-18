<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class SwishPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_swish';

}