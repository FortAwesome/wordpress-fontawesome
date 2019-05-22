import React from 'react'
import PropTypes from 'prop-types'
import classnames from 'classnames'
import styles from './FontAwesomeAdminView.module.css'
import Options from './Options'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faThumbsUp, faExclamationCircle, faExclamationTriangle } from '@fortawesome/free-solid-svg-icons'
import ClientRequirementsView from './ClientRequirementsView'
import UnregisteredClientsView from './UnregisteredClientsView'
import PluginVersionWarningsView from './PluginVersionWarningsView'
import V3DeprecationWarning from './V3DeprecationWarning'
import { values } from 'lodash'
import Modal from './Modal'

class FontAwesomeAdminView extends React.Component {

  constructor(props) {
    super(props)

     this.state = {
       showPseudoElementsHelpModal: false
     }

    this.showPseudoElementsHelpModal = this.showPseudoElementsHelpModal.bind(this)
    this.hidePseudoElementsHelpModal = this.hidePseudoElementsHelpModal.bind(this)
  }

  showPseudoElementsHelpModal() {
    this.setState({ showPseudoElementsHelpModal: true })
  }

  hidePseudoElementsHelpModal() {
    this.setState({ showPseudoElementsHelpModal: false })
  }


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

  getPseudoElementsHelpModal() {
    return <Modal onClose={ this.hidePseudoElementsHelpModal }>
      <div className={ styles['pseudo-elements-help'] }>
        <h1>Inspecting for Pseudo-Elements with Google Chrome DevTools</h1>
        <p>Here's one way to discover whether pseudo-elements are being used on your pages.</p>
        <img alt='screenshot' className={ styles['pseudo-elements-screenshot'] } src='/wp-content/plugins/font-awesome/public_assets/pseudo-elements-screenshot.png'/>
        <ol>
          <li>Use Google Chrome to load a page.</li>
          <li>Open Chrome's developer tools.
            <p>On macOS, that's probably on the menu: View->Developer->Developer Tools (or key Option+Command+I).</p>
            <p>On Windows, try More tools->Developer tools (or key Ctrl+Shift+I)</p>
          </li>
          <li>
            Click the element inspector tool
            <p>Example: see the green arrow on the screenshot below.</p>
          </li>
          <li>
            Click some element you want to inspect, probably a place where there's an empty box where you expect to see an icon.
            <p>Example: see the red arrow on the screenshot below.</p>
          </li>
        </ol>
        <p>
          After selecting an element to inspect, you'll see it highlighted in the html source code in the left panel below.
          See the <code>::before</code> in the screenshot (blue arrow)? That's a pseudo-element. It's not really part of the html markup.
          It's being inserted before the <em>real</em> markup, which is the &lt;p&gt; (paragraph) element with the class "group-icon".
        </p>
        <p>
          Now notice over in the right panel below where the orange arrow is pointing. That's the CSS code that's actually
          causing that pseudo-element to show up. It's setting <code>font-family: "FontAwesome";</code>, which is the old
          <code>font-family</code> used for Font Awesome version 4.
        </p>
        <p>
          It's also setting <code>content: '\f0c0';</code>. That's the unicode character for this particular icon.
          You'll find the unicode character for each icon in its listing in our icon gallery.&nbsp;
          <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/icons/users?style=solid">Here's the listing</a> for that particular icon.
        </p>
        <p>
          One more note: if you get to clicking around like this and inspect a Font Awesome 5 <em>webfont</em> icon that
          you've placed using an <code>&lt;i&gt;</code> tag, you'll find a pseudo-element in there as well. That's not a problem.
          Under the hood our webfont-based technology uses pseudo-elements as well. There's nothing wrong with pseudo-elements themselves,
          and no <em>performance</em> problems with using them in the webfont scenario. In fact, if you switch back and
          forth between <em>webfont</em> and <em>svg</em>, inspecting that icon, you'll see that behind the scenes,
          it either ends up getting a pseudo-element (in the webfont case), or replaced by an <code>&lt;svg&gt;</code>.
          That's what we want: icon references that work in all scenarios: whether Font Awesome version 4 or 5, whether
          webfont or svg.
        </p>
        <p>
          One problem with using pseudo-elements directly to reference icons, instead of <code>&lt;i&gt;</code>
          tags (or WordPress shortcodes), are these <em>compatibility</em> challenges that arise. So when your
          themes or plugins use pseudo-elements in a way that locks those icons into a Font Awesome version 4 webfont,
          it makes it hard to automatically upgrade them when you, the site owner, want to use Font Awesome 5, and
          even more difficult if you want to use svg instead of webfont.
        </p>
      </div>
    </Modal>
  }

  render(){
    const { data, putData } = this.props

    const hasConflict = !!data.conflicts

    const { statusLabel, statusIcon } = this.getStatus( hasConflict, !!data.options.lockedLoadSpec )

    return <div className={ classnames(styles['font-awesome-admin-view'], { [ styles['blur'] ]: this.state.showPseudoElementsHelpModal }) }>
      { this.state.showPseudoElementsHelpModal && this.getPseudoElementsHelpModal() }
      <h1>Font Awesome</h1>
      <div>
        <p className={ classnames( styles['status'], styles[statusLabel] ) }>
          <span className={ styles['status-label'] }>Status: </span>
          <FontAwesomeIcon className={ styles['icon'] } icon={ statusIcon }/>
        </p>
        <V3DeprecationWarning wpApiSettings={ this.props.wpApiSettings }/>
        <Options
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
          showPseudoElementsHelpModal={ this.showPseudoElementsHelpModal }
        />
        { !hasConflict &&
          <ClientRequirementsView
            clientRequirements={ values( data.clientRequirements ) }
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
