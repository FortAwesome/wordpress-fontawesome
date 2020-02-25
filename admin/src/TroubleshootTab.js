import React from 'react'
import ManageFontAwesomeVersionsSection from './ManageFontAwesomeVersionsSection'
import UnregisteredClientsView from './UnregisteredClientsView'
import V3DeprecationWarning from './V3DeprecationWarning'
import ConflictDetectionScannerSection from './ConflictDetectionScannerSection'
import sharedStyles from './App.module.css'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { useSelector, useDispatch } from 'react-redux'
import {
  submitPendingBlocklist,
  submitPendingUnregisteredClientDeletions,
  resetPendingBlocklistSubmissionStatus,
  resetUnregisteredClientsDeletionStatus
} from './store/actions'
import {
  faCheck,
  faSkull,
  faSpinner } from '@fortawesome/free-solid-svg-icons'
import classnames from 'classnames'
import size from 'lodash/size'

export default function TroubleshootTab() {
  const dispatch = useDispatch()
  const hasV3DeprecationWarning = useSelector(state => !!state.v3DeprecationWarning)
  const unregisteredClients = useSelector(state => state.unregisteredClients)

  const blocklistUpdateStatus = useSelector(state => state.blocklistUpdateStatus)
  const unregisteredClientsDeletionStatus = useSelector(state => state.unregisteredClientsDeletionStatus)

  const showSubmitButton = size( unregisteredClients ) > 0
  const hasPendingChanges = null !== blocklistUpdateStatus.pending || size( unregisteredClientsDeletionStatus.pending ) > 0
  const hasSubmitted = unregisteredClientsDeletionStatus.hasSubmitted || blocklistUpdateStatus.hasSubmitted
  const isSubmitting = unregisteredClientsDeletionStatus.isSubmitting || blocklistUpdateStatus.isSubmitting

  const submitSuccess =
    (unregisteredClientsDeletionStatus.hasSubmitted || blocklistUpdateStatus.hasSubmitted) &&
    (unregisteredClientsDeletionStatus.success || !unregisteredClientsDeletionStatus.hasSubmitted) &&
    (blocklistUpdateStatus.success || !blocklistUpdateStatus.hasSubmitted)

  function handleSubmitClick(e) {
    e.preventDefault()

    if ( blocklistUpdateStatus.pending ) {
      dispatch(submitPendingBlocklist())
    } else {
      dispatch(resetPendingBlocklistSubmissionStatus())
    }

    if ( size( unregisteredClientsDeletionStatus.pending ) > 0 ) {
      dispatch(submitPendingUnregisteredClientDeletions())
    } else {
      dispatch(resetUnregisteredClientsDeletionStatus())
    }
  }

  return <>
    <div className={ sharedStyles['wrapper-div'] }>
      { hasV3DeprecationWarning && <V3DeprecationWarning /> }
      <ConflictDetectionScannerSection />
      <ManageFontAwesomeVersionsSection />
      <UnregisteredClientsView />
    </div>
    {
      showSubmitButton &&
        <div className={ classnames(sharedStyles['submit-wrapper'], ['submit']) }>
          <input
            type="submit"
            name="submit"
            id="submit"
            className="button button-primary"
            value="Save Changes"
            disabled={ !hasPendingChanges }
            onClick={ handleSubmitClick }
          />
          { hasSubmitted 
            ? submitSuccess
              ? <span className={ classnames(sharedStyles['submit-status'], sharedStyles['success']) }>
                  <FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faCheck } />
                </span>
              : <div className={ classnames(sharedStyles['submit-status'], sharedStyles['fail']) }>
                  <div className={ classnames(sharedStyles['fail-icon-container']) }>
                    <FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faSkull } />
                  </div>
                  <div className={ sharedStyles['explanation'] }>
                    {
                      !!blocklistUpdateStatus.message && <p> { blocklistUpdateStatus.message } </p>
                    }
                    {
                      !!unregisteredClientsDeletionStatus.message && <p> { unregisteredClientsDeletionStatus.message } </p>
                    }
                  </div>
                </div>
            : null
          }
          {
            isSubmitting
            ? <span className={ classnames(sharedStyles['submit-status'], sharedStyles['submitting']) }>
                <FontAwesomeIcon className={ sharedStyles['icon'] } icon={faSpinner} spin/>
              </span>
            : hasPendingChanges
              ? <span className={ sharedStyles['submit-status'] }>you have pending changes</span>
              : null
          }
        </div>
    }
  </>
}
