<?php
/**
 *
 */
?>
<?php if ( $gateway->is_active( 'notice_enabled' ) ): ?>
    <div class="wc-stripe-wallet-notice">
        <img class="wc-stripe-wallet-notice--mark" src="<?php echo $gateway->icon ?>"/>
        <p class="wc-stripe-wallet-notice--selected-gateway"><?php printf( esc_html__( '%s selected', 'woo-stripe-payment' ), $gateway->get_title() ) ?></p>
        <div class="wc-stripe-wallet-notice--divider"></div>
        <p class="wc-stripe-wallet-notice--text">
            <img class="wc-stripe-wallet-notice--icon" src="<?php echo esc_url( stripe_wc()->assets_url( 'img/wallet_popup.svg' ) ) ?>"/>
			<?php echo sprintf( esc_html__( 'Click the "%1$s" button to submit your payment information and complete your order.', 'woo-stripe-payment' ), $gateway->get_title() ) ?>
        </p>
    </div>
<?php endif; ?>
