import React from 'react'
import styles from './KitSelectView.module.css'
import PropTypes from 'prop-types'
import { useSelector } from 'react-redux'
import get from 'lodash/get'

export default function KitConfigView({ kitToken }) {
  const kitTokenIsActive = useSelector(state => get(state, 'options.kitToken') === kitToken)
  const kitTokenApiData = useSelector(state => (state.kits || []).find(k => k.token === kitToken))

  if(!kitTokenIsActive && !kitTokenApiData) {
    throw new Error('Oh no! We could not find the kit data for the selected kit token. Try reloading this page.')
  }

  const technology = useSelector(state =>
    kitTokenIsActive
      ? state.options.technology
      : kitTokenApiData.technologySelected
  )

  const usePro = useSelector(state =>
    kitTokenIsActive
      ? state.options.usePro
      : kitTokenApiData.technologySelected === 'pro'
  )

  const v4Compat = useSelector(state =>
    kitTokenIsActive
      ? state.options.v4Compat
      : kitTokenApiData.shimEnabled
  )

  const version = useSelector(state =>
    kitTokenIsActive
      ? state.options.version
      : kitTokenApiData.version
  )

  return <div className={ styles['kit-config-view-container'] }>
    <p>version: { version }</p>
    <p>usePro: { usePro ? 'true' : 'false' }</p>
    <p>technology: { technology }</p>
    <p>v4Compat: { v4Compat ? 'true' : 'false' }</p>
  </div>
}

KitConfigView.propTypes = {
  kitToken: PropTypes.string.isRequired
}
