import React from 'react'
import styles from './ManageFontAwesomeVersionsSection.module.css'
import sharedStyles from './App.module.css'
import ClientPreferencesView from './ClientPreferencesView'
import classnames from 'classnames'
import { __, sprintf } from '@wordpress/i18n'
import { __experimentalCreateInterpolateElement } from '@wordpress/element'

export default function ManageFontAwesomeVersionsSection() {
  return <div className={ classnames(sharedStyles['explanation'], styles['font-awesome-versions-section']) }>
    <h2 className={ sharedStyles['section-title'] }>{ __( 'Versions of Font Awesome Active on Your Site', 'font-awesome' ) }</h2>
    <p>
      {
        __experimentalCreateInterpolateElement(
          sprintf(
            __( '<b>Registered plugins and themes</b> have opted to share information about the Font Awesome settings they are expecting, and are therefore easier to fix. For the <b>unregistered plugins and themes</b>, which are more unpredictable, we have provided options for you to block their Font Awesome source from loading and causing issues.', 'font-awesome' )
          ),
          {
            b: <b />
          }
        )
      }
    </p>
    <ClientPreferencesView />
  </div>
}
