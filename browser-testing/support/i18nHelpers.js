import crypto from 'crypto'
import mysql from 'mysql2/promise'

// The locale we force the admin UI into for the translation tests.
export const LOCALE = 'de_DE'

export const TEXT_DOMAIN = 'font-awesome'

// The script handle the plugin registers for its admin bundle
// (FontAwesome::ADMIN_RESOURCE_HANDLE = 'font-awesome-official' . '-admin').
export const ADMIN_HANDLE = 'font-awesome-official-admin'

// Path of the admin bundle relative to the plugin root. The plugin registers it
// from get_webpack_asset_url_base() . 'index.js' (= admin/build/index.js), and
// WordPress hashes exactly this string to name the script's JSON translation
// file: `<text-domain>-<locale>-<md5(relative-path)>.json`. See WordPress core
// load_script_textdomain(). If the build output path changes, update this.
export const RELATIVE_JS_PATH = 'admin/build/index.js'

export const LANG_PLUGINS_DIR = '/var/www/html/wp-content/languages/plugins'

/** The exact filename WordPress looks for when loading the admin bundle's translations. */
export function translationFileName() {
  const hash = crypto.createHash('md5').update(RELATIVE_JS_PATH).digest('hex')
  return `${TEXT_DOMAIN}-${LOCALE}-${hash}.json`
}

/**
 * Name of the running WordPress container to install the translation file into.
 * Defaults to the CI container when CI=true, otherwise the local dev container.
 * Override with WP_CONTAINER.
 */
export function wpContainer() {
  return (
    process.env.WP_CONTAINER ||
    (process.env.CI === 'true' ? 'wordpress-ci' : 'com.fontawesome.wordpress-latest-dev')
  )
}

/** Open a connection to the WordPress DB using the same env the rest of the suite uses. */
export function dbConnection() {
  return mysql.createConnection({
    host: 'localhost',
    user: process.env.WORDPRESS_DB_USER,
    password: process.env.WORDPRESS_DB_PASSWORD,
    database: process.env.WORDPRESS_DB_NAME,
    port: process.env.WORDPRESS_DB_PORT
  })
}
