import React from 'react'
import PropTypes from 'prop-types'
import classnames from 'classnames'

const PRODUCT_BASE_NAME = 'Font Awesome'

const Component = props => {
  const { spec: {
    method,
    v4shim: usingV4Shims,
    'pseudo-elements': usingPseudoElements,
    version,
    pro
  }} = props

  const licenseType = pro ? 'Pro' : 'Free'

  return <div className="load-spec">
    <p>{ PRODUCT_BASE_NAME } <span className={ classnames('license', licenseType) }>{ licenseType }</span></p>
    <table>
      <tbody>
        <tr><td className="label">version: </td><td className="value">{ version }</td></tr>
        <tr><td className="label">method: </td><td className="value">{ method }</td></tr>
        <tr><td className="label">version 4 compatibility: </td><td className="value">{ usingV4Shims ? 'true' : 'false' }</td></tr>
        <tr><td className="label">pseudo-elements support: </td><td className="value">{ usingPseudoElements ? 'true' : 'false' }</td></tr>
      </tbody>
    </table>
  </div>
}

export default Component

Component.propTypes = {
  spec: PropTypes.object
}

