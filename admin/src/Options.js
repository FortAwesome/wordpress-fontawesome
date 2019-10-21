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
  faExternalLinkAlt } from '@fortawesome/free-solid-svg-icons'
import { faCircle, faSquare } from '@fortawesome/free-regular-svg-icons'
import styles from './Options.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'
import { has, size } from 'lodash'
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
            </div>
            { getDetectionStatus('technology') }
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
                    Can be tricky and may be slower than other methods.
                    <br/>
                    <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements">
                      <FontAwesomeIcon icon={faExternalLinkAlt} /> Learn more
                    </a>
                  </span>
                </span>
                </label>
                { getDetectionStatus('svgPseudoElements') }
              </>
            }
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
                  Automatically use Font Awesome 5 for any version 4 icons already on your site, including those used by themes or plugins, without worrying about new syntax and name changes.
                  <br/>
                  <a rel="noopener noreferrer" target="_blank" href="https://staging.fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4">
                    <FontAwesomeIcon icon={faExternalLinkAlt} /> More info
                  </a>
                  </span>
                </span>
              </label>
              { getDetectionStatus('v4compat') }
            </div>
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
