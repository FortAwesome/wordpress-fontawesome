import React from "react"
import classnames from 'classnames'
import styles from './Modal.module.css'
import { faWindowClose } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome"

export default props => (
  <div className={ classnames(styles['modal-wrapper'], styles['open']) }>
    <div className={ styles['modal-content'] }>
      { props.onClose &&
      <div className={ styles['modal-controls'] }>
        <button onClick={ () => props.onClose() }>
          <FontAwesomeIcon icon={ faWindowClose } size='2x'/>
        </button>
      </div>
      }
      { props.children }
    </div>
  </div>
)
