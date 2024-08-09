import { createStore } from './store'
import { get, set } from 'lodash'
import { GLOBAL_KEY } from './constants'
import createInterpolateElement from './createInterpolateElement'
import { __ } from '@wordpress/i18n'

const initialData = window[GLOBAL_KEY]
// See: https://webpack.js.org/guides/public-path/#on-the-fly
__webpack_public_path__ = get(initialData, 'webpackPublicPath')
const CONFLICT_DETECTION_REPORT_EVENT_TYPE = 'fontAwesomeConflictDetectionReport'
/**
 * This will start out as falsy, when there's a report, we'll set it with those
 * params. This is to handle timing issues where the reporting event could possibly
 * (though unlikely) occur before we listen for that event below. So we'll do both:
 * set this module-scoped variable, and dispatch an event. So the listening code
 * below can first check whether the report is already available, and if not, listen
 * for the later reporting event.
 */
let conflictDetectionReport = null

if (get(initialData, 'showConflictDetectionReporter')) {
  const reportEvent = new Event(CONFLICT_DETECTION_REPORT_EVENT_TYPE, { bubbles: true, cancelable: false })

  /**
   * If we're doing conflict detection, we must set this up before DOMContentLoaded,
   * to ensure that the report hook is ready to go.
   */
  window.FontAwesomeDetection = {
    ...(window.FontAwesomeDetection || {}),
    report: (params) => {
      conflictDetectionReport = params
      document.dispatchEvent(reportEvent)
    }
  }
}

if (!initialData) {
  console.error(__('Font Awesome plugin is broken: initial state data missing.', 'font-awesome'))
}

const store = createStore(initialData)

set(window, [GLOBAL_KEY, 'createInterpolateElement'], createInterpolateElement)

const { showAdmin, showConflictDetectionReporter } = store.getState()

if (showAdmin) {
  import('./mountAdminView')
    .then(({ default: mountAdminView }) => {
      mountAdminView(store)
    })
    .catch((error) => {
      console.error(__('Font Awesome plugin error when initializing admin settings view', 'font-awesome'), error)
    })
}

if (showConflictDetectionReporter) {
  Promise.all([import('./store/actions'), import('./mountConflictDetectionReporter')])
    .then(([{ reportDetectedConflicts }, { mountConflictDetectionReporter }]) => {
      const report = (params) => store.dispatch(reportDetectedConflicts(params))

      /**
       * If the conflict detection report is already available, just use it;
       * otherwise, listen for the reporting event.
       */
      if (conflictDetectionReport) {
        report(conflictDetectionReport)
      } else {
        document.addEventListener(CONFLICT_DETECTION_REPORT_EVENT_TYPE, (_event) => report(conflictDetectionReport))
      }

      mountConflictDetectionReporter(store)
    })
    .catch((error) => {
      console.error(__('Font Awesome plugin error when initializing conflict detection scanner', 'font-awesome'), error)
    })
}
