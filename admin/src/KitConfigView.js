import React from 'react'
import styles from './KitSelectView.module.css'
import PropTypes from 'prop-types'
import { useSelector } from 'react-redux'

export default function KitConfigView({ kitToken }) {
  const kit = useSelector(state => (state.kits || []).find(k => k.token === kitToken))

  if(!kit) {
    throw new Error('We could not find a kit for the given kitToken. Try reloading this page.')
  }

  const {
    licenseSelected,
    name,
    shimEnabled,
    technologySelected,
    version
    // The following kit properties are also available, though they do not
    // have corollaries to the CDN-based configuration alternative.

    /*
    useIntegrityHash,
    autoAccessibilityEnabled,
    integrityHash,
    minified,
    */
  } = kit

  return <div className={ styles['kit-config-view-container'] }>
    <p>name: { name }</p>
    <p>version: { version }</p>
    <p>licenseSelected: { licenseSelected }</p>
    <p>technologySelected: { technologySelected }</p>
    <p>shimEnabled (V4 Compatibility): { shimEnabled ? 'true' : 'false' }</p>
  </div>
}

KitConfigView.propTypes = {
  kitToken: PropTypes.string.isRequired
}
