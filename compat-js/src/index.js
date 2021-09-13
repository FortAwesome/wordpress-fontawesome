import React from 'react'
import ReactDOM from 'react-dom'
import * as i18n from '@wordpress/i18n'
import * as element from '@wordpress/element'
import * as components from '@wordpress/components'
import apiFetch from '@wordpress/api-fetch'
import domReady from '@wordpress/dom-ready'

window.__Font_Awesome_Webpack_Externals__ = {
  ...(window.__Font_Awesome_Webpack_Externals__ || {}),
  React,
  ReactDOM,
  i18n,
  element,
  components,
  apiFetch,
  domReady
}
