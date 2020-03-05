import axios from 'axios'
import toPairs from 'lodash/toPairs'
import size from 'lodash/size'
import get from 'lodash/get'
import find from 'lodash/find'
import reportRequestError from '../util/reportRequestError'
import { __ } from '@wordpress/i18n'
import has from 'lodash/has'
import sliceJson from '../util/sliceJson'

// How far into the future from "now" until the conflict detection scanner
// will be enabled.
export const CONFLICT_DETECTION_SCANNER_DURATION_MIN = 10

// How far in the past to set detectConflictsUntil when the conflict detection
// scanner is being disabled. We can use a non-zero but negligible value in
// order to protect against possible race conditions, instead of 0
// (which would just be exactly "now").
const CONFLICT_DETECTION_SCANNER_DEACTIVATION_DELTA_MS = 1

const COULD_NOT_SAVE_CHANGES_MESSAGE = __( 'Couldn\'t save those changes', 'font-awesome' )
const COULD_NOT_CHECK_PREFERENCES_MESSAGE = __( 'Couldn\'t check preferences', 'font-awesome' )
const NO_RESPONSE_MESSAGE = __( 'A request to your WordPress server never received a response', 'font-awesome' )
const REQUEST_FAILED_MESSAGE = __( 'A request to your WordPress server failed', 'font-awesome' )
const COULD_NOT_START_SCANNER_MESSAGE = __( 'Couldn\'t start the scanner', 'font-awesome' )
const COULD_NOT_SNOOZE_MESSAGE = __( 'Couldn\'t snooze', 'font-awesome' )
 
function preprocessResponse( response ) {
  const confirmed = has( response, 'headers.fontawesome-confirmation' )

  if ( 204 === response.status && '' !== response.data ) {
      reportRequestError({ error: null, confirmed, trimmed: response.data, expectEmpty: true })
  } else {
    const sliced = sliceJson( get(response, 'data', null) )

    if ( null === sliced ) {
      reportRequestError({ error: null, confirmed, falsePositive: true, trimmed: response.data })
    } else {
      const { parsed, trimmed, json } = sliced

      // Fixup the response data with clean json
      response.data = json

      const errors = get( parsed, 'errors' )

      if( response.status < 300 ) {
        if ( errors ) {
          /**
           * This is a false positive. We've received an HTTP 200 response from
           * the server, but it actually contains errors which should have been
           * HTTP 4xx or 5xx. This can occur when other buggy code running
           * on the WordPress server preempts and undermines the proper sending
           * of HTTP headers, and yet our controller still follows up with its
           * otherwise-valid JSON response.
           */
          const falsePositive = true
          response.falsePositive = true
          response.uiMessage = reportRequestError({ error: parsed, confirmed, falsePositive, trimmed })
        } else {
          const error = get( parsed, 'error' )

          // We may receive errors back with a 200 response, such as when
          // there PreferenceRegistrationExceptions.
          if( error ) {
            response.uiMessage = reportRequestError({ error, ok: true, confirmed, trimmed })
          } else {
            response.uiMessage = reportRequestError({ error: null, ok: true, confirmed, trimmed })
          }
        }
      } else {
        // HTTP status is 3xx or greater
        response.uiMessage = reportRequestError({ error: errors ? parsed : null, confirmed, trimmed })
      }
    }
  }

  return response
}

axios.interceptors.response.use(
  response => preprocessResponse( response ),
  error => {
    if( error.response ) {
      error.response = preprocessResponse( error.response )
      error.uiMessage = get(error, 'response.uiMessage')
    } else if ( error.request ) {
      const code = 'fontawesome_request_noresponse'
      const e = {
        errors: {
          [code]: [ NO_RESPONSE_MESSAGE ]
        },
        error_data: {
          [code]: { request: error.request }
        }
      }

      error.uiMessage = reportRequestError({ error: e })
    } else {
      const code = 'fontawesome_request_failed'
      const e = {
        errors: {
          [code]: [ REQUEST_FAILED_MESSAGE ]
        },
        error_data: {
          [code]: { failedRequestMessage: error.message }
        }
      }

      error.uiMessage = reportRequestError({ error: e })
    }

    return error
  }
)

export function resetPendingOptions() {
  return {
    type: 'RESET_PENDING_OPTIONS'
  }
}

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

export function updatePendingUnregisteredClientsForDeletion(data = []) {
  return {
    type: 'UPDATE_PENDING_UNREGISTERED_CLIENTS_FOR_DELETION',
    data
  }
}

export function resetUnregisteredClientsDeletionStatus() {
  return {
    type: 'DELETE_UNREGISTERED_CLIENTS_RESET'
  }
}

export function resetPendingBlocklistSubmissionStatus() {
  return {
    type: 'BLOCKLIST_UPDATE_RESET'
  }
}

export function submitPendingUnregisteredClientDeletions() {
  return function(dispatch, getState){
    const { apiNonce, apiUrl, unregisteredClientsDeletionStatus } = getState()
    const deleteList = get( unregisteredClientsDeletionStatus, 'pending', null )

    if (!deleteList || size( deleteList ) === 0) return

    dispatch({ type: 'DELETE_UNREGISTERED_CLIENTS_START' })

    axios.delete(
      `${apiUrl}/conflict-detection/conflicts`,
      {
        data: deleteList,
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    ).then(response => {
      const { status, data } = response
      dispatch({
        type: 'DELETE_UNREGISTERED_CLIENTS_END',
        success: true,
        data: 204 === status ? null : data,
        message: ''
      })
    }).catch(error => {
      const { uiMessage } = error

      dispatch({
        type: 'DELETE_UNREGISTERED_CLIENTS_END',
        success: false,
        message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
      })
    })
  }
}

export function updatePendingBlocklist(data = []) {
  return {
    type: 'UPDATE_PENDING_BLOCKLIST',
    data
  }
}

export function submitPendingBlocklist() {
  return function(dispatch, getState){
    const { apiNonce, apiUrl, blocklistUpdateStatus } = getState()
    const blocklist = get( blocklistUpdateStatus, 'pending', null )

    if (!blocklist) return

    dispatch({type: 'BLOCKLIST_UPDATE_START'})

    return axios.put(
      `${apiUrl}/conflict-detection/conflicts/blocklist`,
      blocklist,
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    ).then(response => {
      const { status, data } = response
      dispatch({
        type: 'BLOCKLIST_UPDATE_END',
        success: true,
        data: 204 === status ? null : data,
        message: ''
      })
    }).catch(error => {
      const { uiMessage } = error

      dispatch({
        type: 'BLOCKLIST_UPDATE_END',
        success: false,
        message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
      })
    })
  }
}

export function checkPreferenceConflicts() {
  return function(dispatch, getState){
    dispatch({type: 'PREFERENCE_CHECK_START'})
    const { apiNonce, apiUrl, options, pendingOptions } = getState()

    return axios.post(
      `${apiUrl}/preference-check`,
      { ...options, ...pendingOptions },
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    ).then(response => {
      const { data, falsePositive, uiMessage } = response

      if( falsePositive ) {
        dispatch({
          type: 'PREFERENCE_CHECK_END',
          success: false,
          message: uiMessage || COULD_NOT_CHECK_PREFERENCES_MESSAGE
        })
      } else {
        dispatch({
          type: 'PREFERENCE_CHECK_END',
          success: true,
          message: '',
          detectedConflicts: data
        })
      }
    }).catch(error => {
      const { uiMessage } = error

      dispatch({
        type: 'PREFERENCE_CHECK_END',
        success: false,
        message: uiMessage || COULD_NOT_CHECK_PREFERENCES_MESSAGE
      })
    })
  }
}

export function chooseAwayFromKitConfig({ activeKitToken }) {
  return function(dispatch, getState) {
    const { releases } = getState()

    dispatch({
      type: 'CHOOSE_AWAY_FROM_KIT_CONFIG',
      activeKitToken,
      concreteVersion: get(releases, 'latest_version')
    })
  }
}

export function chooseIntoKitConfig() {
  return { type: 'CHOOSE_INTO_KIT_CONFIG' }
}

export function queryKits() {
  return function(dispatch, getState) {
    const { apiNonce, apiUrl, options } = getState()

    const initialKitToken = get(options, 'kitToken', null)

    dispatch({ type: 'KITS_QUERY_START' })

    axios.post(
      `${apiUrl}/api`,
      `query {
        me {
          kits {
            name
            version
            technologySelected
            licenseSelected
            minified
            token
            shimEnabled
            integrityHash
            useIntegrityHash
            autoAccessibilityEnabled
            status
          }
        }
      }`,
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    ).then(response => {
      const data = get(response, 'data.data')

      // We may receive errors back with a 200 response, such as when
      // there PreferenceRegistrationExceptions.
      if( get( data, 'me') ) {
        dispatch({
          type: 'KITS_QUERY_END',
          data,
          success: true
        })
      } else {
        const message = reportRequestError({
          response,
          uiMessageDefault: __( 'Failed to fetch kits. Regenerate your API Token and try again.', 'font-awesome' )
        })

        dispatch({
          type: 'KITS_QUERY_END',
          success: false,
          message
        })

        return
      }

      // If we didn't start out with a saved kitToken, we're done.
      // Otherwise, we'll move on to update any config on that kit which
      // might have changed since we saved it in WordPress.
      if(! initialKitToken) return

      const refreshedKits = get( data, 'me.kits', [] )
      const currentKitRefreshed = find( refreshedKits, { token: initialKitToken } )

      if(! currentKitRefreshed) return

      const optionsUpdate = {}

      // Inspect each relevant kit option for the current kit to see if it's
      // been changed since our last query.
      if( options.usePro && currentKitRefreshed.licenseSelected !== 'pro' ) {
        optionsUpdate.usePro = false
      } else if ( !options.usePro && currentKitRefreshed.licenseSelected === 'pro' ) {
        optionsUpdate.usePro = true
      }

      if( options.technology === 'svg' && currentKitRefreshed.technologySelected !== 'svg' ) {
        optionsUpdate.technology = 'webfont'
      } else if( options.technology !== 'svg' && currentKitRefreshed.technologySelected === 'svg' ) {
        optionsUpdate.technology = 'svg'
      }

      if( options.version !== currentKitRefreshed.version) {
        optionsUpdate.version = currentKitRefreshed.version
      }

      if( options.v4Compat && !currentKitRefreshed.shimEnabled ) {
        optionsUpdate.v4Compat = false
      } else if( !options.v4Compat && currentKitRefreshed.shimEnabled ) {
        optionsUpdate.v4Compat = true
      }

      dispatch({type: 'OPTIONS_FORM_SUBMIT_START'})

      axios.put(
        `${apiUrl}/config`,
        { 
          options: {
            ...options, ...optionsUpdate
          }
        },
        {
          headers: {
            'X-WP-Nonce': apiNonce
          }
        }
      ).then(response => {
        const { data } = response

        dispatch({
          type: 'OPTIONS_FORM_SUBMIT_END',
          data,
          success: true,
          message: __( 'Kit changes saved', 'font-awesome' )
        })
      }).catch(error => {
        const message = reportRequestError({
          response: error,
          uiMessageDefault: __( 'Couldn\'t update latest kit settings', 'font-awesome' )
        })

        dispatch({
          type: 'OPTIONS_FORM_SUBMIT_END',
          success: false,
          message
        })
      })
    }).catch(error => {
      const message = reportRequestError({
        response: error,
        uiMessageDefault: __( 'Failed to fetch kits', 'font-awesome' )
      })

      dispatch({
        type: 'KITS_QUERY_END',
        success: false,
        message
      })
    })
  }
}

export function submitPendingOptions() {
  return function(dispatch, getState) {
    const { apiNonce, apiUrl, options, pendingOptions } = getState()

    dispatch({type: 'OPTIONS_FORM_SUBMIT_START'})

    return axios.put(
      `${apiUrl}/config`,
      { options: { ...options, ...pendingOptions }},
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    ).then(response => {
      const { data, falsePositive, uiMessage } = response

      if ( falsePositive ) {
        dispatch({
          type: 'OPTIONS_FORM_SUBMIT_END',
          success: false,
          message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE 
        })
      } else {
        dispatch({
          type: 'OPTIONS_FORM_SUBMIT_END',
          data,
          success: true,
          message: __( 'Changes saved', 'font-awesome' )
        })
      }
    }).catch(error => {
      const { uiMessage } = error

      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        success: false,
        message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
      })
    })
  }
}

export function updateApiToken({ apiToken = false, runQueryKits = false }) {
  return function(dispatch, getState) {
    const { apiNonce, apiUrl, options } = getState()

    dispatch({type: 'OPTIONS_FORM_SUBMIT_START'})

    axios.put(
      `${apiUrl}/config`,
      { options: { ...options, apiToken }},
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    ).then(response => {
      const { data } = response

      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        data,
        success: true,
        message: __( 'API Token saved', 'font-awesome' )
      })

      if( runQueryKits ) {
        dispatch(queryKits())
      }
    }).catch(error => {
      const message = reportRequestError({
        response: error
      })

      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        success: false,
        message
      })
    })
  }
}

export function userAttemptToStopScanner() {
  return {
    type: 'USER_STOP_SCANNER'
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
        const message = reportRequestError({
          response: error
        })

        dispatch({
          type: 'CONFLICT_DETECTION_SUBMIT_END',
          success: false,
          message
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

    return axios.put(
      `${apiUrl}/v3deprecation`,
      { snooze: true },
      {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }
    )
    .then(response => {
      const { falsePositive, uiMessage } = response

      if ( falsePositive ) {
        dispatch({
          type: 'SNOOZE_V3DEPRECATION_WARNING_END',
          success: false,
          message: uiMessage || COULD_NOT_SNOOZE_MESSAGE
        })
      } else {
        dispatch({
          type: 'SNOOZE_V3DEPRECATION_WARNING_END',
          success: true,
          snooze: true,
          message: ''
        })
      }
    })
    .catch(error => {
      const { uiMessage } = error

      dispatch({
        type: 'SNOOZE_V3DEPRECATION_WARNING_END',
        success: false,
        message: uiMessage || COULD_NOT_SNOOZE_MESSAGE
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

    return axios.put(
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
      const { status, data, falsePositive, uiMessage } = response

      if ( falsePositive ) {
        dispatch({
          type: actionEndType,
          success: false,
          message: uiMessage || COULD_NOT_START_SCANNER_MESSAGE
        })
      } else {
        dispatch({
          type: actionEndType,
          data: 204 === status ? null : data,
          success: true
        })
      }
    }).catch(error => {
      const { uiMessage } = error

      dispatch({
        type: actionEndType,
        success: false,
        message: uiMessage || COULD_NOT_START_SCANNER_MESSAGE
      })
    })
  }
}
