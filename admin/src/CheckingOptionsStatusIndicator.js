import React from 'react'
import styles from './CdnConfigView.module.css'
import sharedStyles from './App.module.css'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import classnames from 'classnames'
import { faSpinner } from '@fortawesome/free-solid-svg-icons'

export default function CheckingOptionStatusIndicator(){
  return <span className={ styles['checking-option-status-indicator'] }>
    <FontAwesomeIcon spin className={ classnames(sharedStyles['icon']) } icon={ faSpinner }/>
    &nbsp;checking for preference conflicts...
  </span>
}
