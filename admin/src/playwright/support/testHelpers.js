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
