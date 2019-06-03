import React from 'react'
import styles from './ClientPreferencesView.module.css'
import sharedStyles from './App.module.css'
import { get } from 'lodash'
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

  render() {
    // TODO: remove temporary hack
    const conflict = null

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
                Here are some other active plugins or themes,
                along with their Font Awesome preferences, shown side-by-side with your configured options.
                If you're trying to resolve a problem with one of them, you might find a clue here.
              </p>
            }
            <table className={ classnames( 'widefat', 'striped' ) }>
              <thead>
                <tr className={ sharedStyles['table-header'] }>
                  <th>Name</th>
                  <th className={ classnames({ [styles.conflicted]: 'method' === conflict }) }>Method</th>
                  <th className={ classnames({ [styles.conflicted]: 'v4shim' === conflict }) }>V4 Compat</th>
                  <th className={ classnames({ [styles.conflicted]: 'pseudoElements' === conflict }) }>Pseudo-elements</th>
                </tr>
              </thead>
              <tbody>
              {
                this.props.clientPreferences.map((client, index)  => {
                  return <tr key={ index }>
                    <td>{ client.name === this.props.adminClientInternal ? this.props.adminClientExternal : client.name }</td>
                    <td className={ classnames({ [styles.conflicted]: 'method' === conflict }) }>{ client.method ? client.method : UNSPECIFIED_INDICATOR }</td>
                    <td className={ classnames({ [styles.conflicted]: 'v4shim' === conflict }) }>{ client.v4shim ? client.v4shim : UNSPECIFIED_INDICATOR }</td>
                    <td className={ classnames({ [styles.conflicted]: 'pseudoElements' === conflict }) }>{ client.pseudoElements ? client.pseudoElements : UNSPECIFIED_INDICATOR }</td>
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
