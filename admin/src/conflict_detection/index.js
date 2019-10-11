import React from 'react'
import ReactDOM from 'react-dom'
import ErrorBoundary from '../ErrorBoundary'
import Reporter from './Reporter'

const conflictDetectionContainer = document.createElement('DIV')
conflictDetectionContainer.setAttribute('class', 'font-awesome-plugin-conflict-detection-container')
conflictDetectionContainer.setAttribute('style', 'position: absolute; right: 100px; bottom: 100px; border: 1px solid black;')
document.body.appendChild(conflictDetectionContainer)

ReactDOM.render(<ErrorBoundary><Reporter/></ErrorBoundary>, conflictDetectionContainer)