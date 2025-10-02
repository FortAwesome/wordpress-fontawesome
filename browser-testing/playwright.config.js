import './support/env.js'
import { authFile } from './support/testHelpers.js'
import { defineConfig, devices } from '@playwright/test'

const testDir = '.'
const baseURL = `http://${process.env.WP_DOMAIN}`
process.env.WP_BASE_URL = baseURL

const browsers = [
  { name: 'chrome', device: 'Desktop Chrome' },
  { name: 'firefox', device: 'Desktop Firefox' },
  { name: 'webkit', device: 'Desktop Safari' }
]

const testConfigs = [
  {
    name: 'real-fa-api-pro-kit',
    testMatch: 'tests-using-real-fa-api/using-pro-kit/*.spec.js',
    dependencies: ['setup-real-pro-kit']
  },
  {
    name: 'real-fa-api-legacy-cdn',
    testMatch: 'tests-using-real-fa-api/using-legacy-cdn/*.spec.js',
    dependencies: ['reset']
  },
  {
    name: 'mock-fa-api-pro-kit',
    testMatch: 'tests-using-mock-fa-api/using-pro-kit/*.spec.js',
    dependencies: ['mock-api-and-kit-token']
  },
  {
    name: 'mock-fa-api-legacy-cdn',
    testMatch: 'tests-using-mock-fa-api/using-legacy-cdn/*.spec.js',
    dependencies: ['reset']
  }
]

// Generate browser-specific projects
const browserProjects = browsers.flatMap(browser =>
  testConfigs.map(config => ({
    name: `${config.name}-${browser.name}`,
    testMatch: config.testMatch,
    use: {
      ...devices[browser.device],
      storageState: authFile
    },
    dependencies: config.dependencies
  }))
)

export default defineConfig({
  use: {
    baseURL
  },
  projects: [
    { name: 'wp-login', testDir, testMatch: 'setup/wpLogin.js' },
    {
      name: 'reset',
      testDir,
      testMatch: 'setup/reset.js',
      use: {
        storageState: authFile
      },
      dependencies: ['wp-login']
    },
    {
      name: 'setup-real-pro-kit',
      testDir,
      testMatch: 'setup/realProKit.js',
      use: {
        storageState: authFile
      },
      dependencies: ['wp-login', 'reset']
    },
    {
      name: 'mock-api-and-kit-token',
      testDir,
      testMatch: 'setup/mockApiAndKitToken.js',
      use: {
        storageState: authFile
      },
      dependencies: ['wp-login', 'reset']
    },
    ...browserProjects
  ]
})
