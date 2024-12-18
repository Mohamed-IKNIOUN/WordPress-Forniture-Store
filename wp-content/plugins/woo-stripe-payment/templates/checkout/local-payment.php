<?php
/**
 * @var WC_Payment_Gateway_Stripe_Local_Payment $gateway
 * @version 3.1.7
 *
 */

?>
    <div id="wc_stripe_local_payment_<?php echo esc_attr( $gateway->id ) ?>" data-active="<?php echo esc_attr( $gateway->is_local_payment_available() ) ?>">

    </div>
<?php if ( ( $desc = $gateway->get_local_payment_description() ) ): ?>
    <p class="wc-stripe-local-desc <?php echo esc_attr( $gateway->id ) ?>">
		<?php echo $desc //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped?>
    </p>
<?php endif; ?>
<?php if ( $gateway->show_save_payment_method_html() ): ?>
	<?php wc_stripe_get_template( 'save-payment-method.php', array( 'gateway' => $gateway ) ) ?>
<?php endif; ?>