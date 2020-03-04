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
import { __ } from '@wordpress/i18n'
import { __experimentalCreateInterpolateElement } from '@wordpress/element'

export default function KitConfigView({ kitToken }) {
  const kitTokenIsActive = useSelector(state => get(state, 'options.kitToken') === kitToken)
  const kitTokenApiData = useSelector(state => (state.kits || []).find(k => k.token === kitToken))
  const pendingOptionConflicts = useSelector(state => state.pendingOptionConflicts)
  const hasChecked = useSelector(state => state.preferenceConflictDetection.hasChecked)
  const preferenceCheckSuccess = useSelector(state => state.preferenceConflictDetection.success)

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
      return <Alert title={ __( 'Preference Conflict', 'font-awesome' ) } type='warning'>
        {
          size(pendingOptionConflicts[option]) > 1
          ? <div>
            { __( 'This change might cause problems for these themes or plugins:', 'font-awesome' ) } { pendingOptionConflicts[option].join(', ') }.
          </div>
          : <div>
            { __( 'This change might cause problems for the theme or plugin:', 'font-awesome' ) } { pendingOptionConflicts[option][0] }.
            </div>
        }
      </Alert>
    } else {
      return null
    }
  }

  return (!kitTokenIsActive && !kitTokenApiData) 
    ? <Alert type="warning" title={ __('Oh no! We could not find the kit data for the selected kit token.', 'font-awesome' )}>
        {
          __( 'Try reloading.', 'font-awesome' )
        }
      </Alert>
    : <div className={ styles['kit-config-view-container'] }>
        <table className={ styles['selected-kit-settings'] }>
          <tbody>
            <tr>
              <th className={ styles['label'] }>{ __( 'Icons', 'font-awesome' ) }</th>
              <td className={ styles['value'] }>
                { usePro ? 'Pro' : 'Free' }
                { getDetectionStatusForOption('usePro') }
              </td>
            </tr>
            <tr>
              <th className={ styles['label'] }>{ __( 'Technology', 'font-awesome' ) }</th>
              <td className={ styles['value'] }>
                { technology }
                { getDetectionStatusForOption('technology') }
              </td>
            </tr>
            <tr>
              <th className={ styles['label'] }>{ __( 'Version', 'font-awesome' ) }</th>
              <td className={ styles['value'] }>
                { version }
                { getDetectionStatusForOption('version') }
              </td>
            </tr>
            <tr>
              <th className={ styles['label'] }>{ __( 'Version 4 Compatability', 'font-awesome' ) }</th>
              <td className={ styles['value'] }>
                { v4Compat ? 'On' : 'Off' }
                { getDetectionStatusForOption('v4Compat') }
              </td>
            </tr>
          </tbody>
        </table>
        <p className={ styles['tip-text'] }>
          {
            __experimentalCreateInterpolateElement(
              __( 'Make changes on <a>fontawesome.com/kits <externalLinkIcon/></a>', 'font-awesome' ),
              {
                // eslint-disable-next-line jsx-a11y/anchor-has-content
                a: <a target="_blank" rel="noopener noreferrer" href="https://fontawesome.com/kits" />,
                externalLinkIcon: <FontAwesomeIcon icon={faExternalLinkAlt} style={{marginLeft: '.5em'}} />
              }
            )
          }
        </p>
      </div>
}

KitConfigView.propTypes = {
  kitToken: PropTypes.string.isRequired
}
