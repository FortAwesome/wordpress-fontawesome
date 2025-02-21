import React from 'react'
import ReactDOM from 'react-dom'
import { createRoot } from 'react-dom/client'
import ErrorBoundary from './ErrorBoundary'
import FontAwesomeAdminView from './FontAwesomeAdminView'
import { Provider } from 'react-redux'
import domReady from '@wordpress/dom-ready'

const isAtLeastReact18 = React.version.split('.')[0] >= 18

export default function (store) {
  const container = document.getElementById('font-awesome-admin')

  domReady(() => {
    const app = (
      <ErrorBoundary>
        <Provider store={store}>
          <FontAwesomeAdminView />
        </Provider>
      </ErrorBoundary>
    )

    if (isAtLeastReact18) {
      createRoot(container).render(app)
    } else {
      ReactDOM.render(app, container)
    }
  })
}
