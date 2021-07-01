import React from 'react'
import ReactDOM from 'react-dom'
import ErrorBoundary from './ErrorBoundary'
import FontAwesomeAdminView from './FontAwesomeAdminView'
import { Provider } from 'react-redux'
import { createStore } from './store'
import { reportDetectedConflicts } from './store/actions'
import { mountConflictDetectionReporter } from './mountConflictDetectionReporter'
import { __ } from '@wordpress/i18n'
import { setupIconChooser } from './chooser'

const initialData = window['__FontAwesomeOfficialPlugin__']

if(! initialData){
  console.error( __( 'Font Awesome plugin is broken: initial state data missing.', 'font-awesome' ) )
}

const store = createStore(initialData)

const {
  showAdmin,
  showConflictDetectionReporter,
  enableIconChooser
} = store.getState()

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
  mountConflictDetectionReporter({
    report: params => store.dispatch(reportDetectedConflicts(params)),
    store,
    now: false
  })
}

if ( enableIconChooser ) {
  setupIconChooser()
}
