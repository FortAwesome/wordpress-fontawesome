import apiFetch from '@wordpress/api-fetch'
import md5 from 'blueimp-md5'

const configureQueryHandler = params => async (query, variables, options) => {
  try {
    const { apiNonce, rootUrl, restApiNamespace } = params

    // If apiFetch is from wp.apiFetch, it may already have RootURLMiddleware set up.
    // If we're using the fallback (i.e. when running in the Classic Editor), then
    // it doesn't yet have thr RootURLMiddleware.
    // We want to guarantee that it's there, so we'll always add it.
    // So what if it was already there? Experiment seems to have shown that this
    // is idempotent. It doesn't seem to hurt to just do it again, so we will.
    apiFetch.use( apiFetch.createRootURLMiddleware( rootUrl ) )

    // We need the nonce to be set up because we're going to run our query through
    // the API controller end point, which requires non-public authorization.
    apiFetch.use( apiFetch.createNonceMiddleware( apiNonce ) )

    const cacheKey = md5(`${query}${JSON.stringify(variables)}`)

    const data = sessionStorage.getItem(cacheKey)

    if(data) {
      return JSON.parse(data)
    }

    const response = await apiFetch( {
      path: `${restApiNamespace}/api`,
      method: 'POST',
      headers: {
        'content-type': 'application/json'
      },
      body: JSON.stringify({ query: query.replace(/\s+/g, " "), variables })
    } )

    if(options?.cache) {
      sessionStorage.setItem(cacheKey, JSON.stringify(response))
    }

    return response
  } catch( error ) {
    console.error('CAUGHT:', error)
    throw new Error(error)
  }
}

export default configureQueryHandler
