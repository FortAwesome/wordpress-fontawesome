import { respondWith, resetAxiosMocks, changeImpl } from 'axios'
import * as actions from './actions'
import { submitPendingOptions, addPendingOption } from './actions'
import configureMockStore from 'redux-mock-store'
import thunk from 'redux-thunk'
import reportRequestError, { MOCK_UI_MESSAGE, redactHeaders, redactRequestData } from '../util/reportRequestError'
jest.mock('../util/reportRequestError')
const apiUrl = '/font-awesome/v1'
const INVALID_JSON_RESPONSE_DATA = 'foo[42]bar{123}'

const middlewares = [thunk]
const mockStore = configureMockStore(middlewares)
const fakeNonce = 'fakeNonce'

describe('addPendingOption', () => {
  let store = null

  beforeEach(() => {
    store = mockStore({
      apiNonce: fakeNonce,
      apiUrl,
      options: {
        technology: 'svg',
        pseudoElements: false
      },
      pendingOptions: {}
    })
  })

  test('when multiple pending options are adjusted together, all are updated', () => {
    store.dispatch(addPendingOption({ technology: 'webfont', pseudoElements: true }))
    expect(store.getActions().length).toEqual(2)
    expect(store.getActions()[0]).toEqual(expect.objectContaining({
      type: 'ADD_PENDING_OPTION',
      change: { technology: 'webfont' }
    }))
    expect(store.getActions()[1]).toEqual(expect.objectContaining({
      type: 'ADD_PENDING_OPTION',
      change: { pseudoElements: true }
    }))
  })
})

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
        let data = null

        beforeEach(() => {
          data = {
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
          }

          respondWith({
            url: `${apiUrl}/config`,
            method: 'PUT',
            response: {
              status: 200,
              statusText: 'OK',
              data,
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
                data,
                message: expect.stringContaining('saved')
              })
            ]))
            done()
          })
          .catch(e => done(e))
        })
      })
    })

    describe('when confirmation header is absent', () => {
      describe('when invalid data precedes successful JSON response', () => {
        let data = null

        beforeEach(() => {
          data = {
            options: pendingOptions
          }

          respondWith({
            url: `${apiUrl}/config`,
            method: 'PUT',
            response: {
              status: 200,
              statusText: 'OK',
              data: `${INVALID_JSON_RESPONSE_DATA}${JSON.stringify(data)}`
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
                data,
                message: expect.stringContaining('saved')
              })
            ]))
            done()
          })
          .catch(e => done(e))
        })

        describe('axios request', () => {
          let mockPut = null
          beforeEach(() => {
            mockPut = jest.fn(() => Promise.resolve({ data }))
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
            .catch(e => done(e))
          })
        })
      })
    })
  })

  describe('when HTTP 400', () => {
    describe('when errors payload is absent', () => {
        const responseData = {foo: 42}
        const url = `${apiUrl}/config`
        const method = 'PUT'
        const status = 400
        const statusText = 'Bad Request'
        const requestData = JSON.stringify({bar: 43})
        const responseHeaders = {
          'fontawesome-confirmation': 1
        }
        const requestHeaders = {
          'Content-Type': 'application/json'
        }

        beforeEach(() => {
          respondWith({
            url,
            method,
            response: {
              status,
              statusText,
              data: responseData,
              headers: responseHeaders,
              config: {
                method,
                url,
                data: requestData,
                headers: requestHeaders
              }
            },
          })
        })

        test('displays default ui message and emits console message', done => {
          reportRequestError.mockReturnValueOnce(null)
          store.dispatch(submitPendingOptions()).then(() => {
            expect(reportRequestError).toHaveBeenCalledTimes(1)
            expect(reportRequestError).toHaveBeenCalledWith(expect.objectContaining({
              confirmed: true,
              requestMethod: method,
              //requestData,
              requestUrl: url,
              // responseHeaders: expect.any(Object),
              // requestHeaders: expect.any(Object),
              responseStatus: status,
              responseStatusText: statusText,
              responseData
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
          .catch(e => done(e))
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

      reportRequestError.mockImplementation(() => MOCK_UI_MESSAGE)
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
      .catch(e => done(e))
    })
  })

  describe('when axios request fails for some other reason', () => {
    beforeEach(() => {
      respondWith({
        url: `${apiUrl}/config`,
        method: 'PUT',
        response: new Error('some axios error')
      })

      reportRequestError.mockImplementation(() => MOCK_UI_MESSAGE)
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
      .catch(e => done(e))
    })
  })
})

describe('some action failure cases', () => {
  const STATE_TECH_CHANGE = {
    options: {
      technology: 'webfont'

    },
    pendingOptions: {
      technology: 'svg'
    }
  }

  const cases = [
    {
      action: 'queryKits',
      state: {
        options: {
          kitToken: 'deadbeef'
        }
      },
      route: 'api',
      method: 'POST',
      startAction: 'KITS_QUERY_START',
      endAction: 'KITS_QUERY_END',
      params: {}
    },
    {
      action: 'updateApiToken',
      state: {},
      route: 'config',
      method: 'PUT',
      startAction: 'OPTIONS_FORM_SUBMIT_START',
      endAction: 'OPTIONS_FORM_SUBMIT_END',
      params: {
        apiToken: 'xyz456',
        runQueryKits: false 
      }
    },
    {
      action: 'submitPendingBlocklist',
      state: {
        blocklistUpdateStatus: {
          pending: [ 'abc123' ]
        }
      },
      route: 'conflict-detection/conflicts/blocklist',
      method: 'PUT',
      startAction: 'BLOCKLIST_UPDATE_START',
      endAction: 'BLOCKLIST_UPDATE_END',
      params: {}
    },
    {
      action: 'submitPendingUnregisteredClientDeletions',
      state: {
        unregisteredClientsDeletionStatus: {
          pending: [ 'abc123' ]
        }
      },
      route: 'conflict-detection/conflicts',
      method: 'DELETE',
      startAction: 'DELETE_UNREGISTERED_CLIENTS_START',
      endAction: 'DELETE_UNREGISTERED_CLIENTS_END',
      params: {}
    },
    {
      action: 'reportDetectedConflicts',
      state: {
        showConflictDetectionReporter: true
      },
      route: 'conflict-detection/conflicts',
      method: 'POST',
      startAction: 'CONFLICT_DETECTION_SUBMIT_START',
      endAction: 'CONFLICT_DETECTION_SUBMIT_END',
      params: {
        nodesTested: {
          conflict: {
            'abc123': {}
          }
        }
      }
    },
    {
      action: 'snoozeV3DeprecationWarning',
      state: {},
      route: 'v3deprecation',
      method: 'PUT',
      startAction: 'SNOOZE_V3DEPRECATION_WARNING_START',
      endAction: 'SNOOZE_V3DEPRECATION_WARNING_END',
      params: {}
    },
    {
      action: 'setConflictDetectionScanner',
      desc: 'when enabling',
      state: {},
      route: 'conflict-detection/until',
      method: 'PUT',
      startAction: 'ENABLE_CONFLICT_DETECTION_SCANNER_START',
      endAction: 'ENABLE_CONFLICT_DETECTION_SCANNER_END',
      params: { enable: true }
    },
    {
      action: 'setConflictDetectionScanner',
      desc: 'when disabling',
      state: {},
      route: 'conflict-detection/until',
      method: 'PUT',
      startAction: 'DISABLE_CONFLICT_DETECTION_SCANNER_START',
      endAction: 'DISABLE_CONFLICT_DETECTION_SCANNER_END',
      params: { enable: false }
    },
    {
      action: 'checkPreferenceConflicts',
      state: STATE_TECH_CHANGE,
      route: 'preference-check',
      method: 'POST',
      startAction: 'PREFERENCE_CHECK_START',
      endAction: 'PREFERENCE_CHECK_END',
      params: undefined
    },
    {
      action: 'submitPendingOptions',
      state: STATE_TECH_CHANGE,
      route: 'config',
      method: 'PUT',
      startAction: 'OPTIONS_FORM_SUBMIT_START',
      endAction: 'OPTIONS_FORM_SUBMIT_END',
      params: undefined
    }
  ]

  const garbage = 'foo[alpha]bar{beta}'

  const data = {
    errors: {
      "code1": ["message1"],
    },
    error_data: {
      "code1": {
        "trace": 'some stack trace'
      }
    }
  }

  beforeEach(() => {
    reportRequestError.mockClear()
  })

  afterEach(() => {
    resetAxiosMocks()
  })

  cases.map(c => {
    describe(`${c.action}${ c.desc || ''}`, () => {
      let store = null

      beforeEach(() => {
        store = mockStore({
          apiNonce: fakeNonce,
          apiUrl,
          ...c.state
        })
      })

      describe('when falsePositive', () => {
        beforeEach(() => {
          respondWith({
            url: `${apiUrl}/${c.route}`,
            method: c.method,
            response: {
              status: 200,
              statusText: 'OK',
              data: `${garbage}${JSON.stringify(data)}`,
              // no confirmation header
            }
          })
        })

        test('reports warning and dispatches a failure action despite the garbage', done => {
          store.dispatch(actions[c.action](c.params)).then(() => {
            expect(reportRequestError).toHaveBeenCalledTimes(1)
            expect(reportRequestError).toHaveBeenCalledWith(expect.objectContaining({
              error: expect.objectContaining({
                errors: expect.anything(),
                'error_data': expect.anything()
              }),
              confirmed: false,
              falsePositive: true,
              trimmed: garbage
            }))
            expect(store.getActions().length).toEqual(2)
            expect(store.getActions()).toEqual(expect.arrayContaining([
              expect.objectContaining({
                type: c.startAction
              }),
              expect.objectContaining({
                type: c.endAction,
                success: false,
                message: expect.stringMatching(/[a-z]/)
              })
            ]))
            done()
          })
          .catch(e => done(e))
        })
      })

      describe('when normal failure', () => {
        beforeEach(() => {
          respondWith({
            url: `${apiUrl}/${c.route}`,
            method: c.method,
            response: {
              status: 400,
              statusText: 'Bad Request',
              data,
              headers: {
                'fontawesome-confirmation': 1
              }
            }
          })
        })

        test('reports ui and console error messages', done => {
          reportRequestError.mockReturnValueOnce(null)
          store.dispatch(actions[c.action](c.params)).then(() => {
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
                type: c.startAction
              }),
              expect.objectContaining({
                type: c.endAction,
                success: false,
                message: expect.stringMatching(/[a-z]/)
              })
            ]))
            done()
          })
          .catch(e => done(e))
        })
      })
    })
  })
})

describe('submitPendingUnregisteredClientDeletions', () => {
  test.todo('when deleteList is empty return early doing nothing')
  test.todo('success when deleteList is non-empty')
})

describe('submitPendingBlocklist', () => {
  test.todo('when blocklist is falsy return early doing nothing')
  test.todo('success when blocklist is non-empty')
})

describe('checkPreferenceConflicts', () => {
  test.todo('success')
})

describe('queryKits', () => {
  describe('when kits query succeeds', () => {
    describe('when graphql response has null me field', () => {
      test.todo('reports error when graphql response has null me field')
    })
    describe('when there are no changes to the active kit', () => {
      test.todo('returns early instead of saving kit changes')
    })
    describe('when there are changes to the active kit', () => {
      test.todo('success')
      test.todo('false positive reports error')
      test.todo('normal failure reports error')
    })
  })
})

describe('updateApiToken', () => {
  test.todo('runs queryKits after successfully saving apiToken')
})

describe('reportDetectedConflicts', () => {
  test.todo('return early when not showing conflict detector')
  test.todo('dispatches NONE_FOUND when no conflicts are reported')
  test.todo('success')
})

describe('snoozeV3DeprecationWarning', () => {
  test.todo('success')
})

describe('setConflictDetectionScanner', () => {
  test.todo('success when enabling')
  test.todo('success when disabling')
})

describe('preprocessResponse', () => {
  beforeEach(() => {
    reportRequestError.mockClear()
  })

  describe('when fontawesome-confirmation header is set', () => {
    test('determines confirmed as true', () => {
      const response = {
        status: 400,
        headers: {
          'fontawesome-confirmation': 1
        }
      }

      actions.preprocessResponse(response)

      expect(reportRequestError).toHaveBeenCalledWith(expect.objectContaining({confirmed: true}))
    })
  })

  describe('when method not allowed for PUT', () => {
    const url = `${apiUrl}/config`
    const method = 'PUT'
    const status = 405
    const statusText = 'Method Not Allowed'
    const requestData = JSON.stringify({bar: 43})
    const requestHeaders = {
      'Content-Type': 'application/json'
    }

    let responseData = null
    let responseHeaders = null

    const REDACTED_REQUEST_DATA = 'redacted_request_data'
    const REDACTED_HEADERS = 'redacted_headers'

    beforeEach(() => {
      redactHeaders.mockClear()
      redactRequestData.mockClear()
      redactHeaders.mockReturnValue(REDACTED_HEADERS)
      redactRequestData.mockReturnValue(REDACTED_REQUEST_DATA)
    })

    afterEach(() => {
      responseData = null
      responseHeaders = null
      redactHeaders.mockReset()
      redactRequestData.mockReset()
    })

    describe('when response data is HTML', () => {
      beforeEach(() => {
        responseData = '<html><body><p>Some unexpected HTML response</p></body></html>'

        responseHeaders = {
          'access-control-allow-methods': 'GET, POST, DELETE',
          'Content-Type': 'text/html; charset=UTF-8'
        }
      })

      test('reports with full details including response data', () => {
        const response = {
          status,
          statusText,
          data: responseData,
          headers: responseHeaders,
          url,
          config: {
            headers: requestHeaders,
            method,
            url,
            data: requestData
          }
        }

        actions.preprocessResponse(response)

        expect(reportRequestError).toHaveBeenCalledWith(expect.objectContaining({
          confirmed: false,
          requestData,
          requestMethod: method,
          requestUrl: url,
          responseStatus: status,
          responseStatusText: statusText,
          requestData: REDACTED_REQUEST_DATA,
          responseHeaders: REDACTED_HEADERS,
          requestHeaders: REDACTED_HEADERS
        }))
      })
    })

    describe('when response data is empty', () => {
      beforeEach(() => {
        responseData = ''

        responseHeaders = {
          'access-control-allow-methods': 'GET, POST, DELETE',
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })

      test('reports with full details including response data', () => {
        const response = {
          status,
          statusText,
          data: responseData,
          headers: responseHeaders,
          url,
          config: {
            headers: requestHeaders,
            method,
            url,
            data: requestData
          }
        }

        actions.preprocessResponse(response)

        expect(reportRequestError).toHaveBeenCalledWith(expect.objectContaining({
          confirmed: false,
          requestMethod: method,
          requestUrl: url,
          responseStatus: status,
          responseStatusText: statusText,
          responseData,
          requestData: REDACTED_REQUEST_DATA,
          responseHeaders: REDACTED_HEADERS,
          requestHeaders: REDACTED_HEADERS
        }))
      })
    })
  })
})
