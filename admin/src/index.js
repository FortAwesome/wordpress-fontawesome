import React from 'react'
import ReactDOM from 'react-dom'
import ErrorBoundary from './ErrorBoundary'
import FontAwesomeAdminView from './FontAwesomeAdminView'
import ConflictDetectionReporter from './ConflictDetectionReporter'
import { dom } from '@fortawesome/fontawesome-svg-core'
import { Provider } from 'react-redux'
import store from './store'
import { reportDetectedConflicts } from './store/actions'

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
    )
  })
}

if( showConflictDetectionReporter ) {
  // This needs to be set earlier than DOMContentLoaded, as soon as this script is enqueued,
  // because it needs to add global configuration that the conflict detector will use.
  window.FontAwesomeDetection = {
    report: params => store.dispatch(reportDetectedConflicts(params))
  }

  document.addEventListener('DOMContentLoaded', () => {
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
          <ConflictDetectionReporter />
        </Provider>
      </ErrorBoundary>,
      shadowContainer
    )
  })
}
