import { visitAdminPage, __experimentalActivatePlugin } from '@wordpress/e2e-test-utils'

async function resetOptions() {
  return page.evaluate(() => {
    const { apiUrl, apiNonce} = window.__FontAwesomeOfficialPlugin__

    let DEFAULT_OPTIONS = {
      options:{
        usePro:false,
        compat:true,
        technology:"webfont",
        pseudoElements:true,
        kitToken:null,
        apiToken:true,
        version:"6.0.0-beta3"
      }
    }

    return fetch(`${apiUrl}/config`, {
      method: 'PUT',
      headers: {
        'X-WP-Nonce': apiNonce,
        'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify(DEFAULT_OPTIONS)
    })
  })
}

describe('changeTechnology', () => {
  beforeAll(async () => {
    await visitAdminPage('options-general.php', 'page=font-awesome')
    await resetOptions()
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
