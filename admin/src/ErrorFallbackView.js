import React from 'react'
import { get } from 'lodash'

class ErrorFallbackView extends React.Component {

  render() {
    const { error = {} } = this.props
    const clientSideErrorMessage = get(error, 'message', null)
    const serverErrorMessage = get(error, ['response', 'data', 'message'], null)
    const serverStackTrace = get(error, ['response', 'data', 'data', 'trace'], null)

    return <div className={'error-fallback'}>
      Sorry, we've experienced some error.
      {
        clientSideErrorMessage &&
        <div className={'additional-message'}>
          { clientSideErrorMessage }
        </div>
      }
      {
        serverErrorMessage &&
        <div className={'additional-message'}>
          { serverErrorMessage }
        </div>
      }
      {
        serverStackTrace &&
        <div className={'additional-message'}>
          <pre>
          { serverStackTrace }
          </pre>
        </div>
      }
    </div>
  }
}

export default ErrorFallbackView
