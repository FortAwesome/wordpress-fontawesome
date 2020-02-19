import React from 'react'
import { mount } from 'enzyme'
import { Provider } from 'react-redux'
import { createStore } from './store'
import ErrorBoundary from './ErrorBoundary'
import TroubleshootTab from './TroubleshootTab'
import { unmountComponentAtNode } from 'react-dom'

describe('TroubleshootTab', () => {
  let wrapper = null

  beforeEach(() => {
    const initialData = JSON.parse(
      '{"apiNonce":"81245cfaf6","apiUrl":"http://localhost:8765/index.php?rest_route=/font-awesome/v1","detectConflictsUntil":"1581103894","unregisteredClients":{"3c937b6d9b50371df1e78b5d70e11512":{"type":"fontawesome-conflict","technology":"webfont","href":"https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css","innerText":"","tagName":"LINK","blocked":true},"c604f60e1488e3c3493a19a43709b4ca":{"type":"fontawesome-conflict","technology":"webfont","href":"http://localhost:8765/wp-content/plugins/plugin-kappa/font-awesome-4.7.0/css/font-awesome.css","innerText":"","tagName":"LINK","blocked":true}},"showConflictDetectionReporter":"","settingsPageUrl":"http://localhost:8765/wp-admin/options-general.php?page=font-awesome","activeAdminTab":"ADMIN_TAB_TROUBLESHOOT","options":{"usePro":false,"v4Compat":true,"technology":"webfont","svgPseudoElements":false,"version":"5.12.1"},"showAdmin":"1","onSettingsPage":"1","clientPreferences":{"beta-plugin":{"name":"beta-plugin","v4Compat":true,"version":[["5.1.0",">="]],"releases":{"available":["5.12.1","5.12.0","5.11.2","5.11.1","5.11.0","5.10.2","5.10.1","5.10.0","5.9.0","5.8.2","5.8.1","5.8.0","5.7.2","5.7.1","5.7.0","5.6.3","5.6.1","5.6.0","5.5.0","5.4.2","5.4.1","5.3.1","5.2.0","5.1.1","5.1.0","5.0.13","5.0.12","5.0.10","5.0.9","5.0.8","5.0.6","5.0.4","5.0.3","5.0.2","5.0.1"],"latest_version":"5.12.1"},"pluginVersion":"4.0.0-rc13","preferenceConflicts":[],"v3DeprecationWarning":""}'
    )

    global['__FontAwesomeOfficialPlugin__'] = initialData

    const store = createStore(initialData)

    wrapper = mount(
      <ErrorBoundary>
        <Provider store={ store }>
          <TroubleshootTab/>
        </Provider>
      </ErrorBoundary>
    )
  })

  afterEach(() => {
    wrapper.unmount()
    wrapper = null
  })

  test('mounts successfully', () => {
    expect(wrapper).toBeTruthy()
  })

  describe('when starting with all conflicts blocked', () => {
    beforeEach(() => {
      // Assert expectations of the state of the data
      const inputs = [
        'block_all_detected_conflicts',
        'block_3c937b6d9b50371df1e78b5d70e11512',
        'block_c604f60e1488e3c3493a19a43709b4ca'
      ]

      inputs.forEach(id => {
        expect(
          wrapper
            .find(`#${id}`)
            .first()
            .props()
            .checked
        ).toBe(true)
      })

      expect(
        wrapper.find('#submit').props().disabled
      ).toBe(true)
    })

    describe('when de-selecting and re-selecting an individual conflict for blocking', () => {
      test('there are no pending changes shown', () => {
        // change/click one of the conflicts
        wrapper.find('#block_c604f60e1488e3c3493a19a43709b4ca').simulate('change')

        // That one should now be unchecked
        expect(
          wrapper
            .find('#block_c604f60e1488e3c3493a19a43709b4ca')
            .first()
            .props()
            .checked
        ).toBe(false)

        // The All select should no longer be checked
        expect(
          wrapper
            .find('#block_all_detected_conflicts')
            .first()
            .props()
            .checked
        ).toBe(false)

        // And there should be pending changes
        expect(
          wrapper.find('#submit').props().disabled
        ).toBe(false)

        // Now, just click/change that same one again
        wrapper.find('#block_c604f60e1488e3c3493a19a43709b4ca').simulate('change')

        // That one should now be checked
        expect(
          wrapper
            .find('#block_c604f60e1488e3c3493a19a43709b4ca')
            .first()
            .props()
            .checked
        ).toBe(true)

        // The All select should be checked again
        expect(
          wrapper
            .find('#block_all_detected_conflicts')
            .first()
            .props()
            .checked
        ).toBe(true)

        // And the submit button should again be disabled, for lack of pending changes
        expect(
          wrapper.find('#submit').props().disabled
        ).toBe(true)
      })
    })
  })
})
