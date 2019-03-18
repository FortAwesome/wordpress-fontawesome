import React from 'react'
import PropTypes from 'prop-types'
import classnames from 'classnames'
import styles from './FontAwesomeAdminView.module.css'
import LoadSpecView from './LoadSpecView'
import OptionsSetter from './OptionsSetter'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faThumbsUp, faExclamationCircle, faExclamationTriangle } from '@fortawesome/free-solid-svg-icons'
import ClientRequirementsView from './ClientRequirementsView'
import UnregisteredClientsView from './UnregisteredClientsView'
import PluginVersionWarningsView from './PluginVersionWarningsView'
import V3DeprecationWarning from './V3DeprecationWarning'
import { values } from 'lodash'

class FontAwesomeAdminView extends React.Component {

  getStatus(hasConflict, haslockedLoadSpec) {
    if( hasConflict ) {
      if ( haslockedLoadSpec ) {
        return {
          statusLabel: 'warning',
          statusIcon: faExclamationTriangle
        }
      } else {
        return {
          statusLabel: 'conflict',
          statusIcon: faExclamationCircle
        }
      }
    } else {
      return {
        statusLabel: 'good',
        statusIcon: faThumbsUp
      }
    }
  }

  render(){
    const { data, putData } = this.props

    const hasConflict = !!data.conflicts

    const { statusLabel, statusIcon } = this.getStatus( hasConflict, !!data.options.lockedLoadSpec )

    return <div className={ styles['font-awesome-admin-view'] }>
      <h1>Font Awesome</h1>
      <div>
        <p className={ classnames( styles['status'], styles[statusLabel] ) }>
          <span className={ styles['status-label'] }>Status: </span>
          <FontAwesomeIcon className={ styles['icon'] } icon={ statusIcon }/>
        </p>
        <V3DeprecationWarning wpApiSettings={ this.props.wpApiSettings }/>
        { data.options.lockedLoadSpec &&
          <LoadSpecView spec={ data.options.lockedLoadSpec } usePro={ data.options.usePro } version={ data.options.version } />
        }
        { hasConflict &&
          <ClientRequirementsView
            clientRequirements={data.conflicts.conflictingClientRequirements}
            conflict={data.conflicts.requirement}
            hasLockedLoadSpec={ !!data.options.lockedLoadSpec }
            adminClientInternal={data.adminClientInternal}
            adminClientExternal={data.adminClientExternal}
          />
        }
        <OptionsSetter
          releases={ data.releases }
          currentOptions={ data.options }
          putData={ putData }
          isSubmitting={ this.props.isSubmitting }
          hasSubmitted={ this.props.hasSubmitted }
          submitSuccess={ this.props.submitSuccess }
          submitMessage={ this.props.submitMessage }
          error={ this.props.error }
          adminClientInternal={ data.adminClientInternal }
          releaseProviderStatus={ data.releaseProviderStatus }
        />
        { !hasConflict &&
          <ClientRequirementsView
            clientRequirements={ values( data.clientRequirements ) }
            adminClientInternal={ data.adminClientInternal }
            adminClientExternal={ data.adminClientExternal }
          />
        }
        <UnregisteredClientsView clients={ data.unregisteredClients }/>
        {
          data.pluginVersionWarnings &&
          <PluginVersionWarningsView warnings={ values(data.pluginVersionWarnings) } pluginVersion={ data.pluginVersion }/>
        }
      </div>
    </div>
  }
}

export default FontAwesomeAdminView

FontAwesomeAdminView.propTypes = {
  data: PropTypes.object,
  putData: PropTypes.func.isRequired,
  wpApiSettings: PropTypes.object.isRequired
  // TODO: add the other props if we decide to keep them
}
