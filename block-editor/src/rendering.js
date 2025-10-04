import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import classnames from 'classnames'
import { createElement, useEffect } from '@wordpress/element'
import { FONT_AWESOME_COMMON_BLOCK_WRAPPER_CLASS } from './constants'
import { icon } from '@fortawesome/fontawesome-svg-core'
import { useBlockProps } from '@wordpress/block-editor'
import { isBlockValid } from './attributeValidation'
import kebabCase from 'lodash/kebabCase'

export function useUpdateOnSave( attributes, setAttributes ) {
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

        // TODO: add wrapper props--test with justification

        // We don't support multiple layers yet.
        if (iconLayers.length === 1) {
          const { iconDefinition, color, style } = iconLayers[0]

          const { className: wrapperClassName, ...restWrapperAttrs} = useBlockProps.save(prepareParamsForUseBlock(attributes))

          if ('string' === typeof wrapperClassName) {
            wrapperAttributes.class = wrapperClassName
          }

          for (const key in restWrapperAttrs) {
            wrapperAttributes[key] = restWrapperAttrs[key]
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
        }

        const newAttributes = { wrapperAttributes }

        if (abs) {
          newAttributes.abstract = abs
        }

        setAttributes( newAttributes );
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
