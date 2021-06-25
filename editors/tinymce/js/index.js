import handleSubmit from './handleSubmit'
import { handleQuery, ICON_CHOOSER_CONTAINER_ID, ICON_CHOOSER_MEDIA_BUTTON_ID } from '../../shared'
import React from 'react'
import { Modal } from '@wordpress/components'
import { useState } from '@wordpress/element'
import { FaIconChooser } from '@fortawesome/fa-icon-chooser-react'
import { createElement, render } from '@wordpress/element'
import css from '@wordpress/components/build-style/style.css'
import get from 'lodash/get'

( function() {
  const mediaButton = document.querySelector(`#${ICON_CHOOSER_MEDIA_BUTTON_ID}`)
  if(!mediaButton) return
  const container = document.querySelector(`#${ICON_CHOOSER_CONTAINER_ID}`)
  if(!container) return

  let wpComponentsStyleAdded = false

  if(window._ && !window._.pluck && window._.map) {
    // Polyfill.
    // See the lodash changelog:
    // https://github.com/lodash/lodash/wiki/Changelog
    //
    // The version of tinymce that ships with the Classic Editor plugin v1.6
    // throws an erroor in the JavaScript console when it tries to use the non-existent
    // _.pluck
    window._.pluck = window._.map
  }

  if(!wp) {
    window.wp = {}
  }

  if(!wp.element) {
    wp.element = {
      createElement,
      render
    }
  }

  if(!wpComponentsStyleAdded && !get(window, 'wp.components')) {
    const style = document.createElement('style')
    style.setAttribute('type', 'text/css')
    const text = document.createTextNode(css.toString())
    style.appendChild(text)
    document.head.appendChild(style)
    wpComponentsStyleAdded = true
  } 

  const IconChooserModal = () => {
    const [ isOpen, setOpen ] = useState( false )

    mediaButton.addEventListener('click', () => setOpen(true))

    const closeModal = () => setOpen( false )

    const submitAndCloseModal = (result) => {
      handleSubmit(result)
      closeModal()
    }
  
    return (
        <>
            { isOpen && (
                <Modal title="Font Awesome" onRequestClose={ closeModal }>
                  <FaIconChooser version="5.15.3" cdnUrl="https://example.com/all.js" handleQuery={ handleQuery } onFinish={ result => submitAndCloseModal(result) }></FaIconChooser>
                </Modal>
            ) }
        </>
    )
  }

  render(
    <IconChooserModal/>,
    container
  )
} ( ) )
