import React from 'react'
import styles from './ManageFontAwesomeVersionsSection.module.css'
import sharedStyles from './App.module.css'
import ClientPreferencesView from './ClientPreferencesView'
import classnames from 'classnames'

export default function ManageFontAwesomeVersionsSection() {
  return <div className={ classnames(sharedStyles['explanation'], styles['font-awesome-versions-section']) }>
    <h1>Manage Font Awesome versions</h1>
    <p>
    Below is the list of Font Awesome versions being used on your site. You can
    block any or all of the other versions being loaded to prevent issues.
    Normally this allows the plugins or themes to continue displaying icons as
    expected using the version of Font Awesome you've configured in this plugin.
    </p>
    <ClientPreferencesView />
  </div>
}
