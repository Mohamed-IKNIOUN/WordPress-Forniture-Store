<?php
/**
 * Mailchimp View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.3.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Mailchimp_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Mailchimp_View extends View_Abstract {
	/**
	 * Mailchimp API Key
	 *
	 * @var string $mailchimp_api_key
	 */
	private $mailchimp_api_key = '';

	/**
	 * Set Mailchimp API Key.
	 */
	private function set_mailchimp_api_key() {
		$user_data = get_option( 'jkit_user_data', '' );

		if ( is_array( $user_data ) && isset( $user_data['mailchimp']['api_key'] ) && ! empty( $user_data['mailchimp']['api_key'] ) ) {
			$this->mailchimp_api_key = $user_data['mailchimp']['api_key'];
		}
	}

	/**
	 * Build block content
	 */
	public function build_content() {
		$name    = $this->render_name_form();
		$phone   = $this->render_phone_form();
		$email   = $this->render_email_form();
		$button  = $this->render_button();
		$message = esc_attr( $this->attribute['sg_form_success_message'] );
		$style   = esc_attr( $this->attribute['sg_form_style'] );
		$list    = esc_attr( $this->attribute['sg_form_list'] );
		$error   = esc_html__( 'Something went wrong', 'jeg-elementor-kit' );
		$extra   = 'email-form';

		if ( $name || $phone ) {
			$extra = 'extra-fields';
		}

		$content =
		'<form method="post" class="jkit-mailchimp-form" data-listed="' . $list . '" data-success-message="' . $message . '" data-error-message="' . $error . '">
            <div class="jkit-mailchimp-message"></div>
            <div class="jkit-form-wrapper ' . $extra . '">
                ' . $name . $phone . $email . $button . '
            </div>
        </form>';

		return $this->render_wrapper( 'mailchimp', $content, array( 'style-' . $style ) );
	}

	/**
	 * Build Email Form
	 */
	protected function render_email_form() {
		$icon_label = null;
		$label      = null;

		$icon_enable = 'yes' === $this->attribute['sg_form_email_icon_enable'];
		$label_text  = esc_attr( $this->attribute['sg_form_email_label'] );
		$placeholder = esc_attr( $this->attribute['sg_form_email_placeholder'] );

		$input = '<input type="email" name="email" class="jkit-email jkit-form-control " placeholder="' . $placeholder . '" required="">';

		if ( $icon_enable ) {
			$icon_position = esc_attr( $this->attribute['sg_form_email_icon_position'] );

			$icon_label =
			'<div class="jkit-input-group-icon position-' . $icon_position . '">
                <div class="jkit-input-group-text">
                    ' . $this->render_icon_element( $this->attribute['sg_form_email_icon'] ) . '
                </div>
            </div>';

			if ( 'before' === $icon_position ) {
				$input = $icon_label . $input;
			} else {
				$input = $input . $icon_label;
			}
		}

		if ( ! empty( $label_text ) ) {
			$label = '<label class="jkit-input-label">' . $label_text . '</label>';
		}

		$form =
		'<div class="jkit-mailchimp-email jkit-input-wrapper input-container">
            <div class="jkit-form-group">' . $label . '
                <div class="jkit-input-element-container jkit-input-group">
                    ' . $input . '
                </div>
            </div>
        </div>';

		return $form;
	}

	/**
	 * Build Phone Form
	 */
	protected function render_phone_form() {
		$form   = null;
		$enable = 'yes' === $this->attribute['sg_form_phone_enable'];

		if ( $enable ) {
			$icon_label = null;
			$label      = null;

			$icon_enable = 'yes' === $this->attribute['sg_form_phone_icon_enable'];
			$label_text  = esc_attr( $this->attribute['sg_form_phone_label'] );
			$placeholder = esc_attr( $this->attribute['sg_form_phone_placeholder'] );

			$input = '<input type="phone" name="phone" class="jkit-phone jkit-form-control " placeholder="' . $placeholder . '" required="">';

			if ( $icon_enable ) {
				$icon_position = esc_attr( $this->attribute['sg_form_phone_icon_position'] );

				$icon_label =
				'<div class="jkit-input-group-icon position-' . $icon_position . '">
                    <div class="jkit-input-group-text">
                        ' . $this->render_icon_element( $this->attribute['sg_form_phone_icon'] ) . '
                    </div>
                </div>';

				if ( 'before' === $icon_position ) {
					$input = $icon_label . $input;
				} else {
					$input = $input . $icon_label;
				}
			}

			if ( ! empty( $label_text ) ) {
				$label = '<label class="jkit-input-label">' . $label_text . '</label>';
			}

			$form =
			'<div class="jkit-mailchimp-phone jkit-input-wrapper input-container">
                <div class="jkit-form-group">' . $label . '
                    <div class="jkit-input-element-container jkit-input-group">
                        ' . $input . '
                    </div>
                </div>
            </div>';
		}

		return $form;
	}

	/**
	 * Build Name Form
	 */
	protected function render_name_form() {
		$form   = '';
		$enable = 'yes' === $this->attribute['sg_form_name_enable'];

		if ( $enable ) {
			/**
			 * First Name Form
			 */
			$icon_label = null;
			$label      = null;

			$icon_enable = 'yes' === $this->attribute['sg_form_name_first_icon_enable'];
			$label_text  = esc_attr( $this->attribute['sg_form_name_first_label'] );
			$placeholder = esc_attr( $this->attribute['sg_form_name_first_placeholder'] );

			$input = '<input type="text" name="first-name" class="jkit-first-name jkit-form-control " placeholder="' . $placeholder . '" required="">';

			if ( $icon_enable ) {
				$icon_position = esc_attr( $this->attribute['sg_form_name_first_icon_position'] );

				$icon_label =
				'<div class="jkit-input-group-icon position-' . $icon_position . '">
                    <div class="jkit-input-group-text">
						' . $this->render_icon_element( $this->attribute['sg_form_name_first_icon'] ) . '
                    </div>
                </div>';

				if ( 'before' === $icon_position ) {
					$input = $icon_label . $input;
				} else {
					$input = $input . $icon_label;
				}
			}

			if ( ! empty( $label_text ) ) {
				$label = '<label class="jkit-input-label">' . $label_text . '</label>';
			}

			$form = $form .
			'<div class="jkit-mailchimp-first-name jkit-input-wrapper input-container">
                <div class="jkit-form-group">' . $label . '
                    <div class="jkit-input-element-container jkit-input-group">
                        ' . $input . '
                    </div>
                </div>
            </div>';

			/**
			 * Last Name Form
			 */
			$icon_label = null;
			$label      = null;

			$icon_enable = 'yes' === $this->attribute['sg_form_name_last_icon_enable'];
			$label_text  = esc_attr( $this->attribute['sg_form_name_last_label'] );
			$placeholder = esc_attr( $this->attribute['sg_form_name_last_placeholder'] );

			$input = '<input type="text" name="last-name" class="jkit-last-name jkit-form-control " placeholder="' . $placeholder . '" required="">';

			if ( $icon_enable ) {
				$icon_position = esc_attr( $this->attribute['sg_form_name_last_icon_position'] );

				$icon_label =
				'<div class="jkit-input-group-icon position-' . $icon_position . '">
                    <div class="jkit-input-group-text">
						' . $this->render_icon_element( $this->attribute['sg_form_name_last_icon'] ) . '
                    </div>
                </div>';

				if ( 'before' === $icon_position ) {
					$input = $icon_label . $input;
				} else {
					$input = $input . $icon_label;
				}
			}

			if ( ! empty( $label_text ) ) {
				$label = '<label class="jkit-input-label">' . $label_text . '</label>';
			}

			$form = $form .
			'<div class="jkit-mailchimp-last-name jkit-input-wrapper input-container">
                <div class="jkit-form-group">' . $label . '
                    <div class="jkit-input-element-container jkit-input-group">
                        ' . $input . '
                    </div>
                </div>
            </div>';
		}

		return $form;
	}

	/**
	 * Build Button
	 *
	 * @return mixed
	 */
	protected function render_button() {
		$text          = esc_attr( $this->attribute['sg_form_button_text'] );
		$icon_position = esc_attr( $this->attribute['sg_form_button_icon_position'] );
		$icon          = 'yes' === $this->attribute['sg_form_button_icon_enable'] ? $this->render_icon_element( $this->attribute['sg_form_button_icon'] ) : '';

		if ( 'before' === $icon_position ) {
			$text = $icon . $text;
		} else {
			$text = $text . $icon;
		}

		$button =
		'<div class="jkit-submit-input-holder jkit-input-wrapper">
            <button type="submit" class="jkit-mailchimp-submit position-' . $icon_position . '" name="jkit-mailchimp">
                ' . $text . '
            </button>
        </div>';

		return $button;
	}

	/**
	 * Ajax request handler
	 */
	public function ajax_request() {
		$this->set_mailchimp_api_key();

		// @codingStandardsIgnoreStart sanitize value using jeg_sanitize_array
		$data        = jeg_sanitize_array( $_REQUEST['data'] );
		// @codingStandardsIgnoreEnd
		$check_admin = in_array( 'administrator', wp_get_current_user()->roles, true );

		if ( empty( $this->mailchimp_api_key ) ) {
			$error_message = esc_html__( 'Something went wrong', 'jeg-elementor-kit' );

			if ( $check_admin ) {
				$error_message = esc_html__( 'Please set API Key into dashboard user data.', 'jeg-elementor-kit' );
			}

			wp_send_json(
				array(
					'message'     => $error_message,
					'status_code' => 400,
				)
			);

			return;
		}

		$server = explode( '-', $this->mailchimp_api_key );

		if ( ! isset( $server[1] ) || empty( $server[1] ) || preg_match( '/^.*\..+$/', $server[1] ) ) {
			$error_message = esc_html__( 'Something went wrong', 'jeg-elementor-kit' );

			if ( $check_admin ) {
				$error_message = esc_html__( 'Please make sure your API Key is correct in dashboard user data.', 'jeg-elementor-kit' );
			}

			wp_send_json(
				array(
					'message'     => $error_message,
					'status_code' => 400,
				)
			);

			return;
		}

		$url     = 'https://' . $server[1] . '.api.mailchimp.com/3.0/lists/' . $data['list'] . '/members';
		$payload = array(
			'email_address' => $data['email'],
			'status'        => 'subscribed',
			'status_if_new' => 'subscribed',
			'merge_fields'  => array(
				'FNAME' => isset( $data['first_name'] ) ? $data['first_name'] : '',
				'LNAME' => isset( $data['last_name'] ) ? $data['last_name'] : '',
				'PHONE' => isset( $data['phone'] ) ? $data['phone'] : '',
			),
		);

		$response = wp_remote_post(
			$url,
			array(
				'method'      => 'POST',
				'data_format' => 'body',
				'timeout'     => 45,
				'headers'     => array(
					'Authorization'    => 'apikey ' . $this->mailchimp_api_key,
					'Content-Type'     => 'application/json; charset=utf-8',
					'Content-Language' => get_locale(),
				),
				'body'        => wp_json_encode( $payload ),
			)
		);

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			wp_send_json(
				array(
					'message'     => esc_html__( 'Something went wrong: ', 'jeg-elementor-kit' ) . $error_message,
					'status_code' => 400,
				)
			);
			return;
		}

		$response_body = wp_remote_retrieve_body( $response );
		$response_body = ! is_array( $response_body ) ? json_decode( $response_body ) : $response_body;

		if ( is_object( $response_body ) && $response_body->status >= 400 ) {
			$response_data = apply_filters(
				'jkit_mailchimp_response',
				array(
					'message'     => $response_body->title,
					'status_code' => $response_body->status,
				),
				$response_body
			);

			wp_send_json( $response_data );
			return;
		}

		wp_send_json(
			array(
				'message'     => null,
				'status_code' => 200,
			)
		);
	}
}
