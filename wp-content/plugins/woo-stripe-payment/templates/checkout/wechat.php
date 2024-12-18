<?php
defined( 'ABSPATH' ) || exit;

?>
<div id="wc_stripe_local_payment_<?php echo esc_attr( $gateway->id ) ?>" data-active="<?php echo esc_attr( $gateway->is_local_payment_available() ) ?>">
    <ol class="stripe-wechat-instructions">
        <li><?php echo esc_html( sprintf( __( 'Click %1$s to initiate the WeChat payment.', 'woo-stripe-payment' ), $gateway->order_button_text ) ) ?></li>
        <li><?php esc_html_e( 'A QR code will render on this page.', 'woo-stripe-payment' ) ?></li>
        <li><?php esc_html_e( 'Scan the QR code and authenticate the payment using your WeChat Pay app', 'woo-stripe-payment' ) ?></li>
        <li><?php esc_html_e( 'After you authenticate, stay on this page until it redirects to the order received page.', 'woo-stripe-payment' ) ?></li>
    </ol>
</div>
