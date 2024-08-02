import apiFetch from '@wordpress/api-fetch'
import md5 from 'blueimp-md5'
import { __ } from '@wordpress/i18n'

// TODO: GET this from server config data.
const FA_API_URL = 'https:/api.fontawesome.com/'

let accessToken;

const configureQueryHandler = params => async (query, variables, options) => {
  try {
    const { apiNonce, rootUrl, restApiNamespace } = params

    const cacheKey = md5(`${query}${JSON.stringify(variables)}`)

    const data = localStorage.getItem(cacheKey)

    if(data) {
      return JSON.parse(data)
    }

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

    const accessTokenResponse = await apiFetch( {
      path: `${restApiNamespace}/api/token`,
      method: 'GET'
    } )

    accessToken = accessTokenResponse?.access_token

    if ( ! accessToken ) {
      const error = __( 'Font Awesome Icon Chooser could not get an access token from the WordPress server.', 'font-awesome' )
      console.error(error)
      throw new Error(error)
    }

    const response = await fetch(
      FA_API_URL,
      {
        method: 'POST',
        headers: {
          'content-type': 'application/json',
          'authorization': `Bearer ${accessToken}`
        },
        body: JSON.stringify({ query: query.replace(/\s+/g, " "), variables })
      }
    )

    if (!response.ok) {
      const error = __( 'Font Awesome Icon Chooser received an error response from the Font Awesome API server. See developer console.', 'font-awesome' )
      console.error(error)
      throw new Error(error)
    }

    const responseBody = await response.json()
    const hasErrors = Array.isArray(responseBody?.errors) && responseBody.errors.length > 0

    if(options?.cache && !hasErrors) {
      localStorage.setItem(cacheKey, JSON.stringify(responseBody))
    }

    return responseBody
  } catch( error ) {
    console.error('CAUGHT:', error)
    throw new Error(error)
  }
}

export default configureQueryHandler
