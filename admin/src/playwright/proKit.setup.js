import { test as setup, expect } from '@wordpress/e2e-test-utils-playwright'
import './env.js'

const CONFIG_ROUTE_PATTERN = '**/font-awesome/v1/config'
const API_ROUTE_PATTERN = '**/font-awesome/v1/api*'

setup('pro kit', async ({ page }) => {
  await page.goto('/wp-admin/admin.php?page=font-awesome')
  await page.locator('label').filter({ hasText: 'Use A Kit' }).click()

  const allText = await page.getByRole('heading').allTextContents()

  await page.locator('label').filter({ hasText: 'API Token' }).fill(process.env.API_TOKEN)
  const saveAPITokenResponsePromise = page.waitForResponse(CONFIG_ROUTE_PATTERN)
  await page.getByRole('button', { name: 'Save API Token' }).click()
  await saveAPITokenResponsePromise

  const kitsResponsePromise = page.waitForResponse(API_ROUTE_PATTERN)

  await page.getByRole('button').filter({hasText: 'kits data'}).click()
  await kitsResponsePromise

  await page.locator('select').selectOption('1bd4961884')

  const saveSettingsResponsePromise = page.waitForResponse(CONFIG_ROUTE_PATTERN)

  await page.getByRole('button').filter({hasText: 'Save Changes'}).click()
  await saveSettingsResponsePromise
})
