<?php

namespace PaymentPlugins\PayPalSDK\Service;

use PaymentPlugins\PayPalSDK\Collection;
use PaymentPlugins\PayPalSDK\Utils;

class PaymentTokenServiceV3 extends BaseService {

	protected $path = 'v3/vault';

	/**
	 * @param array $params customer_id
	 * @param array $options
	 *
	 * @return mixed|object|void
	 */
	public function all( $params = [], $options = [] ) {
		return $this->get( $this->buildPath( '/payment-tokens' ), \stdClass::class, $params, $options );
	}

}