import get from 'lodash/get'
import set from 'lodash/set'

// NOTE: the Jest docs on manual mocks indicate that mocks for things under
// node_modules should be in a __mocks__ directory that is adjacent to node_modules.
// https://jestjs.io/docs/manual-mocks#mocking-node-modules
//
// However, the version of Create React App we're using seems to be changing
// the root for Jest in such a way that __mocks__ as to live under the src directory.
// See: https://github.com/facebook/create-react-app/issues/7539#issuecomment-531463603

const DEFAULT_INTERCEPTOR = (thing) => thing
const DEFAULT_PUT = (url, _data, _config) => handleRequest({ url, method: 'PUT' })
const DEFAULT_POST = (url, _data, _config) => handleRequest({ url, method: 'POST' })
const DEFAULT_DELETE = (url, _data, _config) => handleRequest({ url, method: 'DELETE' })
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
  put: DEFAULT_PUT,
  post: DEFAULT_POST,
  delete: DEFAULT_DELETE
}

axios.create = () => axios

export function respondWith({ url, method = 'GET', response }) {
  responses = set(responses, [url, method.toUpperCase()], response)
}

export function resetAxiosMocks() {
  responses = {}
  axios.put = DEFAULT_PUT
  axios.post = DEFAULT_POST
  axios.delete = DEFAULT_DELETE
}

export function changeImpl({ name, fn }) {
  axios[name] = fn
}

function handleRequest(req) {
  const { url, method = 'GET' } = req

  const response = get(responses, [url, method.toUpperCase()])

  if (!response) {
    console.log('No prepared response for:', req) // eslint-disable-line no-console

    return Promise.reject()
  }

  if (response instanceof XMLHttpRequest) {
    return responseFailureInterceptor({ request: response })
  }

  if (response instanceof Error) {
    return responseFailureInterceptor({ message: response.message })
  }

  const status = get(response, 'status')

  // TODO: use axios validateStatus to determine resolve or reject, instead
  // of hardcoding the default
  if (response && status && status < 300) {
    return Promise.resolve(responseSuccessInterceptor(response))
  } else {
    return responseFailureInterceptor({ response })
  }
}

export default axios
