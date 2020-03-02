import get from 'lodash/get'
import size from 'lodash/size'
import { __ } from '@wordpress/i18n'

export const ERROR_REPORT_PREAMBLE = __( 'Font Awesome WordPress Plugin Error Report', 'font-awesome' )
const UI_MESSAGE_DEFAULT = __( 'D\'oh! That failed big time.', 'font-awesome' )
const ERROR_REPORTING_ERROR = __( 'There was an error attempting to report the error.', 'font-awesome' )
const REST_NO_ROUTE_ERROR = __( 'Oh no! Your web browser could not reach your WordPress server.', 'font-awesome' )
const REST_COOKIE_INVALID_NONCE_ERROR = __( 'It looks like your web browser session expired. Try logging out and log back in to WordPress admin.', 'font-awesome' )
const OK_ERROR_PREAMBLE = __( 'The last request was successful, but it also returned the following error(s), which might be helpful for troubleshooting.', 'font-awesome' )
const ONE_OF_MANY_ERRORS_GROUP_LABEL = __( 'Error', 'font-awesome' )
const FALSE_POSITIVE_MESSAGE = __( 'WARNING: The last request contained errors, though your WordPress server reported it as a success. This usually means there\'s a problem with your theme or one of your other plugins emitting output that is causing problems.', 'font-awesome' )
const UNCONFIRMED_RESPONSE_MESSAGE = __( 'WARNING: The last response from your WordPress server did not include the confirmation header that should be in all valid Font Awesome responses. This is a clue that some code from another theme or plugin is acting badly and causing the wrong headers to be sent.', 'font-awesome')
const TRIMMED_RESPONSE_PREAMBLE = __( 'WARNING: Invalid Data Trimmed from Server Response', 'font-awesome' )
const EXPECTED_EMPTY_MESSAGE = __( 'WARNING: We expected the last response from the server to contain no data, but it contained something unexpected.', 'font-awesome' )
const MISSING_ERROR_DATA_MESSAGE = __( 'Your WordPress server returned an error for that last request, but there was no information about the error.', 'font-awesome' )

/**
 * This both sends appropriately formatted output to the console via console.info,
 * and returns a uiMessage that would be appropriate to display to an admin user.
 */
function handleSingleWpErrorOutput( wpError ) {
  if( ! get(wpError, 'code') ) {
    console.info(ERROR_REPORTING_ERROR)
    return UI_MESSAGE_DEFAULT
  }

  let uiMessage = null
  let output = ''

  const message = get(wpError, 'message')
  if(message) {
    output = output.concat(`message: ${message}\n`)
    uiMessage = message
  }

  const code = get(wpError, 'code')
  if(code) {
    output = output.concat(`code: ${code}\n`)

    switch(code) {
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

  const status = get(wpError, 'data.status')
  if(status) output = output.concat(`status: ${status}\n`)

  const trace = get(wpError, 'data.trace')
  if(trace) output = output.concat(`trace:\n${trace}\n`)

  const request = get(wpError, 'data.request')

  if( output && '' !== output ) {
    console.info(output)
  } else {
    console.info(wpError)
  }

  if(request) {
    console.info(request)
  }

  const failedRequestMessage = get(wpError, 'data.failedRequestMessage')

  if(failedRequestMessage) {
    console.info(failedRequestMessage)
  }

  return uiMessage
}

function handleAllWpErrorOutput(errorData) {
  const wpErrors = Object.keys(errorData.errors || []).map(code => {
    // get the first error message available for this code
    const message = get(errorData, `errors.${code}.0`)
    const data = get(errorData, `error_data.${code}`)

    return {
      code,
      message,
      data
    }
  })

  if(0 === size(wpErrors)) {
    wpErrors.push({
      code: 'fontawesome_unknown_error',
      message: ERROR_REPORTING_ERROR
    })
  }

  const uiMessage = wpErrors.reduce((acc, error) => {
    console.group(ONE_OF_MANY_ERRORS_GROUP_LABEL)

    const msg = handleSingleWpErrorOutput( error )

    console.groupEnd()

    // The uiMessage we should return will be the first error message that isn't
    // from a 'previous_exception'
    return (!acc && error.code !== 'previous_exception')
      ? msg
      : acc
  }, null)

  return uiMessage
}

export default function(params) {
  const {
    error,
    ok = false,
    falsePositive = false,
    confirmed = true,
    expectEmpty = false,
    trimmed = ''
  } = params

  console.group(ERROR_REPORT_PREAMBLE)

  if( ok ) {
    console.info(OK_ERROR_PREAMBLE)
  }

  if( falsePositive ) {
    console.info(FALSE_POSITIVE_MESSAGE)
  }

  if( ! confirmed ) {
    console.info(UNCONFIRMED_RESPONSE_MESSAGE)
  }

  if( '' !== trimmed ) {
    console.group(TRIMMED_RESPONSE_PREAMBLE)
    if( expectEmpty ) {
      console.info(EXPECTED_EMPTY_MESSAGE)
    }
    console.info(trimmed)
    console.groupEnd()
  }

  const uiMessage = null !== error
    ? handleAllWpErrorOutput( error )
    : null

  if ( null === error && trimmed === '' && confirmed ) {
    console.info(MISSING_ERROR_DATA_MESSAGE)
  }

  console.groupEnd()

  return uiMessage
}
