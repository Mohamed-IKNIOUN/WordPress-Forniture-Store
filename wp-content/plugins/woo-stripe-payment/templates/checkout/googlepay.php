<?php
/**
 * @var WC_Payment_Gateway_Stripe $gateway
 * @version 3.1.6
 */
?>
<div id="wc-stripe-googlepay-container">
	<?php wc_stripe_get_template( 'wallet-notice.php', array( 'gateway' => $gateway ) ); ?>
</div>