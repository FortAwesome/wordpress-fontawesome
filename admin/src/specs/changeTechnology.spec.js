import { visitAdminPage, __experimentalActivatePlugin } from '@wordpress/e2e-test-utils'
import { resetOptions } from '../testUtil'

describe('changeTechnology', () => {
  beforeAll(async () => {
    await visitAdminPage('options-general.php', 'page=font-awesome')
    await resetOptions(page)
    await page.reload()
  })

  test('works', async () => {
    const useCdnInput = await page.$('#select_use_cdn')
    const useKitInput = await page.$('#select_use_kits')

    expect(await useCdnInput.evaluate( i => i.checked )).toBe(true)
    expect(await useKitInput.evaluate( i => i.checked )).toBe(false)

    const techSvgInput = await page.$('#code_edit_tech_svg')
    expect(await techSvgInput.evaluate( i => i.checked )).toBe(false)
    await techSvgInput.click()

    const submitBefore = await page.waitForSelector('#submit:enabled')
    await submitBefore.click()

    await page.waitForSelector('#submit:disabled')
    expect(await techSvgInput.evaluate( i => i.checked )).toBe(true)
  })
})
