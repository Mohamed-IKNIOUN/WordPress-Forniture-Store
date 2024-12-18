<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class AfterpayPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_afterpay';

	public function get_payment_method_data() {
		$data = wp_parse_args( array(
			'cartEnabled'            => \in_array( 'cart', $this->get_setting( 'payment_sections', [] ) ),
			'requiredParams'         => $this->payment_method->get_required_parameters(),
			'checkoutMessageOptions' => $this->payment_method->get_afterpay_message_options( 'checkout' ),
			'cartMessageOptions'     => $this->payment_method->get_afterpay_message_options( 'cart' ),
			'cartTotal'              => WC()->cart ? wc_stripe_add_number_precision( WC()->cart->total ) : 0,
			'currency'               => get_woocommerce_currency(),
			'accountCountry'         => $this->get_account_country(),
			'hideIneligible'         => wc_string_to_bool( $this->get_setting( 'hide_ineligible', 'no' ) ),
			'paymentSections'        => $this->get_setting( 'payment_sections', [] )
		), parent::get_payment_method_data() );
		if ( ! in_array( $data['locale'], $this->payment_method->get_supported_locales() ) ) {
			$data['locale'] = 'auto';
		}

		return $data;
	}

	/**
	 * @since 3.3.12
	 * @return mixed|string
	 */
	private function get_account_country() {
		$mode    = wc_stripe_mode();
		$country = stripe_wc()->account_settings->get_account_country( $mode );
		if ( empty( $country ) && $mode === 'test' ) {
			$country = wc_get_base_location()['country'];
		}

		return $country;
	}

	public function get_supported_locales() {
		return apply_filters( 'wc_stripe_afterpay_supported_locales', [ 'en-US', 'en-CA', 'en-AU', 'en-NZ', 'en-GB', 'fr-FR', 'it-IT', 'es-ES' ] );
	}

	protected function get_payment_method_icon() {
		return array(
			'id'  => $this->get_name(),
			'alt' => 'Afterpay',
			'src' => stripe_wc()->assets_url( "img/{$this->get_setting('icon', 'afterpay')}.svg" )
		);
	}

}