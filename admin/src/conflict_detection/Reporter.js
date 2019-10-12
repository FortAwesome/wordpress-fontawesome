import React, { useState } from 'react'
import axios from 'axios'
import styles from './Reporter.module.css'
import { difference, size } from 'lodash'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faSpinner, faCheck, faSkull } from '@fortawesome/free-solid-svg-icons'
const STATUS = {
  running: 'Running',
  done: 'Done',
  submitting: 'Submitting',
  error: 'Error'
}

export default function Reporter() {
  const [runStatus, setRunStatus] = useState(STATUS.running)
  const [error, setError] = useState('')
  const [conflicts, setConflicts] = useState({})
  const { apiNonce, apiUrl, prevUnregisteredClients, settingsPageUrl } = window.wpFontAwesomeOfficialConflictReporting || {}

  function reportDetectedConflicts({nodesTested = null}){
    if( !apiNonce || !apiUrl ) {
      setError("Font Awesome Conflict Detection failed because it's not properly configured for reporting its results back to the WordPress server.")
      setRunStatus(STATUS.error)
      return
    }

    const payload = Object.keys(nodesTested.conflict).reduce(function(acc, md5){
      acc[md5] = nodesTested.conflict[md5]
      return acc
    }, {})

    setConflicts(payload)
    setRunStatus(STATUS.submitting)

    axios.post(
      apiUrl,
      payload,
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    )
    .then(function(){
      setRunStatus(STATUS.done)
    })
    .catch(function(error){
      setError(`Submitting results to the WordPress server failed, and this might indicate a bug. Could you report this on the plugin's support forum? There maybe additional diagnostic output in the JavaScript console.\n\n${error}`)
      setRunStatus(STATUS.error)
      console.error('Font Awesome Conflict Detection Reporting Error: ', error)
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
        {
          Running:
            <div className={ styles['report-body'] }>
              <div className={ styles['status-container'] }>
                <FontAwesomeIcon icon={ faSpinner } spin /> <span className={styles['status-desc']}>{ runStatus }</span>
              </div>
            </div>,
          Submitting:
            <div className={ styles['report-body'] }>
              <div className={ styles['status-container'] }>
                <FontAwesomeIcon icon={ faSpinner } spin /> <span className={styles['status-desc']}>{ runStatus }</span>
              </div>
            </div>,
          Done:
            <div className={ styles['report-body'] }>
              <div className={ styles['status-container'] }>
                  <FontAwesomeIcon icon={ faCheck } /> <span className={styles['status-desc']}>{ runStatus }</span>
              </div>
              <p>Previous conflicts: { size(Object.keys(prevUnregisteredClients)) }</p>
              <p>Conflicts detected on this page: { size(Object.keys(conflicts)) }</p>
              <p>New conflicts: { countNewConflicts(prevUnregisteredClients, conflicts) }</p>
              <p><a href={ settingsPageUrl }>Go manage</a> conflict removal on the plugin settings page.</p>
            </div>,
          Error:
            <div className={ styles['report-body'] }>
              <div className={ styles['status-container'] }>
                  <FontAwesomeIcon icon={ faSkull } /> <span className={styles['status-desc']}>{ runStatus }</span>
              </div>
              <p>
                { error }
              </p>
            </div>
        }[runStatus]
      }
    </div>
  )
}
