import React from 'react'
import { mount } from 'enzyme'
import { Provider } from 'react-redux'
import { createStore } from './store'
import ErrorBoundary from './ErrorBoundary'
import FontAwesomeAdminView from './FontAwesomeAdminView'

describe('FontAwesomeAdminView', () => {
  test('mounts successfully', () => {
    const initialData = JSON.parse(
      '{"apiNonce":"deadbeef42","apiUrl":"http://localhost:8765/index.php?rest_route=/font-awesome/v1","unregisteredClients":[],"showConflictDetectionReporter":"","settingsPageUrl":"http://localhost:8765/wp-admin/options-general.php?page=font-awesome","detectConflictsUntil":0,"options":{"usePro":false,"v4Compat":true,"technology":"webfont","pseudoElements":false,"version":"5.12.0"},"showAdmin":"1","onSettingsPage":"1","clientPreferences":{"beta-plugin":{"name":"beta-plugin","v4Compat":true}},"releases":{"available":["5.12.0","5.11.2","5.11.1","5.11.0","5.10.2","5.10.1","5.10.0","5.9.0","5.8.2","5.8.1","5.8.0","5.7.2","5.7.1","5.7.0","5.6.3","5.6.1","5.6.0","5.5.0","5.4.2","5.4.1","5.3.1","5.2.0","5.1.1","5.1.0","5.0.13","5.0.12","5.0.10","5.0.9","5.0.8","5.0.6","5.0.4","5.0.3","5.0.2","5.0.1"],"latest_version":"5.12.0"},"pluginVersion":"4.0.0-rc13","preferenceConflicts":[],"v3DeprecationWarning":""}'
    )

    global['__FontAwesomeOfficialPlugin__'] = initialData

    const store = createStore(initialData)

    const wrapper = mount(
      <ErrorBoundary>
        <Provider store={ store }>
          <FontAwesomeAdminView/>
        </Provider>
      </ErrorBoundary>
    )

    expect(wrapper).toBeTruthy()
  })
})
