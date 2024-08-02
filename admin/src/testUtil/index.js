export async function resetOptions(page) {
  return page.evaluate(() => {
    const { apiUrl, apiNonce } = window.__FontAwesomeOfficialPlugin__

    let DEFAULT_OPTIONS = {
      options: {
        usePro: false,
        compat: true,
        technology: 'webfont',
        pseudoElements: true,
        kitToken: null,
        apiToken: true,
        version: '6.0.0-beta3'
      }
    }

    return fetch(`${apiUrl}/config`, {
      method: 'PUT',
      headers: {
        'X-WP-Nonce': apiNonce,
        'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify(DEFAULT_OPTIONS)
    })
  })
}
