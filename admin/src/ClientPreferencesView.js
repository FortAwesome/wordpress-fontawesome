import { useSelector } from 'react-redux'
import styles from './ClientPreferencesView.module.css'
import sharedStyles from './App.module.css'
import find from 'lodash/find'
import has from 'lodash/has'
import size from 'lodash/size'
import classnames from 'classnames'
import { __, sprintf } from '@wordpress/i18n'
import React from 'react'

const UNSPECIFIED_INDICATOR = '-'

function formatVersionPreference(versionPreference = []) {
  return versionPreference
    .map(pref => `${pref[1]}${pref[0]}`)
    .join(
      sprintf(
        /* translators: 1: space */
        __('%1$sand%1$s'),
        ' '
      )
    )
}

export default function ClientPreferencesView() {
  const clientPreferences = useSelector(state => state.clientPreferences)
  const conflicts = useSelector(state => state.preferenceConflicts)
  const hasAdditionalClients = size(clientPreferences)
  const hasConflicts = size(conflicts)

  return <div className={ styles['client-requirements'] }>
    <h3 className={ sharedStyles['section-title'] }>{ __( 'Registered themes or plugins', 'font-awesome' ) }</h3>
    {
      hasAdditionalClients
      ?
        <div>
          <p className={sharedStyles['explanation']}>
            {
              __(
                'Below is the list of active themes or plugins using Font Awesome that have opted-in to share information about the settings they are expecting.',
                'font-awesome'
              )
            }
            
          { hasConflicts
            ? <span className={sharedStyles['explanation']}>
              { __( 'The highlights show where the settings are mismatched. You might want to adjust your settings to match, or your icons may not work as expected.', 'font-awesome' ) }
            </span>
            : null
          }</p>
          <table className={ classnames( 'widefat', 'striped' ) }>
            <thead>
              <tr className={ sharedStyles['table-header'] }>
                <th>{ __( 'Name', 'font-awesome' ) }</th>
                <th className={ classnames({ [styles.conflicted]: !! conflicts['usePro'] }) }>{ __( 'Icons', 'font-awesome' ) }</th>
                <th className={ classnames({ [styles.conflicted]: !! conflicts['technology'] }) }>{ __( 'Technology', 'font-awesome' ) }</th>
                <th className={ classnames({ [styles.conflicted]: !! conflicts['version'] }) }>{ __( 'Version', 'font-awesome' ) }</th>
                <th className={ classnames({ [styles.conflicted]: !! conflicts['v4Compat'] }) }>{ __( 'V4 Compat', 'font-awesome' ) }</th>
                <th className={ classnames({ [styles.conflicted]: !! conflicts['pseudoElements'] }) }>{ __( 'CSS Pseudo-elements', 'font-awesome' ) }</th>
              </tr>
            </thead>
            <tbody>
            {
              Object.values(clientPreferences).map((client, index)  => {
                const clientHasConflict = optionName => !!find(conflicts[optionName], c => c === client.name)

                return <tr key={ index }>
                  <td>{ client.name }</td>
                  <td
                    className={
                      classnames({ [styles.conflicted]: clientHasConflict('usePro') })
                    }>
                    { has(client, 'usePro')
                      ? client.usePro ? 'Pro' : 'Free'
                      : UNSPECIFIED_INDICATOR
                    }
                  </td>
                  <td
                    className={ classnames({ [styles.conflicted]: clientHasConflict('technology') }) }>
                    { has(client, 'technology')
                      ? client.technology
                      : UNSPECIFIED_INDICATOR
                    }
                  </td>
                  <td
                    className={ classnames({ [styles.conflicted]: clientHasConflict('version') }) }>
                    { has(client, 'version')
                      ? formatVersionPreference(client.version)
                      : UNSPECIFIED_INDICATOR
                    }
                  </td>
                  <td
                    className={ classnames({ [styles.conflicted]: clientHasConflict('v4Compat') }) }>
                    { has(client, 'v4Compat')
                      ? client.v4Compat ? 'true' : 'false'
                      : UNSPECIFIED_INDICATOR
                    }
                  </td>
                  <td
                    className={ classnames({ [styles.conflicted]: clientHasConflict('pseudoElements') }) }>
                    { has(client, 'pseudoElements')
                      ? client.pseudoElements ? 'true' : 'false'
                      : UNSPECIFIED_INDICATOR
                    }
                  </td>
                </tr>
              })
            }
            </tbody>
          </table>
        </div>
      :
        <p className={ sharedStyles['explanation'] }>
          { __( 'No active themes or plugins have requested preferences for Font Awesome.', 'font-awesome' ) }
        </p>
    }
  </div>
}
