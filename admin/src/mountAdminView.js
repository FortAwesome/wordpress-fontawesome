import React from 'react'
import { createRoot } from 'react-dom/client'
import ErrorBoundary from './ErrorBoundary'
import FontAwesomeAdminView from './FontAwesomeAdminView'
import { Provider } from 'react-redux'
import domReady from '@wordpress/dom-ready'

const root = createRoot(document.getElementById('font-awesome-admin'))

export default function (store) {
  domReady(() =>
    root.render(
      <ErrorBoundary>
        <Provider store={store}>
          <FontAwesomeAdminView />
        </Provider>
      </ErrorBoundary>
    )
  )
}
