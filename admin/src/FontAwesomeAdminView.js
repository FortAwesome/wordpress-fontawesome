import React from 'react'
import PropTypes from 'prop-types'
import classnames from 'classnames'
import styles from './FontAwesomeAdminView.module.css'
import LoadSpecView from './LoadSpecView'
import OptionsSetter from './OptionsSetter'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faThumbsUp, faExclamationCircle } from '@fortawesome/free-solid-svg-icons'
import ClientRequirementsView from './ClientRequirementsView'
import UnregisteredClientsView from './UnregisteredClientsView'
import PluginVersionWarningsView from './PluginVersionWarningsView'

class FontAwesomeAdminView extends React.Component {

  render(){
    const { data, putData } = this.props

    const hasConflict = !!data.conflicts

    const statusLabel = hasConflict ? 'conflict' : 'good'

    return <div className={ styles['font-awesome-admin-view'] }>
      <h1>Font Awesome</h1>
      <div>
        <p className={ classnames( styles['status'], styles[statusLabel] ) }>
          <span className={ styles['status-label'] }>Status: </span>
          <FontAwesomeIcon className={ styles['icon'] } icon={ hasConflict ? faExclamationCircle : faThumbsUp }/>
        </p>
        { hasConflict
          ? <ClientRequirementsView
              clientRequirements={ data.conflicts.conflictingClientRequirements }
              conflict={ data.conflicts.requirement }
              adminClientInternal={ data.adminClientInternal }
              adminClientExternal={ data.adminClientExternal }
            />
          : <LoadSpecView spec={ data.currentLoadSpec } />
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
        />
        { !hasConflict &&
          <ClientRequirementsView
            clientRequirements={ data.clientRequirements }
            adminClientInternal={ data.adminClientInternal }
            adminClientExternal={ data.adminClientExternal }
          />
        }
        <UnregisteredClientsView clients={ data.unregisteredClients }/>
        {
          data.pluginVersionWarnings &&
          <PluginVersionWarningsView warnings={ data.pluginVersionWarnings } pluginVersion={ data.pluginVersion }/>
        }
      </div>
    </div>
  }
}

export default FontAwesomeAdminView

FontAwesomeAdminView.propTypes = {
  data: PropTypes.object,
  putData: PropTypes.func.isRequired
  // TODO: add the other props if we decide to keep them
}
