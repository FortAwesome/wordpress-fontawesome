import React from 'react'
import PropTypes from 'prop-types'
import styles from './Alert.module.css'
import classnames from 'classnames'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import {
  faInfoCircle,
  faThumbsUp,
  faSpinner,
  faExclamationTriangle } from '@fortawesome/free-solid-svg-icons'

function getIcon(props = {}){
  switch(props.type){
    case 'info':
      return <FontAwesomeIcon icon={ faInfoCircle } size='lg' title='info' fixedWidth />
    case 'warning':
      return <FontAwesomeIcon icon={ faExclamationTriangle } title='warning' size='lg' fixedWidth />
    case 'pending':
      return <FontAwesomeIcon icon={ faSpinner } title='pending' spin size='lg' fixedWidth />
    case 'success':
      return <FontAwesomeIcon icon={ faThumbsUp } title='success' size='lg' fixedWidth />
    default:
      return <FontAwesomeIcon icon={ faExclamationTriangle } title='warning' size='lg' fixedWidth />
  }
}

function Alert(props = {}) {
  return<div className={ classnames(styles['alert'], styles[`alert-${ props.type }`]) } role="alert">
    <div className={ styles['alert-icon'] }>
      { getIcon(props) }
    </div>
    <div className={ styles['alert-message'] }>
      <h2 className={ styles['alert-title'] }>
        { props.title }
      </h2>
      <div className={ styles['alert-copy'] }>
        { props.children }
      </div>
    </div>
  </div>
}

Alert.propTypes = {
  title: PropTypes.string.isRequired,
  type: PropTypes.oneOf(['info', 'warning', 'success', 'pending']),
  children: PropTypes.oneOfType([
    PropTypes.object,
    PropTypes.string,
    PropTypes.arrayOf(PropTypes.element)
  ]).isRequired
}

export default Alert
