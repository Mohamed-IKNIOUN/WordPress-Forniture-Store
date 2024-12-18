<?php
/**
 * Contact Form 7 View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Contact_Form_7_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Contact_Form_7_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$output = null;

		if ( function_exists( 'wpcf7' ) ) {
			$form_id = intval( $this->attribute['sg_setting_contact_form'] );
			$form    = get_post( $form_id );

			if ( 'wpcf7_contact_form' === $form->post_type ) {
				$output = $this->render_wrapper( 'contact-form-7', do_shortcode( '[contact-form-7 id="' . $form_id . '"]' ) );
			}
		}

		return $output;
	}
}
