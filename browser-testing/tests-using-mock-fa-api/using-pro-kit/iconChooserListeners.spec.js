import { Editor, expect, test } from '../../fixtures.js'
import { mockRoutes } from '../../setup/mockApiNetworkRequests'
import { loadSvgCoreJs } from '../../support/testHelpers'

/**
 * Regression test for the icon chooser's open-event listener registration.
 *
 * IconChooserModal opens in response to a custom event dispatched on `document`.
 * It used to register that listener during render, with no removal, and edit.js
 * used to mint a brand new random event *type* on every render. Together that
 * meant `document` permanently accumulated one listener -- and one entry in its
 * listener map -- for every render any icon block ever performed. Nothing
 * misbehaved, which is why the rest of the suite stayed green, but the growth
 * was unbounded: driving the icon styling modal added a listener per interaction.
 *
 * This test drives a fixed number of re-renders and asserts the registration
 * count stays bounded rather than tracking the render count.
 */

// How many times to poke a control that calls setAttributes, i.e. how many
// extra `Edit` renders to force.
const RERENDER_COUNT = 9

test.describe('icon chooser open-event listeners', async () => {
  test.use({
    editor: async ({ page }, use) => {
      await use(new Editor({ page }))
    }
  })

  test.beforeEach(async ({ page }) => {
    await mockRoutes(page)
    await loadSvgCoreJs(page)

    // Patch the prototype, not `document`: this init script runs before the
    // plugin bundles evaluate, and patching the prototype keeps the counter in
    // place no matter which document object the editor ends up using.
    //
    // The counter only ever goes up. It cannot observe removeEventListener, so
    // it measures registrations, not currently-live listeners. That is enough:
    // the question is whether registrations scale with render count.
    await page.addInitScript(() => {
      window.__faListenerCounts = {}
      const originalAddEventListener = Document.prototype.addEventListener
      Document.prototype.addEventListener = function (type, ...rest) {
        if (String(type).startsWith('fontAwesomeIconChooser-')) {
          window.__faListenerCounts[type] = (window.__faListenerCounts[type] || 0) + 1
        }
        return originalAddEventListener.call(this, type, ...rest)
      }
    })
  })

  test('registrations stay bounded across many block re-renders', async ({ admin, editor, page }) => {
    await admin.createNewPost()

    await editor.insertBlock({ name: 'font-awesome/icon' })

    // The empty block renders a Placeholder inside the editor canvas iframe. Its
    // button handler runs in the outer realm, so it dispatches on the outer
    // `document`, which is where IconChooserModal is listening.
    await editor.canvas.getByRole('button', { name: 'Choose Icon' }).click()

    await page.waitForSelector('fa-icon-chooser input#search')

    const searchResponsePromise = page.waitForResponse(response =>
      response.url().includes('fontawesome.com') && response.request().method() === 'POST'
    )

    await page.locator('fa-icon-chooser input#search').fill('coffee')

    await searchResponsePromise

    await page.locator('fa-icon-chooser button.icon').first().click()

    // With an icon in place, the block toolbar offers the styling modal, whose
    // controls call setAttributes and therefore re-render `Edit`.
    await page.getByRole('button', { name: 'Add Icon Styling' }).click()

    const rotateButtons = ['90°', '180°', '270°']

    for (let i = 0; i < RERENDER_COUNT; i++) {
      await page.getByRole('button', { name: rotateButtons[i % rotateButtons.length], exact: true }).click()
    }

    const counts = await page.evaluate(() => window.__faListenerCounts)

    const distinctEventTypes = Object.keys(counts).length
    const totalRegistrations = Object.values(counts).reduce((sum, n) => sum + n, 0)

    console.log(
      `open-event registrations after ${RERENDER_COUNT} re-renders: ` +
      `${distinctEventTypes} distinct event types, ${totalRegistrations} total registrations`
    )

    // Before the fix both of these grew with RERENDER_COUNT. A block instance
    // should now own exactly one event type, and the thresholds are loose enough
    // to absorb incidental renders without absorbing per-render growth.
    //
    // Soft so that a failure reports both numbers rather than stopping at the first.
    expect.soft(distinctEventTypes).toBeLessThan(5)
    expect.soft(totalRegistrations).toBeLessThan(RERENDER_COUNT)
  })
})
