import { createStore } from './store'
import get from 'lodash/get'

let hasDomLoaded = false

document.addEventListener('DOMContentLoaded', () => {
  hasDomLoaded = true
})

const initialData = window['__FontAwesomeOfficialPlugin__']
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

if( get(initialData, 'showConflictDetectionReporter') ) {
  const reportEvent = new Event(CONFLICT_DETECTION_REPORT_EVENT_TYPE, { "bubbles": true, "cancelable": false })

  /**
   * If we're doing conflict detection, we must set this up before DOMContentLoaded,
   * to ensure that the report hook is ready to go.
   */
  window.FontAwesomeDetection = {
    ...(window.FontAwesomeDetection || {}),
    report: params => {
      conflictDetectionReport = params
      document.dispatchEvent(reportEvent)
    }
  }
}

// First, we need to resolve whether we're using React and ReactDOM from
// WordPress 5 Core, or whether we need to dynamically import them from
// a webpack chunk, as would be necessary in WordPress 4.x.
Promise.all([
  window.React
    ? Promise.resolve({ default: { React: window.React  } })
    : import('./reactCompatWp4'),
  window.ReactDOM
    ? Promise.resolve({ default: { ReactDOM: window.ReactDOM } })
    : import('./reactCompatWp4'),
  get(window, 'wp.i18n')
    ? Promise.resolve(window.wp.i18n)
    : import('@wordpress/i18n'),
  get(window, 'wp.apiFetch')
    ? Promise.resolve({ default: window.wp.apiFetch })
    : import('@wordpress/api-fetch')
])
.then(([{ default: { React } }, { default: { ReactDOM } }, i18n, { default: apiFetch }]) => {
  window.__Font_Awesome_Webpack_Externals__ = {
    React,
    ReactDOM,
    i18n,
    apiFetch
  }

  // TODO: remove global setting for Webpack externals
  window.React = React
  window.ReactDOM = ReactDOM

  if(! initialData){
    console.error( i18n.__( 'Font Awesome plugin is broken: initial state data missing.', 'font-awesome' ) )
  }

  const store = createStore(initialData)

  const {
    showAdmin,
    showConflictDetectionReporter,
    enableIconChooser
  } = store.getState()

  if( showAdmin ) {
    import('./mountAdminView')
    .then(({ default: mountAdminView }) => {
      mountAdminView(store, hasDomLoaded)
    })
  }

  if( showConflictDetectionReporter ) {
    Promise.all([
      import('./store/actions'),
      import('./mountConflictDetectionReporter')
    ])
    .then(([{ reportDetectedConflicts }, { mountConflictDetectionReporter }]) => {
      const report = params => store.dispatch(reportDetectedConflicts(params))

      /**
       * If the conflict detection report is already available, just use it;
       * otherwise, listen for the reporting event.
       */
      if( conflictDetectionReport ) {
        report(conflictDetectionReport)
      } else {
        document.addEventListener(
          CONFLICT_DETECTION_REPORT_EVENT_TYPE,
          _event => report(conflictDetectionReport)
        )
      }

      mountConflictDetectionReporter({
        store,
        now: hasDomLoaded
      })
    })
  }

  if ( enableIconChooser ) {
    Promise.all([
      import('./chooser'),
      import('./chooser/handleQuery'),
      import('./chooser/getUrlText')
    ])
    .then(([{ setupIconChooser }, { default: configureQueryHandler }, { default: getUrlText } ]) => {
      const kitToken = get(initialData, 'options.kitToken')
      const version = get(initialData, 'options.version')

      const params = {
        ...initialData,
        kitToken,
        version,
        getUrlText,
        pro: get(initialData, 'options.usePro')
      }

      const handleQuery = configureQueryHandler(params)

      const { setupClassicEditorIconChooser } = setupIconChooser({ ...params, handleQuery })

      /**
       * Tiny MCE will probably be loaded later, but since this code runs async,
       * we can't guarantee the timing. So if this runs first, it will set this
       * global to a function that the post-tiny-mce inline code can invoke.
       * But if that code runs first, it will set this global to some truthy value,
       * which tells us to invoke this setup immediately.
       */
      if( window['__FontAwesomeOfficialPlugin__setupClassicEditorIconChooser'] ) {
        setupClassicEditorIconChooser()
      } else {
        window['__FontAwesomeOfficialPlugin__setupClassicEditorIconChooser'] = setupClassicEditorIconChooser
      }
    })
  }
})
.catch(error => {
  console.error('Font Awesome Plugin Fatal Error:', error)
})
