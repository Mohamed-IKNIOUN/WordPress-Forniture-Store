<?php

defined( 'ABSPATH' ) || exit();

/**
 *
 * @author  PaymentPlugins
 * @package Stripe/Classes
 *
 */
class WC_Stripe_Redirect_Handler {

	public static function init() {
		add_action( 'wp', array( __CLASS__, 'process_payment_redirect' ) );
		add_action( 'get_header', array( __CLASS__, 'maybe_restore_cart' ), 100 );
		add_action( 'woocommerce_api_stripe_add_payment_method', array( __CLASS__, 'handle_add_payment_method' ) );
	}

	/**
	 * Check if this request is for a local payment redirect.
	 */
	public static function local_payment_redirect() {
		self::process_payment_redirect();
	}

	/**
	 * @since 3.3.62
	 * @return void
	 */
	public static function process_payment_redirect() {
		if ( isset( $_GET['_stripe_payment_method'] ) ) {
			self::process_redirect();
		} elseif ( isset( $_GET[ WC_Stripe_Constants::VOUCHER_PAYMENT ], $_GET['order_id'] ) ) {
			self::process_voucher_redirect();
		}
	}

	/**
	 */
	public static function process_redirect() {
		if ( isset( $_GET['payment_intent'] ) ) {
			$result        = WC_Stripe_Gateway::load()->paymentIntents->retrieve(
				wc_clean( $_GET['payment_intent'] ),
				array( 'expand' => array( 'payment_method' ) )
			);
			$client_secret = isset( $_GET['payment_intent_client_secret'] ) ? $_GET['payment_intent_client_secret'] : '';
		} elseif ( isset( $_GET['setup_intent'] ) ) {
			$result        = WC_Stripe_Gateway::load()->setupIntents->retrieve(
				wc_clean( $_GET['setup_intent'] ),
				array( 'expand' => array( 'payment_method', 'latest_attempt' ) )
			);
			$client_secret = isset( $_GET['setup_intent_client_secret'] ) ? $_GET['setup_intent_client_secret'] : '';
		} else {
			return;
		}
		if ( is_wp_error( $result ) ) {
			wc_add_notice( sprintf( __( 'Error retrieving payment source. Reason: %s', 'woo-stripe-payment' ), $result->get_error_message() ), 'error' );
		} elseif ( ! hash_equals( $client_secret, $result->client_secret ) ) {
			wc_add_notice( __( 'This request is invalid. Please try again.', 'woo-stripe-payment' ), 'error' );
		} else {
			define( WC_Stripe_Constants::REDIRECT_HANDLER, true );
			$order_id = null;
			if ( isset( $result->metadata['order_id'] ) ) {
				$order_id = absint( $result->metadata['order_id'] );
			} else {
				if ( isset( $_GET['key'], $_GET['order_id'] ) ) {
					$order = wc_get_order( absint( $_GET['order_id'] ) );
					if ( $order && ! $order->key_is_valid( $_GET['key'] ) ) {
						wc_stripe_log_info( 'Invalid order key provided while processing redirect.' );
					} else {
						$order_id = absint( $_GET['order_id'] );
					}
				}
			}
			$order = wc_get_order( wc_stripe_filter_order_id( $order_id, $result ) );
			if ( ! $order ) {
				return;
			}

			/**
			 *
			 * @var \WC_Payment_Gateway_Stripe $payment_method
			 */
			$payment_method = WC()->payment_gateways()->payment_gateways()[ $order->get_payment_method() ];

			if ( $result instanceof \Stripe\SetupIntent ) {
				$payment_method->set_setup_intent( $result );
			}

			$redirect = $payment_method->get_return_url( $order );

			if ( in_array( $result->status, array( 'requires_action', 'pending' ) ) ) {
				if ( $result->status === 'pending' ) {
					$order->update_status( 'on-hold' );
				} else {
					if ( $result->status === 'requires_action' ) {
						if ( $payment_method->is_voucher_payment ) {
							if ( method_exists( $payment_method, 'process_voucher_order_status' ) ) {
								$order->set_payment_method_title( $payment_method->get_title() );
								$payment_method->process_voucher_order_status( $order );
							}
						} else {
							if ( ! $payment_method->synchronous ) {
								$order->update_status( 'on-hold' );
							}
						}
					}
				}
			} elseif ( in_array( $result->status, array( 'requires_payment_method', 'failed' ) ) ) {
				wc_add_notice( __( 'Payment authorization failed. Please select another payment method.', 'woo-stripe-payment' ), 'error' );
				wc_stripe_log_info( sprintf( 'User cancelled their payment and has been redirected to the checkout page. Payment Method: %s. Order ID: %s', $payment_method->id, $order->get_id() ) );
				if ( $result instanceof \Stripe\PaymentIntent ) {
					$order->update_meta_data( WC_Stripe_Constants::PAYMENT_INTENT, WC_Stripe_Utils::sanitize_intent( $result->toArray() ) );
				} else {
					$order->delete_meta_data( WC_Stripe_Constants::SOURCE_ID );
				}
				$order->update_status( 'pending' );

				return;
			} elseif ( 'chargeable' === $result->status ) {
				if ( ! $payment_method->has_order_lock( $order ) && ! $order->get_transaction_id() ) {
					$payment_method->set_order_lock( $order );
					$payment_method->set_new_source_token( $result->payment_method->id );
					$result = $payment_method->process_payment( $order_id );
					// we don't release the order lock so there aren't conflicts with the source.chargeable webhook
					if ( $result['result'] === 'success' ) {
						$redirect = $result['redirect'];
					}
				}
			} elseif ( in_array( $result->status, array( 'succeeded', 'requires_capture' ) ) ) {
				if ( ! $payment_method->has_order_lock( $order ) ) {
					$payment_method->set_order_lock( $order );
					$payment_method->set_new_source_token( $result->payment_method->id );
					$result = $payment_method->process_payment( $order_id );
					if ( $result['result'] === 'success' ) {
						$redirect = $result['redirect'];
					}
				}
			} elseif ( $result->status === 'processing' && isset( $result->charges->data ) ) {
				if ( ! $payment_method->has_order_lock( $order ) ) {
					$payment_method->set_order_lock( $order );
					$payment_method->payment_object->payment_complete( $order, $result->charges->data[0] );
					WC_Stripe_Utils::delete_payment_intent_to_session();
					$payment_method->release_order_lock( $order );
				}
				// if this isn't the checkout page, then skip redirect
				if ( ! is_checkout() ) {
					return;
				}
			}
			wp_safe_redirect( $redirect );
			exit();
		}
	}

	public static function maybe_restore_cart() {
		global $wp;
		if ( isset( $wp->query_vars['order-received'] ) && isset( $_GET['wc_stripe_product_checkout'] ) ) {
			add_action( 'woocommerce_cart_emptied', 'wc_stripe_restore_cart_after_product_checkout' );
		}
	}

	private static function process_voucher_redirect() {
		$payment_method = wc_clean( $_GET[ WC_Stripe_Constants::VOUCHER_PAYMENT ] );
		/**
		 * @var \WC_Payment_Gateway_Stripe $payment_method
		 */
		$payment_methods = WC()->payment_gateways()->payment_gateways();
		$payment_method  = $payment_methods[ $payment_method ];
		$order           = wc_get_order( absint( wc_clean( $_GET['order_id'] ) ) );
		$order_key       = isset( $_GET['order_key'] ) ? wc_clean( wp_unslash( $_GET['order_key'] ) ) : '';
		if ( $order && hash_equals( $order->get_order_key(), $order_key ) ) {
			if ( method_exists( $payment_method, 'process_voucher_order_status' ) ) {
				$order->set_payment_method_title( $payment_method->get_title() );
				$payment_method->process_voucher_order_status( $order );
				wp_safe_redirect( $payment_method->get_return_url( $order ) );
				exit();
			}
		}
	}

	public static function handle_add_payment_method() {
		$nonce          = wc_get_var( $_GET['nonce'], '' );
		$payment_method = wc_get_var( $_GET['payment_method'], null );
		if ( $payment_method && ! empty( $nonce ) && wp_verify_nonce( $nonce, $payment_method ) ) {
			$setup_intent  = wc_get_var( $_GET['setup_intent'], null );
			$client_secret = wc_get_var( $_GET['setup_intent_client_secret'], null );
			$context       = wc_get_var( $_GET['context'], '' );
			try {
				/**
				 * @var \WC_Payment_Gateway_Stripe $gateway
				 */
				$gateway = WC()->payment_gateways()->payment_gateways()[ $payment_method ] ?? null;
				if ( $gateway && ! empty( $setup_intent ) ) {
					$setup_intent = $gateway->gateway->setupIntents->retrieve( $setup_intent, array(
						'expand' => array( 'payment_method', 'latest_attempt' )
					) );
					if ( is_wp_error( $setup_intent ) ) {
						throw new \Exception( $setup_intent->get_error_message() );
					}
					if ( ! hash_equals( $client_secret, $setup_intent->client_secret ) ) {
						throw new \Exception( __( 'Invalid setup intent secret.', 'woo-stripe-payment' ) );
					}

					if ( ! empty( $setup_intent->payment_method ) ) {
						$_REQUEST[ WC_Stripe_Constants::STRIPE_PAYMENT_METHOD_TYPE ] = $setup_intent->payment_method->type;

						if ( $gateway instanceof WC_Payment_Gateway_Stripe_UPM ) {
							$child_gateway = $gateway->get_child_payment_gateway( $setup_intent->payment_method->type );
							if ( $child_gateway ) {
								$gateway = $child_gateway;
							}
						}
					}


					$gateway->set_setup_intent( $setup_intent );
					$gateway->set_new_source_token( $setup_intent->payment_method->id );

					if ( $context === 'add_payment_method' ) {
						if ( $setup_intent->status === 'requires_payment_method' ) {
							wp_safe_redirect(
								wc_get_endpoint_url( 'add-payment-method', '', wc_get_page_permalink( 'myaccount' ) )
							);
							exit();
						} elseif ( $setup_intent->status === 'succeeded' ) {
							$result = $gateway->add_payment_method();
						}
					} else {
						$result = apply_filters( 'wc_stripe_process_redirect_' . $context, array(), $gateway, $setup_intent );
					}

					if ( $result['result'] === 'error' ) {
						if ( isset( $result['redirect'] ) ) {
							wp_safe_redirect( $result['redirect'] );
						} else {
							wp_safe_redirect(
								wc_get_endpoint_url( 'add-payment-method', '', wc_get_page_permalink( 'myaccount' ) )
							);
						}
						exit();
					}

					wp_safe_redirect( $result['redirect'] );
					exit();
				}
			} catch ( \Exception $e ) {
				wc_add_notice( $e->getMessage(), 'error' );
				wp_safe_redirect(
					wc_get_endpoint_url( 'add-payment-method', '', wc_get_page_permalink( 'myaccount' ) )
				);
			}
		}
	}

}

WC_Stripe_Redirect_Handler::init();
