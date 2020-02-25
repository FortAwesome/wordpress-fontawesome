import ConflictDetectionReporter from './ConflictDetectionReporter'
import { dom } from '@fortawesome/fontawesome-svg-core'
import React from 'react'
import ReactDOM from 'react-dom'
import ErrorBoundary from './ErrorBoundary'
import { Provider } from 'react-redux'
import retargetEvents from 'react-shadow-dom-retarget-events'

export const CONFLICT_DETECTION_SHADOW_HOST_ID = 'font-awesome-plugin-conflict-detection-shadow-host'
// report: the report callback function to assign to the global
//     window.FontAwesomeDetection.report
// store: the redux store
// now: boolean (default = false) to mount now, synchronously. If false,
//     we'll mount on DOMContentLoaded.
export function mountConflictDetectionReporter({ report = () => {}, store, now = false }) {
  // This needs to be set earlier than DOMContentLoaded, as soon as this script is enqueued,
  // because it needs to add global configuration that the conflict detector will use.
  window.FontAwesomeDetection = {
    ...(window.FontAwesomeDetection || {}),
    report
  }

  const doMount = () => {
    const conflictDetectionShadowRootElement = document.createElement('DIV')
    conflictDetectionShadowRootElement.setAttribute('id', CONFLICT_DETECTION_SHADOW_HOST_ID)
    document.body.appendChild(conflictDetectionShadowRootElement)
    const shadow = conflictDetectionShadowRootElement.attachShadow({ mode: 'open' })
    // React doesn't seem to natively handle click events that originate inside
    // a shadow DOM. This utility will cause things to work like you'd expect.
    // See: https://github.com/spring-media/react-shadow-dom-retarget-events
    retargetEvents(shadow)

    const faStyle = document.createElement('STYLE')
    const css = dom.css()
    const cssText = document.createTextNode(css)
    faStyle.appendChild(cssText)

    const shadowContainer = document.createElement('DIV')

    shadow.appendChild(faStyle)
    shadow.appendChild(shadowContainer)

    ReactDOM.render(
      <Provider store={ store }>
        <ConflictDetectionReporter />
      </Provider>,
      shadowContainer
    )
  }

  if(now) {
    doMount()
  } else {
    document.addEventListener('DOMContentLoaded', doMount)
  }
}

export function isConflictDetectionReporterMounted() {
  const shadowHost = document.getElementById(CONFLICT_DETECTION_SHADOW_HOST_ID)
  if(! shadowHost ) return false

  return !!shadowHost.shadowRoot
}
