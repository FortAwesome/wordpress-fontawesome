import reportRequestError from './reportRequestError'

console.group = jest.fn()
console.groupEnd = jest.fn()
console.info = jest.fn()

describe('reportRequestError', () => {
  beforeEach(() => {
    console.group.mockClear()
    console.groupEnd.mockClear()
    console.info.mockClear()
  })
  describe('with single fontawesome_client_exception', () => {
    const error = {
      response: {
        data: {"code":"fontawesome_client_exception","message":"Whoops, it looks like that API Token is not valid. Try another one?","data":{"status":400,"trace":"#0 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-api-settings.php(311): FortAwesome\\FontAwesomeException::with_wp_response(Array)\n#1 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(115): FortAwesome\\FontAwesome_API_Settings->request_access_token()\n#2 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(946): FortAwesome\\FontAwesome_Config_Controller->update_item(Object(WP_REST_Request))\n#3 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(329): WP_REST_Server->dispatch(Object(WP_REST_Request))\n#4 \/var\/www\/html\/wp-includes\/rest-api.php(305): WP_REST_Server->serve_request('\/font-awesome\/v...')\n#5 \/var\/www\/html\/wp-includes\/class-wp-hook.php(288): rest_api_loaded(Object(WP))\n#6 \/var\/www\/html\/wp-includes\/class-wp-hook.php(312): WP_Hook->apply_filters('', Array)\n#7 \/var\/www\/html\/wp-includes\/plugin.php(544): WP_Hook->do_action(Array)\n#8 \/var\/www\/html\/wp-includes\/class-wp.php(387): do_action_ref_array('parse_request', Array)\n#9 \/var\/www\/html\/wp-includes\/class-wp.php(729): WP->parse_request('')\n#10 \/var\/www\/html\/wp-includes\/functions.php(1255): WP->main('')\n#11 \/var\/www\/html\/wp-blog-header.php(16): wp()\n#12 \/var\/www\/html\/index.php(17): require('\/var\/www\/html\/w...')\n#13 {main}"}},
        status: 400,
        statusText: "Bad Request",
        headers: {},
        config: {},
        request: {}
      }
    }

    test('emits console report and returns uiMessage from given error', () => {
      const message = reportRequestError({
        error
      })

      expect(message).toMatch(/^Whoops/)
      expect(console.group).toHaveBeenCalledTimes(1)
      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/trace:/)
      )
      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/status:/)
      )
      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/code: fontawesome_client_exception/)
      )
      expect(console.groupEnd).toHaveBeenCalledTimes(1)
    })
  })
})
