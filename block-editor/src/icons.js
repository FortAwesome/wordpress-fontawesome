import { Path, SVG } from '@wordpress/components'
import { normalizeIconDefinition } from './iconDefinitions'
import { faFontAwesome } from '@fortawesome/free-brands-svg-icons'

export function wpIconFromFaIconDefinition(faIconDefinition) {
  const iconNormalized = normalizeIconDefinition(faIconDefinition)

  if (!iconNormalized) {
    return null
  }

  const { iconName, prefix, width, height, primaryPath, secondaryPath } = iconNormalized

  return (
    <SVG
      xmlns="http://www.w3.org/2000/svg"
      viewBox={`0 0 ${width} ${height}`}
      data-prefix={prefix}
      className={`svg-inline--fa fa-block-editor-ui fa-${iconName}`}
    >
      {secondaryPath && (
        <Path
          className="fa-secondary"
          fill="currentColor"
          d={secondaryPath}
        />
      )}
      {primaryPath && (
        <Path
          fill="currentColor"
          d={primaryPath}
        />
      )}
    </SVG>
  )
}

export const faBrandIcon = wpIconFromFaIconDefinition(faFontAwesome)
