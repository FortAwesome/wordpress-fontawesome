import React from 'react'
import { useSelector } from 'react-redux'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faSpinner, faCheck, faSkull, faThumbsUp } from '@fortawesome/free-solid-svg-icons'
import ConflictDetectionTimer from './ConflictDetectionTimer'

const STATUS = {
  running: 'Running',
  done: 'Done',
  submitting: 'Submitting',
  none: 'None',
  error: 'Error'
}

const STYLES = {
  container: {
    position: 'fixed',
    fontFamily: 'sans-serif',
    right: '10px',
    bottom: '10px',
    width: '30%',
    minWidth: '325px',
    maxWidth: '80%',
    height: 'auto',
    maxHeight: '60%',
    border: '1px solid lightgrey',
    background: 'white',
    zIndex: '99',
    overflowY: 'scroll',
    fontSize: '13px',
    lineHeight: '1.4em',
    color: '#444'
  },
  h1: {
    fontSize: '1.5em'
  },
  p: {
    marginBlockStart: '1em',
    marginBlockEnd: '1em'
  },
  content: {
    width: '100%',
    padding: '1em',
    boxSizing: 'border-box'
  }
}

export default function ConflictDetectionReporter() {
  const settingsPageUrl = useSelector(state => state.settingsPageUrl)
  const countBefore = useSelector(
    state => state.unregisteredClientDetectionStatus.countBeforeDetection
  )
  const countAfter = useSelector(
    state => state.unregisteredClientDetectionStatus.countAfterDetection
  )
  const runStatus = useSelector(state => {
    const { isSubmitting, hasSubmitted, success, countBeforeDetection, countAfterDetection } = state.unregisteredClientDetectionStatus
    if ( success && (countBeforeDetection === countAfterDetection) ) {
      return STATUS.none
    } else if( isSubmitting ) {
      return STATUS.submitting
    } else if( !hasSubmitted ){
      return STATUS.running
    } else if ( success ) {
      return STATUS.done
    } else {
      return STATUS.error
    }
  })
  const errorMessage = useSelector(
    state => state.unregisteredClientDetectionStatus.message
  )

  return (
    <div style={ STYLES.container }>
      <div style={ STYLES.content }>
        <ConflictDetectionTimer />
        <h1 style={ STYLES.h1 }>Font Awesome Conflict Scanner</h1>
        {
          {
            None:
              <div>
                <div>
                  <FontAwesomeIcon icon={ faThumbsUp } />
                </div>
                <p>
                  No conflicts found on this page!
                </p>
              </div>,
            Running:
              <div>
                <div>
                  <FontAwesomeIcon icon={ faSpinner } spin /> <span>{ runStatus }</span>
                </div>
              </div>,
            Submitting:
              <div>
                <div>
                  <FontAwesomeIcon icon={ faSpinner } spin /> <span>{ runStatus }</span>
                </div>
              </div>,
            Done:
              <div>
                <div>
                    <FontAwesomeIcon icon={ faCheck } /> <span>{ runStatus }</span>
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
              <div>
                <div>
                    <FontAwesomeIcon icon={ faSkull } /> <span>{ runStatus }</span>
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
