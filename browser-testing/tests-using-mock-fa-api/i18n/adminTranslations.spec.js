import { test, expect } from '../../fixtures.js'
import { ADMIN_HANDLE } from '../../support/i18nHelpers.js'

// Regression coverage for PR #304.
//
// The bug: FontAwesome::maybe_enqueue_admin_assets() called
// wp_set_script_translations() for the admin bundle BEFORE the script was
// registered/enqueued, so WordPress never attached the textdomain, never printed
// the setLocaleData bridge, and the React admin UI never received its
// translations. The fix moved the call to run right after
// enqueue_admin_js_assets().
//
// setup/i18n.js forces the locale to de_DE and installs a fixture translation
// file, so with the fix in place these assertions pass; if the bug regresses the
// bridge disappears and the strings stay in English, failing the test.
test.describe('admin JS translations (PR #304)', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/wp-admin/admin.php?page=font-awesome')
  })

  test('prints the script-translations bridge for the admin bundle', async ({ page }) => {
    // The admin bundle must be on the page, otherwise the rest is meaningless.
    await expect(page.locator(`#${ADMIN_HANDLE}-js`)).toHaveCount(1)

    // The heart of the fix: WordPress only prints this inline setLocaleData
    // script when wp_set_script_translations() ran AFTER registration. It's a
    // <script> element (no rendered text), so read its textContent directly.
    const bridge = page.locator(`#${ADMIN_HANDLE}-js-translations`)
    await expect(bridge).toHaveCount(1)
    const bridgeSource = await bridge.evaluate((el) => el.textContent)
    expect(bridgeSource).toContain('wp.i18n.setLocaleData')
    expect(bridgeSource).toContain('font-awesome')
  })

  test('renders translated strings in the admin UI', async ({ page }) => {
    await expect(
      page.getByRole('heading', { name: 'TEST-DE — Wie verwendest du Font Awesome?' })
    ).toBeVisible()
    await expect(page.getByText('TEST-DE — Kit verwenden')).toBeVisible()
    await expect(page.getByText('TEST-DE — CDN verwenden')).toBeVisible()
  })

  test('resolves the plugin textdomain through the wp.i18n runtime', async ({ page }) => {
    const translated = await page.evaluate(() =>
      window.wp.i18n.__('How are you using Font Awesome?', 'font-awesome')
    )
    expect(translated).toBe('TEST-DE — Wie verwendest du Font Awesome?')
  })
})
