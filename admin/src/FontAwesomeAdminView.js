import React, { useState } from 'react'
import { useSelector } from 'react-redux'
import classnames from 'classnames'
import styles from './FontAwesomeAdminView.module.css'
import Options from './Options'
import ClientPreferencesView from './ClientPreferencesView'
import UnregisteredClientsView from './UnregisteredClientsView'
import PluginVersionWarningsView from './PluginVersionWarningsView'
import V3DeprecationWarning from './V3DeprecationWarning'
import { values, get, size } from 'lodash'
import Modal from './Modal'
import ReleaseProviderWarning from './ReleaseProviderWarning'

export default function FontAwesomeAdminView() {
  const releaseProviderStatus = useSelector(state => state.releaseProviderStatus)

  const releaseProviderStatusOK = useSelector(state => {
    // If releaseProviderStatus is null, it means that a network request was never issued.
    // We take that to mean that it's using a cached set of release metadata, which is OK.
    const status = releaseProviderStatus || null
    const code = get(status, 'code', 0)

    // If the status is not null, then the (HTTP) code for that network request should be in the OK range.
    return status === null || (code >= 200 && code <= 300)
  })

  const hasV3DeprecationWarning = useSelector(state => !!state.v3DeprecationWarning)

  const [ showingPseudoElementsHelpModal, setShowingPseudoElementsHelpModal ] = useState(false)

  const showPseudoElementsHelpModal = () => setShowingPseudoElementsHelpModal(true)
  const hidePseudoElementsHelpModal = () => setShowingPseudoElementsHelpModal(false)

  const unregisteredClients = useSelector(state => state.unregisteredClients)
  const pluginVersionWarnings = useSelector(state => values( state.pluginVersionWarnings ))
  const pluginVersion = useSelector(state => state.pluginVersion)

  const getPseudoElementsHelpModal = () => {
    return <Modal onClose={ hidePseudoElementsHelpModal }>
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

  return ( 
    <div className={ classnames(styles['font-awesome-admin-view'], { [ styles['blur'] ]: showingPseudoElementsHelpModal }) }>
      { showingPseudoElementsHelpModal && getPseudoElementsHelpModal() }
      <h1>Font Awesome</h1>
      <div>
        { hasV3DeprecationWarning && <V3DeprecationWarning /> }
        { releaseProviderStatusOK || <ReleaseProviderWarning /> }
        <Options
          showPseudoElementsHelpModal={ showPseudoElementsHelpModal }
        />
        <ClientPreferencesView />
        <UnregisteredClientsView clients={ unregisteredClients }/>
        {
          size(pluginVersionWarnings) > 0
          ? <PluginVersionWarningsView warnings={ pluginVersionWarnings } pluginVersion={ pluginVersion }/>
          : null
        }
      </div>
    </div>
  )
}
