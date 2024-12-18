<?php
/**
 * Dashboard Elements Template
 *
 * @author Jegtheme
 * @since 1.9.0
 * @package jeg-element
 */

$config   = get_option( 'jkit_elements_enable', array() );
$elements = Jeg\Elementor_Kit\Elements\Element::instance()->list_elements();
?>

<div class="jkit-dashboard-body-wrap">
	<form method="POST" id="jkit-elements-enable-form">
		<div id="jkit-form-content">
			<div class="elements-global-control">
				<button type="button" class="jkit-button enable-all"> 
					<?php echo esc_html__( 'Enable All', 'jeg-elementor-kit' ); ?>
				</button>
				<button type="button" class="jkit-button disable-all"> 
					<?php echo esc_html__( 'Disable All', 'jeg-elementor-kit' ); ?>
				</button>
			</div>
			<div class="elements-control-container">
				<?php
				foreach ( $elements as $element ) {
					$item_key  = 'jkit_' . strtolower( $element );
					$item_name = str_replace( '_', ' ', $element );
					$checked   = ! isset( $config[ $item_key ] ) || filter_var( $config[ $item_key ], FILTER_VALIDATE_BOOLEAN ) ? 'checked' : '';
					?>
					<div class="element-checkbox-option">
						<div class="element-info">
							<i class="<?php echo esc_attr( $item_key ); ?>"></i>
							<p class="element-title"><?php echo esc_attr( $item_name ); ?></p>
						</div>
						<input 
							class="element-toggle" 
							name="element-toggle" 
							type="checkbox" 
							data-element-key="<?php echo esc_attr( $item_key ); ?>"
							<?php echo esc_attr( $checked ); ?>>
						<span class="switch"></span>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<div class="jkit-form-submit jkit-input-wraper">
			<button type="submit" class="jkit-submit"> 
				<i aria-hidden="true" class="fa fa-save"></i> <?php echo esc_html__( 'Save Changes', 'jeg-elementor-kit' ); ?>
			</button>
		</div>
	</form>
</div>
