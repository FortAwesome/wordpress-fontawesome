import React from 'react'
import PropTypes from 'prop-types'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faSpinner, faCheck, faSkull } from '@fortawesome/free-solid-svg-icons'
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
      versionOptions: OptionsSetter.buildVersionOptions(props),
      lastProps: props
    }

    this.handleMethodSelect = this.handleMethodSelect.bind(this)
    this.handleProCheck = this.handleProCheck.bind(this)
    this.handleV4Select = this.handleV4Select.bind(this)
    this.handlePseudoElementsSelect = this.handlePseudoElementsSelect.bind(this)
    this.handleVersionSelect = this.handleVersionSelect.bind(this)
    this.handleRemoveUnregisteredCheck = this.handleRemoveUnregisteredCheck.bind(this)
    this.handleSubmitClick = this.handleSubmitClick.bind(this)
  }

  static getDerivedStateFromProps(nextProps, prevState) {
    const newState = {
      lastProps: nextProps
    }

    if( nextProps.currentOptions['load_spec']['pseudo-elements'] !== prevState.lastProps.currentOptions['load_spec']['pseudo-elements'] ) {
      newState.pseudoElements = nextProps.currentOptions['load_spec']['pseudo-elements'] || UNSPECIFIED
    }

    if( nextProps.currentOptions['load_spec']['version'] !== prevState.lastProps.currentOptions['load_spec']['version'] ) {
      newState.version = nextProps.currentOptions['load_spec']['version'] || UNSPECIFIED
    }

    if( nextProps.currentOptions['load_spec']['v4shim'] !== prevState.lastProps.currentOptions['load_spec']['v4shim'] ) {
      newState.v4shim = nextProps.currentOptions['load_spec']['v4shim'] || UNSPECIFIED
    }

    if( nextProps.currentOptions['load_spec']['method'] !== prevState.lastProps.currentOptions['load_spec']['method'] ) {
      newState.method = nextProps.currentOptions['load_spec']['method'] || UNSPECIFIED
    }

    if( nextProps.currentOptions['pro'] !== prevState.lastProps.currentOptions['pro'] ) {
      newState.usePro = nextProps.currentOptions['load_spec']['pro']
    }

    if( nextProps.currentOptions['remove_others'] !== prevState.lastProps.currentOptions['remove_others'] ) {
      newState.removeUnregisteredClients = nextProps.currentOptions['load_spec']['remove_others']
    }

    if (! isEqual(nextProps.releases, prevState.lastProps.releases)) {
      newState.versionOptions = OptionsSetter.buildVersionOptions(nextProps)
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

    const { putData } = this.props

    putData({
      options: {
        load_spec: {
          name: 'user',
          method: this.state.method === UNSPECIFIED ? undefined : this.state.method,
          v4shim: this.state.v4shim === UNSPECIFIED ? undefined : this.state.v4shim,
          'pseudo-elements': this.state.pseudoElements === UNSPECIFIED ? undefined : this.state.pseudoElements,
          version: this.state.version === UNSPECIFIED ? undefined : this.state.version,
        },
        pro: this.state.usePro,
        'remove_others': this.state.removeUnregisteredClients
      }
    })
  }

  render() {
    if(this.state.error) throw this.state.error

    const { hasSubmitted, isSubmitting, submitSuccess, submitMessage } = this.props

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
              <input name="use-pro" value={ this.state.usePro } type="checkbox" onChange={ this.handleProCheck }/>
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
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label htmlFor="remove-unregistered">Remove unregistered clients</label>
            </th>
            <td>
              <input
                name="remove-unregistered"
                value={ this.state.removeUnregisteredClients }
                type="checkbox"
                onChange={ this.handleRemoveUnregisteredCheck }
              />
            </td>
          </tr>
        </tbody>
      </table>
      <p className="submit">
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
            : <span className={ classnames(styles['submit-status'], styles['fail']) }>
                <FontAwesomeIcon className={ styles['icon'] } icon={ faSkull } />
                <span className={ styles['explanation'] }>
                  { submitMessage }
                </span>
              </span>
          )
        }
        {isSubmitting &&
          <span className={ classnames(styles['submit-status'], styles['submitting']) }>
            <FontAwesomeIcon className={ styles['icon'] } icon={faSpinner} spin/>
          </span>
        }
      </p>
    </div>

  }
}

export default OptionsSetter

OptionsSetter.propTypes = {
  putData: PropTypes.func.isRequired,
  currentOptions: PropTypes.object.isRequired,
  releases: PropTypes.object.isRequired
}
