import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import classnames from 'classnames'
import { createElement, useEffect, useMemo } from '@wordpress/element'
import { FONT_AWESOME_COMMON_BLOCK_WRAPPER_CLASS } from './constants'
import { icon } from '@fortawesome/fontawesome-svg-core'
import { isBlockValid } from './attributeValidation'
import kebabCase from 'lodash/kebabCase'

export function useUpdateOnSave( blockProps, attributes, setAttributes ) {
    // Memoize blockProps with deep comparison
    const memoizedBlockProps = useMemo(() => blockProps, [JSON.stringify(blockProps)])

    useEffect( () => {
        const iconLayers = attributes?.iconLayers || []

        if (!Array.isArray(iconLayers) || iconLayers.length === 0) {
          return
        }

        if (!isBlockValid(attributes)) {
          return
        }

        let abs
        const wrapperAttributes = {}

        // We don't support multiple layers yet, so we'll only handle the first layer.
        const { iconDefinition, color, style } = iconLayers[0]

        const { justification } = attributes || {}

        const { className: wrapperClassName, ...restWrapperAttrs } = blockProps || {}

        if ('string' === typeof wrapperClassName) {
          wrapperAttributes.class = wrapperClassName
        }

        for (const key in restWrapperAttrs) {
          wrapperAttributes[key] = restWrapperAttrs[key]
        }

        if (justification) {
          const justificationStyle = `display: flex; justify-content: ${justification};`

          if ('string' === typeof wrapperAttributes.style) {
            // TODO: maybe remove the extra semi-colon
            wrapperAttributes.style = `${wrapperAttributes.style}; ${justificationStyle}`
          } else {
            wrapperAttributes.style = justificationStyle
          }
        }

        const {className, transform, ...rest} = resolveSpecialProps(iconLayers[0], 0, [])

        const params = { attributes: rest, transform, styles: {} }

        if ('string' === typeof className) {
          params.classes = className.split(' ').filter(c => c.length > 0)
        }

        if ('string' === typeof color) {
          params.attributes.color = color
        }

        if ('object' === typeof style) {
          for (const styleKey in style) {
            const kebabKey = kebabCase(styleKey)
            params.styles[kebabKey] = style[styleKey]
          }
        }

        if (iconDefinition) {
          abs = icon(iconDefinition, params).abstract
        }

        if (abs) {
          // Wrap the Font Awesome Icon abstract in a div that represents the block.
          // This abstract format is defined by the @fortawesome/fontawesome-svg-core package.
          const wrappedAbstract = [{
            tag: 'div',
            attributes: wrapperAttributes,
            children: abs
          }]

          setAttributes( { abstract: wrappedAbstract } );
        }
    }, [ attributes.iconLayers, attributes.justification, attributes.color, memoizedBlockProps] );
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
