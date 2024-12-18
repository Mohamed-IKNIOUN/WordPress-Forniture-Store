<?php

namespace PaymentPlugins\Stripe\Utilities;

class PaymentMethodUtils {

	/**
	 * Sort the payment tokens by the default.
	 *
	 * @param $tokens
	 *
	 * @return mixed
	 */
	public static function sort_by_default( $tokens ) {
		if ( \is_array( $tokens ) ) {
			usort( $tokens, function ( $a ) {
				if ( \is_object( $a ) && method_exists( $a, 'is_default' ) ) {
					return $a->is_default() ? - 1 : 1;
				}

				return - 1;
			} );
		}

		return $tokens;
	}

	/**
	 * @param $tokens
	 *
	 * @since 3.3.51
	 * @return array|mixed
	 */
	public static function filter_by_type( $tokens ) {
		if ( \is_array( $tokens ) ) {
			return \array_filter( $tokens, function ( $token ) {
				return $token instanceof \WC_Payment_Token_Stripe;
			} );
		}

		return $tokens;
	}

	/**
	 * @param                            $token_id
	 * @param                            $user_id
	 * @param \WC_Payment_Gateway_Stripe $gateway
	 *
	 * @since 3.3.51
	 * @return bool
	 */
	public static function token_exists( $token_id, $user_id, $gateway = null ) {
		global $wpdb;
		$where = [
			$wpdb->prepare( 'token = %s', $token_id ),
			$wpdb->prepare( 'user_id = %d', $user_id )
		];
		if ( $gateway ) {
			$where[] = $wpdb->prepare( 'gateway_id = %s', $gateway->id );
			if ( method_exists( $gateway, 'get_payment_token_type' ) ) {
				$where[] = $wpdb->prepare( 'type = %s', $gateway->get_payment_token_type() );
			}
		} else {
			$where[] = $wpdb->prepare( 'gateway_id LIKE %s', '%stripe_%' );
		}

		$where_clause = ' WHERE ' . implode( ' AND ', $where );

		$count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}woocommerce_payment_tokens {$where_clause}" );

		return absint( $count ) > 0;
	}

	public static function get_payment_token( $token_id, $user_id, $gateway = null ) {
		global $wpdb;
		$where = [
			$wpdb->prepare( 'token = %s', $token_id ),
			$wpdb->prepare( 'user_id = %d', $user_id )
		];
		if ( $gateway ) {
			$where[] = $wpdb->prepare( 'gateway_id = %s', $gateway->id );
			if ( method_exists( $gateway, 'get_payment_token_type' ) ) {
				$where[] = $wpdb->prepare( 'type = %s', $gateway->get_payment_token_type() );
			}
		} else {
			// if gateway isn't specified, make sure duplicate tokens from other plugins won't be included in this request.
			$where[] = $wpdb->prepare( 'gateway_id like %s', '%stripe_%' );
		}

		$where_clause = ' WHERE ' . implode( ' AND ', $where );

		$result = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}woocommerce_payment_tokens {$where_clause}" );

		if ( $result ) {
			return \WC_Payment_Tokens::get( $result->token_id, $result );
		}

		return null;
	}

	public static function get_gateway_id_from_token( $token ) {
		global $wpdb;

		$result = $wpdb->get_row(
			$wpdb->prepare( "SELECT gateway_id FROM {$wpdb->prefix}woocommerce_payment_tokens WHERE token = %s", $token )
		);

		return $result ? $result->gateway_id : null;
	}


	public static function get_active_bnpl_gateways() {
		$payment_gateways = WC()->payment_gateways()->payment_gateways();
		$upm              = $payment_gateways['stripe_upm'] ?? null;
		$gateways[]       = $payment_gateways['stripe_affirm'] ?? false;
		$gateways[]       = $payment_gateways['stripe_afterpay'] ?? false;
		$gateways[]       = $payment_gateways['stripe_klarna'] ?? false;
		if ( ! $upm ) {
			return [];
		}

		return array_reduce( $gateways, function ( $carry, $gateway ) use ( $upm ) {
			$include = $gateway !== false
			           && ( wc_string_to_bool( $gateway->enabled )
			                || ( wc_string_to_bool( $upm->enabled ) && $upm->is_enabled_payment_method( $gateway->id ) )
			           );
			if ( $include ) {
				$carry[ $gateway->id ] = $gateway;
			}

			return $carry;
		}, [] );
	}

	/**
	 * Returns a url that can be used to handle redirect based payment methods.
	 *
	 * @param $gateway_id
	 * @param $page
	 *
	 * @since 3.3.61
	 * @return string
	 */
	public static function create_return_url( $gateway, $page ) {
		$url = add_query_arg( [
			'nonce'          => wp_create_nonce( $gateway->id ),
			'payment_method' => $gateway->id,
			'context'        => $page
		], WC()->api_request_url( 'stripe_add_payment_method' ) );

		return apply_filters( 'wc_stripe_create_payment_method_return_url', $url, $gateway, $page );
	}

}