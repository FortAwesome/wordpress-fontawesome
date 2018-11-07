import React from 'react'
import PropTypes from 'prop-types'
import classnames from 'classnames'
import styles from './FontAwesomeAdminView.module.css'
import LoadSpecView from './LoadSpecView'
import OptionsSetter from './OptionsSetter'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faThumbsUp, faExclamationCircle } from '@fortawesome/free-solid-svg-icons'

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
        <LoadSpecView spec={ data.currentLoadSpec } />
        <OptionsSetter releases={ data.releases } currentOptions={ data.options } putData={ putData }/>
      </div>
    </div>
  }
}

export default FontAwesomeAdminView

FontAwesomeAdminView.propTypes = {
  data: PropTypes.object,
  putData: PropTypes.func.isRequired
}