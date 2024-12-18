<?php

$options = array();

$options[] = array(
	'id'          => 'jeg[module_loader]',
	'option_type' => 'option',
	'transport'   => 'postMessage',
	'default'     => 'dot',
	'type'        => 'jeg-select',
	'label'       => esc_html__( 'Module Loader Style', 'jeg-elementor-kit' ),
	'description' => esc_html__( 'Choose loader style for general module element.', 'jeg-elementor-kit' ),
	'choices'     => array(
		'dot'    => esc_html__( 'Dot', 'jeg-elementor-kit' ),
		'circle' => esc_html__( 'Circle', 'jeg-elementor-kit' ),
		'square' => esc_html__( 'Square', 'jeg-elementor-kit' ),
	),
	'output'      => array(
		array(
			'method'   => 'class-masking',
			'element'  => '.module-overlay .preloader_type',
			'property' => array(
				'dot'    => 'preloader_dot',
				'circle' => 'preloader_circle',
				'square' => 'preloader_square',
			),
		),
	),
);

return $options;
