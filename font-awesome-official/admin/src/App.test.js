import React from 'react'
import ReactDOM from 'react-dom'
import App from './App'

it('renders without crashing', () => {
  const div = document.createElement('div')
  // The React app expects this global to be present (and populated with valid stuff).
  // For a mount smoke test, we'll just mock it.
  Object.defineProperty(global, 'wpFontAwesomeOfficial', { value: 'foo' })
  ReactDOM.render(<App />, div)
  ReactDOM.unmountComponentAtNode(div)
})
