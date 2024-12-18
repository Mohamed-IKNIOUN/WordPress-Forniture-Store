<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class ZipPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_zip';

}