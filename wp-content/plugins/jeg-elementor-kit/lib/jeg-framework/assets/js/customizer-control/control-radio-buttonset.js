(function($, api){
    "use strict";

	api.controlConstructor['jeg-radio-buttonset'] = api.controlConstructor.default.extend({
		ready: function() {
			var control = this;

			// Change the value
			this.container.on( 'click', 'input', function() {
				control.setting.set( $( this ).val() );
			});
		}
	});
})(jQuery, wp.customize);
