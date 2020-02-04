import axios from 'axios'
import toPairs from 'lodash/toPairs'
import size from 'lodash/size'

// How far into the future from "now" until the conflict detection scanner
// will be enabled.
export const CONFLICT_DETECTION_SCANNER_DURATION_MIN = 10

// How far in the past to set detectConflictsUntil when the conflict detection
// scanner is being disabled. We can use a non-zero but negligible value in
// order to protect against possible race conditions, instead of 0
// (which would just be exactly "now").
const CONFLICT_DETECTION_SCANNER_DEACTIVATION_DELTA_MS = 1

export function addPendingOption(change) {
  return function(dispatch, getState) {
    const { options } = getState()

    const [ key, val ] = toPairs(change)[0]

    const originalValue = options[key]

    // If we're changing back to an original setting
    if( originalValue === val ) {
      dispatch({
        type: 'RESET_PENDING_OPTION',
        change
      })
    } else {
      dispatch({
        type: 'ADD_PENDING_OPTION',
        change
      })
    }
  }
}

export function checkPreferenceConflicts() {
  return function(dispatch, getState){
    dispatch({type: 'PREFERENCE_CHECK_START'})
    const { apiNonce, apiUrl, options, pendingOptions } = getState()

    axios.post(
      `${apiUrl}/preference-check`,
      { ...options, ...pendingOptions },
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    ).then(response => {
      const { status, data } = response
      if (200 === status) {
        dispatch({
          type: 'PREFERENCE_CHECK_END',
          success: true,
          message: '',
          detectedConflicts: data
        })
      } else {
        dispatch({
          type: 'PREFERENCE_CHECK_END',
          success: false,
          message: 'Failed when checking options changes',
        })
      }
    }).catch(error => {
      const { response: { data: { code, message }}} = error

      const checkMessage = (code => { 
        switch(code) {
          case 'cant_update':
            return message
          case 'rest_no_route':
          case 'rest_cookie_invalid_nonce':
            return "Sorry, we couldn't reach the server"
          default:
            return "Update failed"
        }
      })(code)

      dispatch({
        type: 'PREFERENCE_CHECK_END',
        success: false,
        message: checkMessage
      })
    })
  }
}

export function submitPendingOptions() {
  return function(dispatch, getState) {
    const { apiNonce, apiUrl, options, pendingOptions } = getState()

    dispatch({type: 'OPTIONS_FORM_SUBMIT_START'})

    axios.put(
      `${apiUrl}/config`,
      { options: { ...options, ...pendingOptions }},
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    ).then(response => {
    const { status, data } = response
    if (200 === status) {
      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        data,
        success: true,
        message: 'Changes saved'
      })
    } else {
      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        success: false,
        message: "Failed to save changes"
      })
    }
    }).catch(error => {
      const { response: { data: { code, message }}} = error

      const submitMessage = (code => { 
        switch(code) {
          case 'cant_update':
            return message
          case 'rest_no_route':
          case 'rest_cookie_invalid_nonce':
            return "Sorry, we couldn't reach the server"
          default:
            return "Update failed"
        }
      })(code)

      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        success: false,
        message: submitMessage
      })
    })
  }
}

export function reportDetectedConflicts({ nodesTested = {} }) {
  return (dispatch, getState) => {
    const { apiNonce, apiUrl, unregisteredClients, showConflictDetectionReporter } = getState()

    // This should be a noop if by the time we get here the conflict detection reporter
    // is already gone. That would indicate that the user stopped the scanner before
    // the current page's scan was complete and report submitted. In that case,
    // we just ignore the report. Otherwise, this action would try to post results
    // to a REST route that will no longer be registered and listening, resulting a 404.
    if( !showConflictDetectionReporter ) {
      return
    }

    if( size(nodesTested.conflict) > 0 ) {
      const payload = Object.keys(nodesTested.conflict).reduce(function(acc, md5){
        acc[md5] = nodesTested.conflict[md5]
        return acc
      }, {})

      dispatch({
        type: 'CONFLICT_DETECTION_SUBMIT_START',
        unregisteredClientsBeforeDetection: unregisteredClients,
        recentConflictsDetected: nodesTested.conflict
      })

      axios.post(
        `${apiUrl}/conflict-detection/conflicts`,
        payload,
        {
          headers: {
            'X-WP-Nonce': apiNonce
          }
        }
      )
      .then(response => {
        const { status, data } = response

        dispatch({
          type: 'CONFLICT_DETECTION_SUBMIT_END',
          success: true,
          data: 204 === status ? null : data
        })
      })
      .catch(function(error){
        console.error('Font Awesome Conflict Detection Reporting Error: ', error)
        dispatch({
          type: 'CONFLICT_DETECTION_SUBMIT_END',
          success: false,
          message: `Submitting results to the WordPress server failed, and this might indicate a bug. Could you report this on the plugin's support forum? There maybe additional diagnostic output in the JavaScript console.\n\n${error}`
        })
      })
    } else {
      dispatch({ type: 'CONFLICT_DETECTION_NONE_FOUND' })
    }
  }
}

export function snoozeV3DeprecationWarning() {
  return (dispatch, getState) => {
    const { apiNonce, apiUrl } = getState()

    dispatch({ type: 'SNOOZE_V3DEPRECATION_WARNING_START' })

    axios.put(
      `${apiUrl}/v3deprecation`,
      { snooze: true },
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    )
    .then(function() {
      dispatch({ type: 'SNOOZE_V3DEPRECATION_WARNING_END', success: true, snooze: true })
    })
    .catch(function(error){
      console.error('Font Awesome Plugin Error:', error)
      dispatch({
        type: 'SNOOZE_V3DEPRECATION_WARNING_END',
        success: false,
        message: `Snoozing failed. This might indicate a bug. Could you report this on the plugin's support forum? There maybe additional diagnostic output in the JavaScript console.\n\n${error}`
      })
    })
  }
}

export function setActiveAdminTab(tab) {
  return {
    type: 'SET_ACTIVE_ADMIN_TAB',
    tab
  }
}

export function setConflictDetectionScanner({ enable = true }) {
  return function(dispatch, getState) {
    const { apiNonce, apiUrl } = getState()

    const actionStartType = enable
      ? 'ENABLE_CONFLICT_DETECTION_SCANNER_START'
      : 'DISABLE_CONFLICT_DETECTION_SCANNER_START'

    const actionEndType = enable
      ? 'ENABLE_CONFLICT_DETECTION_SCANNER_END'
      : 'DISABLE_CONFLICT_DETECTION_SCANNER_END'

    dispatch({type: actionStartType})

    axios.put(
      `${apiUrl}/conflict-detection/until`,
      enable
        ? Math.floor((new Date((new Date()).valueOf() + (CONFLICT_DETECTION_SCANNER_DURATION_MIN * 1000 * 60))) / 1000)
        : Math.floor((new Date())/1000) - CONFLICT_DETECTION_SCANNER_DEACTIVATION_DELTA_MS,
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    ).then(response => {
      const { status, data } = response
      dispatch({
        type: actionEndType,
        data: 204 === status ? null : data,
        success: true
      })
    }).catch(error => {
      const { response: { data: { code, message }}} = error

      const submitMessage = (code => { 
        switch(code) {
          case 'cant_update':
            return message
          case 'rest_no_route':
          case 'rest_cookie_invalid_nonce':
            return "Sorry, we couldn't reach the server"
          default:
            return "Update failed"
        }
      })(code)

      dispatch({
        type: actionEndType,
        success: false,
        message: submitMessage
      })
    })
  }
}
