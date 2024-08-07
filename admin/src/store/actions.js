import axios from 'axios'
import toPairs from 'lodash/toPairs'
import size from 'lodash/size'
import get from 'lodash/get'
import find from 'lodash/find'
import reportRequestError, { redactRequestData, redactHeaders } from '../util/reportRequestError'
import { __ } from '@wordpress/i18n'
import has from 'lodash/has'
import sliceJson from '../util/sliceJson'
import { clearQueryCache } from '../queryCache'

const restApiAxios = axios.create()

// How far into the future from "now" until the conflict detection scanner
// will be enabled.
export const CONFLICT_DETECTION_SCANNER_DURATION_MIN = 10

// How far in the past to set detectConflictsUntil when the conflict detection
// scanner is being disabled. We can use a non-zero but negligible value in
// order to protect against possible race conditions, instead of 0
// (which would just be exactly "now").
const CONFLICT_DETECTION_SCANNER_DEACTIVATION_DELTA_MS = 1

const COULD_NOT_SAVE_CHANGES_MESSAGE = __("Couldn't save those changes", 'font-awesome')
const REJECTED_METHOD_COULD_NOT_SAVE_CHANGES_MESSAGE = __(
  'Changes not saved because your WordPress server does not allow this kind of request. Look for details in the browser console.',
  'font-awesome'
)
const COULD_NOT_CHECK_PREFERENCES_MESSAGE = __("Couldn't check preferences", 'font-awesome')
const NO_RESPONSE_MESSAGE = __('A request to your WordPress server never received a response', 'font-awesome')
const REQUEST_FAILED_MESSAGE = __('A request to your WordPress server failed', 'font-awesome')
const COULD_NOT_START_SCANNER_MESSAGE = __("Couldn't start the scanner", 'font-awesome')
const COULD_NOT_SNOOZE_MESSAGE = __("Couldn't snooze", 'font-awesome')

export function preprocessResponse(response) {
  const confirmed = has(response, 'headers.fontawesome-confirmation')

  if (204 === response.status && '' !== response.data) {
    reportRequestError({ error: null, confirmed, trimmed: response.data, expectEmpty: true })
    // clean it up
    response.data = {}
    return response
  }

  const data = get(response, 'data', null)

  const foundUnexpectedData = 'string' === typeof data && size(data) > 0

  const sliced = foundUnexpectedData ? sliceJson(data) : {}

  // Fixup the response data if garbage was fixed
  if (foundUnexpectedData) {
    if (sliced) {
      response.data = get(sliced, 'parsed')
    }
  }

  // If we had to trim any garbage, we'll store it here
  const trimmed = get(sliced, 'trimmed', '')

  const errors = get(response, 'data.errors', null)

  if (response.status >= 400) {
    if (errors) {
      // This is just a normal error response.
      response.uiMessage = reportRequestError({ error: response.data, confirmed, trimmed })
    } else {
      const requestMethod = get(response, 'config.method', '').toUpperCase()
      const requestUrl = get(response, 'config.url')
      const responseStatus = response.status
      const responseStatusText = get(response, 'statusText')
      const requestData = redactRequestData(response)
      const responseHeaders = redactHeaders(get(response, 'headers', {}))
      const requestHeaders = redactHeaders(get(response, 'config.headers', {}))
      const responseData = get(response, 'data')

      response.uiMessage = reportRequestError({
        confirmed,
        requestData,
        requestMethod,
        requestUrl,
        responseHeaders,
        requestHeaders,
        responseStatus,
        responseStatusText,
        responseData
      })

      if (405 === responseStatus) {
        response.uiMessage = REJECTED_METHOD_COULD_NOT_SAVE_CHANGES_MESSAGE
      }
    }

    return response
  }

  /**
   * We don't normally expect 3XX responses, but we'll just let it pass
   * through, unless we can see that the response has been corrupted,
   * in which case we'll report that first.
   */
  if (response.status < 400 && response.status >= 300) {
    if (!confirmed || '' !== trimmed) {
      response.uiMessage = reportRequestError({ error: null, confirmed, trimmed })
    }

    return response
  }

  /**
   * If we make it this far, then we have a 2XX response with some valid data,
   * which we maybe had to fix up.
   *
   * Now we need to detect whether it contains any errors to identify false positives,
   * or cases where it's legitmate for the controller to return an otherwise
   * successful response that also includes some error data for extra diagnostics.
   */
  if (errors) {
    /**
     * The controller sent back _only_ error data, though the HTTP status is 2XX.
     * This is a false positive.
     * This can occur when other buggy code running on the WordPress server preempts
     * and undermines the proper sending of HTTP headers, and yet the controller
     * still sends its otherwise-valid JSON error response.
     */
    const falsePositive = true
    response.falsePositive = true
    response.uiMessage = reportRequestError({ error: response.data, confirmed, falsePositive, trimmed })
    return response
  } else {
    const error = get(response, 'data.error', null)

    if (error) {
      /**
       * We may receive errors back with a 200 success response, such as when
       * the controller catches PreferenceRegistrationExceptions.
       */
      response.uiMessage = reportRequestError({ error, ok: true, confirmed, trimmed })
      return response
    }

    if (!confirmed) {
      /**
       * We have received a response that, by every indication so far, is successful.
       * However, it lacks the confirmation header, which _might_ indicate a problem.
       */
      response.uiMessage = reportRequestError({ error: null, ok: true, confirmed, trimmed })
    }
    return response
  }
}

restApiAxios.interceptors.response.use(
  (response) => preprocessResponse(response),
  (error) => {
    if (error.response) {
      error.response = preprocessResponse(error.response)
      error.uiMessage = get(error, 'response.uiMessage')
    } else if (error.request) {
      const code = 'fontawesome_request_noresponse'
      const e = {
        errors: {
          [code]: [NO_RESPONSE_MESSAGE]
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
          [code]: [REQUEST_FAILED_MESSAGE]
        },
        error_data: {
          [code]: { failedRequestMessage: error.message }
        }
      }

      error.uiMessage = reportRequestError({ error: e })
    }

    return Promise.reject(error)
  }
)

export function resetPendingOptions() {
  return {
    type: 'RESET_PENDING_OPTIONS'
  }
}

export function resetOptionsFormState() {
  return {
    type: 'OPTIONS_FORM_STATE_RESET'
  }
}

export function addPendingOption(change) {
  return function (dispatch, getState) {
    const { options } = getState()

    for (const [key, val] of toPairs(change)) {
      const originalValue = options[key]

      // If we're changing back to an original setting
      if (originalValue === val) {
        dispatch({
          type: 'RESET_PENDING_OPTION',
          change: { [key]: val }
        })
      } else {
        dispatch({
          type: 'ADD_PENDING_OPTION',
          change: { [key]: val }
        })
      }
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
  return function (dispatch, getState) {
    const { apiNonce, apiUrl, unregisteredClientsDeletionStatus } = getState()
    const deleteList = get(unregisteredClientsDeletionStatus, 'pending', null)

    if (!deleteList || size(deleteList) === 0) return

    dispatch({ type: 'DELETE_UNREGISTERED_CLIENTS_START' })

    const handleError = ({ uiMessage }) => {
      dispatch({
        type: 'DELETE_UNREGISTERED_CLIENTS_END',
        success: false,
        message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
      })
    }

    return restApiAxios
      .delete(`${apiUrl}/conflict-detection/conflicts`, {
        data: deleteList,
        headers: {
          'X-WP-Nonce': apiNonce
        }
      })
      .then((response) => {
        const { status, data, falsePositive } = response

        if (falsePositive) {
          handleError(response)
        } else {
          dispatch({
            type: 'DELETE_UNREGISTERED_CLIENTS_END',
            success: true,
            data: 204 === status ? null : data,
            message: ''
          })
        }
      })
      .catch(handleError)
  }
}

export function updatePendingBlocklist(data = []) {
  return {
    type: 'UPDATE_PENDING_BLOCKLIST',
    data
  }
}

export function submitPendingBlocklist() {
  return function (dispatch, getState) {
    const { apiNonce, apiUrl, blocklistUpdateStatus } = getState()
    const blocklist = get(blocklistUpdateStatus, 'pending', null)

    if (!blocklist) return

    dispatch({ type: 'BLOCKLIST_UPDATE_START' })

    const handleError = ({ uiMessage }) => {
      dispatch({
        type: 'BLOCKLIST_UPDATE_END',
        success: false,
        message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
      })
    }

    return restApiAxios
      .post(`${apiUrl}/conflict-detection/conflicts/blocklist`, blocklist, {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      })
      .then((response) => {
        const { status, data, falsePositive } = response

        if (falsePositive) {
          handleError(response)
        } else {
          dispatch({
            type: 'BLOCKLIST_UPDATE_END',
            success: true,
            data: 204 === status ? null : data,
            message: ''
          })
        }
      })
      .catch(handleError)
  }
}

export function checkPreferenceConflicts() {
  return function (dispatch, getState) {
    dispatch({ type: 'PREFERENCE_CHECK_START' })
    const { apiNonce, apiUrl, options, pendingOptions } = getState()

    const handleError = ({ uiMessage }) => {
      dispatch({
        type: 'PREFERENCE_CHECK_END',
        success: false,
        message: uiMessage || COULD_NOT_CHECK_PREFERENCES_MESSAGE
      })
    }

    return restApiAxios
      .post(
        `${apiUrl}/preference-check`,
        { ...options, ...pendingOptions },
        {
          headers: {
            'X-WP-Nonce': apiNonce
          }
        }
      )
      .then((response) => {
        const { data, falsePositive } = response

        if (falsePositive) {
          handleError(response)
        } else {
          dispatch({
            type: 'PREFERENCE_CHECK_END',
            success: true,
            message: '',
            detectedConflicts: data
          })
        }
      })
      .catch(handleError)
  }
}

export function chooseAwayFromKitConfig({ activeKitToken }) {
  return function (dispatch, getState) {
    const { releases } = getState()

    dispatch({
      type: 'CHOOSE_AWAY_FROM_KIT_CONFIG',
      activeKitToken,
      concreteVersion: get(releases, 'latest_version_6')
    })
  }
}

export function chooseIntoKitConfig() {
  return { type: 'CHOOSE_INTO_KIT_CONFIG' }
}

export function queryKits() {
  return function (dispatch, getState) {
    const { apiNonce, apiUrl, options } = getState()

    const initialKitToken = get(options, 'kitToken', null)

    dispatch({ type: 'KITS_QUERY_START' })

    clearQueryCache()

    const handleKitsQueryError = ({ uiMessage }) => {
      dispatch({
        type: 'KITS_QUERY_END',
        success: false,
        message: uiMessage || __('Failed to fetch kits', 'font-awesome')
      })
    }

    const handleKitUpdateError = ({ uiMessage }) => {
      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        success: false,
        message: uiMessage || __("Couldn't update latest kit settings", 'font-awesome')
      })
    }

    return restApiAxios
      .post(
        `${apiUrl}/api`,
        'query { me { kits { name version technologySelected licenseSelected minified token shimEnabled autoAccessibilityEnabled status }}}',
        {
          headers: {
            'X-WP-Nonce': apiNonce
          }
        }
      )
      .then((response) => {
        if (response.falsePositive) return handleKitsQueryError(response)

        const data = get(response, 'data.data')

        // We may receive errors back with a 200 response, such as when
        // there PreferenceRegistrationExceptions.
        if (get(data, 'me')) {
          dispatch({
            type: 'KITS_QUERY_END',
            data,
            success: true
          })
        } else {
          return dispatch({
            type: 'KITS_QUERY_END',
            success: false,
            message: __('Failed to fetch kits. Regenerate your API Token and try again.', 'font-awesome')
          })
        }

        // If we didn't start out with a saved kitToken, we're done.
        // Otherwise, we'll move on to update any config on that kit which
        // might have changed since we saved it in WordPress.
        if (!initialKitToken) return

        const refreshedKits = get(data, 'me.kits', [])
        const currentKitRefreshed = find(refreshedKits, { token: initialKitToken })

        if (!currentKitRefreshed) return

        const optionsUpdate = {}

        // Inspect each relevant kit option for the current kit to see if it's
        // been changed since our last query.
        if (options.usePro && currentKitRefreshed.licenseSelected !== 'pro') {
          optionsUpdate.usePro = false
        } else if (!options.usePro && currentKitRefreshed.licenseSelected === 'pro') {
          optionsUpdate.usePro = true
        }

        if (options.technology === 'svg' && currentKitRefreshed.technologySelected !== 'svg') {
          optionsUpdate.technology = 'webfont'
          // pseudoElements must always be true for webfont
          optionsUpdate.pseudoElements = true
        } else if (options.technology !== 'svg' && currentKitRefreshed.technologySelected === 'svg') {
          optionsUpdate.technology = 'svg'
          // pseudoElements must always be false for svg when loaded in a kit
          optionsUpdate.pseudoElements = false
        }

        if (options.version !== currentKitRefreshed.version) {
          optionsUpdate.version = currentKitRefreshed.version
        }

        if (options.compat && !currentKitRefreshed.shimEnabled) {
          optionsUpdate.compat = false
        } else if (!options.compat && currentKitRefreshed.shimEnabled) {
          optionsUpdate.compat = true
        }

        dispatch({ type: 'OPTIONS_FORM_SUBMIT_START' })

        return restApiAxios
          .post(
            `${apiUrl}/config`,
            {
              options: {
                ...options,
                ...optionsUpdate
              }
            },
            {
              headers: {
                'X-WP-Nonce': apiNonce
              }
            }
          )
          .then((response) => {
            const { data, falsePositive } = response

            if (falsePositive) return handleKitUpdateError(response)

            dispatch({
              type: 'OPTIONS_FORM_SUBMIT_END',
              data,
              success: true,
              message: __('Kit changes saved', 'font-awesome')
            })
          })
          .catch(handleKitUpdateError)
      })
      .catch(handleKitsQueryError)
  }
}

export function submitPendingOptions() {
  return function (dispatch, getState) {
    const { apiNonce, apiUrl, options, pendingOptions } = getState()

    dispatch({ type: 'OPTIONS_FORM_SUBMIT_START' })

    const handleError = ({ uiMessage }) => {
      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        success: false,
        message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
      })
    }

    return restApiAxios
      .post(
        `${apiUrl}/config`,
        { options: { ...options, ...pendingOptions } },
        {
          headers: {
            'X-WP-Nonce': apiNonce
          }
        }
      )
      .then((response) => {
        const { data, falsePositive } = response

        if (falsePositive) {
          handleError(response)
        } else {
          dispatch({
            type: 'OPTIONS_FORM_SUBMIT_END',
            data,
            success: true,
            message: __('Changes saved', 'font-awesome')
          })
        }
      })
      .catch(handleError)
  }
}

export function updateApiToken({ apiToken = false, runQueryKits = false }) {
  return function (dispatch, getState) {
    const { apiNonce, apiUrl, options } = getState()

    dispatch({ type: 'OPTIONS_FORM_SUBMIT_START' })

    const handleError = ({ uiMessage }) => {
      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        success: false,
        message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
      })
    }

    return restApiAxios
      .post(
        `${apiUrl}/config`,
        { options: { ...options, apiToken } },
        {
          headers: {
            'X-WP-Nonce': apiNonce
          }
        }
      )
      .then((response) => {
        const { data, falsePositive } = response

        if (falsePositive) {
          handleError(response)
        } else {
          dispatch({
            type: 'OPTIONS_FORM_SUBMIT_END',
            data,
            success: true,
            message: __('API Token saved', 'font-awesome')
          })

          if (runQueryKits) {
            return dispatch(queryKits())
          }
        }
      })
      .catch(handleError)
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
    if (!showConflictDetectionReporter) {
      return
    }

    if (size(nodesTested.conflict) > 0) {
      const payload = Object.keys(nodesTested.conflict).reduce(function (acc, md5) {
        acc[md5] = nodesTested.conflict[md5]
        return acc
      }, {})

      dispatch({
        type: 'CONFLICT_DETECTION_SUBMIT_START',
        unregisteredClientsBeforeDetection: unregisteredClients,
        recentConflictsDetected: nodesTested.conflict
      })

      const handleError = ({ uiMessage }) => {
        dispatch({
          type: 'CONFLICT_DETECTION_SUBMIT_END',
          success: false,
          message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
        })
      }

      return restApiAxios
        .post(`${apiUrl}/conflict-detection/conflicts`, payload, {
          headers: {
            'X-WP-Nonce': apiNonce
          }
        })
        .then((response) => {
          const { status, data, falsePositive } = response

          if (falsePositive) {
            handleError(response)
          } else {
            dispatch({
              type: 'CONFLICT_DETECTION_SUBMIT_END',
              success: true,
              /**
               * If get back no data here, that can only mean that a previous
               * response with garbage in it had an erroneous HTTP 200 status
               * on it, but no parseable JSON, which is equivalent to a 204.
               */
              data: 204 === status || 0 === size(data) ? null : data
            })
          }
        })
        .catch(handleError)
    } else {
      dispatch({ type: 'CONFLICT_DETECTION_NONE_FOUND' })
    }
  }
}

export function setActiveAdminTab(tab) {
  return {
    type: 'SET_ACTIVE_ADMIN_TAB',
    tab
  }
}

export function setConflictDetectionScanner({ enable = true }) {
  return function (dispatch, getState) {
    const { apiNonce, apiUrl } = getState()

    const actionStartType = enable ? 'ENABLE_CONFLICT_DETECTION_SCANNER_START' : 'DISABLE_CONFLICT_DETECTION_SCANNER_START'

    const actionEndType = enable ? 'ENABLE_CONFLICT_DETECTION_SCANNER_END' : 'DISABLE_CONFLICT_DETECTION_SCANNER_END'

    dispatch({ type: actionStartType })

    const handleError = ({ uiMessage }) => {
      dispatch({
        type: actionEndType,
        success: false,
        message: uiMessage || COULD_NOT_START_SCANNER_MESSAGE
      })
    }

    return restApiAxios
      .post(
        `${apiUrl}/conflict-detection/until`,
        enable
          ? Math.floor(new Date(new Date().valueOf() + CONFLICT_DETECTION_SCANNER_DURATION_MIN * 1000 * 60) / 1000)
          : Math.floor(new Date() / 1000) - CONFLICT_DETECTION_SCANNER_DEACTIVATION_DELTA_MS,
        {
          headers: {
            'X-WP-Nonce': apiNonce
          }
        }
      )
      .then((response) => {
        const { status, data, falsePositive } = response

        if (falsePositive) {
          handleError(response)
        } else {
          dispatch({
            type: actionEndType,
            data: 204 === status ? null : data,
            success: true
          })
        }
      })
      .catch(handleError)
  }
}
