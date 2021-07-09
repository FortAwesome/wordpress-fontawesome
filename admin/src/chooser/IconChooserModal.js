import { default as FallbackReact, useState as fallbackUseState } from 'react'
import { Modal as FallbackModal } from '@wordpress/components'
import { FaIconChooser } from '@fortawesome/fa-icon-chooser-react' 
import { __ as FallbackI18n } from '@wordpress/i18n'
import get from 'lodash/get'

const React = get(window, 'React', FallbackReact)
const useState = get(window, 'wp.element.useState', fallbackUseState)
const Modal = get(window, 'wp.components.Modal', FallbackModal)
const __ = get(window, 'wp.i18n.__', FallbackI18n)

const IconChooserModal = (props) => {
  const { onSubmit, kitToken, version, pro, handleQuery, modalOpenEvent, getUrlText } = props
  const [ isOpen, setOpen ] = useState( false )

  document.addEventListener(modalOpenEvent.type, () => setOpen(true))

  const closeModal = () => setOpen( false )

  const submitAndCloseModal = (result) => {
    if('function' === typeof onSubmit) {
      onSubmit(result)
    }
    closeModal()
  }

  const isProCdn = !!pro && !kitToken

  return (
      <>
          { isOpen && (
              <Modal title="Add Font Awesome Icon" onRequestClose={ closeModal }>
                {
                  isProCdn &&
                  <div>
                    { __( 'UX TODO: mention the Pro icons are only available in the Icon Chooser when the WordPress plugin is configured ot use a Pro *Kit* (not Pro CDN).', 'font-awesome' ) }
                  </div>
                }
                <FaIconChooser
                  version={ version }
                  kitToken={ kitToken }
                  handleQuery={ handleQuery }
                  getUrlText={ getUrlText }
                  onFinish={ result => submitAndCloseModal(result) }
                ></FaIconChooser>
              </Modal>
          ) }
      </>
  )
}

export default IconChooserModal
