<?php

defined( 'ABSPATH' ) || exit();

if ( function_exists( 'WC' ) ) {
	$payment_gateways = WC()->payment_gateways()->payment_gateways();
	$ids              = [ 'stripe_ach', 'stripe_sepa' ];
	foreach ( $ids as $id ) {
		$payment_gateway = isset( $payment_gateways[ $id ] ) ? $payment_gateways[ $id ] : null;
		if ( $payment_gateway ) {
			$payment_gateway->update_option( 'stripe_mandate', 'no' );
		}
	}

	$ids = [ 'stripe_applepay', 'stripe_googlepay', 'stripe_payment_request' ];
	foreach ( $ids as $id ) {
		$payment_gateway = isset( $payment_gateways[ $id ] ) ? $payment_gateways[ $id ] : null;
		if ( $payment_gateway ) {
			$payment_gateway->update_option( 'notice_enabled', 'no' );
		}
	}

	stripe_wc()->advanced_settings->update_option( 'guest_customer', 'no' );
}