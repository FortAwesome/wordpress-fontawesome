import React from 'react'
import { createRoot } from 'react-dom/client'
import { buildShortCodeFromIconChooserResult } from './shortcode'
import { get } from 'lodash'
import { GLOBAL_KEY } from '../../admin/src/constants'
import createCustomEvent from '../../block-editor/src/createCustomEvent'
import { __ } from '@wordpress/i18n'

const { IconChooserModal } = get(window, [GLOBAL_KEY, 'iconChooser'], {})

const ICON_CHOOSER_OPEN_MODAL_BY_EDITOR_ID = {}

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

function getIconChooserOpenModal(editorId) {
  if (ICON_CHOOSER_OPEN_MODAL_BY_EDITOR_ID[editorId]) {
    return ICON_CHOOSER_OPEN_MODAL_BY_EDITOR_ID[editorId]
  }

  const editor = document.querySelector(`#${editorId}`)
  const editorContainer = editor?.parentElement

  if (!editorContainer) {
    // The editor might be hidden. Bail early.
    return
  }

  const openIconChooser = newIconChooser(editorId, editorContainer, (editorId, content) => {
    insertContentIntoEditor(editorId, content)
  })

  ICON_CHOOSER_OPEN_MODAL_BY_EDITOR_ID[editorId] = openIconChooser

  return openIconChooser
}

// Using jQuery seems to be the more idiomatic way to bind click events to the media button
// in the WordPress editor. Doing it this way seems to resolve a conflict with the ACF plugin,
// where our click event binding on the media button seemed to be removed on us.
jQuery(document).on('click', '.font-awesome-icon-chooser-media-button', function(e) {
  const editorId = e.target.getAttribute('data-fa-editor-id')
  const iconChooserOpenModal = getIconChooserOpenModal(editorId)
  // This setTimeout allow for the React component that is the Icon Chooser to be mounted
  // and ready to receive the event. After the timeout expires, then the "open" event is dispatched.
  // Without this, the event is dispatched before the React component is mounted and ready to receive it.
  setTimeout(iconChooserOpenModal, 0)
});
