<?php

namespace PaymentPlugins\WooCommerce\PPCP\Factories;

use PaymentPlugins\PayPalSDK\PaymentSource;
use PaymentPlugins\PayPalSDK\Token;
use PaymentPlugins\WooCommerce\PPCP\Constants;

class PaymentSourceFactory extends AbstractFactory {

	public function from_order() {
		$id = $this->order->get_meta( Constants::BILLING_AGREEMENT_ID );
		if ( ! $id ) {
			$id = $this->order->get_meta( '_paypal_subscription_id' );
		}

		return apply_filters( 'wc_ppcp_payment_source_from_order', ( new PaymentSource() )
			->setToken( ( new Token() )
				->setId( $id )
				->setType( Token::BILLING_AGREEMENT ) ), $this->order );
	}

}