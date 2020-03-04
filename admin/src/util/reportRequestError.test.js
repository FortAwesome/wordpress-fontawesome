import reportRequestError from './reportRequestError'

console.group = jest.fn()
console.groupEnd = jest.fn()
console.info = jest.fn()

const SINGLE_EXCEPTION_ERROR = {
  errors: {
    fontawesome_client_exception: ["Whoops, it looks like that API Token is not valid. Try another one?"]
  },
  error_data: {
    fontawesome_client_exception: {
      status:400,
      trace:"#0 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-api-settings.php(311): FortAwesome\\FontAwesome_Exception::with_wp_response(Array)\n#1 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(115): FortAwesome\\FontAwesome_API_Settings->request_access_token()\n#2 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(946): FortAwesome\\FontAwesome_Config_Controller->update_item(Object(WP_REST_Request))\n#3 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(329): WP_REST_Server->dispatch(Object(WP_REST_Request))\n#4 \/var\/www\/html\/wp-includes\/rest-api.php(305): WP_REST_Server->serve_request('\/font-awesome\/v...')\n#5 \/var\/www\/html\/wp-includes\/class-wp-hook.php(288): rest_api_loaded(Object(WP))\n#6 \/var\/www\/html\/wp-includes\/class-wp-hook.php(312): WP_Hook->apply_filters('', Array)\n#7 \/var\/www\/html\/wp-includes\/plugin.php(544): WP_Hook->do_action(Array)\n#8 \/var\/www\/html\/wp-includes\/class-wp.php(387): do_action_ref_array('parse_request', Array)\n#9 \/var\/www\/html\/wp-includes\/class-wp.php(729): WP->parse_request('')\n#10 \/var\/www\/html\/wp-includes\/functions.php(1255): WP->main('')\n#11 \/var\/www\/html\/wp-blog-header.php(16): wp()\n#12 \/var\/www\/html\/index.php(17): require('\/var\/www\/html\/w...')\n#13 {main}"
    }
  }
}

describe('reportRequestError', () => {
  beforeEach(() => {
    console.group.mockClear()
    console.groupEnd.mockClear()
    console.info.mockClear()
  })

  describe('with null error', () => {
    test('returns null message', () => {
      const message = reportRequestError({ error: null })

      expect(message).toBeNull()
    })
  })

  describe('with single fontawesome_client_exception', () => {

    test('emits console report and returns uiMessage from given error', () => {
      const message = reportRequestError({ error: SINGLE_EXCEPTION_ERROR })

      expect(message).toMatch(/^Whoops/)
      // The top-level group, and then one error group
      expect(console.group).toHaveBeenCalledTimes(2)
      expect(console.info).toHaveBeenCalledTimes(1)

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/message: Whoops/),
      )

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/trace:/)
      )

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/status:/),
      )
      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/code: fontawesome_client_exception/)
      )

      expect(console.groupEnd).toHaveBeenCalledTimes(2)
    })
  })

  describe('when PreferenceRegistrationException is thrown with a previous exception', () => {
    const error = {
      errors: {
        fontawesome_server_exception: ["A theme or plugin registered with Font Awesome threw an exception."],
        previous_exception: ["epsilon-plugin throwing"]
      },
      error_data: {
        fontawesome_server_exception: {
          status:500,
          trace:"#0 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome.php(1057): FortAwesome\\FontAwesome_Exception::with_thrown(Object(Exception))\n#1 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(80): FortAwesome\\FontAwesome->gather_preferences()\n#2 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(134): FortAwesome\\FontAwesome_Config_Controller->build_item(Object(FortAwesome\\FontAwesome))\n#3 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(946): FortAwesome\\FontAwesome_Config_Controller->update_item(Object(WP_REST_Request))\n#4 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(329): WP_REST_Server->dispatch(Object(WP_REST_Request))\n#5 \/var\/www\/html\/wp-includes\/rest-api.php(305): WP_REST_Server->serve_request('\/font-awesome\/v...')\n#6 \/var\/www\/html\/wp-includes\/class-wp-hook.php(288): rest_api_loaded(Object(WP))\n#7 \/var\/www\/html\/wp-includes\/class-wp-hook.php(312): WP_Hook->apply_filters('', Array)\n#8 \/var\/www\/html\/wp-includes\/plugin.php(544): WP_Hook->do_action(Array)\n#9 \/var\/www\/html\/wp-includes\/class-wp.php(387): do_action_ref_array('parse_request', Array)\n#10 \/var\/www\/html\/wp-includes\/class-wp.php(729): WP->parse_request('')\n#11 \/var\/www\/html\/wp-includes\/functions.php(1255): WP->main('')\n#12 \/var\/www\/html\/wp-blog-header.php(16): wp()\n#13 \/var\/www\/html\/index.php(17): require('\/var\/www\/html\/w...')\n#14 {main}"
        },
        previous_exception: {
          status:500,
          trace: "#0 \/var\/www\/html\/wp-includes\/class-wp-hook.php(288): {closure}('')\n#1 \/var\/www\/html\/wp-includes\/class-wp-hook.php(312): WP_Hook->apply_filters('', Array)\n#2 \/var\/www\/html\/wp-includes\/plugin.php(478): WP_Hook->do_action(Array)\n#3 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome.php(1055): do_action('font_awesome_pr...')\n#4 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(80): FortAwesome\\FontAwesome->gather_preferences()\n#5 \/var\/www\/html\/wp-content\/plugins\/font-awesome\/includes\/class-fontawesome-config-controller.php(134): FortAwesome\\FontAwesome_Config_Controller->build_item(Object(FortAwesome\\FontAwesome))\n#6 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(946): FortAwesome\\FontAwesome_Config_Controller->update_item(Object(WP_REST_Request))\n#7 \/var\/www\/html\/wp-includes\/rest-api\/class-wp-rest-server.php(329): WP_REST_Server->dispatch(Object(WP_REST_Request))\n#8 \/var\/www\/html\/wp-includes\/rest-api.php(305): WP_REST_Server->serve_request('\/font-awesome\/v...')\n#9 \/var\/www\/html\/wp-includes\/class-wp-hook.php(288): rest_api_loaded(Object(WP))\n#10 \/var\/www\/html\/wp-includes\/class-wp-hook.php(312): WP_Hook->apply_filters('', Array)\n#11 \/var\/www\/html\/wp-includes\/plugin.php(544): WP_Hook->do_action(Array)\n#12 \/var\/www\/html\/wp-includes\/class-wp.php(387): do_action_ref_array('parse_request', Array)\n#13 \/var\/www\/html\/wp-includes\/class-wp.php(729): WP->parse_request('')\n#14 \/var\/www\/html\/wp-includes\/functions.php(1255): WP->main('')\n#15 \/var\/www\/html\/wp-blog-header.php(16): wp()\n#16 \/var\/www\/html\/index.php(17): require('\/var\/www\/html\/w...')\n#17 {main}"
        }
      }
    }

    test('emits console report that includes the previous exception', () => {
      const message = reportRequestError({ error, ok: true })

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

  describe('with single fontawesome_client_exception, no confirmation header, falsePositive, and trimmed garbage', () => {
    const TRIMMED = 'foobar'

    test('emits console report and returns uiMessage from given error', () => {
      const message = reportRequestError({
        error: SINGLE_EXCEPTION_ERROR,
        falsePositive: true,
        trimmed: TRIMMED,
        confirmed: false
      })

      expect(message).toMatch(/^Whoops/)
      // The top-level group, and then one error group, then one for the trimmed content
      expect(console.group).toHaveBeenCalledTimes(3)
      expect(console.group).toHaveBeenCalledWith(
        expect.stringMatching(/Error Report/),
      )
      expect(console.group).toHaveBeenCalledWith(
        expect.stringMatching(/Trimmed/),
      )

      expect(console.groupEnd).toHaveBeenCalledTimes(3)

      expect(console.info).toHaveBeenCalledTimes(4)

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/reported it as a success/),
      )

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/This is a clue/),
      )

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/message: Whoops/),
      )

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/message: Whoops/),
      )

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/trace:/)
      )

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/status:/),
      )

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/code: fontawesome_client_exception/)
      )

      expect(console.info).toHaveBeenCalledWith(
        expect.stringContaining(TRIMMED)
      )
    })
  })

  describe('with no error and when expecting an empty data in the response, as in an HTTP 204', () => {
    const TRIMMED = 'foobar'

    test('emits console report and returns null uiMessage', () => {
      const message = reportRequestError({
        error: null,
        trimmed: TRIMMED,
        expectEmpty: true
      })

      expect(message).toBeNull()
      // The top-level group, and then one for the trimmed content
      expect(console.group).toHaveBeenCalledTimes(2)
      expect(console.group).toHaveBeenCalledWith(
        expect.stringMatching(/Trimmed/),
      )

      expect(console.groupEnd).toHaveBeenCalledTimes(2)

      expect(console.info).toHaveBeenCalledTimes(2)

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/contain no data/),
      )

      expect(console.info).toHaveBeenCalledWith(
        expect.stringContaining(TRIMMED),
      )
    })
  })

  describe('with confirmed error response but no error content', () => {
    test('emits console report and returns null uiMessage', () => {
      const message = reportRequestError({
        error: null
      })

      expect(message).toBeNull()
      expect(console.group).toHaveBeenCalledTimes(1)

      expect(console.groupEnd).toHaveBeenCalledTimes(1)

      expect(console.info).toHaveBeenCalledTimes(1)

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/there was no information about the error/),
      )
    })
  })

  describe('with request data', () => {
    test('adds additional console.info dumping the request', () => {
      const code = 'fontawesome_request_noresponse'
      const error = {
        errors: {
          [code]: [ 'no response' ]
        },
        error_data: {
          [code]: { request: new XMLHttpRequest() }
        }
      }

      const message = reportRequestError({ error })

      expect(message).toEqual('no response')

      // Once for the top-level and again for the error sub group
      expect(console.group).toHaveBeenCalledTimes(2)

      expect(console.groupEnd).toHaveBeenCalledTimes(2)

      expect(console.info).toHaveBeenCalledTimes(2)
    })
  })

  describe('with failedRequestMessage', () => {
    test('adds additional console.info with the message', () => {
      const code = 'fontawesome_request_failed'
      const error = {
        errors: {
          [code]: [ 'ui failure message' ]
        },
        error_data: {
          [code]: { failedRequestMessage: 'failure console message' }
        }
      }

      const message = reportRequestError({ error })

      expect(message).toEqual('ui failure message')

      // Once for the top-level and again for the error sub group
      expect(console.group).toHaveBeenCalledTimes(2)

      expect(console.groupEnd).toHaveBeenCalledTimes(2)

      expect(console.info).toHaveBeenCalledTimes(2)

      expect(console.info).toHaveBeenCalledWith(
        expect.stringMatching(/failure console message/)
      )
    })
  })
})
