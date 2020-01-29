import React, { createRef, useState, useEffect } from 'react'
import { useSelector, useDispatch } from 'react-redux'
import { submitPendingOptions, queryKits, addPendingOption, checkPreferenceConflicts } from './store/actions'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import {
  faSpinner,
  faCheck,
  faSkull } from '@fortawesome/free-solid-svg-icons'
import styles from './KitsConfigView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'
import PropTypes from 'prop-types'

export default function KitsConfigView({ optionSelector, handleOptionChange }) {
  const dispatch = useDispatch()
  const kitToken = optionSelector('kitToken')
  const kits = useSelector( state => state.kits ) || []

  function removeApiToken() {
    handleOptionChange({ apiToken: false })
    // TODO: validate the assumption that at the time we do this submission,
    // the only pending option is the apiToken. We're not trying to set any
    // other options at this point
    dispatch(submitPendingOptions())
  }
  
  /**
   * When selecting a kit, we go through each of its configuration options
   * and add them as pending options. We don't set those options in this system:
   * they come as read-only from the Font Awesome API. But setting them as pending
   * here allows them to processed by the preference checker to notify the user
   * in the UI if selecting this kit would result in any known preference conflicts
   * with registered clients.
   */
  function handleKitChange({ kitToken }) {
    if('' === kitToken) {
      // You can't select a non-kit option. The empty option only
      // appears in the selection dropdown as a placeholder before a kit is
      // selected
      return
    }

    const selectedKit = (kits || []).find(k => k.token === kitToken)

    if( !selectedKit ) {
      throw new Error(`When selecting to use kit ${ kitToken }, somehow the information we needed was missing. Try reloading the page.`)
    }

    dispatch(addPendingOption({
      kitToken,
      technology: 'svg' === selectedKit.technologySelected ? 'svg' : 'webfont',
      usePro: 'pro' === selectedKit.licenseSelected,
      v4compat: selectedKit.shimEnabled,
      version: selectedKit.version,
      // At the time this is being implemented, kits don't yet support
      // toggling svgPseudoElement support. But if that support is added
      svgPseudoElements: false
    }))

    dispatch(checkPreferenceConflicts())
  }

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
                onChange={ e => handleKitChange({ kitToken: e.target.value }) }
                value={ kitToken || '' }
                >
                  <option key='empty' value=''>Select a kit</option>
                {
                  kits.map((kit, index) => {
                    return <option key={ index } value={ kit.token }>
                      { `${ kit.name } (${ kit.token })` }
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
  </div>
}

KitsConfigView.propTypes = {
  optionSelector: PropTypes.func.isRequired,
  handleOptionChange: PropTypes.func.isRequired
}
