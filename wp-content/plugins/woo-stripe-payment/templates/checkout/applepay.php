<?php
/**
 * @var WC_Payment_Gateway_Stripe $gateway
 * @version 3.3.70
 *
 */
?>
<div id="wc-stripe-applepay-container">
	<?php wc_stripe_get_template( 'wallet-notice.php', array( 'gateway' => $gateway ) ); ?>
</div>