import { insertBlock, createNewPost, enablePageDialogAccept, pressKeyTimes, clickBlockToolbarButton, getAllBlocks, loginUser } from '@wordpress/e2e-test-utils'

jest.setTimeout(15000)

let config = null

describe('blockEditorIconChooser', () => {
  beforeAll(async () => {
    enablePageDialogAccept()
    await loginUser(process.env.WP_USERNAME, process.env.WP_PASSWORD)
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
