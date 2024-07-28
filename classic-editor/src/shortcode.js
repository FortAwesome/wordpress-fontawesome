import get from 'lodash/get'

export function buildShortCodeFromIconChooserResult(result) {
  const attrs = []

  if (!result.iconName) {
    // TODO: decide how/whether to handle this error condition
    console.error('Font Awesome Icon Chooser: missing required iconName attribute for shortcode')
    return
  }

  attrs.push(`name="${result.iconName}"`)

  const optionalAttrs = ['prefix', 'style', 'class', 'aria-hidden', 'aria-label', 'aria-labelledby', 'title', 'role']

  for (const attr of optionalAttrs) {
    const val = get(result, attr)

    if (val) {
      attrs.push(`${attr}="${val}"`)
    }
  }

  return `[icon ${attrs.join(' ')}]`
}
