import React from 'react'
import PropTypes from 'prop-types'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faAngleDown, faExclamationTriangle } from '@fortawesome/free-solid-svg-icons'
import sharedStyles from './App.module.css'
import classnames from 'classnames'

class SvgPseudoElementsWarning extends React.Component {
  constructor(props) {
    super(props)

    this.state = {
      showMore: false,
    }

    this.toggleShowMore = this.toggleShowMore.bind(this)
  }

  toggleShowMore() {
    this.setState({ showMore: ! this.state.showMore })
  }

  render() {
    const { v4shim = false, showModal } = this.props

    return <div className={ classnames(sharedStyles['alert'], sharedStyles['alert-warning']) } role="alert">
      <div className={ sharedStyles['alert-icon'] }>
        <FontAwesomeIcon icon={ faExclamationTriangle } size='lg' fixedWidth />
      </div>
      <div className={ sharedStyles['alert-message'] }>
        <h2 className={ sharedStyles['alert-title'] }>
          {
            `Performance might be slow with svg and pseudo-elements.${ v4shim ? " And watch out for empty boxes!" : "" }`
          }
        </h2>
        <div className={ sharedStyles['alert-copy'] }>
          <p>
            Watch out! You've got both svg and pseudo-elements enabled. That's a configuration combo known to cause
            slow browser performance in some scenarios--sometimes <em>really</em> slow. If you know you need to handle
            a lot of pseudo-elements, you'll probably be happier using webfont instead of svg.
          </p>
          { v4shim &&
            <p>
              Also, you've enabled version 4 compatibility, but Font Awesome
              version 4 pseudo-elements will not work in this configuration. If you've used any of those,
              or if your theme or any plugins have used them, you'll probably see empty boxes in those spots.
            </p>
          }
          { this.state.showMore &&
            <div>
              <p>
                If you're using a theme or plugin that places Font Awesome icons using pseudo-elements,
                you may not have much of a choice but to accommodate by enabling pseudo-elements.
                <button onClick={ showModal }>Show me how to find out if pseudo-elements are used.</button>
              </p>
              <p>
                However, in general, it's best if you avoid using &nbsp;
                <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements">pseudo-elements</a>&nbsp;
                because it can make compatibility more difficult. When using our svg technology, it can also cause things to slow
                down considerably. Pseudo-element support is really only provided to accommodate situations where you can't
                modify the html markup.
              </p>
              <p>
                Normally, it's best to use <code>&lt;i&gt;</code> tags to place icons.
                In WordPress, shortcodes are good too.
                Ideally, your themes and plugins that use pseudo-elements will eventually migrate away from using pseudo-elements as well.
              </p>
            </div>
          }
        </div>
        <div className={ sharedStyles['alert-action'] }>
          { ! this.state.showMore &&
            <p><button onClick={ this.toggleShowMore } className={ sharedStyles['more-less'] }><FontAwesomeIcon icon={ faAngleDown }/>Tell me more</button></p>
          }
        </div>
      </div>
    </div>
  }
}

export default SvgPseudoElementsWarning

SvgPseudoElementsWarning.propTypes = {
  showModal: PropTypes.func.isRequired
}
