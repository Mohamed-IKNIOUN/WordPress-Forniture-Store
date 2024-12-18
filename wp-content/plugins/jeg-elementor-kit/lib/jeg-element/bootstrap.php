<?php
/**
 * Jeg Element Framework that glue all element related plugin. Also contain Shortcode Generator, Widget.
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-element
 */

if ( defined( 'JEG_ELEMENT_VERSION' ) ) {
	return;
}

// Need to define JEG_ELEMENT_URL on plugin / Themes.
defined( 'JEG_ELEMENT_URL' ) || define( 'JEG_ELEMENT_URL', JEG_ELEMENT_THEME_URL );
defined( 'JEG_ELEMENT_VERSION' ) || define( 'JEG_ELEMENT_VERSION', '1.1.1' );
defined( 'JEG_ELEMENT_DIR' ) || define( 'JEG_ELEMENT_DIR', dirname( __FILE__ ) );

require_once 'autoload.php';

/**
 * Initialize Jeg Element
 */
if ( ! function_exists( 'jeg_element_initialize' ) ) {
	function jeg_element_initialize() {
		\Jeg\Element\Element::instance();
	}
}

jeg_element_initialize();
