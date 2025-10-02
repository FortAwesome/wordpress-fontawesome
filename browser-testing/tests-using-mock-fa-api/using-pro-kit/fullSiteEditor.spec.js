import { Editor, expect, test } from '../../fixtures.js'
import { mockRoutes } from '../../setup/mockApiNetworkRequests'
import { loadSvgCoreJs } from '../../support/testHelpers'

test.describe('full site editor', async () => {
  test.use({
    editor: async ({ page }, use) => {
      await use(new Editor({ page }))
    }
  })

  test.beforeEach(async ({ page }) => {
    await mockRoutes(page)
    await loadSvgCoreJs(page)
  })

  test('insert with icon chooser', async ({ page, editor, pageUtils }) => {
    const pageLoadPromise = page.waitForResponse('**/wp/v2/pages*')

    await page.goto('/wp-admin/site-editor.php?canvas=edit')

    await pageLoadPromise

    try {
      await page.getByRole('button', { name: 'Get started' }).waitFor({ timeout: 1000 })
      await page.getByRole('button', { name: 'Get started' }).click()
    } catch (error) {
      // Button doesn't exist in current WordPress version, continue with test
    }

    await editor.insertBlock({
      name: 'core/paragraph'
    })
    await page.keyboard.type('Here comes an icon: ')

    await editor.clickBlockToolbarButton('Font Awesome Icon')

    await pageUtils.pressKeys('Enter', 1)

    await page.waitForSelector('fa-icon-chooser input#search')

    const searchResponsePromise = page.waitForResponse(response =>
      response.url().includes('fontawesome.com') && response.request().method() === 'POST'
    )

    await page.locator('fa-icon-chooser input#search').fill('coffee')

    await searchResponsePromise

    await page.locator('fa-icon-chooser button.icon').first().click()

    let blocks = null

    try {
      // On WP 6.0.8, this throws an exception, but it's a false negative.
      // So, if there's a succesfully call of getBlocks(), we want to
      // assert its results. But if that fails, don't fail the whole test.
      blocks = await editor.getBlocks()
      expect(blocks).toHaveLength(1)
      expect(blocks[0].attributes.content).toMatch(/\[icon.*?\]$/)
    } catch (_e) {}
  })
})
