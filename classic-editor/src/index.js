import React from 'react'
import ReactDOM from 'react-dom'
import { buildShortCodeFromIconChooserResult } from './shortcode'
import get from 'lodash/get'
import { GLOBAL_KEY } from '../../admin/src/constants'

const { IconChooserModal, modalOpenEvent } = get(window, [GLOBAL_KEY, 'iconChooser'], {});
const iconChooserContainerId = 'font-awesome-icon-chooser-container'
const iconChooserMediaButtonClass = 'font-awesome-icon-chooser-media-button'

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

/**
 * Tiny MCE will probably be loaded later, but since this code runs async,
 * we can't guarantee the timing. So if this runs first, it will set this
 * global to a function that the post-tiny-mce inline code can invoke.
 * But if that code runs first, it will set this global to some truthy value,
 * which tells us to invoke this setup immediately.
 */
if( window['__FontAwesomeOfficialPlugin__setupClassicEditorIconChooser'] ) {
  setupClassicEditor()
} else {
  window['__FontAwesomeOfficialPlugin__setupClassicEditorIconChooser'] = setupClassicEditor
}
