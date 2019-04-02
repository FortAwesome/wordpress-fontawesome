import React from "react"
import classnames from 'classnames'
import PropTypes from 'prop-types'
import styles from './Modal.module.css'
import { faWindowClose } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome"

class Modal extends React.Component {

  constructor(props) {
    super(props)

    this.handleEscape = this.handleEscape.bind(this)
  }

  handleEscape(e) {
    const { onClose } = this.props
    console.log(`DEBUG: handleEscape`)
    if(27 === e.keyCode){
      onClose()
    }
  }

  componentDidMount() {
    document.addEventListener('keyup', this.handleEscape, false)
  }

  componentWillUnmount() {
    document.removeEventListener('keyup', this.handleEscape, false)
  }

  render() {
    const { onClose, children } = this.props

    return <div
      onKeyUp={ e => { /* 27 === e.keyCode && props.onClose() */ console.log("DEBUG: e.keyCode:", e.keyCode) } }
      className={ classnames(styles['modal-wrapper'], styles['open']) }>
      <div className={ styles['modal-content'] }>
        { onClose &&
        <div className={ styles['modal-controls'] }>
          <button onClick={ () => onClose() }>
            <FontAwesomeIcon icon={ faWindowClose } size='2x'/>
          </button>
        </div>
        }
        { children }
      </div>
    </div>
  }
}

export default Modal

Modal.propTypes = {
  onClose: PropTypes.func.isRequired
}
