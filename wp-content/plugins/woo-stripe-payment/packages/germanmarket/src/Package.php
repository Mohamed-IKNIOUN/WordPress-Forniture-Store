<?php

namespace PaymentPlugins\Stripe\GermanMarket;


use PaymentPlugins\Stripe\Assets\AssetsApi;

class Package {

	public static function init() {
		add_action( 'woocommerce_init', [ __CLASS__, 'initialize' ] );
	}

	public static function initialize() {
		if ( self::is_enabled() ) {
			$assets = new AssetsApi(
				dirname( __DIR__ ) . '/',
				trailingslashit( plugin_dir_url( __DIR__ ) ),
				stripe_wc()->version()
			);
			$assets->register_style( 'wc-stripe-german-market', 'build/styles.css' );
			$assets->register_script( 'wc-stripe-german-market-checkout', 'build/checkout.js' );
			add_action( 'wp_enqueue_scripts', function () use ( $assets ) {
				if ( wc_post_content_has_shortcode( 'woocommerce_de_check' ) ) {
					wp_enqueue_style( 'wc-stripe-german-market' );
				}
				if ( is_checkout() ) {
					wp_enqueue_script( 'wc-stripe-german-market-checkout' );
					wp_localize_script( 'wc-stripe-german-market-checkout', 'wc_stripe_german_market_params', [
						'second_checkout' => get_option( 'woocommerce_de_secondcheckout', 'off' )
					] );
				}
			} );
		}
	}

	private static function is_enabled() {
		return \class_exists( 'Woocommerce_German_Market' );
	}

}