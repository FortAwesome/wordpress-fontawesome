import React from 'react'
import ErrorFallbackView from './ErrorFallbackView'
import { get } from 'lodash'

class ErrorBoundary extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      error: null,
      errorInfo: null
    }
  }

  componentDidCatch(error, errorInfo) {
    this.setState({error, errorInfo})
  }

  render() {
    if (this.state.error) {
      //render fallback UI
      return <ErrorFallbackView error={ this.state.error } errorInfo={ this.state.errorInfo }/>
    } else {
      //when there's not an error, render children untouched
      return this.props.children
    }
  }
}

export default ErrorBoundary
