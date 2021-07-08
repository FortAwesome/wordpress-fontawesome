import IconChooserModal from './IconChooserModal'
import { default as fallbackReactDom } from 'react-dom'
import { buildShortCodeFromIconChooserResult } from './shortcode'
import get from 'lodash/get'

export function handleSubmit(event) {
  const insert = get(window, 'wp.media.editor.insert')
  insert && insert( buildShortCodeFromIconChooserResult(event.detail) )
}

export function setupClassicEditor(params) {
  const {
    iconChooserContainerId,
    iconChooserMediaButtonId,
    modalOpenEvent,
    kitToken,
    version,
    pro,
    handleQuery
  } = params

  // TODO: decide what to do about these early-return error conditions.
  const mediaButton = document.querySelector(`#${iconChooserMediaButtonId}`)
  if(!mediaButton) return
  const container = document.querySelector(`#${iconChooserContainerId}`)
  if(!container) return
  if(!window.tinymce) return

  let wpComponentsStyleAdded = false

  if(!wpComponentsStyleAdded) {
    wpComponentsStyleAdded = true

    import('@wordpress/components/build-style/style.css')
    .then(() => {})
    .catch(err => {
      // TODO: what do we want to do about this error condition?
      console.error(err)
    })
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

  mediaButton.addEventListener('click', () => {
    document.dispatchEvent(modalOpenEvent)
  })

  const render = get(window, 'wp.element.render', fallbackReactDom.render)

  render(
    <IconChooserModal
      kitToken={ kitToken }
      version={ version }
      pro={ pro }
      modalOpenEvent={ modalOpenEvent }
      handleQuery={ handleQuery }
      onSubmit={ handleSubmit }
    />,
    container
  )
}
