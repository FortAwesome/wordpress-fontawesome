import React, { createRef, useState, useEffect } from 'react'
import { useSelector, useDispatch } from 'react-redux'
import has from 'lodash/has'
import size from 'lodash/size'
import { addPendingOption, submitPendingOptions, queryKits } from './store/actions'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import CheckingOptionStatusIndicator from './CheckingOptionsStatusIndicator'
import {
  faSpinner,
  faCheck,
  faSkull } from '@fortawesome/free-solid-svg-icons'
import styles from './KitsConfigView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'

const UNSPECIFIED = '-'

export default function KitsConfigView() {
   const dispatch = useDispatch()

   const optionSelector = option => useSelector(state => 
    has(state.pendingOptions, option)
    ? state.pendingOptions[option]
    : state.options[option]
  )

  function handleOptionChange(change = {}) {
    dispatch(addPendingOption(change))
  }

  function handleSubmitClick(e) {
    e.preventDefault()

    dispatch(submitPendingOptions())
  }

  function removeApiToken() {
    handleOptionChange({ apiToken: false })
    dispatch(submitPendingOptions())
  }

  const pendingOptions = useSelector(state => state.pendingOptions)
  const hasSubmitted = useSelector(state => state.optionsFormState.hasSubmitted)
  const submitSuccess = useSelector(state => state.optionsFormState.success)
  const submitMessage = useSelector(state => state.optionsFormState.message)
  const isSubmitting = useSelector(state => state.optionsFormState.isSubmitting)
  const isChecking = useSelector(state => state.preferenceConflictDetection.isChecking)
  const kitsQueryStatus = useSelector(state => state.kitsQueryStatus)

  /**
   * This seems like a lot of effort just to keep the focus on the API Token input
   * field during data entry, but it's because the component is being re-rendered
   * on each change, and thus a new input DOM element is being created on each change.
   * So the input element doesn't so much "lose focus" as is it just replaced by a
   * different DOM element.
   * So it's more like we have to re-focus on that new DOM element each time it changes.
   * This would happen keystroke by keystroke if the user types in an API Token.
   * Or if content is pasted into the field all at once, we'd like the focus to remain there
   * in the input field until the user intentionally blurs by clicking the submit
   * button, or pressing the tab key, for example.
   */
  const apiTokenInputRef = createRef()
  const [ apiTokenInputHasFocus, setApiTokenInputHasFocus ] = useState( false )
  useEffect(() => {
    if( apiTokenInputHasFocus ) {
      apiTokenInputRef.current.focus()
    }
  })

  // Kits query effect: when we first load the page, if we havent' already loaded
  // any kits, load them.
  useEffect(() => {
    if ( ! kitsQueryStatus.hasSubmitted ) {
      dispatch( queryKits() )
    }
  }, [ kitsQueryStatus.hasSubmitted ])

  /*
  const pendingOptionConflicts = useSelector(state => state.pendingOptionConflicts)
  const hasChecked = useSelector(state => state.preferenceConflictDetection.hasChecked)
  const preferenceCheckSuccess = useSelector(state => state.preferenceConflictDetection.success)
  const preferenceCheckMessage = useSelector(state => state.preferenceConflictDetection.message)  
  */

  const kitToken = optionSelector('kitToken')
  const hasSavedApiToken = useSelector(state => !! state.options.apiToken)
  const pendingApiToken = useSelector(state => state.pendingOptions['apiToken'])

  const kitOptions = useSelector(state => {
    return (state.kits || []).reduce((acc, kit) => {
      acc[kit.token] = kit.name
      return acc
    }, { [UNSPECIFIED]: UNSPECIFIED })
  })

  function ApiTokenInput() {
    return <>
      <label htmlFor="api_token" className={ styles['option-label'] }>
        API Token
      </label>
      <input
        id="api_token"
        name="api_token"
        type="text"
        ref={ apiTokenInputRef }
        placeholder="paste API Token here"
        value={ pendingApiToken }
        size="20"
        onBlur={ () => setApiTokenInputHasFocus( false ) }
        onChange={ e => {
          setApiTokenInputHasFocus( true )
          handleOptionChange({ apiToken: e.target.value }) 
        }}
      />
    </>
  }

  function ApiTokenControl() {
    return <div className={ styles['api-token-control'] }>
      <span>API Token</span>
      <span className={ classnames(sharedStyles['submit-status'], sharedStyles['success']) }>
        <FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faCheck } />
      </span>
      <button onClick={ () => removeApiToken() } className={ styles['remove'] } type="button">remove</button>
    </div>
  }

  function KitSelector() {
      return <div className={ styles['kit-selector-container'] }>
        {
          kitsQueryStatus.isSubmitting
          ? <div>
              <span>
                Loading your kits...
              </span>
              <span className={ classnames(sharedStyles['submit-status'], sharedStyles['submitting']) }>
                <FontAwesomeIcon className={ sharedStyles['icon'] } icon={faSpinner} spin/>
              </span>
            </div>
          : kitsQueryStatus.hasSubmitted
            ? kitsQueryStatus.success
              ? <select
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
              : <div className={ classnames(sharedStyles['submit-status'], sharedStyles['fail']) }>
                  <div className={ classnames(sharedStyles['fail-icon-container']) }>
                    <FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faSkull } />
                  </div>
                  <div className={ sharedStyles['explanation'] }>
                    { kitsQueryStatus.message }
                  </div>
                </div>
          : null
        }
      </div>
  }

  return <div>
    <div>
      {
        hasSavedApiToken
        ? <>
            <ApiTokenControl />
            <KitSelector />
          </>
        : <ApiTokenInput />
      }
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
