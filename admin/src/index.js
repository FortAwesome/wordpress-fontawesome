import React from 'react'
import ReactDOM from 'react-dom'
import App from './App'
import ErrorBoundary from './ErrorBoundary'

const initialData = window['__FontAwesomeOfficialPlugin__'] || {};

ReactDOM.render(<ErrorBoundary><App /></ErrorBoundary>, document.getElementById('font-awesome-admin'));
