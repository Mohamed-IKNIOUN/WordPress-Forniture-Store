(function ($, api) {
  "use strict";

  var $document = $(document)

  api.widgetcontainer = new api.Values({defaultConstructor: api.WidgetContainer})

  api.WidgetContainer = api.BaseContainer.extend({
    /**
     * Flag if widget already rendered
     */
    rendered: false,

    /**
     * Set Container Holder
     */
    setContainerHolder: function () {
      this.containerHolder = api.widgetcontainer
    },

    /**
     * Check if we can render widget on this element
     */
    canRenderWidget: function () {
      var widgetContainer = this
      var element = widgetContainer.element

      if ($(element).parents('#available-widgets').length) {
        return false
      }

      if ($(element).parents('#available-widgets-list').length) {
        return false
      }

      return true
    },

    /**
     * Load Container Content
     */
    loadContainer: function () {
      if (!this.rendered && this.canRenderWidget()) {
        this.populateSegments(this.option.segments)
        this.triggerFinish()
        this.rendered = true
      }
    },
  })

  /**
   * Jeg Widget Builder
   */
  window.jeg = window.jeg || {}
  jeg.widget = {}

  jeg.widget.build = function (id, data) {
    var parent = $('.widget-form-holder[data-id="' + id + '"]').html('')
    if (undefined === data) {
      //prevent if there are duplicate object id, causing parsing error
      if ($('.widget-form-data[data-id="' + id + '"]').length>1) {
        data = JSON.parse($('.widget-form-data[data-id="' + id + '"]')[0].val())
      }
      else{
        data = JSON.parse($('.widget-form-data[data-id="' + id + '"]').val())
      }
    }
    api.widgetcontainer.add(id, new api.WidgetContainer(id, parent, data))
  }

  /**
   * Override widget behavior, when widget added
   */
  jeg.widget.overrideWidgetBehavior = function () {
    if (undefined !== window.wpWidgets) {
      window.wpWidgets.addWidget = function (chooser) {
        var widget, widgetId, add, n, viewportTop, viewportBottom, sidebarBounds,
          sidebarId = chooser.find('.widgets-chooser-selected').data('sidebarId'),
          sidebar = $('#' + sidebarId)

        widget = $('#available-widgets').find('.widget-in-question').clone()
        widgetId = widget.attr('id')
        add = widget.find('input.add_new').val()
        n = widget.find('input.multi_number').val()

        // Remove the cloned chooser from the widget
        widget.find('.widgets-chooser').remove()

        if ('multi' === add) {
          widget.html(
            widget.html().replace(/<[^<>]+>/g, function (m) {
              return m.replace(/__i__|%i%/g, n)
            })
          )

          widget.html(
            widget.html().replace(/<script[\s\S]+script>/gm, function (m) {
              return m.replace(/__i__|%i%/g, n)
            })
          )

          widget.attr('id', widgetId.replace('__i__', n))
          n++
          $('#' + widgetId).find('input.multi_number').val(n)
        } else if ('single' === add) {
          widget.attr('id', 'new-' + widgetId)
          $('#' + widgetId).hide()
        }

        // Open the widgets container.
        sidebar.closest('.widgets-holder-wrap').removeClass('closed').find('.handlediv').attr('aria-expanded', 'true')

        sidebar.append(widget)
        sidebar.sortable('refresh')

        wpWidgets.save(widget, 0, 0, 1)
        // No longer "new" widget
        widget.find('input.add_new').val('')

        $document.trigger('widget-added', [widget])

        /*
         * Check if any part of the sidebar is visible in the viewport. If it is, don't scroll.
         * Otherwise, scroll up to so the sidebar is in view.
         *
         * We do this by comparing the top and bottom, of the sidebar so see if they are within
         * the bounds of the viewport.
         */
        viewportTop = $(window).scrollTop()
        viewportBottom = viewportTop + $(window).height()
        sidebarBounds = sidebar.offset()

        sidebarBounds.bottom = sidebarBounds.top + sidebar.outerHeight()

        if (viewportTop > sidebarBounds.bottom || viewportBottom < sidebarBounds.top) {
          $('html, body').animate({
            scrollTop: sidebarBounds.top - 130,
          }, 200)
        }

        window.setTimeout(function () {
          // Cannot use a callback in the animation above as it fires twice,
          // have to queue this "by hand".
          widget.find('.widget-title').trigger('click')
        }, 250)
      }
    }
  }

  if (undefined !== api.Widgets) {
    api.controlConstructor['sidebar_widgets'] = api.Widgets.SidebarControl.extend({
      addWidget: function (widgetId) {
        var self = this, controlHtml, $widget, controlType = 'widget_form', controlContainer, controlConstructor,
          parsedWidgetId = parseWidgetId(widgetId),
          widgetNumber = parsedWidgetId.number,
          widgetIdBase = parsedWidgetId.id_base,
          widget = api.Widgets.availableWidgets.findWhere({id_base: widgetIdBase}),
          settingId, isExistingWidget, widgetFormControl, sidebarWidgets, settingArgs, setting

        if (!widget) {
          return false
        }

        if (widgetNumber && !widget.get('is_multi')) {
          return false
        }

        // Set up new multi widget
        if (widget.get('is_multi') && !widgetNumber) {
          widget.set('multi_number', widget.get('multi_number') + 1)
          widgetNumber = widget.get('multi_number')
        }

        controlHtml = $.trim($('#widget-tpl-' + widget.get('id')).html())
        if (widget.get('is_multi')) {
          controlHtml = controlHtml.replace(/<[^<>]+>/g, function (m) {
            return m.replace(/__i__|%i%/g, widgetNumber)
          })

          controlHtml = controlHtml.replace(/<script[\s\S]+script>/gm, function (m) {
            return m.replace(/__i__|%i%/g, widgetNumber)
          })
        } else {
          widget.set('is_disabled', true) // Prevent single widget from being added again now
        }

        $widget = $(controlHtml)

        controlContainer = $('<li/>').
          addClass('customize-control').
          addClass('customize-control-' + controlType).
          append($widget)

        // Remove icon which is visible inside the panel
        controlContainer.find('> .widget-icon').remove()

        if (widget.get('is_multi')) {
          controlContainer.find('input[name="widget_number"]').val(widgetNumber)
          controlContainer.find('input[name="multi_number"]').val(widgetNumber)
        }

        widgetId = controlContainer.find('[name="widget-id"]').val()

        controlContainer.hide() // to be slid-down below

        settingId = 'widget_' + widget.get('id_base')
        if (widget.get('is_multi')) {
          settingId += '[' + widgetNumber + ']'
        }
        controlContainer.attr('id', 'customize-control-' + settingId.replace(/\]/g, '').replace(/\[/g, '-'))

        // Only create setting if it doesn't already exist (if we're adding a pre-existing inactive widget)
        isExistingWidget = api.has(settingId)
        if (!isExistingWidget) {
          settingArgs = {
            transport: api.Widgets.data.selectiveRefreshableWidgets[widget.get('id_base')] ? 'postMessage' : 'refresh',
            previewer: this.setting.previewer,
          }
          setting = api.create(settingId, settingId, '', settingArgs)
          setting.set({}) // mark dirty, changing from '' to {}
        }

        controlConstructor = api.controlConstructor[controlType]
        widgetFormControl = new controlConstructor(settingId, {
          settings: {
            'default': settingId,
          },
          content: controlContainer,
          sidebar_id: self.params.sidebar_id,
          widget_id: widgetId,
          widget_id_base: widget.get('id_base'),
          type: controlType,
          is_new: !isExistingWidget,
          width: widget.get('width'),
          height: widget.get('height'),
          is_wide: widget.get('is_wide'),
        })
        api.control.add(widgetFormControl)

        // Make sure widget is removed from the other sidebars
        api.each(function (otherSetting) {
          if (otherSetting.id === self.setting.id) {
            return
          }

          if (0 !== otherSetting.id.indexOf('sidebars_widgets[')) {
            return
          }

          var otherSidebarWidgets = otherSetting().slice(),
            i = _.indexOf(otherSidebarWidgets, widgetId)

          if (-1 !== i) {
            otherSidebarWidgets.splice(i)
            otherSetting(otherSidebarWidgets)
          }
        })

        // Add widget to this sidebar
        sidebarWidgets = this.setting().slice()
        if (-1 === _.indexOf(sidebarWidgets, widgetId)) {
          sidebarWidgets.push(widgetId)
          this.setting(sidebarWidgets)
        }

        controlContainer.slideDown(function () {
          if (isExistingWidget) {
            widgetFormControl.updateWidget({
              instance: widgetFormControl.setting(),
            })
          }
        })

        return widgetFormControl
      },
    })
  }

  /**
   * Initialize Widget
   */
  jeg.widget.init = function () {
    jeg.widget.overrideWidgetBehavior()

    $document.bind('widget-added', function (e, widget) {
      var number = $(widget).find('.multi_number').val()
      var id = $(widget).find('.widget-form-holder').attr('id')
      var data = $(widget).find('.widget-form-data').text()
      if ( data ) {
        data = data.replace(/__i__|%i%/g, number)
        data = JSON.parse(data)

        jeg.widget.build(id, data)
      }
    }.bind(this))
    
    $(document).ajaxComplete(function(e, xhr, settings) {
      //rebuild the widget form after saving
      if ('save-widget' === new URLSearchParams(settings.data).get('action') && undefined !== jeg.widget) {
        jeg.widget.build($(xhr.responseText).closest('.widget-form-data').data('id'));
      }
    });
  };

  (function () {
    $(document).on('ready', jeg.widget.init())
  })()

  function parseWidgetId (widgetId) {
    var matches, parsed = {
      number: null,
      id_base: null,
    }

    matches = widgetId.match(/^(.+)-(\d+)$/)
    if (matches) {
      parsed.id_base = matches[1]
      parsed.number = parseInt(matches[2], 10)
    } else {
      // likely an old single widget
      parsed.id_base = widgetId
    }

    return parsed
  }

})(jQuery, wp.customize)