import React from 'react'
import PropTypes from 'prop-types'

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
      removeUnregisteredClients: currentOptions['remove_others']
    }

    this.handleMethodSelect = this.handleMethodSelect.bind(this)
    this.handleProCheck = this.handleProCheck.bind(this)
    this.handleV4Select = this.handleV4Select.bind(this)
    this.handlePseudoElementsSelect = this.handlePseudoElementsSelect.bind(this)
    this.handleVersionSelect = this.handleVersionSelect.bind(this)
    this.buildVersionOptions = this.buildVersionOptions.bind(this)
    this.handleRemoveUnregisteredCheck = this.handleRemoveUnregisteredCheck.bind(this)

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

  render() {
    return <table className="form-table">
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
  }
}

export default OptionsSetter

OptionsSetter.propTypes = {
  putData: PropTypes.func.isRequired,
  currentOptions: PropTypes.object.isRequired,
  releases: PropTypes.object.isRequired
}
