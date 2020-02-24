import React, { useEffect } from 'react'
import sharedStyles from './App.module.css'
import { useDispatch, useSelector, useStore } from 'react-redux'
import { setConflictDetectionScanner, CONFLICT_DETECTION_SCANNER_DURATION_MIN } from './store/actions'
import ConflictDetectionTimer from './ConflictDetectionTimer'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faSpinner, faCheck, faSkull } from '@fortawesome/free-solid-svg-icons'
import { mountConflictDetectionReporter, isConflictDetectionReporterMounted } from './mountConflictDetectionReporter'

export default function ConflictDetectionScannerSection() {
  const dispatch = useDispatch()
  const detectConflictsUntil = useSelector(state => state.detectConflictsUntil)
  const nowMs = (new Date()).valueOf()
  const detectingConflicts = (new Date(detectConflictsUntil * 1000)) > nowMs
  const { isSubmitting, hasSubmitted, message, success } = useSelector(state => state.conflictDetectionScannerStatus)
  const showConflictDetectionReporter = useSelector(state => state.showConflictDetectionReporter)
  const store = useStore()

  useEffect(() => {
    if(showConflictDetectionReporter && !isConflictDetectionReporterMounted()) {
      mountConflictDetectionReporter({
        report: () => {},
        store,
        now: true
      })
    }
  }, [showConflictDetectionReporter])

  return <div>
    <h2 className={ sharedStyles['section-title'] }>Detect Conflicts with Other Versions of Font Awesome</h2>
    <div className={sharedStyles['explanation']}>
      <p>If you are having trouble loading Font Awesome icons on your WordPress
      site, it may be because other themes or plugins are loading
      conflicting versions of Font Awesome. You can use our conflict scanner to
      detect other versions of Font Awesome running on your site.</p>

      <p>Enable the scanner below and a box will appear in the bottom corner
      of your window while it runs for 10 minutes (only you and other admins
      can see the box). While the scanner is running, browse your site,
      especially the pages having trouble to catch
      any <span style={{ whiteSpace: "nowrap" }}>Slimers - *ahem* - conflicts
      </span> in the scanner. Then come back here to review and manage Font
      Awesome versions found.</p>
    </div>
    <div className={sharedStyles['scanner-actions']}>
      {
        detectingConflicts
        ? <button className={sharedStyles['faPrimary']} disabled >
            Scanner running: <ConflictDetectionTimer />
          </button>
        : <button className="button button-primary" disabled={ isSubmitting } onClick={() => dispatch(setConflictDetectionScanner({ enable: true }))}>
            Enable scanner for <span>{ CONFLICT_DETECTION_SCANNER_DURATION_MIN } minutes</span>
          </button>
      }
      <div className={sharedStyles['scanner-runstatus']}>
      {
        isSubmitting
        ? <FontAwesomeIcon icon={ faSpinner } spin />
        : hasSubmitted
          ? success
            ? <FontAwesomeIcon icon={ faCheck } />
            : <><FontAwesomeIcon icon={ faSkull } /> <span>{ message }</span></>
          : null
      }
      </div>
    </div>
    <hr className={ sharedStyles['section-divider'] }/>
  </div>
}
