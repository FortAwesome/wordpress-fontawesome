import get from 'lodash/get'

const ERROR_MESSAGE_PREFIX = 'Font Awesome WordPress Plugin Error Report'
const UI_MESSAGE_DEFAULT = "D'oh! That failed big time."

export default function({ error, uiMessageDefault = UI_MESSAGE_DEFAULT, uiMessageOverride = null }) {
  let uiMessage = null
  console.group(ERROR_MESSAGE_PREFIX)
  const response = get(error, 'response')

  if(response) {
    const data = get(response, 'data')

    if(data) {
      let output = ''

      const message = get(data, 'message')
      if(message) {
        output = output.concat(`message: ${message}\n`)
        uiMessage = message
      }

      const code = get(data, 'code')
      if(code) {
        output = output.concat(`code: ${code}\n`)

        switch(code) {
          case 'rest_no_route':
            uiMessage = 'Oh no! Your web browser could not reach your WordPress server. '
            break
          case 'rest_cookie_invalid_nonce':
            uiMessage = 'It looks like your web browser session expired. Trying logging out and log back in to WordPress admin.'
            break
          case 'fa_unknown_error':
            uiMessage = UI_MESSAGE_DEFAULT
            break
          default:
        }
      }

      const status = get(data, 'data.status')
      if(status) output = output.concat(`status: ${status}\n`)

      const trace = get(data, 'data.trace')
      if(trace) output = output.concat(`trace:\n${trace}\n`)

      if('' === output) {
        console.info(data)
      } else {
        console.info(output)
      }
    } else {
      console.info(response)
    }
  } else {
    console.info(error)
  }
  console.groupEnd()

  return uiMessageOverride || uiMessage || uiMessageDefault
}
