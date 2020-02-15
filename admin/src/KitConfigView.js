import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faExternalLinkAlt } from '@fortawesome/free-solid-svg-icons'
import styles from './KitSelectView.module.css'
import PropTypes from 'prop-types'
import { useSelector } from 'react-redux'
import Alert from './Alert'
import get from 'lodash/get'
import has from 'lodash/has'
import size from 'lodash/size'

export default function KitConfigView({ kitToken }) {
  const kitTokenIsActive = useSelector(state => get(state, 'options.kitToken') === kitToken)
  const kitTokenApiData = useSelector(state => (state.kits || []).find(k => k.token === kitToken))
  const pendingOptionConflicts = useSelector(state => state.pendingOptionConflicts)
  const hasChecked = useSelector(state => state.preferenceConflictDetection.hasChecked)
  const preferenceCheckSuccess = useSelector(state => state.preferenceConflictDetection.success)

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

  function getDetectionStatusForOption(option) {
    if ( hasChecked && preferenceCheckSuccess && has(pendingOptionConflicts, option) ) {
      return <Alert title="Preference Conflict" type='warning'>
        {
          size(pendingOptionConflicts[option]) > 1
          ? <div>
            This change might cause problems for these themes or plugins: { pendingOptionConflicts[option].join(', ') }.
          </div>
          : <div>
            This change might cause problems for the theme or plugin: { pendingOptionConflicts[option][0] }.
            </div>
        }
      </Alert>
    } else {
      return null
    }
  }

  return <div className={ styles['kit-config-view-container'] }>
    <table className={ styles['selected-kit-settings'] }>
      <tbody>
        <tr>
          <th className={ styles['label'] }>Icons</th>
          <td className={ styles['value'] }>
            { usePro ? 'Pro' : 'Free' }
            { getDetectionStatusForOption('usePro') }
          </td>
        </tr>
        <tr>
          <th className={ styles['label'] }>Technology</th>
          <td className={ styles['value'] }>
            { technology }
            { getDetectionStatusForOption('technology') }
          </td>
        </tr>
        <tr>
          <th className={ styles['label'] }>Version</th>
          <td className={ styles['value'] }>
            { version }
            { getDetectionStatusForOption('version') }
          </td>
        </tr>
        <tr>
          <th className={ styles['label'] }>Version 4 Compatability</th>
          <td className={ styles['value'] }>
            { v4Compat ? 'On' : 'Off' }
            { getDetectionStatusForOption('v4Compat') }
          </td>
        </tr>
      </tbody>
    </table>
    <p className={ styles['tip-text'] }>Make changes on <a target="_blank" rel="noopener noreferrer" href="https://fontawesome.com/kits">fontawesome.com <FontAwesomeIcon icon={faExternalLinkAlt} /></a> and then refresh.</p>
  </div>
}

KitConfigView.propTypes = {
  kitToken: PropTypes.string.isRequired
}
