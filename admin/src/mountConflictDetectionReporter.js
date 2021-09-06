import React from 'react'
import ReactDOM from 'react-dom'
import ConflictDetectionReporter from './ConflictDetectionReporter'
import { dom } from '@fortawesome/fontawesome-svg-core'
import { Provider } from 'react-redux'
import retargetEvents from 'react-shadow-dom-retarget-events'
import domReady from '@wordpress/dom-ready'

export const CONFLICT_DETECTION_SHADOW_HOST_ID = 'font-awesome-plugin-conflict-detection-shadow-host'
export function mountConflictDetectionReporter(store) {
  domReady(() => {
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
  })
}

export function isConflictDetectionReporterMounted() {
  const shadowHost = document.getElementById(CONFLICT_DETECTION_SHADOW_HOST_ID)
  if(! shadowHost ) return false

  return !!shadowHost.shadowRoot
}
