import * as playwright from '@wordpress/e2e-test-utils-playwright'

export const test = base.extend({
  page: async ({ page }, use) => {
    page.on('console', msg => {
      if (process.env.SHOW_CONSOLE === 'true') {
        console.log(msg.text());
      }
    });
    await use(page);
  }
});

export const expect = playwright.expect;
export const Editor = playwright.Editor
