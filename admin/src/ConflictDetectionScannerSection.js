import React, { useEffect } from 'react'
import sharedStyles from './App.module.css'
import { useDispatch, useSelector, useStore } from 'react-redux'
import { setConflictDetectionScanner, CONFLICT_DETECTION_SCANNER_DURATION_MIN, reportDetectedConflicts } from './store/actions'
import ConflictDetectionTimer from './ConflictDetectionTimer'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faSpinner, faCheck, faSkull } from '@fortawesome/free-solid-svg-icons'
import { mountConflictDetectionReporter, isConflictDetectionReporterMounted } from './mountConflictDetectionReporter'
import { __, sprintf } from '@wordpress/i18n'
import createInterpolateElement from './createInterpolateElement'

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
      // We are not setting up the reporting hook, because the conflict scanner
      // script is not actually going to run when it's initially activated from
      // this view. The conflict scanner box will appear to alert the user,
      // but the actual functionality will not be enabled until the next page
      // load, when the conflict detection JavaScript will be enqueued and loaded
      // in the page.

      mountConflictDetectionReporter(store)
    }
  }, [ showConflictDetectionReporter, store ])

  return <div>
    <h2 className={ sharedStyles['section-title'] }>{ __( 'Detect Conflicts with Other Versions of Font Awesome', 'font-awesome' ) }</h2>
    <div className={sharedStyles['explanation']}>
      <p>
        { __( 'If you are having trouble loading Font Awesome icons on your WordPress site, it may be because other themes or plugins are loading conflicting versions of Font Awesome. You can use our conflict scanner to detect other versions of Font Awesome running on your site.', 'font-awesome' ) }
      </p>

      <p>
        {
          createInterpolateElement(
            __( 'Enable the scanner below and a box will appear in the bottom corner of your window while it runs for 10 minutes (only you and other admins can see the box). While the scanner is running, browse your site, especially the pages having trouble to catch any <noWrap>Slimers - *ahem* - conflicts</noWrap> in the scanner.', 'font-awesome' ),
            {
              noWrap: <span style={{ whiteSpace: "nowrap" }} />
            }
          )
        } 
      </p>
    </div>
    <div className={sharedStyles['scanner-actions']}>
      {
        detectingConflicts
        ? <button className={sharedStyles['faPrimary']} disabled >
            { __( 'Scanner running', 'font-awesome' ) }: <ConflictDetectionTimer />
          </button>
        : <button className="button button-primary" disabled={ isSubmitting } onClick={() => dispatch(setConflictDetectionScanner({ enable: true }))}>
            {
              sprintf(
                __( 'Enable scanner for %d minutes', 'font-awesome' ),
                CONFLICT_DETECTION_SCANNER_DURATION_MIN 
              )
            }
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
