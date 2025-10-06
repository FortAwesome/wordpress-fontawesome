import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import classnames from 'classnames'
import { createElement, useEffect, useMemo, useRef } from '@wordpress/element'
import { FONT_AWESOME_COMMON_BLOCK_WRAPPER_CLASS } from './constants'
import { icon } from '@fortawesome/fontawesome-svg-core'
import { isBlockValid } from './attributeValidation'
import kebabCase from 'lodash/kebabCase'

// Custom hook to create stable references for deep comparison.
//
// This seems like a lot of bending over backwards to achieve a simple goal.
// Here's the gist of what's going on here:
//
// Ultimately, the purpose of this is to produce values that can be used in the monitoring
// of the useEffect() below. What we need for useEffect() are object references that change
// only when the values inside the objects change. If we only cared about changes to the
// icon layers, we could just monitor changes to attributes.iconLayers. However, we also need
// to monitor changes to justification, which is attributes.justification, and attributes.color.
// And we don't really want to have to list out all the individual attributes we care about,
// because when a new attribute is added, we'd have to remember to separately add it to the list
// of monitors.
//
// However, if we just set the monitor to `[ attributes ]`, there are two problems:
//
// 1. It changes every time the function is called, which causes an infinite loop, since
//    the useEffect() callback will invoke setAttributes(). React crashes.
//
// 2. It doesn't account for the block wrapper div's blockProps. Those also need to be taken into
//    account for our rendering of the `abstract`, but they are not part of `attributes`.
//    Also, if every invocation receives a new `blockProps` object, with its own identity,
//    then we're back to the problem of having a monitor that is triggered on every invocation
//    of useUpdateOnSave().
//
// So the useRef() here solves the problem of keeping a stable object reference identity.
// Its value will only change when the actual values inside the object change.
// And the useMemo() is the way to get React to only update the current value of the useRef()
// when the underlying values change. JSON.stringify() is how we represent the underlying values in a way
// that can be compared for deep equality.
function useDeepCompareMemo(value) {
    const ref = useRef()

    return useMemo(() => {
        const stringified = JSON.stringify(value)
        if (ref.current?.stringified !== stringified) {
            ref.current = { value, stringified }
        }
        return ref.current.value
    }, [JSON.stringify(value)])
}

export function useUpdateOnSave( blockProps, attributes, setAttributes ) {
    // Create stable references that only change when content changes
    const stableBlockProps = useDeepCompareMemo(blockProps)
    const stableAttributes = useDeepCompareMemo(attributes)

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
      }, [ stableAttributes, stableBlockProps ] );
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
