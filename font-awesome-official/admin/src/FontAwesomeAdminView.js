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
      <div className={ classnames( styles['status'], styles[statusLabel] ) }>
        <p>
          <span className={ styles['status-label'] }>Status: </span><span className={ styles['status-value'] }>{ statusLabel }</span>
        </p>
        { hasConflict
          ?
          <div></div>
          :
          <div className="load-spec-container">
            <LoadSpecView spec={ data.currentLoadSpec } />
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