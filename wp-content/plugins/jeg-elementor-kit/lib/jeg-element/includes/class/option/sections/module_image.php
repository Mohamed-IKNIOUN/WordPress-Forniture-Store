<?php

$options = array();

$options[] = array(
	'id'          => 'jeg[image_load_alert]',
	'type'        => 'jeg-alert',
	'default'     => 'info',
	'label'       => esc_html__( 'How Image Loaded', 'jeg-elementor-kit' ),
	'description' => wp_kses(
		__(
			'<ul>
                    <li><strong>Normal Load Image :</strong> Support retina, largest size at first load, good for SEO.</li>
                    <li><strong>Lazy Load :</strong> Less number of image on first load, support for retina, best browsing experience, good for SEO.</li>
                    <li><strong>Background :</strong> Support GIF image as featured thumbnail, bad for SEO.</li>
                </ul>',
			'jeg-elementor-kit'
		),
		wp_kses_allowed_html()
	),
);

$options[] = array(
	'id'          => 'jeg[image_load]',
	'option_type' => 'option',
	'transport'   => 'refresh',
	'default'     => 'lazyload',
	'type'        => 'jeg-select',
	'label'       => esc_html__( 'Image Load Mechanism', 'jeg-elementor-kit' ),
	'description' => esc_html__( 'Choose image load mechanism method ( only for Jeg Element ).', 'jeg-elementor-kit' ),
	'choices'     => array(
		'normal'     => 'Normal Load',
		'lazyload'   => 'Lazy Load Image',
		'background' => 'Background Image',
	),
);


$options[] = array(
	'id'          => 'jeg[image_generator_alert]',
	'option_type' => 'option',
	'type'        => 'jeg-alert',
	'default'     => 'info',
	'label'       => esc_html__( 'How Image Generated', 'jeg-elementor-kit' ),
	'description' => wp_kses(
		__(
			'<ul>
                    <li><strong>Normal Image Generator :</strong> Fastest load time, but require more space. About 12 images will be generated for single image uploaded. If you switch to this option, please regenerate image again.</li>
                    <li><strong>Dynamic Image Generator :</strong> Slower load time only when image created for the first time. Image generated only when needed.</li>                    
                </ul>',
			'jeg-elementor-kit'
		),
		wp_kses_allowed_html()
	),
);

$options[] = array(
	'id'          => 'jeg[image_generator]',
	'option_type' => 'option',
	'transport'   => 'refresh',
	'default'     => 'normal',
	'type'        => 'jeg-select',
	'label'       => esc_html__( 'Image Generator', 'jeg-elementor-kit' ),
	'description' => esc_html__( 'Choose image generated method ( only for Jeg Element ).', 'jeg-elementor-kit' ),
	'choices'     => array(
		'normal'  => 'Normal Image Generator',
		'dynamic' => 'Dynamic Image Generator',
	),
);

return $options;
