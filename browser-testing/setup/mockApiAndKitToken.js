import { test as setup } from '@wordpress/e2e-test-utils-playwright'
import mysql from 'mysql2/promise'
import { unserialize, serialize } from 'php-serialize'

// The idea here is that we need to mock the _presence_ of an API token
// and a Pro kitToken in the WordPress database, so that any back end code
// that checks for those values will find them, but we won't use real
// values because when these mock db values are used, we'll also be mocking
// any network requests that would make use of those values.
setup('mock API token and Pro kit token', async () => {
  const connection = await mysql.createConnection({
    host: 'localhost',
    user: process.env.WORDPRESS_DB_USER,
    password: process.env.WORDPRESS_DB_PASSWORD,
    database: process.env.WORDPRESS_DB_NAME,
    port: process.env.WORDPRESS_DB_PORT
  })

  const selectSql = 'SELECT option_id, option_value FROM `wp_options` WHERE `option_name` = ? LIMIT 1'
  const [rows] = await connection.execute(selectSql, ['font-awesome'])
  const { option_id, option_value } = rows[0]
  if (!option_id || !option_value) {
    throw new Error('Could not find font-awesome option in database')
  }

  const option = unserialize(option_value)
  option.usePro = true
  option.kitToken = 'abc123'
  option.apiToken = true

  const serializedOption = serialize(option)

  const updateSql = 'UPDATE `wp_options` SET `option_value` = ? WHERE `option_id` = ? LIMIT 1'
  const [status] = await connection.execute(updateSql, [serializedOption, option_id])

  if (1 !== status.affectedRows) {
    throw new Error("Could not update font-awesome option in database")
  }
})
