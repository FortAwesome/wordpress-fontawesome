import React from 'react'
import { useSelector, useDispatch } from 'react-redux'
import {
  addPendingOption,
  checkPreferenceConflicts,
  submitPendingOptions
} from './store/actions'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import {
  faDotCircle,
  faSpinner,
  faCheckSquare,
  faCheck,
  faSkull,
  faExternalLinkAlt,
  faMagic } from '@fortawesome/free-solid-svg-icons'
import { faCircle, faSquare } from '@fortawesome/free-regular-svg-icons'
import styles from './Options.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'
import { has, size } from 'lodash'
import SvgPseudoElementsWarning from "./SvgPseudoElementsWarning";
import Alert from './Alert'

const UNSPECIFIED = ''

function CheckingOptionStatusIndicator(){
  return <div className={ styles['checking-option-status-indicator'] }>
    <FontAwesomeIcon spin className={ classnames(sharedStyles['icon']) } icon={ faSpinner }/>
    &nbsp;checking for preference conflicts...
  </div>
}

export default function Options(props) {
  const optionSelector = option => useSelector(state => 
    has(state.pendingOptions, option)
    ? state.pendingOptions[option]
    : state.options[option]
  )

  const nowMs = (new Date()).valueOf()
  const usePro = optionSelector('usePro')
  const technology = optionSelector('technology')
  const version = optionSelector('version')
  const v4compat = optionSelector('v4compat')
  const svgPseudoElements = optionSelector('svgPseudoElements')

  const pendingOptions = useSelector(state => state.pendingOptions)
  const pendingOptionConflicts = useSelector(state => state.pendingOptionConflicts)
  const isChecking = useSelector(state => state.preferenceConflictDetection.isChecking)
  const preferenceCheckSuccess = useSelector(state => state.preferenceConflictDetection.success)
  const preferenceCheckMessage = useSelector(state => state.preferenceConflictDetection.message)
  
  const detectConflictsUntilNext = optionSelector('detectConflictsUntil')
  const detectingConflictsNext = (new Date(detectConflictsUntilNext * 1000)) > nowMs
  const detectConflictsUntilOrig = useSelector(state => state.options.detectConflictsUntil)
  const detectingConflictsOrig = (new Date(detectConflictsUntilOrig * 1000)) > nowMs

  const versionOptions = useSelector(state => {
    const { releases: { available, latest_version, previous_version } } = state

    return available.reduce((acc, version) => {
      if( latest_version === version ) {
        acc[version] = `${ version } (latest)`
      } else if ( previous_version === version ) {
        acc[version] = `${ version } (previous minor release)`
      } else {
        acc[version] = version
      }
      return acc
    }, {})
  })

  const hasSubmitted = useSelector(state => state.optionsFormState.hasSubmitted)
  const submitSuccess = useSelector(state => state.optionsFormState.submitSuccess)
  const submitMessage = useSelector(state => state.optionsFormState.submitMessage)
  const isSubmitting = useSelector(state => state.optionsFormState.isSubmitting)

  const dispatch = useDispatch()

  function handleOptionChange(change = {}, check = true) {
    dispatch(addPendingOption(change))
    check && dispatch(checkPreferenceConflicts())
  }

  function handleSubmitClick(e) {
    e.preventDefault()

    dispatch(submitPendingOptions())
  }

  function getDetectionStatus(option) {
    if(has(pendingOptions, option)) {
      if(isChecking) {
        return <CheckingOptionStatusIndicator/>
      } else if ( ! preferenceCheckSuccess ) {
        return <Alert title='Error checking preferences' type='warning'>
          <p>{ preferenceCheckMessage }</p>
        </Alert>
      } else if (has(pendingOptionConflicts, option)) {
        return <Alert title="Preference Conflict" type='warning'>
            {
              size(pendingOptionConflicts[option]) > 1
              ? <div>
                This change might cause problems for these themes or plugins: { pendingOptionConflicts[option].join(', ') }.
              </div>
              : <div>
                This change might cause problems for the theme or plugin: { pendingOptionConflicts[option][0] }.
                </div>
            }
        </Alert>
      } else {
        return null
      }
    } else {
      return null
    }
  }

  return <div className={ classnames(styles['options-setter']) }>
      <form onSubmit={ e => e.preventDefault() }>
        <hr className={ styles['option-divider'] }/>
        <div className={ classnames( sharedStyles['flex'], sharedStyles['flex-row'] ) }>
          <div className={ styles['option-header'] }>Icons</div>
          <div className={ styles['option-choice-container'] }>
            <div className={ styles['option-choices'] }>
              <div className={ styles['option-choice'] }>
                <input
                  id="code_edit_icons_pro"
                  name="code_edit_icons"
                  type="radio"
                  value="svg"
                  checked={ usePro }
                  onChange={ () => handleOptionChange({ usePro: true }) }
                  className={ classnames(sharedStyles['sr-only'], styles['input-radio-custom']) }
                />
                <label htmlFor="code_edit_icons_pro" className={ styles['option-label'] }>
                    <span className={ sharedStyles['relative'] }>
                      <FontAwesomeIcon
                        icon={ faDotCircle }
                        className={ styles['checked-icon'] }
                        size="lg"
                        fixedWidth
                      />
                      <FontAwesomeIcon
                        icon={ faCircle }
                        className={ styles['unchecked-icon'] }
                        size="lg"
                        fixedWidth
                      />
                    </span>
                  <span className={ styles['option-label-text'] }>
                      Pro
                    </span>
                </label>
              </div>
              <div className={ styles['option-choice'] }>
                <input
                  id="code_edit_icons_free"
                  name="code_edit_icons"
                  type="radio"
                  value="webfont"
                  checked={ ! usePro }
                  onChange={ () => handleOptionChange({ usePro: false }) }
                  className={ classnames(sharedStyles['sr-only'], styles['input-radio-custom']) }
                />
                <label htmlFor="code_edit_icons_free" className={ styles['option-label'] }>
                  <span className={ sharedStyles['relative'] }>
                    <FontAwesomeIcon
                      icon={ faDotCircle }
                      size="lg"
                      fixedWidth
                      className={ styles['checked-icon'] }
                    />
                    <FontAwesomeIcon
                      icon={ faCircle }
                      size="lg"
                      fixedWidth
                      className={ styles['unchecked-icon'] }
                    />
                  </span>
                  <span className={ styles['option-label-text'] }>
                    Free
                  </span>
                </label>
              </div>
            </div>
            { usePro &&
              <Alert title='Pro requires a subscription' type='info'>
                <ul>
                  <li>
                    <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/pro"><FontAwesomeIcon icon={faExternalLinkAlt} /> Learn more</a>
                  </li>
                  <li>
                    <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/account/cdn"><FontAwesomeIcon icon={faExternalLinkAlt} /> Manage my allowed domains</a>
                  </li>
                </ul>
              </Alert>
            }
            { getDetectionStatus('usePro') }
          </div>
        </div>
        <hr className={ styles['option-divider'] }/>
        <div className={ classnames( sharedStyles['flex'], sharedStyles['flex-row'] ) }>
          <div className={ styles['option-header'] }>Technology</div>
          <div className={ styles['option-choice-container'] }>
            <div className={ styles['option-choices'] }>
              <div className={ styles['option-choice'] }>
                <input
                  id="code_edit_tech_webfont"
                  name="code_edit_tech"
                  type="radio"
                  value="webfont"
                  checked={ technology === 'webfont' }
                  onChange={ () => handleOptionChange({
                    technology: 'webfont',
                    svgPseudoElements: false
                  }) }
                  className={ classnames(sharedStyles['sr-only'], styles['input-radio-custom']) }
                />
                <label htmlFor="code_edit_tech_webfont" className={ styles['option-label'] }>
                    <span className={ sharedStyles['relative'] }>
                      <FontAwesomeIcon
                        icon={ faDotCircle }
                        size="lg"
                        fixedWidth
                        className={ styles['checked-icon'] }
                      />
                      <FontAwesomeIcon
                        icon={ faCircle }
                        size="lg"
                        fixedWidth
                        className={ styles['unchecked-icon'] }
                      />
                    </span>
                  <span className={ styles['option-label-text'] }>
                      Web Font
                    </span>
                </label>
              </div>
              <div className={ styles['option-choice'] }>
                <input
                  id="code_edit_tech_svg"
                  name="code_edit_tech"
                  type="radio"
                  value="svg"
                  checked={ technology === 'svg' }
                  onChange={ () => handleOptionChange({ technology: 'svg' }) }
                  className={ classnames(sharedStyles['sr-only'], styles['input-radio-custom']) }
                />
                <label htmlFor="code_edit_tech_svg" className={ styles['option-label'] }>
                  <span className={ sharedStyles['relative'] }>
                    <FontAwesomeIcon
                      icon={ faDotCircle }
                      className={ styles['checked-icon'] }
                      size="lg"
                      fixedWidth
                    />
                    <FontAwesomeIcon
                      icon={ faCircle }
                      className={ styles['unchecked-icon'] }
                      size="lg"
                      fixedWidth
                    />
                  </span>
                  <span className={ styles['option-label-text'] }>
                    SVG
                  </span>
                </label>
              </div>
            </div>
            { getDetectionStatus('technology') }
          </div>
        </div>
        <hr className={ styles['option-divider'] }/>
        <div className={ classnames( sharedStyles['flex'], sharedStyles['flex-row'] ) }>
          <div className={ styles['option-header'] }>Version</div>
          <div className={ styles['option-choice-container'] }>
            <div className={ styles['option-choices'] }>
              <select
                className={ styles['version-select'] }
                name="version"
                onChange={ e => handleOptionChange({ version: e.target.value }) }
                value={ version }
              >
                {
                  Object.keys(versionOptions).map((version, index) => {
                    return <option key={ index } value={ version }>
                      { version === UNSPECIFIED ? '-' : versionOptions[version] }
                    </option>
                  })
                }
              </select>
            </div>
            { getDetectionStatus('version') }
          </div>
        </div>
        <hr className={ styles['option-divider'] }/>
        <div className={ classnames( sharedStyles['flex'], sharedStyles['flex-row'], styles['features'] ) }>
          <div className={ styles['option-header'] }>Features</div>
          <div className={ styles['option-choice-container'] }>
            <div className={ styles['option-choice'] }>
              <input
                id="code_edit_features_v4compat"
                name="code_edit_features"
                type="checkbox"
                value="v4compat"
                checked={ v4compat }
                onChange={ () => handleOptionChange({ v4compat: ! v4compat }) }
                className={ classnames(sharedStyles['sr-only'], styles['input-checkbox-custom']) }
              />
              <label htmlFor="code_edit_features_v4compat" className={ styles['option-label'] }>
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
                <span className={ styles['option-label-text'] }>
                  Version 4 Compatibility
                  <span className={ styles['option-label-explanation'] }>
                    Automatically use Font Awesome 5 for all of those version 4 icons already on your site, including
                    those used by your theme or plugins, without worrying about new syntax and name changes.
                    Read our guide for <a rel="noopener noreferrer" target="_blank" href="https://staging.fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4">upgrading from version 4</a> for
                    more info.
                  </span>
                </span>
              </label>
              { getDetectionStatus('v4compat') }
            </div>
            <div className={ styles['option-choice'] }>
              <input
                id="code_edit_features_remove_conflicts"
                name="code_edit_features"
                type="checkbox"
                value="remove_conflicts"
                checked={ detectingConflictsNext }
                onChange={ () => {
                  if( detectingConflictsNext ) {
                    // We're disabling detection. The way we do that depends on whether
                    // we're setting a newly disabled state or reverting to a previously disabled state.
                    if ( detectingConflictsOrig ) {
                      // Setting a new disabled state, which means choosing a time that's basically
                      // "now", but just a touch before now to make sure that when re-rendering, this
                      // value results in a correct computation for the detectingConflictsNext boolean.
                      const nowish = Math.floor((new Date())/1000) - 1
                      handleOptionChange({ detectConflictsUntil: nowish }, false)
                    } else {
                      // Turning off conflict detection by resetting it to its originally "off" state,
                      // but a state that represents the last time when conflict detection had been enabled,
                      // which we want to keep.
                      handleOptionChange({ detectConflictsUntil: detectConflictsUntilOrig }, false)
                    }
                  } else {
                    // We're enabling detection, so we calculate a time in the future.
                    const tenMinutesLater = Math.floor((new Date((new Date()).valueOf() + (1000 * 60 * 10))) / 1000)
                    handleOptionChange({ detectConflictsUntil: tenMinutesLater }, false)
                  }
                } }
                className={ classnames(sharedStyles['sr-only'], styles['input-checkbox-custom']) }
              />
              <label htmlFor="code_edit_features_remove_conflicts" className={ styles['option-label'] }>
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
                <span className={ styles['option-label-text'] }>
                  Enable Conflict Detection
                  <span className={ styles['option-label-explanation'] }>
                    After enabling, browse various pages on your site where you think there might be conflicts.
                    The conflict detector will test those pages, looking for other versions of Font Awesome
                    that may be loaded by other themes or plugins you have installed. You'll see the results
                    below and can use it to selectively disable them.
                    Normally this allows them to continue
                    displaying icons as expected, using the one version of Font Awesome you've configured here,
                    instead of loading additional conflicting versions.
                  </span>
                </span>
              </label>
            </div>
            { technology === 'svg' &&
              <div className={styles['option-choice']}>
                <input
                  id="code_edit_features_svg_pseudo_elements"
                  name="code_edit_features"
                  type="checkbox"
                  value="svg_pseudo_elements"
                  checked={ svgPseudoElements }
                  onChange={() => handleOptionChange({ svgPseudoElements: !svgPseudoElements })}
                  className={classnames(sharedStyles['sr-only'], styles['input-checkbox-custom'])}
                />
                <label htmlFor="code_edit_features_svg_pseudo_elements" className={styles['option-label']}>
                <span className={sharedStyles['relative']}>
                  <FontAwesomeIcon
                    icon={faCheckSquare}
                    className={styles['checked-icon']}
                    size="lg"
                    fixedWidth
                  />
                  <FontAwesomeIcon
                    icon={faSquare}
                    className={styles['unchecked-icon']}
                    size="lg"
                    fixedWidth
                  />
                </span>
                  <span className={styles['option-label-text']}>
                  Enable SVG Pseudo-elements
                  <span className={styles['option-label-explanation']}>
                    For best compatibility and performance, it's usually best to avoid using <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements">pseudo-elements</a> in
                    Font Awesome. Pseudo-element icons will be less compatible across major Font Awesome versions and technologies.
                    As a built-in feature of CSS, they come with no performance penalty when using the CSS and Webfont technology.
                    However, using them with SVG requires a little more magic <FontAwesomeIcon
                    icon={faMagic}/> which might make your web site feel signifcantly slower.
                  </span>
                </span>
                </label>
                { getDetectionStatus('svgPseudoElements') }
              </div>
            }
            {
              svgPseudoElements
              ? <SvgPseudoElementsWarning
                v4compat={ v4compat }
              />
              : null
            }
          </div>
        </div>
        <hr className={ styles['option-divider'] }/>
      </form>
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
      { hasSubmitted &&
        ( submitSuccess
          ? <span className={ classnames(styles['submit-status'], styles['success']) }>
              <FontAwesomeIcon className={ styles['icon'] } icon={ faCheck } />
              <span className={ styles['explanation'] }>
                { submitMessage }
              </span>
            </span>
          : <div className={ classnames(styles['submit-status'], styles['fail']) }>
              <div className={ classnames(styles['fail-icon-container']) }>
                <FontAwesomeIcon className={ styles['icon'] } icon={ faSkull } />
              </div>
              <div className={ styles['explanation'] }>
                { submitMessage }
              </div>
            </div>
        )
      }
      {isSubmitting &&
        <span className={ classnames(styles['submit-status'], styles['submitting']) }>
          <FontAwesomeIcon className={ styles['icon'] } icon={faSpinner} spin/>
        </span>
      }
    </div>
  </div>
}
