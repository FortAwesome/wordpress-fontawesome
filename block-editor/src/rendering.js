import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import classnames from 'classnames'
import { createElement, useEffect } from '@wordpress/element'
import { FONT_AWESOME_COMMON_BLOCK_WRAPPER_CLASS } from './constants'
import { icon } from '@fortawesome/fontawesome-svg-core'

export function useUpdateOnSave( attributes, setAttributes ) {
    useEffect( () => {
        const iconLayers = attributes?.iconLayers || []

        if (!Array.isArray(iconLayers) || iconLayers.length === 0) {
          return
        }

        let abs

        // TODO: add wrapper props--test with justification

        // We don't support multiple layers yet.
        if (iconLayers.length === 1) {
          const { iconDefinition, color } = iconLayers[0]
          const {className, ...params} = resolveSpecialProps(iconLayers[0], 0, [])

          if ('string' === typeof className) {
            params.classes = className.split(' ').filter(c => c.length > 0)
          }

          params.attributes = {}

          if ('string' === typeof color) {
            params.attributes.color = color
          }

          if (iconDefinition) {
            abs = icon(iconDefinition, params).abstract
          }
        }

        if (abs) {
          setAttributes( { abstract: abs } );
        }
    }, [ attributes.iconLayers ] );
}

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
      const { iconDefinition, ...restLayer } = layer
      const props = resolveSpecialProps(restLayer, index, classNamesByLayer)

      return (
        <FontAwesomeIcon
          key={index}
          icon={iconDefinition}
          {...props}
        />
      )
    })
  )
}

function resolveSpecialProps(layer = {}, layerIndex = 0, classNamesByLayer = []) {
  const { style = {}, iconDefinition, rotation: initialRotation, ...rest } = layer
  let className = (classNamesByLayer || [])[layerIndex]
  let rotation

  if ([0, 90, 180, 270].includes(initialRotation)) {
    rotation = initialRotation
  } else if (!Number.isNaN(parseInt(initialRotation))) {
    className = classnames(className ? className.toString() : '', 'fa-rotate-by')
    style['--fa-rotate-angle'] = `${initialRotation}deg`
  }

  return {
    style,
    rotation,
    className,
    ...rest
  }
}
