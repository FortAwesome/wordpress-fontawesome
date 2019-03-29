import React from 'react'
import PropTypes from 'prop-types'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faAngleDown, faAngleUp, faSpinner, faCheck, faSkull, faExternalLinkAlt, faExclamationTriangle } from '@fortawesome/free-solid-svg-icons'
import styles from './OptionsSetter.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'
import { isEqual } from 'lodash'

const UNSPECIFIED = ''
const METHOD_OPTIONS = ['webfont', 'svg', UNSPECIFIED]
const REQUIRE_FORBID_OPTIONS = ['require', 'forbid', UNSPECIFIED]

class OptionsSetter extends React.Component {
  constructor(props){
    super(props)

    this.state = {
      method: UNSPECIFIED,
      v4shim: UNSPECIFIED,
      pseudoElements: UNSPECIFIED,
      version: UNSPECIFIED,
      usePro: false,
      removeUnregisteredClients: false,
      versionOptions: null,
      lastProps: null,
      showMoreSvgPseudoElementsWarning: false
    }

    this.handleMethodSelect = this.handleMethodSelect.bind(this)
    this.handleProCheck = this.handleProCheck.bind(this)
    this.handleV4Select = this.handleV4Select.bind(this)
    this.handlePseudoElementsSelect = this.handlePseudoElementsSelect.bind(this)
    this.handleVersionSelect = this.handleVersionSelect.bind(this)
    this.handleRemoveUnregisteredCheck = this.handleRemoveUnregisteredCheck.bind(this)
    this.handleSubmitClick = this.handleSubmitClick.bind(this)
    this.toggleShowMoreSvgPseudoElementsWarning = this.toggleShowMoreSvgPseudoElementsWarning.bind(this)
  }

  static getDerivedStateFromProps(nextProps, prevState) {
    if( nextProps.isSubmitting || isEqual(prevState.lastProps, nextProps) ) {
      return null
    }

    const newState = {
      lastProps: nextProps,
      pseudoElements: nextProps.currentOptions.adminClientLoadSpec.pseudoElements || UNSPECIFIED,
      version: nextProps.currentOptions.version || UNSPECIFIED,
      v4shim: nextProps.currentOptions.adminClientLoadSpec.v4shim || UNSPECIFIED,
      method: nextProps.currentOptions.adminClientLoadSpec.method || UNSPECIFIED,
      usePro: !!nextProps.currentOptions.usePro,
      removeUnregisteredClients: !!nextProps.currentOptions.removeUnregisteredClients,
      versionOptions: OptionsSetter.buildVersionOptions(nextProps)
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
    }, { [UNSPECIFIED]: '-' })
  }

  toggleShowMoreSvgPseudoElementsWarning() {
    this.setState({ showMoreSvgPseudoElementsWarning: ! this.state.showMoreSvgPseudoElementsWarning })
  }

  handleMethodSelect(e){
    this.setState({ method: e.target.value === '-' ? UNSPECIFIED : e.target.value })
  }

  handleVersionSelect(e){
    this.setState({ version: e.target.value === '-' ? UNSPECIFIED : e.target.value })
  }

  handlePseudoElementsSelect(e){
    this.setState({ pseudoElements: e.target.value === '-' ? UNSPECIFIED : e.target.value })
  }

  handleProCheck(){
    this.setState({ usePro: !this.state.usePro })
  }

  handleRemoveUnregisteredCheck(){
    this.setState({ removeUnregisteredClients: !this.state.removeUnregisteredClients })
  }

  handleV4Select(e){
    this.setState({ v4shim: e.target.value === '-' ? UNSPECIFIED : e.target.value })
  }

  handleSubmitClick(e) {
    e.preventDefault()

    const { putData, adminClientInternal } = this.props

    putData({
      options: {
        adminClientLoadSpec: {
          name: adminClientInternal,
          method: this.state.method === UNSPECIFIED ? undefined : this.state.method,
          v4shim: this.state.v4shim === UNSPECIFIED ? undefined : this.state.v4shim,
          pseudoElements: this.state.pseudoElements === UNSPECIFIED ? undefined : this.state.pseudoElements
        },
        version: this.state.version === UNSPECIFIED ? undefined : this.state.version,
        usePro: this.state.usePro,
        removeUnregisteredClients: this.state.removeUnregisteredClients
      }
    })
  }

  render() {
    if(this.state.error) throw this.state.error

    const { hasSubmitted, isSubmitting, submitSuccess, submitMessage } = this.props

    const { method, v4shim, pseudoElements } = this.state
    const showSvgPseudoElementsWarning = 'require' === pseudoElements && 'svg' === method
    const showSvgPseudoElementsV4Warning = 'require' === pseudoElements && 'svg' === method && 'require' === v4shim
    const generalWarningCommentAboutPseudoElements =
      <p>
        In general, it's best if you avoid using
        <a href="https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements">pseudo-elements</a>
        because it can make compatibility more difficult. And with our svg technology, it can cause performance to slow
        down considerably. It's really only there to accommodate situations where you can't control the html markup
        in order to add <code>&lt;i&gt;</code> tags, or in WordPress, maybe shortcodes. So it's best if you don't
        make a habit of using pseudo-elements except where you must. And hopefully over time, the themes and plugins
        you use will migrate away from using pseudo-elements as well.
      </p>

    return <div className="options-setter">
        <h2>Options</h2>
        <p className={ sharedStyles['explanation'] }>
          You can tune these options according to your preferences, as long as your preferences
          don't conflict with the specifications required by other plugins and themes that you've installed.
        </p>
        <p className={ sharedStyles['explanation'] }>
          If conflicts are detected, they'll be shown below, and
          you might be able to resolve them just by choosing different options here.
        </p>
        {
          'require' === pseudoElements && 'svg' === method &&
          <div className={ sharedStyles['warning'] }>
            <FontAwesomeIcon icon={ faExclamationTriangle }/>
            { 'require' === v4shim
              ? <div>
              <p>
                Warning! You've enabled version 4 compatibility along with svg and pseudo-elements. You should know
                that there's a corner case that is not supported by this configuration.
              </p>
                { this.state.showMoreSvgPseudoElementsWarning &&
                <div>
                  <p>
                    We've seen cases where your WordPress theme or some beloved plugin uses version 4 pseudo-elements.
                    In the webfont case, the version 4 compatibility provided by this plugin does a pretty good job.
                    But it doesn't work for svg.
                  </p>
                  <p>
                    This may or may not be a problem in your particular situation. You'll know it's a problem because
                    you'll
                    see those dreaded empty boxes where you'd expect icons to be. If that happens with this config
                    combo,
                    then you're only viable alternative are probably to either use webfont instead of svg, or remove or
                    replace that theme or plugin.
                  </p>
                </div>
                }
              </div>
              : <p>
                Watch out! You've got both svg and pseudo-elements enabled. That's a configuration combo known to cause
                slow browser performance in some scenarios--sometimes <em>really</em> slow.
              </p>
            }
            { this.state.showMoreSvgPseudoElementsWarning &&
              generalWarningCommentAboutPseudoElements
            }
            { this.state.showMoreSvgPseudoElementsWarning
              ? <p><button onClick={ this.toggleShowMoreSvgPseudoElementsWarning } className={ sharedStyles['more-less'] }><FontAwesomeIcon icon={ faAngleUp }/> less</button></p>
              : <p><button onClick={ this.toggleShowMoreSvgPseudoElementsWarning } className={ sharedStyles['more-less'] }><FontAwesomeIcon icon={ faAngleDown }/> more</button></p>
            }
          </div>
        }
        <table className="form-table">
        <tbody>
          <tr>
            <th scope="row">
              <label htmlFor="method">Method</label>
            </th>
            <td>
              <select name="method" onChange={ this.handleMethodSelect } value={ this.state.method }>
                {
                  METHOD_OPTIONS.map((method, index) => {
                    return <option key={ index } value={ method }>{ method ? method : '-' }</option>
                  })
                }
              </select>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label htmlFor="use-pro">Use Pro</label>
            </th>
            <td>
              <input name="use-pro" checked={ this.state.usePro } value={ this.state.usePro } type="checkbox" onChange={ this.handleProCheck }/>
              <span className={styles["label-hint"]}>
                Requires a subscription.
                <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/pro"><FontAwesomeIcon icon={faExternalLinkAlt} /> Learn more</a>
                <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/account/cdn"><FontAwesomeIcon icon={faExternalLinkAlt} /> Manage my allowed domains</a>
              </span>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label htmlFor="v4shim">Version 4 Compatibility</label>
            </th>
            <td>
              <select name="v4shim" onChange={ this.handleV4Select } value={ this.state.v4shim }>
                {
                  REQUIRE_FORBID_OPTIONS.map((option, index) => {
                    return <option key={ index } value={ option }>{ option ? option : '-' }</option>
                  })
                }
              </select>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label htmlFor="pseudo-elements">Pseudo-elements Support</label>
            </th>
            <td>
              <select name="pseudo-elements" onChange={ this.handlePseudoElementsSelect } value={ this.state.pseudoElements }>
                {
                  REQUIRE_FORBID_OPTIONS.map((option, index) => {
                    return <option key={ index } value={ option }>{ option ? option : '-' }</option>
                  })
                }
              </select>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label htmlFor="version">Version</label>
            </th>
            <td>
              <select name="version" onChange={ this.handleVersionSelect } value={ this.state.version }>
                {
                  Object.keys(this.state.versionOptions).map((version, index) => {
                    return <option key={ index } value={ version }>
                      { version === UNSPECIFIED ? '-' : this.state.versionOptions[version] }
                    </option>
                  })
                }
              </select>
              {
                this.props.releaseProviderStatus && this.props.releaseProviderStatus.code !== 200 &&
                <div className={ styles['release-provider-error'] }>
                  { this.props.releaseProviderStatus.message }
                </div>
              }
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label htmlFor="remove-unregistered">Remove unregistered clients</label>
            </th>
            <td>
              <input
                name="remove-unregistered"
                checked={ this.state.removeUnregisteredClients }
                value={ this.state.removeUnregisteredClients }
                type="checkbox"
                onChange={ this.handleRemoveUnregisteredCheck }
              />
            </td>
          </tr>
        </tbody>
      </table>
      <div className="submit">
        <input
          type="submit"
          name="submit"
          id="submit"
          className="button button-primary"
          value="Save Changes"
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

export default OptionsSetter

OptionsSetter.propTypes = {
  putData: PropTypes.func.isRequired,
  currentOptions: PropTypes.object.isRequired,
  releases: PropTypes.object.isRequired,
  adminClientInternal: PropTypes.string.isRequired,
  releaseProviderStatus: PropTypes.object,
}
