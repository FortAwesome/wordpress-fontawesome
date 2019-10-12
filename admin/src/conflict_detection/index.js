import React from 'react'
import ReactDOM from 'react-dom'
import ErrorBoundary from '../ErrorBoundary'
import Reporter from './Reporter'
import { dom } from '@fortawesome/fontawesome-svg-core'

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

ReactDOM.render(<ErrorBoundary><Reporter/></ErrorBoundary>, shadowContainer)