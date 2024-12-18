<?php
/**
 * @version 3.0.0
 */
defined( 'ABSPATH' ) || exit;

if ( ! wp_doing_ajax() ) {
	do_action( 'wc_stripe_product_before_payment_methods' );
}
?>
<div class="wc-stripe-clear"></div>
<div class="wc-stripe-product-checkout-container <?php echo esc_attr( $position ) ?>">
    <ul class="wc_stripe_product_payment_methods" style="list-style: none">
		<?php foreach ( $gateways as $gateway ): ?>
            <li class="payment_method_<?php echo esc_attr( $gateway->id ) ?>">
                <div class="payment-box">
					<?php $gateway->product_fields() ?>
                </div>
            </li>
		<?php endforeach; ?>
    </ul>
</div>