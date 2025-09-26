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
      name: 'setup-real-pro-kit',
      testDir,
      testMatch: 'setup/realProKit.js',
      use: {
        storageState: adminStorageStatePath
      },
      dependencies: ['wp-login', 'reset']
    },
    {
      name: 'mock-api-and-kit-token',
      testDir,
      testMatch: 'setup/mockApiAndKitToken.js',
      use: {
        storageState: adminStorageStatePath
      },
      dependencies: ['wp-login', 'reset']
    },
    {
      name: 'real-fa-api-pro-kit',
      testMatch: 'tests-using-real-fa-api/using-pro-kit/*.spec.js',
      use: {
        ...devices['Desktop Chrome'],
        storageState: adminStorageStatePath
      },
      dependencies: ['setup-real-pro-kit']
    },
    {
      name: 'real-fa-api-legacy-cdn',
      testMatch: 'tests-using-real-fa-api/using-legacy-cdn/*.spec.js',
      use: {
        ...devices['Desktop Chrome'],
        storageState: adminStorageStatePath
      },
      dependencies: ['wp-login', 'reset']
    },
    {
      name: 'with-mock-fa-api-pro-kit',
      testMatch: 'tests-using-mock-fa-api/using-pro-kit/*.spec.js',
      use: {
        ...devices['Desktop Chrome'],
        storageState: adminStorageStatePath
      },
      dependencies: ['mock-api-and-kit-token']
    },
    {
      name: 'with-mock-fa-api-legacy-cdn',
      testMatch: 'tests-using-mock-fa-api/using-legacy-cdn/*.spec.js',
      use: {
        ...devices['Desktop Chrome'],
        storageState: adminStorageStatePath
      },
      dependencies: ['wp-login', 'reset']
    }
  ]
})
