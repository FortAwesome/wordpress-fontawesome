import React from 'react'
import { useSelector, useDispatch } from 'react-redux'
import { addPendingOption, submitPendingOptions } from './store/actions'
import PropTypes from 'prop-types'
import styles from './UnregisteredClientsView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import {
  faCheck,
  faSkull,
  faSpinner,
  faCheckSquare,
  faSquare,
  faThumbsUp } from '@fortawesome/free-solid-svg-icons'
import get from 'lodash/get'
import size from 'lodash/size'
import has from 'lodash/has'

export default function UnregisteredClientsView(props) {
  const dispatch = useDispatch()

  const optionSelector = option => useSelector(state => 
    has(state.pendingOptions, option)
    ? state.pendingOptions[option]
    : state.options[option]
  )
  const blacklist = optionSelector('blacklist')
  const pendingOptions = useSelector(state => state.pendingOptions)
  const hasSubmitted = useSelector(state => state.optionsFormState.hasSubmitted)
  const submitSuccess = useSelector(state => state.optionsFormState.success)
  const submitMessage = useSelector(state => state.optionsFormState.message)
  const isSubmitting = useSelector(state => state.optionsFormState.isSubmitting)
  const detectedUnregisteredClients = size(Object.keys(props.clients)) > 0

  function handleSubmitClick(e) {
    e.preventDefault()

    dispatch(submitPendingOptions())
  }

  function handleBlockSelection(change = {}) {
    dispatch(addPendingOption(change))
  }

  function isCheckedForBlocking(md5) {
    return !! blacklist.find(x => x === md5)
  }

  function changeCheckForBlocking(md5) {
    const newBlacklist = isCheckedForBlocking(md5)
      ? blacklist.filter(x => x !== md5)
      : [...blacklist, md5]
    
    handleBlockSelection({ blacklist: newBlacklist })
  }

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
                      checked={ isCheckedForBlocking(md5) }
                      onChange={ () => changeCheckForBlocking(md5) }
                      className={ classnames(sharedStyles['sr-only'], sharedStyles['input-checkbox-custom']) }
                    />
                    <label htmlFor={`block_${md5}`} className={ styles['checkbox-label'] }>
                      <span className={ sharedStyles['relative'] }>
                        <FontAwesomeIcon
                          icon={ faCheckSquare }
                          className={ sharedStyles['checked-icon'] }
                          size="lg"
                          fixedWidth
                        />
                        <FontAwesomeIcon
                          icon={ faSquare }
                          className={ sharedStyles['unchecked-icon'] }
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
          <div className="submit">
            <input
              type="submit"
              name="submit"
              id="submit"
              className="button button-primary"
              value="Save Changes"
              disabled={ size(pendingOptions) === 0 }
              onClick={ handleSubmitClick }
            />
            { hasSubmitted 
              ? submitSuccess
                ? <span className={ classnames(styles['submit-status'], styles['success']) }>
                    <FontAwesomeIcon className={ styles['icon'] } icon={ faCheck } />
                  </span>
                : <div className={ classnames(styles['submit-status'], styles['fail']) }>
                    <div className={ classnames(styles['fail-icon-container']) }>
                      <FontAwesomeIcon className={ styles['icon'] } icon={ faSkull } />
                    </div>
                    <div className={ styles['explanation'] }>
                      { submitMessage }
                    </div>
                  </div>
              : null
            }
            {
              size(pendingOptions) > 0
              ? <span className={ styles['submit-status'] }>you have pending changes</span>
              : isSubmitting &&
                  <span className={ classnames(styles['submit-status'], styles['submitting']) }>
                    <FontAwesomeIcon className={ styles['icon'] } icon={faSpinner} spin/>
                  </span>
            }
          </div>
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
