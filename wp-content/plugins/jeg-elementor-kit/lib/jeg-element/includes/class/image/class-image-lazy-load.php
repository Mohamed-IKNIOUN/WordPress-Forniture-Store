<?php
/**
 * Jeg News Element Lazy Load Class
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Image;

/**
 * Class Image
 */
class Image_Lazy_Load implements Image_Interface {

	/**
	 * Distance from where image expanded
	 *
	 * @var int
	 */
	private $expand_range = 700;

	/**
	 * Generate Image HTML tag without predefine size.
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function single_image_unwrap( $id, $size ) {
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'lazy_load_image' ), 10, 2 );

		$image_size = wp_get_attachment_image_src( $id, $size );
		$image      = get_post( $id );
		$percentage = round( $image_size[2] / $image_size[1] * 100, 3 );

		$thumbnail  = '<div class="thumbnail-container animate-lazy" style="padding-bottom:' . $percentage . '%">';
		$thumbnail .= wp_get_attachment_image( $id, $size );
		$thumbnail .= '</div>';

		if ( ! empty( $image->post_excerpt ) ) {
			$thumbnail .= '<p class="wp-caption-text">' . $image->post_excerpt . '</p>';
		}

		remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'lazy_load_image' ), 10 );

		return $thumbnail;
	}

	/**
	 * Image thumbnail.
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function image_thumbnail_unwrap( $id, $size ) {
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'lazy_load_image' ), 10, 2 );

		$post_thumbnail_id = get_post_thumbnail_id( $id );
		$image_size        = wp_get_attachment_image_src( $post_thumbnail_id, $size );
		$image             = get_post( $post_thumbnail_id );
		$percentage        = ! empty( $image_size[1] ) ? round( $image_size[2] / $image_size[1] * 100, 3 ) : '';

		$thumbnail  = '<div class="thumbnail-container animate-lazy" style="padding-bottom:' . $percentage . '%">';
		$thumbnail .= get_the_post_thumbnail( $id, $size );
		$thumbnail .= '</div>';

		if ( ! empty( $image->post_excerpt ) ) {
			$thumbnail .= '<p class="wp-caption-text">' . $image->post_excerpt . '</p>';
		}

		remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'lazy_load_image' ), 10 );

		return $thumbnail;
	}

	/**
	 * Generate image thumbnail HTML tag
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function image_thumbnail( $id, $size ) {
		$image_size = Image::get_image_sizes( $size );

		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'lazy_load_image' ), 10, 2 );

		$additional_class = '';
		if ( ! has_post_thumbnail( $id ) ) {
			$additional_class = 'no_thumbnail';
		}

		$thumbnail  = '<div class="thumbnail-container animate-lazy ' . $additional_class . ' size-' . $image_size['dimension'] . '">';
		$thumbnail .= get_the_post_thumbnail( $id, $size );
		$thumbnail .= '</div>';

		remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'lazy_load_image' ), 10 );
		return $thumbnail;
	}

	/**
	 * Generate Image Tag for Owl Carousel
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function owl_single_image( $id, $size ) {
		$image_size = Image::get_image_sizes( $size );

		$thumbnail  = '<div class="thumbnail-container size-' . $image_size['dimension'] . '">';
		$thumbnail .= wp_get_attachment_image( $id, $size );
		$thumbnail .= '</div>';

		return $thumbnail;
	}

	/**
	 * Generate Image Tag for Lazy Load Owl Carousel
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function owl_lazy_single_image( $id, $size ) {
		$image_size = Image::get_image_sizes( $size );

		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'owl_lazy_attr' ), 10, 2 );

		$thumbnail  = '<div class="thumbnail-container size-' . $image_size['dimension'] . '">';
		$thumbnail .= wp_get_attachment_image( $id, $size );
		$thumbnail .= '</div>';

		remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'owl_lazy_attr' ), 10 );

		return $thumbnail;
	}

	/**
	 * Generate Image Tag for Lazy Load Carousel
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function owl_lazy_image( $id, $size ) {
		$image_size = Image::get_image_sizes( $size );
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'owl_lazy_attr' ), 10, 2 );

		$thumbnail  = '<div class="thumbnail-container size-' . $image_size['dimension'] . '">';
		$thumbnail .= get_the_post_thumbnail( $id, $size );
		$thumbnail .= '</div>';

		remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'owl_lazy_attr' ), 10 );

		return $thumbnail;
	}

	/**
	 * HTML tag for Single image.
	 *
	 * @param string $img_src URL of image.
	 * @param string $img_title Title of image.
	 * @param string $img_size Size of image.
	 *
	 * @return string
	 */
	public function single_image( $img_src, $img_title, $img_size ) {
		$img_tag = "<img class='lazyload' src='{$this->get_empty_image()}' data-expand='" . $this->expand_range . "' alt='{$img_title}' data-src='{$img_src}' title='{$img_title}'>";

		if ( $img_size ) {
			return "<div class='thumbnail-container animate-lazy size-{$img_size}'>{$img_tag}</div>";
		} else {
			return $img_tag;
		}
	}

	/**
	 * Attribute for lazy load image
	 *
	 * @param array    $attr Image attribute.
	 * @param \WP_Post $image Image instance.
	 *
	 * @return mixed
	 */
	public function lazy_load_image( $attr, $image ) {
		$attr['class']       = $attr['class'] . ' lazyload';
		$attr['data-src']    = $attr['src'];
		$attr['data-sizes']  = 'auto';
		$attr['data-srcset'] = isset( $attr['srcset'] ) ? $attr['srcset'] : '';
		$attr['data-expand'] = $this->expand_range;
		$attr['src']         = $this->get_empty_image();

		if ( empty( $attr['alt'] ) && ! empty( $image->post_parent ) ) {
			$attr['alt'] = wp_strip_all_tags( get_the_title( $image->post_parent ) );
		}

		// Need to fix issues on ajax request image not showing.
		if ( wp_doing_ajax() ) {
			$attr['data-animate'] = 0;
		}

		unset( $attr['srcset'] );
		unset( $attr['sizes'] );

		return $attr;
	}

	/**
	 * Owl image lazy attribute
	 *
	 * @param array    $attr Image attribute.
	 * @param \WP_Post $image Image instance.
	 *
	 * @return mixed
	 */
	public function owl_lazy_attr( $attr, $image ) {
		$attr['class']    = $attr['class'] . ' owl-lazy';
		$attr['data-src'] = $attr['src'];
		$attr['src']      = $this->get_empty_image();

		if ( empty( $attr['alt'] ) && ! empty( $image->post_parent ) ) {
			$attr['alt'] = wp_strip_all_tags( get_the_title( $image->post_parent ) );
		}

		unset( $attr['srcset'] );
		unset( $attr['sizes'] );

		return $attr;
	}

	/**
	 * Empty Image
	 *
	 * @return string
	 */
	public function get_empty_image() {
		return JEG_ELEMENT_URL . '/assets/img/jeg-empty.png';
	}
}
