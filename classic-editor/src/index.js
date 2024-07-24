import React from 'react'
import { createRoot } from 'react-dom/client'
import { buildShortCodeFromIconChooserResult } from './shortcode'
import get from 'lodash/get'
import { GLOBAL_KEY } from '../../admin/src/constants'

const { IconChooserModal } = get(window, [GLOBAL_KEY, 'iconChooser'], {});
const iconChooserContainerId = 'font-awesome-icon-chooser-container'

const modalOpenEvent = new Event("classicEditorFontAwesomeIconChooserOpen", {
  "bubbles": true,
  "cancelable": false,
});

const openIconChooser = () => {
  document.dispatchEvent(modalOpenEvent)
}

export function handleSubmit(event) {
  const insert = get(window, 'wp.media.editor.insert')
  insert && insert( buildShortCodeFromIconChooserResult(event.detail) )
}

function setupClassicEditor() {
  // TODO: make sure this setup happens only once per page, no matter how many
  // editors there are.
  const container = document.querySelector(`#${iconChooserContainerId}`)

  const root = createRoot(container)

  if(container) {
    root.render(
      <IconChooserModal
        onSubmit={ handleSubmit }
        openEvent={ modalOpenEvent }
      />
    )
  }
}

class FontAwesomeOfficialPlugin {
  constructor(editor, _url, _c) {
    // Probably what I should do here:
    // just let the [icon] shortcodes continue to be what's inserted here, for now.
    // and turn them into <i> tags or spans for visual mode.
    // and load the kit into the editor's iframe so that they are rendered in visual
    // mode. This would work whether they are sVG/JS or webfont/css
    editor.on('init', () => {
      const button = document.querySelector('button.font-awesome-icon-chooser-media-button')

      if(button) {
        button.addEventListener('click', openIconChooser)
      }

      // This allows SVGs like the following:
      /*
       * <span class="fa-icon"><svg class="svg-inline--fa" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z">&#xFFFD;</path></svg></span>
       *
       * Notice:
       * - the object replacement char 0xfffd is in there, as in the block editor's inline formats.
       * - the viewbox is lowercase (addValidElements doesn't respect it when it's viewBox)
       *
       * TODO: Need to figure out how to navigate the caret past the icon so it can be deleted.
       * Or to make it selectable by clicking.
      */
      // editor.schema.addValidElements('svg[class|viewbox|xmlns]')
      // editor.schema.addValidElements('path[class|d]')
    })

    setupClassicEditor()
  }
}

if(window.tinymce) {
  tinymce.PluginManager.add('font-awesome-official', FontAwesomeOfficialPlugin)
}
