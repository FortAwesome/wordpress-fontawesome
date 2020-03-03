const DEFAULT_IMPL = () => 'fake ui message'
let mockFn = null

resetReportRequestErrorMock()

export function resetReportRequestErrorMock() {
  mockFn = jest.fn( DEFAULT_IMPL )
  // mockFn = jest.fn()
}

export function getReportRequestErrorMock() {
  return mockFn
}

export default function() {
  return mockFn(...arguments)
}
