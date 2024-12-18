( function($, api) {
  "use strict";
  
  api.sectionConstructor.default = api.Section.extend({
    expand : function(params)
    {
      var section = this.container[1];
      
      if(!$(section).hasClass('jeg-section-loaded'))
      {
        $(section).addClass('jeg-section-loaded').trigger('jeg-open-section');
      }
      
      api.Section.prototype.expand.call(this, params);
    }
  });
  
  
})( jQuery, wp.customize );
