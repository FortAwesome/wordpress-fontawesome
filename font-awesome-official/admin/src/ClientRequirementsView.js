import React from 'react'
import styles from './ClientRequirementsView.module.css'
import sharedStyles from './App.module.css'
import { find } from 'lodash'
import classnames from 'classnames'
import PropTypes from 'prop-types'

const ADMIN_USER_CLIENT_NAME = 'user'
// TODO: refactor this with the one in OptionsSetter
const UNSPECIFIED_INDICATOR = '-'

class ClientRequirementsView extends React.Component {

  hasAdditionalClients() {
    return !!find(this.props.clientRequirements, client => client.name !== ADMIN_USER_CLIENT_NAME )
  }

  render() {
    return <div className={ styles['client-requirements'] }>
      <h2>Client Requirements</h2>
      {
        this.hasAdditionalClients()
        ?
          <div>
            <p className={ sharedStyles['explanation'] }>
              Here are some other clients of the Font Awesome plugin, such as plugins or themes,
              along with their Font Awesome requirements shown side-by-side with your preferences.
              If you're trying to resolve a conflict, you might find the culprit at a glance here.
            </p>
            <table className={ classnames( 'widefat', 'striped' ) }>
              <tbody>
              <tr className={ sharedStyles['table-header'] }>
                <th>Name</th><th>Method</th><th>Version</th><th>V4 Compat</th><th>Pseudo-elements</th>
              </tr>
              {
                this.props.clientRequirements.map((client, index)  => {
                  return <tr key={ index }>
                    <td>{ client.name }</td>
                    <td>{ client.method ? client.method : UNSPECIFIED_INDICATOR }</td>
                    <td>{ client.version ? client.version : UNSPECIFIED_INDICATOR }</td>
                    <td>{ client.v4shim ? client.v4shim : UNSPECIFIED_INDICATOR }</td>
                    <td>{ client['pseudo-elements'] ? client['pseudo-elements'] : UNSPECIFIED_INDICATOR }</td>
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
  clientRequirements: PropTypes.array.isRequired
}
