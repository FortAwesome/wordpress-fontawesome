import React from 'react'
import { createRoot } from 'react-dom/client'
import { buildShortCodeFromIconChooserResult } from './shortcode'
import get from 'lodash-es/get'
import { GLOBAL_KEY } from '../../admin/src/constants'
import createCustomEvent from '../../block-editor/src/createCustomEvent'
import { __ } from '@wordpress/i18n'

const { IconChooserModal } = get(window, [GLOBAL_KEY, 'iconChooser'], {})

// Creates a new icon chooser with its own open event and submit handler.
function newIconChooser(editor) {
  if ('function' !== typeof editor?.insertContent) {
    console.error(__('Font Awesome Plugin: failed to initialize TinyMCE plugin.', 'font-awesome'))
    return () => {}
  }

  const modalOpenEvent = createCustomEvent()

  const openIconChooser = () => {
    document.dispatchEvent(modalOpenEvent)
  }

  function handleSubmit(event) {
    editor.insertContent(buildShortCodeFromIconChooserResult(event.detail))
  }

  const container = editor.container
  const iconChooserWrapper = document.createElement('div')
  container.appendChild(iconChooserWrapper)

  const root = createRoot(iconChooserWrapper)

  if (container) {
    root.render(
      <IconChooserModal
        onSubmit={handleSubmit}
        openEvent={modalOpenEvent}
      />
    )
  }

  return openIconChooser
}

class FontAwesomeOfficialPlugin {
  constructor(editor, _url, _c) {
    editor.on('init', () => {
      const button = document.querySelector(`#fawp-tinymce-${editor.id}`)

      if (!button) {
        console.error(__('Font Awesome Plugin: no Font Awesome media button found for TinyMCE editor id:', 'font-awesome'), editor.id)
        return
      }

      const openIconChooser = newIconChooser(editor)

      if (button) {
        button.addEventListener('click', openIconChooser)
      }
    })
  }
}

if (window.tinymce) {
  tinymce.PluginManager.add('font-awesome-official', FontAwesomeOfficialPlugin)
}
