import ErrorBoundary from './ErrorBoundary'
import FontAwesomeAdminView from './FontAwesomeAdminView'
import { Provider } from 'react-redux'

function render(store) {
  const { React, ReactDOM } = window.__Font_Awesome_Webpack_Externals__ 

  ReactDOM.render(
    <ErrorBoundary>
      <Provider store={ store }>
        <FontAwesomeAdminView/>
      </Provider>
    </ErrorBoundary>,
    document.getElementById('font-awesome-admin')
  )
}

export default function(store, hasDomLoaded) {
  if( hasDomLoaded ) {
    render(store)
  } else {
    document.addEventListener('DOMContentLoaded', () => {
      render(store)
    })
  }
}
