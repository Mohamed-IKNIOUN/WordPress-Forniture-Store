<?php
/**
 * Customizer Form Widget
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */

namespace Jeg\Form;

use Jeg\Util\Sanitize;

/**
 * Form Widget Class
 */
class Form_Meta_Box {

	/**
	 * Form Metabox Instance Pool
	 *
	 * @var array
	 */
	public static $pool = array();

	/**
	 * List of Segment
	 *
	 * @var array Array of segment.
	 */
	private $segments;

	/**
	 * List of Fields on this meta_box
	 *
	 * @var array Array of Field.
	 */
	private $fields;

	/**
	 * Type of Metabox Container
	 * Option can be single | multiple
	 *
	 * @var string Type of Metabox container.
	 */
	private $type;

	/**
	 * Post type for meta_box
	 *
	 * @var array Array of post type registered on this meta_box.
	 */
	private $post_type = 'single';

	/**
	 * Metabox Identifier
	 *
	 * @var string Unique id for this meta_box.
	 */
	private $meta_box_id;

	/**
	 * Metabox Title
	 *
	 * @var string Metabox title.
	 */
	private $meta_box_title;

	/**
	 * Metabox Context
	 * side, normal, advanced
	 *
	 * @var string
	 */
	private $context = 'normal';

	/**
	 * Metabox Priority
	 * high, sorted, core, default, low
	 *
	 * @var string Priority of this meta_box
	 */
	private $priority = 'high';

	/**
	 * Hold metabox value.
	 *
	 * @var mixed Metabox value.
	 */
	private $value;

	/**
	 * Form_Metabox constructor.
	 *
	 * @param array $data Array of Metabox Field & Setting.
	 */
	public function __construct( $data ) {
		$this->meta_box_id    = $data['id'];
		$this->post_type      = $data['post_type'];
		$this->meta_box_title = $data['title'];
		$this->type           = isset( $data['type'] ) ? $data['type'] : $this->type;
		$this->context        = isset( $data['context'] ) ? $data['context'] : $this->context;
		$this->priority       = isset( $data['priority'] ) ? $data['priority'] : $this->priority;
		$this->segments       = isset( $data['segments'] ) ? $data['segments'] : array();
		$this->fields         = isset( $data['fields'] ) ? $data['fields'] : array();

		$this->prepare_fields();
		$this->prepare_segments();
		$this->hook();

		self::$pool[ $this->meta_box_id ] = $this;
	}

	/**
	 * Register hook for meta_box
	 */
	public function hook() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ), 99 );
		add_action( 'save_post', array( $this, 'save' ) );
	}


	/**
	 * Handle Save Event
	 *
	 * @param int $post_id Post ID.
	 */
	public function save( $post_id ) {
		if ( current_user_can( 'edit_posts', 'edit_pages' ) && isset( $_POST[ $this->meta_box_id ] ) && wp_verify_nonce( sanitize_key( $_POST[ $this->meta_box_id ]['nonce'] ), $this->meta_box_id ) ) {
			$data = $this->sanitize_value( wp_unslash( $_POST[ $this->meta_box_id ] ) );

			if ( is_null( $data ) ) {
				delete_post_meta( $post_id, $this->meta_box_id );
			} else {
				update_post_meta( $post_id, $this->meta_box_id, $data );
			}

			foreach ( $this->fields as $key => $field ) {
				if ( $field['single_meta'] ) {
					if ( is_null( $data[ $key ] ) ) {
						delete_post_meta( $post_id, $key );
					} else {
						update_post_meta( $post_id, $key, $data[ $key ] );
					}
				}
			}
		}
	}

	/**
	 * Recursively Sanitize Input Field
	 *
	 * @param mixed $values Value to be sanitized.
	 *
	 * @return mixed
	 */
	protected function sanitize_value( $values ) {
		foreach ( $values as $key => $value ) {
			if ( isset( $this->fields[ $key ] ) && $this->fields[ $key ]['sanitize'] ) {
				$sanitize = array( Sanitize::get_instance(), $this->fields[ $key ]['sanitize'] );

				if ( is_callable( $sanitize ) ) {
					$value = call_user_func( $sanitize, $value );
				} else {
					$value = '';
				}
			} else {
				if ( jeg_is_json( $value ) ) {
					$value = json_decode( urldecode( $value ) );
				}

				if ( is_object( $value ) ) {
					$value = (array) $value;
				}

				if ( is_array( $value ) ) {
					$values[ $key ] = jeg_sanitize_array( $value );
				} else {
					$values[ $key ] = sanitize_text_field( $value );
				}
			}
		}

		return $values;
	}

	/**
	 * Used to get the current post id.
	 *
	 * @return    int post ID
	 */
	public static function get_post_id() {
		global $post;

		$p_post_id = isset( $_POST['post_ID'] ) ? (int) sanitize_text_field( $_POST['post_ID'] ) : null;
		$g_post_id = isset( $_GET['post'] ) ? (int) sanitize_text_field( $_GET['post'] ) : null;
		$post_id   = $g_post_id ? $g_post_id : $p_post_id;
		$post_id   = isset( $post->ID ) ? $post->ID : $post_id;

		if ( isset( $post_id ) ) {
			return (int) $post_id;
		}

		return null;
	}

	/**
	 * Get value for meta box
	 *
	 * @param null $post_id Post ID.
	 *
	 * @return mixed
	 */
	public function get_values( $post_id = null ) {
		if ( ! is_numeric( $post_id ) ) {
			$post_id = self::get_post_id();
		}

		if ( ! $this->value ) {
			$this->value = get_post_meta( $post_id, $this->meta_box_id, true );
		}

		return $this->value;
	}

	/**
	 * Get value of input
	 *
	 * @param string $name Name of value need to be retrieved.
	 * @param mixed  $default Default value of this metabox.
	 *
	 * @return mixed
	 */
	public function get_value( $name, $default ) {
		$this->get_values();

		if ( isset( $this->value[ $name ] ) ) {
			return $this->value[ $name ];
		} else {
			return $default;
		}
	}

	/**
	 * Get field option
	 *
	 * @param array $field Array of Fields.
	 * @param mixed $value Value of this field.
	 *
	 * @return array
	 */
	public function get_field_option( $field, $value ) {
		$option = array();

		if ( isset( $field['options'] ) ) {
			if ( is_callable( $field['options'] ) ) {
				return call_user_func_array( $field['options'], array( $value ) );
			} elseif ( is_array( $field['options'] ) ) {
				return $field['options'];
			}
		}

		return $option;
	}

	/**
	 * Prepare segments for processing
	 */
	public function prepare_segments() {
		foreach ( $this->segments as $key => $section ) {
			$this->segments[ $key ]             = array();
			$this->segments[ $key ]['id']       = $key;
			$this->segments[ $key ]['name']     = isset( $section['name'] ) ? $section['name'] : '';
			$this->segments[ $key ]['priority'] = isset( $section['priority'] ) ? $section['priority'] : 10;
			$this->segments[ $key ]['context']  = $this->context;
		}
	}

	/**
	 * Prepare field for processing
	 */
	public function prepare_fields() {
		foreach ( $this->fields as $key => $field ) {
			$default = isset( $field['default'] ) ? $field['default'] : '';
			$value   = $this->get_value( $key, $default );
			$option  = $this->get_field_option( $field, $value );

			$this->fields[ $key ]                = array();
			$this->fields[ $key ]['id']          = $key;
			$this->fields[ $key ]['fieldID']     = $this->meta_box_id . '_' . $key;
			$this->fields[ $key ]['fieldName']   = $this->meta_box_id . '[' . $key . ']';
			$this->fields[ $key ]['default']     = $default;
			$this->fields[ $key ]['value']       = $value;
			$this->fields[ $key ]['options']     = $option;
			$this->fields[ $key ]['type']        = isset( $field['type'] ) ? $field['type'] : 'text';
			$this->fields[ $key ]['segment']     = isset( $field['segment'] ) ? $field['segment'] : '';
			$this->fields[ $key ]['title']       = isset( $field['title'] ) ? $field['title'] : '';
			$this->fields[ $key ]['description'] = isset( $field['description'] ) ? $field['description'] : '';
			$this->fields[ $key ]['fields']      = isset( $field['fields'] ) ? $field['fields'] : array();
			$this->fields[ $key ]['row_label']   = isset( $field['row_label'] ) ? $field['row_label'] : array();
			$this->fields[ $key ]['dependency']  = isset( $field['dependency'] ) ? $field['dependency'] : array();
			$this->fields[ $key ]['priority']    = isset( $field['priority'] ) ? $field['priority'] : 10;
			$this->fields[ $key ]['multiple']    = isset( $field['multiple'] ) ? $field['multiple'] : 1;
			$this->fields[ $key ]['choices']     = isset( $field['choices'] ) ? $field['choices'] : array();
			$this->fields[ $key ]['ajax']        = isset( $field['ajax'] ) ? $field['ajax'] : '';
			$this->fields[ $key ]['nonce']       = isset( $field['nonce'] ) ? $field['nonce'] : '';
			$this->fields[ $key ]['sanitize']    = isset( $field['sanitize'] ) ? $field['sanitize'] : '';
			$this->fields[ $key ]['mime_type']   = isset( $field['mime_type'] ) ? $field['mime_type'] : '';
			$this->fields[ $key ]['single_meta'] = isset( $field['single_meta'] ) ? $field['single_meta'] : false;

			if ( 'image' === $field['type'] ) {
				if ( 1 < $this->fields[ $key ]['multiple'] && is_array( $value ) ) {
					foreach ( $value as $item ) {
						$image = wp_get_attachment_image_src( $item, 'thumbnail' );
						if ( isset( $image[0] ) ) {
							$this->fields[ $key ]['imageUrl'][] = array(
								'id'  => $item,
								'url' => $image[0],
							);
						}
					}
				} else {
					$image = wp_get_attachment_image_src( $value, 'full' );
					if ( isset( $image[0] ) ) {
						$this->fields[ $key ]['imageUrl'] = $image[0];
					}
				}
			}

			if ( 'upload' === $field['type'] ) {
				$file = basename( wp_get_attachment_url( $value ) );

				$this->fields[ $key ]['filename'] = $file;
			}

			if ( 'repeater' === $field['type'] ) {
				if ( is_array( $value ) ) {
					$temporary_value = array();
					foreach ( $value as $id => $val ) {
						$temporary = array();
						foreach ( $field['fields'] as $field_key => $field_detail ) {
							$temporary[ $field_key ] = $val[ $field_key ];

							if ( 'image' === $field_detail['type'] ) {
								$image = wp_get_attachment_image_src( $val[ $field_key ], 'full' );

								$temporary[ $field_key ] = array(
									'url' => $image[0],
									'id'  => $val[ $field_key ],
								);
							}

							if ( 'upload' === $field_detail['type'] ) {
								$file = basename( wp_get_attachment_url( $val[ $field_key ] ) );

								$temporary[ $field_key ] = array(
									'filename' => $file,
									'id'       => $val[ $field_key ],
								);
							}
						}

						$temporary_value[ $id ] = $temporary;
					}

					$this->fields[ $key ]['value'] = $temporary_value;
				}
			}
		}
	}


	/**
	 * Enqueue Script
	 */
	public function enqueue_script() {
		wp_enqueue_media();
		wp_enqueue_script( 'jeg-form-meta-box-script', JEG_URL . '/assets/js/form/meta-box-container.js', array( 'jeg-form-builder-script' ), jeg_get_version(), true );
	}

	/**
	 * Initialize meta_box
	 */
	public function init() {
		add_meta_box(
			$this->meta_box_id . '_meta_box',
			$this->meta_box_title,
			array(
				$this,
				'meta_box',
			),
			$this->post_type,
			$this->context,
			$this->priority
		);
	}

	/**
	 * Render meta_box
	 */
	public function meta_box() {
		if ( 'normal' === $this->type ) {
			?>
			<div class="meta_box-holder" id="<?php echo esc_html( $this->meta_box_id ); ?>"></div>
			<?php
			$this->meta_box_script();
		} elseif ( 'tabbed' === $this->type ) {
			?>
			<div class="tabbed-container" id="<?php echo esc_html( $this->meta_box_id ); ?>">
				<ul class="tabbed-list"></ul>
				<div class="tabbed-body"></div>
			</div>
			<?php
			$this->meta_box_script();
		}
	}

	/**
	 * Render meta_box script
	 */
	public function meta_box_script() {
		wp_localize_script(
			'jeg-form-meta-box-script',
			'jegMetaboxData',
			array(
				wp_json_encode(
					array(
						'id'   => $this->meta_box_id,
						'type' => $this->type,
						'data' => array(
							'segments' => $this->segments,
							'fields'   => $this->fields,
						),
					)
				),
			)
		);
		?>
		<input type="hidden" name="<?php echo esc_html( $this->meta_box_id . '[nonce]' ); ?>" value="<?php echo esc_attr( wp_create_nonce( $this->meta_box_id ) ); ?>">
		<?php
	}
}
