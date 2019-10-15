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
      <p>
        Looks like you're using an <code>[icon]</code> shortcode with an old Font Awesome 3 icon name:
        <code>{ atts.name }</code>
      </p>
      <p>
        We discontinued support for <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/v3.2.1/icons/">Font Awesome 3</a> quite some time ago,
        though we only recently inherited this WordPress plugin,
        which previously only supported up to Font Awesome 3.
      </p>
      <p>
        Won't you jump into Font Awesome 5 with us? It's way better, and we're gonna make
        it really easy to upgrade. We've added some temporary magic to this plugin to translate your version 3 icon
        names into their version 5 equivalents.
      </p>
      <p>
        <i className="fas fa-magic fa-2x"></i> <em>Bippity Boppity Boo!</em>
      </p>
      <p>
        We just turned your<br/>
        <code>[icon name="{ atts.name }"]</code><br/>
        <i className={ `${ v5prefix } fa-${ v5name } fa-2x` }></i> into<br/>
        <code>[icon name="{ v5name }" prefix="{ v5prefix }"]</code>.
      </p>
      <p>
        Actually, we just converted it on the fly so it would look right in your web pages,
        without changing your saved web site content. So
        to make that change permanent (and get rid of this warning), you'll need to go change any version 3 icon
        names in <code>[icon]</code> shortcodes in your pages, posts, widgets, templates, or wherever they're coming from.
      </p>
      <p>
        What's that <code>prefix</code>, you ask?
      </p>
      <p>
        Well...in Font Awesome 5, most icons come in three different styles. You use a style <em>prefix</em> to indicate
        which style you want. The default style prefix is <code>fas</code> for the Solid style.
        So when you're upgrading your shortcodes from v3 to v5 names, if you just want the Solid style icon,
        you can leave off that <code>prefix</code>. Most v3 icons map to Solid style icons in v5. But some of
        the version 3 icon names map to the <code>fab</code> style for Brands, or the <code>far</code> style for Regular.
      </p>
      <p>
        Icons for companies like <i className="fab fa-apple fa-2x"></i> Apple, or products like <i className="fab fa-chrome fa-2x"></i>
        Chrome will be in the Brands style with the <code>fab</code> prefix.
      </p>
      <p>
        When you subscribe to <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/pro">Font Awesome Pro</a>,
        you get tons of icons in All the Styles, including <code>fal</code>,
        the Light style.
      </p>
      <p>
        Head over to our <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/icons?d=gallery">Icon Gallery</a> to
        check out the vast array.
      </p>
      <p>
        Guess what! In Font Awesome 3.2.1, you had
        361 icons to choose from. Now, with Font Awesome 5 Free (as of v5.11.2) you've got <b>1,544</b>,
        and with Pro you get...wait for it...<b>7,345</b>!
      </p>
      <p>
        So have a blast upgrading. We're gonna remove this v3-to-v5 magic soon, though,
        so don't wait forever.
      </p>
      <p>
        Clear this warning by updating those icons, or you could hit snooze to get this warning out of your way for a while.
      </p>

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