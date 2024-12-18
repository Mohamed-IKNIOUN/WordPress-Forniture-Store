<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;

use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class ACHPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_ach';

	public function get_payment_method_icon() {
		return array(
			'id'  => $this->get_name(),
			'alt' => 'ACH Payment',
			'src' => $this->payment_method->icon
		);
	}

	public function get_payment_method_data() {
		return wp_parse_args( array(
			'businessName'   => $this->payment_method->get_option( 'business_name' ),
			'mandate'        => wc_string_to_bool( $this->get_setting( 'stripe_mandate', 'yes' ) ),
			'mandateText'    => $this->payment_method->get_mandate_text(),
			'accountCountry' => stripe_wc()->account_settings->get_account_country( wc_stripe_mode() ),
			'showSaveOption'         => \in_array( 'tokenization', $this->get_supported_features() ) && wc_string_to_bool( $this->get_setting( 'save_card_enabled', true ) ),
		), parent::get_payment_method_data() );
	}

	protected function get_script_translations() {
		return array_merge(
			parent::get_script_translations(),
			[
				'ach_payment_cancelled' => __( 'ACH payment has been cancelled', 'woo-stripe-payment' ),
				'mandate_text'          => $this->payment_method->get_mandate_text()
			]
		);
	}

}