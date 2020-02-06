import { options } from './index'

describe('options', () => {
  describe('defaults', () => {
    test('returns initial state', () => {
      expect(options(undefined, {})).toEqual({})
    })
  })

  describe('no action match', () => {
    test('return unchanged state', () => {
      expect(options({ foo: 42 })).toEqual({foo: 42})
    })
  })

  describe('OPTIONS_FORM_SUBMIT_END', () => {
    test('when successful state is updated with given data', () => {
      const data = {
        options: {
          technology: 'svg',
          usePro: true,
          v4compat: false,
          svgPseudoElements: true,
          version: '5.11.2',
        }
      }

      const action = {
        type: 'OPTIONS_FORM_SUBMIT_END',
        data
      }

      expect(options(undefined, action)).toEqual(data.options)
    })

    test('when unsuccessful, such that data is undefined, state is unchanged', () => {
      const action = {
        type: 'OPTIONS_FORM_SUBMIT_END'
      }

      expect(options({ foo: 42 }, action)).toEqual({foo: 42})
    })
  })
})
