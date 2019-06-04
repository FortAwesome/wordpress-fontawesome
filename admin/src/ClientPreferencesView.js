import React from 'react'
import styles from './ClientPreferencesView.module.css'
import sharedStyles from './App.module.css'
import { find, get, has } from 'lodash'
import classnames from 'classnames'
import PropTypes from 'prop-types'

// TODO: refactor this with the one in OptionsSetter
const UNSPECIFIED_INDICATOR = '-'

class ClientPreferencesView extends React.Component {

  hasAdditionalClients() {
    return get(this.props.clientPreferences, 'length', 0) > 0
  }

  hasConflicts() {
    return get(this.props, ['conflicts', 'length'], 0) > 0
  }

  static formatVersionPreference(versionPreference = []) {
    return versionPreference
      .map(pref => `${pref[1]}${pref[0]}`)
      .join(' and ')
  }

  render() {
    const { conflicts } = this.props

    return <div className={ styles['client-requirements'] }>
      {
        this.hasConflicts()
        ? <h2>Conflicting Preferences</h2>
        : <h2>Other Theme or Plugin Preferences</h2>
      }
      {
        this.hasAdditionalClients()
        ?
          <div>
            { this.hasConflicts()
              ? <div>
                  <p className={sharedStyles['explanation']}>
                  We found conflicting requirements between two or more plugins or themes, shown below.
                  </p>
                </div>
              : <p className={sharedStyles['explanation']}>
                Here are some other active plugins or themes, along with their Font Awesome preferences, highlighting
                conflicts in preferences.
                If you're trying to resolve a problem with one of them, you might find a clue here.
              </p>
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
                this.props.clientPreferences.map((client, index)  => {
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
                        ? ClientPreferencesView.formatVersionPreference(client.version)
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
            We don't detect any other active theme or plugins that have registered
            preferences for Font Awesome.
          </p>
      }
    </div>
  }
}

export default ClientPreferencesView

ClientPreferencesView.propTypes = {
  clientPreferences: PropTypes.array.isRequired,
  conflicts: PropTypes.object
}
