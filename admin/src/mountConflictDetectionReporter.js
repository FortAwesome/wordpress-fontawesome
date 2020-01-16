import ConflictDetectionReporter from './ConflictDetectionReporter'
import { dom } from '@fortawesome/fontawesome-svg-core'
import React from 'react'
import ReactDOM from 'react-dom'
import ErrorBoundary from './ErrorBoundary'
import { Provider } from 'react-redux'
// report: the report callback function to assign to the global
//     window.FontAwesomeDetection.report
// store: the redux store
// now: boolean (default = false) to mount now, synchronously. If false,
//     we'll mount on DOMContentLoaded.
export default function (report = () => {}, store, now = false) {
  // This needs to be set earlier than DOMContentLoaded, as soon as this script is enqueued,
  // because it needs to add global configuration that the conflict detector will use.
  window.FontAwesomeDetection = {
    report
  }

  const doMount = () => {
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
  }

  if(now) {
    doMount()
  } else {
    document.addEventListener('DOMContentLoaded', doMount)
  }
}
