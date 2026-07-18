import mockSearchResult from '../support/mockSearchResult.json';
import mockKitMetadataResponse from '../support/mockKitMetadataResponse.json';
import mockKitRevisionResponse from '../support/mockKitRevisionResponse.json';
import mockSearchKitResponse from '../support/mockSearchKitResponse.json';
import mockShowcaseIconsResponse from '../support/mockShowcaseIconsResponse.json';
import faSquareFull from '../support/square-full.json';

export async function mockRoutes(page) {
  // Mock the FontAwesome GraphQL API endpoints
  await page.route(/https:\/\/api.*\.fontawesome\.com\/.*/, async route => {
    const method = route.request().method()
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

    // Dispatch on the GraphQL operation name. handleQuery collapses the query's
    // whitespace to single spaces before POSTing, so these `query <Name>` prefixes
    // appear verbatim in the request body.
    //
    // Kit mode (fa-icon-chooser >= 0.11.0) no longer uses the legacy top-level
    // `search` query. It runs a KitRevision identity probe, loads kit metadata,
    // searches the kit subset via `searchKit`, and fills its opening view via
    // `showcaseIcons`. Non-kit / CDN mode still uses the legacy `Search` query,
    // which falls through to the default branch below.
    let responseBody
    if (postData.includes('query KitRevision')) {
      responseBody = mockKitRevisionResponse
    } else if (postData.includes('query KitMetadata')) {
      responseBody = mockKitMetadataResponse
    } else if (postData.includes('query SearchKit')) {
      responseBody = mockSearchKitResponse
    } else if (postData.includes('query ShowcaseIcons')) {
      responseBody = mockShowcaseIconsResponse
    } else {
      // Legacy top-level `search` query (non-kit / CDN mode).
      responseBody = mockSearchResult
    }

    await route.fulfill({
      status: 200,
      contentType: 'application/json',
      body: JSON.stringify(responseBody)
    })
  })

  // Mock CDN requests
  await page.route(/https:\/\/ka-[pf]\.fontawesome\.com\/.*/, async route => {
    const url = new URL(route.request().url());

    if (url.pathname.endsWith('.svg')) {
      await route.fulfill({
        status: 200,
        contentType: 'image/svg+xml',
        // It's just a solid square icon that fills the whole viewBox.
        body: '<svg viewBox="0 0 512 512"><path d="M0 0h512v512H0z"/></svg>'
      })
    } else if (url.pathname.endsWith('.json')) {
      await route.fulfill({
        status: 200,
        contentType: 'application/json',
        body: JSON.stringify(faSquareFull)
      })
    } else {
      console.error(`UNKNOWN ROUTE: ${url}`)
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
  await page.route(/.*\/api\/token|rest_route=.*token/, async route => {
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

  await page.route(/pro\.min\.js/, async route => {
    await route.fulfill({
      status: 200,
      contentType: 'application/javascript',
      body: 'console.log("adding fake FA SVG Core scrript")'
    })
  })
}
