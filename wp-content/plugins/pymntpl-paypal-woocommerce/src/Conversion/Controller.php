<?php

namespace PaymentPlugins\WooCommerce\PPCP\Conversion;

use PaymentPlugins\PayPalSDK\PayPalClient;
use PaymentPlugins\PayPalSDK\Token;
use PaymentPlugins\WooCommerce\PPCP\PluginIntegrationController;

class Controller {

	private $registry;

	public function __construct( Registry $registry ) {
		$this->registry = $registry;
		$this->initialize();
	}

	private function initialize() {
		add_action( 'wc_ppcp_loaded', [ $this->registry, 'initialize' ] );
		add_action( 'woocommerce_ppcp_plugin_conversion_registration', [ $this, 'register_instances' ], 10, 2 );
		add_filter( 'wc_ppcp_add_subscription_payment_meta', [ $this, 'add_subscription_payment_meta' ], 10, 2 );
		add_filter( 'woocommerce_subscription_get_payment_method', [ $this, 'get_payment_method' ], 10, 2 );
		add_filter( 'wc_ppcp_payment_source_from_order', [ $this, 'get_payment_source_from_order' ], 10, 2 );
		add_action( 'wc_ppcp_renewal_payment_processed', [ $this, 'update_subscription_meta' ] );
	}

	public function register_instances( $registry, $container ) {
		$this->register_conversions( $container );
		$this->registry->register( $container->get( WooCommercePayPalPayments::class ) );
		$this->registry->register( $container->get( WooCommercePayPalCheckoutGateway::class ) );
		$this->registry->register( $container->get( WooCommercePayPalAngellEYE::class ) );
		$this->registry->register( $container->get( WooCommercePPCPAngellEYE::class ) );
	}

	/**
	 * @param \PaymentPlugins\WooCommerce\PPCP\Container\Container $container
	 */
	private function register_conversions( $container ) {
		$container->register( WooCommercePayPalPayments::class, function ( $container ) {
			return new WooCommercePayPalPayments(
				$container->get( PayPalClient::class )
			);
		} );
		$container->register( WooCommercePayPalCheckoutGateway::class, function ( $container ) {
			return new WooCommercePayPalCheckoutGateway(
				$container->get( PayPalClient::class )
			);
		} );
		$container->register( WooCommercePayPalAngellEYE::class, function ( $container ) {
			return new WooCommercePayPalAngellEYE(
				$container->get( PayPalClient::class )
			);
		} );
		$container->register( WooCommercePPCPAngellEYE::class, function ( $container ) {
			return new WooCommercePPCPAngellEYE(
				$container->get( PayPalClient::class )
			);
		} );
	}

	/**
	 * @param array     $payment_meta
	 * @param \WC_Order $subscription
	 */
	public function add_subscription_payment_meta( $payment_meta, $subscription ) {
		foreach ( $this->registry->get_registered_integrations() as $integration ) {
			$payment_meta = $integration->add_subscription_payment_meta( $payment_meta, $subscription );
		}

		return $payment_meta;
	}

	/**
	 * @param string    $payment_method
	 * @param \WC_Order $order
	 */
	public function get_payment_method( $payment_method, $order ) {
		foreach ( $this->registry->get_registered_integrations() as $integration ) {
			$payment_method = $integration->get_payment_method( $payment_method, $order );
		}

		return $payment_method;
	}

	/**
	 * @param \PaymentPlugins\PayPalSDK\PaymentSource $payment_source
	 * @param \WC_Order                               $order
	 */
	public function get_payment_source_from_order( $payment_source, $order ) {
		if ( $payment_source->getToken() && $payment_source->getToken()->getType() === Token::BILLING_AGREEMENT ) {
			foreach ( $this->registry->get_registered_integrations() as $integration ) {
				if ( $integration->is_plugin ) {
					$payment_source = $integration->get_payment_source_from_order( $payment_source, $order );
				}
			}
		}

		return $payment_source;
	}

	public function update_subscription_meta( \WC_Order $order ) {
		foreach ( $this->registry->get_registered_integrations() as $integration ) {
			if ( $integration->is_plugin ) {
				$subscription_id = $order->get_meta( '_subscription_renewal' );
				if ( $subscription_id ) {
					$subscription = wcs_get_subscription( absint( $subscription_id ) );
					if ( $subscription && $subscription instanceof \WC_Subscription ) {
						$integration->update_subscription_meta( $subscription );
					}
				}
			}
		}
	}

}