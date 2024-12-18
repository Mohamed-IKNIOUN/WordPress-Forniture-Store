(function ($, api) {
    "use strict";
    api.controlConstructor['widget_form'] = api.Widgets.WidgetControl.extend({
        alert: false,
        initialize: function (id, options) {
            var control = this;
            api.Widgets.WidgetControl.prototype.initialize.call(control, id, options);
            control.bindOnExpand();
        },
        bindOnExpand: function () {
            var control = this;
            this.container.on('expand', function () {
                var base = control.params.widget_id_base;
                var start = base.startsWith('jeg');
                if (start && !control.alert) {
                    var content = control.container.find('.widget-content');
                    var html = this.compileTemplate('widget-alert', window.widgetLang);
                    content.append(html);
                    control.alert = true;
                }
            });
        },
        compileTemplate: function (template, data) {
            var compiledTemplate = wp.template(template);
            return $(compiledTemplate(data));
        }
    });
})(jQuery, wp.customize);
