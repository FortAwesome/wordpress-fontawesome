import { test as setup, expect } from '@wordpress/e2e-test-utils-playwright'
import '../support/env.js'

const CONFIG_ROUTE_PATTERN = '**/font-awesome/v1/config'
const API_ROUTE_PATTERN = '**/font-awesome/v1/api*'

setup('real pro kit', async ({ page }) => {
  expect(process.env.API_TOKEN).toBeTruthy()
  expect(process.env.KIT_TOKEN).toBeTruthy()

  await page.goto('/wp-admin/admin.php?page=font-awesome')
  await page.locator('label').filter({ hasText: 'Use A Kit' }).click()

  await page.locator('label').filter({ hasText: 'API Token' }).fill(process.env.API_TOKEN)
  const saveAPITokenResponsePromise = page.waitForResponse(CONFIG_ROUTE_PATTERN)
  await page.getByRole('button', { name: 'Save API Token' }).click()
  await saveAPITokenResponsePromise

  const kitsResponsePromise = page.waitForResponse(API_ROUTE_PATTERN)

  await page.getByRole('button').filter({ hasText: 'kits data' }).click()
  await kitsResponsePromise

  await page.locator('select').selectOption(process.env.KIT_TOKEN)

  const saveSettingsResponsePromise = page.waitForResponse(CONFIG_ROUTE_PATTERN)

  await page.getByRole('button').filter({ hasText: 'Save Changes' }).click()
  await saveSettingsResponsePromise
})
