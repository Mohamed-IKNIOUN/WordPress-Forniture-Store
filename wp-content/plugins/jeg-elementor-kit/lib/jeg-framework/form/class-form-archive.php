<?php
/**
 * Archive Form
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form;

/**
 * Form Archive Form
 */
class Form_Archive {

	/**
	 * Form_Menu constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'form_script' ), 99 );
	}

	/**
	 * Print menu option on bottom of admin page
	 */
	public function form_script() {
		wp_enqueue_script( 'jeg-form-archive-script', JEG_URL . '/assets/js/form/archive-container.js', array( 'jeg-form-builder-script' ), jeg_get_version(), true );
	}

	/**
	 * Render Form
	 *
	 * @param string $id Field Identifier.
	 * @param array  $segments List of Segment available on widget.
	 * @param array  $fields List of Fields available on widget.
	 */
	public static function render_form( $id, $segments, $fields ) {
		wp_localize_script(
			'jeg-form-archive-script',
			'jegWidgetData',
			array(
				wp_json_encode(
					array(
						'id'   => $id,
						'data' => array(
							'segments' => $segments,
							'fields'   => $fields,
						),
					)
				),
			)
		);
		?>
		<div id="<?php echo esc_html( $id ); ?>" data-id="<?php echo esc_html( $id ); ?>" class="archive-form-holder"></div>
		<?php
	}
}
