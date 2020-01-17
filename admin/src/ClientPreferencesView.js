import React from 'react'
import { useSelector } from 'react-redux'
import styles from './ClientPreferencesView.module.css'
import sharedStyles from './App.module.css'
import find from 'lodash/find'
import has from 'lodash/has'
import size from 'lodash/size'
import classnames from 'classnames'

// TODO: refactor this with the one in OptionsSetter
const UNSPECIFIED_INDICATOR = '-'

function formatVersionPreference(versionPreference = []) {
  return versionPreference
    .map(pref => `${pref[1]}${pref[0]}`)
    .join(' and ')
}

export default function ClientPreferencesView() {
  const clientPreferences = useSelector(state => state.clientPreferences)
  const conflicts = useSelector(state => state.preferenceConflicts)
  const hasAdditionalClients = size(clientPreferences)
  const hasConflicts = size(conflicts)

  return <div className={ styles['client-requirements'] }>
    <h2>Registered themes or plugins</h2>
    {
      hasAdditionalClients
      ?
        <div>
          <p className={sharedStyles['explanation']}>
            Below is the list of active themes or plugins that have opted-in (registered) to use your settings in this plugin, and their Font Awesome preferences.
          </p>
          { hasConflicts
            ? <p className={sharedStyles['explanation']}>
              We've highlighted those preferences that differ from the options you've configured.
              It's best to reconfigure the options in order to satisfy these, if possible.
              A theme or plugin whose preferences aren't satisfied may not work as expected.
            </p>
            : null
          }
          <table className={ classnames( 'widefat', 'striped' ) }>
            <thead>
              <tr className={ sharedStyles['table-header'] }>
                <th>Name</th>
                <th className={ classnames({ [styles.conflicted]: !! conflicts['usePro'] }) }>Icons</th>
                <th className={ classnames({ [styles.conflicted]: !! conflicts['technology'] }) }>Technology</th>
                <th className={ classnames({ [styles.conflicted]: !! conflicts['version'] }) }>Version</th>
                <th className={ classnames({ [styles.conflicted]: !! conflicts['v4compat'] }) }>V4 Compat</th>
                <th className={ classnames({ [styles.conflicted]: !! conflicts['svgPseudoElements'] }) }>SVG Pseudo-elements</th>
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
                    className={ classnames({ [styles.conflicted]: clientHasConflict('v4compat') }) }>
                    { has(client, 'v4compat')
                      ? client.v4compat ? 'true' : 'false'
                      : UNSPECIFIED_INDICATOR
                    }
                  </td>
                  <td
                    className={ classnames({ [styles.conflicted]: clientHasConflict('svgPseudoElements') }) }>
                    { has(client, 'svgPseudoElements')
                      ? client.svgPseudoElements ? 'true' : 'false'
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
          No active theme or plugins have registered preferences for Font Awesome.
        </p>
    }
  </div>
}
