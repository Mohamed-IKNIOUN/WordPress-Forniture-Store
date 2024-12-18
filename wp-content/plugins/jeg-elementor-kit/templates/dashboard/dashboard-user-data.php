<?php
/**
 * Dashboard User Data Template
 *
 * @author Jegtheme
 * @since 1.3.0
 * @package jeg-element
 */

$user_data         = get_option( 'jkit_user_data' );
$mailchimp_api_key = is_array( $user_data ) && isset( $user_data['mailchimp']['api_key'] ) ? $user_data['mailchimp']['api_key'] : '';
?>

<div class="jkit-dashboard-body-wrap">
	<form method="POST" id="jkit-user-data-form">
		<div id="jkit-form-content">
			<div class="jkit-form-tab collapse">
				<div class="jkit-form-content">
					<div class="jkit-form-info">
						<span class="jkit-form-name"><?php echo esc_html__( 'Mailchimp', 'jeg-elementor-kit' ); ?></span>
					</div>
				</div>
				<div class="jkit-form-tab-content">
					<div class="jkit-form-input-group mailchimp-api-key">
						<label for="data[mailchimp_api_key]"><?php echo esc_html__( 'API Key', 'jeg-elementor-kit' ); ?></label>
						<input type="text" id="data[mailchimp_api_key]" name="data[mailchimp_api_key]" value="<?php echo esc_html( $mailchimp_api_key ); ?>">
						<p><?php echo wp_kses( sprintf( __( 'Insert your Mailchimp API key. For more info, you can check out this <a href="%s" target="_blank">article</a>.', 'jeg-elementor-kit' ), 'https://mailchimp.com/help/about-api-keys/#Find_or_generate_your_API_key' ), wp_kses_allowed_html() ); ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="jkit-form-submit jkit-input-wraper">
			<button type="submit" class="jkit-submit">
				<i aria-hidden="true" class="fa fa-save"></i> <?php echo esc_html__( 'Save Changes', 'jeg-elementor-kit' ); ?>
			</button>
		</div>
	</form>
</div>
