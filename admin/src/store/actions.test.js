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

describe('submitPendingOptions', () => {
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
//{"options":{"usePro":true,"v4Compat":true,"technology":"webfont","pseudoElements":true,"kitToken":null,"apiToken":false,"version":"5.12.1"},"conflicts":[],"error":{"errors":{"fontawesome_server_exception":["A theme or plugin registered with Font Awesome threw an exception."],"previous_exception":["epsilon-plugin throwing"]},"error_data":{"fontawesome_server_exception":{"trace":"#0 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome.php(1039): FortAwesome\\FontAwesome_Exception::with_thrown(Object(Exception))\n#1 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(75): FortAwesome\\FontAwesome->gather_preferences()\n#2 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(130): FortAwesome\\FontAwesome_Config_Controller->build_item(Object(FortAwesome\\FontAwesome))\n#3 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(946): FortAwesome\\FontAwesome_Config_Controller->update_item(Object(WP_REST_Request))\n#4 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(329): WP_REST_Server->dispatch(Object(WP_REST_Request))\n#5 \/var\/www\/html\/wp-includes\/rest-api.php(305): WP_REST_Server->serve_request('\/font-awesome\/v...')\n#6 \/var\/www\/html\/wp-includes\/class-wp-hook.php(288): rest_api_loaded(Object(WP))\n#7 \/var\/www\/html\/wp-includes\/class-wp-hook.php(312): WP_Hook->apply_filters('', Array)\n#8 \/var\/www\/html\/wp-includes\/plugin.php(544): WP_Hook->do_action(Array)\n#9 \/var\/www\/html\/wp-includes\/class-wp.php(387): do_action_ref_array('parse_request', Array)\n#10 \/var\/www\/html\/wp-includes\/class-wp.php(729): WP->parse_request('')\n#11 \/var\/www\/html\/wp-includes\/functions.php(1255): WP->main('')\n#12 \/var\/www\/html\/wp-blog-header.php(16): wp()\n#13 \/var\/www\/html\/index.php(17): require('\/var\/www\/html\/w...')\n#14 {main}"},"previous_exception":{"trace":"#0 \/var\/www\/html\/wp-includes\/class-wp-hook.php(288): {closure}('')\n#1 \/var\/www\/html\/wp-includes\/class-wp-hook.php(312): WP_Hook->apply_filters(NULL, Array)\n#2 \/var\/www\/html\/wp-includes\/plugin.php(478): WP_Hook->do_action(Array)\n#3 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome.php(1037): do_action('font_awesome_pr...')\n#4 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(75): FortAwesome\\FontAwesome->gather_preferences()\n#5 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(130): FortAwesome\\FontAwesome_Config_Controller->build_item(Object(FortAwesome\\FontAwesome))\n#6 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(946): FortAwesome\\FontAwesome_Config_Controller->update_item(Object(WP_REST_Request))\n#7 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(329): WP_REST_Server->dispatch(Object(WP_REST_Request))\n#8 \/var\/www\/html\/wp-includes\/rest-api.php(305): WP_REST_Server->serve_request('\/font-awesome\/v...')\n#9 \/var\/www\/html\/wp-includes\/class-wp-hook.php(288): rest_api_loaded(Object(WP))\n#10 \/var\/www\/html\/wp-includes\/class-wp-hook.php(312): WP_Hook->apply_filters('', Array)\n#11 \/var\/www\/html\/wp-includes\/plugin.php(544): WP_Hook->do_action(Array)\n#12 \/var\/www\/html\/wp-includes\/class-wp.php(387): do_action_ref_array('parse_request', Array)\n#13 \/var\/www\/html\/wp-includes\/class-wp.php(729): WP->parse_request('')\n#14 \/var\/www\/html\/wp-includes\/functions.php(1255): WP->main('')\n#15 \/var\/www\/html\/wp-blog-header.php(16): wp()\n#16 \/var\/www\/html\/index.php(17): require('\/var\/www\/html\/w...')\n#17 {main}"}}}}

      })
    })

    describe('when confirmation header is absent', () => {
      describe('when invalid data precedes successful JSON response', () => {
        //const json = '{"options":{"usePro":true,"v4Compat":true,"technology":"webfont","pseudoElements":true,"kitToken":null,"apiToken":false,"version":"5.12.1"},"conflicts":[]}'
        let json = null

        beforeEach(() => {
        //const json = '{"options":{"usePro":true,"v4Compat":true,"technology":"webfont","pseudoElements":true,"kitToken":null,"apiToken":false,"version":"5.12.1"},"conflicts":[]}'
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
            mockPut = jest.fn(() => Promise.resolve())
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
            "error_data": {
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

    })

    describe('when confirmation header is absent', () => {

    })
  })
})
