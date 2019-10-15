import axios from 'axios'
import { toPairs, size } from 'lodash'

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

export function reportDetectedConflicts({ nodesTested = null}) {
  return (dispatch, getState) => {
    const { apiNonce, apiUrl, unregisteredClients } = getState()

    const payload = Object.keys(nodesTested.conflict).reduce(function(acc, md5){
      acc[md5] = nodesTested.conflict[md5]
      return acc
    }, {})

    dispatch({ type: 'CONFLICT_DETECTION_SUBMIT_START', countBeforeDetection: size(unregisteredClients) })

    axios.post(
      `${apiUrl}/report-conflicts`,
      payload,
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    )
    .then(function() {
      dispatch({
        type: 'CONFLICT_DETECTION_SUBMIT_END',
        success: true,
        unregisteredClients: payload
      })
    })
    .catch(function(error){
      console.error('Font Awesome Conflict Detection Reporting Error: ', error)
      dispatch({
        type: 'CONFLICT_DETECTION_SUBMIT_END',
        success: false,
        unregisteredClients: payload,
        message: `Submitting results to the WordPress server failed, and this might indicate a bug. Could you report this on the plugin's support forum? There maybe additional diagnostic output in the JavaScript console.\n\n${error}`
      })
    })
  }
}
