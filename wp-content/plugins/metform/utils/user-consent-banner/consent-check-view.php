
<style>
	.metform-user-consent-for-banner{
		margin: 0 0 15px 0!important;
        width: 842px;
		max-width: 1350px;
	}
	.metform-success-notice {
		position: fixed;
		top: 50px;
		right: 20px;
		background-color: #14c87c;
		color: white;
		padding: 10px;
		border-radius: 5px;
		display: none;
	}

</style>
<script>
	jQuery(document).ready(function ($) {
		"use strict";
		$('#metform-admin-switch__metform-user-consent-for-banner').on('change', function(){
			let val = ($(this).prop("checked") ? $(this).val() : 'no');
			let data = {
				'settings' : {
					'metform_user_consent_for_banner' : val, 
				}, 
				'nonce': "<?php echo esc_html(wp_create_nonce( 'ajax-nonce' )); ?>"
			};

			$.post( ajaxurl + '?action=metform_admin_action', data, function( data ) {
				$('#success-notice').fadeIn().delay(1000).slideUp(); 
            });
		});
	}); // end ready function
</script>


<div id="success-notice" class="metform-success-notice">Success! Your action was completed.</div>
<div class="metform-user-consent-for-banner notice notice-error">
	<p>
		<input type="checkbox" <?php echo ( \MetForm\Utils\Util::get_settings( 'metform_user_consent_for_banner', 'yes' ) == 'yes' ? 'checked' : '' ); ?>  value="yes" class="metform-admin-control-input" name="metform-user-consent-for-banner" id="metform-admin-switch__metform-user-consent-for-banner">
		<label for="metform-admin-switch__metform-user-consent-for-banner"><?php esc_html_e( 'Show update & fix related important messages, essential tutorials and promotional images on WP Dashboard', 'metform' ); ?></label>

	</p>
</div>

