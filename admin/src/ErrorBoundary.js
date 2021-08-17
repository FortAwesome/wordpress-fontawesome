import ErrorFallbackView from './ErrorFallbackView'
import { ERROR_REPORT_PREAMBLE } from './util/reportRequestError'
import React from 'react'

class ErrorBoundary extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      error: null,
      errorInfo: null
    }
  }

  componentDidCatch(error, errorInfo) {
    console.group(ERROR_REPORT_PREAMBLE)
    console.log( error )
    console.log( errorInfo )
    console.groupEnd()
    this.setState({error, errorInfo})
  }

  render() {
    if (this.state.error) {
      //render fallback UI
      return <ErrorFallbackView />
    } else {
      //when there's not an error, render children untouched
      return this.props.children
    }
  }
}

export default ErrorBoundary
