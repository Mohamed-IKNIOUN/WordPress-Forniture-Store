<?php
/**
 * Jeg News Element Widget Abstract
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-news-element
 */

namespace Jeg\Element\Wpbakery;

/**
 * Class Widget_Abstract
 *
 * @package Jeg\Element\Widget
 */
class Wpbakery_Integration {
	/**
	 * Wpbakery_Integration constructor.
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'integrate_vc' ) );
		add_action( 'init', array( $this, 'additional_control' ), 98 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_script' ) );
		add_action( 'jeg_element_additional_class', array( $this, 'element_additional_class' ), null, 4 );

		add_filter( 'jeg_get_shortcode_width', array( $this, 'calculate_shortcode_width' ), null, 3 );
		add_filter( 'jeg_shortcode_reset_width', array( $this, 'reset_shortcode_width' ), null, 2 );
		add_filter( 'jeg_load_element_option', array( $this, 'flag_load_element_option' ) );
	}

	/**
	 * Flag Module
	 *
	 * @param boolean $flag Flag for load element option.
	 *
	 * @return bool
	 */
	public function flag_load_element_option( $flag ) {
		if ( ( isset( $_GET['vc_editable'] ) && $_GET['vc_editable'] ) || ( isset( $_GET['vc_action'] ) && $_GET['vc_action'] === 'vc_inline' ) ) {
			return true;
		}

		return $flag;
	}

	/**
	 * Reset shortcode width
	 *
	 * @param boolean $flag Flag if we will reset the width.
	 * @param string  $tag Shortcode name.
	 *
	 * @return boolean
	 */
	public function reset_shortcode_width( $flag, $tag ) {
		if ( 'vc_column' === $tag || 'vc_column_inner' === $tag ) {
			return true;
		}

		return $flag;
	}

	/**
	 * Calculate width for every shortcode.
	 *
	 * @param int          $width Current width for shortcode.
	 * @param string       $tag Shortcode name.
	 * @param array|string $attr Shortcode attributes array or empty string.
	 *
	 * @return integer
	 */
	public function calculate_shortcode_width( $width, $tag, $attr ) {
		if ( 'vc_column' === $tag || 'vc_column_inner' === $tag ) {
			$width = isset( $attr['width'] ) ? $attr['width'] : '1/1';
			$width = $this->calculate_width( $width );

			return $width;
		}

		return $width;
	}

	/**
	 * Parse string and get attribute of column width
	 *
	 * @param string $width shortcode width format.
	 *
	 * @return int
	 */
	public function calculate_width( $width ) {
		preg_match( '/(\d+)\/(\d+)/', $width, $matches );

		if ( ! empty( $matches ) ) {
			$part_x = (int) $matches[1];
			$part_y = (int) $matches[2];
			if ( $part_x > 0 && $part_y > 0 ) {
				$value = ceil( $part_x / $part_y * 12 );
				if ( $value > 0 && $value <= 12 ) {
					$width = $value;
				}
			}
		}

		return (int) $width;
	}

	/**
	 * Additional class for each element
	 *
	 * @param array   $classes Collection of classes for element.
	 * @param string  $id ID / Shortcode Element.
	 * @param integer $post_id Post ID of current Page.
	 * @param array   $attribute Attribute.
	 *
	 * @return array
	 */
	public function element_additional_class( $classes, $id, $post_id, $attribute ) {
		if ( isset( $attribute['css'] ) ) {
			$css_exploded = explode( '{', $attribute['css'] );
			$class        = $css_exploded[0];
			$classes[]    = substr( $class, 1 );
		}

		$classes[] = isset( $attribute['boxed'] ) && $attribute['boxed'] ? 'jeg_pb_boxed' : '';
		$classes[] = isset( $attribute['boxed_shadow'] ) && $attribute['boxed_shadow'] ? 'jeg_pb_boxed_shadow' : '';

		return $classes;
	}

	/**
	 * Enqueue admin script
	 */
	public function admin_script() {
		wp_enqueue_style( 'global-admin', JEG_ELEMENT_URL . '/assets/css/vc-admin.css', null, JEG_ELEMENT_VERSION );
		wp_enqueue_style( 'selectize', JEG_ELEMENT_URL . '/assets/css/selectize.default.css', null, '0.14.0' );
		wp_enqueue_script( 'jquery-ui-spinner' );
		wp_enqueue_script( 'selectize', JEG_ELEMENT_URL . '/assets/js/selectize.min.js', null, '0.14.0', true );
	}

	/**
	 * Set WP Bakery Page Builder as theme
	 */
	public function integrate_vc() {
		if ( function_exists( 'vc_set_as_theme' ) ) {
			vc_set_as_theme();
		}
	}

	/**
	 * Additional Control for WPBakery Page builder
	 */
	public function additional_control() {
		if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
			$params = array(
				array( 'alert', array( $this, 'vc_alert' ) ),
				array( 'select', array( $this, 'vc_select' ), JEG_ELEMENT_URL . '/assets/js/vc/vc.script.js' ),
				array( 'number', array( $this, 'vc_number' ), JEG_ELEMENT_URL . '/assets/js/vc/vc.script.js' ),
				array( 'checkblock', array( $this, 'vc_checkblock' ), JEG_ELEMENT_URL . '/assets/js/vc/vc.script.js' ),
				array( 'radioimage', array( $this, 'vc_radioimage' ), JEG_ELEMENT_URL . '/assets/js/vc/vc.script.js' ),
				array( 'slider', array( $this, 'vc_slider' ), JEG_ELEMENT_URL . '/assets/js/vc/vc.script.js' ),
				array(
					'attach_file',
					array( $this, 'vc_attach_file' ),
					JEG_ELEMENT_URL . '/assets/js/vc/vc.script.js',
				),
			);

			foreach ( $params as $param ) {
				call_user_func_array( 'vc_add_shortcode_param', $param );
			}
		}
	}

	/**
	 * VC ALERT
	 *
	 * @param array $settings Array of setting.
	 *
	 * @return string
	 */
	public function vc_alert( $settings ) {
		return "<div class=\"alert-wrapper\" data-field=\"{$settings['std']}\">
	        <input name='{$settings['param_name']}' class='wpb_vc_param_value {$settings['param_name']} {$settings['type']}_field' type='hidden'/>
	        <div class=\"alert-element alert-{$settings['std']}\">
	            <strong>{$settings['heading']}</strong>
	            <div class=\"alert-description\">{$settings['description']}</div>
	        </div>
	    </div>";
	}

	/**
	 * VC Select, Handle both single & multiple select. Also handle Ajax Loaded Option.
	 *
	 * @param array $settings Array of setting.
	 * @param mixed $value Value of element.
	 *
	 * @return string
	 */
	public function vc_select( $settings, $value ) {
		ob_start();

		$slug = isset( $settings['slug'] ) ? $settings['slug'] : '';

		if ( isset( $settings['value'] ) ) {
			$options = array();
			foreach ( $settings['value'] as $key => $val ) {
				$options[] = array(
					'value' => $val,
					'text'  => $key,
				);
			}
		} else {
			$options = call_user_func_array( $settings['options'], array( $value, $slug ) );
		}

		?>
		<div class="vc-select-wrapper" data-ajax="<?php echo esc_attr( $settings['ajax'] ); ?>"
			data-multiple="<?php echo esc_attr( $settings['multiple'] ); ?>"
			data-slug="<?php echo esc_attr( $slug ); ?>"
			data-nonce="<?php echo esc_attr( $settings['nonce'] ); ?>">
			<?php if ( $settings['multiple'] > 1 ) { ?>
			<input
				class='wpb_vc_param_value wpb-input input-sortable multiselect_field <?php echo esc_html( $settings['param_name'] ); ?> <?php echo esc_html( $settings['type'] ); ?>_field'
				type="text" name="<?php echo esc_attr( $settings['param_name'] ); ?>"
				value="<?php echo esc_attr( $value ); ?>"/>
			<div class="data-option" style="display: none;">
				<?php echo wp_json_encode( $options ); ?>
			</div>
			<?php } else { ?>
				<select
						class='wpb_vc_param_value wpb-input input-sortable <?php echo esc_html( $settings['param_name'] ); ?> <?php echo esc_html( $settings['type'] ); ?>_field'
						name="<?php echo esc_attr( $settings['param_name'] ); ?>">
					<option value=''></option>
					<?php
					foreach ( $options as $option ) {
						$select = ( $option['value'] === $value ) ? 'selected' : '';
						?>
						<option
								value='<?php echo esc_attr( $option['value'] ); ?>' <?php echo esc_attr( $select ); ?>><?php echo esc_html( $option['text'] ); ?></option>
						<?php
					}
					?>
				</select>
			<?php } ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * VC NUMBER
	 *
	 * @param array $settings Array of setting.
	 * @param mixed $value Value of element.
	 *
	 * @return string
	 */
	public function vc_number( $settings, $value ) {
		return "<div class='number-input-wrapper'>
                <input name='{$settings['param_name']}'
                    class='wpb_vc_param_value wpb-input {$settings['param_name']} {$settings['type']}_field'
                    type='text'
                    min='{$settings['min']}'
                    max='{$settings['max']}'
                    step='{$settings['step']}'
                    value='{$value}'/>
            </div>";
	}

	/**
	 * Check Block
	 *
	 * @param array $settings Array of setting.
	 * @param mixed $value Value of element.
	 *
	 * @return string
	 */
	public function vc_checkblock( $settings, $value ) {
		$option   = '';
		$valuearr = explode( ',', $value );

		$option .= "<input name='" . $settings['param_name'] . "' class='wpb_vc_param_value wpb-input " . $settings['param_name'] . ' ' . $settings['type'] . "_field' type='hidden' value='" . $value . "' />";
		foreach ( $settings['value'] as $key => $val ) {
			$checked = in_array( $val, $valuearr, true ) ? 'checked="checked"' : '';
			$option .= '<label><input ' . $checked . ' class="checkblock" value="' . $val . '" type="checkbox">' . $key . '</label>';
		}

		return '<div class="wp-tab-panel vc_checkblock">
                <div>' . $option . '</div>
            </div>';
	}

	/**
	 * VC Radio Image
	 *
	 * @param array $settings Array of setting.
	 * @param mixed $value Value of element.
	 *
	 * @return string
	 */
	public function vc_radioimage( $settings, $value ) {
		$radio_option = '';
		$radio_input  = "<input type='hidden' name='{$settings['param_name']}' value='{$value}' class='wpb_vc_param_value wpb-input{$settings['param_name']}'/>";

		foreach ( $settings['value'] as $key => $val ) {
			$checked       = ( $value === $val ) ? 'checked' : '';
			$radio_option .=
				"<label>
                <input {$checked} type='radio' name='{$settings['param_name']}_field' value='{$val}' class='{$settings['type']}_field'/>
                <img src='{$key}' class='wpb_vc_radio_image'/>
            </label>";
		}

		return "<div class='radio-image-wrapper'>
                {$radio_input}
                {$radio_option}
            </div>";
	}


	/**
	 * VC Slider
	 *
	 * @param array $settings Array of setting.
	 * @param mixed $value Value of element.
	 *
	 * @return string
	 */
	public function vc_slider( $settings, $value ) {
		return "<div class='slider-input-wrapper'>
                <input name='{$settings['param_name']}'
                    class='wpb_vc_param_value wpb-input {$settings['param_name']} {$settings['type']}_field'
                    type='range'
                    min='{$settings['min']}'
                    max='{$settings['max']}'
                    step='{$settings['step']}'
                    value='{$value}'
                    data-reset_value='{$value}'/>
                <div class=\"jeg_range_value\">
                    <span class=\"value\">{$value}</span>
                </div>
                <div class=\"jeg-slider-reset\">
                  <span class=\"dashicons dashicons-image-rotate\"></span>
                </div>
            </div>";
	}


	/**
	 * VC Attach File
	 *
	 * @param array $settings Array of setting.
	 * @param mixed $value Value of element.
	 *
	 * @return string
	 */
	public function vc_attach_file( $settings, $value ) {
		return "<div class='input-uploadfile'>
                <input name='" . $settings['param_name'] . "' class='wpb_vc_param_value wpb-input" . $settings['param_name'] . ' ' . $settings['type'] . "_field' type='text' value='$value' />
                <div class='buttons'>
                    <input type='button' value='" . esc_html__( 'Select File', 'jeg-elementor-kit' ) . "' class='selectfileimage btn'/>
                </div>
            </div>";
	}

}
