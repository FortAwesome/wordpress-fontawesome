//import apiFetch from '@wordpress/api-fetch'

export const ICON_CHOOSER_CONTAINER_ID = 'font-awesome-icon-chooser-container'

export const ICON_CHOOSER_MEDIA_BUTTON_ID = 'font-awesome-icon-chooser-media-button'

export async function handleQuery(query) {
  try {
    // TODO: send this query through our API controller so it can be authorized
    // for account-specific queries.

    const headers = {
      'Content-Type': 'application/json'
    }

    const response = await fetch( 'https://api.fontawesome.com', {
      method: 'POST',
      headers,
      body: JSON.stringify({ query })
    })

    if(response.ok) {
      return await response.json()
    } else {
      console.error('FAILED query response:', response)
      // TODO: determine a real error message
      throw new Error('failed Font Awesome API query')
    }
  /*
    const response = await apiFetch( {
      path: '/font-awesome/v1/api',
      method: 'POST',
      body: query
    } )

    console.log('DEBUG response:', response)
    */

    return response

    /*
    if(response.ok) {
      response.json()
      .then(json => resolve(json))
      .catch(e => reject(e))
    } else {
      reject('bad query')
    }
    */
  } catch( error ) {
    console.error('CAUGHT:', error)
    throw new Error(error)
  }
}
