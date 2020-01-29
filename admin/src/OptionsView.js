import React from 'react'
import { useSelector, useDispatch } from 'react-redux'
import {
  addPendingOption,
  checkPreferenceConflicts
} from './store/actions'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import {
  faDotCircle,
  faSpinner,
  faCheckSquare,
  faCheck,
  faSkull,
  faExternalLinkAlt } from '@fortawesome/free-solid-svg-icons'
import { faCircle, faSquare } from '@fortawesome/free-regular-svg-icons'
import styles from './OptionsView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'
import has from 'lodash/has'
import size from 'lodash/size'
import Alert from './Alert'
import CheckingOptionStatusIndicator from './CheckingOptionsStatusIndicator'
import PropTypes from 'prop-types'

const UNSPECIFIED = ''

export default function OptionsView({ useKit, optionSelector, handleSubmit }) {
  const usePro = optionSelector('usePro')
  const technology = optionSelector('technology')
  const version = optionSelector('version')
  const v4Compat = optionSelector('v4Compat')
  const svgPseudoElements = optionSelector('svgPseudoElements')

  const pendingOptions = useSelector(state => state.pendingOptions)
  const pendingOptionConflicts = useSelector(state => state.pendingOptionConflicts)
  const isChecking = useSelector(state => state.preferenceConflictDetection.isChecking)
  const hasChecked = useSelector(state => state.preferenceConflictDetection.hasChecked)
  const preferenceCheckSuccess = useSelector(state => state.preferenceConflictDetection.success)
  const preferenceCheckMessage = useSelector(state => state.preferenceConflictDetection.message)  

  const versionOptions = useSelector(state => {
    const { releases: { available, latest_version } } = state

    return available.reduce((acc, version) => {
      if( latest_version === version ) {
        acc[version] = `${ version } (latest)`
      } else {
        acc[version] = version
      }
      return acc
    }, {})
  })

  const hasSubmitted = useSelector(state => state.optionsFormState.hasSubmitted)
  const submitSuccess = useSelector(state => state.optionsFormState.success)
  const submitMessage = useSelector(state => state.optionsFormState.message)
  const isSubmitting = useSelector(state => state.optionsFormState.isSubmitting)

  const dispatch = useDispatch()

  function handleOptionChange(change = {}, check = true) {
    dispatch(addPendingOption(change))
    check && dispatch(checkPreferenceConflicts())
  }

  function getDetectionStatusForOption(option) {
    if(has(pendingOptions, option)) {
      if ( hasChecked && ! preferenceCheckSuccess ) {
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
    <div className={ sharedStyles['wrapper-div'] }>
      <form onSubmit={ e => e.preventDefault() }>
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
                  disabled={ useKit }
                  onChange={ () => handleOptionChange({ usePro: true }) }
                  className={ classnames(sharedStyles['sr-only'], sharedStyles['input-radio-custom']) }
                />
                <label htmlFor="code_edit_icons_pro" className={ styles['option-label'] }>
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
                  disabled={ useKit }
                  onChange={ () => handleOptionChange({ usePro: false }) }
                  className={ classnames(sharedStyles['sr-only'], sharedStyles['input-radio-custom']) }
                />
                <label htmlFor="code_edit_icons_free" className={ styles['option-label'] }>
                  <span className={ sharedStyles['relative'] }>
                    <FontAwesomeIcon
                      icon={ faDotCircle }
                      size="lg"
                      fixedWidth
                      className={ sharedStyles['checked-icon'] }
                    />
                    <FontAwesomeIcon
                      icon={ faCircle }
                      size="lg"
                      fixedWidth
                      className={ sharedStyles['unchecked-icon'] }
                    />
                  </span>
                  <span className={ styles['option-label-text'] }>
                    Free
                  </span>
                </label>
              </div>
            </div>
            { usePro &&
              <Alert title='Pro requires a Font Awesome subscription' type='info'>
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
            { getDetectionStatusForOption('usePro') }
          </div>
        </div>
        <hr className={ styles['option-divider'] }/>
        <div className={ classnames( sharedStyles['flex'], sharedStyles['flex-row'] ) }>
          <div className={ styles['option-header'] }>Technology</div>
          <div className={ styles['option-choice-container'] }>
            <div className={ styles['option-choices'] }>
              <div className={ styles['option-choice'] }>
                <input
                  id="code_edit_tech_svg"
                  name="code_edit_tech"
                  type="radio"
                  value="svg"
                  checked={ technology === 'svg' }
                  disabled={ useKit }
                  onChange={ () => handleOptionChange({ technology: 'svg' }) }
                  className={ classnames(sharedStyles['sr-only'], sharedStyles['input-radio-custom']) }
                />
                <label htmlFor="code_edit_tech_svg" className={ styles['option-label'] }>
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
                  <span className={ styles['option-label-text'] }>
                    SVG
                  </span>
                </label>
              </div>
              <div className={ styles['option-choice'] }>
                <input
                  id="code_edit_tech_webfont"
                  name="code_edit_tech"
                  type="radio"
                  value="webfont"
                  checked={ technology === 'webfont' }
                  disabled={ useKit }
                  onChange={ () => handleOptionChange({
                    technology: 'webfont',
                    svgPseudoElements: false
                  }) }
                  className={ classnames(sharedStyles['sr-only'], sharedStyles['input-radio-custom']) }
                />
                <label htmlFor="code_edit_tech_webfont" className={ styles['option-label'] }>
                    <span className={ sharedStyles['relative'] }>
                      <FontAwesomeIcon
                        icon={ faDotCircle }
                        size="lg"
                        fixedWidth
                        className={ sharedStyles['checked-icon'] }
                      />
                      <FontAwesomeIcon
                        icon={ faCircle }
                        size="lg"
                        fixedWidth
                        className={ sharedStyles['unchecked-icon'] }
                      />
                    </span>
                  <span className={ styles['option-label-text'] }>
                      Web Font
                    </span>
                </label>
              </div>
            </div>
            { getDetectionStatusForOption('technology') }
          </div>
        </div>
        <div className={ classnames( sharedStyles['flex'], sharedStyles['flex-row'] ) }>
          <div className={ styles['option-header'] }></div>
          <div className={ styles['option-choice-container'] } style={{marginTop: '1em'}}>
            { technology === 'svg' &&
              <>
                <input
                  id="code_edit_features_svg_pseudo_elements"
                  name="code_edit_features"
                  type="checkbox"
                  value="svg_pseudo_elements"
                  checked={ svgPseudoElements }
                  disabled={ useKit }
                  onChange={() => handleOptionChange({ svgPseudoElements: !svgPseudoElements })}
                  className={classnames(sharedStyles['sr-only'], sharedStyles['input-checkbox-custom'])}
                />
                <label htmlFor="code_edit_features_svg_pseudo_elements" className={styles['option-label']}>
                <span className={sharedStyles['relative']}>
                  <FontAwesomeIcon
                    icon={faCheckSquare}
                    className={sharedStyles['checked-icon']}
                    size="lg"
                    fixedWidth
                  />
                  <FontAwesomeIcon
                    icon={faSquare}
                    className={sharedStyles['unchecked-icon']}
                    size="lg"
                    fixedWidth
                  />
                </span>
                  <span className={styles['option-label-text']}>
                  Enable SVG Pseudo-elements
                  <span className={styles['option-label-explanation']}>
                    Can be tricky and may be slower than other methods.
                    <br/>
                    <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements">
                      <FontAwesomeIcon icon={faExternalLinkAlt} /> Learn more
                    </a>
                  </span>
                </span>
                </label>
                { getDetectionStatusForOption('svgPseudoElements') }
              </>
            }
          </div>
        </div>
        <hr className={ styles['option-divider'] }/>
        <div className={ classnames( sharedStyles['flex'], sharedStyles['flex-row'] ) }>
          <div className={ styles['option-header'] }>Version</div>
          <div className={ styles['option-choice-container'] }>
            <div className={ styles['option-choices'] }>
              {
                useKit
                ? <span>kit version: { version }</span>
                : <select
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
              }
            </div>
            { getDetectionStatusForOption('version') }
          </div>
        </div>
        <hr className={ styles['option-divider'] }/>
        <div className={ classnames( sharedStyles['flex'], sharedStyles['flex-row'], styles['features'] ) }>
          <div className={ styles['option-header'] }>Version 4 Compatibility</div>
          <div className={ styles['option-choice-container'] }>
            <div className={ styles['option-choices'] }>
              <div className={ styles['option-choice'] }>
                <input
                  id="code_edit_v4compat_on"
                  name="code_edit_v4compat_on"
                  type="radio"
                  value={ v4Compat }
                  checked={ v4Compat }
                  onChange={ () => handleOptionChange({ v4Compat: ! v4Compat }) }
                  className={ classnames(sharedStyles['sr-only'], sharedStyles['input-radio-custom']) }
                />
                <label htmlFor="code_edit_v4compat_on" className={ styles['option-label'] }>
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
                  <span className={ styles['option-label-text'] }>
                    On
                  </span>
                </label>
              </div>
              <div className={ styles['option-choice'] }>
                <input
                  id="code_edit_v4_compat_off"
                  name="code_edit_v4_compat_off"
                  type="radio"
                  value={ ! v4Compat }
                  checked={ ! v4Compat }
                  onChange={ () => handleOptionChange({ v4Compat: ! v4Compat }) }
                  className={ classnames(sharedStyles['sr-only'], sharedStyles['input-radio-custom']) }
                />
                <label htmlFor="code_edit_v4_compat_off" className={ styles['option-label'] }>
                    <span className={ sharedStyles['relative'] }>
                      <FontAwesomeIcon
                        icon={ faDotCircle }
                        size="lg"
                        fixedWidth
                        className={ sharedStyles['checked-icon'] }
                      />
                      <FontAwesomeIcon
                        icon={ faCircle }
                        size="lg"
                        fixedWidth
                        className={ sharedStyles['unchecked-icon'] }
                      />
                    </span>
                    <span className={ styles['option-label-text'] }>
                      Off
                    </span>
                </label>
              </div>
            </div>
            { getDetectionStatusForOption('v4Compat') }
          </div>
        </div>
      </form>
    </div>
    <div className={ classnames(sharedStyles['submit-wrapper'], ['submit']) }>
      <input
        type="submit"
        name="submit"
        id="submit"
        className="button button-primary"
        value="Save Changes"
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
            ? <span className={ sharedStyles['submit-status'] }>you have pending changes</span>
            : null
      }
    </div>
  </div>
}

OptionsView.propTypes = {
  useKits: PropTypes.bool,
  optionSelector: PropTypes.func.isRequired,
  handleOptionChange: PropTypes.func.isRequired,
  handleSubmit: PropTypes.func.isRequired
}
