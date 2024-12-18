<?php

return array(
	'enabled'                           => array(
		'title'       => __( 'Enabled', 'woo-stripe-payment' ),
		'type'        => 'checkbox',
		'default'     => 'no',
		'value'       => 'yes',
		'desc_tip'    => true,
		'description' => __( 'If enabled, your site can accept credit card payments through Stripe.', 'woo-stripe-payment' ),
	),
	'live_payment_method_configuration' => array(
		'type'    => 'payment_config_select',
		'title'   => __( 'Payment Method Configuration (live mode)', 'woo-stripe-payment' ),
		'label'   => __( 'Create', 'woo-stripe-payment' ),
		'class'   => 'wc-enhanced-select payment-method-config-options',
		'default' => '',
		'options' => array(
			'' => __( 'Please select a payment method configuration', 'woo-stripe-payment' )
		)
	),
	'test_payment_method_configuration' => array(
		'type'    => 'payment_config_select',
		'title'   => __( 'Payment Method Configuration (test mode)', 'woo-stripe-payment' ),
		'label'   => __( 'Create', 'woo-stripe-payment' ),
		'class'   => 'wc-enhanced-select payment-method-config-options',
		'default' => '',
		'options' => array(
			'' => __( 'Please select a payment method configuration', 'woo-stripe-payment' )
		)
	),
	'desc'                              => array(
		'type'        => 'description',
		'description' => sprintf( __( 'The Universal Payment Method (UPM) allows you to combine all payment methods into a single integration. On your checkout page, the UPM will show all of the enabled payment methods
		 that are eligible.', 'woo-stripe-payment' ), '<a target="_blank" href="https://stripe.com/docs/testing#cards">', '</a>' ),
	),
	'general_settings'                  => array(
		'type'  => 'title',
		'title' => __( 'General Settings', 'woo-stripe-payment' ),
	),
	'title_text'                        => array(
		'type'        => 'text',
		'title'       => __( 'Title', 'woo-stripe-payment' ),
		'default'     => __( 'Popular payment methods', 'woo-stripe-payment' ),
		'desc_tip'    => true,
		'description' => __( 'Title of the payment method option' ),
	),
	'description'                       => array(
		'title'       => __( 'Description', 'woo-stripe-payment' ),
		'type'        => 'text',
		'default'     => '',
		'description' => __( 'Leave blank if you don\'t want a description to show for the gateway.', 'woo-stripe-payment' ),
		'desc_tip'    => true,
	),
	'save_card_enabled'                 => array(
		'type'        => 'checkbox',
		'value'       => 'yes',
		'default'     => 'yes',
		'title'       => __( 'Allow Payment Method Save', 'woo-stripe-payment' ),
		'desc_tip'    => true,
		'description' => __( 'If enabled, a checkbox will be available on the checkout page allowing your customers to save their payment method. The payment methods are stored securely in Stripe\'s vault and never touch your server. Note: if the cart contains a subscription, there will be no checkbox because the payment method will be saved automatically.',
			'woo-stripe-payment' ),
	),
	'test_payment_methods'              => array(
		'type'    => 'payment_methods',
		'title'   => __( 'Payment Methods (Test)', 'woo-stripe-payment' ),
		'default' => array()
	),
	'live_payment_methods'              => array(
		'type'    => 'payment_methods',
		'title'   => __( 'Payment Methods (Live)', 'woo-stripe-payment' ),
		'default' => array()
	),
	/*'icons'                             => array(
		'type'        => 'multiselect',
		'title'       => __( 'Icons', 'woo-stripe-payment' ),
		'class'       => 'wc-enhanced-select stripe-accepted-cards',
		'default'     => array( 'stripe_cc', 'stripe_klarna' ),
		'options'     => array(),
		'desc_tip'    => true,
		'description' => __( 'The selected icons will show customers which payment methods you accept using the UPM. We don\'t recommend selecting
		more than 6 icons for the best UX.', 'woo-stripe-payment' ),
	),*/
	'theme'                             => array(
		'title'   => __( 'Theme', 'woo-stripe-payment' ),
		'type'    => 'select',
		'default' => 'stripe',
		'options' => array(
			'stripe' => __( 'Default', 'woo-stripe-payment' ),
			'night'  => __( 'Night', 'woo-stripe-payment' ),
			'flat'   => __( 'Flat', 'woo-stripe-payment' )
		)
	),
	'layout_type'                       => array(
		'title'       => __( 'Layout', 'woo-stripe-payment' ),
		'type'        => 'select',
		'default'     => 'tabs',
		'options'     => array(
			'tabs'      => __( 'Tabs layout', 'woo-stripe-payment' ),
			'accordion' => __( 'Vertical layout', 'woo-stripe-payment' )
		),
		'description' => __( 'The layout option determines how the payment methods in the Universal Payment Method are displayed.', 'woo-stripe-payment' )
	),
	'layout_radios'                     => array(
		'title'             => __( 'Radio Input', 'woo-stripe-payment' ),
		'type'              => 'checkbox',
		'default'           => 'no',
		'value'             => 'yes',
		'description'       => __( 'Display a radio button next to each payment method.', 'woo-stripe-payment' ),
		'desc_tip'          => true,
		'custom_attributes' => array( 'data-show-if' => array( 'layout_type' => 'accordion' ) ),
	),
	'spaced_items'                      => array(
		'title'             => __( 'Spaced Payment Methods', 'woo-stripe-payment' ),
		'type'              => 'checkbox',
		'default'           => 'no',
		'value'             => 'yes',
		'description'       => __( 'When true, the Payment Methods render as standalone buttons with space in between them.', 'woo-stripe-payment' ),
		'desc_tip'          => true,
		'custom_attributes' => array( 'data-show-if' => array( 'layout_type' => 'accordion' ) ),
	)
);
