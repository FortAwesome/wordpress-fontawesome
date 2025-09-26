import './src/playwright/support/env.js'
import { defineConfig, devices } from '@playwright/test'

const testDir = 'src/playwright'
const baseURL = `http://${process.env.WP_DOMAIN}`
process.env.WP_BASE_URL = baseURL
const adminStorageStatePath = 'src/playwright/.auth/state.json'

export default defineConfig({
  use: {
    baseURL
  },
  projects: [
    { name: 'wp-login', testDir, testMatch: 'setup/wp-login.js' },
    {
      name: 'reset',
      testDir,
      testMatch: 'setup/reset.js',
      use: {
        storageState: adminStorageStatePath
      }
    },
    {
      name: 'setupRealProKit',
      testDir,
      testMatch: 'setup/realProKit.js',
      use: {
        storageState: adminStorageStatePath
      },
      dependencies: ['wp-login', 'reset']
    },
    {
      name: 'with-proKit-chromium',
      testMatch: 'withProKit/*.spec.js',
      use: {
        ...devices['Desktop Chrome'],
        storageState: adminStorageStatePath
      },
      dependencies: ['setupRealProKit']
    },
    {
      name: 'withAuth-chromium',
      testMatch: 'withAuth/*.spec.js',
      use: {
        ...devices['Desktop Chrome'],
        storageState: adminStorageStatePath
      },
      dependencies: ['wp-login', 'reset']
    }
  ]
})
