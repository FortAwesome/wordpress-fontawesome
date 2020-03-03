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

function preprocessResponse( response ) {
  const confirmed = has( response, 'headers.fontawesome-confirmation' )

  if ( 204 === response.status && '' !== response.data ) {
      //console.log('WARNING: response body should be empty but has this:', response.data)
      reportRequestError({ error: null, confirmed, trimmed: response.data, expectEmpty: true })
  } else {
    const sliced = sliceJson( response.data )

    if ( null === sliced ) {
      //console.log('WARNING: could not find valid JSON data in the response:', response.data)
      reportRequestError({ error: null, confirmed, falsePositive: true, trimmed: response.data })
    } else {
      const { parsed, trimmed, json } = sliced

      // Fixup the response data with just json
      response.data = json

      // console.log('WARNING: found invalid content preceding JSON data in the response:', trimmed)
      response.fontAwesomeTrimmed = trimmed

      if( response.status < 300 ) {
        const errors = get( parsed, 'errors' )

        if ( errors ) {
          // write an error report to the console and mention that this is a false negative
          // console.log('WARNING: got errors in a 2XX response:', errors)
          reportRequestError({ error: parsed, confirmed, falsePositive: true, trimmed })
        } else {
          const error = get( parsed, 'error' )

          // We may receive errors back with a 200 response, such as when
          // there PreferenceRegistrationExceptions.
          if( error ) {
            reportRequestError({ error, ok: true, confirmed, trimmed })
          } else {
            reportRequestError({ error: null, ok: true, confirmed, trimmed })
          }
        }
      }
    }
  }

  return response
}

axios.interceptors.response.use(
  response => preprocessResponse( response ),
  error => {
    let fontAwesomeMessage = null

    if( error.response ) {
      error.response = preprocessResponse( error.response )
      
    } else if ( error.request ) {
      // TODO: emit error about not being able to make a request

    } else {
      // TODO: emit totally unexpected error and add error.message if present
    }
    console.log('DEBUG: intercepting error')
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
      const message = reportRequestError({
        response: error,
        uiMessageDefault: __( 'Couldn\'t save those changes', 'font-awesome' )
      })

      dispatch({
        type: 'DELETE_UNREGISTERED_CLIENTS_END',
        success: false,
        message
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

    axios.put(
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
      const message = reportRequestError({
        response: error,
        uiMessageDefault: __( 'Couldn\'t save those changes', 'font-awesome' )
      })

      dispatch({
        type: 'BLOCKLIST_UPDATE_END',
        success: false,
        message
      })
    })
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
      const { data } = response

      dispatch({
        type: 'PREFERENCE_CHECK_END',
        success: true,
        message: '',
        detectedConflicts: data
      })
    }).catch(error => {
      const message = reportRequestError({
        response: error,
        uiMessageDefault: __( 'Couldn\'t save those changes', 'font-awesome' )
      })

      dispatch({
        type: 'PREFERENCE_CHECK_END',
        success: false,
        message
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
      const { data } = response

      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        data,
        success: true,
        message: __( 'Changes saved', 'font-awesome' )
      })
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
      const message = reportRequestError({
        response: error
      })

      dispatch({
        type: 'SNOOZE_V3DEPRECATION_WARNING_END',
        success: false,
        message
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
      const message = reportRequestError({
        response: error,
        uiMessageDefault: __( 'Couldn\'t start the scanner', 'font-awesome' )
      })

      dispatch({
        type: actionEndType,
        success: false,
        message
      })
    })
  }
}
