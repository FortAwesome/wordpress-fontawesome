import React from 'react'
import ManageFontAwesomeVersionsSection from './ManageFontAwesomeVersionsSection'
import UnregisteredClientsView from './UnregisteredClientsView'
import V3DeprecationWarning from './V3DeprecationWarning'
import ConflictDetectionScannerSection from './ConflictDetectionScannerSection'
import sharedStyles from './App.module.css'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { useSelector, useDispatch } from 'react-redux'
import { submitPendingOptions } from './store/actions'
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
  const pendingOptions = useSelector(state => state.pendingOptions)
  const hasSubmitted = useSelector(state => state.optionsFormState.hasSubmitted)
  const submitSuccess = useSelector(state => state.optionsFormState.success)
  const submitMessage = useSelector(state => state.optionsFormState.message)
  const isSubmitting = useSelector(state => state.optionsFormState.isSubmitting)
  const showSubmitButton = size( unregisteredClients ) > 0

  function handleSubmitClick(e) {
    e.preventDefault()

    dispatch(submitPendingOptions())
  }

  return <>
    <div className={ sharedStyles['wrapper-div'] }>
      { hasV3DeprecationWarning && <V3DeprecationWarning /> }
      <ConflictDetectionScannerSection />
      <ManageFontAwesomeVersionsSection />
      <UnregisteredClientsView clients={ unregisteredClients }/>
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
            disabled={ size(pendingOptions) === 0 }
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
                    { submitMessage }
                  </div>
                </div>
            : null
          }
          {
            isSubmitting
            ? <span className={ classnames(sharedStyles['submit-status'], sharedStyles['submitting']) }>
                <FontAwesomeIcon className={ sharedStyles['icon'] } icon={faSpinner} spin/>
              </span>
            : size(pendingOptions) > 0
              ? <span className={ sharedStyles['submit-status'] }>you have pending changes</span>
              : null
          }
        </div>
    }
  </>
}
