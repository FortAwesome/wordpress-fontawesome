import React from 'react'
import { useSelector } from 'react-redux'
import styles from './Reporter.lazy.module.css'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faSpinner, faCheck, faSkull } from '@fortawesome/free-solid-svg-icons'

const STATUS = {
  running: 'Running',
  done: 'Done',
  submitting: 'Submitting',
  error: 'Error'
}

export default function Reporter() {
  const settingsPageUrl = useSelector(state => state.settingsPageUrl)
  const countBefore = useSelector(
    state => state.unregisteredClientDetectionStatus.countBeforeDetection
  )
  const countAfter = useSelector(
    state => state.unregisteredClientDetectionStatus.countAfterDetection
  )
  const runStatus = useSelector(state => {
    const { isSubmitting, hasSubmitted, success } = state.unregisteredClientDetectionStatus
    if( isSubmitting ) {
      return 'Submitting'
    } else if( !hasSubmitted ){
      return 'Running'
    } else if ( success ) {
      return 'Done'
    } else {
      return 'Error'
    }
  })
  const errorMessage = useSelector(
    state => state.unregisteredClientDetectionStatus.message
  )

  styles.use()

  return (
    <div className={ styles.locals['container'] }>
      <div className={ styles.locals['content'] }>
        <h1>FA Conflict Detection</h1>
        {
          {
            Running:
              <div className={ styles.locals['report-body'] }>
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
                <p>Conflicts known before detection: { countBefore }</p>
                <p>Conflicts known after detection: { countAfter }</p>
                {
                  window.location.href === settingsPageUrl ?
                  <p>Manage conflict removal right here on the plugin settings page.</p>
                  : <p><a href={ settingsPageUrl }>Go manage</a> conflict removal on the plugin settings page.</p>
                }
              </div>,
            Error:
              <div className={ styles['report-body'] }>
                <div className={ styles['status-container'] }>
                    <FontAwesomeIcon icon={ faSkull } /> <span className={styles['status-desc']}>{ runStatus }</span>
                </div>
                <p>
                  { errorMessage }
                </p>
              </div>
          }[runStatus]
        }
      </div>
    </div>
  )
}
