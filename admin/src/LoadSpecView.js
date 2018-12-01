import React from 'react'
import PropTypes from 'prop-types'
import classnames from 'classnames'
import styles from './LoadSpecView.module.css'

const PRODUCT_BASE_NAME = 'Font Awesome'

const LoadSpecView = props => {
  const { usePro, spec: {
    method,
    v4shim,
    pseudoElements,
    version,
  }} = props

  const licenseType = usePro ? 'Pro' : 'Free'

  return <div className={styles['load-spec']}>
    <h2>Current Load Specification</h2>
    <table className={classnames('widefat', 'striped')}>
      <tbody>
      <tr>
        <td className={styles['label']}>Product</td>
        <td className={styles['value']}>{PRODUCT_BASE_NAME} <span
          className={classnames('license', licenseType)}>{ licenseType }</span></td>
      </tr>
      <tr>
        <td className={styles['label']}>Version</td>
        <td className={styles['value']}>{version}</td>
      </tr>
      <tr>
        <td className={styles['label']}>Method</td>
        <td className={styles['value']}>{method}</td>
      </tr>
      <tr>
        <td className={styles['label']}>Version 4 compatibility</td>
        <td className={styles['value']}>{v4shim ? 'true' : 'false'}</td>
      </tr>
      <tr>
        <td className={styles['label']}>Pseudo-elements support</td>
        <td className={styles['value']}>{pseudoElements ? 'true' : 'false'}</td>
      </tr>
      </tbody>
    </table>
  </div>
}

export default LoadSpecView

LoadSpecView.propTypes = {
  spec: PropTypes.object.isRequired,
  usePro: PropTypes.boolean
}

