import { expect, test } from '@wordpress/e2e-test-utils-playwright'
import { prepareRestApi } from '../support/testHelpers'

const QUERY = 'query { search(version: "6.x", query: "coffee", first: 1) { id } }'

// A regression test to ensure that the former way of sending query requests
// to the plugin's /api endpoint still works, though it's no longer the recommended
// way to do it.
//
// This test can only be expected to work when mod_security is disabled,
// since making a request to the API endpoint with a default (text/plain)
// MIME type is known to result in a 403 due to the OWASP default core ruleset
// as of OWASP 4.3.0.
test('query as plain text', async ({ storageState, baseURL }) => {
  expect(process.env.ENABLE_MOD_SECURITY).toEqual('false')

  const { requestUtils } = await prepareRestApi({ storageState, baseURL })

  const url = `http://${process.env.WP_DOMAIN}/wp-json/font-awesome/v1/api?_locale=user`

  const response = await requestUtils.request.fetch(url, {
    method: 'POST',
    data: QUERY,
    headers: {
      'X-WP-Nonce': requestUtils.storageState.nonce
    }
  })

  expect(response.status()).toEqual(200)

  const responseObj = await response.json()

  expect(responseObj).toHaveProperty('data.search')
})
