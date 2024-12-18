<?php

namespace PaymentPlugins\Blocks\Stripe;

use Automattic\WooCommerce\Blocks\Integrations\IntegrationRegistry;
use PaymentPlugins\Blocks\Stripe\Assets\Api as AssetsApi;
use PaymentPlugins\Blocks\Stripe\BlockTypes\BNPLMessageCartBlock;
use PaymentPlugins\Blocks\Stripe\Payments\PaymentsApi;

class BlocksController {

	private $container;

	public function __construct( $container ) {
		$this->container = $container;
	}

	public function initialize() {
		add_action( 'woocommerce_blocks_cart_block_registration', [ $this, 'register_blocks' ] );
	}

	public function register_blocks( IntegrationRegistry $registry ) {
		$registry->register( new BNPLMessageCartBlock(
			$this->container->get( PaymentsApi::class ),
			$this->container->get( AssetsApi::class )
		) );
	}

}