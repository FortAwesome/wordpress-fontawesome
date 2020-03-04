export const MOCK_UI_MESSAGE = 'mock ui message'
const DEFAULT_IMPL = () => MOCK_UI_MESSAGE
const mockFn = jest.fn( DEFAULT_IMPL )
export default mockFn
