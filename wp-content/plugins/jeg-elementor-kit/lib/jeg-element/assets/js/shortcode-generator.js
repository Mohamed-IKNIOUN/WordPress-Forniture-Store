(function ($, api) {
    'use strict';

    /**
     * Short Code Item Collection
     */
    api.shortcodepopup = new api.Values({defaultConstructor: api.ShortCodeListPopup});

    api.shortcodecontainer = new api.Values({defaultConstructor: api.ShortCodeContainer});

    api.ShortCodeContainer = api.BaseContainer.extend({
        /**
         * Set Container Holder
         */
        setContainerHolder: function() {
            this.containerHolder = api.shortcodecontainer;
        },

        /**
         * Attach event
         */
        attachEvent: function(){
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
        prepareSegmentData: function(segment, data, index) {
            segment.parent = this.id;
            segment.container = this;
            segment.type = 'tabbed';
            segment.index = index;

            return segment;
        },

        /**
         * Prepare Field Data
         *
         * @param field
         * @param data
         * @param index
         *
         * @returns {*}
         */
        prepareFieldData: function(field, data, index) {
            field.container = this;
            field.index = index;

            return field;
        },
    });


    /**
     * Short Code Item
     */
    api.ShortCodeItem = api.Class.extend({
        /**
         * ID of this item
         */
        id: null,

        /**
         * data passed from container
         */
        data: null,

        /**
         * Rendered Element
         */
        element: null,

        /**
         * Container that hold element
         */
        container: null,

        /**
         * Container that hold option
         */
        popupContainer: null,

        /**
         * Initialize
         *
         * @param id
         * @param data
         */
        initialize: function (id, data) {
            this.id = id;
            this.data = data;
            this.popupContainer = $(".shortcode-option-wrapper");

            this.renderItem();
            this.attachEvent();
        },

        /**
         * Render Item
         */
        renderItem: function () {
            var template = wp.template('shortcode-item');
            this.element = $(template({
                id: this.id,
                name: this.data.name,
            }));

            this.container = this.data.parent.container.find('[id=' + this.data.category + '] .jeg_metabox_body');
            this.container.append(this.element);
        },

        /**
         * Attach Event
         */
        attachEvent: function () {
            var instance = this;
            instance.element.on('click', instance.showShortCodeOptionWindow.bind(this));
        },

        /**
         * Show Short Code Popup Window
         */
        showShortCodeOptionWindow: function () {
            var instance = this;
            api.shortcodepopup.instance('jeg').hidePopup();
            instance.setupPopup();
        },

        /**
         * Setup Popup
         */
        setupPopup: function(){
            this.renderPopup();
            this.showPopup();
            this.resetPosition();
            this.renderShortCodeOption();
        },

        /**
         * calculate box position
         */
        resetPosition: function(){
            var wh = $(window).height();
            var ww = $(window).width();

            var maxWidth = 750;
            var maxHeight = 700;

            var width = Math.floor( 80 * ww / 100 );
            width = ( width > maxWidth ) ? maxWidth : width;

            var height = Math.floor( 80 * wh / 100 );
            height = ( height > maxHeight ) ? maxHeight : height;

            var left = ( ww - width ) / 2;
            var top = ( wh - height ) / 2;

            this.popupContainer.css({
                width: width,
                height: height,
                top: top,
                left: left
            });

            var headerHeight = this.popupContainer.find('.popup-header').outerHeight() +
                this.popupContainer.find('.tabbed-list').outerHeight() +
                this.popupContainer.find('.popup-footer').outerHeight();

            // console.log(this.popupContainer.find('.popup-header').outerHeight(),
            //     this.popupContainer.find('.tabbed-list').outerHeight(),
            //     this.popupContainer.find('.popup-footer').outerHeight());

            // console.log(height - headerHeight);

            this.popupContainer.find('.popup-content').css({
                height: height - headerHeight
            });
        },

        /**
         * Render Popup
         */
        renderPopup: function() {
            this.popupContainer.html('');
            var template = wp.template('shortcode-option');
            var html = template({
                header: this.data.name,
                close: window.jelement.close,
                generate: window.jelement.generate,
            });

            this.popupContainer.append(html);
            this.attachPopupEvent();
        },

        /**
         * Attach event popup
         */
        attachPopupEvent: function(){
            var instance = this;

            // hide Popup
            this.popupContainer.find('.close').on('click', instance.hidePopup.bind(instance));

            // Generate Shortcode
            this.popupContainer.find('.generate').on('click', instance.generateShortcode.bind(instance));

            // Draggable handler
            this.popupContainer.draggable({ handle: '.popup-header' });
        },

        /**
         * Show Popup
         */
        showPopup: function () {
            this.popupContainer.addClass('active');
        },

        /**
         * Hide Popup
         */
        hidePopup: function () {
            this.popupContainer.removeClass('active');
        },

        /**
         * Load Short Code Option
         */
        renderShortCodeOption: function () {
            var instance = this;
            var load = instance.loadAjax();
            load.done(instance.shortCodeOptionLoaded.bind(this));
        },

        /**
         * Load Ajax
         *
         * @returns {*|$.promise}
         */
        loadAjax: function () {
            var instance = this;

            return wp.ajax.send(instance.id, {
                data: {
                    nonce: window.jelement.nonce
                }
            });
        },

        /**
         * Create Short Code Option
         */
        shortCodeOptionLoaded: function (response) {
            var instance = this;
            if(api.shortcodecontainer.has(instance.id)) {
                api.shortcodecontainer.remove(instance.id);
            }
            api.shortcodecontainer.add(instance.id, new api.ShortCodeContainer(instance.id, instance.popupContainer, response));
            instance.resetPosition();
        },

        /**
         * Generate Short Code
         */
        generateShortcode: function() {
            var instance = this;
            var containerInstance = api.shortcodecontainer.instance(instance.id);
            var shortcode = [];

            containerInstance.segments.each(function(segment){
                segment.fields.each(function(field){
                    var value = field.value.get();
                    if(field.params.default != value) {
                        value = instance.filterValue(value);
                        shortcode.push(field.id + '="' + value + '"');
                    }
                })
            })

            if(shortcode.length) {
                shortcode = "[" + instance.id + ' ' + shortcode.join(' ') + "]";
            } else {
                shortcode = "[" + instance.id + "]";
            }

            instance.data.editor.execCommand('mceInsertContent', false, shortcode);
            instance.hidePopup();
        },

        /**
         * Filter value
         */
        filterValue: function(value) {
            return value;
        }
    });

    api.ShortCodeCategory = api.Class.extend({
        /**
         * ID of this category
         */
        id: null,

        /**
         * Shortcode Index
         */
        index: 0,

        /**
         * parent instance & category text
         */
        data: null,

        /**
         * Initialize
         *
         * @param id
         * @param index
         * @param data
         */
        initialize: function (id, index, data) {
            this.id = id;
            this.data = data;
            this.index = index;

            this.renderCategory();
        },

        /**
         * Render Category
         */
        renderCategory: function () {
            var instance = this;
            var container = this.data.parent.container;
            var data = {
                id: instance.id,
                text: instance.data.category,
                index: instance.index
            };

            // List Template
            var listTemplate = wp.template('shortcode-category-list');
            var listHTML = listTemplate(data);
            container.find('.tabbed-list').append(listHTML);

            // Category Body
            var bodyTemplate = wp.template('shortcode-category');
            var bodyHTML = bodyTemplate(data);
            container.find('.tabbed-body').append(bodyHTML);
        },
    });

    /**
     * Shortcode Generator Widget
     */
    api.ShortCodeListPopup = api.Class.extend({
        /**
         * WP Editor
         */
        editor: null,

        /**
         * Shortcode Data
         */
        data: null,

        /**
         * Collection category attached
         */
        categories: null,

        /**
         * Collection of items
         */
        items: null,

        /**
         * This shortcode list container
         */
        container: null,

        /**
         * Initialize Short Code Generator
         * @param editor
         */
        initialize: function (editor) {
            this.editor = editor;
            this.categories = new api.Values({defaultConstructor: api.ShortCodeCategory});
            this.items = new api.Values({defaultConstructor: api.ShortCodeItem});
            this.data = window.jelement;
            this.container = $(".shortcode-popup-list-wrapper");

            this.setupPopup();
            this.showPopup();
            this.resetPosition(true);
        },

        /**
         * Setup Popup
         */
        setupPopup: function () {
            this.setupContainer();
            this.setupCategory();
            this.setupElement();
            this.attachEvent();
        },

        /**
         * Setup Container
         */
        setupContainer: function () {
            var template = wp.template('shortcode-popup');
            var html = template({
                header: this.data.title
            });

            this.container.append(html);
        },

        /**
         * Attach event for container
         */
        attachEvent: function () {
            var instance = this;

            // attach close event
            this.container.find('.close').on('click', instance.hidePopup.bind(instance));

            // category tab event
            this.container.formtab();

            // Draggable handler
            this.container.draggable({ handle: '.popup-header' });

            // resize event
            $(window).on('resize', instance.resetPosition.bind(this));
        },

        /**
         * calculate Box size
         */
        resetPosition: function(){
            var wh = $(window).height();
            var ww = $(window).width();

            var maxWidth = 1200;
            var maxHeight = 700;

            var width = Math.floor( 80 * ww / 100 );
            width = ( width > maxWidth ) ? maxWidth : width;

            var height = Math.floor( 80 * wh / 100 );
            height = ( height > maxHeight ) ? maxHeight : height;

            var left = ( ww - width ) / 2;
            var top = ( wh - height ) / 2;

            this.container.css({
                width: width,
                height: height,
                top: top,
                left: left
            });

            var headerHeight = this.container.find('.popup-header').outerHeight() + this.container.find('.tabbed-list').outerHeight();
            this.container.find('.popup-content').css({
                height: height - headerHeight
            });
        },

        /**
         * Setup category
         */
        setupCategory: function () {
            var instance = this;
            var index = 0;

            _.each(instance.data.elements, function (item) {
                var slug = instance.slugify(item.category);
                if (!instance.categories.has(slug)) {
                    instance.categories.add(slug, new api.ShortCodeCategory(slug, index++, {
                        category: item.category,
                        parent: instance
                    }));
                }
            });
        },

        /**
         * Setup element
         */
        setupElement: function () {
            var instance = this;

            _.each(instance.data.elements, function (item, key) {
                instance.items.add(key, new api.ShortCodeItem(key, {
                    id: key,
                    name: item.name,
                    category: instance.slugify(item.category),
                    parent: instance,
                    editor: instance.editor
                }));
            });
        },

        /**
         * Show Popup
         */
        showPopup: function () {
            this.container.addClass('active');
        },

        /**
         * Hide Popup
         */
        hidePopup: function () {
            this.container.removeClass('active');
        },

        /**
         * Turn string to slug
         *
         * @param text
         * @returns {string}
         */
        slugify: function (text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        },
    });

})(jQuery, wp.customize);
