import React from 'react'
import styles from './ErrorFallbackView.module.css'
import Alert from './Alert'
import { __ } from '@wordpress/i18n'

export const fatalAlert = <Alert title={ __( 'Whoops, this is embarrassing', 'font-awesome' ) } type='warning'>
  <p>
    {
      __( 'Some unexpected error has occurred. There might be some additional diagnostic information in the JavaScript console.', 'font-awesome' )
    }
  </p>
</Alert>

function ErrorFallbackView() {
  return <div className={ styles['error-fallback'] }>
    { fatalAlert }
  </div>
}

export default ErrorFallbackView
