<?php

namespace PaymentPlugins\WooCommerce\PPCP;

use PaymentPlugins\WooCommerce\PPCP\Assets\AssetsApi;

class FrontendScripts {

	private $assets;

	public function __construct( AssetsApi $assets ) {
		$this->assets = $assets;
	}

	public function initialize() {
		add_action( 'init', [ $this, 'register_scripts' ] );
	}

	public function register_scripts() {
		$this->assets->register_script( 'wc-ppcp-utils', 'build/js/utils.js' );
		$this->assets->register_script( 'wc-ppcp-product', 'build/js/product.js' );
		$this->assets->register_script( 'wc-ppcp-cart', 'build/js/cart.js' );
		$this->assets->register_script( 'wc-ppcp-minicart', 'build/js/minicart.js' );
	}

}