import { default as FallbackReact, useState as fallbackUseState } from 'react'
import { Modal as FallbackModal } from '@wordpress/components'
import { FaIconChooser } from '@fortawesome/fa-icon-chooser-react'
import { __ as FallbackI18n } from '@wordpress/i18n'
import get from 'lodash/get'
import { createInterpolateElement } from '@wordpress/element'

const React = get(window, 'React', FallbackReact)
const useState = get(window, 'wp.element.useState', fallbackUseState)
const Modal = get(window, 'wp.components.Modal', FallbackModal)
const __ = get(window, 'wp.i18n.__', FallbackI18n)

const IconChooserModal = (props) => {
  const { onSubmit, kitToken, version, pro, handleQuery, modalOpenEvent, getUrlText, settingsPageUrl } = props
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
              <Modal title="Add a Font Awesome Icon" onRequestClose={ closeModal }>
                {
                  isProCdn &&
                  <div style={{ margin: '1em', backgroundColor: '#FFD200', padding: '1em', borderRadius: '.5em', fontSize: '15px'}}>
                    {__( 'Looking for Pro icons and styles? You’ll need to use a kit. ', 'font-awesome' ) }

                    <a href={settingsPageUrl}>{__('Go to Font Awesome Plugin Settings', 'font-awesome')}</a>
                  </div>
                }
                <FaIconChooser
                  version={ version }
                  kitToken={ kitToken }
                  handleQuery={ handleQuery }
                  getUrlText={ getUrlText }
                  onFinish={ result => submitAndCloseModal(result) }
                >
                  <span slot="start-view-heading">
                    {__( "Font Awesome is the web's most popular icon set, with tons of icons in a variety of styles.", 'font-awesome' ) }
                  </span>
                  <span slot="start-view-detail">
                    {
                      createInterpolateElement(
                        __( "Not sure where to start? Here are some favorites, or try a search for <strong>spinners</strong>, <strong>animals</strong>, <strong>food</strong>, or <strong>whatever you're looking for</strong>.", 'font-awesome'),
                        {
                          strong: <strong/>
                        }
                      )
                    } 
                  </span>
                </FaIconChooser>
              </Modal>
          ) }
      </>
  )
}

export default IconChooserModal
