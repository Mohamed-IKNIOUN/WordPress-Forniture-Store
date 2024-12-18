<?php

defined( 'ABSPATH' ) || exit();

/**
 *
 * @since   3.1.0
 * @author  Payment Plugins
 * @package Stripe/Trait
 */
trait WC_Stripe_Payment_Intent_Trait {

	public $has_parent_gateway = false;

	public function get_payment_object() {
		return WC_Stripe_Payment_Factory::load( 'payment_intent', $this, WC_Stripe_Gateway::load() );
	}

	public function get_payment_method_type() {
		return $this->payment_method_type;
	}

	/**
	 *
	 * @param WC_Order $order
	 */
	public function get_confirmation_method( $order = null ) {
		return 'automatic';
	}

	/**
	 *
	 * @param \Stripe\PaymentIntent $intent
	 * @param WC_Order              $order
	 */
	public function get_payment_intent_checkout_url( $intent, $order, $type = 'payment_intent' ) {
		return sprintf(
			'#response=%s',
			rawurlencode(
				base64_encode(
					wp_json_encode( $this->get_payment_intent_checkout_params( $intent, $order, $type ) )
				)
			)
		);
	}

	/**
	 * @param          $intent
	 * @param WC_Order $order
	 * @param          $type
	 *
	 * @return array
	 */
	protected function get_payment_intent_checkout_params( $intent, $order, $type ) {
		$billing_details = array(
			'name'    => sprintf( '%s %s', $order->get_billing_first_name(), $order->get_billing_last_name() ),
			'phone'   => $order->get_billing_phone(),
			'email'   => $order->get_billing_email(),
			'address' => array(
				'city'        => $order->get_billing_city(),
				'country'     => $order->get_billing_country(),
				'line1'       => $order->get_billing_address_1(),
				'line2'       => $order->get_billing_address_2(),
				'postal_code' => $order->get_billing_postcode(),
				'state'       => $order->get_billing_state()
			)
		);

		/*$billing_details            = array_filter( $billing_details );
		$billing_details['address'] = array_filter( $billing_details['address'] );*/

		$billing_details            = array_map( function ( $value ) {
			return empty( $value ) ? null : $value;
		}, $billing_details );
		$billing_details['address'] = array_map( function ( $value ) {
			return empty( $value ) ? null : $value;
		}, $billing_details['address'] );

		$args = array(
			'pm'                 => $intent->payment_method,
			'type'               => $type,
			'client_secret'      => $intent->client_secret,
			'status'             => $intent->status,
			'gateway_id'         => $this->id,
			'order_id'           => $order->get_id(),
			'order_key'          => $order->get_order_key(),
			'return_url'         => $this->get_complete_payment_return_url( $order ),
			'order_received_url' => $this->get_return_url( $order ),
			'confirmation_args'  => $this->get_payment_intent_confirmation_args( $intent, $order ),
			'billing_details'    => $billing_details,
			'entropy'            => rand(
				0,
				999999
			),
		);
		global $wp;

		if ( ! empty( $wp->query_vars['order-pay'] ) ) {
			$args['save_method'] = ! empty( $_POST[ $this->save_source_key ] );
		}

		return $args;
	}

	/**
	 * @param \Stripe\PaymentIntent $intent
	 * @param WC_Order              $order
	 */
	public function get_payment_intent_confirmation_args( $intent, $order ) {
		$args = array(
			'return_url' => $this->get_complete_payment_return_url( $order )
		);

		if ( $this->requires_confirmation_mandate( $intent ) || ( isset( $intent['setup_future_usage'] ) && $intent['setup_future_usage'] === 'off_session' ) ) {
			$this->add_payment_intent_mandate_args( $args, $order );
		}

		return $args;
	}

	public function get_setup_intent_checkout_params( $intent, $order ) {
		return array();
	}

	protected function requires_confirmation_mandate( $intent ) {
		return false;
	}

	protected function add_payment_intent_mandate_args( &$args, $order ) {
		$ip_address = $order->get_customer_ip_address();
		$user_agent = $order->get_customer_user_agent();
		if ( ! $ip_address ) {
			$ip_address = WC_Geolocation::get_external_ip_address();
		}
		if ( ! $user_agent ) {
			$user_agent = 'WordPress/' . get_bloginfo( 'version' ) . '; ' . get_bloginfo( 'url' );
		}

		$args['mandate_data'] = array(
			'customer_acceptance' => array(
				'type'   => 'online',
				'online' => array(
					'ip_address' => $ip_address,
					'user_agent' => $user_agent
				)
			)
		);
	}

	/**
	 * @param WC_Order $order
	 *
	 * @return array|void
	 */
	public function handle_setup_intent_for_order( $order ) {
		if ( defined( WC_Stripe_Constants::PROCESSING_PAYMENT ) || defined( WC_Stripe_Constants::REDIRECT_HANDLER ) ) {
			if ( $this->is_mandate_required( $order ) ) {
				$setup_intent = $this->gateway->setupIntents->retrieve( $order->get_meta( WC_Stripe_Constants::SETUP_INTENT_ID ) );
				if ( ! empty( $setup_intent->mandate ) ) {
					$order->update_meta_data( WC_Stripe_Constants::STRIPE_MANDATE, $setup_intent->mandate );
				}
				$this->payment_method_token = $setup_intent->payment_method;
			} else {
				$result = $this->save_payment_method( $this->get_new_source_token(), $order );
				if ( is_wp_error( $result ) ) {
					wc_add_notice( $result->get_error_message(), 'error' );

					return $this->get_order_error();
				}
			}
			$order->delete_meta_data( WC_Stripe_Constants::SETUP_INTENT_ID );
		} else {
			$setup_intent        = $this->get_payment_intent_id();
			$save_payment_method = $this->should_save_payment_method( $order );
			// if setup intent exists then it was created client side.
			// attempt to save the payment method
			if ( $setup_intent && ( $save_payment_method || $this->is_mandate_required( $order ) ) ) {
				$payment_method_details = null;
				if ( $this->is_mandate_required( $order ) ) {
					// if a mandate was required, the payment method has already been attached.
					$setup_intent_obj       = $this->gateway->setupIntents->retrieve( $setup_intent, array( 'expand' => array( 'payment_method' ) ) );
					$payment_method_details = $setup_intent_obj->payment_method;
					$order->update_meta_data( WC_Stripe_Constants::STRIPE_MANDATE, $setup_intent_obj->mandate );
				}
				$result = $this->save_payment_method( $this->get_new_source_token(), $order, $payment_method_details );
				if ( is_wp_error( $result ) ) {
					wc_add_notice( $result->get_error_message(), 'error' );

					return $this->get_order_error();
				}
			} elseif ( ! $setup_intent && $save_payment_method ) {
				// A new payment method is being used but there's no setup intent provided
				// by client. Create one here
				$result = $this->does_order_require_action( $order, $this->get_new_source_token() );
				if ( is_wp_error( $result ) ) {
					wc_add_notice( sprintf( __( 'Error processing payment. Reason: %s', 'woo-stripe-payment' ), $result->get_error_message() ), 'error' );

					return $this->get_order_error();
				} elseif ( $result ) {
					return $result;
				} else {
					$this->save_payment_method( $this->get_new_source_token(), $order );
				}
			} else {
				$this->payment_method_token = $this->get_saved_source_id();
				if ( $this->is_mandate_required( $order ) ) {
					// update the setup-intent with the saved payment method info
					$order->update_meta_data( WC_Stripe_Constants::SETUP_INTENT_ID, WC()->session->get( WC_Stripe_Constants::SETUP_INTENT_ID ) );

					return $this->does_order_require_action( $order, $this->payment_method_token );
				}
			}
		}
	}

	/**
	 * @param WC_Order $order
	 *
	 * @return array|void
	 */
	public function process_zero_total_order( $order ) {
		$result = $this->handle_setup_intent_for_order( $order );
		if ( $result && isset( $result['result'] ) ) {
			return $result;
		}

		return $this->payment_object->process_zero_total_order( $order, $this );
	}

	/**
	 * @param \WC_Order $order
	 */
	public function process_pre_order( $order ) {
		$token        = null;
		$setup_intent = $this->get_payment_intent_id();
		if ( defined( WC_Stripe_Constants::PROCESSING_PAYMENT ) ) {
			$token = $this->create_payment_method( $this->get_new_source_token(), $order->get_meta( WC_Stripe_Constants::CUSTOMER_ID ) );
		} else {
			if ( ! $this->use_saved_source() ) {
				if ( ! $order->get_customer_id() ) {
					$customer = WC_Stripe_Customer_Manager::instance()->create_customer( WC()->customer );
					if ( is_wp_error( $customer ) ) {
						return wc_add_notice( $customer->get_error_message(), 'error' );
					}
					$order->update_meta_data( WC_Stripe_Constants::CUSTOMER_ID, $customer->id );
				} else {
					$order->update_meta_data( WC_Stripe_Constants::CUSTOMER_ID, wc_stripe_get_customer_id( $order->get_customer_id() ) );
				}
				$order->save();
				if ( ! $setup_intent ) {
					$result = $this->does_order_require_action( $order, $this->get_new_source_token() );
					if ( $result ) {
						if ( is_wp_error( $result ) ) {
							wc_add_notice( $result->get_error_message(), 'error' );
							$result = $this->get_order_error();
						}

						return $result;
					}
				}
				$token = $this->create_payment_method( $this->get_new_source_token(), $order->get_meta( WC_Stripe_Constants::CUSTOMER_ID ) );
			} else {
				$this->payment_method_token = $this->get_saved_source_id();
			}
		}
		if ( is_wp_error( $token ) ) {
			return wc_add_notice( $token->get_error_message(), 'error' );
		}
		WC_Pre_Orders_Order::mark_order_as_pre_ordered( $order );
		$this->save_zero_total_meta( $order, $token );
		$this->payment_object->destroy_session_data();

		return array(
			'result'   => 'success',
			'redirect' => $this->get_return_url( $order ),
		);
	}

	/**
	 * @param WC_Order $order
	 * @param string   $payment_method
	 *
	 * @return array
	 */
	private function does_order_require_action( $order, $payment_method ) {
		if ( ( $intent_id = $order->get_meta( WC_Stripe_Constants::SETUP_INTENT_ID ) ) ) {
			$params = array_filter( array(
				'payment_method'       => $payment_method,
				'payment_method_types' => [ $this->get_payment_method_type() ]
			) );
			$intent = $this->gateway->setupIntents->update( $intent_id, apply_filters( 'wc_stripe_update_setup_intent_params', $params, $order ) );
		} else {
			$params = array(
				'confirm'              => false,
				'usage'                => 'off_session',
				'metadata'             => array(
					'gateway_id' => $this->id,
					'order_id'   => $order->get_id()
				),
				'payment_method_types' => [ $this->get_payment_method_type() ]
			);
			if ( $payment_method ) {
				$params['payment_method'] = $payment_method;
				$params['confirm']        = true;
			}
			$this->add_stripe_order_args( $params, $order );
			$intent = $this->payment_object->get_gateway()->setupIntents->create( apply_filters( 'wc_stripe_setup_intent_params', $params, $order, $this ) );
		}
		if ( is_wp_error( $intent ) ) {
			return $intent;
		}
		$order->update_meta_data( WC_Stripe_Constants::SETUP_INTENT_ID, $intent->id );
		if ( ! empty( $intent->mandate ) ) {
			$order->update_meta_data( WC_Stripe_Constants::STRIPE_MANDATE, $intent->mandate );
		}
		$order->save();

		if ( in_array( $intent->status, array(
			'requires_action',
			'requires_payment_method',
			'requires_source_action',
			'requires_source',
			'requires_confirmation'
		), true )
		) {
			return array(
				'result'   => 'success',
				'redirect' => $this->get_payment_intent_checkout_url( $intent, $order, 'setup_intent' ),
			);
		} elseif ( $intent->status === 'succeeded' ) {
			$this->payment_method_token = $intent->payment_method;
			// The setup intent ID is no longer needed so remove it from the order
			$order->delete_meta_data( WC_Stripe_Constants::SETUP_INTENT_ID );

			return false;
		}
	}

	/**
	 * @since 3.3.32
	 * @return false
	 */
	public function is_deferred_intent_creation() {
		return false;
	}

	public function process_server_side_confirmation( $intent, $order ) {
		if ( in_array( $this->get_payment_method_type(), [ 'blik', 'boleto' ] ) ) {
			if ( doing_action( 'woocommerce_rest_checkout_process_payment_with_context' ) ) {
				return false;
			}
			! $this->has_parent_gateway;
		}

		return true;
	}

}

/**
 *
 * @since   3.1.0
 * @author  Payment Plugins
 * @package Stripe/Trait
 */
trait WC_Stripe_Payment_Charge_Trait {

	public function get_payment_object() {
		return WC_Stripe_Payment_Factory::load( 'charge', $this, WC_Stripe_Gateway::load() );
	}

}

/**
 *
 * @since   3.1.0
 * @author  Payment Plugins
 * @package Stripe/Trait
 */
trait WC_Stripe_Local_Payment_Charge_Trait {

	public function get_payment_object() {
		return WC_Stripe_Payment_Factory::load( 'local_charge', $this, WC_Stripe_Gateway::load() );
	}

}

/**
 *
 * @since   3.1.0
 * @author  Payment Plugins
 * @package Stripe/Trait
 *
 */
trait WC_Stripe_Local_Payment_Intent_Trait {

	use WC_Stripe_Payment_Intent_Trait;

	public function get_setup_intent_checkout_params( $setup_intent, $order ) {
		return $this->get_payment_intent_checkout_params( $setup_intent, $order, 'setup_intent' );
	}

}

trait WC_Stripe_Voucher_Payment_Trait {

	/**
	 * @param \WC_Order $order
	 */
	public function process_voucher_order_status( $order ) {
		if ( $this->is_active( 'email_link' ) ) {
			add_filter( 'woocommerce_email_additional_content_customer_on_hold_order', array( $this, 'add_customer_voucher_email_content' ), 10, 2 );
		}
		$order->update_status( 'on-hold' );
	}

	/**
	 * @param string    $content
	 * @param \WC_Order $order
	 */
	public function add_customer_voucher_email_content( $content, $order ) {
		if ( $order && $order->get_payment_method() === $this->id ) {
			if ( ( $intent_id = $order->get_meta( WC_Stripe_Constants::PAYMENT_INTENT_ID ) ) ) {
				$payment_intent = $this->gateway->mode( $order )->paymentIntents->retrieve( $intent_id );
				if ( ! is_wp_error( $payment_intent ) ) {
					$voucher_property_name = $this->payment_method_type . '_display_details';
					$link                  = isset( $payment_intent->next_action->{$voucher_property_name}->hosted_voucher_url ) ? $payment_intent->next_action->{$voucher_property_name}->hosted_voucher_url : null;
					if ( $link ) {
						$content .= '<p>' . sprintf( __( 'Please click %shere%s to view your %s voucher.', 'woo-stripe-payment' ), '<a href="' . $link . '" target="_blank">', '</a>', $this->get_title() ) . '</p>';
					}
				}
			}
		}

		return $content;
	}

}

trait WC_Stripe_Express_Payment_Trait {

	public function get_element_options( $options = array() ) {
		$options = array( 'locale' => wc_stripe_get_site_locale() );

		return apply_filters( 'wc_stripe_get_element_options', $options, $this );
	}

}