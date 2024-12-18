<?php

/**
 * @var WC_Payment_Gateway_Stripe_Klarna $gateway
 * @version 3.3.55
 *
 */
?>
<div id="wc_stripe_local_payment_<?php echo esc_attr( $gateway->id ) ?>" data-active="<?php echo esc_attr( $gateway->is_local_payment_available() ) ?>">
	<?php wc_stripe_get_template( 'offsite-notice.php', array( 'text' => $gateway->order_button_text, 'title' => $gateway->get_title() ) ) ?>
</div>