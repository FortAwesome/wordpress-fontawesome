import get from 'lodash-es/get'
import set from 'lodash-es/set'
import size from 'lodash-es/size'
import { __ } from '@wordpress/i18n'

export const ERROR_REPORT_PREAMBLE = __('Font Awesome WordPress Plugin Error Report', 'font-awesome')
const UI_MESSAGE_DEFAULT = __("D'oh! That failed big time.", 'font-awesome')
const ERROR_REPORTING_ERROR = __('There was an error attempting to report the error.', 'font-awesome')
const REST_NO_ROUTE_ERROR = __('Oh no! Your web browser could not reach your WordPress server.', 'font-awesome')
const REST_COOKIE_INVALID_NONCE_ERROR = __(
  'It looks like your web browser session expired. Try logging out and log back in to WordPress admin.',
  'font-awesome'
)
const OK_ERROR_PREAMBLE = __(
  'The last request was successful, but it also returned the following error(s), which might be helpful for troubleshooting.',
  'font-awesome'
)
const ONE_OF_MANY_ERRORS_GROUP_LABEL = __('Error', 'font-awesome')
const FALSE_POSITIVE_MESSAGE = __(
  "WARNING: The last request contained errors, though your WordPress server reported it as a success. This usually means there's a problem with your theme or one of your other plugins emitting output that is causing problems.",
  'font-awesome'
)
const UNCONFIRMED_RESPONSE_MESSAGE = __(
  'WARNING: The last response from your WordPress server did not include the confirmation header that should be in all valid Font Awesome responses. This is a clue that some code from another theme or plugin is acting badly and causing the wrong headers to be sent.',
  'font-awesome'
)
const CONFIRMED_RESPONSE_MESSAGE = __(
  "CONFIRMED: The last response from your WordPress server included the confirmation header that is expected for all valid responses from the Font Awesome plugin's code running on your WordPress server.",
  'font-awesome'
)
const TRIMMED_RESPONSE_PREAMBLE = __('WARNING: Invalid Data Trimmed from Server Response', 'font-awesome')
const EXPECTED_EMPTY_MESSAGE = __(
  'WARNING: We expected the last response from the server to contain no data, but it contained something unexpected.',
  'font-awesome'
)
const MISSING_ERROR_DATA_MESSAGE = __(
  'Your WordPress server returned an error for that last request, but there was no information about the error.',
  'font-awesome'
)
const REPORT_INFO_PARAM_KEYS = [
  'requestMethod',
  'responseStatus',
  'responseStatusText',
  'requestUrl',
  'requestData',
  'responseHeaders',
  'responseData',
  'requestHeaders'
]

/**
 * This both sends appropriately formatted output to the console via console.info,
 * and returns a uiMessage that would be appropriate to display to an admin user.
 */
function handleSingleWpErrorOutput(wpError) {
  if (!get(wpError, 'code')) {
    console.info(ERROR_REPORTING_ERROR)
    return UI_MESSAGE_DEFAULT
  }

  let uiMessage = null
  let output = ''

  const message = get(wpError, 'message')
  if (message) {
    output = output.concat(`message: ${message}\n`)
    uiMessage = message
  }

  const code = get(wpError, 'code')
  if (code) {
    output = output.concat(`code: ${code}\n`)

    switch (code) {
      case 'rest_no_route':
        uiMessage = REST_NO_ROUTE_ERROR
        break
      case 'rest_cookie_invalid_nonce':
        uiMessage = REST_COOKIE_INVALID_NONCE_ERROR
        break
      case 'fontawesome_unknown_error':
        uiMessage = UI_MESSAGE_DEFAULT
        break
      default:
    }
  }

  const data = get(wpError, 'data')

  if ('string' === typeof data) {
    output = output.concat(`data: ${data}\n`)
  } else {
    const status = get(wpError, 'data.status')
    if (status) output = output.concat(`status: ${status}\n`)

    const trace = get(wpError, 'data.trace')
    if (trace) output = output.concat(`trace:\n${trace}\n`)
  }

  if (output && '' !== output) {
    console.info(output)
  } else {
    console.info(wpError)
  }

  const request = get(wpError, 'data.request')
  if (request) {
    console.info(request)
  }

  const failedRequestMessage = get(wpError, 'data.failedRequestMessage')

  if (failedRequestMessage) {
    console.info(failedRequestMessage)
  }

  return uiMessage
}

function handleAllWpErrorOutput(errorData = {}) {
  const wpErrors = Object.keys(errorData.errors || []).map((code) => {
    // get the first error message available for this code
    const message = get(errorData, `errors.${code}.0`)
    const data = get(errorData, `error_data.${code}`)

    return {
      code,
      message,
      data
    }
  })

  if (0 === size(wpErrors)) {
    wpErrors.push({
      code: 'fontawesome_unknown_error',
      message: ERROR_REPORTING_ERROR
    })
  }

  const uiMessage = wpErrors.reduce((acc, error) => {
    console.group(ONE_OF_MANY_ERRORS_GROUP_LABEL)

    const msg = handleSingleWpErrorOutput(error)

    console.groupEnd()

    // The uiMessage we should return will be the first error message that isn't
    // from a 'previous_exception'
    return !acc && error.code !== 'previous_exception' ? msg : acc
  }, null)

  return uiMessage
}

function report(params) {
  const { error = null, ok = false, falsePositive = false, confirmed = false, expectEmpty = false, trimmed = '' } = params

  console.group(ERROR_REPORT_PREAMBLE)

  if (ok) {
    console.info(OK_ERROR_PREAMBLE)
  }

  if (falsePositive) {
    console.info(FALSE_POSITIVE_MESSAGE)
  }

  if (confirmed) {
    console.info(CONFIRMED_RESPONSE_MESSAGE)
  } else {
    console.info(UNCONFIRMED_RESPONSE_MESSAGE)
  }

  // Strings to later join with newlines, making a report.
  const info = []

  for (const key of REPORT_INFO_PARAM_KEYS) {
    const val = get(params, key)

    if ('undefined' !== typeof val) {
      const valType = typeof val

      if ('string' === valType || 'number' === valType) {
        info.push(`${key}: ${val}`)
      } else if ('object' === valType) {
        info.push(`${key}:`)

        for (const innerKey in val) {
          info.push(`\t${innerKey}: ${val[innerKey].toString()}`)
        }
      } else {
        console.info(`Unexpected report content type \'${valType}\' for ${key}:`, val)
      }
    }
  }

  if (size(info) > 0) {
    console.info(`Extra Info:\n${info.join('\n')}`)
  }

  if ('' !== trimmed) {
    console.group(TRIMMED_RESPONSE_PREAMBLE)
    if (expectEmpty) {
      console.info(EXPECTED_EMPTY_MESSAGE)
    }
    console.info(trimmed)
    console.groupEnd()
  }

  const uiMessage = null !== error ? handleAllWpErrorOutput(error) : null

  if (error && trimmed === '' && confirmed) {
    console.info(MISSING_ERROR_DATA_MESSAGE)
  }

  console.groupEnd()

  return uiMessage
}

// Expects an axios Response object as an argument.
export function redactRequestData(response = {}) {
  const requestContentType = get(response, 'config.headers.Content-Type', '').toLowerCase()
  const requestData = get(response, 'config.data', '')

  let redacted = ''

  if ('application/json' === requestContentType) {
    try {
      const data = JSON.parse(requestData)
      const apiTokenValue = get(data, 'options.apiToken')

      /**
       * When a kit is configured, and options are submitted for any request, other than the
       * initial request to save the API token, the value of the apiToken property is just a
       * boolean indicating whether an API token has been saved. We don't need to redact
       * that boolean. It's useful to leave it so the error report indicates whether an
       * apiToken has been successfully saved.
       */
      if ('boolean' !== typeof apiTokenValue) {
        set(data, 'options.apiToken', 'REDACTED')
      }

      redacted = JSON.stringify(data)
    } catch (e) {
      redacted = `ERROR while redacting request data: ${e.toString()}`
    }

    return redacted
  } else {
    return requestData
  }
}

export function redactHeaders(headers = {}) {
  const redacted = { ...headers }

  for (const key in redacted) {
    if ('x-wp-nonce' === key.toLowerCase()) {
      redacted[key] = 'REDACTED'
    }
  }

  return redacted
}

export default report
