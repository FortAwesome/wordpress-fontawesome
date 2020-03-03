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

function handleAllWpErrorOutput({ error, uiMessageDefault, uiMessageOverride }) {
  const wpErrors = Object.keys(error.errors).map(code => {
    // get the first error message available for this code
    const message = get(error, `errors.${code}.0`)
    const data = get(error, `error_data.${code}`)

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
}

export default function({ error, uiMessageDefault = UI_MESSAGE_DEFAULT, uiMessageOverride = null, ok = false, falsePositive = false, confirmed = true, expectEmpty = false , trimmed = '' }) {
  console.group(ERROR_REPORT_PREAMBLE)

  if( ok ) {
    console.info(OK_ERROR_PREAMBLE)
  }

  const uiMessage = handleAllWpErrorOutput({ error, uiMessageDefault, uiMessageOverride })

  console.groupEnd()

  return uiMessageOverride || uiMessage || uiMessageDefault
}
