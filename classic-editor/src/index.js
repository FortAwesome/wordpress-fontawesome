import React from 'react'
import { createRoot } from 'react-dom/client'
import { buildShortCodeFromIconChooserResult } from './shortcode'
import { get } from 'lodash'
import { GLOBAL_KEY } from '../../admin/src/constants'
import createCustomEvent from '../../block-editor/src/createCustomEvent'
import { __ } from '@wordpress/i18n'

const { IconChooserModal } = get(window, [GLOBAL_KEY, 'iconChooser'], {})

// Creates a new icon chooser with its own open event and submit handler.
function newIconChooser(editorId, container, editorInsert) {
  const modalOpenEvent = createCustomEvent()

  const openIconChooser = () => {
    document.dispatchEvent(modalOpenEvent)
  }

  function handleSubmit(event) {
    editorInsert(editorId, buildShortCodeFromIconChooserResult(event.detail))
  }

  const iconChooserWrapper = document.createElement('div')

  container.appendChild(iconChooserWrapper)

  const root = createRoot(iconChooserWrapper)

  root.render(
    <IconChooserModal
      onSubmit={handleSubmit}
      openEvent={modalOpenEvent}
    />
  )

  return openIconChooser
}

function isVisible(textarea) {
  const computedStyle = window.getComputedStyle(textarea)
  if (computedStyle.display === 'none') {
    return false
  }

  if (computedStyle.visibility === 'hidden') {
    return false
  }

  const rect = textarea.getBoundingClientRect()
  if (rect.width === 0 || rect.height === 0) {
    return false
  }

  return true
}

// Determine whether it's a TinyMCE editor or QTags editor, and
// insert the content accordingly.
function insertContentIntoEditor(editorId, content) {
  const tinymceEditor = get(window, `tinymce.editors.${editorId}`)

  if (tinymceEditor && !tinymceEditor.hidden) {
    tinymceEditor.insertContent(content)
    return
  }

  const qtagsEditor = window.QTags && QTags.getInstance(editorId)
  const isQtagsEditorVisible = isVisible(qtagsEditor.canvas)

  if (qtagsEditor && isQtagsEditorVisible) {
    QTags.insertContent(content, editorId)
  }
}

function initialize() {
  const editorIds = get(window, '__FontAwesomeOfficialPlugin_tinymce__.editors', [])

  for (const editorId of editorIds) {
    const button = document.querySelector(`#fawp-tinymce-${editorId}`)
    const editor = document.querySelector(`#${editorId}`)
    const editorContainer = editor.parentElement

    if (!editor || !button || !editorContainer) {
      console.error(__('Font Awesome Plugin: could not attach to editor id:', 'font-awesome'), editorId)
      continue
    }

    const openIconChooser = newIconChooser(editorId, editorContainer, (editorId, content) => {
      insertContentIntoEditor(editorId, content)
    })

    button.addEventListener('click', openIconChooser)
  }
}

if (document.readyState === 'complete') {
  initialize()
} else {
  window.addEventListener('DOMContentLoaded', () => {
    initialize()
  })
}
