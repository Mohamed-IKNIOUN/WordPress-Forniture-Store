<?php

$options = array();

$options[] = array(
	'id'          => 'jeg[module-title-font]',
	'transport'   => 'postMessage',
	'type'        => 'jeg-typography',
	'label'       => esc_html__( 'Global Title Font', 'jeg-elementor-kit' ),
	'description' => esc_html__( 'Set global module font title.', 'jeg-elementor-kit' ),
	'option_type' => 'option',
	'default'     => array(
		'font-family' => '',
		'variant'     => '',
		'font-size'   => '',
		'line-height' => '',
		'subsets'     => array(),
		'color'       => '',
	),
	'output'      => array(
		array(
			'method'  => 'typography',
			'element' => '.jeg_post_title, .jeg_post_title > a, jeg_archive_title',
		),
	),
);

$options[] = array(
	'id'          => 'jeg[module-meta-font]',
	'transport'   => 'postMessage',
	'type'        => 'jeg-typography',
	'label'       => esc_html__( 'Global Meta Font', 'jeg-elementor-kit' ),
	'description' => esc_html__( 'Set global module meta title.', 'jeg-elementor-kit' ),
	'option_type' => 'option',
	'default'     => array(
		'font-family' => '',
		'variant'     => '',
		'font-size'   => '',
		'line-height' => '',
		'subsets'     => array(),
		'color'       => '',
	),
	'output'      => array(
		array(
			'method'  => 'typography',
			'element' => '.jeg_post_meta, .jeg_post_meta .fa, .jeg_postblock .jeg_subcat_list > li > a:hover, .jeg_pl_md_card .jeg_post_category a, .jeg_postblock .jeg_subcat_list > li > a.current, .jeg_pl_md_5 .jeg_post_meta, .jeg_pl_md_5 .jeg_post_meta .fa, .jeg_post_category a',
		),
	),
);

$options[] = array(
	'id'          => 'jeg[module-content-font]',
	'transport'   => 'postMessage',
	'type'        => 'jeg-typography',
	'label'       => esc_html__( 'Global Content Font', 'jeg-elementor-kit' ),
	'description' => esc_html__( 'Set global content font title.', 'jeg-elementor-kit' ),
	'option_type' => 'option',
	'default'     => array(
		'font-family' => '',
		'variant'     => '',
		'font-size'   => '',
		'line-height' => '',
		'subsets'     => array(),
		'color'       => '',
	),
	'output'      => array(
		array(
			'method'  => 'typography',
			'element' => '.jeg_post_excerpt,.jeg_readmore',
		),
	),
);

return $options;
