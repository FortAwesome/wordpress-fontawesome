import ErrorBoundary from './ErrorBoundary'
import FontAwesomeAdminView from './FontAwesomeAdminView'
import { Provider } from 'react-redux'
import { createStore } from './store'
import { reportDetectedConflicts } from './store/actions'
import { mountConflictDetectionReporter } from './mountConflictDetectionReporter'
import { __ } from '@wordpress/i18n'
import configureQueryHandler from './chooser/handleQuery'
import getUrlText from './chooser/getUrlText'
import get from 'lodash/get'
import { setupIconChooser } from './chooser'

const initialData = window['__FontAwesomeOfficialPlugin__']

if(! initialData){
  console.error( __( 'Font Awesome plugin is broken: initial state data missing.', 'font-awesome' ) )
}

// First, we need to resolve whether we're using React and ReactDOM from
// WordPress 5 Core, or whether we need to dynamically import them from
// a webpack chunk, as would be necessary in WordPress 4.x.
const resolveReact = Promise.all([
  window.React
    ? Promise.resolve(window.React)
    : import('react'),
  window.ReactDOM
    ? Promise.resolve(window.ReactDOM)
    : import('react-dom')
])

resolveReact
.then(([React, ReactDOM]) => {
  window.__Font_Awesome_Webpack_Externals__ = {
    React,
    ReactDOM
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
    const kitToken = get(initialData, 'options.kitToken')
    const version = get(initialData, 'options.version')

    const params = {
      ...initialData,
      kitToken,
      version,
      getUrlText,
      pro: get(initialData, 'options.usePro')
    }

    const handleQuery = configureQueryHandler(params)

    const { setupClassicEditorIconChooser } = setupIconChooser({ ...params, handleQuery })

    // The Tiny MCE will probably be loaded later, so we'll expose the global set up function.
    window['__FontAwesomeOfficialPlugin__setupClassicEditorIconChooser'] = setupClassicEditorIconChooser
  }
})
.catch(error => {
  console.error('Font Awesome Plugin Fatal Error:', error)
})
