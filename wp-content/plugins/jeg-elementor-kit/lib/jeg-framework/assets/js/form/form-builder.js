(function ($, api) {
  'use strict'

  /**
   * Simple Form for Tabbed Builder
   */
  $.fn.formtab = function () {
    var parent = this
    var li = $(this).find('.tabbed-list > li')
    var body = $(this).find('.jeg_tabbed_body')
    var active = 'active'

    li.on('click', function () {
      if (!$(this).hasClass(active)) {
        var link = $(this).attr('href').substr(1)

        // Active Tab
        li.removeClass(active)
        $(this).addClass(active)

        // Active Body
        body.removeClass(active)
        $(parent).find('#' + link).addClass(active)
      }

      return false
    })
  }

  /**
   * Global helper for form builder
   *
   * @type {{}}
   */
  api.helper = {}

  /**
   * Sort element by priority
   *
   * @param data
   * @returns {Array}
   */
  api.helper.prioritySort = function (data) {
    var sortedData = []
    var sortedKey = Object.keys(data).sort(function (a, b) {
      return data[a]['priority'] - data[b]['priority']
    })

    _.each(sortedKey, function (key) {
      sortedData.push(data[key])
    })

    return sortedData
  }

  /**
   * String Format functionality to replicate sprintf on php
   * @param format
   */
  api.helper.format = function (format) {
    var args = Array.prototype.slice.call(arguments, 1)
    return format.replace(/{(\d+)}/g, function (match, number) {
      return typeof args[number] !== 'undefined' ? args[number] : match
    })
  }

  /**
   * Base container to extended by type of container
   */
  api.BaseContainer = api.Class.extend({
    /**
     * ID of this container
     */
    id: null,

    /**
     * Element that hold this menu
     */
    element: null,

    /**
     * Collection segments attached for every single menu
     */
    segments: null,

    /**
     * Collection fields attached for every single field
     */
    fields: null,

    /**
     * Menu container loaded
     */
    loaded: false,

    /**
     * Container pane. Here to inject new element
     */
    containerPaneParent: '',

    /**
     * Container Holder
     */
    containerHolder: null,

    /**
     * Initialize Menu
     *
     * @param id
     * @param element
     * @param option
     */
    initialize: function (id, element, option) {
      this.id = id
      this.element = element
      this.option = option

      // This variable need to be assigned right here to prevent merging variable with previous instantiate class
      this.segments = new api.Values({ defaultConstructor: api.Segment })

      this.setContainerHolder()
      this.loadContainer()
    },

    /**
     * Load Container Content
     */
    loadContainer: function () {
      // populate segment
      this.populateSegments(this.option.segments)

      // Need to trigger Widget Container Loaded so both segment & field can be resolved
      this.triggerFinish()

      // Attach event if available
      this.attachEvent()
    },

    /**
     * Trigger when container already finish rendered
     */
    triggerFinish: function () {
      this.loaded = true
      this.containerHolder.trigger(this.id, this)
    },

    /**
     * Populate Segment
     *
     * @param segments
     */
    populateSegments: function (segments) {
      segments = this.prepareSegment(segments)
      this.setupSegment(this.id, segments)
    },

    /**
     * Setup Setting Segment
     *
     * @param segments
     */
    prepareSegment: function (segments) {
      var index = 0

      _.each(segments, function (data, key) {
        segments[key] = this.prepareSegmentData(segments[key], data, index++)
      }.bind(this))

      return api.helper.prioritySort(segments)
    },

    /**
     * Inject segment into MenuContainer
     *
     * @param id
     * @param segments
     */
    setupSegment: function (id, segments) {
      var Constructor = null
      _.each(segments, function (data) {
        if (_.has(api.segmentConstructor, data.type)) {
          Constructor = api.segmentConstructor[data.type]
        } else {
          Constructor = api.segmentConstructor.normal
        }
        if (!this.segments.has(data.id)) {
          this.segments.add(data.id, new Constructor(data.id, data))
        }
      }.bind(this))
    },

    /**
     * Assign additional Segment Data
     *
     * @param segment
     *
     * @returns {*}
     */
    prepareSegmentData: function (segment) {
      segment.parent = this.id
      segment.container = this

      return segment
    },

    /**
     * Set Container Holder
     */
    setContainerHolder: function () { },

    /**
     * Attach event
     */
    attachEvent: function () { },
  })

  /**
   * Main class for Segment type, will be extended by menu, widget, category, etc
   */
  api.Segment = api.Class.extend({

    /**
     * Segment Type
     */
    segmentType: 'segment',

    /**
     * Segment not loaded
     */
    loaded: false,

    /**
     * Default parameters
     */
    defaults: {
      name: '',
      type: 'default',
      active: true,
      parent: '',
      priority: 10,
    },

    /**
     * Initialize segment
     *
     * @param id
     * @param options
     */
    initialize: function (id, options) {
      this.id = id

      this.params = _.extend(
        {},
        this.defaults,
        this.params || {},
        options || {}
      )

      this.priority = new api.Value()
      this.priority.set(this.params.priority)

      // holding fields
      this.fields = new api.Values({ defaultConstructor: api.Fields })

      this.deferred = {
        embedded: new $.Deferred(),
      }

      this.embed()
      this.setContainerHolder()

      this.deferred.embedded.done(function () {
        this.attachEvent()
        this.ready()
      }.bind(this))

      this.populateFields()
      this.loadState()
    },

    /**
     * Set loaded segment
     */
    triggerLoaded: function () {
      this.loaded = true
      this.containerHolder.trigger(this.id, this)
    },

    /**
     * Render Content
     */
    renderContent: function () {
      var template

      template = wp.template('form-segment-' + this.segmentType)

      if (template) {
        return template(this.params)
      }
      return '<div></div>'
    },

    /***
     * Set Container Holder
     */
    setContainerHolder: function () {
      this.containerHolder = this.params.container.segments
    },

    /**
     * Get selector where to append segment
     *
     * @return string
     */
    getParentSegmentHolder: function () {
      return this.params.container.containerPaneParent
    },

    /**
     * Get parent container element
     *
     * @return string
     */
    getParentContainer: function () {
      return this.params.container.element
    },

    /**
     * attach event
     */
    attachEvent: function () { },

    /**
     * Ready State
     */
    ready: function () { },

    /**
     * set load state for segment
     */
    loadState: function () { },

    /**
     * Populare Fields
     */
    populateFields: function () {
      var fields = this.prepareField(this.params.container.option.fields)
      this.setupField(this.id, fields)
    },

    /**
     * Setup Setting Field
     *
     * @param fields
     * @returns {*}
     */
    prepareField: function (fields) {
      var index = 0
      var resultFields = []

      _.each(fields, function (data, key) {
        if (this.id === fields[key].segment) {
          resultFields[key] = this.prepareFieldData(fields[key], data, index++)
        }
      }.bind(this))

      return api.helper.prioritySort(resultFields)
    },

    /**
     * Inject field into Menu Container
     *
     * @param id
     * @param fields
     */
    setupField: function (id, fields) {
      var Constructor = null
      _.each(fields, function (data) {
        if (_.has(api.fieldConstructor, data.type)) {
          Constructor = api.fieldConstructor[data.type]
        } else {
          Constructor = api.fieldConstructor.standart
        }
        if (!this.fields.has(data.id)) {
          this.fields.add(data.id, new Constructor(data.id, data))
        }
      }.bind(this))
    },

    /**
     * Prepare Field Data
     *
     * @param field
     * @param data
     *
     * @returns {*}
     */
    prepareFieldData: function (field, data) {
      field.container = this

      return field
    },

    /**
     * Embed element
     */
    embed: function () { },

    /**
     * Listen Field Change
     */
    listenFieldChange: function (id, value) { },
  })

  /**
   * Normal Default Segment
   */
  api.normalSegment = api.Segment.extend({
    segmentType: 'normal',
    segmentContentParent: '.jeg_accordion_body',

    /**
     * Initialize Menu segment
     *
     * @param id
     * @param params
     */
    initialize: function (id, params) {
      var normalSegment = this
      api.Segment.prototype.initialize.call(normalSegment, id, params)
    },

    /**
     * modify load state
     */
    loadState: function () {
      var normalSegment = this
      var container = normalSegment.params.container
      var containerID = container.id

      container.containerHolder.bind(containerID, function (container) {
        if (container.loaded) {
          normalSegment.loaded = true
          normalSegment.params.container.segments.trigger(normalSegment.id, normalSegment)
        }
      })
    },

    /**
     * attach event
     */
    attachEvent: function () {
      var segment = this

      segment.element.find('.jeg_accordion_heading').on('click', function (e) {
        e.preventDefault()
        var parent = $(this).parent('.jeg_accordion_wrapper')
        var body = $(parent).find('.jeg_accordion_body')

        if ($(parent).hasClass('open')) {
          $(body).slideUp('fast')
          $(parent).removeClass('open').addClass('close')
        } else {
          $(body).slideDown('fast')
          $(parent).removeClass('close').addClass('open')
        }
      })
    },

    /**
     * Embed element
     */
    embed: function () {
      var segment = this

      segment.element = $(segment.renderContent())
      segment.holder = segment.getParentContainer()
      segment.holder.append(segment.element)

      segment.deferred.embedded.resolve()
    },
  })

  /**
   * Metabox Segment
   */
  api.noWrapSegment = api.Segment.extend({
    segmentType: 'nowrap',
    segmentContentParent: '.jeg_metabox_body',

    /**
     * modify load state
     */
    loadState: function () {
      var segment = this
      var containerID = segment.params.container.id

      segment.params.container.containerHolder.bind(containerID, function (container) {
        if (container.loaded) {
          segment.loaded = true
          segment.params.container.segments.trigger(segment.id, segment)
        }
      })
    },

    /**
     * Embed element
     */
    embed: function () {
      this.element = $(this.renderContent())
      this.holder = this.getParentContainer()
      this.holder.append(this.element)
      this.deferred.embedded.resolve()
    },
  })

  /**
   * Tabbed Segment
   */
  api.TabbedSegment = api.Segment.extend({
    segmentType: 'tabbed',
    segmentContentParent: '.jeg_metabox_body',

    /**
     * modify load state
     */
    loadState: function () {
      var tabbedSegment = this
      var container = tabbedSegment.params.container
      var containerID = container.id

      container.containerHolder.bind(containerID, function (container) {
        if (container.loaded) {
          tabbedSegment.loaded = true
          tabbedSegment.params.container.segments.trigger(tabbedSegment.id, tabbedSegment)
        }
      })
    },

    /**
     * Embed element
     */
    embed: function () {
      var segment = this

      // Navigation
      segment.navigationElement = $(segment.renderNavigationContent())
      segment.navigationHolder = segment.getParentContainer().find('.tabbed-list')
      segment.navigationHolder.append(segment.navigationElement)

      // Body
      segment.element = $(segment.renderContent())
      segment.holder = segment.getParentContainer().find('.tabbed-body')
      segment.holder.append(segment.element)

      segment.deferred.embedded.resolve()
    },

    /**
     * Navigation Content
     */
    renderNavigationContent: function () {
      var template,
        segment = this

      template = wp.template('form-segment-' + segment.segmentType + '-tab')

      if (template) {
        return template(segment.params)
      }
      return '<div></div>'
    },

    /**
     * attach event
     */
    attachEvent: function () { },

    /**
     * Prepare Field Data
     *
     * @param field
     * @param data
     * @param index
     *
     * @returns {*}
     */
    prepareFieldData: function (field, data, index) {
      field.container = this
      field.index = index

      return field
    },

  })

  /**
   * List of Segment Type
   *
   * @type {{menu: *}}
   */
  api.segmentConstructor = {
    normal: api.normalSegment,
    nowrap: api.noWrapSegment,
    tabbed: api.TabbedSegment,
  }

  /**
   * Main class for Field will be extended by every text
   */
  api.Fields = api.Class.extend({

    defaults: {
      title: '',
      desc: '',
      default: '',
      type: 'text',
      active: true,
      parent: '',
      priority: 10,
    },

    /**
     * Initialize
     *
     * @param id
     * @param options
     */
    initialize: function (id, options) {
      var field = this
      field.id = id

      field.params = _.extend(
        {},
        field.defaults,
        field.params || {},
        options || {}
      )

      // setup link field
      field.params.link = 'data-link="true"'

      // Setup field Value
      field.value = new api.Value()
      field.value.set(field.params.value)
      field.value.bind(function (value) {
        this.params.container.listenFieldChange(field.id, value)
      }.bind(this))

      // Setup Field Active State
      field.active = new api.Value()
      field.active.set(true)
      field.active.bind(function (active) {
        field.onChangeActive(active)
      })

      field.deferred = {
        embedded: new $.Deferred(),
      }

      field.embed()
      field.deferred.embedded.done(function () {
        field.listenLink()
        field.attachEvent()
        field.ready()
      })

      this.params.container.containerHolder.bind(this.params.container.id, function (segment) {
        if (segment.loaded) {
          this.loaded(segment)
        }
      }.bind(this))
    },

    /**
     * When active status changed
     *
     * @param active
     */
    onChangeActive: function (active) {
      var field = this
      if (active) {
        field.element.slideDown('fast')
      } else {
        field.element.slideUp('fast')
      }
    },

    /**
     * Embed element
     */
    embed: function () {
      var field = this
      var segment = field.params.container
      var container = segment.element.find(segment.segmentContentParent)

      field.element = $(field.renderContent())
      container.append(field.element)

      field.deferred.embedded.resolve()
    },

    /**
     * Render Content
     */
    renderContent: function () {
      var template,
        field = this,
        type = field.params.type

      if (0 !== $('#tmpl-form-field-' + type).length) {
        template = wp.template('form-field-' + type)
      } else {
        template = wp.template('form-field-standart')
      }

      if (template) {
        return template(field.params)
      }
    },

    /**
     * Listen input change, then setup those field
     */
    listenLink: function () {
      var field = this
      $(field.element).find('[data-link]').change(function () {
        field.value.set($(this).val())
      })
    },

    /**
     * attach event
     */
    attachEvent: function () { },

    /**
     * Ready State
     */
    ready: function () { },

    /**
     * Field loaded
     *
     * @param segment
     */
    loaded: function (segment) {
      var field = this
      field.activeField()
    },

    /**
     * Compare between two value
     *
     * @param value1
     * @param value2
     * @param compare
     * @returns {boolean}
     */
    compare: function (value1, value2, compare) {
      if (compare === '===') {
        return value1 === value2
      }

      if (compare === '=' || compare === '==' || compare === 'equals' || compare === 'equal') {
        return value1 == value2
      }

      if (compare === '!=') {
        return value1 !== value2
      }

      if (compare === '!=' || compare === 'not equal') {
        return value1 !== value2
      }

      if (compare === '>=' || compare === 'greater or equal' || compare === 'equal or greater') {
        return value1 >= value2
      }

      if (compare === '<=' || compare === 'smaller or equal' || compare === 'equal or smaller') {
        return value1 <= value2
      }

      if (compare === '>' || compare === 'greater') {
        return value1 > value2
      }

      if (compare === '<' || compare === 'smaller') {
        return value1 < value2
      }

      if (compare === 'in' || compare === 'contains') {
        var result = value1.indexOf(value2)
        return result >= 0
      }

      if (compare === 'not in' || compare === 'not contains') {
        var result = value1.indexOf(value2)
        return result < 0
      }
    },

    /**
     * Examine status
     *
     * @param dependencies
     * @returns {boolean}
     */
    getStatus: function (dependencies) {
      var field = this
      var fields = field.params.container.fields
      var flag = true

      _.each(dependencies, function (dependency) {
        var parent = fields(dependency.field)
        flag = flag && field.compare(dependency.value, parent.value.get(), dependency.operator)
      })

      return flag
    },

    /**
     * Set active status for this field
     *
     * @param field
     * @param dependencies
     */
    setActiveStatus: function (field, dependencies) {
      var activeStatus = field.getStatus(dependencies)
      field.active.set(activeStatus)
    },

    /**
     * Setup field active field
     */
    activeField: function () {
      var field = this
      var fields = field.params.container.fields

      if (undefined !== field.params.dependency) {
        var dependencies = field.params.dependency

        if (dependencies.length > 0) {
          field.setActiveStatus(field, dependencies)

          _.each(dependencies, function (dependency) {
            var parent = fields(dependency.field)

            parent.value.bind(function () {
              field.setActiveStatus(field, dependencies)
            })
          })
        }
      }
    },
  })

  /**
   * Radio Image Field
   */
  api.radioImageField = api.Fields.extend({})

  /**
   * Color Field Type
   */
  api.colorField = api.Fields.extend({
    attachEvent: function () {
      var element = $(this.element)
      var clone = $(element).find('.jeg-color-picker-clone')
      var input = $(element).find('.jeg-color-picker')

      clone.wpColorPicker({
        change: function (event, ui) {
          var color = ui.color.toString()
          $(input).val(color).trigger('change')
        },
        clear: function () {
          $(input).val('').trigger('change')
        },
      })
    },
  })

  /**
   * Slider Field Type
   */
  api.sliderField = api.Fields.extend({
    attachEvent: function () {
      var element = $(this.element).find('input[type=range]'),
        value = element.val()

      element.closest('div').find('.jeg_range_value .value').text(value)

      element.on('mousedown', function () {
        $(this).mousemove(function () {
          var value = $(this).val()
          $(this).closest('div').find('.jeg_range_value .value').text(value)
        })
      })

      element.on('click', function () {
        var value = $(this).val()
        $(this).closest('div').find('.jeg_range_value .value').text(value)
      })

      $(this.element).find('.jeg-slider-reset').on('click', function () {
        var thisInput = element
        var inputDefault = thisInput.data('reset_value')
        thisInput.val(inputDefault)
        thisInput.change()

        $(this).closest('div.wrapper').find('.jeg_range_value .value').text(inputDefault)
      })
    },
  })

  /**
   * Icon Picker
   */
  api.iconPickerField = api.Fields.extend({
    attachEvent: function () {
      var field = this

      $(field.element).find('.iconpicker').iconpicker({
        arrowPrevIconClass: 'fa fa-chevron-left',
        arrowNextIconClass: 'fa fa-chevron-right',
        iconset: 'fontawesome',
      }).on('change', function (e) {
        field.value.set(e.icon)
      })
    },
  })

  /**
   * Select Field
   */
  api.selectField = api.Fields.extend({
    /**
     * Check if valid option passed
     *
     * @param options
     */
    isValidOption: function (options) {
      if (undefined !== options[0]) {
        if (undefined !== options[0]['value'] &&
          undefined !== options[0]['text']) {
          return true
        }
      }

      return false
    },
    /**
     * Setup select option for Selectize
     *
     * @param options
     * @returns {Array}
     */
    setupOption: function (options) {
      if (this.isValidOption(options)) {
        return options
      } else {
        var newOption = []
        _.each(options, function (text, value) {
          newOption.push({
            'value': value,
            'text': text,
          })
        })
        return newOption
      }
    },
    /**
     * Call ajax if required
     *
     * @param query
     * @param callback
     * @returns {*}
     */
    ajaxCall: function (query, callback) {
      var field = this, slug = ''
      if (!query.length || query.length < 3) return callback()

      if ('' !== field.params.slug) {
        slug = field.params.slug
      }

      var request = wp.ajax.send(field.params.ajax, {
        data: {
          query: query,
          nonce: field.params.nonce,
          slug: slug,
        },
      })

      request.done(function (response) {
        callback(response)
      })
    },
    /**
     * Attach event for both single & multi
     */
    attachEvent: function () {
      var field = this,
        options = this.setupOption(field.params.options),
        value = field.params.value,
        slug = ''

      if ('' !== field.params.slug) {
        slug = field.params.slug
      }

      if (('' !== value && undefined !== value) && options.length === 0) {
        wp.ajax.send(field.params.ajaxoptions, {
          data: {
            value: value,
            nonce: field.params.nonce,
            slug: slug
          },
        }).done(function (response) {
          field.renderSelect(response)
        })
      } else {
        field.renderSelect(options)
      }
    },
    /**
     * Render select
     *
     * @return {*}
     */
    renderSelect: function (options) {
      var field = this,
        setting = {}

      var input = $(field.element).find('select')
      if (input.length === 0) {
        input = $(field.element).find('input')
      }

      if ((field.params.multiple && field.params.multiple > 1) || field.params.ajax) {
        // Multi.
        setting = {
          plugins: ['drag_drop', 'remove_button'],
          multiple: field.params.multiple,
          hideSelected: true,
          options: options,
          render: {
            option: function (item) {
              return '<div><span>' + item.text + '</span></div>'
            },
          },
          onChange: function (e) {
            field.value.set(e)
          },
          onItemAdd: function () {
            if (!field.params.multiple) {
              var value = this.items
              if (value.length > 1) {
                for (var a = 0; a < value.length; a++) {
                  this.removeItem(value[a])
                  this.refreshOptions()
                }
              }
            }
          },
        }
      } else {
        // Single.
        setting = {
          allowEmptyOption: true,
          onChange: function (e) {
            field.value.set(e)
          },
        }
      }

      if (field.params.ajax !== '') {
        setting.load = field.ajaxCall.bind(field)
        setting.create = true
      }

      $(input).selectize(setting)
    },
  })

  /**
   * Checkbox Field
   */
  api.checkboxField = api.Fields.extend({
    ready: function () {
      var field = this,
        checkboxValue

      $(field.element).find('input').change(function () {
        checkboxValue = $(this).is(':checked')
        field.value.set(checkboxValue)
      })
    },
  })

  /**
   * Text Field
   */
  api.textField = api.Fields.extend({
    ready: function () {
      var field = this

      $(field.element).on('change click keyup paste', 'input', function () {
        field.value.set($(this).val())
      })
    },
  })

  /**
   * Text Area
   */
  api.textareaField = api.textField.extend({
    ready: function () {
      var field = this

      $(field.element).on('change click keyup paste', 'textarea', function () {
        field.value.set($(this).val())
      })
    },
  })

  /**
   * Type Number
   */
  api.numberField = api.Fields.extend({
    ready: function () {
      var field = this,
        element = $(this.element).find('input'),
        min = $(this).attr('min'),
        max = $(this).attr('max'),
        step = $(this).attr('step')

      $(element).spinner({
        min: min,
        max: max,
        step: step,
        stop: function () {
          field.value.set($(this).val())
        },
      })
    },
  })

  api.uploadField = api.Fields.extend({
    ready: function () {
      var field = this;

      field.createMediaUploadInstance(false);

      field.element.on('click keypress', '.remove-button', function (e) {
        e.preventDefault()
        field.removeFile(e)
      });

      field.element.on('click keypress', '.upload-button', function (e) {
        e.preventDefault()
        field.openDialog(e)
      });
    },
    createMediaUploadInstance: function () {
      var libMediaType = this.getMimeType()
      var library = null

      if (libMediaType === 'image') {
        library = wp.media.query({ type: libMediaType })
      } else {
        library = wp.media.query({ type: JSON.stringify(libMediaType.split(',')) })
      }

      this.frame = wp.media({
        states: [
          new wp.media.controller.Library({
            library: library,
            multiple: false,
            date: false,
          }),
        ],
      })

      // When a file is selected, run a callback.
      this.frame.on('select', this.onSelect, this)
    },
    onSelect: function () {
      var attachment = this.frame.state().get('selection').first().toJSON();
      var $uploadButton = this.element.find('.upload-button');

      this.element.find('.jeg-file-attachment').
        html('<span class="file"><span class="dashicons dashicons-media-default"></span> ' + attachment.filename +
          '</span>').
        hide().
        slideDown('slow');

      this.element.find('.hidden-field').val(attachment.id);
      $uploadButton.text($uploadButton.data('alt-label'));
      $uploadButton.show();
      this.element.find('.remove-button').show();

      //This will activate the save button
      this.element.find('input, textarea, select').trigger('change')
      this.frame.close()
    },
    getMimeType: function () {
      return this.params.mime_type;
    },
    openDialog: function () {
      var field = this
      this.frame.open()
    },
    removeFile: function () {
      var $uploadButton = this.element.find('.upload-button');
      this.element.find('.jeg-file-attachment').slideUp('fast', function () {
        $(this).show().html($(this).data('placeholder'));
      })

      this.element.find('.hidden-field').val('');
      $uploadButton.text($uploadButton.data('label'));
      this.element.find('.remove-button').hide();

      this.element.find('input, textarea, select').trigger('change')
    }
  });

  /**
   * Image
   */
  api.imageField = api.Fields.extend({
    ready: function () {
      var field = this,
        addButton = $(field.element).find('.add-button'),
        removeButton = $(field.element).find('.remove-button'),
        multiple = ($(field.element).find('.image-content').attr('data-multiple') == 'true')

      field.createMediaUploadInstance(multiple)
      $(addButton).on('click', field.openDialog.bind(this))
      $(removeButton).on('click', field.removeImage.bind(this))

      $(field.element).on('click', '.image-wrapper .remove', function (e) {
        $(this).parent().fadeOut(200, function () {
          $(this).remove();
          $(field.element).trigger('change');
          field.setupMultiple();
        });
      });

      if (multiple) {
        $(field.element).find('.image-wrapper ').sortable({
          stop: function (e, ui) {
            field.setupMultiple();
          }
        });
      }
    },
    imageWrapperAction: function (src) {
      var field = this

      $(field.element).find('.image-wrapper').toggleClass('hide-image', src)
      $(field.element).find('img').attr('src', src)
    },
    toogleButton: function (src) {
      var field = this
      var toggle = '' === src ? 1 : 0

      $(field.element).find('.remove-button').toggleClass('hide-button', toggle)
      $(field.element).find('.add-button').toggleClass('hide-button', !toggle)
    },
    setupInput: function (src) {
      var field = this

      $(field.element).find('.image-input').val(src).change()
      field.value.set(src)
    },
    setupMultiple: function () {
      var field = this,
        images = [],
        wrapper = $(field.element).find('.image-wrapper')
      wrapper.find('input[name="' + field.params.fieldName + '[]"]').each(function () {
        images.push($(this).val());
      });
      field.value.set(images);
    },
    removeImage: function () {
      var field = this
      field.imageWrapperAction('')
      field.toogleButton('')
      field.setupInput('')
    },
    addImage: function (image) {
      var field = this
      field.imageWrapperAction(image.url)
      field.toogleButton(image.url)
      field.setupInput(image.id)
    },
    addMultipleImage: function (images) {
      var field = this,
        output = '',
        wrapper = $(field.element).find('.image-wrapper')

      _.each(images, function (image) {
        var thumbnail = image['url']

        if (image['sizes'] !== undefined && image['sizes']['thumbnail'] !== undefined)
          thumbnail = image['sizes']['thumbnail']['url']

        output +=
          "<div>" +
          "<input type='hidden' name='" + field.params.fieldName + "[]' value='" + image['id'] + "'>" +
          "<img src=" + thumbnail + ">" +
          "<span class='remove'></span>" +
          "</div>";
      })
      wrapper.removeClass('hide-image').append(output)
      field.setupMultiple()
    },
    createMediaUploadInstance: function (multiple) {
      var field = this
      field.mediaUpload = wp.media({
        frame: 'post',
        state: 'insert',
        multiple: multiple,
      })

      field.mediaUpload.on('insert', function () {
        var json = field.mediaUpload.state().get('selection')

        if (multiple) {
          field.addMultipleImage(json.toJSON())
        } else {
          field.addImage(json.first().toJSON())
        }

        field.mediaUpload.close()
      })
    },

    openDialog: function () {
      var field = this
      field.mediaUpload.open()
    },

  })

  var RepeaterRow = function (rowIndex, container, label) {

    'use strict'

    var self = this

    this.rowIndex = rowIndex
    this.container = container
    this.label = label
    this.header = this.container.find('.repeater-row-header'),

      this.header.on('click', function () {
        self.toggleMinimize()
      })

    this.container.on('click', '.repeater-row-remove', function () {
      self.remove()
      self.container.trigger('change')
    })

    this.header.on('mousedown', function () {
      self.container.trigger('row:start-dragging')
    })

    this.container.on('keyup change', 'input, select, textarea', function (e) {
      self.container.trigger('row:update', [self.rowIndex, jQuery(e.target).data('field'), e.target])
    })

    this.setRowIndex = function (rowIndex) {
      this.rowIndex = rowIndex
      this.container.attr('data-row', rowIndex)
      this.container.data('row', rowIndex)
      this.updateLabel()
    }

    this.toggleMinimize = function () {

      if (this.container.hasClass('minimized')) {
        this.container.find('.repeater-row-content').slideDown('fast')
      } else {
        this.container.find('.repeater-row-content').slideUp('fast')
      }

      // Store the previous state.
      this.container.toggleClass('minimized')
      this.header.find('.dashicons').toggleClass('dashicons-arrow-up').toggleClass('dashicons-arrow-down')
    }

    this.remove = function () {
      this.container.slideUp(300, function () {
        jQuery(this).detach()
      })
      this.container.trigger('row:remove', [this.rowIndex])
    }

    this.updateLabel = function () {
      var rowLabelField,
        rowLabel

      if ('field' === this.label.type) {
        rowLabelField = this.container.find('.repeater-field [data-field="' + this.label.field + '"]')
        if ('function' === typeof rowLabelField.val) {
          rowLabel = rowLabelField.val()
          if ('' !== rowLabel) {
            this.header.find('.repeater-row-label').text(rowLabel)
            return
          }
        }
      }
      this.header.find('.repeater-row-label').text(this.label.value + ' ' + (this.rowIndex + 1))
    }

    this.updateLabel()
  }

  /**
   * Repeater Field
   */
  api.repeaterField = api.Fields.extend({
    ready: function () {
      'use strict'
      var control = this
      var limit, theNewRow

      // The current value set in Control Class (set in to_json() function)
      var settingValue = $.isArray(control.params.value) ? control.params.value : JSON.parse(
        decodeURIComponent(control.params.value))

      // The hidden field that keeps the data saved (though we never update it)
      control.settingField = control.element.find('[data-customize-setting-link]').first()

      // Set the field value for the first time, we'll fill it up later
      control.setValue([], false)

      // The DIV that holds all the rows
      control.repeaterFieldsContainer = control.element.find('.repeater-fields').first()

      // Set number of rows to 0
      control.currentIndex = 0

      // Save the rows objects
      control.rows = []

      // Default limit choice
      limit = false
      if (control.params.choices) {
        if (undefined !== control.params.choices.limit) {
          limit = (0 >= control.params.choices.limit) ? false : parseInt(control.params.choices.limit)
        }
      }

      control.element.on('click', 'button.repeater-add', function (e) {
        e.preventDefault()
        if (!limit || control.currentIndex < limit) {
          theNewRow = control.addRow()
          theNewRow.toggleMinimize()
          control.initColorPicker()
          control.initDropdownPages(theNewRow)
          control.initSlider(theNewRow)
          control.element.trigger('change')
        } else {
          jQuery(control.selector + ' .limit').addClass('highlight')
        }
      })

      control.element.on('click', '.repeater-row-remove', function (e) {
        control.currentIndex--
        if (!limit || control.currentIndex < limit) {
          jQuery(control.selector + ' .limit').removeClass('highlight')
        }
      })

      control.element.on('click keypress',
        '.repeater-field-image .upload-button,.repeater-field-cropped_image .upload-button,.repeater-field-upload .upload-button,.repeater-field-upload_file .upload-button',
        function (e) {
          e.preventDefault()
          control.$thisButton = jQuery(this)
          control.openFrame(e)
        })

      control.element.on('click keypress',
        '.repeater-field-image .remove-button,.repeater-field-cropped_image .remove-button', function (e) {
          e.preventDefault()
          control.$thisButton = jQuery(this)
          control.removeImage(e)
        })

      control.element.on('click keypress', '.repeater-field-upload .remove-button', function (e) {
        e.preventDefault()
        control.$thisButton = jQuery(this)
        control.removeFile(e)
      })

      /**
       * Function that loads the Mustache template
       */
      control.repeaterTemplate = function () {
        return wp.template('form-field-repeater-content')
      }

      // When we load the control, the fields have not been filled up
      // This is the first time that we create all the rows
      if (settingValue.length) {
        _.each(settingValue, function (subValue) {
          theNewRow = control.addRow(subValue)
          control.initColorPicker()
          control.initDropdownPages(theNewRow, subValue)
          control.initSlider(theNewRow, subValue)
        })
      }

      // Once we have displayed the rows, we cleanup the values
      control.setValue(settingValue, true, true)

      control.repeaterFieldsContainer.sortable({
        handle: '.repeater-row-header',
        update: function (e, ui) {
          control.sort()
        },
      })

    },

    /**
     * Open the media modal.
     */
    openFrame: function (event) {

      'use strict'

      if (wp.customize.utils.isKeydownButNotEnterEvent(event)) {
        return
      }

      if (this.$thisButton.closest('.repeater-field').hasClass('repeater-field-cropped_image')) {
        this.initCropperFrame()
      } else {
        this.initFrame()
      }

      this.frame.open()
    },

    initFrame: function () {

      'use strict'

      var libMediaType = this.getMimeType()
      var library = null

      if (libMediaType === 'image') {
        library = wp.media.query({ type: libMediaType })
      } else {
        library = wp.media.query({ type: JSON.stringify(libMediaType.split(',')) })
      }

      this.frame = wp.media({
        states: [
          new wp.media.controller.Library({
            library: library,
            multiple: false,
            date: false,
          }),
        ],
      })

      // When a file is selected, run a callback.
      this.frame.on('select', this.onSelect, this)
    },
    /**
     * Create a media modal select frame, and store it so the instance can be reused when needed.
     * This is mostly a copy/paste of Core api.CroppedImageControl in /wp-admin/js/customize-control.js
     */
    initCropperFrame: function () {

      'use strict'

      // We get the field id from which this was called
      var currentFieldId = this.$thisButton.siblings('input.hidden-field').attr('data-field'),
        attrs = ['width', 'height', 'flex_width', 'flex_height'], // A list of attributes to look for
        libMediaType = this.getMimeType()

      // Make sure we got it
      if ('string' === typeof currentFieldId && '' !== currentFieldId) {

        // Make fields is defined and only do the hack for cropped_image
        if ('object' === typeof this.params.fields[currentFieldId] &&
          'cropped_image' === this.params.fields[currentFieldId].type) {

          //Iterate over the list of attributes
          attrs.forEach(function (el, index) {

            // If the attribute exists in the field
            if ('undefined' !== typeof this.params.fields[currentFieldId][el]) {

              // Set the attribute in the main object
              this.params[el] = this.params.fields[currentFieldId][el]
            }
          }.bind(this))
        }
      }

      this.frame = wp.media({
        button: {
          text: 'Select and Crop',
          close: false,
        },
        states: [
          new wp.media.controller.Library({
            library: wp.media.query({ type: libMediaType }),
            multiple: false,
            date: false,
            suggestedWidth: this.params.width,
            suggestedHeight: this.params.height,
          }),
          new wp.media.controller.CustomizeImageCropper({
            imgSelectOptions: this.calculateImageSelectOptions,
            control: this,
          }),
        ],
      })

      this.frame.on('select', this.onSelectForCrop, this)
      this.frame.on('cropped', this.onCropped, this)
      this.frame.on('skippedcrop', this.onSkippedCrop, this)

    },

    onSelect: function () {

      'use strict'

      var attachment = this.frame.state().get('selection').first().toJSON()

      if (this.$thisButton.closest('.repeater-field').hasClass('repeater-field-upload')) {
        this.setFileInRepeaterField(attachment)
      } else {
        this.setImageInRepeaterField(attachment)
      }
    },

    /**
     * After an image is selected in the media modal, switch to the cropper
     * state if the image isn't the right size.
     */

    onSelectForCrop: function () {

      'use strict'

      var attachment = this.frame.state().get('selection').first().toJSON()

      if (this.params.width === attachment.width && this.params.height === attachment.height &&
        !this.params.flex_width && !this.params.flex_height) {
        this.setImageInRepeaterField(attachment)
      } else {
        this.frame.setState('cropper')
      }
    },

    /**
     * After the image has been cropped, apply the cropped image data to the setting.
     *
     * @param {object} croppedImage Cropped attachment data.
     */
    onCropped: function (croppedImage) {

      'use strict'

      this.setImageInRepeaterField(croppedImage)

    },

    /**
     * Returns a set of options, computed from the attached image data and
     * control-specific data, to be fed to the imgAreaSelect plugin in
     * wp.media.view.Cropper.
     *
     * @param {wp.media.model.Attachment} attachment
     * @param {wp.media.controller.Cropper} controller
     * @returns {Object} Options
     */
    calculateImageSelectOptions: function (attachment, controller) {

      'use strict'

      var control = controller.get('control'),
        flexWidth = !!parseInt(control.params.flex_width, 10),
        flexHeight = !!parseInt(control.params.flex_height, 10),
        realWidth = attachment.get('width'),
        realHeight = attachment.get('height'),
        xInit = parseInt(control.params.width, 10),
        yInit = parseInt(control.params.height, 10),
        ratio = xInit / yInit,
        xImg = realWidth,
        yImg = realHeight,
        x1,
        y1,
        imgSelectOptions

      controller.set('canSkipCrop', !control.mustBeCropped(flexWidth, flexHeight, xInit, yInit, realWidth, realHeight))

      if (xImg / yImg > ratio) {
        yInit = yImg
        xInit = yInit * ratio
      } else {
        xInit = xImg
        yInit = xInit / ratio
      }

      x1 = (xImg - xInit) / 2
      y1 = (yImg - yInit) / 2

      imgSelectOptions = {
        handles: true,
        keys: true,
        instance: true,
        persistent: true,
        imageWidth: realWidth,
        imageHeight: realHeight,
        x1: x1,
        y1: y1,
        x2: xInit + x1,
        y2: yInit + y1,
      }

      if (false === flexHeight && false === flexWidth) {
        imgSelectOptions.aspectRatio = xInit + ':' + yInit
      }
      if (false === flexHeight) {
        imgSelectOptions.maxHeight = yInit
      }
      if (false === flexWidth) {
        imgSelectOptions.maxWidth = xInit
      }

      return imgSelectOptions
    },

    /**
     * Return whether the image must be cropped, based on required dimensions.
     *
     * @param {bool} flexW
     * @param {bool} flexH
     * @param {int}  dstW
     * @param {int}  dstH
     * @param {int}  imgW
     * @param {int}  imgH
     * @return {bool}
     */
    mustBeCropped: function (flexW, flexH, dstW, dstH, imgW, imgH) {

      'use strict'

      if (true === flexW && true === flexH) {
        return false
      }

      if (true === flexW && dstH === imgH) {
        return false
      }

      if (true === flexH && dstW === imgW) {
        return false
      }

      if (dstW === imgW && dstH === imgH) {
        return false
      }

      if (imgW <= dstW) {
        return false
      }

      return true
    },

    /**
     * If cropping was skipped, apply the image data directly to the setting.
     */
    onSkippedCrop: function () {

      'use strict'

      var attachment = this.frame.state().get('selection').first().toJSON()
      this.setImageInRepeaterField(attachment)

    },

    /**
     * Updates the setting and re-renders the control UI.
     *
     * @param {object} attachment
     */
    setImageInRepeaterField: function (attachment) {

      'use strict'

      var $targetDiv = this.$thisButton.closest('.repeater-field-image,.repeater-field-cropped_image')

      $targetDiv.find('.jeg-image-attachment').html('<img src="' + attachment.url + '">').hide().slideDown('slow')

      $targetDiv.find('.hidden-field').val(attachment.id)
      this.$thisButton.text(this.$thisButton.data('alt-label'))
      $targetDiv.find('.remove-button').show()

      //This will activate the save button
      $targetDiv.find('input, textarea, select').trigger('change')
      this.frame.close()

    },

    /**
     * Updates the setting and re-renders the control UI.
     *
     * @param {object} attachment
     */
    setFileInRepeaterField: function (attachment) {

      'use strict'

      var $targetDiv = this.$thisButton.closest('.repeater-field-upload')

      $targetDiv.find('.jeg-file-attachment').
        html('<span class="file"><span class="dashicons dashicons-media-default"></span> ' + attachment.filename +
          '</span>').
        hide().
        slideDown('slow')

      $targetDiv.find('.hidden-field').val(attachment.id)
      this.$thisButton.text(this.$thisButton.data('alt-label'))
      $targetDiv.find('.upload-button').show()
      $targetDiv.find('.remove-button').show()

      //This will activate the save button
      $targetDiv.find('input, textarea, select').trigger('change')
      this.frame.close()

    },

    getMimeType: function () {

      'use strict'

      // We get the field id from which this was called
      var currentFieldId = this.$thisButton.siblings('input.hidden-field').attr('data-field'),
        attrs = ['mime_type'] // A list of attributes to look for

      // Make sure we got it
      if ('string' === typeof currentFieldId && '' !== currentFieldId) {

        // Make fields is defined and only do the hack for cropped_image
        if ('object' === typeof this.params.fields[currentFieldId] &&
          ('upload' === this.params.fields[currentFieldId].type || 'upload_file' === this.params.fields[currentFieldId].type)) {

          // If the attribute exists in the field
          if ('undefined' !== typeof this.params.fields[currentFieldId].mime_type) {

            // Set the attribute in the main object
            return this.params.fields[currentFieldId].mime_type
          }
        }
      }

      return 'image'

    },

    removeImage: function (event) {

      'use strict'

      var $targetDiv,
        $uploadButton

      if (wp.customize.utils.isKeydownButNotEnterEvent(event)) {
        return
      }

      $targetDiv = this.$thisButton.closest(
        '.repeater-field-image,.repeater-field-cropped_image,.repeater-field-upload')
      $uploadButton = $targetDiv.find('.upload-button')

      $targetDiv.find('.jeg-image-attachment').slideUp('fast', function () {
        jQuery(this).show().html(jQuery(this).data('placeholder'))
      })
      $targetDiv.find('.hidden-field').val('')
      $uploadButton.text($uploadButton.data('label'))
      this.$thisButton.hide()

      $targetDiv.find('input, textarea, select').trigger('change')

    },

    removeFile: function (event) {

      'use strict'

      var $targetDiv,
        $uploadButton

      if (wp.customize.utils.isKeydownButNotEnterEvent(event)) {
        return
      }

      $targetDiv = this.$thisButton.closest('.repeater-field-upload')
      $uploadButton = $targetDiv.find('.upload-button')

      $targetDiv.find('.jeg-file-attachment').slideUp('fast', function () {
        jQuery(this).show().html(jQuery(this).data('placeholder'))
      })
      $targetDiv.find('.hidden-field').val('')
      $uploadButton.text($uploadButton.data('label'))
      this.$thisButton.hide()

      $targetDiv.find('input, textarea, select').trigger('change')

    },

    /**
     * Get the current value of the setting
     *
     * @return Object
     */
    getValue: function () {
      'use strict'

      // need to load the setting from JSON for first load
      if (JSON.parse(decodeURIComponent($(this.element).find('.data-setting').attr('value'))).length <= 0) {
        // The setting is saved in JSON
        return $.isArray(this.params.value) ? this.params.value : JSON.parse(decodeURIComponent(this.params.value))
      }

      return $.isArray($(this.element).find('.data-setting').attr('value')) ? $(this.element).
        find('.data-setting').
        attr('value') : JSON.parse(decodeURIComponent($(this.element).find('.data-setting').attr('value')))

    },

    /**
     * Set a new value for the setting
     *
     * @param newValue Object
     * @param refresh If we want to refresh the previewer or not
     * @param filtering
     */
    setValue: function (newValue, refresh, filtering) {
      'use strict'

      // We need to filter the values after the first load to remove data requrired for diplay but that we don't want to save in DB
      // need boolean filter to avoid null data on array after remove data
      var filteredValue = newValue.filter(Boolean),
        filter = []

      if (filtering) {
        jQuery.each(this.params.fields, function (index, value) {
          if ('image' === value.type || 'cropped_image' === value.type || 'upload' === value.type) {
            filter.push(index)
          }
        })
        jQuery.each(newValue, function (index, value) {
          jQuery.each(filter, function (ind, field) {
            if ('undefined' !== typeof value[field] && 'undefined' !== typeof value[field].id) {
              filteredValue[index][field] = value[field].id
            }
          })
        })
      }

      this.value.set(filteredValue)
      $(this.element).find('.data-setting').attr('value', encodeURI(JSON.stringify(filteredValue)))
    },

    /**
     * Add a new row to repeater settings based on the structure.
     *
     * @param data (Optional) Object of field => value pairs (undefined if you want to get the default values)
     */
    addRow: function (data) {

      'use strict'

      var control = this,
        template = control.repeaterTemplate(), // The template for the new row (defined on render_content() ).
        settingValue = this.getValue(), // Get the current setting value.
        newRowSetting = {}, // Saves the new setting data.
        templateData, // Data to pass to the template
        newRow,
        i

      if (template) {

        // The control structure is going to define the new fields
        // We need to clone control.params.fields. Assigning it
        // ould result in a reference assignment.
        templateData = jQuery.extend(true, {}, control.params.fields)

        // But if we have passed data, we'll use the data values instead
        if (data) {
          for (i in data) {
            if (data.hasOwnProperty(i) && templateData.hasOwnProperty(i)) {
              templateData[i]['default'] = data[i]
            }
          }
        }

        templateData.index = this.currentIndex

        // Append the template content
        template = template(templateData)

        // Create a new row object and append the element
        newRow = new RepeaterRow(
          control.currentIndex,
          jQuery(template).appendTo(control.repeaterFieldsContainer),
          control.params.row_label
        )

        newRow.container.on('row:remove', function (e, rowIndex) {
          control.deleteRow(rowIndex)
        })

        newRow.container.on('row:update', function (e, rowIndex, fieldName, element) {
          control.updateField.call(control, e, rowIndex, fieldName, element)
          newRow.updateLabel()
        })

        // Add the row to rows collection
        this.rows[this.currentIndex] = newRow

        for (i in templateData) {
          if (templateData.hasOwnProperty(i)) {
            newRowSetting[i] = templateData[i]['default']
          }
        }

        settingValue[this.currentIndex] = newRowSetting
        this.setValue(settingValue, true)
        this.currentIndex++
        return newRow
      }

    },

    sort: function () {

      'use strict'

      var control = this,
        $rows = this.repeaterFieldsContainer.find('.repeater-row'),
        newOrder = [],
        settings = control.getValue(),
        newRows = [],
        newSettings = []

      $rows.each(function (i, element) {
        newOrder.push(jQuery(element).data('row'))
      })

      jQuery.each(newOrder, function (newPosition, oldPosition) {
        newRows[newPosition] = control.rows[oldPosition]
        newRows[newPosition].setRowIndex(newPosition)

        newSettings[newPosition] = settings[oldPosition]
      })

      control.rows = newRows
      control.setValue(newSettings)

    },

    /**
     * Delete a row in the repeater setting
     *
     * @param index Position of the row in the complete Setting Array
     */
    deleteRow: function (index) {

      'use strict'

      var currentSettings = this.getValue(),
        row,
        i,
        prop

      if (currentSettings[index]) {

        // Find the row
        row = this.rows[index]
        if (row) {

          // The row exists, let's delete it

          // Remove the row settings
          delete currentSettings[index]

          // Remove the row from the rows collection
          delete this.rows[index]

          // Update the new setting values
          this.setValue(currentSettings, true)

        }

      }

      // Remap the row numbers
      i = 1
      for (prop in this.rows) {
        if (this.rows.hasOwnProperty(prop) && this.rows[prop]) {
          this.rows[prop].updateLabel()
          i++
        }
      }

    },

    /**
     * Update a single field inside a row.
     * Triggered when a field has changed
     *
     * @param e
     * @param rowIndex
     * @param fieldId
     * @param element
     */
    updateField: function (e, rowIndex, fieldId, element) {
      'use strict'

      var type,
        row,
        currentSettings

      if (!this.rows[rowIndex]) {
        return
      }

      if (!this.params.fields[fieldId]) {
        return
      }

      type = this.params.fields[fieldId].type
      row = this.rows[rowIndex]
      currentSettings = this.getValue()

      element = jQuery(element)

      if (undefined === typeof currentSettings[row.rowIndex][fieldId]) {
        return
      }

      if ('checkbox' === type) {
        currentSettings[row.rowIndex][fieldId] = element.is(':checked')

      } else {
        // Update the settings
        currentSettings[row.rowIndex][fieldId] = element.val()
      }

      this.setValue(currentSettings, true)

    },

    /**
     * Init the color picker on color fields
     * Called after AddRow
     *
     */
    initColorPicker: function () {

      'use strict'

      var control = this,
        colorPicker = control.element.find('.color-picker-hex'),
        options = {},
        fieldId = colorPicker.data('field')

      // We check if the color palette parameter is defined.
      if ('undefined' !== typeof fieldId && 'undefined' !== typeof control.params.fields[fieldId] &&
        'undefined' !== typeof control.params.fields[fieldId].palettes &&
        'object' === typeof control.params.fields[fieldId].palettes) {
        options.palettes = control.params.fields[fieldId].palettes
      }

      // When the color picker value is changed we update the value of the field
      options.change = function (event, ui) {

        var currentPicker = jQuery(event.target),
          row = currentPicker.closest('.repeater-row'),
          rowIndex = row.data('row'),
          currentSettings = control.getValue()

        currentSettings[rowIndex][currentPicker.data('field')] = ui.color.toString()
        control.setValue(currentSettings, true)

      }

      // Init the color picker
      if (0 !== colorPicker.length) {
        colorPicker.wpColorPicker(options)
      }

    },

    /**
     * Init the dropdown-pages field with selectize
     * Called after AddRow
     *
     * @param {object} theNewRow the row that was added to the repeater
     * @param {object} data the data for the row if we're initializing a pre-existing row
     *
     */
    initDropdownPages: function (theNewRow, data) {
      'use strict'

      var control = this,
        dropdown = theNewRow.container.find('.repeater-dropdown-pages select'),
        $select,
        selectize,
        dataField

      if (0 === dropdown.length) {
        return
      }

      $select = jQuery(dropdown).selectize()
      selectize = $select[0].selectize
      dataField = dropdown.data('field')

      if (data) {
        selectize.setValue(data[dataField])
      }

      this.element.on('change', '.repeater-dropdown-pages select', function (event) {

        var currentDropdown = jQuery(event.target),
          row = currentDropdown.closest('.repeater-row'),
          rowIndex = row.data('row'),
          currentSettings = control.getValue()

        currentSettings[rowIndex][currentDropdown.data('field')] = jQuery(this).val()
        control.setValue(currentSettings)

      })

    },


    initSlider: function (theNewRow, subValue) {
      'use strict'

      var control = this,
        slider = theNewRow.container.find('.repeater-slider-wrapper .jeg-number-range'),
        value

      if (subValue !== undefined) {
        if (jQuery.isEmptyObject(subValue['value'])) {
          value = slider.data('reset_value')
        }
        else {
          value = subValue['value']
        }
      }
      else {
        value = slider.data('reset_value')
      }


      slider.attr('value', value)
      slider.closest('div').find('.jeg_range_value .value').text(value)

      slider.on('mousedown', function () {
        $(this).mousemove(function () {
          var value = $(this).attr('value'),
            currentSlider = jQuery(event.target),
            row = currentSlider.closest('.repeater-row'),
            rowIndex = row.data('row'),
            currentSettings = control.getValue()

          $(this).closest('div').find('.jeg_range_value .value').text(value)
          $(this).attr('value', value)
          currentSettings[rowIndex]['value'] = jQuery(this).val()
          control.setValue(currentSettings)
        })
      })

      theNewRow.container.find('.jeg-slider-reset').on('click', function () {
        var thisInput = slider
        var inputDefault = thisInput.data('reset_value')
        thisInput.attr('value', inputDefault)
        thisInput.change()

        $(this).closest('div.repeater-slider-wrapper').find('.jeg_range_value .value').text(inputDefault)
      })
    },
  })

  //======================================//

  api.standartField = api.Fields.extend({})
  api.headingField = api.Fields.extend({})
  api.alertField = api.Fields.extend({})

  //======================================//

  api.checkblockField = api.Fields.extend({})

  //======================================//

  api.fieldConstructor = {
    text: api.textField,
    password: api.textField,
    color: api.colorField,
    select: api.selectField,
    checkbox: api.checkboxField,
    radioimage: api.radioImageField,
    slider: api.sliderField,
    iconpicker: api.iconPickerField,
    standart: api.standartField,
    heading: api.headingField,
    alert: api.alertField,
    textarea: api.textareaField,
    number: api.numberField,
    image: api.imageField,
    repeater: api.repeaterField,
    upload: api.uploadField,

    // Need to add this form
    // checkblock:         api.checkblockField,
  }

})(jQuery, wp.customize)
