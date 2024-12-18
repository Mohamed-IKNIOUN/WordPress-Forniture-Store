(function($, api){
    "use strict";

	api.controlConstructor['jeg-slider'] = api.controlConstructor.default.extend({
		ready: function() {
			var control = this,
				value,
				thisInput,
				inputDefault,
				$range = $('input[type=range]'),
				$reset = $('.jeg-slider-reset');

			// Update the text value
			$range.on( 'mousedown', function() {
				$( this ).mousemove( function() {
					value = $( this ).val();
					$( this ).closest( 'label' ).find( '.jeg_range_value .value' ).text( value );
				});
			});

			$range.on( 'click', function() {
				value = $( this ).val();
				$( this ).closest( 'label' ).find( '.jeg_range_value .value' ).text( value );
			});

			// Handle the reset button
			$reset.on( 'click', function() {
				thisInput    = $( this ).closest( 'label' ).find( 'input' );
				inputDefault = thisInput.data( 'reset_value' );
				thisInput.val( inputDefault );
				thisInput.change();
				$( this ).closest( 'label' ).find( '.jeg_range_value .value' ).text( inputDefault );
			});

			// Save changes.
			this.container.on( 'change', 'input', function() {
				control.setting.set( $( this ).val() );
			});
		}
	});
})(jQuery, wp.customize);
