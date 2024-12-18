<?php

defined( 'ABSPATH' ) || exit();

/**
 * Class that manages customer creation and custom updates.
 *
 * @since   3.0.0
 * @package Stripe/Classes
 * @author  PaymentPlugins
 *
 */
class WC_Stripe_Customer_Manager {

	private static $_instance;

	public static function instance() {
		if ( ! self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		add_action( 'woocommerce_checkout_update_customer', array( $this, 'checkout_update_customer' ), 10, 2 );
		add_action( 'wp_loaded', array( $this, 'wp_loaded' ) );
		add_action( 'wc_stripe_before_process_payment', array( $this, 'handle_before_process_payment' ), 10, 2 );
	}

	/**
	 * Returns true if the plugin should create a Stripe customer if the user has an account
	 * with the store
	 *
	 * @since 3.3.38
	 * @return bool
	 */
	public function should_create_when_account_exists() {
		return stripe_wc()->advanced_settings->get_option( 'customer_creation' ) === 'account_creation';
	}

	/**
	 * Returns true if the plugin should create a Stripe customer when the payment is being processed.
	 *
	 * @since 3.3.38
	 * @return bool
	 */
	public function should_create_when_payment() {
		return stripe_wc()->advanced_settings->get_option( 'customer_creation' ) === 'payment';
	}

	/**
	 *
	 * @param WC_Customer $customer
	 * @param array       $data
	 */
	public function checkout_update_customer( $customer, $data ) {
		if ( $this->user_has_id( $customer ) ) {
			if ( $this->should_update_customer( $customer ) ) {
				$result = $this->update_customer( $customer );
				if ( is_wp_error( $result ) ) {
					// add info to log. This error isn't added to wc_add_notice because we don't want a user update to
					// interfere with payment being processed.
					wc_stripe_log_error( sprintf( __( 'Error saving customer. Reason: %s', 'woo-stripe-payment' ), $result->get_error_message() ) );
				}
			}
		}
	}

	/**
	 *
	 * @param WC_Customer $customer
	 *
	 * @return \Stripe\Customer|WP_Error
	 */
	public function create_customer( $customer, $mode = null ) {
		return WC_Stripe_Gateway::load( $mode )->customers->create( apply_filters( 'wc_stripe_customer_args', $this->get_customer_args( $customer ) ) );
	}

	/**
	 *
	 * @param WC_Customer $customer
	 */
	public function update_customer( $customer ) {
		return WC_Stripe_Gateway::load()->customers->update(
			wc_stripe_get_customer_id( $customer->get_id() ),
			apply_filters( 'wc_stripe_update_customer_args', $this->get_customer_args( $customer, 'update' ) )
		);
	}

	/**
	 * Check if the Stripe customer has been created for the WC user.
	 * If there is no Stripe customer then
	 * create one and save it to the WC user.
	 */
	public function wp_loaded() {
		$customer = WC()->customer;
		if ( $customer && $customer->get_id() ) {
			if ( ! $this->user_has_id( $customer ) ) {
				if ( $this->should_create_when_account_exists() ) {
					if ( WC()->session ) {
						$customer_id = WC()->session->get( WC_Stripe_Constants::STRIPE_CUSTOMER_ID );
						if ( $customer_id ) {
							// customer ID is no longer needed since it's being added to the user.
							unset( WC()->session->{WC_Stripe_Constants::STRIPE_CUSTOMER_ID} );

							return wc_stripe_save_customer( $customer_id, $customer->get_id() );
						}
					}
					$response = $this->create_customer( $customer );
					if ( ! is_wp_error( $response ) ) {
						wc_stripe_save_customer( $response->id, $customer->get_id() );
					}
				}
			}
		}
	}

	/**
	 *
	 * @param mixed $customer
	 */
	private function user_has_id( $customer ) {
		if ( $customer instanceof \WC_Customer ) {
			$user_id = $customer->get_id();
		} else {
			$user_id = $customer;
		}
		$id = wc_stripe_get_customer_id( $user_id );

		// this customer may have an ID from another plugin. Check that too.
		if ( empty( $id ) ) {
			$id = $this->get_customer_id_from_user_id( $user_id );
			if ( $id ) {
				// validate that this customer exists in the Stripe gateway
				$response = WC_Stripe_Gateway::load()->customers->retrieve( $id );
				if ( ! is_wp_error( $response ) ) {
					// id exists so save customer ID to this plugin's format.
					wc_stripe_save_customer( $id, $user_id );

					// load this customer's payment methods
					$this->sync_payment_methods( $id, $user_id );
				} else {
					$id = '';
				}
			}
		}

		return ! empty( $id );
	}

	private function get_customer_id_from_user_id( $user_id ) {
		$keys = [ WC_Stripe_Constants::STRIPE_CUSTOMER_ID, '_fkwcs_customer_id' ];
		foreach ( $keys as $key ) {
			$id = get_user_option( $key, $user_id );
			if ( $id && ! empty( $id ) && is_string( $id ) ) {
				return $id;
			}
		}

		return null;
	}

	/**
	 * Syncs the WC database payment methods with the payment methods stored in Stripe.
	 *
	 * @param string $customer_id
	 * @param int    $user_id
	 *
	 * @since 3.1.0
	 */
	public static function sync_payment_methods( $customer_id, $user_id, $mode = '' ) {
		$payment_methods = WC_Stripe_Gateway::load()->paymentMethods->mode( $mode )->all( array(
			'customer' => $customer_id,
			'limit'    => 100,
		) );
		if ( ! is_wp_error( $payment_methods ) ) {
			$payment_gateways = wc_stripe_get_payment_gateways();
			foreach ( $payment_methods->data as $payment_method ) {
				/**
				 * @var \Stripe\PaymentMethod $payment_method
				 */
				if ( $payment_method->type === 'card' ) {
					$gateway_id = 'stripe_cc';
					if ( isset( $payment_method->card->wallet->type ) ) {
						switch ( $payment_method->card->wallet->type ) {
							case 'google_pay':
								$gateway_id = 'stripe_googlepay';
								break;
							case 'apple_pay':
								$gateway_id = 'stripe_applepay';
								break;
						}
					}
				} else {
					$gateway_id = null;
					foreach ( $payment_gateways as $gateway ) {
						if ( method_exists( $gateway, 'get_payment_method_type' ) ) {
							if ( $gateway->get_payment_method_type() === $payment_method->type ) {
								$gateway_id = $gateway->id;
								break;
							}
						}
					}
				}

				if ( $gateway_id ) {
					/**
					 *
					 * @var WC_Payment_Gateway_Stripe_CC $payment_gateway
					 */
					$payment_gateway = $payment_gateways[ $gateway_id ] ?? null;

					if ( $payment_gateway && ! \PaymentPlugins\Stripe\Utilities\PaymentMethodUtils::token_exists( $payment_method->id, $user_id, $payment_gateway ) ) {
						$token = $payment_gateway->get_payment_token( $payment_method->id, $payment_method );
						$token->set_environment( $payment_method->livemode ? 'live' : 'test' );
						$token->set_user_id( $user_id );
						$token->set_customer_id( $customer_id );
						$token->save();
					}
				}
			}
		} else {
			wc_stripe_log_info( sprintf( 'Payment methods for customer %s could not be synced. Reason: %s', $customer_id, $payment_methods->get_error_message() ) );
		}
	}

	/**
	 * Returns true if the customer should be updated in Stripe.
	 *
	 * @param WC_Customer $customer
	 *
	 * @return bool
	 */
	private function should_update_customer( $customer ) {
		$changes = $customer->get_changes();
		if ( ! empty( $changes['billing'] ) ) {
			return array_intersect_key( $changes['billing'], array_flip( $this->get_attribute_keys() ) );
		}

		return false;
	}

	/**
	 * Returns an array of user attributes.
	 *
	 * @return array
	 */
	private function get_attribute_keys() {
		return apply_filters( 'wc_stripe_get_customer_attribute_keys', array(
			'first_name',
			'last_name',
			'email',
			'address_1',
			'address_2',
			'country',
			'state',
			'postcode'
		) );
	}

	/**
	 * Return an array of args used to create or update a customer.
	 *
	 * @param WC_Customer $customer
	 * @param string      $context
	 *
	 * @since 3.2.12
	 * @return array
	 */
	private function get_customer_args( $customer, $context = 'create' ) {
		$args = array(
			'email'   => $customer->get_email(),
			'name'    => sprintf( '%s %s', $customer->get_first_name(), $customer->get_last_name() ),
			'phone'   => $customer->get_billing_phone(),
			'address' => array(
				'city'        => $customer->get_billing_city(),
				'country'     => $customer->get_billing_country(),
				'line1'       => $customer->get_billing_address_1(),
				'line2'       => $customer->get_billing_address_2(),
				'postal_code' => $customer->get_billing_postcode(),
				'state'       => $customer->get_billing_state()
			)
		);
		if ( 'create' === $context ) {
			$args['metadata'] = array(
				'user_id'  => $customer->get_id(),
				'username' => $customer->get_username(),
				'website'  => get_site_url(),
			);
		}

		return $args;
	}

	private function get_customer_args_from_order( \WC_Order $order ) {
		return apply_filters( 'wc_stripe_customer_order_args', array(
			'email'    => $order->get_billing_email(),
			'name'     => sprintf( '%1$s %2$s', $order->get_billing_first_name(), $order->get_billing_last_name() ),
			'phone'    => $order->get_billing_phone(),
			'address'  => array(
				'city'        => $order->get_billing_city(),
				'country'     => $order->get_billing_country(),
				'line1'       => $order->get_billing_address_1(),
				'line2'       => $order->get_billing_address_2(),
				'postal_code' => $order->get_billing_postcode(),
				'state'       => $order->get_billing_state()
			),
			'metadata' => array(
				'website' => get_site_url(),
			)
		) );
	}

	/**
	 * @param \WC_Order $order
	 * @param string    $gateway_id
	 *
	 * @return void
	 */
	public function handle_before_process_payment( $order, $gateway_id ) {
		if ( $order->get_customer_id() > 0 ) {
			// user exists. check if they have a Stripe customer ID
			if ( ! $this->user_has_id( $order->get_customer_id() ) ) {
				if ( WC()->session ) {
					$customer_id = WC()->session->get( WC_Stripe_Constants::STRIPE_CUSTOMER_ID );
					if ( $customer_id ) {
						// customer ID is no longer needed since it's being added to the user.
						unset( WC()->session->{WC_Stripe_Constants::STRIPE_CUSTOMER_ID} );

						return wc_stripe_save_customer( $customer_id, $order->get_customer_id() );
					}
				}
				$customer = new WC_Customer( $order->get_customer_id() );
				$response = $this->create_customer( $customer );
				if ( ! is_wp_error( $response ) ) {
					wc_stripe_save_customer( $response->id, $customer->get_id() );
				} else {
					wc_add_notice( sprintf( __( 'Error saving customer. Reason: %s', 'woo-stripe-payment' ), $response->get_error_message() ), 'error' );
				}
			}
		} elseif ( wc_string_to_bool( stripe_wc()->advanced_settings->get_option( 'guest_customer', 'no' ) ) ) {
			$customer_id = $order->get_meta( WC_Stripe_Constants::CUSTOMER_ID );
			if ( ! $customer_id ) {
				// create a Stripe customer ID for the guest user.
				$payment_method = WC()->payment_gateways()->payment_gateways()[ $gateway_id ];
				$response       = $payment_method->gateway->mode( $order )->customers->create( $this->get_customer_args_from_order( $order ) );
				if ( ! is_wp_error( $response ) ) {
					$order->update_meta_data( WC_Stripe_Constants::CUSTOMER_ID, $response->id );
					$order->save();
				} else {
					// fail silently. The customer creation failure should not prevent payment for a guest user.
					wc_stripe_log_error( sprintf( 'Error creating customer ID for guest. Reason: %s', $response->get_error_message() ) );
				}
			}
		}
	}

}

WC_Stripe_Customer_Manager::instance();
