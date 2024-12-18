(function ($) {
    'use strict';

    /**
     * Check if valid option passed
     *
     * @param options
     */
    function isValidOption(options) {
        if (undefined !== options[0]) {
            if (undefined !== options[0]['value'] && undefined !== options[0]['text']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Setup select option for Selectize
     *
     * @param options
     * @returns {Array}
     */
    function setupOption(options) {
        if (isValidOption(options)) {
            return options;
        } else {
            var newOption = [];
            _.each(options, function (text, value) {
                newOption.push({
                    'value': value,
                    'text': text
                });
            });
            return newOption;
        }
    }

    function ajaxLoad(query, callback) {
        var control = this,
            value = control.element.attr('value');
        if (!query.length || query.length < 3) return callback();

        var request = wp.ajax.send(control.ajax, {
            data: {
                query: query,
                nonce: control.nonce,
                slug: control.slug,
                value: value
            }
        });

        request.done(function (response) {
            callback(response);
        });
    }

    function fetchOption(ajax, value, nonce, slug) {
        return wp.ajax.send(ajax, {
            data: {
                value: value,
                nonce: nonce,
                slug: slug
            }
        });
    }

    function renderMultiSelect(element, options) {
        options = setupOption(options)
        var $element = $(element),
            multiple = $element.data('multiple'),
            ajax = $element.data('ajax'),
            slug = $element.data('slug'),
            nonce = $element.data('nonce'),
            setting = {
                plugins: ['drag_drop', 'remove_button'],
                multiple: multiple,
                maxItems: multiple,
                hideSelected: true,
                options: options,
                render: {
                    option: function (item) {
                        return '<div><span>' + item.text + '</span></div>';
                    }
                }
            };

        if ('' !== ajax && true !== ajax) {
            setting.load = ajaxLoad.bind({ ajax: ajax, nonce: nonce, slug: slug, element: $element });
            setting.create = true;
        }

        $(element).selectize(setting);
    }

    function singleSelect(element) {
        var ajax = $(element).data('ajax'),
            nonce = $(element).data('nonce'),
            setting = {
                allowEmptyOption: true
            };

        if ('' !== ajax) {
            setting.load = ajaxLoad.bind({ ajax: ajax, nonce: nonce, slug: '' });
            setting.create = true;
        }

        $(element).selectize(setting);
    }

    function multiSelect(element) {
        var $element = $(element),
            value = $element.val(),
            options = $element.parent().find('.data-option').text(),
            retriever = $element.data('retriever'),
            slug = $element.data('slug'),
            nonce = $element.data('nonce');
        if ('' !== options) {
            var options_temp = JSON.parse(options)
        }
        if ('' !== value && (typeof options_temp !== undefined && '' === options_temp || 0 === options_temp.length)) {
            var fetch = fetchOption(retriever, value, nonce, slug);
            fetch.done(function (response) {
                renderMultiSelect(element, response);
            });
        } else {
            if ('' !== options) {
                options = JSON.parse(options)
            }
            renderMultiSelect(element, options)
        }
    }

    window.selectField = function (element) {
        var tag = $(element).prop('tagName');

        if (tag === 'SELECT') {
            singleSelect(element);
        } else {
            multiSelect(element);
        }
    };

    window.open_control = function (control) {
        var wrapper = control.parent();

        if (wrapper.hasClass('type-select')) {
            selectField(control);
        }

        wrapper.find('input.input-sortable').on('change', function () {
            $(this).trigger('input');
        });
    };

    $(window).on('load', function () {
        elementor.hooks.addAction('panel/open_editor/widget', function (panel) {
            var control = $(panel.$el).find('.elementor-control-input-wrapper > input');

            control.each(function () {
                window.open_control($(this));
            });
        });

        if (elementor.panel) {
            // can't use .on because Elementor already add .off
            $(elementor.panel.$el).bind('click', '.elementor-component-tab', function () {
                var control = $(elementor.panel.$el).find('.elementor-control-input-wrapper > input');

                control.each(function () {
                    window.open_control($(this));
                });
            })
        }
    });
})(jQuery);
