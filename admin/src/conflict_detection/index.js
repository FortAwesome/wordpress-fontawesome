import React from 'react'
import ReactDOM from 'react-dom'
import ErrorBoundary from '../ErrorBoundary'
import Reporter from './Reporter'

const conflictDetectionContainer = document.createElement('DIV')
conflictDetectionContainer.setAttribute('class', 'font-awesome-plugin-conflict-detection-container')
conflictDetectionContainer.setAttribute(
  'style',
  'position: fixed; right: 10px; bottom: 10px; width: 300px; height: 200px; border: 1px solid lightgrey; background: white; z-index: 99;'
)
document.body.appendChild(conflictDetectionContainer)

ReactDOM.render(<ErrorBoundary><Reporter/></ErrorBoundary>, conflictDetectionContainer)