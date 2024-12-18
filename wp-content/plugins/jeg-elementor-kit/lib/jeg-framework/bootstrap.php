<?php
/**
 * This customizer plugin branch of Kirki Customizer Plugin.
 * https://github.com/aristath/kirki
 *
 * @author Jegstudio
 * @since 1.3.0
 * @package jeg-framework
 */

if ( defined( 'JEG_VERSION' ) ) {
	return;
}

// Need to define JEG_URL on plugin / Themes.
defined( 'JEG_URL' ) || define( 'JEG_URL', JEG_THEME_URL . '/lib/jeg-framework' );
defined( 'JEG_VERSION' ) || define( 'JEG_VERSION', '1.3.0' );
defined( 'JEG_DIR' ) || define( 'JEG_DIR', dirname( __FILE__ ) );
defined( 'JEG_CLASSPATH' ) || define( 'JEG_CLASSPATH', JEG_DIR );

require_once 'autoload.php';
require_once 'util/framework-helper.php';

add_action( 'init', 'jeg_initialize_customizer' );

/**
 * Initialize Customizer
 */
if ( ! function_exists( 'jeg_initialize_customizer' ) ) {
	function jeg_initialize_customizer() {
		// Instantiate Customizer.
		Jeg\Customizer\Customizer::get_instance();

		// Style Generator.
		Jeg\Util\Style_Generator::get_instance();

		// Form Control.
		Jeg\Form\Form_Builder::get_instance();
	}
}
