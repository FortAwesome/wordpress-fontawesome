import IconChooserModal from './IconChooserModal'
import { render as fallbackRender} from '@wordpress/element'
import { buildShortCodeFromIconChooserResult } from './shortcode'
import css from '@wordpress/components/build-style/style.css'
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
    cdnUrl,
    integrity,
    version,
    usingPro,
    handleQuery
  } = params
  // TODO: decide what to do about these early-return error conditions.
  const mediaButton = document.querySelector(`#${iconChooserMediaButtonId}`)
  if(!mediaButton) return
  const container = document.querySelector(`#${iconChooserContainerId}`)
  if(!container) return
  if(!window.tinymce) return

  let wpComponentsStyleAdded = false

  if(!wpComponentsStyleAdded && !get(window, 'wp.components')) {
    const style = document.createElement('style')
    style.setAttribute('type', 'text/css')
    const text = document.createTextNode(css.toString())
    style.appendChild(text)
    document.head.appendChild(style)
    wpComponentsStyleAdded = true
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

  const render = get(window, 'wp.element.render', fallbackRender)

  render(
    <IconChooserModal
      kitToken={ kitToken }
      cdnUrl={ cdnUrl }
      integrity={ integrity }
      version={ version }
      usingPro={ usingPro }
      modalOpenEvent={ modalOpenEvent }
      handleQuery={ handleQuery }
      onSubmit={ handleSubmit }
    />,
    container
  )
}
