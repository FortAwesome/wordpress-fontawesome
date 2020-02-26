import React from 'react'
import { useSelector, useDispatch } from 'react-redux'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faClock, faSpinner, faCheck, faSkull } from '@fortawesome/free-solid-svg-icons'
import { snoozeV3DeprecationWarning } from './store/actions'
import styles from './V3DeprecationWarning.module.css'
import classnames from 'classnames'
import Alert from './Alert'

export default function V3DeprecationWarning() {
  const { snooze, atts, v5name, v5prefix } = useSelector(state => state.v3DeprecationWarning)
  const { isSubmitting, hasSubmitted, success } = useSelector(state => state.v3DeprecationWarningStatus)
  const dispatch = useDispatch()

  if (snooze) return null

  return <Alert
    title='Font Awesome 3 icon names are deprecated'
    type='warning'
    >
      <p>Looks like you're using an old Font Awesome 3 icon name in your shortcode: <code>{ atts.name }</code>. We discontinued support for Font Awesome 3 quite some time ago. Won't you jump into <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/">the newest Font Awesome</a> with us? It's way better, and it's easy to upgrade.</p>

      <p>Just adjust your shortcode from this:
      <blockquote><code>[icon name="{ atts.name }"]</code></blockquote>
      to this:
      <blockquote><code>[icon name="{ v5name }" prefix="{ v5prefix }"]</code></blockquote></p>

      <p>You'll need to go adjust any version 3 icon names in [icon] shortcodes in your pages, posts, widgets, templates (or wherever they're coming from) to the new format with prefix. You can check the icon names and prefixes in our <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/icons?d=gallery">Icon Gallery</a>. But what's that prefix, you ask? We now support a number of different styles for each icon. <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4#changes">Learn more</a></p>

      <p>Once you update your icon shortcodes, this warning will disappear or you could hit snooze to hide it for a while. <strong>But we're gonna remove this v3-to-v5 magic soon, though, so don't wait forever.</strong></p>

      <p>
        <button disabled={ isSubmitting } onClick={ () => dispatch(snoozeV3DeprecationWarning()) } className={ classnames( styles['snooze-button'], 'button', 'button-primary' ) }>
          {
            isSubmitting
              ?  <FontAwesomeIcon icon={ faSpinner } spin className={ styles['submitting'] } />
              : hasSubmitted
              ? success
                ? <FontAwesomeIcon icon={ faCheck } className={ styles['success'] }/>
                : <FontAwesomeIcon icon={ faSkull } className={ styles['fail'] }/>
              : <FontAwesomeIcon icon={ faClock } className={ styles['snooze'] }/>
          }
          <span className={ styles['label'] }>Snooze</span>
        </button>
      </p>
  </Alert>
}
