import React from 'react'
import { useSelector, useDispatch } from 'react-redux'
import classnames from 'classnames'
import styles from './FontAwesomeAdminView.module.css'
import SettingsTab from './SettingsTab'
import TroubleshootTab from './TroubleshootTab'
import { ADMIN_TAB_SETTINGS, ADMIN_TAB_TROUBLESHOOT } from './store/reducers'
import { setActiveAdminTab } from './store/actions'

export default function FontAwesomeAdminView() {
  const activeAdminTab = useSelector(state => state.activeAdminTab )
  const dispatch = useDispatch()

  return ( 
    <div className={ classnames(styles['font-awesome-admin-view']) }>
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
    </div>
  )
}
