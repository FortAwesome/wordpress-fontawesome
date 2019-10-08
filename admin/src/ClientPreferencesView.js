import React from 'react'
import styles from './ClientPreferencesView.module.css'
import sharedStyles from './App.module.css'
import { find, has, size } from 'lodash'
import classnames from 'classnames'
import PropTypes from 'prop-types'

// TODO: refactor this with the one in OptionsSetter
const UNSPECIFIED_INDICATOR = '-'

class ClientPreferencesView extends React.Component {

  hasAdditionalClients() {
    return size(this.props.clientPreferences) > 0
  }

  hasConflicts() {
    return size(this.props.conflicts) > 0
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
            <p className={sharedStyles['explanation']}>
              These are other active plugins or themes that depend on this plugin, along with their Font Awesome preferences.
            </p>
            { this.hasConflicts() &&
              <p className={sharedStyles['explanation']}>
                We've highlighted those preferences that differ from the options you've configured.
                It's best to reconfigure the options in order to satisfy these, if possible.
                A theme or plugin whose preferences aren't satisfied will probably not work as expected.
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
  conflicts: PropTypes.object.isRequired
}
