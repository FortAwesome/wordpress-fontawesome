import React from 'react'
import ReactDOM from 'react-dom'
import ErrorBoundary from './ErrorBoundary'
import FontAwesomeAdminView from './FontAwesomeAdminView'
import Reporter from './conflict_detection/Reporter'
import { dom } from '@fortawesome/fontawesome-svg-core'
import { Provider } from 'react-redux'
import store from './store'

const { showAdmin, showConflictDetectionReporter } = store.getState()

if( showAdmin ) {
  document.addEventListener('DOMContentLoaded', () => {
    ReactDOM.render(
      <ErrorBoundary>
        <Provider store={ store }>
          <FontAwesomeAdminView/>
        </Provider>
      </ErrorBoundary>,
      document.getElementById('font-awesome-admin')
    );
  })
}

// This needs to be mounted earlier than DOMContentLoaded, as soon as it's enqueued,
// because it needs to add global configuration that the conflict detector will use.
if( showConflictDetectionReporter ) {
  const conflictDetectionShadowRootElement = document.createElement('DIV')
  conflictDetectionShadowRootElement.setAttribute('id', 'font-awesome-plugin-conflict-detection-shadow-host')
  document.body.appendChild(conflictDetectionShadowRootElement)
  const shadow = conflictDetectionShadowRootElement.attachShadow({ mode: 'open' })

  const faStyle = document.createElement('STYLE')
  const css = dom.css()
  const cssText = document.createTextNode(css)
  faStyle.appendChild(cssText)

  const shadowContainer = document.createElement('DIV')

  shadow.appendChild(faStyle)
  shadow.appendChild(shadowContainer)

  // TODO: need a different ErrorFallbackView for the ErrorBoundary used by the reporter, since
  // it's smaller.
  ReactDOM.render(
    <ErrorBoundary>
      <Provider store={ store }>
        <Reporter />
      </Provider>
    </ErrorBoundary>,
    shadowContainer
  )
}
