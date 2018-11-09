import React from 'react'

class ErrorFallbackView extends React.Component {

  render() {
    const { message } = this.props

    return <div className={'error-fallback'}>
      Sorry, we've experienced some error.
      {
        message &&
        <div className={'additional-message'}>
          { message }
        </div>
      }
    </div>
  }
}

export default ErrorFallbackView
