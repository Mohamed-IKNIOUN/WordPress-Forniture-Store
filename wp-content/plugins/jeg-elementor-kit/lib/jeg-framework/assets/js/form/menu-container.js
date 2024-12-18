(function ($, api) {
  'use strict'

  /*********************************************************************************************************************
   * Menu Segment
   */
  api.menuSegment = api.normalSegment.extend({
    /**
     * Embed element
     */
    embed: function () {
      var segment = this

      segment.element = $(segment.renderContent())
      segment.holder = segment.getParentContainer().find(segment.getParentSegmentHolder())
      segment.holder.append(segment.element)

      segment.deferred.embedded.resolve()
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
      var option = this.params.container.option
      field.fieldID = api.helper.format(option['fieldIDPattern'], option['inputName'], this.params.container.id,
        data.id)
      field.fieldName = api.helper.format(option['fieldNamePattern'], option['inputName'], this.params.container.id,
        data.id)
      field.container = this

      return field
    },
  })

  api.segmentConstructor['menu'] = api.menuSegment

  /*********************************************************************************************************************
   * Menu Container
   */

  api.menucontainer = new api.Values({ defaultConstructor: api.MenuContainer })

  api.MenuContainer = api.BaseContainer.extend({

    /**
     * Container pane. Here to inject new element
     */
    containerPaneParent: '.jeg-form-wrapper',

    /**
     * Load ajax Promise
     */
    loadContainer: function () {
      var menuContainer = this
      menuContainer.promise = $.Deferred()

      var load = menuContainer.loadData()
      load.done(menuContainer.dataLoaded.bind(this))

      return this.promise
    },

    /**
     * Execute Ajax Call
     *
     * @returns {*|$.promise}
     */
    loadData: function () {
      var menuContainer = this

      return wp.ajax.send('load_menu', {
        data: {
          menu: menuContainer.id,
          nonce: menuContainer.option.nonce,
        },
      })
    },

    /**
     * Data loaded
     *
     * @param response
     */
    dataLoaded: function (response) {
      this.option = $.extend(response, this.option)

      $(this.element).find('.jeg-form-loader').remove()

      // Segment
      this.populateSegments(this.option.segments)

      // trigger finish
      this.triggerFinish()
    },

    /**
     * Set Container Holder
     */
    setContainerHolder: function () {
      this.containerHolder = api.menucontainer
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
      segment.parent = this.id
      segment.container = this

      return segment
    },
  })

  window.jeg = window.jeg || {}
  jeg.menu = {}

  /**
   * When Sort Menu Update
   */
  jeg.menu.sortUpdate = function (event, ui) {
    setTimeout(() => {
      var prevItem = ui.item.prev(),
        prevItemDepth = prevItem.menuItemDepth(),
        itemDepth = ui.item.menuItemDepth();

      if (prevItemDepth < itemDepth) {
        prevItem.addClass('have-child');
      } else {
        prevItem.removeClass('have-child');
      }
    })
  }

  /**
   *
   * @param parent
   */
  jeg.menu.build = function (parent) {
    var id = $(parent).find('.menu-item-data-db-id').val()

    if (!api.menucontainer.has(id)) {
      var option = window.jegMenuOptions

      api.menucontainer.add(id, new api.MenuContainer(id, parent, option))
    }
  }

  /**
   * Override menu behavior, when button clicked, build required menu option
   */
  jeg.menu.overrideMenuBehavior = function () {
    if (undefined !== window.wpNavMenu) {
      window.wpNavMenu.eventOnClickEditLink = function (clickedEl) {
        var settings, item,
          matchedSection = /#(.*)$/.exec(clickedEl.href)
        if (matchedSection && matchedSection[1]) {
          settings = $('#' + matchedSection[1])
          item = settings.parent()
          if (0 !== item.length) {
            if (item.hasClass('menu-item-edit-inactive')) {
              if (!settings.data('menu-item-data')) {
                settings.data('menu-item-data', settings.getItemData())
              }
              settings.slideDown('fast')
              item.removeClass('menu-item-edit-inactive').addClass('menu-item-edit-active')
            } else {
              settings.slideUp('fast')
              item.removeClass('menu-item-edit-active').addClass('menu-item-edit-inactive')
            }
            var parent = $(clickedEl).parents('.menu-item')
            jeg.menu.build(parent)
            return false
          }
        }
      }
    }
  }

  /**
   * Override Menu Behavior On Window Load
   */
  jeg.menu.overrideMenuBehaviorOnWindowLoad = function () {
    if (undefined !== window.wpNavMenu) {
      if (undefined !== window.wpNavMenu.menuList) {
        window.wpNavMenu.menuList.on('sortstop', function (event, ui) {
          jeg.menu.sortUpdate(event, ui)
        })
      }
    }
  }

  /**
   * Initialize Menu
   */
  jeg.menu.init = function () {
    jeg.menu.overrideMenuBehavior()
  };

  (function () {
    $(document).on('ready', jeg.menu.init())
    $(window).on('load', () => { jeg.menu.overrideMenuBehaviorOnWindowLoad() })
  })()

})(jQuery, wp.customize)