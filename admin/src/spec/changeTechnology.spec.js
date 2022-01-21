import { activatePlugin, visitAdminPage, __experimentalActivatePlugin } from '@wordpress/e2e-test-utils'

describe('changeTechnology', () => {
  beforeAll(async () => {
    await activatePlugin('font-awesome')
    await visitAdminPage('options-general.php', 'page=font-awesome')
  })

  test('works', async () => {

    await page.screenshot({ path: 'admin-page-initial.png' });

    const useCdnInput = await page.$('#select_use_cdn')
    const useKitInput = await page.$('#select_use_kits')

    expect(await useCdnInput.evaluate( i => i.value )).toEqual("true")
    expect(await useKitInput.evaluate( i => i.value )).toEqual("false")
  })
})
