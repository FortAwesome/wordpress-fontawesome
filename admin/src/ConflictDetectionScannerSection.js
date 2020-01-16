import React, { useEffect } from 'react'
import sharedStyles from './App.module.css'
import { useDispatch, useSelector, useStore } from 'react-redux'
import { setConflictDetectionScanner, CONFLICT_DETECTION_SCANNER_DURATION_MIN } from './store/actions'
import ConflictDetectionTimer from './ConflictDetectionTimer'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faSpinner, faCheck, faSkull } from '@fortawesome/free-solid-svg-icons'
import mountConflictDetectionReporter from './mountConflictDetectionReporter'

export default function ConflictDetectionScannerSection() {
  const dispatch = useDispatch()
  const detectConflictsUntil = useSelector(state => state.options.detectConflictsUntil)
  const nowMs = (new Date()).valueOf()
  const detectingConflicts = (new Date(detectConflictsUntil * 1000)) > nowMs
  const { isSubmitting, hasSubmitted, message, success } = useSelector(state => state.conflictDetectionScannerStatus)
  const showConflictDetectionReporter = useSelector(state => state.showConflictDetectionReporter)
  const store = useStore()

  useEffect(() => {
    if(showConflictDetectionReporter) {
      mountConflictDetectionReporter(
        () => {},
        store,
        true
      )
    }
  }, [showConflictDetectionReporter])

  return <div>
    <h1>Conflict Detection Scanner</h1>
    <p className={sharedStyles['explanation']}>
      If you are having trouble loading icons on your site, you can use this
      conflict scanner to detect possible Font Awesome version conflicts coming
      from themes or other plugins that are loading other versions of Font Awesome.

      After you enable the scanner, a scanner box will appear in the bottom corner
      of your window (only you can see it) while it runs for 10 minutes. You can
      then browse your site -- especially pages that are having trouble -- to
      catch the conflicts in the scanner. Then return to this page to review and
      manage any Font Awesome versions found.
    </p>
    <div>
      {
        detectingConflicts
        ? <button disabled >
            Scanner running: <ConflictDetectionTimer />
          </button>
        : <button disabled={ isSubmitting } onClick={() => dispatch(setConflictDetectionScanner({ enable: true }))}>
            Enable scanner for <span>{ CONFLICT_DETECTION_SCANNER_DURATION_MIN } minutes</span>
          </button>
      }
      {
        isSubmitting
        ? <FontAwesomeIcon icon={ faSpinner } spin />
        : hasSubmitted
          ? success
            ? <FontAwesomeIcon icon={ faCheck } />
            : <><FontAwesomeIcon icon={ faSkull } /><span>{ message }</span></>
          : null
      }
    </div>
  </div>
}
