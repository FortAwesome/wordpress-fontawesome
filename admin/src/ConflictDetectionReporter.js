import React from 'react'
import { useSelector, useDispatch } from 'react-redux'
import { setConflictDetectionScanner, userAttemptToStopScanner } from './store/actions'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faCheckCircle, faCog, faExclamationTriangle, faGrin, faSkull, faThumbsUp, faTimesCircle } from '@fortawesome/free-solid-svg-icons'
import { ADMIN_TAB_TROUBLESHOOT } from './store/reducers'
import ConflictDetectionTimer from './ConflictDetectionTimer'
import has from 'lodash-es/has'
import size from 'lodash-es/size'
import { __ } from '@wordpress/i18n'
import ErrorBoundary from './ErrorBoundary'

// NOTE: We don't have Webpack set up to handle the loading of CSS modules in
// a way that is compatible with our use of Shadow DOM. After a failed attempt
// to do so, we'll just use the standard React Style Object technique for assigning
// styles.
// See: https://reactjs.org/docs/dom-elements.html#style

const STATUS = {
  running: {
    code: 'Running',
    display: __('Running', 'font-awesome')
  },
  done: {
    code: 'Done',
    display: __('Done', 'font-awesome')
  },
  submitting: {
    code: 'Submitting',
    display: __('Submitting', 'font-awesome')
  },
  none: {
    code: 'None',
    display: __('None', 'font-awesome')
  },
  error: {
    code: 'Error',
    display: __('Error', 'font-awesome')
  },
  expired: {
    code: 'Expired',
    display: __('Expired', 'font-awesome')
  },
  ready: {
    code: 'Ready',
    display: __('Ready', 'font-awesome')
  },
  stopped: {
    code: 'Stopped',
    display: __('Stopped', 'font-awesome')
  },
  stopping: {
    code: 'Stopping',
    display: __('Stopping', 'font-awesome')
  },
  restarting: {
    code: 'Restarting',
    display: __('Restarting', 'font-awesome')
  }
}

const STYLES = {
  container: {
    position: 'fixed',
    fontFamily: '"Helvetica Neue",Helvetica,Arial,sans-serif',
    right: '10px',
    bottom: '10px',
    width: '450px',
    height: 'auto',
    maxHeight: '60%',
    border: '1px solid #CDD4DB',
    borderRadius: '3px',
    boxShadow: '1px 1px 5px 0 rgba(132,142,151,.3)',
    background: '#008DED',
    zIndex: '99',
    overflowY: 'scroll',
    fontSize: '14px',
    lineHeight: '1.4em',
    color: '#fff'
  },
  header: {
    display: 'flex',
    justifyContent: 'space-between',
    alignItems: 'center',
    padding: '5px 20px',
    color: '#CAECFF'
  },
  content: {
    width: '100%',
    padding: '0 20px 10px 20px',
    boxSizing: 'border-box'
  },
  adminEyesOnly: {
    margin: '0',
    fontSize: '12px'
  },
  h1: {
    margin: '.3em 0',
    fontSize: '14px'
  },
  h2: {
    margin: '.3em 0',
    fontSize: '18px'
  },
  p: {
    margin: '.5em 0'
  },
  link: {
    color: '#fff'
  },
  tally: {
    display: 'flex',
    alignItems: 'center',
    margin: '.5em 0',
    textAlign: 'center'
  },
  count: {
    flexBasis: '1em',
    marginRight: '5px',
    fontWeight: '600',
    fontSize: '20px'
  },
  timerRow: {
    display: 'flex',
    alignItems: 'center',
    backgroundColor: '#0064B1',
    padding: '10px 20px',
    color: '#fff',
    fontWeight: '600'
  },
  button: {
    margin: '0 0 0 10px',
    border: '0',
    padding: '5px',
    backgroundColor: 'transparent',
    color: '#fff',
    opacity: '.7',
    cursor: 'pointer'
  },
  badness: {
    padding: '20px 25px',
    backgroundColor: '#FFC100',
    color: '#202529'
  }
}

function withErrorBoundary(Component) {
  return class extends ErrorBoundary {
    render() {
      return (
        <div style={STYLES.container}>
          {!!this.state.error ? (
            <div style={STYLES.badness}>
              <FontAwesomeIcon icon={faExclamationTriangle} />
              {__(
                ' Whoops, this is embarrassing! Some unexpected error has occurred. There might be some additional diagnostic information in the JavaScript console.',
                'font-awesome'
              )}
            </div>
          ) : (
            <Component />
          )}
        </div>
      )
    }
  }
}

function ConflictDetectionReporter() {
  const dispatch = useDispatch()
  const settingsPageUrl = useSelector((state) => state.settingsPageUrl)
  const troubleshootTabUrl = `${settingsPageUrl}&tab=ts`
  const activeAdminTab = useSelector((state) => state.activeAdminTab)
  const currentlyOnPluginAdminPage = window.location.href.startsWith(settingsPageUrl)
  const currentlyOnTroubleshootTab = currentlyOnPluginAdminPage && activeAdminTab === ADMIN_TAB_TROUBLESHOOT
  const userAttemptedToStopScanner = useSelector((state) => state.userAttemptedToStopScanner)

  const unregisteredClients = useSelector((state) => state.unregisteredClients)

  const unregisteredClientsBeforeDetection = useSelector((state) => state.unregisteredClientDetectionStatus.unregisteredClientsBeforeDetection)

  const recentConflictsDetected = useSelector((state) => state.unregisteredClientDetectionStatus.recentConflictsDetected)

  const expired = useSelector((state) => !state.showConflictDetectionReporter)

  const restarting = useSelector((state) => expired && state.conflictDetectionScannerStatus.isSubmitting)

  const scannerReady = useSelector((state) => state.conflictDetectionScannerStatus.hasSubmitted && state.conflictDetectionScannerStatus.success)

  const scannerIsStopping = useSelector((state) => userAttemptedToStopScanner && !state.conflictDetectionScannerStatus.hasSubmitted)

  const userStoppedScannerSuccessfully = useSelector(
    (state) => userAttemptedToStopScanner && !scannerIsStopping && state.conflictDetectionScannerStatus.success
  )

  const runStatus = useSelector((state) => {
    const { isSubmitting, hasSubmitted, success } = state.unregisteredClientDetectionStatus
    if (userAttemptedToStopScanner) {
      if (scannerIsStopping) {
        return STATUS.stopping
      } else if (userStoppedScannerSuccessfully) {
        return STATUS.stopped
      } else {
        // The user clicked to disable the scanner, and that action failed somehow.
        // Probably a fluke in the communication between the browser and the WordPress server.
        return STATUS.error
      }
    } else if (restarting) {
      return STATUS.restarting
    } else if (expired) {
      return STATUS.expired
    } else if (scannerReady) {
      return STATUS.ready
    } else if (success && 0 === size(unregisteredClients)) {
      return STATUS.none
    } else if (success) {
      return STATUS.done
    } else if (isSubmitting) {
      return STATUS.submitting
    } else if (!hasSubmitted) {
      return STATUS.running
    } else {
      return STATUS.error
    }
  })

  const errorMessage = useSelector((state) => state.unregisteredClientDetectionStatus.message)

  function stopScanner() {
    dispatch(userAttemptToStopScanner())
    dispatch(setConflictDetectionScanner({ enable: false }))
  }

  const expiredOrStoppedDiv = (
    <div>
      <h2 style={STYLES.tally}>
        <span>{size(unregisteredClients)}</span> <span>&nbsp;{__('Results to Review', 'font-awesome')}</span>
      </h2>
      <p style={STYLES.p}>
        {currentlyOnTroubleshootTab ? (
          __('Manage results or restart the scanner here on the Troubleshoot tab.', 'font-awesome')
        ) : (
          <>
            {__('Manage results or restart the scanner on the Troubleshoot tab.', 'font-awesome')}{' '}
            <a
              href={troubleshootTabUrl}
              style={STYLES.link}
            >
              {__('Go', 'font-awesome')}
            </a>
          </>
        )}
      </p>
    </div>
  )

  const stoppingOrSubmittingDiv = (
    <div>
      <div style={STYLES.status}>
        <h2 style={STYLES.h2}>
          <FontAwesomeIcon
            icon={faCog}
            size="sm"
            spin
          />{' '}
          <span>{runStatus.display}</span>
        </h2>
      </div>
    </div>
  )

  return (
    <>
      <div style={STYLES.header}>
        <h1 style={STYLES.h1}>{__('Font Awesome Conflict Scanner', 'font-awesome')}</h1>
        <p style={STYLES.adminEyesOnly}>{__('only admins can see this box', 'font-awesome')}</p>
      </div>
      <div style={STYLES.content}>
        {
          {
            None: (
              <div>
                <div style={STYLES.status}>
                  <h2 style={STYLES.h2}>
                    <FontAwesomeIcon
                      icon={faGrin}
                      size="sm"
                    />{' '}
                    <span>{__('All clear!', 'font-awesome')}</span>
                  </h2>
                  <p style={STYLES.p}>{__('No new conflicts found on this page.', 'font-awesome')}</p>
                </div>
              </div>
            ),
            Running: (
              <div>
                <div style={STYLES.status}>
                  <h2 style={STYLES.h2}>
                    <FontAwesomeIcon
                      icon={faCog}
                      size="sm"
                      spin
                    />{' '}
                    <span>{__('Scanning', 'font-awesome')}...</span>
                  </h2>
                </div>
              </div>
            ),
            Restarting: (
              <div>
                <div style={STYLES.status}>
                  <h2 style={STYLES.h2}>
                    <FontAwesomeIcon
                      icon={faCog}
                      size="sm"
                      spin
                    />{' '}
                    <span>{__('Restarting', 'font-awesome')}...</span>
                  </h2>
                </div>
              </div>
            ),
            Ready: (
              <div>
                <div>
                  <h2 style={STYLES.h2}>
                    <FontAwesomeIcon
                      icon={faThumbsUp}
                      size="sm"
                    />{' '}
                    {__('Proton pack charged!', 'font-awesome')}
                  </h2>
                  <p style={STYLES.p}>{__('Wander through the pages of your web site and this scanner will track progress.', 'font-awesome')}</p>
                </div>
              </div>
            ),
            Submitting: stoppingOrSubmittingDiv,
            Stopping: stoppingOrSubmittingDiv,
            Done: (
              <div>
                <div style={STYLES.status}>
                  <h2 style={STYLES.h2}>
                    <FontAwesomeIcon
                      icon={faCheckCircle}
                      size="sm"
                    />{' '}
                    <span>{__('Page scan complete', 'font-awesome')}</span>
                  </h2>
                </div>
                <p style={STYLES.tally}>
                  <span style={STYLES.count}>{size(Object.keys(recentConflictsDetected).filter((k) => !has(unregisteredClientsBeforeDetection, k)))}</span>{' '}
                  <span>{__('new conflicts found on this page', 'font-awesome')}</span>
                </p>
                <p style={STYLES.tally}>
                  <span style={STYLES.count}>{size(unregisteredClients)}</span> <span>total found</span>
                  {currentlyOnTroubleshootTab ? (
                    <span>&nbsp;({__('manage conflicts here on the Troubleshoot tab', 'font-awesome')})</span>
                  ) : (
                    <span>
                      &nbsp;(
                      <a
                        href={troubleshootTabUrl}
                        style={STYLES.link}
                      >
                        {__('manage', 'font-awesome')}
                      </a>
                      )
                    </span>
                  )}
                </p>
              </div>
            ),
            Expired: expiredOrStoppedDiv,
            Stopped: expiredOrStoppedDiv,
            Error: (
              <div>
                <h2 style={STYLES.h2}>
                  <FontAwesomeIcon icon={faSkull} /> <span>{__("Don't cross the streams! It would be bad.", 'font-awesome')}</span>
                </h2>
                <p style={STYLES.p}>{errorMessage}</p>
              </div>
            )
          }[runStatus.code]
        }
      </div>
      <div style={STYLES.timerRow}>
        <span>
          <ConflictDetectionTimer addDescription>
            <button
              style={STYLES.button}
              title={__('Stop timer', 'font-awesome')}
              onClick={() => stopScanner()}
            >
              <FontAwesomeIcon
                icon={faTimesCircle}
                size="lg"
              />
            </button>
          </ConflictDetectionTimer>
        </span>
        {
          {
            Expired: __('Timer expired', 'font-awesome'),
            Stopped: __('Timer stopped', 'font-awesome'),
            Restarting: null
          }[runStatus.code]
        }
      </div>
    </>
  )
}

export default withErrorBoundary(ConflictDetectionReporter)
