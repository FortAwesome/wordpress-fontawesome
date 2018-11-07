import React from 'react'
import PropTypes from 'prop-types'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faSpinner, faCheck, faSkull } from '@fortawesome/free-solid-svg-icons'
import styles from './OptionsSetter.module.css'
import classnames from 'classnames'

const UNSPECIFIED = ''
const METHOD_OPTIONS = ['webfont', 'svg', UNSPECIFIED]
const REQUIRE_FORBID_OPTIONS = ['require', 'forbid', UNSPECIFIED]

class OptionsSetter extends React.Component {
  constructor(props){
    super(props)

    const { currentOptions } = props

    this.state = {
      method: currentOptions.method || UNSPECIFIED,
      v4shim: currentOptions.v4shim || UNSPECIFIED,
      pseudoElements: currentOptions['pseudo-elements'] || UNSPECIFIED,
      version: currentOptions.version || UNSPECIFIED,
      usePro: currentOptions.pro,
      removeUnregisteredClients: currentOptions['remove_others'],
      isSubmitting: false,
      hasSubmitted: false,
      submitSuccess: false,
      submitMessage: null,
      error: null
    }

    this.handleMethodSelect = this.handleMethodSelect.bind(this)
    this.handleProCheck = this.handleProCheck.bind(this)
    this.handleV4Select = this.handleV4Select.bind(this)
    this.handlePseudoElementsSelect = this.handlePseudoElementsSelect.bind(this)
    this.handleVersionSelect = this.handleVersionSelect.bind(this)
    this.buildVersionOptions = this.buildVersionOptions.bind(this)
    this.handleRemoveUnregisteredCheck = this.handleRemoveUnregisteredCheck.bind(this)
    this.handleSubmitClick = this.handleSubmitClick.bind(this)

    this.versionOptions = this.buildVersionOptions()
  }

  buildVersionOptions() {
    const { releases: { available, latest_version, previous_version } } = this.props

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

    this.setState({ isSubmitting: true, hasSubmitted: false })

    putData({
      options: {
        method: this.state.method === UNSPECIFIED ? undefined : this.state.method,
        v4shim: this.state.v4shim === UNSPECIFIED ? undefined : this.state.v4shim,
        'pseudo-elements': this.state.pseudoElements === UNSPECIFIED ? undefined : this.state.pseudoElements,
        version: this.state.version === UNSPECIFIED ? undefined : this.state.version,
        pro: this.state.usePro,
        'remove_others': this.state.removeUnregisteredClients
      }
    })
    .then(response => {
      const { status } = response
      if(200 === status) {
        this.setState({ isSubmitting: false, hasSubmitted: true, error: null, submitSuccess: true, submitMessage: "Changes saved" })
      } else {
        this.setState({ isSubmitting: false, hasSubmitted: true, error: null, submitSuccess: false, submitMessage: "Failed to save changes" })
      }
    })
    .catch(error => {
      const { response: { data: { code, message }}} = error
      let submitMessage = ""

      switch(code) {
        case 'cant_update':
          submitMessage = message
          break
        case 'rest_no_route':
        case 'rest_cookie_invalid_nonce':
          submitMessage = "Sorry, we couldn't reach the server"
          break
        default:
          submitMessage = "Update failed"
      }
      this.setState({ isSubmitting: false, hasSubmitted: true, error: null, submitSuccess: false, submitMessage })
    })
  }

  render() {
    if(this.state.error) throw this.state.error

    const { hasSubmitted, isSubmitting, submitSuccess } = this.state

    return <div className="options-setter">
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
                  Object.keys(this.versionOptions).map((version, index) => {
                    return <option key={ index } value={ version }>
                      { version === UNSPECIFIED ? '-' : this.versionOptions[version] }
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
                  { this.state.submitMessage }
                </span>
              </span>
            : <span className={ classnames(styles['submit-status'], styles['fail']) }>
                <FontAwesomeIcon className={ styles['icon'] } icon={ faSkull } />
                <span className={ styles['explanation'] }>
                  { this.state.submitMessage }
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
