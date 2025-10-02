import { expect, test } from '../../fixtures.js'
import { mockRoutes } from '../../setup/mockApiNetworkRequests'
import { prepareRestApi } from '../../support/testHelpers'

test.describe('conflictScanner', async () => {
  let requestUtils = null;

  test.beforeEach(async ({ page, baseURL }) => {
    // Use prepareRestApi with page context for proper authentication
    const prep = await prepareRestApi({ baseURL, page })
    requestUtils = prep.requestUtils
    await requestUtils.activatePlugin('plugin-gamma')
    await mockRoutes(page)
  })

  test.afterEach(async () => {
    await requestUtils.deactivatePlugin('plugin-gamma')
  })

  test('start conflict detection scanner, detect, and block', async ({ page }) => {
    await page.goto('/wp-admin/admin.php?page=font-awesome')
    await page.getByRole('button', { name: 'Troubleshoot' }).click()
    const scannerStartResponsePromise = page.waitForResponse('**/font-awesome/v1/conflict-detection/until')
    await page.getByRole('button', { name: 'Enable scanner for 10 minutes' }).click()
    await scannerStartResponsePromise

    await expect(page.getByRole('heading', { name: 'Font Awesome Conflict Scanner' })).toBeVisible()

    await expect(page.locator('span').filter({ hasText: 'minutes left to browse' }).first()).toBeVisible()

    const scannerReportResponsePromise = page.waitForResponse('**/font-awesome/v1/conflict-detection/conflicts')
    await page.goto('/')
    await expect(page.getByRole('heading', { name: 'Plugin Gamma' })).toBeVisible()

    await scannerReportResponsePromise
    await expect(page.getByRole('heading', { name: 'Font Awesome Conflict Scanner' })).toBeVisible()

    await expect(page.getByText('Page scan complete')).toBeVisible()
    await expect(page.getByText('1 new conflicts found on this page')).toBeVisible()
    await expect(page.getByText('1 total found')).toBeVisible()
    await page.getByRole('link', { name: 'manage' }).click()
    await page.getByRole('row', { name: 'link https://cdn.jsdelivr.net' }).locator('svg').nth(1).click()
    const saveChangesResponsePromise = page.waitForResponse('**/font-awesome/v1/conflict-detection/conflicts/blocklist')
    await page.getByRole('button', { name: 'Save Changes' }).click()
    await saveChangesResponsePromise
    await page.goto('/')
    await expect(page.getByText('0 new conflicts found on this page')).toBeVisible()
  })
})
