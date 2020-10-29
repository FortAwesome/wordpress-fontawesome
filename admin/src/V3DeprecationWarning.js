import React from 'react'
import { useSelector, useDispatch } from 'react-redux'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faClock, faSpinner, faCheck, faSkull } from '@fortawesome/free-solid-svg-icons'
import { snoozeV3DeprecationWarning } from './store/actions'
import styles from './V3DeprecationWarning.module.css'
import classnames from 'classnames'
import Alert from './Alert'
import { __, sprintf } from '@wordpress/i18n'
import { createInterpolateElement } from '@wordpress/element'

export default function V3DeprecationWarning() {
  const { snooze, atts, v5name, v5prefix } = useSelector(state => state.v3DeprecationWarning)
  const { isSubmitting, hasSubmitted, success } = useSelector(state => state.v3DeprecationWarningStatus)
  const dispatch = useDispatch()

  if (snooze) return null

  return <Alert
    title={ __( 'Font Awesome 3 icon names are deprecated', 'font-awesome' ) } 
    type='warning'
    >
      <p>
        {
          createInterpolateElement(
            sprintf(
              __('Looks like you\'re using an old Font Awesome 3 icon name in your shortcode: <code>%s</code>. We discontinued support for Font Awesome 3 quite some time ago. Won\'t you jump into <a>the newest Font Awesome</a> with us? It\'s way better, and it\'s easy to upgrade.', 'font-awesome' ),
              atts.name
            ),
            {
              code: <code />,
                // eslint-disable-next-line jsx-a11y/anchor-has-content
              a: <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/" />
            }
          )
        }
      </p>

      <p>
        { __('Just adjust your shortcode from this:', 'font-awesome' ) }
      </p>
        
      <blockquote><code>[icon name="{ atts.name }"]</code></blockquote>

      <p>
        { __( 'to this:', 'font-awesome' ) }
      </p>

      <blockquote><code>[icon name="{ v5name }" prefix="{ v5prefix }"]</code></blockquote>

      <p>
        {
          createInterpolateElement(
            __( 'You\'ll need to go adjust any version 3 icon names in [icon] shortcodes in your pages, posts, widgets, templates (or wherever they\'re coming from) to the new format with prefix. You can check the icon names and prefixes in our <linkIconGallery>Icon Gallery</linkIconGallery>. But what\'s that prefix, you ask? We now support a number of different styles for each icon. <linkLearnMore>Learn more</linkLearnMore>', 'font-awesome' ),
            {
              // eslint-disable-next-line jsx-a11y/anchor-has-content
              linkIconGallery: <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/icons?d=gallery" />,
              // eslint-disable-next-line jsx-a11y/anchor-has-content
              linkLearnMore: <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4#changes" />
            }
          )
        }
      </p>

      <p>
        {
          createInterpolateElement(
            __( 'Once you update your icon shortcodes, this warning will disappear or you could hit snooze to hide it for a while. <strong>But we\'re gonna remove this v3-to-v5 magic soon, though, so don\'t wait forever.</strong>', 'font-awesome' ),
            {
              strong: <strong />
            }
          )
        }
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
          <span className={ styles['label'] }>{ __( 'Snooze', 'font-awesome' ) }</span>
        </button>
      </p>
  </Alert>
}
