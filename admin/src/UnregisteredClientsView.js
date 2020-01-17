import React from 'react'
import PropTypes from 'prop-types'
import styles from './UnregisteredClientsView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import {
  faCheckSquare,
  faSquare,
  faThumbsUp } from '@fortawesome/free-solid-svg-icons'
import get from 'lodash/get'
import size from 'lodash/size'

const UnregisteredClientsView = props => {

  const detectedUnregisteredClients = size(Object.keys(props.clients)) > 0

  return <div className={ classnames(styles['unregistered-clients'], { [styles['none-detected']]: !detectedUnregisteredClients }) }>
    <h2>Other themes or plugins</h2>
    {detectedUnregisteredClients
      ? <div>
          <p className={sharedStyles['explanation']}>
            Below is the list of other versions of Font Awesome from active
            plugins or themes that are loading on your site. Check off any that
            you would like to block from loading. Normally this just blocks the
            conflicting version of Font Awesome and doesn't affect the other
            functions of the plugin, but you should verify your site works as expected.
          </p>
          <table className={classnames('widefat', 'striped')}>
            <tbody>
            <tr className={sharedStyles['table-header']}>
              <th>Block</th>
              <th>Type</th>
              <th>URL</th>
            </tr>
            {
              Object.keys(props.clients).map(md5 => (
                <tr key={md5}>
                  <td>
                    <input
                      id={`block_${md5}`}
                      name={`block_${md5}`}
                      type="checkbox"
                      value={ md5 }
                      checked={ true }
                      onChange={ () => console.log('changed') }
                      className={ classnames(sharedStyles['sr-only'], sharedStyles['input-radio-custom']) }
                    />
                    <label htmlFor={`block_${md5}`} className={ styles['option-label'] }>
                      <span className={ sharedStyles['relative'] }>
                        <FontAwesomeIcon
                          icon={ faCheckSquare }
                          className={ styles['checked-icon'] }
                          size="lg"
                          fixedWidth
                        />
                        <FontAwesomeIcon
                          icon={ faSquare }
                          className={ styles['unchecked-icon'] }
                          size="lg"
                          fixedWidth
                        />
                      </span>
                    </label>
                  </td>
                  <td>
                    {props.clients[md5].type}
                  </td>
                  <td>
                    {props.clients[md5].src || props.clients[md5].href || get(props.clients[md5], 'excerpt', 'UNKNOWN')}
                  </td>
                </tr>
              ))
            }
            </tbody>
          </table>
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
  clients: PropTypes.object.isRequired
}

export default UnregisteredClientsView

