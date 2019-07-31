import React from 'react'
import styles from './ErrorFallbackView.module.css'
import Alert from './Alert'
import PropTypes from 'prop-types'
import { get } from 'lodash'

function ErrorFallbackView(props) {
  const { error = {} } = props
  const clientSideErrorMessage = get(error, 'message', null)
  const serverErrorMessage = get(error, ['response', 'data', 'message'], null)
  const serverStackTrace = get(error, ['response', 'data', 'data', 'trace'], null)

  return <div className={ styles['error-fallback'] }>
    <Alert title='Whoops, this is embarrassing' type='warning'>
      <p>
        Some unexpected error has occurred.
      </p>
      {
        clientSideErrorMessage &&
        <p>
          { clientSideErrorMessage }
        </p>
      }
      <p>
        You might be able to find a solution to this
        problem in the <a href="https://wordpress.org/support/plugin/font-awesome/" rel="noopener noreferrer" target="_blank">plugin's support forum</a>.
        If not, you could post about the problem there.
      </p>
      {
       serverErrorMessage  &&
        <div>
          The server says:
          <div className={ styles['additional-message'] }>
            { serverErrorMessage }
          </div>
          {
            serverStackTrace && <p>A server stack trace is shown below.</p>
          }
          <p>Please include this information if you submit an error report.</p>
        </div>
      }
    </Alert>
    {
      serverStackTrace &&
      <p>
        <h2>Server Stack Trace</h2>
        <pre>
        { serverStackTrace }
        </pre>
      </p>
    }
  </div>
}

ErrorFallbackView.propTypes = {
  message: PropTypes.string
}

export default ErrorFallbackView
