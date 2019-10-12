import React, { useState } from 'react'
import axios from 'axios'
import styles from './Reporter.module.css'
import { difference, size } from 'lodash'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faSpinner, faCheck } from '@fortawesome/free-solid-svg-icons'

export default function Reporter() {
  const [runStatus, setRunStatus] = useState('running')
  const [conflicts, setConflicts] = useState({})
  const { apiNonce, apiUrl, prevUnregisteredClients } = window.wpFontAwesomeOfficialConflictReporting || {}

  function reportDetectedConflicts({nodesTested = null}){
    if( !apiNonce || !apiUrl ) {
      console.error("Font Awesome Conflict Detection failed because it's not properly configured.")
      return
    }

    const payload = Object.keys(nodesTested.conflict).reduce(function(acc, md5){
      acc[md5] = nodesTested.conflict[md5]
      return acc
    }, {})

    setConflicts(payload)

    const errorMsg = 'Font Awesome Conflict Detection: found ' +
      Object.keys(payload).length + ' conflicts' +
      ' but failed when trying to submit them to your WordPress server. Sorry!'+
      ' You might just try again by reloading this page.';

    axios.post(
      apiUrl,
      payload,
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    )
    .then(function(response){
      const { status } = response
      if (204 === status) {
        console.log('Font Awesome Conflict Detection: ran successfully and submitted ' +
          Object.keys(payload).length +
          ' conflicts to your WordPress server.' +
          ' You can use the Font Awesome plugin settings page to manage them.')
        setRunStatus('done')
      } else {
        console.error(errorMsg)
      }
    })
    .catch(function(error){
      console.error(errorMsg)
    })
  }

  function countNewConflicts(prevConflicts = {}, curConflicts = {}) {
    return size(difference(Object.keys(curConflicts), Object.keys(prevConflicts)))
  }

  window.FontAwesomeDetection = {
    report: reportDetectedConflicts
  }

  return (
    <div className={ styles['report-container'] }>
      <h1>FA Conflict Detection</h1>
      {
        runStatus === 'running'
        ? 
          <div className={ styles['report-body'] }>
            <div className={ styles['status-container'] }>
              <FontAwesomeIcon icon={ faSpinner } spin /> <span className={styles['status-desc']}>{ runStatus }</span>
            </div>
          </div>
        : <div className={ styles['report-body'] }>
          <div className={ styles['status-container'] }>
              <FontAwesomeIcon icon={ faCheck } /> <span className={styles['status-desc']}>{ runStatus }</span>
          </div>
          <p>Previous conflicts: { size(Object.keys(prevUnregisteredClients)) }</p>
          <p>Conflicts detected on this page: { size(Object.keys(conflicts)) }</p>
          <p>New conflicts: { countNewConflicts(prevUnregisteredClients, conflicts) }</p>
        </div>
      }
    </div>
  )
}
