<script type="text/template" id="tmpl-wc-stripe-modal-payment-config">
    <div class="wc-backbone-modal">
        <div class="wc-backbone-modal-content">
            <section class="wc-backbone-modal-main" role="main">
                <header class="wc-backbone-modal-header">
                    <h1><?php esc_html_e( 'Create Payment Configuration', 'woo-stripe-payment' ); ?></h1>
                    <button
                            class="modal-close modal-close-link dashicons dashicons-no-alt">
                        <span class="screen-reader-text">Close modal panel</span>
                    </button>
                </header>
                <article>
                    <form id="wc-stripe-pay-order-form">
                        <input type="hidden" name="customer_id" value="{{{data.customer_id}}}"/>
                        <input type="hidden" name="order_id" value="{{{data.order_id}}}"/>
                        <div class="modal-wide option">
                            <label><?php esc_html_e( 'Configuration Name', 'woo-stripe-payment' ); ?></label>
                            <input type="text" id="payment_config_name" name="payment_config_name" class="input-text regular-input" value="<?php echo esc_attr( $name ) ?>" style="width: 100%"/>
                        </div>
                    </form>
                </article>
                <footer>
                    <div class="inner">
                        <button id="create-payment-config" class="button button-primary button-large"><?php esc_html_e( 'Create', 'woo-stripe-payment' ); ?></button>
                    </div>
                </footer>
            </section>
        </div>
    </div>
    <div class="wc-backbone-modal-backdrop modal-close"></div>
</script>