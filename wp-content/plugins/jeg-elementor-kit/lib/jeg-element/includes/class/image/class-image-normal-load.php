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
class Image_Normal_Load implements Image_Interface {

	/**
	 * Generate Image HTML tag without predefine size.
	 *
	 * @param integer $id Image ID.
	 * @param string  $size Size of Image.
	 *
	 * @return string
	 */
	public function single_image_unwrap( $id, $size ) {
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'normal_load_image' ), 10, 2 );

		$image_size = wp_get_attachment_image_src( $id, $size );
		$image      = get_post( $id );
		$percentage = round( $image_size[2] / $image_size[1] * 100, 3 );

		$thumbnail  = '<div class="thumbnail-container" style="padding-bottom:"' . $percentage . '"%">';
		$thumbnail .= wp_get_attachment_image( $id, $size );
		$thumbnail .= '</div>';

		if ( ! empty( $image->post_excerpt ) ) {
			$thumbnail .= '<p class="wp-caption-text">' . $image->post_excerpt . '</p>';
		}

		remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'normal_load_image' ), 10 );

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
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'normal_load_image' ), 10, 2 );

		$post_thumbnail_id = get_post_thumbnail_id( $id );
		$image_size        = wp_get_attachment_image_src( $post_thumbnail_id, $size );
		$image             = get_post( $post_thumbnail_id );

		if ( $image_size[1] > 0 ) {
			$percentage = round( $image_size[2] / $image_size[1] * 100, 3 );
		} else {
			$percentage = $image_size[2];
		}

		$thumbnail  = '<div class="thumbnail-container" style="padding-bottom:' . $percentage . '%">';
		$thumbnail .= get_the_post_thumbnail( $id, $size );
		$thumbnail .= '</div>';

		if ( ! empty( $image->post_excerpt ) ) {
			$thumbnail .= '<p class="wp-caption-text">' . $image->post_excerpt . '</p>';
		}

		remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'normal_load_image' ), 10 );

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
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'normal_load_image' ), 10, 2 );

		$image_size = Image::get_image_sizes( $size );

		$additional_class = '';
		if ( ! has_post_thumbnail( $id ) ) {
			$additional_class = 'no_thumbnail';
		}

		$thumbnail  = '<div class="thumbnail-container ' . $additional_class . ' size-' . $image_size['dimension'] . '">';
		$thumbnail .= get_the_post_thumbnail( $id, $size );
		$thumbnail .= '</div>';

		remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'normal_load_image' ), 10 );

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
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'normal_load_image' ), 10, 2 );

		$image_size = Image::get_image_sizes( $size );

		$thumbnail  = '<div class="thumbnail-container size-' . $image_size['dimension'] . '">';
		$thumbnail .= wp_get_attachment_image( $id, $size );
		$thumbnail .= '</div>';

		remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'normal_load_image' ), 10 );

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
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'normal_load_image' ), 10, 2 );

		$image_size = Image::get_image_sizes( $size );

		$thumbnail  = '<div class="thumbnail-container size-' . $image_size['dimension'] . '">';
		$thumbnail .= wp_get_attachment_image( $id, $size );
		$thumbnail .= '</div>';

		remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'normal_load_image' ), 10 );

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
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'normal_load_image' ), 10, 2 );

		$image_size = Image::get_image_sizes( $size );

		$thumbnail  = '<div class="thumbnail-container size-' . $image_size['dimension'] . '">';
		$thumbnail .= get_the_post_thumbnail( $id, $size );
		$thumbnail .= '</div>';

		remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'normal_load_image' ), 10 );

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
		$img_tag = "<img src='{$img_src}' alt='{$img_title}' title='{$img_title}'>";

		if ( $img_size ) {
			return "<div class='thumbnail-container size-{$img_size}'>{$img_tag}</div>";
		} else {
			return $img_tag;
		}
	}

	/**
	 * Attribute for normal image
	 *
	 * @param array    $attr Image attribute.
	 * @param \WP_Post $image Image instance.
	 *
	 * @return mixed
	 */
	public function normal_load_image( $attr, $image ) {
		if ( empty( $attr['alt'] ) && ! empty( $image->post_excerpt ) ) {
			$attr['alt'] = wp_strip_all_tags( $image->post_excerpt );
		}

		return $attr;
	}
}
