import get from 'lodash/get'
import set from 'lodash/set'

const DEFAULT_INTERCEPTOR = thing => thing
const DEFAULT_PUT = ( url, _data, _config ) => handleRequest( { url, method: 'PUT' } )
let responses = {}
let responseSuccessInterceptor = DEFAULT_INTERCEPTOR
let responseFailureInterceptor = DEFAULT_INTERCEPTOR

const axios = {
  interceptors: {
    response: {
      use: (success, failure) => {
        responseSuccessInterceptor = success
        responseFailureInterceptor = failure
      }
    }
  },
  put: DEFAULT_PUT
}

export function respondWith ({ url, method = "GET", response }) {
  responses = set(responses, [url, method.toUpperCase()], response)
}

export function resetAxiosMocks () {
  responses = {}
  axios.put = DEFAULT_PUT
}

export function changeImpl({ name, fn }) {
  axios[name] = fn
}

function handleRequest(req) {
  const { url, method = 'GET' } = req

  const response = get(responses, [url, method.toUpperCase()])

  if ( !response ) {
    console.log('No prepared response for:', req) // eslint-disable-line no-console

    return Promise.reject()
  }

  if ( response instanceof XMLHttpRequest ) {
    return Promise.reject( responseFailureInterceptor( { request: response } ) )
  }

  const status = get( response, 'status' )

  // TODO: use axios validateStatus to determine resolve or reject, instead
  // of hardcoding the default
  if ( response && status && status < 300 ) {
    return Promise.resolve( responseSuccessInterceptor( response ) )
  } else {
    return Promise.reject( responseFailureInterceptor( { response } ) )
  }
}

export default axios
