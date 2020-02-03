import React from 'react'
import styles from './ManageFontAwesomeVersionsSection.module.css'
import sharedStyles from './App.module.css'
import ClientPreferencesView from './ClientPreferencesView'
import classnames from 'classnames'

export default function ManageFontAwesomeVersionsSection() {
  return <div className={ classnames(sharedStyles['explanation'], styles['font-awesome-versions-section']) }>
    <h2 className={ sharedStyles['section-title'] }>Font Awesome Versions Found on Your Site</h2>
    <p>
    <b> Registered plugins and themes</b> have opted to share information about the
    Font Awesome settings they are expecting, and are therefore easier to fix.
    For the <b>unregistered plugins and themes</b>, which are more unpredictable, we
    have provided options for you to block their Font Awesome source from loading and
    causing issues.
    </p>
    <ClientPreferencesView />
  </div>
}
