<?php

namespace PaymentPlugins\Stripe\WooCommerceProductAddons;

use PaymentPlugins\Stripe\Assets\AssetsApi;

class FrontendScripts {

	private $assets;

	public function __construct( AssetsApi $assets ) {
		$this->assets = $assets;
	}

	public function initialize() {
		$this->register_scripts();
		add_action( 'wc_stripe_product_before_payment_methods', [ $this, 'enqueue_scripts' ] );
	}

	private function register_scripts() {
		$this->assets->register_script( 'wc-stripe-product-addons', 'build/product-addons.js' );
	}

	public function enqueue_scripts() {
		\wp_enqueue_script( 'wc-stripe-product-addons' );
	}

}