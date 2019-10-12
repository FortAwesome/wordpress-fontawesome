import React from 'react'
import ReactDOM from 'react-dom'
import ErrorBoundary from '../ErrorBoundary'
import Reporter from './Reporter'

const conflictDetectionShadowRootElement = document.createElement('DIV')
conflictDetectionShadowRootElement.setAttribute('id', 'font-awesome-plugin-conflict-detection-shadow-host')
document.body.appendChild(conflictDetectionShadowRootElement)
const shadow = conflictDetectionShadowRootElement.attachShadow({ mode: 'open' })

ReactDOM.render(<ErrorBoundary><Reporter/></ErrorBoundary>, shadow)