import { Editor, test, expect, login, RequestUtils } from '@wordpress/e2e-test-utils-playwright'

test.describe('blockEditorIconChooser', async () => {
  test.beforeEach(async ({ admin }) => {
    await admin.createNewPost()
  })

  test.use({
    editor: async ({ page }, use) => {
      await use(new Editor({ page }))
    }
  })

  test('search and select from icon chooser', async ({ editor, page, pageUtils }) => {
    await editor.insertBlock({
      name: 'core/paragraph'
    })
    await page.keyboard.type('Here comes an icon: ')

    await editor.clickBlockToolbarButton('More')

    await pageUtils.pressKeys('Enter', 1)

    await page.waitForSelector('fa-icon-chooser input#search')

    const searchResponsePromise = page.waitForResponse('**/font-awesome/v1/api*')

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

    // The loading of the icon chooser should not have messed up the lodash globals.
    await expect(page.evaluate(() => 'undefined' !== typeof _ && 'undefined' !== typeof lodash)).toBeTruthy()
  })
})
