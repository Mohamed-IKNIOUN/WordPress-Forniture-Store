<?php
/**
 * Testimonials View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.0.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Testimonials_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Testimonials_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$quote_position = 'yes' === $this->attribute['st_quote_override_position'] ? 'quote-override' : '';
		$arrow_position = 'arrow-' . esc_attr( $this->attribute['sg_setting_arrow_position'] );
		$layout         = esc_attr( $this->attribute['sg_layout_testimonial_choose'] );

		$output =
		'<div class="testimonials-list">
            <div class="testimonials-track">' . $this->render_testimonials() . '</div>
        </div>';

		return $this->render_wrapper(
			'testimonials',
			$output,
			array( $arrow_position, $layout, $quote_position ),
			array(
				'id'       => $this->unique_id,
				'settings' => $this->render_option(),
			)
		);
	}

	/**
	 * Render Testimonials
	 */
	private function render_testimonials() {
		$testimonials = null;
		$layout       = $this->attribute['sg_layout_testimonial_choose'];

		switch ( $layout ) {
			case 'style-1':
				$testimonials = $this->render_testimonials_1();
				break;
			case 'style-2':
				$testimonials = $this->render_testimonials_2();
				break;
			case 'style-3':
				$testimonials = $this->render_testimonials_3();
				break;
			case 'style-4':
				$testimonials = $this->render_testimonials_4();
				break;
		}

		return $testimonials;
	}

	/**
	 * Render Testimonials Style 1
	 */
	private function render_testimonials_1() {
		$testimonials            = '';
		$height                  = 'yes' === $this->attribute['st_wrapper_fix_height'] ? 'fix-height' : '';
		$icon                    = 'yes' === $this->attribute['sg_setting_quote'] ? $this->render_icon_element( $this->attribute['sg_setting_quote_icon'] ) : '';
		$icon_class              = 'icon-content';
		$hover_direction         = esc_attr( $this->attribute['st_layout_hover_direction'] );
		$image_size              = esc_attr( $this->attribute['sg_testimonials_image_size_imagesize_size'] );
		$override_quote_position = esc_attr( $this->attribute['st_quote_override_position'] );

		if ( 'gradient' === $this->attribute['st_quote_normal_background_background_background'] || 'gradient' === $this->attribute['st_quote_hover_background_background_background'] ) {
			$icon_class .= ' hover-gradient';
			$icon        = '<span>' . $icon . '</span>';
		}

		foreach ( $this->attribute['sg_testimonials_list'] as $testimonial ) {
			$client_name        = esc_attr( $testimonial['sg_testimonials_list_client_name'] );
			$client_designation = esc_attr( $testimonial['sg_testimonials_list_designation'] );
			$client_review      = esc_attr( $testimonial['sg_testimonials_list_review'] );
			$id                 = 'elementor-repeater-item-' . esc_attr( $testimonial['_id'] );
			$rating_stars       = 'yes' === $this->attribute['sg_setting_rating'] ? $this->render_rating( floatval( $testimonial['sg_testimonials_list_rating']['size'] ) ) : '';
			$icon_content       = '<div class="' . $icon_class . '">' . $icon . '</div>';
			$content            = null;

			$img_source = 'source-url';

			if ( isset( $testimonial['sg_testimonials_list_client_avatar']['source'] ) ) {
				$img_source = 'source-' . $testimonial['sg_testimonials_list_client_avatar']['source'];
			}

			$profile_image = $this->render_image_element( $testimonial['sg_testimonials_list_client_avatar'], $image_size, null, $img_source, esc_attr( $testimonial['sg_testimonials_list_client_name'] ) );

			$comment_bio =
			'<div class="comment-bio">
                <div class="profile-image">' . $profile_image . '</div>
                <ul class="rating-stars">' . $rating_stars . '</ul>
                <span class="profile-info">
                    <strong class="profile-name">' . $client_name . '</strong>
                    <p class="profile-des">' . $client_designation . '</p>
                </span>
            </div>';

			if ( 'yes' === $override_quote_position ) {
				$content = $icon_content . $comment_bio . '<div class="comment-content"><p>' . $client_review . '</p></div>';
			} else {
				$content = $comment_bio . '<div class="comment-content">' . $icon_content . '<p>' . $client_review . '</p></div>';
			}

			$testimonials = $testimonials .
			'<div class="testimonial-item ' . $height . ' ' . $id . '">
                <div class="testimonial-box" >
                    <div class="testimonial-slider hover-from-' . $hover_direction . '">
                        ' . $content . '
                    </div>
                </div>
            </div>';
		}

		return $testimonials;
	}

	/**
	 * Render Testimonials Style 2
	 */
	private function render_testimonials_2() {
		$testimonials            = '';
		$height                  = 'yes' === $this->attribute['st_wrapper_fix_height'] ? 'fix-height' : '';
		$icon                    = 'yes' === $this->attribute['sg_setting_quote'] ? $this->render_icon_element( $this->attribute['sg_setting_quote_icon'] ) : '';
		$icon_class              = 'icon-content';
		$image_position          = esc_attr( $this->attribute['sg_layout_image_position'] );
		$hover_direction         = esc_attr( $this->attribute['st_layout_hover_direction'] );
		$image_size              = esc_attr( $this->attribute['sg_testimonials_image_size_imagesize_size'] );
		$override_quote_position = esc_attr( $this->attribute['st_quote_override_position'] );

		if ( 'gradient' === $this->attribute['st_quote_normal_background_background_background'] || 'gradient' === $this->attribute['st_quote_hover_background_background_background'] ) {
			$icon_class .= ' hover-gradient';
			$icon        = '<span>' . $icon . '</span>';
		}

		foreach ( $this->attribute['sg_testimonials_list'] as $testimonial ) {
			$client_name        = esc_attr( $testimonial['sg_testimonials_list_client_name'] );
			$client_designation = esc_attr( $testimonial['sg_testimonials_list_designation'] );
			$client_review      = esc_attr( $testimonial['sg_testimonials_list_review'] );
			$id                 = 'elementor-repeater-item-' . esc_attr( $testimonial['_id'] );
			$rating_stars       = 'yes' === $this->attribute['sg_setting_rating'] ? $this->render_rating( floatval( $testimonial['sg_testimonials_list_rating']['size'] ) ) : '';
			$icon_content       = '<div class="' . $icon_class . '">' . $icon . '</div>';
			$content            = null;

			$img_source = 'source-url';

			if ( isset( $testimonial['sg_testimonials_list_client_avatar']['source'] ) ) {
				$img_source = 'source-' . $testimonial['sg_testimonials_list_client_avatar']['source'];
			}

			$profile_image = $this->render_image_element( $testimonial['sg_testimonials_list_client_avatar'], $image_size, null, $img_source, esc_attr( $testimonial['sg_testimonials_list_client_name'] ) );

			$bio_details =
			'<div class="bio-details">
                <div class="profile-image">' . $profile_image . '</div>
                <span class="profile-info">
                    <strong class="profile-name">' . $client_name . '</strong>
                    <p class="profile-des">' . $client_designation . '</p>
                </span>
            </div>';

			if ( 'above' === $image_position ) {
				$content =
				'<div class="comment-header"><ul class="rating-stars">' . $rating_stars . '</ul></div>
                <div class="comment-bio">' . $bio_details . $icon_content . '</div>
                <div class="comment-content"><p>' . $client_review . '</p></div>';
			} elseif ( 'yes' === $override_quote_position ) {
					$content =
					$icon_content . '
                    <div class="comment-content"><p>' . $client_review . '</p></div>
                    <div class="comment-header"><ul class="rating-stars">' . $rating_stars . '</ul></div>
                    <div class="comment-bio">' . $bio_details . '</div>';
			} else {
				$content =
				'<div class="comment-content"><p>' . $client_review . '</p></div>
                    <div class="comment-header"><ul class="rating-stars">' . $rating_stars . '</ul></div>
                    <div class="comment-bio">' . $bio_details . $icon_content . '</div>';
			}

			$testimonials = $testimonials .
				'<div class="testimonial-item ' . $height . ' ' . $id . '">
                    <div class="testimonial-box hover-from-' . $hover_direction . '" >
                        ' . $content . '
                    </div>
                </div>';
		}

		return $testimonials;
	}

	/**
	 * Render Testimonials Style 3
	 */
	private function render_testimonials_3() {
		$testimonials    = '';
		$height          = 'yes' === $this->attribute['st_wrapper_fix_height'] ? 'fix-height' : '';
		$icon            = 'yes' === $this->attribute['sg_setting_quote'] ? $this->render_icon_element( $this->attribute['sg_setting_quote_icon'] ) : '';
		$icon_class      = 'icon-content';
		$image_position  = esc_attr( $this->attribute['sg_layout_image_position'] );
		$hover_direction = esc_attr( $this->attribute['st_layout_hover_direction'] );
		$image_size      = esc_attr( $this->attribute['sg_testimonials_image_size_imagesize_size'] );

		if ( 'gradient' === $this->attribute['st_quote_normal_background_background_background'] || 'gradient' === $this->attribute['st_quote_hover_background_background_background'] ) {
			$icon_class .= ' hover-gradient';
			$icon        = '<span>' . $icon . '</span>';
		}

		foreach ( $this->attribute['sg_testimonials_list'] as $testimonial ) {
			$client_name        = esc_attr( $testimonial['sg_testimonials_list_client_name'] );
			$client_designation = esc_attr( $testimonial['sg_testimonials_list_designation'] );
			$client_review      = esc_attr( $testimonial['sg_testimonials_list_review'] );
			$id                 = 'elementor-repeater-item-' . esc_attr( $testimonial['_id'] );
			$rating_stars       = 'yes' === $this->attribute['sg_setting_rating'] ? $this->render_rating( floatval( $testimonial['sg_testimonials_list_rating']['size'] ) ) : '';
			$icon_content       = '<div class="' . $icon_class . '">' . $icon . '</div>';
			$content            = null;

			$img_source = 'source-url';

			if ( isset( $testimonial['sg_testimonials_list_client_avatar']['source'] ) ) {
				$img_source = 'source-' . $testimonial['sg_testimonials_list_client_avatar']['source'];
			}

			$profile_image = $this->render_image_element( $testimonial['sg_testimonials_list_client_avatar'], $image_size, null, $img_source, esc_attr( $testimonial['sg_testimonials_list_client_name'] ) );

			$comment_bio =
			'<div class="comment-bio">
                <div class="bio-details"><div class="profile-image">' . $profile_image . '</div></div>
            </div>
            <ul class="rating-stars">' . $rating_stars . '</ul>';

			if ( 'above' === $image_position ) {
				$content = $comment_bio . '<div class="comment-content"><p>' . $client_review . '</p></div>';
			} else {
				$content = '<div class="comment-content"><p>' . $client_review . '</p></div>' . $comment_bio;
			}

			$testimonials = $testimonials .
			'<div class="testimonial-item ' . $height . ' ' . $id . '">
                <div class="testimonial-box hover-from-' . $hover_direction . '">
                    ' . $icon_content . $content . '
                    <span class="profile-info">
                        <strong class="profile-name">' . $client_name . '</strong>
                        <p class="profile-des">' . $client_designation . '</p>
                    </span>
                </div>
            </div>';
		}

		return $testimonials;
	}

	/**
	 * Render Testimonials Style 4
	 */
	private function render_testimonials_4() {
		$testimonials    = '';
		$height          = 'yes' === $this->attribute['st_wrapper_fix_height'] ? 'fix-height' : '';
		$icon            = 'yes' === $this->attribute['sg_setting_quote'] ? $this->render_icon_element( $this->attribute['sg_setting_quote_icon'] ) : '';
		$icon_class      = 'icon-content';
		$image_position  = esc_attr( $this->attribute['sg_layout_image_position'] );
		$hover_direction = esc_attr( $this->attribute['st_layout_hover_direction'] );
		$image_size      = esc_attr( $this->attribute['sg_testimonials_image_size_imagesize_size'] );

		if ( 'gradient' === $this->attribute['st_quote_normal_background_background_background'] || 'gradient' === $this->attribute['st_quote_hover_background_background_background'] ) {
			$icon_class .= ' hover-gradient';
			$icon        = '<span>' . $icon . '</span>';
		}

		foreach ( $this->attribute['sg_testimonials_list'] as $testimonial ) {
			$client_name        = esc_attr( $testimonial['sg_testimonials_list_client_name'] );
			$client_designation = esc_attr( $testimonial['sg_testimonials_list_designation'] );
			$client_review      = esc_attr( $testimonial['sg_testimonials_list_review'] );
			$id                 = 'elementor-repeater-item-' . esc_attr( $testimonial['_id'] );
			$rating_stars       = 'yes' === $this->attribute['sg_setting_rating'] ? $this->render_rating( floatval( $testimonial['sg_testimonials_list_rating']['size'] ) ) : '';
			$icon_content       = '<div class="' . $icon_class . '">' . $icon . '</div>';
			$content            = null;

			$img_source = 'source-url';

			if ( isset( $testimonial['sg_testimonials_list_client_avatar']['source'] ) ) {
				$img_source = 'source-' . $testimonial['sg_testimonials_list_client_avatar']['source'];
			}

			$profile_image = $this->render_image_element( $testimonial['sg_testimonials_list_client_avatar'], $image_size, null, $img_source, esc_attr( $testimonial['sg_testimonials_list_client_name'] ) );

			$comment_bio =
			'<div class="comment-bio">
                <div class="bio-details">
                    <div class="profile-image">' . $profile_image . '</div>
                    <ul class="rating-stars">' . $rating_stars . '</ul>
                    <span class="profile-info">
                        <strong class="profile-name">' . $client_name . '</strong>
                        <p class="profile-des">' . $client_designation . '</p>
                    </span>
                </div>
            </div>';

			if ( 'above' === $image_position ) {
				$content = $comment_bio . '<div class="comment-content"><p>' . $client_review . '</p></div>';
			} else {
				$content = '<div class="comment-content"><p>' . $client_review . '</p></div>' . $comment_bio;
			}

			$testimonials = $testimonials .
			'<div class="testimonial-item ' . $height . ' ' . $id . '">
                <div class="testimonial-box hover-from-' . $hover_direction . '" >
                    ' . $icon_content . $content . '
                </div>
            </div>';
		}

		return $testimonials;
	}

	/**
	 * Render stars rating
	 *
	 * @param int $value Rating value.
	 */
	private function render_rating( $value ) {
		$rating       = '';
		$rating_round = floor( $value );
		$rating_full  = $this->render_icon_element( $this->attribute['sg_setting_rating_icon_full'] );
		$rating_half  = $this->render_icon_element( $this->attribute['sg_setting_rating_icon_half'] );

		for ( $i = 0; $i < $rating_round; $i++ ) {
			$rating = $rating . '<li>' . $rating_full . '</li>';
		}

		if ( ( $value - $rating_round ) > 0 ) {
			$rating = $rating . '<li>' . $rating_half . '</li>';
		}

		return $rating;
	}

	/**
	 * Render Option
	 */
	private function render_option() {
		$default   = array(
			'widescreen'   => array(
				'items'  => 3,
				'margin' => 10,
			),
			'dekstop'      => array(
				'items'  => 3,
				'margin' => 10,
			),
			'laptop'       => array(
				'items'  => 3,
				'margin' => 10,
			),
			'tablet_extra' => array(
				'items'  => 3,
				'margin' => 10,
			),
			'tablet'       => array(
				'items'  => 2,
				'margin' => 10,
			),
			'mobile_extra' => array(
				'items'  => 2,
				'margin' => 10,
			),
			'mobile'       => array(
				'items'  => 1,
				'margin' => 10,
			),
		);
		$nav_left  = preg_replace( '~[\r\n\s]+~', ' ', $this->render_icon_element( $this->attribute['sg_setting_arrow_left'] ) );
		$nav_right = preg_replace( '~[\r\n\s]+~', ' ', $this->render_icon_element( $this->attribute['sg_setting_arrow_right'] ) );
		$items     = ! empty( $this->attribute['sg_setting_slide_show_responsive']['size'] ) ? $this->attribute['sg_setting_slide_show_responsive']['size'] : $default['dekstop']['items'];
		$margin    = ! empty( $this->attribute['sg_setting_margin_responsive']['size'] ) ? $this->attribute['sg_setting_margin_responsive']['size'] : $default['dekstop']['margin'];

		if ( 'gradient' === $this->attribute['st_arrow_normal_background_background_background'] || 'gradient' === $this->attribute['st_arrow_hover_background_background_background'] ) {
			$icon_class = 'hover-gradient';
			$nav_left   = '<span class="' . $icon_class . '">' . $nav_left . '</span>';
			$nav_right  = '<span class="' . $icon_class . '">' . $nav_right . '</span>';
		} else {
			$nav_left  = '<span>' . $nav_left . '</span>';
			$nav_right = '<span>' . $nav_right . '</span>';
		}

		$prev_key              = 'desktop';
		$responsive['desktop'] = array(
			'items'      => $items,
			'margin'     => $margin,
			'breakpoint' => 0,
		);

		foreach ( jkit_get_responsive_breakpoints() as $breakpoint ) {
			$responsive[ $breakpoint['key'] ]      = array(
				'items'      => $default[ $breakpoint['key'] ]['items'],
				'margin'     => $default[ $breakpoint['key'] ]['margin'],
				'breakpoint' => 0,
			);
			$responsive[ $prev_key ]['breakpoint'] = $breakpoint['value'] + 1;

			if ( isset( $this->attribute[ 'sg_setting_slide_show_responsive_' . $breakpoint['key'] ] ) ) {
				$responsive[ $breakpoint['key'] ]['items'] = ! empty( $this->attribute[ 'sg_setting_slide_show_responsive_' . $breakpoint['key'] ]['size'] ) ? $this->attribute[ 'sg_setting_slide_show_responsive_' . $breakpoint['key'] ]['size'] : $responsive[ $prev_key ]['items'];
			}

			if ( isset( $this->attribute[ 'sg_setting_margin_responsive_' . $breakpoint['key'] ] ) ) {
				$responsive[ $breakpoint['key'] ]['margin'] = ! empty( $this->attribute[ 'sg_setting_margin_responsive_' . $breakpoint['key'] ]['size'] ) ? $this->attribute[ 'sg_setting_margin_responsive_' . $breakpoint['key'] ]['size'] : $responsive[ $prev_key ]['margin'];
			}

			$prev_key = $breakpoint['key'];
		}

		$options = array(
			'autoplay'             => 'yes' === $this->attribute['sg_setting_autoplay'],
			'autoplay_speed'       => ! empty( $this->attribute['sg_setting_autoplay_speed']['size'] ) ? intval( $this->attribute['sg_setting_autoplay_speed']['size'] ) : '',
			'autoplay_hover_pause' => 'yes' === $this->attribute['sg_setting_autoplay_pause'],
			'show_navigation'      => 'yes' === $this->attribute['sg_setting_arrow'],
			'navigation_left'      => $nav_left,
			'navigation_right'     => $nav_right,
			'show_dots'            => 'yes' === $this->attribute['sg_setting_dots'],
			'arrow_position'       => 'top-left' === $this->attribute['sg_setting_arrow_position'] || 'top-right' === $this->attribute['sg_setting_arrow_position'] ? 'top' : 'bottom',
			'responsive'           => $responsive,
		);

		return htmlspecialchars( wp_json_encode( $options ), ENT_QUOTES, 'UTF-8' );
	}
}
