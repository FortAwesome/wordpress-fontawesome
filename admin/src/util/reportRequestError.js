import get from 'lodash/get'

const ERROR_MESSAGE_PREFIX = 'Font Awesome WordPress Plugin Error Report'

export default function(error) {
  console.group(ERROR_MESSAGE_PREFIX)
  const response = get(error, 'response')

  if(response) {
    const data = get(response, 'data')

    if(data) {
      let output = ''

      const code = get(data, 'code')
      if(code) output = output.concat(`code: ${code}\n`)

      const message = get(data, 'message')
      if(message) output = output.concat(`message: ${message}\n`)

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
}
