import axios from 'axios'
import { toPairs } from 'lodash'

export function addPendingOption(change) {
  return function(dispatch, getState) {
    const { options } = getState()

    const [ key, val ] = toPairs(change)[0]

    // If we're changing back to an original setting
    if( options[key] === val ) {
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
