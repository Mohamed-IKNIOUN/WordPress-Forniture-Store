<?php

defined( 'ABSPATH' ) || exit();

/**
 * Gateway that processes ACH payments.
 * Only available for U.S. based merchants at this time.
 *
 * @since   3.0.5
 * @author  Payment Plugins
 * @package Stripe/Gateways
 *
 */
class WC_Payment_Gateway_Stripe_ACH extends WC_Payment_Gateway_Stripe_Local_Payment {

	use WC_Stripe_Payment_Intent_Trait;

	protected $payment_method_type = 'us_bank_account';

	public $synchronous = false;

	protected $supports_save_payment_method = true;

	public $token_type = 'Stripe_ACH';

	public function __construct() {
		$this->id                 = 'stripe_ach';
		$this->currencies         = array( 'USD' );
		$this->countries          = array( 'US' );
		$this->tab_title          = __( 'ACH', 'woo-stripe-payment' );
		$this->method_title       = __( 'ACH (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'ACH gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		$this->icon               = stripe_wc()->assets_url( 'img/ach.svg' );
		parent::__construct();
		$this->new_payment_method_label    = __( 'New Bank', 'woo-stripe-payment' );
		$this->saved_payment_methods_label = __( 'Saved Banks', 'woo-stripe-payment' );
	}

	public static function init() {
		add_action( 'woocommerce_checkout_update_order_review', array( __CLASS__, 'update_order_review' ) );
		add_action( 'woocommerce_checkout_process', array( __CLASS__, 'add_fees_for_checkout' ) );
	}

	public function init_supports() {
		parent::init_supports();
		$this->supports[] = 'subscriptions';
		$this->supports[] = 'subscription_cancellation';
		$this->supports[] = 'multiple_subscriptions';
		$this->supports[] = 'subscription_reactivation';
		$this->supports[] = 'subscription_suspension';
		$this->supports[] = 'subscription_date_changes';
		$this->supports[] = 'subscription_payment_method_change_admin';
		$this->supports[] = 'subscription_amount_changes';
		$this->supports[] = 'subscription_payment_method_change_customer';
		$this->supports[] = 'pre-orders';
	}

	public function get_local_payment_settings() {
		$settings = include stripe_wc()->plugin_path() . 'includes/gateways/settings/ach-settings.php';

		return $settings;
	}

	public function validate_local_payment_available( $currency, $billing_country, $total ) {
		if ( $currency !== 'USD' ) {
			return false;
		}
		if ( stripe_wc()->account_settings->get_account_country( wc_stripe_mode() ) !== 'US' ) {
			return false;
		}

		return true;
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see WC_Payment_Gateway_Stripe::enqueue_checkout_scripts()
	 */
	public function enqueue_checkout_scripts( $scripts ) {
		wp_enqueue_script( 'wc-stripe-ach-connections' );
		$scripts->localize_script( 'ach-connections', $this->get_localized_params() );
	}

	public function generate_ach_fee_html( $key, $data ) {
		$field_key = $this->get_field_key( $key );
		$defaults  = array(
			'title'             => '',
			'disabled'          => false,
			'class'             => '',
			'css'               => 'max-width: 150px; min-width: 150px;',
			'placeholder'       => '',
			'type'              => 'text',
			'desc_tip'          => false,
			'description'       => '',
			'custom_attributes' => array(),
			'options'           => array(),
		);
		$data      = wp_parse_args( $data, $defaults );
		ob_start();
		include stripe_wc()->plugin_path() . 'includes/admin/views/html-ach-fee.php';

		return ob_get_clean();
	}

	public function validate_ach_fee_field( $key, $value ) {
		$value = empty( $value ) ? array(
			'type'    => 'none',
			'taxable' => 'no',
			'value'   => '0',
		) : $value;
		if ( ! isset( $value['taxable'] ) ) {
			$value['taxable'] = 'no';
		}

		return $value;
	}

	public function fees_enabled() {
		$fee = $this->get_option(
			'fee',
			array(
				'type'  => 'none',
				'value' => '0',
			)
		);

		return ! empty( $fee ) && $fee['type'] != 'none';
	}

	/**
	 *
	 * @param WC_Cart $cart
	 */
	public function calculate_cart_fees( $cart ) {
		$this->calculate_fees( $cart );
	}

	/**
	 *
	 * @param WC_Cart $cart
	 */
	public function calculate_fees( $cart ) {
		$fee     = $this->get_option( 'fee' );
		$taxable = wc_string_to_bool( $fee['taxable'] );
		switch ( $fee['type'] ) {
			case 'amount':
				$cart->add_fee( __( 'ACH Fee', 'woo-stripe-payment' ), $fee['value'], $taxable );
				break;
			case 'percent':
				$cart_total = $cart->get_subtotal() + $cart->get_shipping_total() + $cart->get_subtotal_tax() + $cart->get_shipping_tax();
				$cart->add_fee( __( 'ACH Fee', 'woo-stripe-payment' ), $fee['value'] * $cart_total, $taxable );
				break;
		}
	}

	public static function update_order_review() {
		if ( ! empty( $_POST['payment_method'] ) && wc_clean( $_POST['payment_method'] ) === 'stripe_ach' ) {
			$payment_method = new WC_Payment_Gateway_Stripe_ACH();
			if ( $payment_method->fees_enabled() ) {
				add_action( 'woocommerce_cart_calculate_fees', array( $payment_method, 'calculate_cart_fees' ) );
			}
		}
	}

	public static function add_fees_for_checkout() {
		if ( ! empty( $_POST['payment_method'] ) && wc_clean( $_POST['payment_method'] ) === 'stripe_ach' ) {
			$payment_method = WC()->payment_gateways()->payment_gateways()['stripe_ach'];
			if ( $payment_method && $payment_method->fees_enabled() ) {
				add_action( 'woocommerce_cart_calculate_fees', array( $payment_method, 'calculate_cart_fees' ) );
			}
		}
	}

	public function has_enqueued_scripts( $scripts ) {
		return wp_script_is( $scripts->get_handle( 'ach-connections' ) );
	}

	public function add_stripe_order_args( &$args, $order, $intent = null ) {
		if ( ! $intent ) {
			$args['payment_method_options'] = array(
				'us_bank_account' => array(
					'verification_method'   => 'automatic',
					'financial_connections' => array(
						'permissions' => array( 'payment_method' ) //@todo - add balances in future release 'permissions' => array( 'payment_method', 'balances' )
					)
				)
			);
		}
		// check if this was a Plaid bank token. If so, add the mandate
		if ( strpos( $order->get_meta( WC_Stripe_Constants::PAYMENT_METHOD_TOKEN ), 'ba_' ) !== false ) {
			if ( $this->is_processing_scheduled_payment() ) {
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
		}
	}

	public function get_local_payment_description() {
		$this->local_payment_description = $this->get_mandate_text();

		return parent::get_local_payment_description();
	}

	public function get_mandate_text() {
		return apply_filters( 'wc_stripe_ach_get_mandate_text', sprintf(
			__( 'By clicking %1$s, you authorize %2$s to debit the bank 
		account you select for any amount owed for charges arising from your use of %2$s 
		services and/or purchase of products from %2$s, pursuant to %2$s 
		website and terms, until this authorization is revoked. You may amend or cancel this 
		authorization at any time by providing notice to %2$s with 30 (thirty) days notice.',
				'woo-stripe-payment' ), $this->order_button_text, $this->get_option( 'business_name' ) ), $this );
	}

	public function get_localized_params() {
		return array_merge_recursive(
			parent::get_localized_params(),
			array(
				'fees_enabled' => $this->fees_enabled()
			)
		);
	}

	public function admin_options() {
		if ( wc_string_to_bool( $this->get_option( 'plaid_enabled', 'no' ) ) ) {
			$description                              = '<p>' . sprintf( __( 'The %1$sPlaid ACH%2$s gateway has been deprecated. If you still want to use the Plaid gateway, you can download it %1$shere%2$s.', 'woo-stripe-payment' ),
					'<a target="_blank" href="https://github.com/paymentplugins/paymentplugins-plaid-gateway/releases">', '</a>' ) . '</p>';
			$this->form_fields['desc']['description'] = $this->form_fields['desc']['description'] . $description;
		}
		parent::admin_options();
	}

	public function get_payment_element_options() {
		return array(
			'terms'    => array(
				'usBankAccount' => $this->is_active( 'stripe_mandate' ) ? 'auto' : 'never'
			),
			'business' => array(
				'name' => $this->get_option( 'business_name', '' )
			)
		);
	}

	protected function requires_confirmation_mandate( $intent ) {
		if ( $intent && $intent->status === 'requires_confirmation' ) {
			return true;
		}

		return false;
	}

}

WC_Payment_Gateway_Stripe_ACH::init();
