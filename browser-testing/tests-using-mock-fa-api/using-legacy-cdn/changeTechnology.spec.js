import { test } from '../../fixtures.js'

test('change technology', async ({ page }) => {
  await page.goto('/wp-admin/admin.php?page=font-awesome')

  const preferenceCheckResponsePromise = page.waitForResponse('**/font-awesome/v1/preference-check')

  await page.getByText('SVG').click()

  await preferenceCheckResponsePromise

  const saveChangesResponsePromise = page.waitForResponse('**/font-awesome/v1/config')
  await page.getByRole('button', { name: 'Save Changes' }).click()
  await saveChangesResponsePromise
})
