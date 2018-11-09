import React from 'react'
import PropTypes from 'prop-types'
import styles from './UnregisteredClientsView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'

const UnregisteredClientsView = props => {
  return <div className={styles['unregistered-clients']}>
    <h2>Unregistered Clients</h2>
    <p className={ sharedStyles['explanation'] }>
      These are plugins or themes we've detected that appear to be trying to load
      their own versions of Font Awesome. Loading more than one version of Font Awesome
      will almost certainly result in problems, eventually. So, even if all registered
      clients are satisfied with your configuration, they can be broken by an
      unexpected version of Font Awesome loaded by one of these unregistered clients.
    </p>
    <p className={ sharedStyles['explanation'] }>
      We recommend enabling the <code>Remove unregistered clients</code> option to avoid
      such conflicts. When enabled, our plugin will attempt to stop these other clients from loading
      their own versions of Font Awesome. Most likely, they will continue to operate normally,
      as long as they are compatible with the version configured here.
    </p>
    <p className={ sharedStyles['explanation'] }>
      If you enable <code>Remove unregistered clients</code> and the results
      produced by those unregistered clients aren't what you expect (for example, their icons are missing),
      then you could try to select different options here, trying to find a configuration
      that <em>is</em> compatible with them. Since they are <em>unregistered</em> clients, we don't know
      what their requirements are, so you kinda just have to guess. You'll know you've found a workable
      configuration when all of the registered clients are satisfied (no conflicts shown here),
      and the unregistered clients produce expected results (their icons look right to you).
    </p>
    <p className={ sharedStyles['explanation'] }>
      A couple other options for resolving problems with unregistered clients:
      <ol>
        <li>
          Disable it if you don't need it. If it's a plugin you don't need, deactivate and remove it.
          If it's a theme you can replace with another one that doesn't create a conflict, replace it.
        </li>
        <li>
          Contact the developer for the unregistered client and ask them to consider updating their
          code to register with this Font Awesome Official plugin. Let them know they can reach us
          at <code>hello@fontawesome.com</code>.
        </li>
      </ol>
    </p>
    <table className={ classnames('widefat', 'striped') }>
      <tbody>
      <tr className={ sharedStyles['table-header'] }>
        <th>Name</th>
        <th>Type</th>
        <th>Loading</th>
      </tr>
      {
        props.clients.map((client, index) => (
          <tr key={index}>
            <td>
              { client.handle }
            </td>
            <td>
              { client.type }
            </td>
            <td>
              { client.src }
            </td>
          </tr>
        ))
      }
      </tbody>
    </table>
  </div>
}

UnregisteredClientsView.propTypes = {
  clients: PropTypes.array.isRequired
}

export default UnregisteredClientsView

