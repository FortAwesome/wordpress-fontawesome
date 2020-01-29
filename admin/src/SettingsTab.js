import React, { useState } from 'react'
import { useSelector, useDispatch } from 'react-redux'
import OptionsView from './OptionsView'
import KitsConfigView from './KitsConfigView'
import sharedStyles from './App.module.css'
import optionStyles from './OptionsView.module.css'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faDotCircle } from '@fortawesome/free-solid-svg-icons'
import { faCircle } from '@fortawesome/free-regular-svg-icons'
import classnames from 'classnames'
import styles from './SettingsTab.module.css'
import has from 'lodash/has'
import { addPendingOption, submitPendingOptions, chooseAwayFromKitConfig, chooseIntoKitConfig } from './store/actions'

export default function SettingsTab() {
  const dispatch = useDispatch()
  const alreadyUsingKit = useSelector( state => !!state.options.kitToken )
  const [useKit, setUseKit] = useState(alreadyUsingKit)

  const optionSelector = option => useSelector(state => 
    has(state.pendingOptions, option)
    ? state.pendingOptions[option]
    : state.options[option]
  )

  function handleSubmit(e) {
    if(!!e && 'function' == typeof e.preventDefault) {
      e.preventDefault()
    }

    dispatch(submitPendingOptions())
  }

  // The kitToken that may be a pendingOption
  const kitToken = optionSelector( 'kitToken' )

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

    dispatch( chooseIntoKitConfig() )
  }

  return <div>
    <div className={ styles['select-config-container'] }>
      <div>
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
          Use A Kit
          </span>
        </label>
      </div>
      <div>
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
          Use CDN
          </span>
        </label>
      </div>
    </div>
    <>
      { useKit && <KitsConfigView optionSelector={ optionSelector } handleOptionChange={ handleOptionChange } handleSubmit={ handleSubmit }/> }
      {
        (!useKit || !!kitToken)
        ? <OptionsView useKit={ useKit } optionSelector={ optionSelector } handleOptionChange={ handleOptionChange } handleSubmit={ handleSubmit }/>
        : null
      }
    </>
  </div>
}
