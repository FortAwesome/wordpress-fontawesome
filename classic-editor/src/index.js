import React from 'react'
import ReactDOM from 'react-dom'
import { buildShortCodeFromIconChooserResult } from './shortcode'
import get from 'lodash/get'
import { GLOBAL_KEY } from '../../admin/src/constants'

const { IconChooserModal, modalOpenEvent } = get(window, [GLOBAL_KEY, 'iconChooser'], {});
const iconChooserContainerId = 'font-awesome-icon-chooser-container'

export function handleSubmit(event) {
  const insert = get(window, 'wp.media.editor.insert')
  insert && insert( buildShortCodeFromIconChooserResult(event.detail) )
}

function setupClassicEditor() {
  const container = document.querySelector(`#${iconChooserContainerId}`)

  if(container) {
    ReactDOM.render(
      <IconChooserModal
        onSubmit={ handleSubmit }
      />,
      container
    )
  }
}

class FontAwesomeOfficialPlugin {
  constructor(_editor, _url, _c) {
    setupClassicEditor()
  }
}

if(window.tinymce) {
  tinymce.PluginManager.add('font-awesome-official', FontAwesomeOfficialPlugin)
}
