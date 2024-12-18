(function ($, api) {
    "use strict";

    api.MetaboxContainer = api.BaseContainer.extend({
        /**
         * Set Container Holder
         */
        setContainerHolder: function () {
            this.containerHolder = api.metaboxcontainer;
        },

        /**
         * Assign additional Segment Data
         *
         * @param segment
         * @param data
         *
         * @returns {*}
         */
        prepareSegmentData: function (segment, data) {
            segment.parent = this.id;
            segment.container = this;
            segment.type = 'nowrap';

            return segment;
        },
    });

    /**
     * Metabox Normal Container
     */
    api.MetaboxNormalContainer = api.MetaboxContainer.extend({});

    /**
     * Metabox Tabbed Container
     */
    api.MetaboxTabbedContainer = api.MetaboxContainer.extend({
        /**
         * Attach event
         */
        attachEvent: function () {
            var container = this;
            $(container.element).formtab();
        },

        /**
         * Assign additional Segment Data
         *
         * @param segment
         * @param data
         * @param index
         *
         * @returns {*}
         */
        prepareSegmentData: function (segment, data, index) {
            segment.parent = this.id;
            segment.container = this;
            segment.type = 'tabbed';
            segment.index = index;

            return segment;
        },
    });

    api.metaboxContainerConstructor = {
        normal: api.MetaboxNormalContainer,
        tabbed: api.MetaboxTabbedContainer
    };

    api.metaboxcontainer = new api.Values({ defaultConstructor: api.MetaboxContainer });

    /**
     * Jeg Metabox
     */
    window.jeg = window.jeg || {};
    jeg.metabox = {};

    jeg.metabox.build = function (id, type, data) {
        if (!api.metaboxcontainer.has(id)) {
            var element = $('#' + id);
            var Constructor = api.metaboxContainerConstructor[type];
            api.metaboxcontainer.add(id, new Constructor(id, element, data));
        }
    };

    $(document).on('ready', function () {
        if (typeof window.jegMetaboxData === 'undefined') return;

        var metaboxData = JSON.parse(window.jegMetaboxData)
        if (undefined !== jeg.metabox) {
            jeg.metabox.build(metaboxData.id, metaboxData.type, metaboxData.data);
        }
    })

})(jQuery, wp.customize);
