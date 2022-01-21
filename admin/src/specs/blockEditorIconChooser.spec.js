import { insertBlock, createNewPost, enablePageDialogAccept, pressKeyTimes, clickBlockToolbarButton, getAllBlocks } from '@wordpress/e2e-test-utils'

let config = null

describe('blockEditorIconChooser', () => {
  beforeAll(async () => {
    await enablePageDialogAccept()
  })

  beforeEach(async () => {
    await createNewPost()
    config = await page.evaluate(() => window.__FontAwesomeOfficialPlugin__)
  })

  test('works', async () => {
    await insertBlock( 'Paragraph' )
    await pressKeyTimes('Space', 1)
    await clickBlockToolbarButton('More')
    await pressKeyTimes('Enter', 1)

    const searchInput = await page.waitForFunction(() => {
      const chooser = document.querySelector('fa-icon-chooser')
      const shadowRoot = chooser && chooser.shadowRoot
      return shadowRoot.querySelector('input#search')
    })

    await searchInput.focus()
    await searchInput.type('coffee', { delay: 100 })

    await page.waitForResponse(
      `${config.apiUrl}/api?_locale=user`
    );

    const firstIcon = await page.waitForFunction(() => {
      return document.querySelector('fa-icon-chooser').shadowRoot.querySelector('button.icon')
    })

    await firstIcon.click()

    const blocks = await getAllBlocks()
    expect(blocks).toHaveLength(1)
    expect(blocks[0].attributes.content).toMatch(/\[icon.*?\]$/)
  })
})
