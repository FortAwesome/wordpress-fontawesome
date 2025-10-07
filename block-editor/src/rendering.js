import classnames from 'classnames'
import { createElement, useEffect, useMemo, useRef } from '@wordpress/element'
import { FONT_AWESOME_COMMON_BLOCK_WRAPPER_CLASS, ANIMATIONS } from './constants'
import { icon } from '@fortawesome/fontawesome-svg-core'
import { isBlockValid } from './attributeValidation'
import kebabCase from 'lodash/kebabCase'
import camelCase from 'lodash/camelCase'

const DEFAULT_BLOCK_WRAPPER_TAG = 'div'

/**
 *  Rendering overview:
 *
 *  As far as this module is concerned, there are two rendering targets:
 *
 *  1. For the block editor. This corresponds to the `edit` function or `Edit` component
 *     for a block. This is how the icon is rendered in the block editor interface.
 *
 *  2. The abstract representation of the block, stored in the `abstract` attribute.
 *     This abstract drives the back end rendering of the icon in the dynamic block `render_callback`.
 *     It is a way to avoid saving raw HTML in the block content, while still allowing for complex HTML structures.
 *
 *  In order to ensure that these two renderings are consistent, the rendering for the block editor
 *  is also based on the abstract representation. The abstract is rendered to React elements.
 */
export function updateAbstractOnChange(blockProps, attributes, setAttributes ) {
  // Create stable references that only change when content changes
  const stableBlockProps = useDeepCompareMemo(blockProps)
  const stableAttributes = useDeepCompareMemo(attributes)

  useEffect( () => {
    const abstract = renderWrappedAbstract(blockProps, attributes)
    setAttributes({ abstract });
  }, [ stableAttributes, stableBlockProps ] );
}

export function renderIconForEditor(attributes, options = {}) {
  const elementType = options?.blockWrapperTag || DEFAULT_BLOCK_WRAPPER_TAG
  const blockProps = options?.blockProps || {}
  const abstract = attributes?.abstract || []
  const [ wrapperDiv ] = abstract
  const children = wrapperDiv?.children || []
  return createElement(
    elementType,
    blockProps,
    createReactElementsFromAbstract(children)
  )
}

function createReactElementsFromAbstract(abstract) {
  return abstract.map((node, index) => {
    const { tag, attributes = {}, children = [] } = node
    // We strip away the `spin` attribute, since that is not a valid HTML attribute,
    // and it's only used for internal state management to distinguish between different
    // styles of spinning.
    const { class: className, spin: _spin, style, ...restAttributes } = attributes || {}

    const styleObject = 'string' === typeof style ? parseStyleAttribute(style) : {}

    return createElement(
      tag,
      { key: index, ...restAttributes, className, style: styleObject },
      children.length > 0 ? createReactElementsFromAbstract(children) : null
    )
  })
}

function parseStyleAttribute(styleString) {
  const el = document.createElement('div');
  el.style.cssText = styleString;

  const styleObj = {};
  for (let i = 0; i < el.style.length; i++) {
    const prop = el.style[i];
    const camelProp = camelCase(prop);
    styleObj[camelProp] = el.style[prop];
  }
  return styleObj;
}

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
// The `useRef()` here provides a stable reference that persists between renders.
// It stores the last known value and its serialized (stringified) form.
//
// The useMemo() ensures that the comparison and possible update of the ref only occur when the
// serialized (JSON.stringify) value changes.
//
// JSON.stringify() is how we represent the underlying values in a way
// that can be compared for deep equality.
//
// In short: this hook returns a stable object reference that only updates when the
// *contents* of the input value change, not when new objects are created with the
// same data.
//
// It seems like the `use-deep-compare-effect` NPM should do this for us. By its description,
// it's designed just for this purpose. However, it doesn't work for all of our cases:
// it doesn't update the abstract when changing the icon's color.
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

function renderWrappedAbstract(blockProps, attributes, options = {}) {
  const iconLayers = attributes?.iconLayers || []

  if (!Array.isArray(iconLayers) || iconLayers.length === 0) {
    return []
  }

  if (!isBlockValid(attributes)) {
    return []
  }

  // Wrap the Font Awesome Icon abstract in a div that represents the block wrapper.
  // The abstract schema is defined by the @fortawesome/fontawesome-svg-core package.
  return [{
    tag: options?.blockWrapperTag || DEFAULT_BLOCK_WRAPPER_TAG,
    attributes: resolveWrapperAttributes(blockProps, attributes),
    children: renderIconAbstract(iconLayers)
  }]
}

function renderIconAbstract(iconLayers) {
  // We don't support multiple layers yet, so we'll only handle the first layer.
  const iconLayerIndex = 0

  const { iconDefinition, color, style: initialStyle, transform = {}, ...iconLayerRest } = iconLayers[iconLayerIndex]

  if (!iconDefinition) {
    return []
  }

  const { style: rotationStyle, className: rotationClassName, rotation } = resolveRotation(iconLayerRest)
  const { classes: animationClasses } = resolveAnimations(iconLayerRest)
  const attributes = {...iconLayerRest }

  // Remove any animation props from attributes, since they are handled via classes.
  // They aren't valid HTML attributes.
  for (const a of ANIMATIONS) {
    delete attributes[a]
  }

  const rotationClasses = rotationClassName ? rotationClassName.split(' ').filter(c => c.length > 0) : []

  if ('undefined' !== typeof rotation) {
    transform.rotate = rotation
  }

  const params = {
    attributes,
    transform,
    styles: rotationStyle,
    classes: [
      ...rotationClasses,
      ...animationClasses
    ]
  }

  if ('string' === typeof color) {
    params.attributes.color = color
  }

  if ('object' === typeof initialStyle) {
    for (const styleKey in initialStyle) {
      const kebabKey = kebabCase(styleKey)
      params.styles[kebabKey] = initialStyle[styleKey]
    }
  }

  return icon(iconDefinition, params).abstract
}

function resolveWrapperAttributes(blockProps, attributes) {
  const { justification } = attributes || {}
  const { className: wrapperClassName, ...restWrapperAttrs } = blockProps || {}
  const wrapperAttributes = {}

  if ('string' === typeof wrapperClassName) {
    wrapperAttributes.class = wrapperClassName
  }

  for (const key in restWrapperAttrs) {
    wrapperAttributes[key] = restWrapperAttrs[key]
  }

  if (justification) {
    const justificationStyle = `display: flex; justify-content: ${justification};`

    if ('string' === typeof wrapperAttributes.style) {
      const maybeSemicolon = wrapperAttributes.style.trim().endsWith(';') ? '' : ';'
      wrapperAttributes.style = `${wrapperAttributes.style}${maybeSemicolon} ${justificationStyle}`
    } else {
      wrapperAttributes.style = justificationStyle
    }
  }

  return wrapperAttributes
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

// A layer may have props that set animations. Those translate directly to props on the
// FontAwesomeIcon React component, but when rendering the abstract for saving in the block content,
// they must be turned into kebab-cased class names (which is what the React component does internally anyway).
function resolveAnimations(layer = {}) {
  const classes = []

  for (const animationProp of ANIMATIONS) {
    if (layer[animationProp]) {
      classes.push(`fa-${kebabCase(animationProp)}`)
    }
  }

  return { classes }
}

function resolveRotation(layer = {}) {
  const { rotation: initialRotation } = layer
  let className = ''
  let rotation
  const style = {}

  if ([0, 90, 180, 270].includes(initialRotation)) {
    rotation = initialRotation
  } else if (!Number.isNaN(parseInt(initialRotation))) {
    className = classnames(className ? className.toString() : '', 'fa-rotate-by')
    style['--fa-rotate-angle'] = `${initialRotation}deg`
  }

  return {
    style,
    rotation,
    className
  }
}
