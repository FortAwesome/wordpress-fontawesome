import React from 'react'
import ReactDOM from 'react-dom'
import ErrorBoundary from './ErrorBoundary'
import FontAwesomeAdminView from './FontAwesomeAdminView'
import { Provider } from 'react-redux'
import { createStore } from './store'
import { reportDetectedConflicts } from './store/actions'
import mountConflictDetectionReporter from './mountConflictDetectionReporter'

const initialData = window['__FontAwesomeOfficialPlugin__']

if(! initialData){
  console.error('Font Awesome plugin is broken: initial state data missing.')
}

const store = createStore(initialData)

const { showAdmin, showConflictDetectionReporter } = store.getState()

if( showAdmin ) {
  document.addEventListener('DOMContentLoaded', () => {
    ReactDOM.render(
      <ErrorBoundary>
        <Provider store={ store }>
          <FontAwesomeAdminView/>
        </Provider>
      </ErrorBoundary>,
      document.getElementById('font-awesome-admin')
    )
  })
}

if( showConflictDetectionReporter ) {
  mountConflictDetectionReporter(
    params => store.dispatch(reportDetectedConflicts(params)),
    store,
    false
  )
}
