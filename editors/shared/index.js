import apiFetch from '@wordpress/api-fetch'

export const ICON_CHOOSER_CONTAINER_ID = 'font-awesome-icon-chooser-container'

export const ICON_CHOOSER_MEDIA_BUTTON_ID = 'font-awesome-icon-chooser-media-button'

export async function handleQuery(query) {
  try {
    if(!window['__FontAwesomeOfficialPlugin_EditorSupportConfig__']) {
      // TODO: figure out what to do with this error message for real.
      throw new Error('Font Awesome: missing require configuration')
    }

    const { apiNonce, apiUrl } = window['__FontAwesomeOfficialPlugin_EditorSupportConfig__']

    apiFetch.use( apiFetch.createNonceMiddleware( apiNonce ) )

    return await apiFetch( {
      path: `${apiUrl}/api`,
      method: 'POST',
      body: query
    } )
  } catch( error ) {
    console.error('CAUGHT:', error)
    throw new Error(error)
  }
}
