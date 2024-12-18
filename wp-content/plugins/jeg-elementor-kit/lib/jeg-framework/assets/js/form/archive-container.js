(function ($, api) {
    "use strict";
    /**
    * Jeg Archive Builder
    */
   $(document).on('ready', function() {
        api.archivecontainer = new api.Values({defaultConstructor: api.ArchiveContainer});

        /**
         * Archive container class
         */
        api.ArchiveContainer = api.BaseContainer.extend({
            /**
             * Set Container Holder
             */
            setContainerHolder: function() {
                this.containerHolder = api.archivecontainer;
            },
        });

        window.jeg = window.jeg || {};
        jeg.archive = {};

        if ( 'undefined' !== typeof jeg && undefined !== jeg.archive && undefined !== window.jegWidgetData) {
            var jegWidgetData = JSON.parse(window.jegWidgetData)
            var parent = $("#" + jegWidgetData.id);
            api.archivecontainer(jegWidgetData.id, new api.ArchiveContainer( jegWidgetData.id, parent, jegWidgetData.data));
        }
    })
})(jQuery, wp.customize);
