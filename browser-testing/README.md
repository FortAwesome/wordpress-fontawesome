# Browser Testing

Browser testing for the `font-awesome` WordPress plugin is done using [Playwright](https://playwright.dev/).

# Strategy

We need some browser tests that run not only end-to-end with respect to the WordPress environment, but also with respect to the Font Awesome API.

But we probably don't need _many_ tests like that. Those tests require Real Font Awesome API (see below). We'll running them only in local development, not in CI.

Then we need a larger number of tests that run end-to-end with respect to the WordPress environment, but that mock the Font Awesome API. Those tests can run in CI.

There are two broad axes for the test matrix:

1. Pro Kit vs. Non-kit (using only the legacy CDN)

2. Real Font Awesome API usage vs. Mocked Font Awesome API

| Test Scenario | Kit | Non-kit (Legacy CDN) |
|---------------|-----|---------------------|
| **Real Font Awesome API** | local-only | local-only |
| **Mocked Font Awesome API** | CI | CI |

Each cell in the matrix must be run independently because the tests in each cell all have common expectations about the state of the WordPress server, but those expectations differ between cells.

So the Real and Mocked ones can't be part of the same `npx playwright test` run.

And the Kit and Non-kit ones can't be part of the same `npx playwright test` run.

# Initializing the Playwright Project

```bash
npm install
npx playwright install-deps
npx playwright install
```

# Running Real Font Awesome API Tests Locally

Real Font Awesome API tests are intended only for running in local development.
They require real `API_TOKEN` and `KIT_TOKEN` environment variables to be set
in your `.env.local` file.

After setting up the local dev WordPress environment, and configuring your `env.local` with the aforementioned tokens, run the non-kit tests like this:

```bash
npm run test:local:browser-non-kit
```

and the Pro Kit tests like this:

```bash
npm run test:local:browser-pro-kit
```

# Running Mocked Font Awesome API Tests like in CI

You can simulate how the tests are run in CI by looking at the `browser-tests.yml` workflow file and running the same commands locally.

Start up the WordPress environment with the CI-specific docker compose file:

```bash
docker compose -f docker-compose.ci.yml up -d
```

Then run the non-kit tests like this:

```bash
npm run test:ci:browser-non-kit
```
and the Pro Kit tests like this:

```bash
npm run test:ci:browser-pro-kit
```

# Admin i18n Test (PR #304)

`tests-using-mock-fa-api/i18n/adminTranslations.spec.js` is regression coverage
for the admin JavaScript internationalization fix (PR #304): it verifies, in the
browser, that the admin bundle's script translations load and are applied.

Because this bug only manifests in the browser (the PHP hook ordering looked
fine in isolation), it belongs here rather than in the PHPUnit suite.

It runs as its own project (`i18n-chrome`) with a dedicated setup/teardown so it
doesn't disturb the other cells, whose specs match UI text in **English**:

- `setup/i18n.js` forces the locale to `de_DE` (via a direct `wp_options` write,
  so no language pack download is needed) and installs a fixture JS translation
  file (`support/admin-translations.de_DE.json`) into the WordPress container
  under the exact name WordPress derives from the admin bundle's path.
- `setup/i18nCleanup.js` (wired as the `setup-i18n` project's `teardown`) reverts
  the locale and removes the fixture file.

The fixture strings are intentionally prefixed with `TEST-DE —` so the browser
assertions are unambiguous; they are test markers, not real German copy.

Run it the way CI does:

```bash
npm run test:ci:browser-i18n
```

The setup installs the fixture file into the running WordPress container via
`docker`. The container name defaults to `wordpress-ci` when `CI=true` and the
local dev container otherwise; override with `WP_CONTAINER` if needed.

# Console Output

The JavaScript console output from the browser is silenced by default to avoid showing in the terminal.

To enable it, set set the `SHOW_CONSOLE` environment variable to `true` when running the tests, like this:

```bash
SHOW_CONSOLE=true npm run test:ci:browser-non-kit
```
