(function($, api){
  "use strict";

  api.controlConstructor['jeg-textarea'] = api.controlConstructor.default.extend({
    ready: function() {
      var control = this;

      this.container.on( 'change click keyup paste', 'textarea', function() {
        control.setting.set( $( this ).val() );
      });
    }
  });
})(jQuery, wp.customize);
