import React from 'react'
import ReactDOM from 'react-dom'
import ErrorBoundary from './ErrorBoundary'
import FontAwesomeAdminView from './FontAwesomeAdminView'
import { Provider } from 'react-redux'
import domReady from '@wordpress/dom-ready'

export default function(store) {
  domReady(() =>
    ReactDOM.render(
      <ErrorBoundary>
        <Provider store={ store }>
          <FontAwesomeAdminView/>
        </Provider>
      </ErrorBoundary>,
      document.getElementById('font-awesome-admin')
    )
  )
}
