import { test as setup, expect, RequestUtils } from '@wordpress/e2e-test-utils-playwright'
import { request } from '@playwright/test'
import mysql from 'mysql2/promise'

setup('reset', async ({ storageState, baseURL }) => {
  const {requestUtils, requestContext} = await prepareRequestUtilsAndContext({ storageState, baseURL })
	await requestUtils.deactivatePlugin('font-awesome')

  const connection = await mysql.createConnection({
    host: 'localhost',
    user: process.env.WORDPRESS_DB_USER,
    password: process.env.WORDPRESS_DB_PASSWORD,
    database: process.env.WORDPRESS_DB_NAME,
  })

  const sql = 'DELETE FROM `wp_options` WHERE `option_name` = ? LIMIT 1';
  await connection.execute(sql, ['font-awesome']);
  await connection.execute(sql, ['font-awesome-conflict-detection']);
  await connection.execute(sql, ['font-awesome-releases']);
	await requestUtils.activatePlugin('font-awesome')
	await requestContext.dispose();
})

async function prepareRequestUtilsAndContext({baseURL, storageState}) {
	const requestContext = await request.newContext( {
		baseURL,
	} );

	const storageStatePath =
		typeof storageState === 'string' ? storageState : undefined;

	const requestUtils = new RequestUtils( requestContext, {
		storageStatePath,
	} );

	await requestUtils.setupRest()

	return {requestUtils, requestContext}
}
