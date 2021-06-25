import get from 'lodash/get'

export default function(result) {
  const attrs = []
  const iconName = get(result, 'detail.iconName')

  if(!iconName) {
    // TODO: decide how/whether to handle this error condition
    console.error('Font Awesome Icon Chooser: missing required iconName attribute for shortcode')
    return
  }

  attrs.push(`name="${iconName}"`)

  const optionalAttrs = [
    'prefix',
    'style',
    'class', 
    'aria-hidden',
    'aria-label',
    'aria-labelledby',
    'title',
    'role'
  ]

  for(const attr of optionalAttrs) {
    const val = get(result, ['detail', attr])

    if(val) {
      attrs.push(`${attr}="${val}"`)
    }
  }

  wp.media.editor.insert( `[icon ${ attrs.join(' ') }]` )
}
