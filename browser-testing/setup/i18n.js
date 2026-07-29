import { test as setup } from '@wordpress/e2e-test-utils-playwright'
import { execFileSync } from 'child_process'
import path from 'path'
import '../support/env.js'
import {
  LOCALE,
  LANG_PLUGINS_DIR,
  translationFileName,
  wpContainer,
  dbConnection
} from '../support/i18nHelpers.js'

// Establishes the preconditions for the admin JS-translation tests:
//   1. force the site locale to de_DE, and
//   2. install a fixture JS translation file for the admin bundle.
//
// Both are reverted by setup/i18nCleanup.js (wired as this project's teardown),
// so the rest of the suite — whose specs match UI text in English — is
// unaffected. This is a plain admin-page test and does not touch the Font
// Awesome API.
setup('set up admin i18n fixture', async () => {
  // 1. Force the locale via a direct DB write. Going through the WPLANG option's
  //    sanitize (as wp-cli / the Settings screen would) rejects a locale whose
  //    language pack isn't installed; writing the row directly avoids needing a
  //    language-pack download, keeping this hermetic.
  const connection = await dbConnection()
  await connection.execute(
    'INSERT INTO `wp_options` (`option_name`, `option_value`, `autoload`) VALUES (?, ?, "yes") ' +
      'ON DUPLICATE KEY UPDATE `option_value` = VALUES(`option_value`)',
    ['WPLANG', LOCALE]
  )
  await connection.end()

  // 2. Install the JS translation file under the exact name WordPress derives
  //    from the admin bundle's path (see support/i18nHelpers.js). WordPress only
  //    prints the setLocaleData bridge when such a file exists for the locale,
  //    so this file is what makes the fix observable in the browser.
  const container = wpContainer()
  const fixture = path.resolve(__dirname, `../support/admin-translations.${LOCALE}.json`)
  execFileSync('docker', ['exec', '-u', 'root', container, 'mkdir', '-p', LANG_PLUGINS_DIR])
  execFileSync('docker', [
    'cp',
    fixture,
    `${container}:${LANG_PLUGINS_DIR}/${translationFileName()}`
  ])
})
