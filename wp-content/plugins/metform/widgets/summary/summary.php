<?php
namespace Elementor;
defined( 'ABSPATH' ) || exit;

Class MetForm_Input_Summary extends Widget_Base{

	use \MetForm\Traits\Common_Controls;
    use \MetForm\Traits\Conditional_Controls;
	use \MetForm\Widgets\Widget_Notice;

    public function get_name() {
		return 'mf-summary';
    }
    
	public function get_title() {
		return esc_html__( 'Summary', 'metform' );
	}
	
	public function show_in_panel() {
        return 'metform-form' == get_post_type();
	}

	public function get_categories() {
		return [ 'metform' ];
	}
	    
	public function get_keywords() {
        return ['metform', 'input', 'summary', 'preview'];
    }

	public function get_help_url() {
        return 'https://wpmet.com/doc/form-widgets/#summary-';
    }

    protected function register_controls() {
        
        $this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'metform' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->input_content_controls();

        $this->end_controls_section();

		
        $this->start_controls_section(
			'label_section',
			[
				'label' => esc_html__( 'Label', 'metform' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' =>[
					'mf_input_label_status' => 'yes'
				]
			]
        );

		$this->summary_input_label_controls();

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
		?>

		<div class="mf-input-wrapper">
			<?php if ( 'yes' == $mf_input_label_status ): ?>
				<label class="mf-input-label mf-summary-wrapper-label" for="mf-input-text-<?php echo esc_attr( $this->get_id() ); ?>">
					<?php echo esc_html(\MetForm\Utils\Util::react_entity_support($mf_input_label, $render_on_editor )); ?>
				</label>
			<?php endif; ?>
			
			<?php if ( !$is_edit_mode ): ?>
				<div class="mf-input mf-input-summary metform-entry-data container">
					<ul class="mf-entry-data">
						${Object.keys( parent.state.formData ).map((name, key) => name !== 'expireTime' && props.SummaryWidget(name, key, parent) )}
					</ul>
				</div>
			<?php else: ?>
				<div class="attr-alert attr-alert-warning" style="margin-bottom: 0;">
					<?php esc_html_e( 'Summary will be shown on preview.', 'metform' ); ?>
				</div>
			<?php endif; ?>
			<?php echo ('' !== trim($mf_input_help_text) ? sprintf('<span class="mf-input-help"> %s </span>', esc_html( \MetForm\Utils\Util::react_entity_support(trim($mf_input_help_text), $render_on_editor))) : ''); ?>
		</div>

		<?php
    }
}
