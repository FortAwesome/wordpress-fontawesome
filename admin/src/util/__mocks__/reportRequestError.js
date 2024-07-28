export const MOCK_UI_MESSAGE = 'mock ui message'
const DEFAULT_REPORT_IMPL = () => MOCK_UI_MESSAGE
const mockDefaultFn = jest.fn(DEFAULT_REPORT_IMPL)

export const redactRequestData = jest.fn()
export const redactHeaders = jest.fn()

export default mockDefaultFn
