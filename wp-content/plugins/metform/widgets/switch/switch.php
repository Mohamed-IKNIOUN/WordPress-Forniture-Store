<?php
namespace Elementor;
defined( 'ABSPATH' ) || exit;

Class MetForm_Input_Switch extends Widget_Base{

	use \MetForm\Traits\Common_Controls;
	use \MetForm\Traits\Conditional_Controls;
	use \MetForm\Widgets\Widget_Notice;

    public function get_name() {
		return 'mf-switch';
    }
    
	public function get_title() {
		return esc_html__( 'Switch', 'metform' );
	}
	
	public function show_in_panel() {
        return 'metform-form' == get_post_type();
	}

	public function get_categories() {
		return [ 'metform' ];
	}
	    
	public function get_keywords() {
        return ['metform', 'input', 'switch', 'on', 'off'];
    }

	public function get_help_url() {
        return 'https://wpmet.com/doc/form-widgets/#switch';
    }

    protected function register_controls() {
        
        $this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'metform' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->input_content_controls(['NO_PLACEHOLDER']);
		
		$this->add_control(
		    'mf_swtich_enable_text',
		    [
			    'label' => esc_html__( 'Active Text', 'metform' ),
				'type' => Controls_Manager::TEXT,
				'default'	=> esc_html__('Yes', 'metform'),
				'frontend_available' => true,
		    ]
		);
		$this->add_control(
		    'mf_swtich_disable_text',
		    [
			    'label' => esc_html__( 'Inactive Text', 'metform' ),
				'type' => Controls_Manager::TEXT,
				'default'	=> esc_html__('No', 'metform'),
		    ]
	    );

        $this->end_controls_section();

        $this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'Settings', 'metform' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		

		$this->input_setting_controls();

		$this->add_control(
			'mf_input_validation_type',
			[
				'label' => __( 'Validation Type', 'metform' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'none',
			]
		);

		$this->input_get_params_controls();

		$this->help_text_control('To set the value, you have to use Active text value');

		$this->end_controls_section();

		if(class_exists('\MetForm_Pro\Base\Package')){
			$this->input_conditional_control();
		}

        $this->start_controls_section(
			'label_section',
			[
				'label' => esc_html__( 'Label', 'metform' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'mf_input_label_status',
							'operator' => '===',
							'value' => 'yes',
						],
						[
							'name' => 'mf_input_required',
							'operator' => '===',
							'value' => 'yes',
						],
					],
                ],
			]
		);


		$this->input_label_controls();

        $this->end_controls_section();

        $this->start_controls_section(
			'input_section',
			[
				'label' => esc_html__( 'Input', 'metform' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'mf_switch_option_btn_width',
			[
				'label' => esc_html__( 'Width', 'metform' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
                    'unit' => 'px',
                    'size' => 55	,
                ],
				'selectors' => [
					'{{WRAPPER}} .mf-input-switch .mf-input-control-label::before' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mf-input-control-label::after' => 'width: calc(({{SIZE}}{{UNIT}}  / 2) - 7px);',
					'{{WRAPPER}} .mf-input-control:checked~.mf-input-control-label::after' => 'left:  calc({{SIZE}}{{UNIT}} - (({{SIZE}}{{UNIT}}  / 2) - 7px) - 2px);'
				]
			]
		);

		$this->add_control(
			'mf_switch_option_btn_height',
			[
				'label' => esc_html__( 'Height', 'metform' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
                    'unit' => 'px',
                    'size' => 25,
                ],
				'selectors' => [
					'{{WRAPPER}} .mf-input-switch .mf-input-control-label::before' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mf-input-control-label::after' => 'height: calc({{SIZE}}{{UNIT}}  - 4px) '
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mf_input_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'metform' ),
				'selector' => '{{WRAPPER}} .mf-input, {{WRAPPER}} .irs--round .irs-line, {{WRAPPER}} .mf-input-switch label.mf-input-control-label:before, {{WRAPPER}} .mf-input-wrapper .asRange, {{WRAPPER}} .asRange .asRange-pointer:before, {{WRAPPER}} .mf-file-upload-container .mf-input-file-upload-label, {{WRAPPER}} .mf-input-wrapper .iti--separate-dial-code .iti__selected-flag, {{WRAPPER}} .mf-input-calculation-total, {{WRAPPER}} .mf-input-select > .mf_select__control, {{WRAPPER}} .mf-input-multiselect .mf_multiselect__control, {{WRAPPER}} .mf_multiselect__option, {{WRAPPER}} .mf-input-wrapper .input-range__track--background',
			]
		);
		
		$this->add_control(
            'mf_switch_active_inactive_text_heading',
            [
                'label' => esc_html__( 'Active and Inactive:', 'metform' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
		);


		$this->start_controls_tabs('mf_switch_active_inactive_text_tabs');
			$this->start_controls_tab(
				'mf_switch_inactive_text_tab',
				[
					'label' => esc_html__('Inactive', 'metform'),
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'mf_switch_inactive_text_typo',
					'label' =>esc_html__( 'Typography', 'metform' ),
					'selector' => '{{WRAPPER}} .mf-input-switch .mf-input-control-label::before',
				]
			);

			$this->add_control(
				'mf_switch_option_btn_disable_color',
				[
					'label' => esc_html__( 'Color', 'metform' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control-label::before' => 'border-color: {{VALUE}}; background-color: {{VALUE}}',
					],
					'default' => '#DADEEA',
				]
			);


			$this->add_responsive_control(
				'mf_switch_inactive_text_color',
				[
					'label' =>esc_html__( 'Text Color', 'metform' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#80828A',
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control-label::before' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'mf_switch_btn_inactive_border_style',
				[
					'label' => esc_html_x( 'Input Border Type', 'Border Control', 'metform' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'none' => esc_html__( 'None', 'metform' ),
						'solid' => esc_html_x( 'Solid', 'Border Control', 'metform' ),
						'double' => esc_html_x( 'Double', 'Border Control', 'metform' ),
						'dotted' => esc_html_x( 'Dotted', 'Border Control', 'metform' ),
						'dashed' => esc_html_x( 'Dashed', 'Border Control', 'metform' ),
						'groove' => esc_html_x( 'Groove', 'Border Control', 'metform' ),
					],
					'default'	=> 'none',
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control-label::before' => 'border-style: {{VALUE}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'mf_switch_btn_inactive_border_dimensions',
				[
					'label' => esc_html_x( 'Input Border Width', 'Border Control', 'metform' ),
					'type' => Controls_Manager::DIMENSIONS,
					'condition'	=> [
						'mf_switch_btn_inactive_border_style!'	=> 'none'
					],
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control-label::before' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
	
			$this->add_responsive_control(
				'mf_switch_btn_inactive_border_color',
				[
					'label' => esc_html_x( 'Input Border Color', 'Border Control', 'metform' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control-label::before' => 'border-color: {{VALUE}};',
					],
					'condition'	=> [
						'mf_switch_btn_inactive_border_style!'	=> 'none'
					],
				]
			);

			$this->add_responsive_control(
				'mf_switch_inactive_text_padding',
				[
					'label' => esc_html__( 'Padding', 'metform' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control-label::before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'mf_switch_option_btn_input_slider_text_one',
				[
					'label' => esc_html__( 'Input Slider:', 'metform' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'mf_switch_option_btn_disable_circle_color',
				[
					'label' => esc_html__( 'Circle Background Color', 'metform' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .mf-input-control-label::after' => 'border-color: {{VALUE}}; background-color: {{VALUE}}',
					],
					'default' => '#FFFFFF',
				]
			);
			$this->add_responsive_control(
				'mf_switch_btn_circle_border_style',
				[
					'label' => esc_html_x( 'Circle Border Type', 'Border Control', 'metform' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'none' => esc_html__( 'None', 'metform' ),
						'solid' => esc_html_x( 'Solid', 'Border Control', 'metform' ),
						'double' => esc_html_x( 'Double', 'Border Control', 'metform' ),
						'dotted' => esc_html_x( 'Dotted', 'Border Control', 'metform' ),
						'dashed' => esc_html_x( 'Dashed', 'Border Control', 'metform' ),
						'groove' => esc_html_x( 'Groove', 'Border Control', 'metform' ),
					],
					'default'	=> 'none',
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control-label::after' => 'border-style: {{VALUE}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'mf_switch_btn_circle_border_dimensions',
				[
					'label' => esc_html_x( 'Circle Border Width', 'Border Control', 'metform' ),
					'type' => Controls_Manager::DIMENSIONS,
					'condition'	=> [
						'mf_switch_btn_circle_border_style!'	=> 'none'
					],
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control-label::after' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
	
			$this->add_responsive_control(
				'mf_switch_btn_circle_border_color',
				[
					'label' => esc_html_x( 'Circle Border Color', 'Border Control', 'metform' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control-label::after' => 'border-color: {{VALUE}};',
					],
					'condition'	=> [
						'mf_switch_btn_circle_border_style!'	=> 'none'
					],
				]
			);

			

			

			$this->end_controls_tab();

			$this->start_controls_tab(
				'mf_switch_active_text_tab',
				[
					'label' => esc_html__('Active', 'metform'),
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'mf_switch_active_text_typo',
					'label' =>esc_html__( 'Typography', 'metform' ),
					'selector' => '{{WRAPPER}} .mf-input-control:checked~.mf-input-control-label::before',
				]
			);

			$this->add_control(
				'mf_switch_option_btn_active_color',
				[
					'label' => esc_html__( 'Color', 'metform' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .mf-input-control:checked~.mf-input-control-label::before' => 'border-color: {{VALUE}}; background-color: {{VALUE}}',
					],
					'default' => '#007BFF',
				]
			);

			$this->add_responsive_control(
				'mf_switch_active_text_color',
				[
					'label' =>esc_html__( 'Text Color', 'metform' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .mf-input-control:checked~.mf-input-control-label::before' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'mf_switch_btn_active_border_style',
				[
					'label' => esc_html_x( 'Input Border Type', 'Border Control', 'metform' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'none' => esc_html__( 'None', 'metform' ),
						'solid' => esc_html_x( 'Solid', 'Border Control', 'metform' ),
						'double' => esc_html_x( 'Double', 'Border Control', 'metform' ),
						'dotted' => esc_html_x( 'Dotted', 'Border Control', 'metform' ),
						'dashed' => esc_html_x( 'Dashed', 'Border Control', 'metform' ),
						'groove' => esc_html_x( 'Groove', 'Border Control', 'metform' ),
					],
					'default'	=> 'none',
					'selectors' => [
						'{{WRAPPER}} .mf-input-control:checked~.mf-input-control-label::before' => 'border-style: {{VALUE}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'mf_switch_btn_active_border_dimensions',
				[
					'label' => esc_html_x( 'Input Border Width', 'Border Control', 'metform' ),
					'type' => Controls_Manager::DIMENSIONS,
					'condition'	=> [
						'mf_switch_btn_active_border_style!'	=> 'none'
					],
					'selectors' => [
						'{{WRAPPER}} .mf-input-control:checked~.mf-input-control-label::before' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
	
			$this->add_responsive_control(
				'mf_switch_btn_active_border_color',
				[
					'label' => esc_html_x( 'Input Border Color', 'Border Control', 'metform' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .mf-input-control:checked~.mf-input-control-label::before' => 'border-color: {{VALUE}};',
					],
					'condition'	=> [
						'mf_switch_btn_active_border_style!'	=> 'none'
					],
				]
			);

			$this->add_responsive_control(
				'mf_switch_active_text_padding',
				[
					'label' => esc_html__( 'Padding', 'metform' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .mf-input-control:checked~.mf-input-control-label::before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'mf_switch_option_btn_input_slider_text_two',
				[
					'label' => esc_html__( 'Input Slider:', 'metform' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);


			$this->add_control(
				'mf_switch_option_btn_active_circle_color',
				[
					'label' => esc_html__( 'Circle Background Color', 'metform' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control:checked ~ .mf-input-control-label::after' => 'border-color: {{VALUE}}; background-color: {{VALUE}}',
					],
					'default' => '#FFFFFF',
				]
			);
			$this->add_responsive_control(
				'mf_switch_btn_active_circle_border_style',
				[
					'label' => esc_html_x( 'Circle Border Type', 'Border Control', 'metform' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'none' => esc_html__( 'None', 'metform' ),
						'solid' => esc_html_x( 'Solid', 'Border Control', 'metform' ),
						'double' => esc_html_x( 'Double', 'Border Control', 'metform' ),
						'dotted' => esc_html_x( 'Dotted', 'Border Control', 'metform' ),
						'dashed' => esc_html_x( 'Dashed', 'Border Control', 'metform' ),
						'groove' => esc_html_x( 'Groove', 'Border Control', 'metform' ),
					],
					'default'	=> 'none',
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control:checked ~ .mf-input-control-label::after' => 'border-style: {{VALUE}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'mf_switch_btn_active_circle_border_dimensions',
				[
					'label' => esc_html_x( 'Circle Border Width', 'Border Control', 'metform' ),
					'type' => Controls_Manager::DIMENSIONS,
					'condition'	=> [
						'mf_switch_btn_active_circle_border_style!'	=> 'none'
					],
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control:checked ~ .mf-input-control-label::after' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
	
			$this->add_responsive_control(
				'mf_switch_btn_active_circle_border_color',
				[
					'label' => esc_html_x( 'Circle Border Color', 'Border Control', 'metform' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .mf-input-switch .mf-input-control:checked ~ .mf-input-control-label::after' => 'border-color: {{VALUE}};',
					],
					'condition'	=> [
						'mf_switch_btn_active_circle_border_style!'	=> 'none'
					],
				]
			);


			

			$this->end_controls_tab();
		$this->end_controls_tabs();

        

		$this->end_controls_section();
		
		$this->start_controls_section(
			'help_text_section',
			[
				'label' => esc_html__( 'Help Text', 'metform' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'mf_input_help_text!' => ''
				]
			]
		);
		
		$this->input_help_text_controls();

        $this->end_controls_section();

        $this->insert_pro_message();
	}

    protected function render($instance = []){
		$settings = $this->get_settings_for_display();
        extract($settings);
		
		$render_on_editor = false;
		$is_edit_mode = 'metform-form' === get_post_type() && \Elementor\Plugin::$instance->editor->is_edit_mode();
		
		$class = (isset($settings['mf_conditional_logic_form_list']) ? 'mf-conditional-input' : '');
		
		$configData = [
			'message' 		=> $errorMessage 	= isset($mf_input_validation_warning_message) ? !empty($mf_input_validation_warning_message) ? $mf_input_validation_warning_message : esc_html__('This field is required.', 'metform') : esc_html__('This field is required.', 'metform'),
			'required'		=> isset($mf_input_required) && $mf_input_required == 'yes' ? true : false,
		];

		$switch_text_enable = isset($mf_swtich_enable_text) ? $mf_swtich_enable_text : '';
		$switch_text_disable = isset($mf_swtich_disable_text) ? $mf_swtich_disable_text : '';

        ?>

		<div class="mf-input-wrapper">
			<?php if ( 'yes' == $mf_input_label_status ): ?>
				<label class="mf-input-label" for="mf-input-switch-<?php echo esc_attr( $this->get_id() ); ?>">
					<?php echo esc_html(\MetForm\Utils\Util::react_entity_support($mf_input_label, $render_on_editor )); ?>
					<span class="mf-input-required-indicator"><?php echo esc_html( ($mf_input_required === 'yes') ? '*' : '' );?></span>
				</label>
			<?php endif; ?>

			<span class="mf-input-switch-control mf-input-switch">
				<input type="checkbox"
					name="<?php echo esc_attr($mf_input_name); ?>"
					value="<?php echo esc_attr(trim(\MetForm\Utils\Util::react_entity_support($switch_text_disable, $render_on_editor ))); ?>"
					class="mf-input mf-input-control mf-input-switch-box <?php echo esc_attr($class); ?>" id="mf-input-switch-<?php echo esc_attr($this->get_id()); ?>"
					<?php if ( !$is_edit_mode ): ?>
						onInput=${ parent.handleSwitch }
						aria-invalid=${validation.errors['<?php echo esc_attr($mf_input_name); ?>'] ? 'true' : 'false'}
						ref=${el => parent.activateValidation(<?php echo json_encode($configData); ?>, el)}
					<?php endif; ?>
					/>
				<label
					data-enable="<?php echo esc_attr(trim(\MetForm\Utils\Util::react_entity_support($switch_text_enable, $render_on_editor ))); ?>"
					data-disable="<?php echo esc_attr(trim(\MetForm\Utils\Util::react_entity_support($switch_text_disable, $render_on_editor ))); ?>"
					class="mf-input-control-label" for="mf-input-switch-<?php echo esc_attr($this->get_id()); ?>"></label>
			</span>

			<?php if ( !$is_edit_mode ) : ?>
				<${validation.ErrorMessage}
					errors=${validation.errors}
					name="<?php echo esc_attr( $mf_input_name ); ?>"
					as=${html`<span className="mf-error-message"></span>`}
					/>
			<?php endif; ?>
			<?php echo ('' !== trim($mf_input_help_text) ? sprintf('<span class="mf-input-help"> %s </span>', esc_html( \MetForm\Utils\Util::react_entity_support(trim($mf_input_help_text), $render_on_editor))) : ''); ?>
		</div>

		<?php
    }
    
}
