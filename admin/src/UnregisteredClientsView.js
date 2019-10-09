import React from 'react'
import PropTypes from 'prop-types'
import styles from './UnregisteredClientsView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faThumbsUp } from '@fortawesome/free-solid-svg-icons'
import { get, size } from 'lodash'

const UnregisteredClientsView = props => {

  const detectedUnregisteredClients = size(props.clients) > 0

  return <div className={ classnames(styles['unregistered-clients'], { [styles['none-detected']]: !detectedUnregisteredClients }) }>
    <h2>Unregistered Themes or Plugins</h2>
    {detectedUnregisteredClients
      ? <div>
          <table className={classnames('widefat', 'striped')}>
            <tbody>
            <tr className={sharedStyles['table-header']}>
              <th>Type</th>
              <th>Source or Excerpt</th>
            </tr>
            {
              props.clients.map((client, index) => (
                <tr key={index}>
                  <td>
                    {client.type}
                  </td>
                  <td>
                    {client.src || get(client, 'excerpt', 'UNKNOWN')}
                  </td>
                </tr>
              ))
            }
            </tbody>
          </table>
          <p className={sharedStyles['explanation']}>
            These are plugins or themes we've detected that appear to be trying to load
            their own versions of Font Awesome. Loading more than one version of Font Awesome
            will almost certainly result in problems, eventually.
          </p>
          <p className={sharedStyles['explanation']}>
            We recommend enabling the <code>Remove Conflicts</code> option to avoid
            such conflicts. If you do that and the results
            produced by those unregistered themes or plugins aren't what you expect (for example, their icons are missing),
            then you could try different configuration options here, looking for a configuration
            that <em>is</em> compatible with them. Since they are <em>unregistered</em>, we don't know
            what their requirements are, so you kinda just have to guess.
          </p>
          <p className={sharedStyles['explanation']}>
            A couple other options for resolving problems with an unregistered theme or plugin:
          </p>
          <ol className={ sharedStyles['explanation'] }>
            <li>
              Deactivate or replace it, if possible.
            </li>
            <li>
              Contact the developer for that theme or plugin and ask them to consider updating their
              code to register their preferences with this Font Awesome plugin instead of trying to load their own
              conflicting installation Font Awesome. Let them know they can reach us
              at <code>hello@fontawesome.com</code>.
            </li>
          </ol>
        </div>
      : <div className={ classnames(sharedStyles['explanation'], sharedStyles['flex'], sharedStyles['flex-row'] )}>
          <div>
            <FontAwesomeIcon icon={ faThumbsUp } size='lg'/>
          </div>
          <div className={ sharedStyles['space-left'] }>
            We detected no other plugins or themes loading other versions of Font Awesome.
          </div>
      </div>
    }
  </div>
}

UnregisteredClientsView.propTypes = {
  clients: PropTypes.array.isRequired
}

export default UnregisteredClientsView

