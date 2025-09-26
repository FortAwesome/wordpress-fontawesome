import mockSearchResult from '../support/mockSearchResult.json';
import mockKitMetadataResponse from '../support/mockKitMetadataResponse.json';

export async function mockRoutes(page) {
  // Mock the FontAwesome GraphQL API endpoints
  await page.route(/https:\/\/api.*\.fontawesome\.com\/.*/, async route => {
    const method = route.request().method()
    console.log(`Handling GQL API request with method: ${method}, url: ${route.request().url()}`)

    if (method === 'OPTIONS') {
      await route.fulfill({
        status: 204,
        // TODO: change the allow-origin to use the origin in the request
        headers: {
          'access-control-allow-headers': 'authorization,content-type',
          'access-control-allow-methods': 'POST',
          'access-control-allow-origin': 'http://wp.test:8765',
          'access-control-allow-credentials': true
        }
      })
      return;
    }

    if (method !== 'POST') {
      const url = route.request().url()
      throw new Error(`Only OPTION and POST requests are supported in this mock, got method: ${method} for url: ${url}`)
    }

    const postData = route.request().postData()

    const isKitMetadataQuery = postData.includes('query KitMetadata')

    console.log(`isKitMetadataQuery: ${isKitMetadataQuery}`)

    if (isKitMetadataQuery) {
      await route.fulfill({
        status: 200,
        contentType: 'application/json',
        body: mockKitMetadataResponse
      })
    } else {
      // Assume it's a search query
      await route.fulfill({
        status: 200,
        contentType: 'application/json',
        body: mockSearchResult
      })
    }
  })

  // Mock CDN requests
  await page.route(/https:\/\/ka-[pf]\.fontawesome\.com\/.*/, async route => {
    if (route.request().url().endsWith('.svg')) {
      await route.fulfill({
        status: 200,
        contentType: 'image/svg+xml',
        // It's just a solid square icon that fills the whole viewBox.
        body: '<svg viewBox="0 0 512 512"><path d="M0 0h512v512H0z"/></svg>'
      })
    } else {
      console.log(`UNKNOWN ROUTE: ${route.request().url()}`)
      await route.continue()
    }
  })

  // Mock the kit loader load:
  // https://kit.fontawesome.com/abc123.js
  await page.route(/https:\/\/kit\.fontawesome\.com/, async route => {
    await route.fulfill({
      status: 200,
      contentType: 'application/javascript',
      body: 'console.log("mock kit loaded")'
    })
  })

  // Mock the plugin's WP REST API route for fetching an access token.
  await page.route(/.*\/api\/token/, async route => {
    const mockData = {
      access_token: 'fake_access_token',
      expires_at: '2099-12-31T23:59:59Z'
    };

    await route.fulfill({
      status: 200,
      contentType: 'application/json',
      body: JSON.stringify(mockData)
    })
  })

  // await page.route(/.*/, async route => {
  //   console.log(`Continuing unhandled request: ${route.request().url()}`)
  //   await route.continue()
  // })
}
