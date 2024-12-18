<?php

defined( 'ABSPATH' ) || exit();

class WC_Payment_Gateway_Stripe_UPM extends WC_Payment_Gateway_Stripe {

	use WC_Stripe_Payment_Intent_Trait;

	protected $payment_method_type = null;

	/**
	 * @var \WC_Payment_Gateway_Stripe
	 */
	private $child_payment_gateway;

	private $excluded_payment_methods = [ 'stripe_applepay', 'stripe_googlepay', 'stripe_payment_request', 'paypal', 'apple_pay', 'google_pay', 'customer_balance' ];

	public $installments;

	protected $supports_save_payment_method = true;

	public function __construct() {
		$this->id                 = 'stripe_upm';
		$this->tab_title          = __( 'Universal Payment Method', 'woo-stripe-payment' );
		$this->template_name      = 'universal-payment-method.php';
		$this->token_type         = 'Stripe_CC';
		$this->method_title       = __( 'Universal Payment Methods (Stripe) By Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'Stripe payment method that lets you combine all payment methods into a single integration.', 'woo-stripe-payment' );
		$this->installments       = \PaymentPlugins\Stripe\Installments\InstallmentController::instance();
		parent::__construct();
	}

	public function hooks() {
		parent::hooks();
		add_action( 'wc_stripe_account_settings_saved', array( $this, 'handle_connection_success' ), 10, 2 );
	}

	public function payment_fields() {
		parent::payment_fields();
		wc_stripe_hidden_field( WC_Stripe_Constants::STRIPE_PAYMENT_METHOD_TYPE );
	}

	/**
	 * @param $order_id
	 *
	 * @return array|string[]
	 * @throws \Exception
	 */
	public function process_payment( $order_id ) {
		if ( $this->use_saved_source() ) {
			$this->set_child_payment_gateway(
				$this->get_child_payment_gateway_from_token( $this->get_saved_source_id() )
			);
		} else {
			$this->payment_method_type = $this->get_payment_method_type_from_request();
			if ( $this->payment_method_type ) {
				if ( in_array( $this->payment_method_type, $this->excluded_payment_methods ) ) {
					throw new \Exception( sprintf( __( '%s is an unsupported payment method. Please remove it from your payment method configuration.', 'woo-stripe-payment' ), ucfirst( $this->payment_method_type ) ) );
				}
				$this->set_child_payment_gateway(
					$this->get_payment_gateway_from_type( $this->payment_method_type )
				);
			}
		}

		if ( $this->child_payment_gateway ) {
			$this->child_payment_gateway->has_parent_gateway = true;
			$this->child_payment_gateway->set_new_source_token( $this->get_new_source_token() );
			$this->child_payment_gateway->set_payment_method_token( $this->get_saved_source_id() );
			$_POST[ $this->child_payment_gateway->payment_intent_key ] = wc_get_var( $_POST[ $this->payment_intent_key ], '' );
			$_POST[ $this->child_payment_gateway->payment_type_key ]   = wc_get_var( $_POST[ $this->payment_type_key ], '' );
			$_POST[ $this->child_payment_gateway->save_source_key ]    = wc_get_var( $_POST[ $this->save_source_key ], '' );

			return $this->child_payment_gateway->process_payment( $order_id );
		}

		return parent::process_payment( $order_id );
	}

	public function add_payment_method() {
		$payment_method_type = isset( $_REQUEST[ WC_Stripe_Constants::STRIPE_PAYMENT_METHOD_TYPE ] ) ? wc_clean( $_REQUEST[ WC_Stripe_Constants::STRIPE_PAYMENT_METHOD_TYPE ] ) : null;
		if ( ! $payment_method_type ) {
			throw new Exception( __( 'Payment method type is required', 'woo-stripe-payment' ) );
		}
		$child_gateway = $this->get_payment_gateway_from_type( $payment_method_type );
		if ( $child_gateway ) {
			$child_gateway->set_new_source_token( $this->get_new_source_token() );
			$child_gateway->set_setup_intent( $this->get_setup_intent() );

			return $child_gateway->add_payment_method();
		}

		return parent::add_payment_method();
	}

	public function is_installment_available() {
		$order_id = null;
		if ( is_checkout_pay_page() ) {
			global $wp;
			$order_id = absint( $wp->query_vars['order-pay'] );
		}

		return $this->installments->is_available( $order_id );
	}

	public function get_tokens() {
		if ( count( $this->tokens ) > 0 ) {
			return $this->tokens;
		}

		if ( is_user_logged_in() && $this->supports( 'tokenization' ) ) {
			$this->tokens = WC_Payment_Tokens::get_customer_tokens( get_current_user_id() );
		}

		return $this->tokens;
	}

	/**
	 * @param \WC_Stripe_Frontend_Scripts $scripts
	 *
	 * @return void
	 */
	public function enqueue_checkout_scripts( $scripts ) {
		$scripts->assets_api->register_script(
			'wc-stripe-upm-checkout',
			'assets/build/universal-payment-method.js',
			[ 'wc-stripe-vendors' ]
		);
		wp_enqueue_script( 'wc-stripe-upm-checkout' );
		// localize the script parameters
		$scripts->localize_script( 'wc-stripe-upm-checkout', $this->get_localized_params() );
	}

	public function get_localized_params() {
		$data = array(
			'paymentElementOptions' => array(
				'layout' => array(
					'type' => $this->get_option( 'layout_type', 'tabs' )
				)
			),
			'installments'          => array(
				'loading' => __( 'Loading installments...', 'woo-stripe-payment' )
			)
		);
		if ( $this->get_option( 'layout_type' ) === 'accordion' ) {
			$data['paymentElementOptions']['layout']['radios']               = wc_string_to_bool( $this->get_option( 'layout_radios', 'no' ) );
			$data['paymentElementOptions']['layout']['spacedAccordionItems'] = wc_string_to_bool( $this->get_option( 'spaced_items', 'no' ) );
		}

		return array_merge( parent::get_localized_params(), $data );
	}

	public function get_element_options( $options = array() ) {
		$payment_method_config = $this->get_payment_method_configuration();
		if ( $payment_method_config ) {
			$options['paymentMethodConfiguration'] = $payment_method_config;
		}
		$options['appearance'] = array(
			'theme' => $this->get_option( 'theme', 'stripe' )
		);

		return parent::get_element_options( $options ); // TODO: Change the autogenerated stub
	}

	/**
	 * Returns a list of all payment methods that have been enabled
	 *
	 * @return array
	 */
	public function get_enabled_payment_methods( $mode = null ) {
		if ( ! $mode ) {
			$mode = wc_stripe_mode();
		}

		return $this->get_option( "{$mode}_payment_methods", array() );
	}

	public function set_payment_method_configuration( $id, $mode ) {
		$this->settings["{$mode}_payment_method_configuration"] = $id;
	}

	public function update_available_payment_methods( $value, $mode ) {
		$this->update_option( "{$mode}_payment_methods", $value );
	}

	public function update_payment_method_configuration( $id, $mode ) {
		$this->update_option( "{$mode}_payment_method_configuration", $id );
	}

	public function is_enabled_payment_method( $name ) {
		$payment_methods = $this->get_enabled_payment_methods();

		return is_array( $payment_methods )
		       && isset( $payment_methods[ $name ]['enabled'] )
		       && $payment_methods[ $name ]['enabled'] === true;
	}

	public function get_supported_payment_methods() {
		return array_filter( WC()->payment_gateways()->payment_gateways(), function ( $gateway ) {
			return $gateway instanceof WC_Payment_Gateway_Stripe
			       && ! in_array( $gateway->id, $this->excluded_payment_methods )
			       && $gateway->payment_object instanceof WC_Stripe_Payment_Intent
			       && $gateway->id !== $this->id;
		} );
	}

	protected function is_supported_payment_method( $payment_method ) {
		return array_key_exists( $payment_method->id, $this->get_supported_payment_methods() );
	}

	public function get_payment_method_type_from_request() {
		return isset( $_POST[ WC_Stripe_Constants::STRIPE_PAYMENT_METHOD_TYPE ] ) ? wc_clean( $_POST[ WC_Stripe_Constants::STRIPE_PAYMENT_METHOD_TYPE ] ) : null;
	}

	public function get_payment_gateway_from_type( $type ) {
		foreach ( $this->get_supported_payment_methods() as $gateway ) {
			if ( $type === $gateway->get_payment_method_type() ) {
				return $gateway;
			}
		}

		return null;
	}

	public function get_confirmation_method( $order = null ) {
		return WC_Stripe_Constants::AUTOMATIC;
	}

	/**
	 * @param                            $method_id
	 * @param \Stripe\PaymentMethod|null $method_details
	 *
	 * @return void|\WC_Payment_Token_Stripe
	 */
	public function get_payment_token( $method_id, $method_details = null ) {
		if ( $method_details ) {
			$gateway = $this->get_child_payment_gateway( $method_details->type );

			if ( ! $gateway ) {
				$this->token_type = 'Stripe_Local';
				$token            = parent::get_payment_token( $method_id, $method_details );
				$token->set_format( 'gateway_title' );
				$token->set_gateway_title( implode( ' ', array_map( 'ucfirst', explode( '_', $method_details['type'] ) ) ) );
				$token->set_brand( $token->get_gateway_title() );

				return $token;
			}

			return $gateway->get_payment_token( $method_id, $method_details );
		} else {
			// fetch the payment method and use those details.
			$payment_method = $this->gateway->paymentMethods->retrieve( $method_id );

			return $this->get_payment_token( $method_id, $payment_method );
		}
	}

	public function set_child_payment_gateway( $gateway ) {
		$this->child_payment_gateway = $gateway;
	}

	/**
	 * @param string|WC_Order $mixed
	 *
	 * @return \WC_Payment_Gateway_Stripe
	 */
	public function get_child_payment_gateway( $mixed = null ) {
		if ( ! $this->child_payment_gateway && $mixed ) {
			if ( $mixed instanceof WC_Order ) {
				$gateway = WC()->payment_gateways()->payment_gateways()[ $mixed->get_meta( WC_Stripe_Constants::STRIPE_UPE_PAYMENT_METHOD ) ];
			} else {
				$gateway = $this->get_payment_gateway_from_type( $mixed );
			}
			$this->set_child_payment_gateway( $gateway );
		}

		return $this->child_payment_gateway;
	}

	/**
	 * @param \WC_Order $order
	 *
	 * @return void
	 */
	protected function get_child_payment_gateway_from_token( $token ) {
		$gateway_id = \PaymentPlugins\Stripe\Utilities\PaymentMethodUtils::get_gateway_id_from_token( $token );
		if ( ! $gateway_id ) {
			throw new \Exception( __( 'Invalid payment method token. Please try again.', 'woo-stripe-payment' ) );
		}
		if ( $gateway_id === $this->id ) {
			return null;
		}

		return WC()->payment_gateways()->payment_gateways()[ $gateway_id ];
	}

	/*public function generate_multiselect_html( $key, $data ) {
		if ( $key === 'icons' ) {
			$data['options'] = array_reduce( $this->get_supported_payment_methods(), function ( $carry, $payment_method ) {
				$carry[ $payment_method->id ] = $payment_method->get_title();

				return $carry;
			}, array() );
		}

		return parent::generate_multiselect_html( $key, $data );
	}*/

	public function generate_payment_methods_html( $key, $data ) {
		$payment_methods = $this->get_supported_payment_methods();
		ksort( $payment_methods );
		$field_key    = $this->get_field_key( $key );
		$value        = $this->get_option( $key, array() );
		$unintegrated = array_filter( $value, function ( $key ) use ( $payment_methods ) {
			return ! isset( $payment_methods[ $key ] );
		}, ARRAY_FILTER_USE_KEY );
		$defaults     = array(
			'title'             => '',
			'disabled'          => false,
			'class'             => '',
			'css'               => '',
			'placeholder'       => '',
			'type'              => 'text',
			'desc_tip'          => false,
			'description'       => '',
			'custom_attributes' => array()
		);
		$data         = wp_parse_args( $data, $defaults );
		$cards        = $payment_methods['stripe_cc'];
		unset( $payment_methods['stripe_cc'] );
		ob_start();
		?>
        <tr valign="top">
            <th scope="row" class="titledesc"><label
                        for="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post( $data['title'] ); ?><?php echo $this->get_tooltip_html( $data ); // WPCS: XSS ok. ?></label>
            </th>
            <td class="forminp">
                <fieldset>
                    <div class="stripe-upm-payment-methods-description">
                        <p class="description">
							<?php esc_html_e( 'The following list of payment methods are supported by the UPM integration. Payment methods that are
							disabled are not supported by your Stripe account. Stripe will dynamically render these enabled payment methods based on inputs like the cart currency, amount, and customer location.', 'woo-stripe-payment' ) ?>
                        </p>
                        <p class="description">
							<?php esc_html_e( 'Payment method settings are still maintained on their respective settings page.', 'woo-stripe-payment' ) ?>
                        </p>
                    </div>
                    <div class="stripe-upm-payment-methods-container stripe_cc">
						<?php
						$supported = isset( $value[ $cards->id ] ) && true === $value[ $cards->id ]['supported'];
						$checked   = isset( $value[ $cards->id ] ) && true === $value[ $cards->id ]['enabled'];
						?>
                        <div class="stripe-upm-payment-method <?php echo $supported ? 'supported-method' : 'unsupported-method' ?>">
                            <div class="stripe-upm-checkbox-container">
                                <input <?php disabled( $supported, false ); ?>
                                        class="<?php echo esc_attr( $data['class'] ); ?>" type="checkbox" name="<?php echo esc_attr( $field_key ); ?>[]"
                                        id="<?php echo esc_attr( $field_key ); ?>" style="<?php echo esc_attr( $data['css'] ); ?>"
                                        value="<?php echo $cards->id ?>" <?php checked( $checked, true ) ?>"/>
								<?php echo $this->get_custom_attribute_html( $data ); // WPCS: XSS ok. ?>
                            </div>
                            <div class="stripe-upm-label-container">
                                <label><a href="<?php echo admin_url( 'admin.php?page=wc-settings&tab=checkout&section=' . $cards->id ) ?>" target="_blank"><?php echo $cards->get_title() ?></a></label>
                            </div>
                        </div>
                    </div>
                    <div class="stripe-upm-divider"></div>
                    <div class="stripe-upm-payment-methods-container">
						<?php foreach ( $payment_methods as $payment_method ): ?>
							<?php
							$supported = true === ( $value[ $payment_method->id ]['supported'] ?? false );
							$checked   = true === ( $value[ $payment_method->id ]['enabled'] ?? false );
							?>
                            <div class="stripe-upm-payment-method <?php echo esc_attr( $payment_method->id ) ?> <?php echo $supported ? 'supported-method' : 'unsupported-method' ?>">
                                <div class="stripe-upm-checkbox-container">
                                    <input <?php disabled( $supported, false ); ?>
                                            class="<?php echo esc_attr( $data['class'] ); ?>" type="checkbox" name="<?php echo esc_attr( $field_key ); ?>[]"
                                            id="<?php echo esc_attr( $field_key ); ?>" style="<?php echo esc_attr( $data['css'] ); ?>"
                                            value="<?php echo $payment_method->id ?>" <?php checked( $checked, true ) ?>"/>
									<?php echo $this->get_custom_attribute_html( $data ); // WPCS: XSS ok. ?>
                                </div>
                                <div class="stripe-upm-label-container">
                                    <label><a href="<?php echo admin_url( 'admin.php?page=wc-settings&tab=checkout&section=' . $payment_method->id ) ?>" target="_blank"><?php echo $payment_method->get_title() ?></a></label>
                                </div>
                            </div>
						<?php endforeach; ?>
                        <div class="stripe-upm-divider"></div>
						<?php foreach ( $unintegrated as $key => $value ): ?>
							<?php
							$supported = true === ( $value['supported'] ?? false );
							$checked   = true === ( $value['enabled'] ?? false );
							$title     = explode( '_', $key );
							?>
                            <div class="stripe-upm-payment-method <?php echo esc_attr( $key ) ?> <?php echo $supported ? 'supported-method' : 'unsupported-method' ?>">
                                <div class="stripe-upm-checkbox-container">
                                    <input <?php disabled( $supported, false ); ?>
                                            class="<?php echo esc_attr( $data['class'] ); ?>" type="checkbox" name="<?php echo esc_attr( $field_key ); ?>[]"
                                            id="<?php echo esc_attr( $field_key ); ?>" style="<?php echo esc_attr( $data['css'] ); ?>"
                                            value="<?php echo esc_attr( $key ) ?>" <?php checked( $checked, true ) ?>"/>
									<?php echo $this->get_custom_attribute_html( $data ); // WPCS: XSS ok. ?>
                                </div>
                                <div class="stripe-upm-label-container">
                                    <label><?php echo esc_attr( implode( ' ', array_map( 'ucfirst', $title ) ) ) ?></label>
                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
					<?php echo $this->get_description_html( $data ); // WPCS: XSS ok. ?>
                </fieldset>
            </td>
        </tr>
		<?php
		return ob_get_clean();
	}

	/*public function get_icon() {
		$payment_icons   = $this->get_option( 'icons', array() );
		$payment_methods = $this->get_supported_payment_methods();
		$result          = array();
		foreach ( $payment_icons as $id ) {
			if ( isset( $payment_methods[ $id ] ) ) {
				$payment_method = $payment_methods[ $id ];
				$icon_url       = stripe_wc()->assets_url( "img/upm/{$payment_method->id}.svg" );
				$icon           = $icon_url ? '<img src="' . WC_HTTPS::force_https_url( $icon_url ) . '"/>' : '';
				$result[]       = array(
					'icon' => $icon
				);
			}
		}

		return wc_stripe_get_template_html( 'upm-payment-icons.php', array(
			'icons'      => $result,
			'assets_url' => stripe_wc()->assets_url(),
			'gateway'    => $this
		) );
	}*/

	public function is_deferred_intent_creation() {
		return true;
	}

	public function map_payment_config_to_payment_methods( \Stripe\PaymentMethodConfiguration $config ) {
		$payment_methods         = array();
		$supported_payment_types = array();
		// loop through options and turn on/off payment methods
		foreach ( $this->get_supported_payment_methods() as $gateway ) {
			$payment_methods[ $gateway->id ] = array(
				'supported' => false,
				'enabled'   => false
			);
			if ( isset( $config->{$gateway->get_payment_method_type()} ) ) {
				// if payment type key exists on the payment method configuration object,
				// that means it's supported.
				$supported_payment_types[]                    = $gateway->get_payment_method_type();
				$payment_methods[ $gateway->id ]['supported'] = true;
				if ( $config->{$gateway->get_payment_method_type()}->display_preference->value === 'on' ) {
					$payment_methods[ $gateway->id ]['enabled'] = true;
				}
			}
		}

		$diff = array_diff_key( $config->toArray(), array_flip( $supported_payment_types ) );

		if ( ! empty( $diff ) ) {
			foreach ( $diff as $key => $value ) {
				if ( ! in_array( $key, $this->excluded_payment_methods, true ) && is_array( $value ) ) {
					$payment_methods[ $key ] = array(
						'supported' => true,
						'enabled'   => $value['display_preference']['value'] === 'on'
					);
				}
			}
		}

		return $payment_methods;
	}

	public function get_new_method_label() {
		return __( 'New Payment Method', 'woo-stripe-payment' );
	}

	public function get_saved_methods_label() {
		return __( 'Saved Payment Methods', 'woo-stripe-payment' );
	}

	public function get_payment_method_configuration( $mode = null ) {
		$mode = ! $mode ? wc_stripe_mode() : $mode;

		return $this->get_option( "{$mode}_payment_method_configuration", '' );
	}

	/**
	 * @param \WC_Stripe_Account_Settings $account_settings
	 * @param \Stripe\Account             $account
	 * @param string                      $mode
	 *
	 * @return void
	 * @throws \Stripe\Exception\ApiErrorException
	 */
	public function handle_connection_success( $account_settings, $mode ) {
		if ( stripe_wc()->api_settings->has_secret_key( $mode ) ) {
			$payment_method_config = $this->get_payment_method_configuration( $mode );
			if ( $payment_method_config ) {
				$response = $this->gateway->mode( $mode )->paymentMethodConfigurations->retrieve( $payment_method_config );
				if ( is_wp_error( $response ) ) {
					$payment_method_config = null;
				}
			}
			if ( ! $payment_method_config ) {
				try {
					// load the payment method config
					$response = $this->gateway->mode( $mode )->paymentMethodConfigurations->all();
					if ( ! is_wp_error( $response ) && is_array( $response->data ) ) {
						foreach ( $response->data as $config ) {
							if ( $config->is_default ) {
								// save the option
								$this->update_payment_method_configuration( $config->id, $mode );
								$this->update_available_payment_methods(
									$this->map_payment_config_to_payment_methods( $config ),
									$mode
								);
								break;
							}
						}
					}
				} catch ( \Exception $e ) {
					wc_stripe_log_error( $e->getMessage() );
				}
			}
		}
	}

	protected function get_payment_method_configuration_list( $mode ) {
		if ( ! stripe_wc()->api_settings->has_secret_key( $mode ) ) {
			return array(
				'' => __( 'Please connect to Stripe before configuring', 'woo-stripe-payment' )
			);
		}
		$response = $this->gateway->mode( $mode )->paymentMethodConfigurations->all();
		if ( is_wp_error( $response ) ) {
			return array(
				'' => __( 'Error fetching payment method configurations.', 'woo-stripe-payment' )
			);
		}

		return array_reduce( $response->data, function ( $carry, $item ) {
			return array_merge( $carry, array( $item->id => sprintf( '%1$s - %2$s', $item->name, $item->id ) ) );
		}, array() );
	}

	public function generate_payment_config_select_html( $key, $data ) {
		$field_key = $this->get_field_key( $key );
		$defaults  = array(
			'title'             => '',
			'disabled'          => false,
			'class'             => '',
			'css'               => '',
			'placeholder'       => '',
			'type'              => 'text',
			'desc_tip'          => false,
			'description'       => '',
			'custom_attributes' => array(),
			'options'           => array(),
		);

		$data  = wp_parse_args( $data, $defaults );
		$parts = explode( '_', $key );
		$value = $this->get_option( $key );
		if ( ! $value ) {
			$data['options'] = array_merge( $data['options'], $this->get_payment_method_configuration_list( $parts[0] ) );
		} else {
			$data['options'] = $this->get_payment_method_configuration_list( $parts[0] );
		}

		ob_start();
		?>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post( $data['title'] ); ?><?php echo $this->get_tooltip_html( $data ); // WPCS: XSS ok. ?></label>
            </th>
            <td class="forminp">
                <fieldset>
                    <legend class="screen-reader-text"><span><?php echo wp_kses_post( $data['title'] ); ?></span></legend>
                    <select class="select <?php echo esc_attr( $data['class'] ); ?>" name="<?php echo esc_attr( $field_key ); ?>" id="<?php echo esc_attr( $field_key ); ?>" style="<?php echo esc_attr( $data['css'] ); ?>" <?php disabled( $data['disabled'],
						true ); ?> <?php echo $this->get_custom_attribute_html( $data ); // WPCS: XSS ok. ?>>
						<?php foreach ( (array) $data['options'] as $option_key => $option_value ) : ?>
							<?php if ( is_array( $option_value ) ) : ?>
                                <optgroup label="<?php echo esc_attr( $option_key ); ?>">
									<?php foreach ( $option_value as $option_key_inner => $option_value_inner ) : ?>
                                        <option value="<?php echo esc_attr( $option_key_inner ); ?>" <?php selected( (string) $option_key_inner, esc_attr( $value ) ); ?>><?php echo esc_html( $option_value_inner ); ?></option>
									<?php endforeach; ?>
                                </optgroup>
							<?php else : ?>
                                <option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( (string) $option_key, esc_attr( $value ) ); ?>><?php echo esc_html( $option_value ); ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
                    </select>
                    <button class="button-secondary add-new-payment-config"><?php esc_html_e( 'Add New', 'woo-stripe-payment' ) ?></button>
                    <button class="button-secondary refresh-payment-config">
                        <span class="dashicons dashicons-update"></span>
						<?php esc_html_e( 'Sync', 'woo-stripe-payment' ) ?>
                    </button>
					<?php echo $this->get_description_html( $data ); // WPCS: XSS ok. ?>
                </fieldset>
            </td>
        </tr>
		<?php

		return ob_get_clean();
	}

	public function admin_options() {
		if ( ! stripe_wc()->api_settings->has_secret_key( wc_stripe_mode() ) ) {
			$this->add_error( sprintf(
				__( 'Please %1$sconnect your Stripe account%2$s to %3$s mode before configuring the Universal Payment Method.', 'woo-stripe-payment' ),
				'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=stripe_api' ) . '">',
				'</a>',
				wc_stripe_test_mode() ? __( 'test', 'woo-stripe-payment' ) : __( 'live', 'woo-stripe-payment' )
			) );
			$this->output_settings_nav();
			$this->display_errors();

			return;
		}
		$mode   = wc_stripe_mode();
		$unset  = 'live_payment_method_configuration';
		$unset2 = 'live_payment_methods';
		if ( $mode === 'live' ) {
			$unset  = 'test_payment_method_configuration';
			$unset2 = 'test_payment_methods';
		}
		unset( $this->form_fields[ $unset ], $this->form_fields[ $unset2 ] );
		if ( ( $id = $this->get_payment_method_configuration( $mode ) ) ) {
			$this->form_fields["{$mode}_payment_method_configuration"]['description'] = sprintf(
				__( '%1$s Payment Method Configuration: %2$s' ),
				'<span class="dashicons dashicons-yes delete-payment-method-config"></span>',
				sprintf( '<a href="https://dashboard.stripe.com/%1$ssettings/payment_methods?config_id=%2$s" target="_blank">' . $id . '</a>', $mode === 'test' ? 'test/' : '', $id )
			);
		}

		parent::admin_options();

		$name = sprintf( 'Payment Plugins (%s)', $_SERVER['SERVER_NAME'] );
		include stripe_wc()->plugin_path() . 'includes/admin/views/html-payment-config-modal.php';
	}

	public function validate_payment_methods_field( $key, $values ) {
		$mode              = substr( $key, 0, strlen( $key ) - strlen( '_payment_methods' ) );
		$payment_config_id = $this->get_payment_method_configuration( $mode );
		$values            = is_array( $values ) ? array_map( 'wc_clean', array_map( 'stripslashes', $values ) ) : array();
		if ( ! $payment_config_id ) {
			return array();
		}

		$payment_methods = $this->get_enabled_payment_methods( wc_stripe_mode() );

		foreach ( $payment_methods as $key => $value ) {
			if ( isset( $payment_methods[ $key ] ) ) {
				$payment_methods[ $key ]['enabled'] = in_array( $key, $values, true );
			}
		}

		if ( wc_stripe_mode() === $mode ) {
			if ( stripe_wc()->api_settings->has_secret_key( $mode ) ) {
				$payment_config_id         = $this->get_payment_method_configuration( $mode );
				$supported_payment_methods = $this->get_supported_payment_methods();
				$params                    = [];
				foreach ( $payment_methods as $key => $value ) {
					if ( $payment_methods[ $key ]['supported'] ) {
						$payment_method_type            = isset( $supported_payment_methods[ $key ] ) ? $supported_payment_methods[ $key ]->get_payment_method_type() : $key;
						$params[ $payment_method_type ] = [
							'display_preference' => [
								'preference' => $payment_methods[ $key ]['enabled'] ? 'on' : 'off'
							]
						];
					}
				}
				if ( $payment_config_id ) {
					$response = $this->gateway->paymentMethodConfigurations->update( $payment_config_id, $params );
					if ( ! is_wp_error( $response ) ) {
						$this->update_option( "{$mode}_payment_method_configuration", $response->id );
					} else {
						throw new \Exception( sprintf( __( 'Error saving payment method configuration in Stripe. Reason: %s', 'woo-stripe-payment' ), $response->get_error_message() ) );
					}
				}
			}
		} else {
			$payment_methods = $this->get_option( $key );
		}

		return $payment_methods;
	}

	public function payment_methods_list_item( $item, $payment_token ) {
		if ( $payment_token->get_gateway_id() === $this->id || $this->is_enabled_payment_method( $payment_token->get_gateway_id() ) ) {
			if ( method_exists( $payment_token, 'get_last4' ) ) {
				$item['method']['last4'] = $payment_token->get_last4();
			} else {
				$item['method']['last4'] = substr( $payment_token->get_token(), - 4 );
			}
			$item['method']['brand'] = ucfirst( $payment_token->get_brand() );
			if ( $payment_token->has_expiration() ) {
				$item['expires'] = sprintf( '%s / %s', $payment_token->get_exp_month(), $payment_token->get_exp_year() );
			} else {
				$item['expires'] = __( 'n/a', 'woo-stripe-payment' );
			}
			$item['wc_stripe_method'] = true;
		}

		return $item;
	}

	public function get_token( $token_id, $user_id ) {
		return \PaymentPlugins\Stripe\Utilities\PaymentMethodUtils::get_payment_token( $token_id, $user_id );
	}

	public function add_stripe_order_args( &$args, $order, $intent = null ) {
		if ( ! $this->payment_method_type ) {
			unset( $args['payment_method_types'], $args['confirmation_method'] );
			$args['payment_method_configuration'] = $this->get_payment_method_configuration( wc_stripe_order_mode( $order ) );
			if ( ! $intent ) {
				$args['automatic_payment_methods'] = array( 'enabled' => true );
			}
		}
	}

	public function get_payment_method_charge_type() {
		if ( $this->child_payment_gateway ) {
			return $this->child_payment_gateway->get_payment_method_charge_type();
		}

		return parent::get_payment_method_charge_type();
	}

	public function get_order_status_option() {
		if ( $this->child_payment_gateway ) {
			return $this->child_payment_gateway->get_order_status_option();
		}

		return $this->get_option( 'order_status', 'default' );
	}

}