import React from 'react'
import { useSelector, useDispatch } from 'react-redux'
import classnames from 'classnames'
import styles from './FontAwesomeAdminView.module.css'
import SettingsTab from './SettingsTab'
import TroubleshootTab from './TroubleshootTab'
import { ADMIN_TAB_SETTINGS, ADMIN_TAB_TROUBLESHOOT } from './store/reducers'
import { setActiveAdminTab } from './store/actions'
import { __ } from '@wordpress/i18n'

export default function FontAwesomeAdminView() {
  const activeAdminTab = useSelector((state) => state.activeAdminTab || ADMIN_TAB_SETTINGS)
  const dispatch = useDispatch()

  return (
    <div className={classnames(styles['font-awesome-admin-view'])}>
      <h1>Font Awesome</h1>
      <div className={styles['tab-header']}>
        <button
          onClick={() => dispatch(setActiveAdminTab(ADMIN_TAB_SETTINGS))}
          disabled={activeAdminTab === ADMIN_TAB_SETTINGS}
        >
          {__('Settings', 'font-awesome')}
        </button>
        <button
          onClick={() => dispatch(setActiveAdminTab(ADMIN_TAB_TROUBLESHOOT))}
          disabled={activeAdminTab === ADMIN_TAB_TROUBLESHOOT}
        >
          {__('Troubleshoot', 'font-awesome')}
        </button>
      </div>
      {
        {
          [ADMIN_TAB_SETTINGS]: <SettingsTab />,
          [ADMIN_TAB_TROUBLESHOOT]: <TroubleshootTab />
        }[activeAdminTab]
      }
    </div>
  )
}
