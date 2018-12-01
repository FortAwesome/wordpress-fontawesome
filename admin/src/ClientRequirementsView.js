import React from 'react'
import styles from './ClientRequirementsView.module.css'
import sharedStyles from './App.module.css'
import { find } from 'lodash'
import classnames from 'classnames'
import PropTypes from 'prop-types'

// TODO: refactor this with the one in OptionsSetter
const UNSPECIFIED_INDICATOR = '-'

class ClientRequirementsView extends React.Component {

  hasAdditionalClients() {
    return !!find(this.props.clientRequirements, client => client.name !== this.props.adminClientInternal )
  }

  render() {
    const { conflict, hasLockedLoadSpec } = this.props

    const hasConflict = !!conflict

    return <div className={ styles['client-requirements'] }>
      {
        hasConflict
        ? <h2>Conflicting Requirements</h2>
        : <h2>Client Requirements</h2>
      }
      {
        this.hasAdditionalClients()
        ?
          <div>
            { hasConflict
              ? <div>
                  <p className={sharedStyles['explanation']}>
                  We found conflicting requirements between two or more plugins or themes, shown below.
                  </p>
                { hasLockedLoadSpec
                  ? <p className={sharedStyles['explanation']}>
                    We'll continue to load the last good load specification you've locked in, so things will
                    keep working the way they've been working. However, until you resolve the conflict, whatever
                    clients have introduced these new conflicting requirements may not work as expected.
                    </p>
                  : <p className={sharedStyles['explanation']}>
                    Since you haven't yet locked in a working configuration, we can't load Font Awesome at all.
                    So, until you resolve these conflicts, Font Awesome won't work!
                    </p>
                }
                </div>
              : <p className={sharedStyles['explanation']}>
                Here are some other clients of the Font Awesome plugin, such as plugins or themes,
                along with their Font Awesome requirements shown side-by-side with your preferences.
                If you're trying to resolve a conflict, you might find the culprit at a glance here.
              </p>
            }
            <table className={ classnames( 'widefat', 'striped' ) }>
              <thead>
                <tr className={ sharedStyles['table-header'] }>
                  <th>Name</th>
                  <th className={ classnames({ [styles.conflicted]: 'method' === conflict }) }>Method</th>
                  <th className={ classnames({ [styles.conflicted]: 'version' === conflict }) }>Version</th>
                  <th className={ classnames({ [styles.conflicted]: 'v4shim' === conflict }) }>V4 Compat</th>
                  <th className={ classnames({ [styles.conflicted]: 'pseudoElements' === conflict }) }>Pseudo-elements</th>
                </tr>
              </thead>
              <tbody>
              {
                this.props.clientRequirements.map((client, index)  => {
                  return <tr key={ index }>
                    <td>{ client.name === this.props.adminClientInternal ? this.props.adminClientExternal : client.name }</td>
                    <td className={ classnames({ [styles.conflicted]: 'method' === conflict }) }>{ client.method ? client.method : UNSPECIFIED_INDICATOR }</td>
                    <td className={ classnames({ [styles.conflicted]: 'version' === conflict }) }>{ client.version ? client.version : UNSPECIFIED_INDICATOR }</td>
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
            We don't detect any other active clients (like themes or plugins) that have registered
            requirements for Font Awesome.
          </p>
      }
    </div>
  }
}

export default ClientRequirementsView

ClientRequirementsView.propTypes = {
  clientRequirements: PropTypes.array.isRequired,
  hasLockedLoadSpec: PropTypes.boolean,
  conflict: PropTypes.string,
  adminClientInternal: PropTypes.string.isRequired,
  adminClientExternal: PropTypes.string.isRequired
}
