import './src/playwright/env.js'
import { defineConfig, devices } from '@playwright/test';

const testDir = 'src/playwright'
const baseURL = `http://${process.env.WP_DOMAIN}`
process.env.WP_BASE_URL = baseURL
const adminStorageStatePath = 'src/playwright/.auth/state.json'

export default defineConfig({
  use: {
    baseURL,
  },
  projects: [
    { name: 'auth', testDir, testMatch: 'auth.setup.js' },
    {
      name: 'reset',
      testDir,
      testMatch: 'reset.setup.js',
      use: {
        storageState: adminStorageStatePath
      },
    },
    {
      name: 'setupProKit',
      testDir,
      testMatch: 'proKit.setup.js',
      use: {
        storageState: adminStorageStatePath
      },
      dependencies: [
        'auth',
        'reset'
      ]
    },
    {
      name: 'chromium',
      testMatch: '*.playwright.js',
      use: {
        ...devices['Desktop Chrome'],
        storageState: adminStorageStatePath
      },
      dependencies: ['setupProKit'],
    }
  ]
})

