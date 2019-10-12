import React from 'react'
import ReactDOM from 'react-dom'
import ErrorBoundary from '../ErrorBoundary'
import Reporter from './Reporter'

const conflictDetectionShadowRootElement = document.createElement('DIV')
conflictDetectionShadowRootElement.setAttribute('id', 'font-awesome-plugin-conflict-detection-shadow-root')
document.body.appendChild(conflictDetectionShadowRootElement)
const shadow = conflictDetectionShadowRootElement.attachShadow({ mode: 'open' })

const conflictDetectionContainer = document.createElement('DIV')
conflictDetectionContainer.setAttribute('class', 'font-awesome-plugin-conflict-detection-container')
conflictDetectionContainer.setAttribute(
  'style',
  'position: fixed; right: 10px; bottom: 10px; width: 30%; max-width: 80%; height: auto; max-height: 40%; border: 1px solid lightgrey; background: white; z-index: 99; overflow-y: scroll;'
)
shadow.appendChild(conflictDetectionContainer)

ReactDOM.render(<ErrorBoundary><Reporter/></ErrorBoundary>, conflictDetectionContainer)