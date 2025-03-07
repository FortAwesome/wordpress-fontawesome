import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import classnames from 'classnames'
import { createElement } from '@wordpress/element'
import { FONT_AWESOME_COMMON_BLOCK_WRAPPER_CLASS } from './constants'

export function computeIconLayerCount(attributes) {
  return Array.isArray(attributes?.iconLayers) ? attributes.iconLayers.length : 0
}

export function prepareParamsForUseBlock(attributes) {
  const iconLayerCount = computeIconLayerCount(attributes)

  return {
    className: classnames(FONT_AWESOME_COMMON_BLOCK_WRAPPER_CLASS, { 'fa-layers': iconLayerCount > 1 })
  }
}

export function renderIcon(attributes, options = {}) {
  const { wrapperProps = {}, classNamesByLayer } = options?.extraProps || {}
  const elementType = options?.wrapperElement?.toLowerCase() || 'div'
  const iconLayers = attributes?.iconLayers
  const { justification } = attributes || {}

  if (justification) {
    wrapperProps.style = {
      display: 'flex',
      justifyContent: justification
    }
  }

  if (!Array.isArray(iconLayers) || iconLayers.length === 0) return

  return createElement(
    elementType,
    { ...(wrapperProps || {}) },
    attributes.iconLayers.map((layer, index) => {
      const { style = {}, iconDefinition, rotation: initialRotation, ...rest } = layer
      let className = (classNamesByLayer || [])[index]
      let rotation

      if ([0, 90, 180, 270].includes(initialRotation)) {
        rotation = initialRotation
      } else if (!Number.isNaN(parseInt(initialRotation))) {
        className = classnames(className ? className.toString() : '', 'fa-rotate-by')
        style['--fa-rotate-angle'] = `${initialRotation}deg`
      }

      return (
        <FontAwesomeIcon
          key={index}
          className={className}
          style={style}
          icon={iconDefinition}
          rotation={rotation}
          {...rest}
        />
      )
    })
  )
}
