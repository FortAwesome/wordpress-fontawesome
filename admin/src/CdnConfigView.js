import { useSelector, useDispatch } from 'react-redux'
import {
  addPendingOption,
  checkPreferenceConflicts
} from './store/actions'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import {
  faDotCircle,
  faCheckSquare,
  faExternalLinkAlt } from '@fortawesome/free-solid-svg-icons'
import { faCircle, faSquare } from '@fortawesome/free-regular-svg-icons'
import styles from './CdnConfigView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'
import Alert from './Alert'
import PropTypes from 'prop-types'
import { __ } from '@wordpress/i18n'

const UNSPECIFIED = ''

export default function CdnConfigView({ useOption, handleSubmit }) {
  const usePro = useOption('usePro')
  const technology = useOption('technology')
  const version = useOption('version')
  const v4Compat = useOption('v4Compat')
  const pseudoElements = useOption('pseudoElements')

  const pendingOptions = useSelector(state => state.pendingOptions)
  const pendingOptionConflicts = useSelector(state => state.pendingOptionConflicts)
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

  const dispatch = useDispatch()

  function handleOptionChange(change = {}, check = true) {
    const pendingTechnology = _.get( change, 'technology' )

    const adjustedChange = pendingTechnology
      ? 'webfont' === pendingTechnology
        ? { ...change, pseudoElements: true }
        : { ...change, pseudoElements: false }
      : change

    dispatch(addPendingOption(adjustedChange))
    check && dispatch(checkPreferenceConflicts())
  }

  function getDetectionStatusForOption(option) {
    if(_.has(pendingOptions, option)) {
      if ( hasChecked && ! preferenceCheckSuccess ) {
        return <Alert title={ __( 'Error checking preferences', 'font-awesome' ) } type='warning'>
          <p>{ preferenceCheckMessage }</p>
        </Alert>
      } else if (_.has(pendingOptionConflicts, option)) {
        return <Alert title={ __( 'Preference Conflict', 'font-awesome' ) } type='warning'>
            {
              _.size(pendingOptionConflicts[option]) > 1
              ? <div>
                { __( 'This change might cause problems for these themes or plugins', 'font-awesome' ) }: { pendingOptionConflicts[option].join(', ') }.
              </div>
              : <div>
                { __( 'This change might cause problems for the theme or plugin', 'font-awesome' ) }: { pendingOptionConflicts[option][0] }.
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
        <div className={ classnames( sharedStyles['flex'], sharedStyles['flex-row'] ) }>
          <div className={ styles['option-header'] }>Icons</div>
          <div className={ styles['option-choice-container'] }>
            <div className={ styles['option-choices'] }>
              <div className={ styles['option-choice'] }>
                <input
                  id="code_edit_icons_pro"
                  name="code_edit_icons"
                  type="radio"
                  checked={ usePro }
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
                  checked={ ! usePro }
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
              <Alert title={ __( 'Heads up! Pro requires a Font Awesome subscription', 'font-awesome' ) } type='info'>
              <p>And you need to add your WordPress site to the allowed domains for your CDN.</p>
                <ul>
                  <li>
                    <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/account/cdn">{ __( 'Manage my allowed domains', 'font-awesome' ) }<FontAwesomeIcon icon={faExternalLinkAlt} style={{marginLeft: '.5em'}} /></a>
                  </li>
                  <li>
                    <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/pro">{ __( 'Get Pro', 'font-awesome' ) }<FontAwesomeIcon icon={faExternalLinkAlt} style={{marginLeft: '.5em'}} /></a>
                  </li>
                </ul>
              </Alert>
            }
            { getDetectionStatusForOption('usePro') }
          </div>
        </div>
        <hr className={ styles['option-divider'] }/>
        <div className={ classnames( sharedStyles['flex'], sharedStyles['flex-row'] ) }>
          <div className={ styles['option-header'] }>{ __( 'Technology', 'font-awesome' ) }</div>
          <div className={ styles['option-choice-container'] }>
            <div className={ styles['option-choices'] }>
              <div className={ styles['option-choice'] }>
                <input
                  id="code_edit_tech_svg"
                  name="code_edit_tech"
                  type="radio"
                  checked={ technology === 'svg' }
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
                    { __( 'SVG', 'font-awesome' ) }
                  </span>
                </label>
              </div>
              <div className={ styles['option-choice'] }>
                <input
                  id="code_edit_tech_webfont"
                  name="code_edit_tech"
                  type="radio"
                  checked={ technology === 'webfont' }
                  onChange={ () => handleOptionChange({
                    technology: 'webfont',
                    pseudoElements: false
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
                      { __( 'Web Font', 'font-awesome' ) }
                      {
                        technology === 'webfont' &&
                          <span className={styles['option-label-explanation']}>
                            { __( 'CSS Pseudo-elements are enabled by default with Web Font', 'font-awesome' ) }
                          </span>
                      }
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
                  id="code_edit_features_pseudo_elements"
                  name="code_edit_features"
                  type="checkbox"
                  checked={ pseudoElements }
                  onChange={() => handleOptionChange({ pseudoElements: !pseudoElements })}
                  className={classnames(sharedStyles['sr-only'], sharedStyles['input-checkbox-custom'])}
                />
                <label htmlFor="code_edit_features_pseudo_elements" className={styles['option-label']}>
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
                    { __( 'Enable CSS Pseudo-elements with SVG', 'font-awesome' ) }
                    <span className={styles['option-label-explanation']}>
                      { __( 'May cause performance issues.', 'font-awesome' ) } <a rel="noopener noreferrer" target="_blank" style={{marginLeft: '.5em'}} href="https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements">
                        { __( 'Learn more', 'font-awesome' ) } <FontAwesomeIcon icon={faExternalLinkAlt} style={{marginLeft: '.5em'}} />
                      </a>
                    </span>
                  </span>
                </label>
                { getDetectionStatusForOption('pseudoElements') }
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
                    { __( 'On', 'font-awesome' ) }
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
                      { __( 'Off', 'font-awesome' ) }
                    </span>
                </label>
              </div>
            </div>
            { getDetectionStatusForOption('v4Compat') }
          </div>
        </div>
      </form>
  </div>
}

CdnConfigView.propTypes = {
  useOption: PropTypes.func.isRequired,
  handleOptionChange: PropTypes.func.isRequired,
  handleSubmit: PropTypes.func.isRequired
}
