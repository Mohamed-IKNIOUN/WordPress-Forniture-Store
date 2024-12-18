<?php

namespace PaymentPlugins\Stripe\Traits;

trait BNPLPaymentGatewayTrait {

	public function get_woocommerce_gateway_icon( $icon, $gateway_id = '' ) {
		if ( $gateway_id === $this->id ) {
			if ( in_array( 'checkout', $this->get_option( 'payment_sections', array() ) ) ) {
				$icon = '';
			} else {
				$src = $this->get_option( 'icon' );
				if ( $src ) {
					$src  = stripe_wc()->assets_url( "img/{$src}.svg" );
					$icon = '<img src="' . \WC_HTTPS::force_https_url( $src ) . '" alt="' . esc_attr( $this->get_title() ) . '" />';
				}
			}
		}

		return $icon;
	}

}