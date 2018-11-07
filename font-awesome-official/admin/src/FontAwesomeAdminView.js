import React from 'react'
import PropTypes from 'prop-types'
import classnames from 'classnames'
import styles from './FontAwesomeAdminView.module.css'
import LoadSpecView from './LoadSpecView'
import OptionsSetter from './OptionsSetter'

class FontAwesomeAdminView extends React.Component {

  render(){
    const { data, putData } = this.props

    const hasConflict = !!data.conflicts

    const statusLabel = hasConflict ? 'conflict' : 'good'

    return <div className={ styles['font-awesome-admin-view'] }>
      <h1>Font Awesome</h1>
      <div>
        <p className={ classnames( styles['status'], styles[statusLabel] ) }>
          <span className={ styles['status-label'] }>Status: </span><span className={ styles['status-value'] }>{ statusLabel }</span>
        </p>
        { hasConflict
          ?
          <div>(not yet implemented)</div>
          :
          <div className="load-spec-container">
            <h2>Current Load Specification</h2>
            <LoadSpecView spec={ data.currentLoadSpec } />
            <h2>Options</h2>
            <p className={ styles['options-disclaimer'] }>
              You can tune these options according to your preferences, as long as your preferences
              don't conflict with the specifications required by other plugins and themes that you've installed.
            </p>
            <p className={ styles['options-disclaimer'] }>
              If conflicts are detected, they'll be shown below, and
              you might be able to resolve them just by choosing different options here.
            </p>
            <OptionsSetter releases={ data.releases } currentOptions={ data.options } putData={ putData }/>
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