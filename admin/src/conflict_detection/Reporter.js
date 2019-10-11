import React, { useState } from 'react'
import axios from 'axios'
import styles from './Reporter.module.css'

export default function Reporter() {
  // const [data, setData] = useState({ hits: [] })
  const [runStatus, setRunStatus] = useState('running')

  function reportDetectedConflicts({nodesTested = null}){
    const apiNonce = window.wpFontAwesomeOfficialConflictReporting['api_nonce'] || null
    const apiBaseUrl = window.wpFontAwesomeOfficialConflictReporting['api_url'] || null

    if( !apiNonce || !apiBaseUrl ) {
      console.error("Font Awesome Conflict Detection failed because it's not properly configured.")
      return
    }

    const payload = Object.keys(nodesTested.conflict).reduce(function(acc, md5){
      acc[md5] = nodesTested.conflict[md5]
      return acc
    }, {})

    const errorMsg = 'Font Awesome Conflict Detection: found ' +
      Object.keys(payload).length + ' conflicts' +
      ' but failed when trying to submit them to your WordPress server. Sorry!'+
      ' You might just try again by reloading this page.';

    axios.post(
      apiBaseUrl + '/report-conflicts',
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

  window.FontAwesomeDetection = {
    report: reportDetectedConflicts
  }

  return (
    <div className={ styles['reporter'] }>
      <p>reporter status: { runStatus }</p>
    </div>
  )
}
