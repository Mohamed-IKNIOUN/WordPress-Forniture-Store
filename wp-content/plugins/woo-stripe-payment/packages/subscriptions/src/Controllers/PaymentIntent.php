<?php

namespace PaymentPlugins\Stripe\WooCommerceSubscriptions\Controllers;

use PaymentPlugins\Stripe\RequestContext;
use PaymentPlugins\Stripe\WooCommerceSubscriptions\FrontendRequests;

class PaymentIntent {

	private $request;

	public function __construct( FrontendRequests $request ) {
		$this->request = $request;
		$this->initialize();
	}

	private function initialize() {
		add_filter( 'wc_stripe_create_setup_intent', [ $this, 'maybe_create_setup_intent' ], 10, 2 );
		add_filter( 'wc_stripe_payment_intent_args', [ $this, 'update_payment_intent_args' ], 10, 2 );
		add_filter( 'wc_stripe_setup_intent_params', [ $this, 'update_setup_intent_params' ], 10, 2 );
		add_filter( 'wc_stripe_update_setup_intent_params', [ $this, 'update_setup_intent_params' ], 10, 2 );

		/**
		 * Filter that is called when a setup-intent is created via the REST API
		 */
		add_filter( 'wc_stripe_create_setup_intent_params', [ $this, 'add_setup_intent_params' ], 10, 2 );

		add_filter( 'wc_stripe_deferred_intent_subscription_mode', [ $this, 'is_subscription_mode' ], 10, 2 );

		add_action( 'wc_stripe_output_checkout_fields', [ $this, 'print_script_variables' ] );

		add_filter( 'wc_stripe_create_payment_method_return_url', [ $this, 'add_change_payment_method_query' ], 10, 3 );

		add_filter( 'wc_stripe_process_redirect_change_payment_method', [ $this, 'process_change_payment_method_redirect' ], 10, 3 );

		add_filter( 'wc_stripe_is_link_active', [ $this, 'is_link_active' ] );
	}

	private function account_requires_mandate() {
		return stripe_wc()->account_settings->get_account_country( wc_stripe_mode() ) === 'IN';
	}

	public function maybe_create_setup_intent( $bool, RequestContext $context ) {
		if ( ! $bool ) {
			if ( $this->request->is_change_payment_method() ) {
				$bool = true;
			} elseif ( $this->request->is_checkout_with_free_trial( $context ) ) {
				$bool = true;
			} elseif ( $this->request->is_order_pay_with_free_trial( $context ) ) {
				$bool = true;
			} elseif ( $this->request->is_checkout_with_free_coupon( $context ) ) {
				$bool = true;
			}
		}

		return $bool;
	}

	/**
	 * @param $bool
	 *
	 * @since 3.3.60
	 * @return bool|mixed
	 */
	public function is_subscription_mode( $bool, RequestContext $context ) {
		if ( ! $bool ) {
			$is_manual_enabled = wcs_is_manual_renewal_enabled();

			// if $is_manual_enabled is enabled then subscription mode isn't needed.
			if ( ! $is_manual_enabled ) {
				if ( $this->request->is_order_pay_with_subscription( $context ) ) {
					$bool = true;
				} elseif ( $this->request->is_checkout_with_subscription( $context ) ) {
					$bool = true;
				}
			}
		}

		return $bool;
	}

	/**
	 * @param array     $args
	 * @param \WC_Order $order
	 *
	 * @return void
	 */
	public function update_payment_intent_args( $args, $order ) {
		return $this->add_params_to_intent( $args, $order );
	}

	public function update_setup_intent_params( $args, $order ) {
		return $this->add_params_to_intent( $args, $order, 'setup_intent' );
	}

	/**
	 * @param array     $args
	 * @param \WC_Order $order
	 * @param string    $type
	 *
	 * @return array
	 */
	private function add_params_to_intent( $args, $order, $type = 'payment_intent' ) {
		if ( isset( $args['payment_method_types'] ) && in_array( 'card', $args['payment_method_types'] ) ) {
			// check if this is an India account. If so, make sure mandate data is included.
			if ( stripe_wc()->account_settings->get_account_country( wc_stripe_order_mode( $order ) ) === 'IN' ) {
				if ( isset( $args['setup_future_usage'] ) && $args['setup_future_usage'] === 'off_session'
				     || $type === 'setup_intent'
				     || wcs_order_contains_subscription( $order )
				) {
					$subscriptions = wcs_get_subscriptions_for_order( $order );
					if ( $subscriptions ) {
						$total = max( array_map( function ( $subscription ) {
							return (float) $subscription->get_total();
						}, $subscriptions ) );
						if ( ! isset( $args['payment_method_options']['card'] ) ) {
							$args['payment_method_options']['card'] = [];
						}
						$args['payment_method_options']['card']['mandate_options'] = array(
							'amount'          => wc_stripe_add_number_precision( $total, $order->get_currency() ),
							'amount_type'     => 'maximum',
							'interval'        => 'sporadic',
							'reference'       => $order->get_id(),
							'start_date'      => time(),
							'supported_types' => [ 'india' ]
						);
						if ( $type === 'setup_intent' ) {
							$args['payment_method_options']['card']['mandate_options']['currency'] = $order->get_currency();
						}
					}
				}
			}
		}

		return $args;
	}

	/**
	 * @param array                      $args
	 * @param \WC_Payment_Gateway_Stripe $payment_method
	 *
	 * @return array
	 */
	public function add_setup_intent_params( $args, $payment_method ) {
		if ( isset( $args['payment_method_types'] ) && in_array( 'card', $args['payment_method_types'] ) ) {
			if ( $payment_method->is_mandate_required() ) {
				//if ( \WC_Subscriptions_Cart::cart_contains_free_trial() ) {
				if ( ! isset( $args['payment_method_options']['card'] ) ) {
					$args['payment_method_options']['card'] = [];
				}
				$total = 15000;//$this->get_recurring_cart_total();
				// add margin to the total since the shipping might not have been calculated yet.
				$customer_id = wc_stripe_get_customer_id();
				if ( ! $customer_id ) {
					$customer = \WC_Stripe_Customer_Manager::instance()->create_customer( WC()->customer );
					if ( ! is_wp_error( $customer ) ) {
						$customer_id = $customer->id;
						WC()->session->set( \WC_Stripe_Constants::STRIPE_CUSTOMER_ID, $customer_id );
					}
				}
				$args['customer']                                          = $customer_id;
				$args['payment_method_options']['card']['mandate_options'] = array(
					'amount'          => wc_stripe_add_number_precision( $total ),
					'amount_type'     => 'maximum',
					'interval'        => 'sporadic',
					'reference'       => sprintf( '%1$s-%2$s', WC()->session->get_customer_id(), uniqid() ),
					'start_date'      => time(),
					'supported_types' => [ 'india' ],
					'currency'        => get_woocommerce_currency()
				);
				//}
			}
		}

		return $args;
	}

	public function print_script_variables() {
		if ( WC()->cart && wcs_stripe_active() && \WC_Subscriptions_Cart::cart_contains_subscription() ) {
			stripe_wc()->data_api()->print_data( 'wc_stripe_cart_contains_subscription', true );
		}
	}

	private function get_recurring_cart_total() {
		WC()->cart->calculate_totals();
		$carts = WC()->cart->recurring_carts;
		if ( \is_array( $carts ) ) {
			return array_reduce( WC()->cart->recurring_carts, function ( $total, $cart ) {
				return (float) $total + (float) $cart->get_total( 'edit' );
			}, 0 );
		}

		return 0;
	}

	/**
	 * @param                            $url
	 * @param \WC_Payment_Gateway_Stripe $gateway
	 * @param                            $page
	 *
	 * @return mixed|string
	 */
	public function add_change_payment_method_query( $url, $gateway, $page ) {
		if ( $page === 'change_payment_method' ) {
			global $wp;
			if ( isset( $wp->query_vars['order-pay'] ) ) {
				$url = add_query_arg(
					[ 'order_id' => absint( $wp->query_vars['order-pay'] ), 'order_key' => wc_get_var( $_REQUEST['key'] ) ],
					$url
				);
			} elseif ( $gateway->get_request_context() && $gateway->get_request_context()->has_prop( 'order_id' ) ) {
				$context = $gateway->get_request_context();
				$url     = add_query_arg(
					[ 'order_id' => absint( $context->get_prop( 'order_id' ) ), 'order_key' => $context->get_prop( 'order_key' ) ],
					$url
				);
			}
		}

		return $url;
	}

	/**
	 * @param array                      $result
	 * @param \WC_Payment_Gateway_Stripe $gateway
	 * @param \Stripe\SetupIntent        $setup_intent
	 *
	 * @return void
	 */
	public function process_change_payment_method_redirect( $result, $gateway, $setup_intent ) {
		$id        = wc_get_var( $_GET['order_id'], '' );
		$order_key = wc_get_var( $_GET['order_key'], '' );
		if ( ! $id ) {
			return [
				'result'   => 'error',
				'redirect' => wc_get_page_permalink( 'myaccount' )
			];
		}
		$subscription = wc_get_order( absint( $id ) );

		if ( ! $subscription || ! $subscription->key_is_valid( $order_key ) ) {
			return [
				'result'   => 'error',
				'redirect' => wc_get_page_permalink( 'myaccount' )
			];
		}
		if ( $setup_intent->status === 'requires_payment_method' ) {
			return [
				'result'   => 'error',
				'redirect' => add_query_arg(
					[ '_wpnonce' => wp_create_nonce(), 'change_payment_method' => $subscription->get_id() ],
					$subscription->get_checkout_payment_url()
				)
			];
		} elseif ( $setup_intent->status === 'succeeded' ) {
			// update the payment method on the subscription
			\WC_Subscriptions_Change_Payment_Gateway::update_payment_method( $subscription, $gateway->id );

			if ( wc_notice_count( 'error' ) == 0 ) {
				$gateway->set_setup_intent( $setup_intent );
				$gateway->set_new_source_token( $setup_intent->payment_method->id );
				$gateway->process_subscription_payment_method_updated( $subscription );
			}
			wp_safe_redirect( $subscription->get_view_order_url() );
			exit();
		}
	}

	public function is_link_active( $bool ) {
		if ( $bool ) {
			if ( \WC_Subscriptions_Change_Payment_Gateway::$is_request_to_change_payment ) {
				$bool = false;
			}
		}

		return $bool;
	}

}