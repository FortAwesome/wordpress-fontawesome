import React, { createRef, useState, useEffect } from 'react'
import { useSelector, useDispatch } from 'react-redux'
import Alert from './Alert'
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
  faRedo,
  faSkull, 
  faTrashAlt } from '@fortawesome/free-solid-svg-icons'
import { faQuestionCircle, faCheckCircle } from '@fortawesome/free-regular-svg-icons'
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
  const [ showingRemoveApiTokenAlert, setShowRemoveApiTokenAlert ] = useState(false)
  const apiToken = useSelector(state => {
    if( null !== pendingApiToken ) return pendingApiToken

    return state.options.apiToken
  })
  const kits = useSelector( state => state.kits ) || []
  const hasSubmitted = useSelector(state => state.optionsFormState.hasSubmitted)
  const submitSuccess = useSelector(state => state.optionsFormState.success)
  const submitMessage = useSelector(state => state.optionsFormState.message)
  const isSubmitting = useSelector(state => state.optionsFormState.isSubmitting)

  function removeApiToken() {
    if( !!kitTokenActive ) {
      setShowRemoveApiTokenAlert(true)
    } else {
      dispatch(updateApiToken({ apiToken: false }))
    }
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
        // toggling pseudoElement support for SVG, but it's implicitly supported for webfont.
        pseudoElements: 'svg' !== selectedKit.technologySelected
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
      <div className={ styles['field-apitoken'] }>
        <label htmlFor="api_token">
          <FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faQuestionCircle } size="lg" />
          API Token
        </label>
        <div>
          <input
            id="api_token"
            name="api_token"
            type="text"
            ref={ apiTokenInputRef }
            value={ pendingApiToken || '' }
            size="20"
            onChange={ e => {
              setApiTokenInputHasFocus( true )
              setPendingApiToken(e.target.value)
            }}
          />
          <p>Grab your secure and unique API token from your Font Awesome account page and enter it here so we can securely fetch your kits. <a target="_blank" rel="noopener noreferrer" href="https://fontawesome.com/account#api-tokens">Get your API token on fontawesome.com<FontAwesomeIcon icon={faExternalLinkAlt} style={{marginLeft: '.5em'}} /></a></p>

        </div>
      </div>
      <div className="submit">
        <input
          type="submit"
          name="submit"
          id="submit"
          className="button button-primary"
          value="Save API Token"
          disabled={ !pendingApiToken }
          onMouseDown={ () => {
              dispatch(updateApiToken({ apiToken: pendingApiToken, runQueryKits: true }))
              setPendingApiToken(null)
            }
          }
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
    return <div className={ styles['api-token-control-wrapper'] }>
      <div className={ styles['api-token-control'] }>
        <p className={ styles['token-saved'] }> 
          <span>
            <FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faCheckCircle } size="lg" />
          </span>
          API Token Saved
        </p>
        {
          !!apiToken &&
          <button onClick={ () => removeApiToken() } className={ styles['remove'] } type="button"><FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faTrashAlt } title="remove" alt="remove" /></button>
        }
      </div>
      {
        showingRemoveApiTokenAlert &&
        <div className={ styles['api-token-control-alert-wrapper'] }>
          <Alert title="Whoa, whoa, whoa!" type='warning'>
          You can't remove your API token when "Use a Kit" is active. Switch to "Use CDN" first.
          </Alert>
        </div>
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
    
    const kitRefreshButton = <button onClick={ () => dispatch(queryKits()) } className={ styles['refresh'] }>
      <FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faRedo } title="refresh" alt="refresh" />
      <span>
      {
        0 === size(kits)
        ? 'Get latest kits data'
        : 'Refresh kits data'
      }
      </span>
    </button>

    const activeKitNotice = kitTokenActive ? <div className={ styles['wrap-active-kit'] }><p className={ classnames(styles['active-kit'], styles['set']) }><FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faCheckCircle } size="lg" /> { kitTokenActive } Kit is Currently Active</p></div> : null


      return <div className={ styles['kit-selector-container'] }>

        { activeKitNotice }

        <div className={ styles['wrap-selectkit'] }>
          <h3 className={ styles['title-selectkit'] }><FontAwesomeIcon className={ sharedStyles['icon'] } icon={ faQuestionCircle } size="lg" />
            Pick a Kit to Use or Check Settings
          </h3>
          <div className={ styles['selectkit'] }>
            <p>Refresh your kits data to get the latest kit settings, then select the kit you would like to use. Remember to save when you're ready to use it.</p>
          {
            {
              noApiToken: 'noApiToken',
              apiTokenReadyNoKitsYet: <>{ activeKitNotice } { kitRefreshButton }</>,
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
                  <Alert title="Zoinks! Looks like you don't have any kits set up yet." type="info">
                    <p>Head over to Font Awesome to create one, then come back here and refresh your kits. <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/kits">Create a kit on Font Awesome <FontAwesomeIcon icon={faExternalLinkAlt} /></a></p>
                  </Alert>
                  { kitRefreshButton }
                </>,

              kitSelection:
                <>
                <div className={ styles['field-kitselect'] }>
                  <select
                  className={ styles['kit-select'] }
                  id="kits"
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
                  { kitRefreshButton }
                  </div>
                </>,

              showingOnlyActiveKit:
                <>
                  { kitRefreshButton }
                </>
            }[status]
          }
          </div>
        </div>
      </div>
    }

  return <div>
    <div className={ styles['kit-tab-content'] }>
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
