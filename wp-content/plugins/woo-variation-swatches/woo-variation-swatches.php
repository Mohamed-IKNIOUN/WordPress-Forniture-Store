<?php
	/**
	 * Plugin Name: Variation Swatches for WooCommerce
	 * Plugin URI: https://wordpress.org/plugins/woo-variation-swatches/
	 * Description: Beautiful colors, images and buttons variation swatches for woocommerce product attributes. Requires WooCommerce 7.5+
	 * Author: Emran Ahmed
	 * Version: 2.1.3
	 * Requires PHP: 7.4
	 * Requires at least: 5.9
	 * Tested up to: 6.7
	 * WC requires at least: 7.5
	 * WC tested up to: 9.4
	 * Text Domain: woo-variation-swatches
	 * Domain Path: /languages
	 * Author URI: https://getwooplugins.com/
	 * Requires Plugins: woocommerce
	 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WOO_VARIATION_SWATCHES_PLUGIN_VERSION' ) ) {
	define( 'WOO_VARIATION_SWATCHES_PLUGIN_VERSION', '2.1.3' );
}

if ( ! defined( 'WOO_VARIATION_SWATCHES_MINIMUM_COMPATIBLE_PRO_PLUGIN_VERSION' ) ) {
	define( 'WOO_VARIATION_SWATCHES_MINIMUM_COMPATIBLE_PRO_PLUGIN_VERSION', '2.1.0' );
}

if ( ! defined( 'WOO_VARIATION_SWATCHES_PLUGIN_FILE' ) ) {
	define( 'WOO_VARIATION_SWATCHES_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'WOO_VARIATION_SWATCHES_MAYBE_PRO_PLUGIN_FILE' ) ) {
	$woo_variation_swatches_maybe_pro_plugin_file = sprintf('%s/woo-variation-swatches-pro/woo-variation-swatches-pro.php', wp_normalize_path( WP_PLUGIN_DIR ));
	define( 'WOO_VARIATION_SWATCHES_MAYBE_PRO_PLUGIN_FILE', $woo_variation_swatches_maybe_pro_plugin_file );
}

	// Include the main class.
if ( ! class_exists( 'Woo_Variation_Swatches', false ) ) {
	require_once __DIR__ . '/includes/class-woo-variation-swatches.php';
}

/**
 * Require woocommerce admin message.
 *
 * @return void
 */
function woo_variation_swatches_missing_wc_notice() {

	if ( ! class_exists( 'WooCommerce' ) ) {

		$args = array(
			'tab'       => 'plugin-information',
			'plugin'    => 'woocommerce',
			'TB_iframe' => 'true',
			'width'     => '640',
			'height'    => '500',
		);

		printf(
			'<div class="%1$s"><p>%2$s <a class="thickbox open-plugin-details-modal" href="%3$s"><strong>%4$s</strong></a></p></div>',
			'notice notice-error',
			wp_kses( __( '<strong>Variation Swatches for WooCommerce</strong> is an add-on of ', 'woo-variation-swatches' ), array( 'strong' => array() ) ),
			esc_url( add_query_arg( $args, admin_url( 'plugin-install.php' ) ) ),
			esc_html__( 'WooCommerce', 'woo-variation-swatches' )
		);
	}
}

	add_action( 'admin_notices', 'woo_variation_swatches_missing_wc_notice' );

	/**
	 * Returns the main instance.
	 */
function woo_variation_swatches() {

	if ( ! class_exists( 'WooCommerce', false ) ) {
		return false;
	}

	if ( function_exists( 'woo_variation_swatches_pro' ) && woo_variation_swatches_using_correct_pro_version() ) {
		return woo_variation_swatches_pro();
	}

	return Woo_Variation_Swatches::instance();
}

	add_action( 'plugins_loaded', 'woo_variation_swatches' );

/**
 * Check is using correct version of pro plugin.
 *
 * @return bool
 */
function woo_variation_swatches_using_correct_pro_version(): bool {
	return defined( 'WOO_VARIATION_SWATCHES_PRO_PLUGIN_VERSION' ) && ( version_compare( constant('WOO_VARIATION_SWATCHES_PRO_PLUGIN_VERSION'), constant( 'WOO_VARIATION_SWATCHES_MINIMUM_COMPATIBLE_PRO_PLUGIN_VERSION' ) ) >= 0 );
}

/**
 * Prevent activating pro old version.
 *
 * @return void
 */
function woo_variation_swatches_deactivate_pro() {

	if ( woo_variation_swatches_using_correct_pro_version() ) {
		return;
	}

	if ( ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	if ( is_plugin_active( 'woo-variation-swatches-pro/woo-variation-swatches-pro.php' ) ) {

		// Suppress "Plugin activated." notice.
		unset($_GET['activate']); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		// Display notice why pro version cannot activate.
		add_action('admin_notices', 'woo_variation_swatches_deactivate_notice_pro');
		// Deactivate the plugin silently, Prevent deactivation hooks from running.
		deactivate_plugins( 'woo-variation-swatches-pro/woo-variation-swatches-pro.php', true );
	}
}

/**
 * Prevent Pro plugin.
 *
 * @return void
 */
function woo_variation_swatches_deactivate_notice_pro() {

	if ( woo_variation_swatches_using_correct_pro_version() ) {
		return;
	}

	/* translators: %s: Pro Plugin Version */
	$notice_text =  sprintf(esc_html__('You are running older version of "Variation Swatches for WooCommerce - Pro". Please upgrade to %s or upper and continue.', 'woo-variation-swatches'), esc_html(constant( 'WOO_VARIATION_SWATCHES_MINIMUM_COMPATIBLE_PRO_PLUGIN_VERSION' )));

	printf( '<div class="%1$s"><p>%2$s</p></div>', 'notice notice-error', esc_html($notice_text) );
}

/**
 * Show notice on plugin row.
 *
 * @param string $plugin_file Refer to {@see 'plugin_row_meta'} filter.
 * @param array  $plugin_data Refer to {@see 'plugin_row_meta'} filter.
 *
 * @return void
 */
function woo_variation_swatches_row_meta_notice_pro( string $plugin_file, array $plugin_data) {
	if ( plugin_basename( WOO_VARIATION_SWATCHES_MAYBE_PRO_PLUGIN_FILE ) === $plugin_file ) {
		$current_version = $plugin_data['Version'];
		if (  version_compare( $current_version, constant( 'WOO_VARIATION_SWATCHES_MINIMUM_COMPATIBLE_PRO_PLUGIN_VERSION' ), '<' )  ) {
			/* translators: %s: Pro Plugin Version */
			$notice_text = 	 sprintf(esc_html__('You are running older version of "Variation Swatches for WooCommerce - Pro". Please upgrade to %s or upper.', 'woo-variation-swatches'), esc_html(constant( 'WOO_VARIATION_SWATCHES_MINIMUM_COMPATIBLE_PRO_PLUGIN_VERSION' )));

			printf( '<p style="color: darkred"><span class="dashicons dashicons-warning"></span> <strong>%s</strong></p>', esc_html($notice_text) );
		}
	}
}

/**
 * HPOS compatibility declaration.
 *
 * @return void
 */
function woo_variation_swatches_hpos_compatibility() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
}

	add_action( 'before_woocommerce_init', 'woo_variation_swatches_hpos_compatibility' );
	add_action( 'plugins_loaded', 'woo_variation_swatches_deactivate_pro', 9 );
	add_action( 'after_plugin_row_meta', 'woo_variation_swatches_row_meta_notice_pro', 10, 2 );

