import React from 'react'
import { mount } from 'enzyme'
import { Provider } from 'react-redux'
import { createStore } from './store'
import ErrorBoundary from './ErrorBoundary'
import TroubleshootTab from './TroubleshootTab'

describe('TroubleshootTab', () => {
  let store = null

  beforeEach(() => {
    const initialData = JSON.parse(
      '{"apiNonce":"81245cfaf6","apiUrl":"http://localhost:8080/index.php?rest_route=/font-awesome/v1","detectConflictsUntil":"1581103894","unregisteredClients":{"3c937b6d9b50371df1e78b5d70e11512":{"type":"fontawesome-conflict","technology":"webfont","href":"https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css","innerText":"","tagName":"LINK","blocked":true},"c604f60e1488e3c3493a19a43709b4ca":{"type":"fontawesome-conflict","technology":"webfont","href":"http://localhost:8080/wp-content/plugins/plugin-kappa/font-awesome-4.7.0/css/font-awesome.css","innerText":"","tagName":"LINK","blocked":true}},"showConflictDetectionReporter":"","settingsPageUrl":"http://localhost:8080/wp-admin/options-general.php?page=font-awesome","activeAdminTab":"ADMIN_TAB_TROUBLESHOOT","options":{"usePro":false,"v4compat":true,"technology":"webfont","svgPseudoElements":false,"version":"5.12.1"},"showAdmin":"1","onSettingsPage":"1","clientPreferences":{"beta-plugin":{"name":"beta-plugin","v4compat":true,"version":[["5.1.0",">="]],"clientCallSite":{"file":"/var/www/html/wp-content/plugins/plugin-beta/plugin-beta.php","line":24}}},"releases":{"available":["5.12.1","5.12.0","5.11.2","5.11.1","5.11.0","5.10.2","5.10.1","5.10.0","5.9.0","5.8.2","5.8.1","5.8.0","5.7.2","5.7.1","5.7.0","5.6.3","5.6.1","5.6.0","5.5.0","5.4.2","5.4.1","5.3.1","5.2.0","5.1.1","5.1.0","5.0.13","5.0.12","5.0.10","5.0.9","5.0.8","5.0.6","5.0.4","5.0.3","5.0.2","5.0.1"],"latest_version":"5.12.1"},"pluginVersion":"4.0.0-rc13","preferenceConflicts":[],"v3DeprecationWarning":""}'
    )

    global['__FontAwesomeOfficialPlugin__'] = initialData

    store = createStore(initialData)
  })

  afterEach(() => {
    store = null
  })

  test('mounts successfully', () => {

    const wrapper = mount(
      <ErrorBoundary>
        <Provider store={ store }>
          <TroubleshootTab/>
        </Provider>
      </ErrorBoundary>
    )

    expect(wrapper).toBeTruthy()
  })
})
