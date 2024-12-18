<?php
/**
 * Animated Text View Class
 *
 * @package jeg-elementor-kit
 * @author Jegtheme
 * @since 1.1.0
 */

namespace Jeg\Elementor_Kit\Elements\Views;

/**
 * Class Animated_Text_View
 *
 * @package Jeg\Elementor_Kit\Elements\Views
 */
class Animated_Text_View extends View_Abstract {
	/**
	 * Build block content
	 */
	public function build_content() {
		$tag    = \Elementor\Utils::validate_html_tag( $this->attribute['sg_text_html_tag'] );
		$url    = $this->attribute['sg_text_link'];
		$text   = '<' . $tag . ' class="animated-text">' . $this->render_text() . '</' . $tag . '>';
		$text   = ! empty( $url['url'] ) ? $this->render_url_element( $url, null, null, $text ) : $text;
		$option = $this->render_option();

		return $this->render_wrapper( 'animated-text', $text, array(), $option );
	}

	/**
	 * Render Text
	 */
	private function render_text() {
		$normal_color_style  = esc_attr( $this->attribute['sg_text_normal_color_style'] );
		$dynamic_color_style = esc_attr( $this->attribute['sg_text_animated_color_style'] );
		$style               = $this->attribute['sg_text_style'];
		$text                = '<span class="normal-text style-' . $normal_color_style . '">' . esc_attr( $this->attribute['sg_text_before'] ) . '</span>';

		if ( 'rotating' === $style ) {
			$text = $text . '<span class="dynamic-wrapper style-' . $dynamic_color_style . '">' . $this->render_rotating_list() . '</span>';
		} elseif ( 'highlighted' === $style ) {
			$text = $text . '<span class="dynamic-wrapper style-' . $dynamic_color_style . '"><span class="dynamic-text">' . esc_attr( $this->attribute['sg_text_animated'] ) . '</span>' . $this->get_stroke( $this->attribute['sg_text_shape'] ) . '</span>';
		} else {
			$text = $text . '<span class="dynamic-wrapper style-' . $dynamic_color_style . '"><span class="dynamic-text">' . esc_attr( $this->attribute['sg_text_animated'] ) . '</span></span>';
		}

		$text = $text . '<span class="normal-text style-' . $normal_color_style . '">' . esc_attr( $this->attribute['sg_text_after'] ) . '</span>';

		return $text;
	}

	/**
	 * Render option
	 */
	private function render_option() {
		$option = array();
		$style  = $this->attribute['sg_text_style'];

		if ( 'rotating' === $style ) {
			$text   = array();
			$lists  = $this->attribute['sg_text_rotating_list'];
			$rotate = $this->attribute['sg_text_rotating'];
			$delay  = $this->attribute['sg_text_delay_change'];

			foreach ( $lists as $list ) {
				array_push( $text, $list['sg_text_rotating_list_text'] );
			}

			$text   = implode( ',', $text );
			$option = array(
				'style'  => esc_attr( $style ),
				'text'   => esc_attr( $text ),
				'rotate' => esc_attr( $rotate ),
				'delay'  => esc_attr( $delay ),
			);

			if ( in_array( $rotate, array( 'typing', 'swirl', 'blinds', 'wave' ), true ) ) {
				$option['letter-speed'] = esc_attr( $this->attribute['sg_text_letter_speed'] );
			}

			if ( 'clip' === $rotate ) {
				$option['clip-duration'] = esc_attr( $this->attribute['sg_text_clip_duration'] );
			}

			if ( 'typing' === $rotate ) {
				$option['delay-delete'] = esc_attr( $this->attribute['sg_text_delay_delete'] );
			}
		} elseif ( 'highlighted' === $style ) {
			$option = array(
				'style' => esc_attr( $style ),
				'text'  => esc_attr( $this->attribute['sg_text_animated'] ),
				'shape' => esc_attr( $this->attribute['sg_text_shape'] ),
			);
		} else {
			$option = array( 'style' => esc_attr( $style ) );
		}

		return $option;
	}

	/**
	 * Render Rotating List
	 */
	private function render_rotating_list() {
		$text_list    = '';
		$lists        = $this->attribute['sg_text_rotating_list'];
		$rotate_style = $this->attribute['sg_text_rotating'];

		if ( in_array( $rotate_style, array( 'typing', 'swirl', 'blinds', 'wave' ), true ) ) {
			foreach ( $lists as $list ) {
				$text_string = $list['sg_text_rotating_list_text'];
				$text_length = mb_strlen( $text_string, 'UTF-8' );
				$text_list   = $text_list . '<span class="dynamic-text">';

				for ( $i = 0; $i < $text_length; $i++ ) {
					$text_list = $text_list . '<span class="dynamic-text-letter">' . mb_substr( $text_string, $i, 1, 'UTF-8' ) . '</span>';
				}

				$text_list = $text_list . '</span>';
			}
		} else {
			foreach ( $lists as $list ) {
				$text_list = $text_list . '<span class="dynamic-text">' . $list['sg_text_rotating_list_text'] . '</span>';
			}
		}

		return $text_list;
	}

	/**
	 * Get stroke SVG
	 *
	 * @param string $stroke Stroke option.
	 */
	private function get_stroke( $stroke ) {
		$gradient_svg    = '';
		$gradient_stroke = '';

		$color_style = esc_attr( $this->attribute['st_highlight_color_style'] );

		if ( 'gradient' === $color_style ) {
			$gradient_svg    = '<linearGradient x1="0" y1="0" x2="100%" y2="100%" id="jkit-highlight-gradient"><stop offset="0"/><stop offset="100%"/></linearGradient>';
			$gradient_stroke = 'stroke="url(#jkit-highlight-gradient)"';
		}

		$strokes = array(
			'circle'           => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">' . $gradient_svg . '<path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M281.68,15.89S135.3,14.19,22.05,81.45s331.78,76.17,441,35.68S363.86-35.6,178.77,26.39" transform="translate(0.75 -3.61)"/></svg>',
			'curly'            => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">' . $gradient_svg . '<path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M6.5,75.5s25-29,50,0,50,0,50,0,25-32,50,0,50-1,50-1,25-30,50,1,50,0,50,0,27-28,50,0,50,0,50,0,26-25,50,0,36,7,36,7" transform="translate(-3.09 -56.78)"/></svg>',
			'underline'        => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">' . $gradient_svg . '<path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M3,77.5s200.54-11,493,0" transform="translate(-2.75 -68.11)"/></svg>',
			'double'           => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">' . $gradient_svg . '<path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M3.69,18.7s240.11-30,492.31,0" transform="translate(-3.14 -0.87)"/><path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M3.65,144S248.43,128,496,144" transform="translate(-3.14 -0.87)"/></svg>',
			'double-underline' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">' . $gradient_svg . '<path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M3,59.5s152.5-13,493-3" transform="translate(-2.62 -48.22)"/><path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M3,83.5s200.54-11,493,0" transform="translate(-2.62 -48.22)"/></svg>',
			'underline-zigzag' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">' . $gradient_svg . '<path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M9.5,52.5s361-31,478,0" transform="translate(-9.11 -34.22)"/><path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M484.5,55.5s-386-2-432,15c0,0,317-12,358,5,0,0-177-4-227,11" transform="translate(-9.11 -34.22)"/></svg>',
			'diagonal'         => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">' . $gradient_svg . '<path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M7.5,6.5s257,84,483,136" transform="translate(-6.1 -2.22)"/></svg>',
			'strikethrough'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">' . $gradient_svg . '<path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M7.5,75.5s200,10,485,0" transform="translate(-7.28 -71)"/></svg>',
			'x'                => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">' . $gradient_svg . '<path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M7.5,6.5s257,84,483,136" transform="translate(-6.1 -2.22)"/><path class="style-' . $color_style . '" ' . $gradient_stroke . ' d="M490.5,6.5s-310,103-483,136" transform="translate(-6.1 -2.22)"/></svg>',
		);

		return $strokes[ $stroke ];
	}
}
