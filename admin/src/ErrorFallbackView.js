import React from 'react'
import styles from './ErrorFallbackView.module.css'
import Alert from './Alert'

function ErrorFallbackView() {
  return <div className={ styles['error-fallback'] }>
    <Alert title='Whoops, this is embarrassing' type='warning'>
      <p>
        Some unexpected error has occurred. There might be some additional
        diagnostic information in the JavaScript console.
      </p>
    </Alert>
  </div>
}

export default ErrorFallbackView
