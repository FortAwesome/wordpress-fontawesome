import React, { createRef, useState, useEffect } from 'react'
import { useSelector, useDispatch } from 'react-redux'
import {
  resetPendingOptions,
  queryKits,
  addPendingOption,
  checkPreferenceConflicts,
  updateApiToken
 } from './store/actions'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import {
  faSpinner,
  faExternalLinkAlt,
  faCheck,
  faSkull } from '@fortawesome/free-solid-svg-icons'
import styles from './KitSelectView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'
import PropTypes from 'prop-types'
import size from 'lodash/size'

export default function KitSelectView({ optionSelector }) {
  const dispatch = useDispatch()
  const kitTokenActive = useSelector(state => state.options.kitToken)
  const kitToken = optionSelector('kitToken')
  const [ pendingApiToken, setPendingApiToken ] = useState(null)
  const apiToken = useSelector(state => {
    if( null !== pendingApiToken ) return pendingApiToken

    return state.options.apiToken
  })
  const kits = useSelector( state => state.kits ) || []
  const hasSubmitted = useSelector(state => state.optionsFormState.hasSubmitted)
  const submitSuccess = useSelector(state => state.optionsFormState.success)
  const submitMessage = useSelector(state => state.optionsFormState.message)
  const isSubmitting = useSelector(state => state.optionsFormState.isSubmitting)

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

    if( kitTokenActive === kitToken ) {
      // We're just resetting back to the state we were in
      dispatch(resetPendingOptions())
    } else {
      dispatch(addPendingOption({
        kitToken,
        technology: 'svg' === selectedKit.technologySelected ? 'svg' : 'webfont',
        usePro: 'pro' === selectedKit.licenseSelected,
        v4Compat: selectedKit.shimEnabled,
        version: selectedKit.version,
        // At the time this is being implemented, kits don't yet support
        // toggling svgPseudoElement support. But if that support is added
        svgPseudoElements: false
      }))
    }

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
    if( !!apiTokenInputRef.current && apiTokenInputHasFocus ) {
      apiTokenInputRef.current.focus()
    }
  })

  const hasSavedApiToken = useSelector(state => !! state.options.apiToken)

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
        value={ pendingApiToken || '' }
        size="20"
        onChange={ e => {
          setApiTokenInputHasFocus( true )
          setPendingApiToken(e.target.value) 
        }}
      />
      <div className="submit">
        <input
          type="submit"
          name="submit"
          id="submit"
          className="button button-primary"
          value="Save API Token"
          disabled={ !pendingApiToken }
          onMouseDown={ () => dispatch(updateApiToken({ apiToken: pendingApiToken, runQueryKits: true })) }
        />
        { 
          (hasSubmitted && ! submitSuccess) &&
          <div className={ classnames(sharedStyles['submit-status'], sharedStyles['fail']) }>
            <div className={ classnames(sharedStyles['fail-icon-container']) }>
              <FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faSkull } />
            </div>
            <div className={ sharedStyles['explanation'] }>
              { submitMessage }
            </div>
          </div>
        }
        {
          isSubmitting &&
          <span className={ classnames(sharedStyles['submit-status'], sharedStyles['submitting']) }>
            <FontAwesomeIcon className={ sharedStyles['icon'] } icon={faSpinner} spin/>
          </span>
        }
      </div>
    </>
  }

  function ApiTokenControl() {
    return <div className={ styles['api-token-control'] }>
      <span>API Token</span>
      <span className={ classnames(sharedStyles['submit-status'], sharedStyles['success']) }>
        <FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faCheck } />
      </span>
      {
        !!apiToken &&
        <button onClick={ () => dispatch(updateApiToken({ apiToken: false })) } className={ styles['remove'] } type="button">remove</button>
      }
    </div>
  }

  const STATUS = {
    querying: 'querying',
    showingOnlyActiveKit: 'showingOnlyActiveKit',
    noKitsFoundAfterQuery: 'noKitsFoundAfterQuery',
    networkError: 'networkError',
    kitSelection: 'kitSelection',
    noApiToken: 'noApiToken',
    apiTokenReadyNoKitsYet: 'apiTokenReadyNoKitsYet'
  }

  function KitSelector() {
    const status =
      apiToken
        ? kitsQueryStatus.isSubmitting
          ? STATUS.querying
          : kitsQueryStatus.hasSubmitted
            ? kitsQueryStatus.success
              ? size(kits) > 0
                ? STATUS.kitSelection
                : STATUS.noKitsFoundAfterQuery
              : STATUS.networkError
            : kitTokenActive
              ? STATUS.showingOnlyActiveKit
              : STATUS.apiTokenReadyNoKitsYet
        : STATUS.noApiToken
    
    if(null === status) {
      // TODO: use a utility reporting method for this
      console.group('Font Awesome WordPress Plugin')
      console.log('There is no active kitToken, yet KitSelector has not queried')
      throw new Error('Something went wrong. Try reloading the page.')
    }

    const kitRefreshButton = <button onClick={ () => dispatch(queryKits()) }>
      {
        0 === size(kits)
        ? 'query kits'
        : 'refresh kits'
      }
    </button>

      return <div className={ styles['kit-selector-container'] }>
        {
          {
            noApiToken: 'noApiToken',
            apiTokenReadyNoKitsYet: kitRefreshButton,
            querying:
              <div>
                <span>
                  Loading your kits...
                </span>
                <span className={ classnames(sharedStyles['submit-status'], sharedStyles['submitting']) }>
                  <FontAwesomeIcon className={ sharedStyles['icon'] } icon={faSpinner} spin/>
                </span>
              </div>,
            
            networkError:
              <div className={ classnames(sharedStyles['submit-status'], sharedStyles['fail']) }>
                <div className={ classnames(sharedStyles['fail-icon-container']) }>
                  <FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faSkull } />
                </div>
                <div className={ sharedStyles['explanation'] }>
                  { kitsQueryStatus.message }
                </div>
              </div>,
            
            noKitsFoundAfterQuery:
              <>
                <p>Oh no! You don't have any kits set up.</p>
                <p>Head over to your <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/kits"><FontAwesomeIcon icon={faExternalLinkAlt} />Font Awesome account</a> to create one. Then come back here and reload this page.</p>
              </>,

            kitSelection:
              <>
                { kitRefreshButton }
                <select
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
              </>,
            
            showingOnlyActiveKit:
              <>
                { kitRefreshButton }
                <span>showingOnlyActiveKit</span>
              </>
          }[status]
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

KitSelectView.propTypes = {
  optionSelector: PropTypes.func.isRequired,
  handleOptionChange: PropTypes.func.isRequired
}
