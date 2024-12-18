<?php
/**
 * Dashboard Notfound Template
 *
 * @author Jegtheme
 * @since 2.3.0
 * @package jeg-element
 */

$current_active_template = get_option( 'jkit_notfound_template' );
$existing_page_template  = get_posts(
	array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'posts_per_page' => 50,
		'meta_key'       => '_elementor_edit_mode',
		'meta_value'     => 'builder',
	)
);

?>

<div class="jkit-dashboard-body-wrap">
	<form method="POST" id="jkit-notfound-form">
		<div id="jkit-form-content">
			<div class="jkit-form-tab collapse">
				<div class="jkit-form-content">
					<div class="jkit-form-info">
						<span class="jkit-form-name"><?php echo esc_html__( '404 Template', 'jeg-elementor-kit' ); ?></span>
					</div>
				</div>
				<div class="jkit-form-tab-content">
					<div class="jkit-form-input-group global-style-option">
						<label for="data[notfound_template]"><?php echo esc_html__( 'Choose 404 Template', 'jeg-elementor-kit' ); ?></label>
						<select id="data[notfound_template]" name="data[notfound_template]">
							<option value=""><?php esc_html_e( 'Default From Theme', 'jeg-elementor-kit' ); ?></option>
							<?php
							if ( $existing_page_template ) {
								foreach ( $existing_page_template as $post ) {
									$selected = '';
									if ( $current_active_template == $post->ID ) {
										$selected = 'selected';
									}
									echo '<option value="' . esc_html( $post->ID ) . '" ' . esc_html( $selected ) . '>' . esc_html( $post->post_title ) . '</option>';
								}
							}
							?>
						</select>
						<p><?php esc_html_e( 'Choose which page that you want to set as a 404 page.', 'jeg-elementor-kit' ); ?></p>
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
