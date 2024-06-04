import { test as setup, expect, RequestUtils } from '@wordpress/e2e-test-utils-playwright'
import { request } from '@playwright/test'
import mysql from 'mysql2/promise'

setup('reset', async ({ page, storageState, baseURL }) => {
	await deactivate(page);

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

	await activate(page);
})

async function deactivate(page) {
	await page.goto('/wp-admin/plugins.php');
  const linkLocator = page.getByRole('row', { name: 'Select Font Awesome Font' }).getByRole('link').nth(1);

	if ( (await linkLocator.innerText()).match(/Deactivate/) ) {
	  await linkLocator.click();
    await page.waitForURL('/wp-admin/plugins.php');
	}
}

async function activate(page) {
	await page.goto('/wp-admin/plugins.php');
  const linkLocator = page.getByRole('row', { name: 'Select Font Awesome Font' }).getByRole('link').nth(1);

	if ((await linkLocator.innerText()).match(/Activate/) ) {
	  await linkLocator.click();
    await page.waitForURL('/wp-admin/plugins.php');
	}
}
