import { respondWith, resetAxiosMocks, changeImpl } from 'axios'
import { submitPendingOptions } from './actions'
import configureMockStore from 'redux-mock-store'
import thunk from 'redux-thunk'
import reportRequestError, { MOCK_UI_MESSAGE } from '../util/reportRequestError'
jest.mock('../util/reportRequestError')
const apiUrl = '/font-awesome/v1'
const INVALID_JSON_RESPONSE_DATA = 'foo[42]bar{123}'

const middlewares = [thunk]
const mockStore = configureMockStore(middlewares)
const fakeNonce = 'fakeNonce'

describe('submitPendingOptions and interceptors', () => {
  let store = null
  let pendingOptions = {
    technology: 'svg'
  }

  beforeEach(() => {
    store = mockStore({
      apiNonce: fakeNonce,
      apiUrl,
      options: {
        technology: 'webfont'
      },
      pendingOptions
    })

    reportRequestError.mockClear()
  })

  afterEach(() => {
    resetAxiosMocks()
  })
  
  describe('when HTTP 200', () => {
    describe('when confirmation header is present', () => {
      describe('successful JSON response also includes error information', () => {
        let json = null

        beforeEach(() => {
          json = JSON.stringify({
            options: pendingOptions,
            error: {
              errors: {
                "code1": ["message1"],
              },
              error_data: {
                "code1": {
                  "trace": 'some stack trace'
                }
              }
            }
          })

          respondWith({
            url: `${apiUrl}/config`,
            method: 'PUT',
            response: {
              status: 200,
              statusText: 'OK',
              data: json,
              headers: {
                'fontawesome-confirmation': 1
              }
            }
          })
        })

        test('submits successfully with successful ui message and also reports error to console', done => {
          store.dispatch(submitPendingOptions()).then(() => {
            expect(reportRequestError).toHaveBeenCalledTimes(1)
            expect(reportRequestError).toHaveBeenCalledWith(expect.objectContaining({
              error: expect.objectContaining({
                errors: {
                  code1: expect.anything()
                },
                error_data: {
                  code1: expect.anything()
                }
              }),
              confirmed: true,
              ok: true
            }))
            expect(store.getActions().length).toEqual(2)
            expect(store.getActions()).toEqual(expect.arrayContaining([
              expect.objectContaining({
                type: 'OPTIONS_FORM_SUBMIT_START'
              }),
              expect.objectContaining({
                type: 'OPTIONS_FORM_SUBMIT_END',
                success: true,
                data: json,
                message: expect.stringContaining('saved')
              })
            ]))
            done()
          })
        })
      })
    })

    describe('when confirmation header is absent', () => {
      describe('when invalid data precedes successful JSON response', () => {
        let json = null

        beforeEach(() => {
          json = JSON.stringify({
            options: pendingOptions
          })

          respondWith({
            url: `${apiUrl}/config`,
            method: 'PUT',
            response: {
              status: 200,
              statusText: 'OK',
              data: `${INVALID_JSON_RESPONSE_DATA}${json}`
            }
          })
        })

        test('reports warning but completes successfully', done => {
          store.dispatch(submitPendingOptions()).then(() => {
            expect(reportRequestError).toHaveBeenCalledTimes(1)
            expect(reportRequestError).toHaveBeenCalledWith(expect.objectContaining({
              error: null,
              confirmed: false,
              ok: true,
              trimmed: INVALID_JSON_RESPONSE_DATA
            }))
            expect(store.getActions().length).toEqual(2)
            expect(store.getActions()).toEqual(expect.arrayContaining([
              expect.objectContaining({
                type: 'OPTIONS_FORM_SUBMIT_START'
              }),
              expect.objectContaining({
                type: 'OPTIONS_FORM_SUBMIT_END',
                success: true,
                data: json,
                message: expect.stringContaining('saved')
              })
            ]))
            done()
          })
        })

        describe('axios request', () => {
          let mockPut = null
          beforeEach(() => {
            mockPut = jest.fn(() => Promise.resolve({ data: json }))
            changeImpl({ name: 'put', fn: mockPut })
          })

          test('submits pendingOptions', done => {
            store.dispatch(submitPendingOptions()).then(() => {
              expect(mockPut).toHaveBeenCalledTimes(1)
              expect(mockPut).toHaveBeenCalledWith(
                `${apiUrl}/config`,
                expect.objectContaining({
                  options: pendingOptions
                }),
                expect.objectContaining({
                  headers: {
                    'X-WP-Nonce': fakeNonce
                  }
                })
              )
              done()
            })
          })
        })
      })

      describe('false positive: when invalid data preceeds an errors JSON response that should have been HTTP 4xx or 5xx', () => {
        let jsonResponse = null

        beforeEach(() => {
          jsonResponse = JSON.stringify({
            errors: {
              "code1": ["message1"],
            },
            error_data: {
              "code1": {
                "trace": 'some stack trace'
              }
            }
          })

          respondWith({
            url: `${apiUrl}/config`,
            method: 'PUT',
            response: {
              status: 200,
              statusText: 'OK',
              data: `${INVALID_JSON_RESPONSE_DATA}${jsonResponse}`
            }
          })
        })

        test('reports warning and dispatches a failure action despite the garbage', done => {
          store.dispatch(submitPendingOptions()).then(() => {
            expect(reportRequestError).toHaveBeenCalledTimes(1)
            expect(reportRequestError).toHaveBeenCalledWith(expect.objectContaining({
              error: expect.objectContaining({
                errors: expect.anything(),
                'error_data': expect.anything()
              }),
              confirmed: false,
              falsePositive: true,
              trimmed: INVALID_JSON_RESPONSE_DATA
            }))
            expect(store.getActions().length).toEqual(2)
            expect(store.getActions()).toEqual(expect.arrayContaining([
              expect.objectContaining({
                type: 'OPTIONS_FORM_SUBMIT_START'
              }),
              expect.objectContaining({
                type: 'OPTIONS_FORM_SUBMIT_END',
                success: false,
                message: MOCK_UI_MESSAGE
              })
            ]))
            done()
          })
        })
      })
    })
  })

  describe('when HTTP 400', () => {
    describe('when confirmation header is present', () => {
        let json = null

        beforeEach(() => {
          json = JSON.stringify({
            errors: {
              "code1": ["message1"],
            },
            error_data: {
              "code1": {
                "trace": 'some stack trace'
              }
            }
          })

          respondWith({
            url: `${apiUrl}/config`,
            method: 'PUT',
            response: {
              status: 400,
              statusText: 'Bad Request',
              data: json,
              headers: {
                'fontawesome-confirmation': 1
              }
            }
          })
        })

        test('reports ui and console error messages', done => {
          reportRequestError.mockReturnValueOnce(null)
          store.dispatch(submitPendingOptions()).then(() => {
            expect(reportRequestError).toHaveBeenCalledTimes(1)
            expect(reportRequestError).toHaveBeenCalledWith(expect.objectContaining({
              error: expect.objectContaining({
                errors: expect.anything(),
                'error_data': expect.anything()
              }),
              confirmed: true,
              trimmed: ''
            }))
            expect(store.getActions().length).toEqual(2)
            expect(store.getActions()).toEqual(expect.arrayContaining([
              expect.objectContaining({
                type: 'OPTIONS_FORM_SUBMIT_START'
              }),
              expect.objectContaining({
                type: 'OPTIONS_FORM_SUBMIT_END',
                success: false,
                message: expect.stringContaining("Couldn't save")
              })
            ]))
            done()
          })
        })
    })

    describe('when errors payload is absent', () => {
        let json = null

        beforeEach(() => {
          json = JSON.stringify({})

          respondWith({
            url: `${apiUrl}/config`,
            method: 'PUT',
            response: {
              status: 400,
              statusText: 'Bad Request',
              data: json,
              headers: {
                'fontawesome-confirmation': 1
              }
            }
          })
        })

        test('displays default ui message and emits console message', done => {
          reportRequestError.mockReturnValueOnce(null)
          store.dispatch(submitPendingOptions()).then(() => {
            expect(reportRequestError).toHaveBeenCalledTimes(1)
            expect(reportRequestError).toHaveBeenCalledWith(expect.objectContaining({
              error: null,
              confirmed: true,
              trimmed: ''
            }))
            expect(store.getActions().length).toEqual(2)
            expect(store.getActions()).toEqual(expect.arrayContaining([
              expect.objectContaining({
                type: 'OPTIONS_FORM_SUBMIT_START'
              }),
              expect.objectContaining({
                type: 'OPTIONS_FORM_SUBMIT_END',
                success: false,
                message: expect.stringContaining("Couldn't save")
              })
            ]))
            done()
          })
        })
    })
  })

  describe('when axios request fails with no response', () => {
    beforeEach(() => {
      respondWith({
        url: `${apiUrl}/config`,
        method: 'PUT',
        response: new XMLHttpRequest()
      })
    })

    test('failed request is reported to console and failure with uiMessage is dispatched to store', done => {
      store.dispatch(submitPendingOptions()).then(() => {
        expect(reportRequestError).toHaveBeenCalledTimes(1)
        expect(reportRequestError).toHaveBeenCalledWith(expect.objectContaining({
          error: {
            errors: expect.objectContaining({
              fontawesome_request_noresponse: [ expect.any(String) ]
            }),
            error_data: {
              fontawesome_request_noresponse: {
                request: expect.any(XMLHttpRequest)
              }
            }
          },
        }))
        expect(store.getActions()).toEqual(expect.arrayContaining([
          expect.objectContaining({
            type: 'OPTIONS_FORM_SUBMIT_START'
          }),
          expect.objectContaining({
            type: 'OPTIONS_FORM_SUBMIT_END',
            success: false,
            message: MOCK_UI_MESSAGE
          })
        ]))
        done()
      })
    })
  })

  describe('when axios request fails for some other reason', () => {
    beforeEach(() => {
      respondWith({
        url: `${apiUrl}/config`,
        method: 'PUT',
        response: new Error('some axios error')
      })
    })

    test('failure is reported to console and failure with uiMessage is dispatched to store', done => {
      store.dispatch(submitPendingOptions()).then(() => {
        expect(reportRequestError).toHaveBeenCalledTimes(1)
        expect(reportRequestError).toHaveBeenCalledWith(expect.objectContaining({
          error: {
            errors: expect.objectContaining({
              fontawesome_request_failed: [ expect.stringContaining('server failed') ]
            }),
            error_data: {
              fontawesome_request_failed: {
                failedRequestMessage: 'some axios error'
              }
            }
          },
        }))
        expect(store.getActions()).toEqual(expect.arrayContaining([
          expect.objectContaining({
            type: 'OPTIONS_FORM_SUBMIT_START'
          }),
          expect.objectContaining({
            type: 'OPTIONS_FORM_SUBMIT_END',
            success: false,
            message: MOCK_UI_MESSAGE
          })
        ]))
        done()
      })
    })
  })
})
