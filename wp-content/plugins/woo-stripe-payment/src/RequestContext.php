<?php

namespace PaymentPlugins\Stripe;

class RequestContext {

	const CART = 'cart';

	const CHECKOUT = 'checkout';

	const ORDER_PAY = 'order_pay';

	const ADD_PAYMENT_METHOD = 'add_payment_method';

	const PRODUCT = 'product';

	const SHOP = 'shop';

	private $context;

	private $props = [];

	public function __construct( $context = '' ) {
		$this->context = $context;
		if ( ! $this->context ) {
			$this->initialize();
		}
	}

	public function initialize() {
		if ( is_cart() ) {
			$this->context = 'cart';
		} elseif ( is_checkout() ) {
			if ( is_checkout_pay_page() ) {
				$this->context = self::ORDER_PAY;
			} else {
				$this->context = self::CHECKOUT;
			}
		} elseif ( is_add_payment_method_page() ) {
			$this->context = self::ADD_PAYMENT_METHOD;
		} elseif ( is_product() ) {
			$this->context = self::PRODUCT;
		} elseif ( is_shop() ) {
			$this->context = self::SHOP;
		}
	}

	public function set_prop( $key, $value ) {
		$this->props[ $key ] = $value;
	}

	public function has_prop( $key ) {
		return array_key_exists( $key, $this->props );
	}

	public function set_props( $props ) {
		foreach ( $props as $key => $value ) {
			$this->set_prop( $key, $value );
		}
	}

	public function get_prop( $key ) {
		if ( $this->has_prop( $key ) ) {
			return $this->props[ $key ];
		}

		return null;
	}

	public function get_context() {
		return $this->context;
	}

	public function is_cart() {
		return $this->context === self::CART;
	}

	public function is_checkout() {
		return $this->context === self::CHECKOUT;
	}

	public function is_order_pay() {
		return $this->context === self::ORDER_PAY;
	}

	public function is_product() {
		return $this->context === self::PRODUCT;
	}

	public function is_shop() {
		return $this->context === self::SHOP;
	}

	public function is_add_payment_method() {
		return $this->context === self::ADD_PAYMENT_METHOD;
	}

}