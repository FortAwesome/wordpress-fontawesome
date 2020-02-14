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
        response: error
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

  describe('when PreferenceRegistrationException is thrown with a previous exception', () => {
    const response = {
      status: 200,
      statusText: "OK",
      headers: {},
      config: {},
      request: {},
      data: {"options":{"usePro":false,"v4Compat":true,"technology":"svg","svgPseudoElements":false,"kitToken":null,"apiToken":false,"version":"5.12.0"},"conflicts":[],"error":{"errors":{"fontawesome_server_exception":["A theme or plugin registered with Font Awesome threw an exception."],"previous_exception":["epsilon-plugin throwing"]},"error_data":{"fontawesome_server_exception":{"status":500,"trace":"#0 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome.php(1057): FortAwesome\\FontAwesomeException::with_thrown(Object(Exception))\n#1 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(80): FortAwesome\\FontAwesome->gather_preferences()\n#2 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(134): FortAwesome\\FontAwesome_Config_Controller->build_item(Object(FortAwesome\\FontAwesome))\n#3 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(946): FortAwesome\\FontAwesome_Config_Controller->update_item(Object(WP_REST_Request))\n#4 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(329): WP_REST_Server->dispatch(Object(WP_REST_Request))\n#5 \/var\/www\/html\/wp-includes\/rest-api.php(305): WP_REST_Server->serve_request('\/font-awesome\/v...')\n#6 \/var\/www\/html\/wp-includes\/class-wp-hook.php(288): rest_api_loaded(Object(WP))\n#7 \/var\/www\/html\/wp-includes\/class-wp-hook.php(312): WP_Hook->apply_filters('', Array)\n#8 \/var\/www\/html\/wp-includes\/plugin.php(544): WP_Hook->do_action(Array)\n#9 \/var\/www\/html\/wp-includes\/class-wp.php(387): do_action_ref_array('parse_request', Array)\n#10 \/var\/www\/html\/wp-includes\/class-wp.php(729): WP->parse_request('')\n#11 \/var\/www\/html\/wp-includes\/functions.php(1255): WP->main('')\n#12 \/var\/www\/html\/wp-blog-header.php(16): wp()\n#13 \/var\/www\/html\/index.php(17): require('\/var\/www\/html\/w...')\n#14 {main}"},"previous_exception":{"status":500,"trace":"#0 \/var\/www\/html\/wp-includes\/class-wp-hook.php(288): {closure}('')\n#1 \/var\/www\/html\/wp-includes\/class-wp-hook.php(312): WP_Hook->apply_filters('', Array)\n#2 \/var\/www\/html\/wp-includes\/plugin.php(478): WP_Hook->do_action(Array)\n#3 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome.php(1055): do_action('font_awesome_pr...')\n#4 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(80): FortAwesome\\FontAwesome->gather_preferences()\n#5 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(134): FortAwesome\\FontAwesome_Config_Controller->build_item(Object(FortAwesome\\FontAwesome))\n#6 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(946): FortAwesome\\FontAwesome_Config_Controller->update_item(Object(WP_REST_Request))\n#7 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(329): WP_REST_Server->dispatch(Object(WP_REST_Request))\n#8 \/var\/www\/html\/wp-includes\/rest-api.php(305): WP_REST_Server->serve_request('\/font-awesome\/v...')\n#9 \/var\/www\/html\/wp-includes\/class-wp-hook.php(288): rest_api_loaded(Object(WP))\n#10 \/var\/www\/html\/wp-includes\/class-wp-hook.php(312): WP_Hook->apply_filters('', Array)\n#11 \/var\/www\/html\/wp-includes\/plugin.php(544): WP_Hook->do_action(Array)\n#12 \/var\/www\/html\/wp-includes\/class-wp.php(387): do_action_ref_array('parse_request', Array)\n#13 \/var\/www\/html\/wp-includes\/class-wp.php(729): WP->parse_request('')\n#14 \/var\/www\/html\/wp-includes\/functions.php(1255): WP->main('')\n#15 \/var\/www\/html\/wp-blog-header.php(16): wp()\n#16 \/var\/www\/html\/index.php(17): require('\/var\/www\/html\/w...')\n#17 {main}"}}}}
    }

    test('emits console report that includes the previous exception', () => {
      const message = reportRequestError({
        response
      })

      expect(console.group).toHaveBeenCalledTimes(3)
      expect(console.groupEnd).toHaveBeenCalledTimes(3)

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/code: fontawesome_server_exception/)
      )

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/code: previous_exception/)
      )

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/The last request was successful/)
      )

      expect(message).toMatch(/^A theme or plugin/)
    })
  })

  describe('when response is 200 OK with no errors', () => {
    const response = {
      status: 200,
      data: {}
    }

    test('nothing emitted to console', () => {
      const message = reportRequestError({
        response
      })

      expect(console.info).not.toHaveBeenCalled()
      expect(console.group).not.toHaveBeenCalled()
      expect(console.groupEnd).not.toHaveBeenCalled()
    })
  })

  describe('when response has a non-OK status but the error schema is invalid', () => {
    const error = {
      response: {
        data: '',
        status: 400
      }
    }

    test('something is emitted to indicate utter badness', () => {
      const message = reportRequestError({
        response: error
      })

      expect(console.info).toHaveBeenCalled()
      expect(console.group).toHaveBeenCalledTimes(1)
      expect(console.groupEnd).toHaveBeenCalledTimes(1)
      expect(message).toMatch(/^D\'oh/)
    })
  })
})
