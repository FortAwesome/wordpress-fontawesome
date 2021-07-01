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

    const { apiNonce, rootUrl, restApiNamespace } = window['__FontAwesomeOfficialPlugin_EditorSupportConfig__']

    // If apiFetch is from wp.apiFetch, it may already have RootURLMiddleware set up.
    // If we're using the fallback (i.e. when running in the Classic Editor), then
    // it doesn't yet have thr RootURLMiddleware.
    // We want to guarantee that it's there, so we'll always add it.
    // So what if it was already there? Experiment seems to have shown that this
    // is idempotent. It doesn't seem to hurt to just do it again, so we will.
    apiFetch.use( apiFetch.createRootURLMiddleware( rootUrl ) )

    // We need the nonce to be set up because we're going to run our query through
    // the API controller end point, which requires non-public authorization.
    apiFetch.use( apiFetch.createNonceMiddleware( apiNonce ) )

    return await apiFetch( {
      path: `${restApiNamespace}/api`,
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
