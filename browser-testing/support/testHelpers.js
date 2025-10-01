import { request } from '@playwright/test'
import { RequestUtils } from '@wordpress/e2e-test-utils-playwright'

export async function prepareRestApi({ baseURL, storageState }) {
  const requestContext = await request.newContext({
    baseURL
  })

  const storageStatePath = typeof storageState === 'string' ? storageState : undefined

  const requestUtils = new RequestUtils(requestContext, {
    storageStatePath
  })

  await requestUtils.setupRest()

  return { requestUtils, requestContext }
}

// This can be loaded as part of mocking for the Icon Chooser. So it will
// not need to fetch pro.min.js, since loading this asset will define the
// global FontAwesome object in the DOM.
export async function loadSvgCoreJs(page) {
  await page.addInitScript({ path: 'support/fontawesome.free.7.0.1.min.js' });
}
