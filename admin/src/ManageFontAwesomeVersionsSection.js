import React from 'react'
import styles from './ManageFontAwesomeVersionsSection.module.css'
import sharedStyles from './App.module.css'
import ClientPreferencesView from './ClientPreferencesView'
import classnames from 'classnames'
import { __ } from '@wordpress/i18n'

export default function ManageFontAwesomeVersionsSection() {
  return <div className={ classnames(sharedStyles['explanation'], styles['font-awesome-versions-section']) }>
    <h2 className={ sharedStyles['section-title'] }>{ __( 'Versions of Font Awesome Active on Your Site', 'font-awesome' ) }</h2>
    <p>
      {
        __( 'Registered plugins and themes have opted to share information about the Font Awesome settings they are expecting, and are therefore easier to fix. For the unregistered plugins and themes, which are more unpredictable, we have provided options for you to block their Font Awesome source from loading and causing issues.', 'font-awesome' )
      }
    </p>
    <ClientPreferencesView />
  </div>
}
