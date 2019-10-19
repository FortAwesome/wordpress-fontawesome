import React from 'react'
import { useSelector, useDispatch } from 'react-redux'
import classnames from 'classnames'
import styles from './FontAwesomeAdminView.module.css'
import Options from './Options'
import ClientPreferencesView from './ClientPreferencesView'
import UnregisteredClientsView from './UnregisteredClientsView'
import PluginVersionWarningsView from './PluginVersionWarningsView'
import V3DeprecationWarning from './V3DeprecationWarning'
import { values, get, size } from 'lodash'
import ReleaseProviderWarning from './ReleaseProviderWarning'
import SettingsTab from './SettingsTab'
import TroubleshootTab from './TroubleshootTab'
import { ADMIN_TAB_SETTINGS, ADMIN_TAB_TROUBLESHOOT } from './store/reducers'
import { setActiveAdminTab } from './store/actions'
import PseudoElementsHelp from './PseudoElementsHelp'

export default function FontAwesomeAdminView() {
  const activeAdminTab = useSelector(state => state.activeAdminTab )
  const releaseProviderStatus = useSelector(state => state.releaseProviderStatus)
  const dispatch = useDispatch()

  const releaseProviderStatusOK = useSelector(state => {
    // If releaseProviderStatus is null, it means that a network request was never issued.
    // We take that to mean that it's using a cached set of release metadata, which is OK.
    const status = releaseProviderStatus || null
    const code = get(status, 'code', 0)

    // If the status is not null, then the (HTTP) code for that network request should be in the OK range.
    return status === null || (code >= 200 && code <= 300)
  })

  const hasV3DeprecationWarning = useSelector(state => !!state.v3DeprecationWarning)
  const showingPseudoElementsHelp = useSelector(state => state.showingPseudoElementsHelp)
  const unregisteredClients = useSelector(state => state.unregisteredClients)
  const pluginVersionWarnings = useSelector(state => values( state.pluginVersionWarnings ))
  const pluginVersion = useSelector(state => state.pluginVersion)

  return ( 
    <div className={ classnames(styles['font-awesome-admin-view'], { [ styles['blur'] ]: showingPseudoElementsHelp }) }>
      { 
        showingPseudoElementsHelp
        ? <PseudoElementsHelp/>
        : null
      }
      <h1>Font Awesome</h1>
      <div className={styles['tab-header']}>
        <button 
          onClick={() => dispatch(setActiveAdminTab(ADMIN_TAB_SETTINGS))}
          disabled={ activeAdminTab === ADMIN_TAB_SETTINGS }
        >
          Settings
        </button>
        <button
          onClick={() => dispatch(setActiveAdminTab(ADMIN_TAB_TROUBLESHOOT))}
          disabled={ activeAdminTab === ADMIN_TAB_TROUBLESHOOT }
        >
          Troubleshoot
        </button>
      </div>
      {
        {
          [ADMIN_TAB_SETTINGS]: <SettingsTab/>,
          [ADMIN_TAB_TROUBLESHOOT]: <TroubleshootTab/>
        }[activeAdminTab]
      }
      <div>
        { hasV3DeprecationWarning && <V3DeprecationWarning /> }
        { releaseProviderStatusOK || <ReleaseProviderWarning /> }
        <Options />
        <ClientPreferencesView />
        <UnregisteredClientsView clients={ unregisteredClients }/>
        {
          size(pluginVersionWarnings) > 0
          ? <PluginVersionWarningsView warnings={ pluginVersionWarnings } pluginVersion={ pluginVersion }/>
          : null
        }
      </div>
    </div>
  )
}
