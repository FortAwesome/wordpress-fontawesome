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
                  searchInputPlaceholder={__('Search for icons by name, category, or keyword', 'font-awesome')}
                >
                  <span slot='fatal-error-heading'>
                    { __('Well, this is awkward...', 'font-awesome') }
                  </span>
                  <span slot='fatal-error-detail'>
                    { __('Something has gone horribly wrong. Check the console for additional error information.', 'font-awesome') }
                  </span>
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
                  <span slot='search-field-label-free'>
                    {__('Search Font Awesome Free Icons in Version', 'font-awesome')}
                  </span>
                  <span slot='search-field-label-pro'>
                    {__('Search Font Awesome Pro Icons in Version', 'font-awesome')}
                  </span>
                  <span slot='searching-free'>
                    {__("You're searching Font Awesome Free icons in version", 'font-awesome')}
                  </span>
                  <span slot='searching-pro'>
                    {__("You're searching Font Awesome Pro icons in version", 'font-awesome')}
                  </span>
                  <span slot='light-requires-pro'>
                    {__('You need to use a Pro kit to get Light icons.', 'font-awesome')}
                  </span>
                  <span slot='thin-requires-pro'>
                    {__('You need to use a Pro kit with Version 6 to get Thin icons.', 'font-awesome')}
                  </span>
                  <span slot='duotone-requires-pro'>
                    {__('You need to use a Pro kit with Version 5.10 or later to get Duotone icons.', 'font-awesome')}
                  </span>
                  <span slot='uploaded-requires-pro'>
                    {__('You need to use a Pro kit to get Uploaded icons.', 'font-awesome')}
                  </span>
                  <span slot='kit-has-no-uploaded-icons'>
                    {__('This kit contains no uploaded icons.', 'font-awesome')}
                  </span>
                  <span slot='no-search-results-heading'>
                    {__("Sorry, we couldn't find anything for that.", 'font-awesome')}
                  </span>
                  <span slot='no-search-results-detail'>
                    {__('You might try a different search...', 'font-awesome')}
                  </span>
                  <span slot="suggest-icon-upload">
                    {
                      createInterpolateElement(
                        __( 'Or <a>upload your own icon</a> to a Pro kit!', 'font-awesome'),
                        {
                        // eslint-disable-next-line jsx-a11y/anchor-has-content
                        a: <a target="_blank" rel="noopener noreferrer" href="https://fontawesome.com/v5.15/how-to-use/on-the-web/using-kits/uploading-icons" />
                        }
                      )
                    }
                  </span>
                  <span slot='get-fontawesome-pro'>
                    {
                      createInterpolateElement(
                        __( 'Or <a>use Font Awesome Pro</a> for more icons and styles!', 'font-awesome'),
                        {
                        // eslint-disable-next-line jsx-a11y/anchor-has-content
                        a: <a target="_blank" rel="noopener noreferrer" href="https://fontawesome.com/" />
                        }
                      )
                    }
                  </span>
                  <span slot='initial-loading-view-heading'>
                    {__('Fetching icons', 'font-awesome') }
                  </span>
                  <span slot='initial-loading-view-detail'>
                    {__('When this thing gets up to 88 mph...', 'font-awesome')}
                  </span>
                </FaIconChooser>
              </Modal>
          ) }
      </>
  )
}

export default IconChooserModal
