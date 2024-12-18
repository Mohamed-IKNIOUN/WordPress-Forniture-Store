<?php
/**
 * Post Comment View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.5.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Post_Comment_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Post_Comment_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		add_filter( 'comment_form_default_fields', array( $this, 'custom_comment_form_fields' ) );

		if ( jeg_is_editor_elementor() ) {
			add_filter(
				'comments_open',
				function ( $open, $post_id ) {
					return array( true, $post_id );
				},
				null,
				2
			);
		}

		ob_start();
		comments_template();
		$content = ob_get_contents();
		ob_end_clean();
		return $this->render_wrapper( 'post-comment', $content );
	}

	/**
	 * Custom Comment Form Fields
	 */
	public function custom_comment_form_fields( $fields ) {
		if ( isset( $fields['cookies'] ) ) {
			$commenter = wp_get_current_commenter();
			$consent   = empty( $commenter['comment_author_email'] ) ? '' : 'checked';

			$fields['cookies'] = sprintf(
				'<p class="comment-form-cookies-consent">%s %s</p>',
				sprintf(
					'<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />%s',
					$consent,
					sprintf(
						'<label for="wp-comment-cookies-consent"><span class="checkmark">%s</span></label>',
						$this->render_icon_element( $this->attribute['st_form_checkbox_icon'] )
					)
				),
				sprintf(
					'<label for="wp-comment-cookies-consent">%s</label>',
					esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'jeg-elementor-kit' )
				)
			);
		}

		remove_filter( 'comment_form_default_fields', array( $this, 'custom_comment_form_fields' ) );

		return $fields;
	}
}
