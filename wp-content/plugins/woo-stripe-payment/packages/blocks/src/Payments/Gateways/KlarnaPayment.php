<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class KlarnaPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_klarna';

	public function get_payment_method_data() {
		$currency   = get_woocommerce_currency();
		$cart_total = 0;
		if ( WC()->cart ) {
			$cart_total = (float) WC()->cart->total;
		}

		return wp_parse_args( array(
			'currency'        => $currency,
			'requiredParams'  => $this->payment_method->get_required_parameters(),
			'messageOptions'  => array(
				'countryCode' => stripe_wc()->account_settings->get_account_country( wc_stripe_mode() )
			),
			'cartTotals'      => [
				'value' => wc_stripe_add_number_precision( $cart_total, $currency )
			],
			'paymentSections' => $this->get_setting( 'payment_sections', [] ),
			'cartEnabled'     => \in_array( 'cart', $this->get_setting( 'payment_sections', [] ) )
		), parent::get_payment_method_data() );
	}

}