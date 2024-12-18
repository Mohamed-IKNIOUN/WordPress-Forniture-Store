<?php
/**
 * Customizer Form Widget
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form;

/**
 * Form Widget Class
 */
class Form_Widget {

	/**
	 * Form_Menu constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'widget_setting' ), 99 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'widget_setting' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'widget_setting' ) );
	}

	/**
	 * Print menu option on bottom of admin page
	 */
	public function widget_setting() {
		wp_enqueue_script( 'jeg-form-widget-script', JEG_URL . '/assets/js/form/widget-container.js', array( 'jeg-form-builder-script' ), jeg_get_version(), true );
	}

	public static function render_form( $id, $segments, $fields ) {
		$data = array(
			'segments' => $segments,
			'fields'   => $fields,
		);

		?>
		<div id="<?php echo esc_html( $id ); ?>" data-id="<?php echo esc_html( $id ); ?>" class="widget-form-holder"></div>
		<input type="hidden" class="widget-form-data" data-id="<?php echo esc_html( $id ); ?>" value="<?php echo esc_textarea( wp_json_encode( $data ) ); ?>">
		<?php
			add_action(
				'wp_enqueue_scripts',
				wp_add_inline_script(
					'jeg-form-widget-script',
					'
						if (undefined !== window.elementor) {
							if (undefined !== jeg.widget) {
								jeg.widget.build("' . $id . '");
							}
						} else {
							(function ($) {
								$(document).on("ready", function() {
									if (undefined !== jeg.widget) {
										jeg.widget.build("' . $id . '");
									}
								})
							})(jQuery);
						}
					'
				)
			);
		?>
		<?php
	}
}
