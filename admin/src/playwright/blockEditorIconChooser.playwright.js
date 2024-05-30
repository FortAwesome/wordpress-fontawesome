import { Editor, test, expect, login, RequestUtils } from '@wordpress/e2e-test-utils-playwright'

test.describe( 'blockEditorIconChooser', async () => {
	test.beforeEach( async ( { admin } ) => {
		await admin.createNewPost()
	} )

  test.use( {
	  editor: async ( { page }, use ) => {
		  await use( new Editor( { page } ) )
	  },
  } )

  test('search and select from icon chooser', async ({ editor, page, pageUtils }) => {
		await editor.insertBlock( {
			name: 'core/paragraph',
		} );
		await page.keyboard.type( 'Here comes an icon: ' )

		await editor.clickBlockToolbarButton( 'More' )

		await pageUtils.pressKeys('Enter', 1)

		await page.waitForSelector( 'fa-icon-chooser input#search' );

    const searchResponsePromise = page.waitForResponse(
      '**/font-awesome/v1/api*'
    );

    await page.locator( 'fa-icon-chooser input#search' ).fill('coffee')

    await searchResponsePromise

    await page.locator( 'fa-icon-chooser button.icon' ).first().click()

    const blocks = await editor.getBlocks()
    expect(blocks).toHaveLength(1)
    expect(blocks[0].attributes.content).toMatch(/\[icon.*?\]$/)
  })
} )
