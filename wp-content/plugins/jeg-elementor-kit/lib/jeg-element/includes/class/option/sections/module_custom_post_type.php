<?php

$options = array();

$post_types = jeg_exclude_post_type();

unset( $post_types['post'] );
unset( $post_types['page'] );

if ( ! empty( $post_types ) && is_array( $post_types ) ) {
	foreach ( $post_types as $key => $label ) {
		$options[] = array(
			'id'          => 'jeg[enable_cpt_' . $key . ']',
			'option_type' => 'option',
			'transport'   => 'postMessage',
			'default'     => true,
			'type'        => 'jeg-toggle',
			'label'       => sprintf( esc_html__( 'Enable %s Post Type', 'jeg-elementor-kit' ), $label ),
			'description' => sprintf( esc_html__( 'Enable %s post type and their custom taxonomy as content filter.', 'jeg-elementor-kit' ), strtolower( $label ) ),
		);
	}
} else {
	$options[] = array(
		'id'          => 'jeg[enable_post_type_alert]',
		'type'        => 'jeg-alert',
		'default'     => 'info',
		'label'       => esc_html__( 'Notice', 'jeg-elementor-kit' ),
		'description' => esc_html__( 'There\'s no custom post type found.', 'jeg-elementor-kit' ),
	);
}

return $options;
