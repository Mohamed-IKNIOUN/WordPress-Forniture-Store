<?php
/**
 * Register SPL Autoloader
 *
 * @package jeg-news-element
 * @since 1.0.0
 */

spl_autoload_register(
	function ( $class ) {
		$prefix   = 'Jeg\\Element\\';
		$base_dir = JEG_ELEMENT_DIR . '/includes/class/';
		$len      = strlen( $prefix );

		if ( strncmp( $prefix, $class, $len ) !== 0 ) {
			return;
		}

		$relative_class = substr( $class, $len );
		$class_path     = explode( '\\', $relative_class );
		$relative_class = array_pop( $class_path );
		$class_path     = strtolower( implode( '/', $class_path ) );

		preg_match_all( '/((?:^|[A-Z]|\d)[a-z]+|\d+)/', $relative_class, $matches );
		$class_name = 'class-' . implode( '-', $matches[0] ) . '.php';
		$file       = rtrim( $base_dir, '/' ) . '/' . $class_path . '/' . strtolower( $class_name );

		if ( is_link( $file ) ) {
			$file = readlink( $file );
		}

		if ( is_file( $file ) ) {
			require $file;
		}
	}
);


