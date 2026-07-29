import { test as teardown } from '@wordpress/e2e-test-utils-playwright'
import { execFileSync } from 'child_process'
import '../support/env.js'
import {
  LANG_PLUGINS_DIR,
  translationFileName,
  wpContainer,
  dbConnection
} from '../support/i18nHelpers.js'

// Reverts everything setup/i18n.js established, so the WordPress instance is left
// with its default (English) locale and no fixture translation file. Wired as
// the teardown of the `setup-i18n` project, so it runs after the i18n specs
// finish. Each step is best-effort — teardown must not fail the run.
teardown('tear down admin i18n fixture', async () => {
  try {
    const connection = await dbConnection()
    await connection.execute(
      'UPDATE `wp_options` SET `option_value` = "" WHERE `option_name` = "WPLANG"'
    )
    await connection.end()
  } catch (e) {
    console.warn(`i18n teardown: reverting WPLANG failed: ${e.message}`)
  }

  try {
    const container = wpContainer()
    execFileSync('docker', [
      'exec',
      '-u',
      'root',
      container,
      'rm',
      '-f',
      `${LANG_PLUGINS_DIR}/${translationFileName()}`
    ])
  } catch (e) {
    console.warn(`i18n teardown: removing translation file failed: ${e.message}`)
  }
})
