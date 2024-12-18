<?php
/**
 * @version 3.0.0
 */
?>
<input type="radio" class="wc-stripe-payment-type" checked="checked" id="<?php echo esc_attr( $gateway->id ) ?>_use_saved" name="<?php echo esc_attr( $gateway->payment_type_key ) ?>" value="saved"/>
<label for="<?php echo esc_attr( $gateway->id ) ?>_use_saved" class="wc-stripe-label-payment-type"><?php echo esc_html( $gateway->get_saved_methods_label() ) ?></label>
<div class="wc-stripe-saved-methods-container wc-<?php echo esc_attr( $gateway->id ) ?>-saved-methods-container">
    <select class="wc-stripe-saved-methods" id="<?php echo esc_attr( $gateway->saved_method_key ) ?>" name="<?php echo esc_attr( $gateway->saved_method_key ) ?>">
		<?php foreach ( $tokens as $token ): ?>
            <option class="wc-stripe-saved-method <?php echo esc_attr( $token->get_html_classes() ) ?>" value="<?php echo esc_attr( $token->get_token() ) ?>"
                    data-gateway="<?php echo esc_attr( $token->get_gateway_id() ) ?>"><?php echo esc_html( $token->get_payment_method_title( $gateway->get_option( 'method_format' ) ) ) ?></option>
		<?php endforeach; ?>
    </select>
</div>