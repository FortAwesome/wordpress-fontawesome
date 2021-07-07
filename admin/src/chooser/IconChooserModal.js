import { default as FallbackReact, useState as fallbackUseState } from 'react'
import { Modal as FallbackModal } from '@wordpress/components'
import { FaIconChooser } from '@fortawesome/fa-icon-chooser-react' 
import get from 'lodash/get'

const React = get(window, 'React', FallbackReact)
const useState = get(window, 'wp.element.useState', fallbackUseState)
const Modal = get(window, 'wp.components.Modal', FallbackModal)

const IconChooserModal = (props) => {
  const { onSubmit, kitToken, version, handleQuery, modalOpenEvent } = props
  const [ isOpen, setOpen ] = useState( false )

  document.addEventListener(modalOpenEvent.type, () => setOpen(true))

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
                  kitToken={ kitToken }
                  handleQuery={ handleQuery }
                  onFinish={ result => submitAndCloseModal(result) }
                ></FaIconChooser>
              </Modal>
          ) }
      </>
  )
}

export default IconChooserModal
