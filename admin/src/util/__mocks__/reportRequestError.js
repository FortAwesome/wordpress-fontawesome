export const MOCK_UI_MESSAGE = 'mock ui message'
const DEFAULT_IMPL = () => MOCK_UI_MESSAGE
export default jest.fn( DEFAULT_IMPL )
