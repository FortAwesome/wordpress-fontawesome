import { default as fallbackApiFetch } from '@wordpress/api-fetch'
import { default as FallbackReact } from 'react'
import { Modal as FallbackModal } from '@wordpress/components'
import { useState as fallbackUseState } from '@wordpress/element'
import { FaIconChooser } from '@fortawesome/fa-icon-chooser-react' 
import get from 'lodash/get'

const React = get(window, 'React', FallbackReact)
const useState = get(window, 'wp.element.useState', fallbackUseState)
const Modal = get(window, 'wp.components.Modal', FallbackModal)
const apiFetch = get(window, 'wp.apiFetch', fallbackApiFetch)

export const ICON_CHOOSER_CONTAINER_ID = 'font-awesome-icon-chooser-container'

export const ICON_CHOOSER_MEDIA_BUTTON_ID = 'font-awesome-icon-chooser-media-button'

export const MODAL_OPEN_EVENT = new Event('fontAwesomeIconChooserOpen', { "bubbles": true, "cancelable": false })

export async function handleQuery(query) {
  try {
    if(!window['__FontAwesomeOfficialPlugin_EditorSupportConfig__']) {
      // TODO: figure out what to do with this error message for real.
      throw new Error('Font Awesome: missing require configuration')
    }

    const { apiNonce, apiUrl } = window['__FontAwesomeOfficialPlugin_EditorSupportConfig__']

    apiFetch.use( apiFetch.createNonceMiddleware( apiNonce ) )

    return await apiFetch( {
      path: `${apiUrl}/api`,
      method: 'POST',
      body: query
    } )
  } catch( error ) {
    console.error('CAUGHT:', error)
    throw new Error(error)
  }
}

export const IconChooserModal = ({ onSubmit }) => {
  if(!window['__FontAwesomeOfficialPlugin_EditorSupportConfig__']) {
    // TODO: figure out what to do with this error message for real.
    throw new Error('Font Awesome: missing require configuration')
  }

  const [ isOpen, setOpen ] = useState( false )

  const { cdnUrl, integrity, kitToken, usingPro, version } = window['__FontAwesomeOfficialPlugin_EditorSupportConfig__']

  document.addEventListener(MODAL_OPEN_EVENT.type, () => setOpen(true))

  const closeModal = () => setOpen( false )

  const submitAndCloseModal = (result) => {
    if('function' === typeof onSubmit) {
      onSubmit(result)
    }
    closeModal()
  }

  return (
      <>
          { isOpen && (
              <Modal title="Add Font Awesome Icon" onRequestClose={ closeModal }>
                <FaIconChooser
                  version={ version }
                  pro={ usingPro === "1" }
                  cdnUrl={ cdnUrl }
                  kitToken={ kitToken }
                  integrity={ integrity }
                  handleQuery={ handleQuery }
                  onFinish={ result => submitAndCloseModal(result) }
                ></FaIconChooser>
              </Modal>
          ) }
      </>
  )
}
