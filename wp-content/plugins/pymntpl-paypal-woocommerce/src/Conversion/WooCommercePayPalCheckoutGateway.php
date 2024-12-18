<?php

namespace PaymentPlugins\WooCommerce\PPCP\Conversion;

use PaymentPlugins\WooCommerce\PPCP\Constants;

/**
 * https://wordpress.org/plugins/woocommerce-gateway-paypal-express-checkout/
 */
class WooCommercePayPalCheckoutGateway extends GeneralPayPalPlugin {

	public $id = 'ppec_paypal';

	protected $payment_token_id = '_ppec_billing_agreement_id';

	/**
	 * @param array     $payment_meta
	 * @param \WC_Order $subscription
	 */
	public function add_subscription_payment_meta( $payment_meta, $subscription ) {
		if ( isset( $payment_meta['ppcp'] ) ) {
			if ( $this->is_plugin ) {
				if ( empty( $payment_meta['ppcp']['post_meta'][ Constants::BILLING_AGREEMENT_ID ]['value'] ) ) {
					$id = $subscription->get_meta( $this->payment_token_id );
					if ( $id ) {
						$payment_meta['ppcp']['post_meta'][ Constants::BILLING_AGREEMENT_ID ]['value'] = $id;
					}
				}
			}
		}

		return $payment_meta;
	}

	/**
	 * @param \WC_Subscription $subscription
	 *
	 * @return void
	 */
	public function update_subscription_meta( \WC_Subscription $subscription ) {
		if ( $this->payment_source ) {
			if ( $this->payment_source->getToken() ) {
				$subscription->update_meta_data( Constants::BILLING_AGREEMENT_ID, $this->payment_source->getToken()->getId() );
				$subscription->save();
			}
		}
	}

}