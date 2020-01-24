import React from 'react'
import { useSelector, useDispatch } from 'react-redux'
import has from 'lodash/has'
import size from 'lodash/size'
import { addPendingOption, submitPendingOptions } from './store/actions'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import CheckingOptionStatusIndicator from './CheckingOptionsStatusIndicator'
import {
  faSpinner,
  faCheck,
  faSkull } from '@fortawesome/free-solid-svg-icons'
//import { faCircle, faSquare } from '@fortawesome/free-regular-svg-icons'
import styles from './KitsConfigView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'

const UNSPECIFIED = '-'

export default function KitsConfigView(props) {
  const optionSelector = option => useSelector(state => 
    has(state.pendingOptions, option)
    ? state.pendingOptions[option]
    : state.options[option]
  )

  function handleOptionChange(change = {}) {
    dispatch(addPendingOption(change))
  }

  const dispatch = useDispatch()
  const pendingOptions = useSelector(state => state.pendingOptions)
  const hasSubmitted = useSelector(state => state.optionsFormState.hasSubmitted)
  const submitSuccess = useSelector(state => state.optionsFormState.success)
  const submitMessage = useSelector(state => state.optionsFormState.message)
  const isSubmitting = useSelector(state => state.optionsFormState.isSubmitting)
  const isChecking = useSelector(state => state.preferenceConflictDetection.isChecking)
  /*
  const pendingOptionConflicts = useSelector(state => state.pendingOptionConflicts)
  const hasChecked = useSelector(state => state.preferenceConflictDetection.hasChecked)
  const preferenceCheckSuccess = useSelector(state => state.preferenceConflictDetection.success)
  const preferenceCheckMessage = useSelector(state => state.preferenceConflictDetection.message)  
  */

  const kitToken = optionSelector('kitToken')
  //const apiToken = optionSelector('apiToken')
  const hasSavedApiToken = useSelector(state => !! state.options.apiToken)
  const pendingApiToken = useSelector(state => state.pendingOptions['apiToken'])

  function ApiTokenInput() {
    return <>
      <label htmlFor="api_token" className={ styles['option-label'] }>
        API Token
      </label>
      <input
        id="api_token"
        name="api_token"
        type="password"
        placeholder="api token here"
        value={ pendingApiToken }
        size="20"
        onChange={ e => {
          e.preventDefault()
          e.stopPropagation()
          handleOptionChange({ apiToken: e.target.value }) 
        }}
      />
    </>
  }

  const kitOptions = useSelector(state => {
    return (state.kits || []).reduce((acc, kit) => {
      acc[kit.token] = kit.name
      return acc
    }, { [UNSPECIFIED]: UNSPECIFIED })
  })

  function handleSubmitClick(e) {
    e.preventDefault()

    dispatch(submitPendingOptions())
  }
  /*
		kitToken
		apiToken
    apiScopes
  */

  return <div>
    <div>
      {
        hasSavedApiToken
        ? <span>ok, we have a good API token.</span>
        : <ApiTokenInput />
      }
    </div>
    <div>
      <select
        className={ styles['version-select'] }
        name="kit"
        onChange={ e => handleOptionChange({ kitToken: e.target.value }) }
        value={ kitToken || UNSPECIFIED }
      >
        {
          Object.keys(kitOptions).map((token, index) => {
            return <option key={ index } value={ token }>
              { token === UNSPECIFIED ? 'Select a kit' : `${ kitOptions[token] } (${ token })`}
            </option>
          })
        }
      </select>
    </div>
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
          ? <span className={ classnames(sharedStyles['submit-status'], sharedStyles['success']) }>
              <FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faCheck } />
            </span>
          : <div className={ classnames(sharedStyles['submit-status'], sharedStyles['fail']) }>
              <div className={ classnames(sharedStyles['fail-icon-container']) }>
                <FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faSkull } />
              </div>
              <div className={ sharedStyles['explanation'] }>
                { submitMessage }
              </div>
            </div>
        : null
      }
      {
        isSubmitting
        ? <span className={ classnames(sharedStyles['submit-status'], sharedStyles['submitting']) }>
            <FontAwesomeIcon className={ sharedStyles['icon'] } icon={faSpinner} spin/>
          </span>
        : isChecking
          ? <CheckingOptionStatusIndicator/>
          : size(pendingOptions) > 0
            ? <span className={ sharedStyles['submit-status'] }>you have pending changes</span>
            : null
      }
    </div>
  </div>
}
