(function (api) {
  'use strict'

  if (!api.redirectTag) {
    api.redirectTag = {}
  }

  api.redirectTag = {
    dialogOpen: false,
  }

  api.redirectTag.registerTag = function (object) {
    api(object.id, function (setting) {
      setting.bind(function () {
        api.redirectTag.handleChange(object.redirect, object.refresh)
      })
    })
  }

  api.redirectTag.handleChange = function (tag, refresh) {
    var redirect = outputSetting.redirectTag[tag]

    if (!redirect.flag) {
      if (!api.redirectTag.dialogOpen) {
        api.redirectTag.dialogOpen = true
        vex.dialog.confirm({
          message: outputSetting.redirectSetting.changeNotice,
          showCloseButton: false,
          callback: function (value) {
            if (value) {
              api.redirectTag.redirectPreview(redirect.url)
            } else {
              api.redirectTag.dialogOpen = false
              api.redirectTag.refreshPreviewer(refresh, redirect.flag)
            }
          },
        })
      }
    } else {
      api.redirectTag.refreshPreviewer(refresh, redirect.flag)
    }
  }

  /**
   * Redirect Previewer to appropriate URL
   *
   * @param url
   */
  api.redirectTag.redirectPreview = function (url) {
    var customizerpreview = new api.Preview({
      url: url,
      channel: api.settings.channel,
    })

    customizerpreview.send('scroll', 0)
    customizerpreview.send('url', url)
  }

  /**
   * Force Refresh previewer
   *
   * @param refresh
   * @param flag
   */
  api.redirectTag.refreshPreviewer = function (refresh, flag) {
    if (refresh && flag) {
      if(api.previewer) {
        api.previewer.refresh()
      } else {
        api.preview.send('refresh')
      }
    }
  }

  /**
   * Bind Setting for partial refresh
   */
  api.redirectTag.initialize = function () {
    api.preview.bind('register-redirect-tag', function (object) {
      api.redirectTag.registerTag(object)
    })

    api.preview.bind('register-all-redirect-tag', function (objects) {
      _.each(objects, function (object) {
        api.redirectTag.registerTag(object)
      })
    })
  }

  /**
   * Initialize partial refresh
   */
  api.bind('preview-ready', function () {
    api.redirectTag.initialize()
  })
})(wp.customize)
