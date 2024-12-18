<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class AmazonPayPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_amazonpay';

}