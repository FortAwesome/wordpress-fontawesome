import React from 'react'
import PropTypes from 'prop-types'
import classnames from 'classnames'
import LoadSpecView from './LoadSpecView'
import OptionsSetter from './OptionsSetter'

class FontAwesomeAdminView extends React.Component {

  render(){
    const { data, putData } = this.props

    const hasConflict = !!data.conflicts

    const statusLabel = hasConflict ? 'conflict' : 'good'

    const statusClasses = classnames( 'status', statusLabel )

    return <div className="font-awesome-admin-view">
      <h1>Font Awesome</h1>
      <div className={statusClasses}>
        <p>
          <span className="status-label">Status: </span><span className="status-value">{ statusLabel }</span>
        </p>
        { hasConflict
          ?
          <div></div>
          :
          <div className="load-spec-container">
            <p><span className="loaded-label">Loaded: </span></p>
            <LoadSpecView spec={ data.currentLoadSpec } />
            <OptionsSetter currentOptions={ data.options } putData={ putData }/>
          </div>
        }
      </div>
    </div>
  }
}

export default FontAwesomeAdminView

FontAwesomeAdminView.propTypes = {
  data: PropTypes.object,
  putData: PropTypes.func.isRequired
}