describe('checkCompatibility', () => {
  const originalConsoleError = console.error
  const originalConsoleWarn = console.warn

  let i18n = null

  beforeEach(() => {
    console.error = jest.fn()
    console.warn = jest.fn()
    window.__Font_Awesome_Webpack_Externals__ = undefined
    i18n = {
      __: jest.fn(),
      sprintf: jest.fn(),
    }
  })

  afterEach(() => {
    console.error = originalConsoleError
    console.warn = originalConsoleWarn
  })

  test('all good when old versions', () => {
    window.__Font_Awesome_Webpack_Externals__ = {
      React: {
        version: '16.9.0'
      },
      ReactDOM: {}, 
      i18n,
      apiFetch: () => {},
      components: {},
      element: {
        __experimentalCreateInterpolateElement: () => {}
      }
    }

    const { default: checkCompatibility } = require('./checkCompatibility')

    expect(checkCompatibility()).toBe(true)
  })

  test('all good with React 16.13.1 and createInterpolateElement', () => {
    window.__Font_Awesome_Webpack_Externals__ = {
      React: {
        version: '16.13.1'
      },
      ReactDOM: {}, 
      i18n,
      apiFetch: () => {},
      components: {},
      element: {
        createInterpolateElement: () => {}
      }
    }

    const { default: checkCompatibility } = require('./checkCompatibility')

    expect(checkCompatibility()).toBe(true)
  })

  test('incompatible when when React is too old', () => {
    window.__Font_Awesome_Webpack_Externals__ = {
      React: {
        version: '16.7.0'
      },
      ReactDOM: {}, 
      i18n,
      apiFetch: () => {},
      components: {},
      element: {
        createInterpolateElement: () => {}
      }
    }

    const { default: checkCompatibility } = require('./checkCompatibility')

    expect(checkCompatibility()).toBe(false)
    expect(console.warn).toHaveBeenCalled()
  })

  test('incompatible when when no createInterpolateElement is available', () => {
    window.__Font_Awesome_Webpack_Externals__ = {
      React: {
        version: '16.9.0'
      },
      ReactDOM: {}, 
      i18n,
      apiFetch: () => {},
      components: {},
      element: {}
    }

    const { default: checkCompatibility } = require('./checkCompatibility')

    expect(checkCompatibility()).toBe(false)
    expect(console.warn).toHaveBeenCalled()
  })
})
