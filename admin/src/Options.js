import React from 'react'
import PropTypes from 'prop-types'
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
import { isEqual } from 'lodash'
import SvgPseudoElementsWarning from "./SvgPseudoElementsWarning";

const UNSPECIFIED = ''

class Options extends React.Component {
  constructor(props){
    super(props)

    this.state = {
      technology: null,
      v4compat: null,
      svgPseudoElements: null,
      version: null,
      usePro: null,
      removeConflicts: null,
      versionOptions: null,
      lastProps: null,
      formHasChanges: false
    }

    this.handleVersionSelect = this.handleVersionSelect.bind(this)
    this.handleSubmitClick = this.handleSubmitClick.bind(this)
    this.handleOptionChange = this.handleOptionChange.bind(this)
  }

  static getDerivedStateFromProps(nextProps, prevState) {
    if( nextProps.isSubmitting || isEqual(prevState.lastProps, nextProps) ) {
      return null
    }

    const newState = {
      lastProps: nextProps,
      svgPseudoElements: nextProps.currentOptions.svgPseudoElements,
      version: nextProps.currentOptions.version,
      v4compat: nextProps.currentOptions.v4compat,
      technology: nextProps.currentOptions.technology,
      usePro: !!nextProps.currentOptions.usePro,
      removeConflicts: !!nextProps.currentOptions.removeConflicts,
      versionOptions: Options.buildVersionOptions(nextProps),
      formHasChanges: false
    }

    return newState
  }

  static buildVersionOptions(props) {
    const { releases: { available, latest_version, previous_version } } = props

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
  }

  handleVersionSelect(e){
    this.setState({ version: e.target.value })
  }

  handleOptionChange(change = {}) {
    this.setState( { ...change, formHasChanges: true } )
  }

  handleSubmitClick(e) {
    e.preventDefault()

    const { putData } = this.props

    putData({
      options: {
        usePro: this.state.usePro,
        technology: this.state.technology,
        v4compat: this.state.v4compat,
        svgPseudoElements: this.state.svgPseudoElements,
        removeConflicts: this.state.removeConflicts,
        version: this.state.version
      }
    })
  }

  render() {
    if(this.state.error) throw this.state.error

    const { hasSubmitted, isSubmitting, submitSuccess, submitMessage } = this.props

    const { technology, v4compat, svgPseudoElements, usePro, removeConflicts } = this.state

    return <div className={ classnames(styles['options-setter']) }>
        <form onSubmit={ e => e.preventDefault() }>
          <hr className={ styles['option-divider'] }/>
          <div className={ classnames( sharedStyles['flex'], sharedStyles['flex-row'] ) }>
            <div className={ styles['option-header'] }>Icons</div>
            <div className={ styles['option-choice-container'] }>
              <div className={ styles['option-choices'] }>
                <div className={ styles['option-choice'] }>
                  <input
                    id="code_edit_icons_free"
                    name="code_edit_icons"
                    type="radio"
                    value="webfont"
                    checked={ ! usePro }
                    onChange={ () => this.handleOptionChange({ usePro: false }) }
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
                <div className={ styles['option-choice'] }>
                  <input
                    id="code_edit_icons_pro"
                    name="code_edit_icons"
                    type="radio"
                    value="svg"
                    checked={ usePro }
                    onChange={ () => this.handleOptionChange({ usePro: true }) }
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
              </div>
              { usePro &&
              <div className={styles['option-explanation']}>
                <p>Pro requires a subscription.</p>
                <ul>
                  <li>
                    <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/pro"><FontAwesomeIcon icon={faExternalLinkAlt} /> Learn more</a>
                  </li>
                  <li>
                    <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/account/cdn"><FontAwesomeIcon icon={faExternalLinkAlt} /> Manage my allowed domains</a>
                  </li>
                </ul>
              </div>
              }
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
                    onChange={ () => this.handleOptionChange({
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
                    onChange={ () => this.handleOptionChange({ technology: 'svg' }) }
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
                  onChange={ e => this.handleOptionChange({ version: e.target.value }) }
                  value={ this.state.version }
                >
                  {
                    Object.keys(this.state.versionOptions).map((version, index) => {
                      return <option key={ index } value={ version }>
                        { version === UNSPECIFIED ? '-' : this.state.versionOptions[version] }
                      </option>
                    })
                  }
                </select>
              </div>
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
                  onChange={ () => this.handleOptionChange({ v4compat: ! this.state.v4compat }) }
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
              </div>
              <div className={ styles['option-choice'] }>
                <input
                  id="code_edit_features_remove_conflicts"
                  name="code_edit_features"
                  type="checkbox"
                  value="remove_conflicts"
                  checked={ removeConflicts }
                  onChange={ () => this.handleOptionChange({ removeConflicts: ! this.state.removeConflicts }) }
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
                    Remove Conflicts
                    <span className={ styles['option-label-explanation'] }>
                      We'll try to detect when your theme or other plugins attempt to load their own versions of
                      Font Awesome, and then block those attempts. Normally this allows them to continue
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
                    checked={svgPseudoElements}
                    onChange={() => this.handleOptionChange({svgPseudoElements: !svgPseudoElements})}
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
                      For best compatibility, it's best to avoid using <a rel="noopener noreferrer" target="_blank"
                                                                          href="https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements">pseudo-elements</a>.
                      They're a built-in feature of webfonts and CSS, and have no performance penalty in that case.
                      But if you need to use them with SVG, then you need a little more magic <FontAwesomeIcon
                      icon={faMagic}/> which
                      may impact your site's performance.
                    </span>
                  </span>
                  </label>
                </div>
              }
              {
                svgPseudoElements
                && <SvgPseudoElementsWarning
                  v4compat={ v4compat }
                  showModal={ this.props.showPseudoElementsHelpModal }
                />
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
          disabled={ ! this.state.formHasChanges }
          onClick={ this.handleSubmitClick }
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
}

export default Options

Options.propTypes = {
  putData: PropTypes.func.isRequired,
  currentOptions: PropTypes.shape({
    technology: PropTypes.string.isRequired,
    v4compat: PropTypes.bool.isRequired,
    usePro: PropTypes.bool.isRequired,
    svgPseudoElements: PropTypes.bool.isRequired
  }).isRequired,
  releases: PropTypes.object.isRequired,
  releaseProviderStatus: PropTypes.object,
}
