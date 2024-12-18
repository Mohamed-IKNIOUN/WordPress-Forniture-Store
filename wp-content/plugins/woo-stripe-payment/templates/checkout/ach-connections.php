<?php
/**
 * @var \WC_Payment_Gateway_Stripe_ACH $gateway
 */

?>
<div id="wc-stripe-ach-container">
    <div id="wc-stripe-ach-element"></div>
	<?php if ( ! $gateway->is_active( 'stripe_mandate' ) ): ?>
        <p class="wc-stripe-ach__mandate">
			<?php echo esc_html( $gateway->get_mandate_text() ) ?>
        </p>
	<?php endif; ?>
	<?php if ( $gateway->show_save_payment_method_html() ): ?>
		<?php wc_stripe_get_template( 'save-payment-method.php', array( 'gateway' => $gateway ) ) ?>
	<?php endif; ?>
</div>
