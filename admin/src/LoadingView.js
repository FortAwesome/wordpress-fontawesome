import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faSpinner } from '@fortawesome/free-solid-svg-icons'

export default () =>
  <div className="loading-view">
    <FontAwesomeIcon icon={ faSpinner } size="4x" spin />
  </div>