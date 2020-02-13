import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import {
  faExternalLinkAlt, 
  faExclamationTriangle
 } from '@fortawesome/free-solid-svg-icons'
import styles from './KitSelectView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'
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
      : kitTokenApiData.technologySelected === 'svg'
        ? 'svg'
        : 'webfont'
  )

  const usePro = useSelector(state =>
    kitTokenIsActive
      ? state.options.usePro
      : kitTokenApiData.licenseSelected === 'pro'
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
  <p>Settings for [selected kit name or token] kit at last refresh</p>
    <table className={ styles['selected-kit-settings'] }>
      <tr>
        <th className={ styles['label'] }>Icons</th>
        <td className={ styles['value'] }>{ usePro ? 'Pro' : 'Free' }
        <div class="Alert_alert__9rB-8 Alert_alert-warning__a4JcD" role="alert"><div class="Alert_alert-icon__33P-T"><FontAwesomeIcon icon={ faExclamationTriangle } title='warning' fixedWidth /></div><div class="Alert_alert-message__1QY5M"><h2 class="Alert_alert-title__p2H1b">Preference Conflict</h2><div><div>This setting might cause problems for the theme or plugin: eta-plugin.</div></div></div></div>
        </td>
      </tr>
      <tr>
        <th className={ styles['label'] }>Technology</th>
        <td className={ styles['value'] }>{ technology }</td>
      </tr>
      <tr>
        <th className={ styles['label'] }>Version</th>
        <td className={ styles['value'] }>{ version }</td>
      </tr>
      <tr>
        <th className={ styles['label'] }>Version 4 Compatability</th>
        <td className={ styles['value'] }>{ v4Compat ? 'On' : 'Off' }</td>
      </tr>
    </table>
    <p className={ styles['option-label-explanation'] }>Make changes on <a target="_blank" href="https://fontawesome.com/kits">fontawesome.com <FontAwesomeIcon icon={faExternalLinkAlt} /></a> and then refresh.</p>
  </div>
}

KitConfigView.propTypes = {
  kitToken: PropTypes.string.isRequired
}
