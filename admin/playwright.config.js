import './src/playwright/support/env.js'
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
    { name: 'auth', testDir, testMatch: 'setup/auth.js' },
    {
      name: 'reset',
      testDir,
      testMatch: 'setup/reset.js',
      use: {
        storageState: adminStorageStatePath
      },
    },
    {
      name: 'setupProKit',
      testDir,
      testMatch: 'setup/proKit.js',
      use: {
        storageState: adminStorageStatePath
      },
      dependencies: [
        'auth',
        'reset'
      ]
    },
    {
      name: 'with-proKit-chromium',
      testMatch: 'withProKit/*.spec.js',
      use: {
        ...devices['Desktop Chrome'],
        storageState: adminStorageStatePath
      },
      dependencies: ['setupProKit'],
    },
    {
      name: 'withAuth-chromium',
      testMatch: 'withAuth/*.spec.js',
      use: {
        ...devices['Desktop Chrome'],
        storageState: adminStorageStatePath
      },
      dependencies: ['auth', 'reset'],
    }
  ]
})

