import { test as setup } from '@wordpress/e2e-test-utils-playwright'
import '../support/env.js'
import { authFile } from '../support/testHelpers.js'

setup('WordPress admin login', async ({ page }) => {
  await page.goto('/wp-login.php')
  await page.getByLabel('Username or Email Address').fill(process.env.WP_ADMIN_USERNAME)
  await page.getByLabel('Password', { exact: true }).fill(process.env.WP_ADMIN_PASSWORD)
  await page.getByRole('button', { name: 'Log In' }).click()
  await page.waitForURL('**/wp-admin/')
  await page.context().storageState({ path: authFile })
})
