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

/**
 * This both sends appropriately formatted output to the console via console.info,
 * and returns a uiMessage that would be appropriate to display to an admin user.
 */
function handleSingleWpErrorOutput({ wpError, uiMessageDefault, uiMessageOverride }) {
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

  if( output && '' !== output ) {
    console.info(output)
  } else {
    console.info(wpError)
  }

  return uiMessageOverride || uiMessage || uiMessageDefault
}

function handleWpErrorOutput({ wpError, uiMessageDefault, uiMessageOverride }) {
  if( get(wpError, 'code') ) {
    return handleSingleWpErrorOutput({ wpError, uiMessageDefault, uiMessageOverride })
  } else if( size( get(wpError, 'errors') ) > 0 ) {
    // Multiple errors
    const wpErrors = Object.keys(wpError.errors).map(code => {
      // get the first error message available for this code
      const message = get(wpError, `errors.${code}.0`)
      const data = get(wpError, `error_data.${code}`)

      return {
        code,
        message,
        data
      }
    })

    const uiMessage = wpErrors.reduce((acc, error) => {
      console.group(ONE_OF_MANY_ERRORS_GROUP_LABEL)

      const msg = handleSingleWpErrorOutput({
        wpError: error,
        uiMessageDefault,
        uiMessageOverride
      })

      console.groupEnd()

      // The uiMessage we should return will be the first error message that isn't
      // from a 'previous_exception'
      return (!acc && wpError.code !== 'previous_exception')
        ? msg
        : acc
    }, null)

    return uiMessage
  } else {
    // We don't recognize this schema
    return handleSingleWpErrorOutput({
      wpError: {
        code: 'fontawesome_unknown_error',
        message: ERROR_REPORTING_ERROR
      }
    })
  }
}

export default function({ response, uiMessageDefault = UI_MESSAGE_DEFAULT, uiMessageOverride = null }) {
  // We might get back a successful response that still has errors on it, as in
  // the case of a PreferenceRegistrationException.
  const status = get(response, 'status')
  const isOK = status >= 200 && status < 300
  const okError = isOK
    ? get(response, 'data.error', null)
    : null

  // This could be a serialized WP_Error object representing either a single
  // or multiple errors.
  const wpError = isOK
    ? !!okError
      ? okError
      : null
    : ( get(response, 'response.data.code') || get(response, 'data.errors') )
      ? get(response, 'response.data')
      : {} // pass through an error object that has a bad schema to produce a bad schema report

  // If the status is OK and we have no wpError at this point, then there's no
  // error to process, but we should return what we may have been given as the uiMessage.
  if(isOK && !wpError) return uiMessageOverride || uiMessageDefault

  console.group(ERROR_REPORT_PREAMBLE)

  if( !!okError ) {
    console.info(OK_ERROR_PREAMBLE)
  }

  const uiMessage = handleWpErrorOutput({ wpError, uiMessageDefault, uiMessageOverride })

  console.groupEnd()

  return uiMessageOverride || uiMessage || uiMessageDefault
}
