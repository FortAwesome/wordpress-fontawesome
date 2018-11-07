import React from 'react'
import PropTypes from 'prop-types'

const UNSPECIFIED = ''
const METHODS = ['webfont', 'svg', UNSPECIFIED]

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
  }

  handleMethodSelect(e){
    this.setState({ method: e.target.value === '-' ? null : e.target.value })
  }

  handleProCheck(){
    this.setState({ usePro: !this.state.usePro })
  }

  render() {
    return <div className="options-setter">
      <div className="method-option">
        <span>Method: </span>
        <select onChange={ this.handleMethodSelect } value={ this.state.method }>
          {
            METHODS.map((method, index) => {
              return <option key={ index } value={ method }>{ method ? method : '-' }</option>
            })
          }
        </select>
      </div>
      <div className="pro-option">
        <span>Pro</span><input value={ this.state.usePro } type="checkbox" onChange={ this.handleProCheck }/>
      </div>
    </div>
  }
}

export default OptionsSetter

OptionsSetter.propTypes = {
  putData: PropTypes.func.isRequired,
  currentOptions: PropTypes.object.isRequired
}
