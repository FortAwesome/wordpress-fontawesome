import React, { useState } from 'react'
import { useSelector, useDispatch } from 'react-redux'
import CdnConfigView from './CdnConfigView'
import KitSelectView from './KitSelectView'
import KitConfigView from './KitConfigView'
import sharedStyles from './App.module.css'
import optionStyles from './CdnConfigView.module.css'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import {
  faDotCircle,
  faSpinner,
  faCheck,
  faSkull,
} from '@fortawesome/free-solid-svg-icons'
import { faCircle } from '@fortawesome/free-regular-svg-icons'
import classnames from 'classnames'
import styles from './SettingsTab.module.css'
import has from 'lodash/has'
import { addPendingOption, submitPendingOptions, chooseAwayFromKitConfig, chooseIntoKitConfig } from './store/actions'
import CheckingOptionStatusIndicator from './CheckingOptionsStatusIndicator'
import size from 'lodash/size'
import { __ } from '@wordpress/i18n'

export default function SettingsTab() {
  const dispatch = useDispatch()
  const alreadyUsingKit = useSelector( state => !!state.options.kitToken )
  const [useKit, setUseKit] = useState(alreadyUsingKit)
  const isChecking = useSelector(state => state.preferenceConflictDetection.isChecking)
  const hasSubmitted = useSelector(state => state.optionsFormState.hasSubmitted)
  const submitSuccess = useSelector(state => state.optionsFormState.success)
  const submitMessage = useSelector(state => state.optionsFormState.message)
  const isSubmitting = useSelector(state => state.optionsFormState.isSubmitting)
  const pendingOptions = useSelector(state => state.pendingOptions)
  const apiToken = useSelector(state => state.options.apiToken)
  const [ masterSubmitButtonShowing, setMasterSubmitButtonShowing ] = useState( true )

  function useOption(option) {
    return useSelector(state => 
      has(state.pendingOptions, option)
      ? state.pendingOptions[option]
      : state.options[option]
    )
  }

  function handleSubmit(e) {
    if(!!e && 'function' == typeof e.preventDefault) {
      e.preventDefault()
    }

    dispatch(submitPendingOptions())
  }

  // The kitToken that may be a pendingOption
  const kitToken = useOption( 'kitToken' )

  // The one that's actually saved in the database already
  const activeKitToken = useSelector( state => state.options.kitToken )

  function handleOptionChange(change = {}) {
    dispatch(addPendingOption(change))
  }

  /**
   * In this case, we need to not only toggle the component's local
   * state, but also get rid of the kitToken and any pending options
   * that a kit selection might have put onto the form.
   */
  function handleSwitchAwayFromKitConfig() {
    setUseKit( false )

    dispatch( chooseAwayFromKitConfig({ activeKitToken }) )
  }

  function handleSwitchToKitConfig() {
    setUseKit( true )
    setMasterSubmitButtonShowing( true )

    dispatch( chooseIntoKitConfig() )
  }

  return <div><div className={ sharedStyles['wrapper-div'] }>
    <h3>{ __( 'How are you using Font Awesome?', 'font-awesome' ) }</h3>
    <div className={ styles['select-config-container'] }>
      <span>
        <input
          id="select_use_kits"
          name="select_use_kits"
          type="radio"
          value={ useKit }
          checked={ useKit }
          onChange={ () => handleSwitchToKitConfig() }
          className={ classnames(sharedStyles['sr-only'], sharedStyles['input-radio-custom']) }
        />
        <label htmlFor="select_use_kits" className={ optionStyles['option-label'] }>
          <span className={ sharedStyles['relative'] }>
            <FontAwesomeIcon
              icon={ faDotCircle }
              className={ sharedStyles['checked-icon'] }
              size="lg"
              fixedWidth
            />
            <FontAwesomeIcon
              icon={ faCircle }
              className={ sharedStyles['unchecked-icon'] }
              size="lg"
              fixedWidth
            />
          </span>
          <span className={ optionStyles['option-label-text'] }>
          { __( 'Use A Kit', 'font-awesome' ) }
          </span>
        </label>
      </span>
      <span>
        <input
          id="select_use_cdn"
          name="select_use_cdn"
          type="radio"
          value={ ! useKit }
          checked={ ! useKit }
          onChange={ () => handleSwitchAwayFromKitConfig() }
          className={ classnames(sharedStyles['sr-only'], sharedStyles['input-radio-custom']) }
        />
        <label htmlFor="select_use_cdn" className={ optionStyles['option-label'] }>
          <span className={ sharedStyles['relative'] }>
            <FontAwesomeIcon
              icon={ faDotCircle }
              className={ sharedStyles['checked-icon'] }
              size="lg"
              fixedWidth
            />
            <FontAwesomeIcon
              icon={ faCircle }
              className={ sharedStyles['unchecked-icon'] }
              size="lg"
              fixedWidth
            />
          </span>
          <span className={ optionStyles['option-label-text'] }>
          { __( 'Use CDN', 'font-awesome' ) }
          </span>
        </label>
      </span>
    </div>
    <>
      {
        useKit
          ? <>
            <KitSelectView useOption={ useOption } handleOptionChange={ handleOptionChange } handleSubmit={ handleSubmit } masterSubmitButtonShowing={ masterSubmitButtonShowing } setMasterSubmitButtonShowing={ setMasterSubmitButtonShowing }/>
            { !!kitToken && <KitConfigView kitToken={ kitToken } /> }
          </>
          : <CdnConfigView useOption={ useOption } handleOptionChange={ handleOptionChange } handleSubmit={ handleSubmit }/>
      }
    </>
    </div>
    {
      (!useKit || ( apiToken && masterSubmitButtonShowing ) ) &&
      <div className={ classnames(sharedStyles['submit-wrapper'], ['submit']) }>
        <input
          type="submit"
          name="submit"
          id="submit"
          className="button button-primary"
          value={ __( 'Save Changes', 'font-awesome' ) }
          disabled={ size(pendingOptions) === 0 }
          onClick={ handleSubmit }
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
              ? <span className={ sharedStyles['submit-status'] }>{ __( 'you have pending changes', 'font-awesome' ) }</span>
              : null
        }
      </div>
    }
  </div>
}
