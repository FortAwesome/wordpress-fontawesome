import React from 'react'
import ReactDOM from 'react-dom'
import IconChooserModal from './IconChooserModal'
import { buildShortCodeFromIconChooserResult } from './shortcode'
import get from 'lodash/get'

export function handleSubmit(event) {
  const insert = get(window, 'wp.media.editor.insert')
  insert && insert( buildShortCodeFromIconChooserResult(event.detail) )
}

export function setupClassicEditor(params) {
  const {
    iconChooserContainerId,
    modalOpenEvent,
    kitToken,
    version,
    pro,
    handleQuery,
    getUrlText,
    settingsPageUrl
  } = params

  const container = document.querySelector(`#${iconChooserContainerId}`)
  if(!container) return
  if(!window.tinymce) return

  let wpComponentsStyleAdded = false

  if(!wpComponentsStyleAdded) {
    wpComponentsStyleAdded = true

    import('@wordpress/components/build-style/style.css')
    .then(() => {})
    .catch(err =>
      console.error(
        'Font Awesome Plugin failed to load styles for the Icon Chooser in the Classic Editor',
        err
      )
    )
  }

  // TODO: consider how to add Font Awesome to the Tiny MCE visual pane.
  // But there maybe unexpected behaviors.
  /*
  const editor = tinymce.activeEditor

  editor.on('init', e => {
    const script = editor.dom.doc.createElement('script')
    script.setAttribute('src', 'https://kit.fontawesome.com/fakekit.js')
    script.setAttribute('crossorigin', 'anonymous')
    editor.dom.doc.head.appendChild(script)
  })
  */

  ReactDOM.render(
    <IconChooserModal
      kitToken={ kitToken }
      version={ version }
      pro={ pro }
      modalOpenEvent={ modalOpenEvent }
      handleQuery={ handleQuery }
      settingsPageUrl={ settingsPageUrl }
      onSubmit={ handleSubmit }
      getUrlText={ getUrlText }
    />,
    container
  )
}
