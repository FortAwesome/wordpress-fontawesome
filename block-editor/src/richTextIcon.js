import { Component, Fragment, renderToString, useState } from "@wordpress/element";
import { Modal, Popover, ToolbarButton, ToolbarGroup } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import {
  applyFormat,
  create,
  insert,
  insertObject,
  registerFormatType,
  useAnchor,
} from "@wordpress/rich-text";
import {
  BlockControls,
  RichTextToolbarButton,
  useBlockProps,
} from "@wordpress/block-editor";
import get from "lodash/get";
import kebabCase from "lodash/kebabCase";
import pick from "lodash/pick";
import { faBrandIcon } from "./icons";
import { GLOBAL_KEY } from "../../admin/src/constants";
import { iconDefinitionFromIconChooserSelectionEvent, normalizeIconDefinition } from './iconDefinitions'
import createCustomEvent from './createCustomEvent'
import { renderIcon } from './rendering'
import IconModifier from './iconModifier'
import { ANIMATIONS } from './constants'
import { toIconDefinition } from './iconDefinitions'
export const ZERO_WIDTH_SPACE = '\u200b';
const FONT_AWESOME_RICH_TEXT_ICON_CLASS = 'wp-font-awesome-rich-text-icon';
const FONT_AWESOME_RICH_TEXT_ICON_TRANSFORM_ATTR = 'data-transform';
export const FONT_AWESOME_RICH_TEXT_ICON_TAG_NAME = 'span';
const TRANSFORM_PROPS = ['size', 'x', 'y', 'rotate', 'flipX', 'flipY']

const { IconChooserModal } = get(window, [GLOBAL_KEY, "iconChooser"], {});

const name = "font-awesome/rich-text-icon";
const title = __("Font Awesome Icon");

const settings = {
  name,
  title,
  keywords: [__("icon"), __("awesome")],
  tagName: FONT_AWESOME_RICH_TEXT_ICON_TAG_NAME,
  className: FONT_AWESOME_RICH_TEXT_ICON_CLASS,
  contentEditable: false,
  attributes: {
    transformJSON: FONT_AWESOME_RICH_TEXT_ICON_TRANSFORM_ATTR
  },
  edit: Edit
};

registerFormatType(name, settings);

const modalOpenEvent = createCustomEvent()

// Use `insertObject()` on an empty value merely for the side effect of
// producing the text value corresponding to an object.
//
// This is sort of bending over backwards to avoid hardcoding an implementation
// detail of the block editor.
//
// We can see in the Gutenberg source code (as of WordPress 6.5) that the text
// inserted by `insertObject()` is just a single character: U+FFFC, the object
// replacement character.
//
// However, that implementation is not documented as part of the public API.
// So it might change at any time. So let's not hardcode it here.
// (In fact, if memory serves, it used to be a different special character.)
//
// This technique produces whatever text is used for object replacement,
// which might be more than one character, using `insertObject()`.
// Since `insertObject()` *is* part of the RichText API, this ought to continue
// working even if the implementation details change underneath.
const EMPTY_VALUE = create({ text: "" });
const EMPTY_OBJECT_VALUE = insertObject(EMPTY_VALUE, {});

function isFocused(value) {
  if (!Array.isArray(value.replacements) || !Number.isInteger(value.start)) {
    return false;
  }
  const replacement = value.replacements[value.start];
  return replacement?.type === name;
}

// This does not fully support layers. It returns attributes with
// an `iconLayers` property, but it doesn't yet read icon layers out of the HTML,
// so that iconLayers array will always have a length of 1.
function deriveAttributes(value) {
  if(!Number.isFinite(value?.start)) return
  const replacement = value?.replacements[value.start]
  if('string' !== typeof replacement?.innerHTML) return
  const parser = new DOMParser();
  const doc = parser.parseFromString(replacement.innerHTML, 'text/html');
  const svg = doc.querySelector('svg')
  if(!svg) return

  const viewBox = svg.getAttribute('viewBox')
  const prefix = svg.getAttribute('data-prefix')
  const iconName = svg.getAttribute('data-icon')
  const paths = svg.querySelectorAll('path')

  let primaryPath, secondaryPath

  if(paths.length < 1) return

  if (paths[0].classList.contains('fa-secondary')) {
    secondaryPath = paths[0].getAttribute('d')
  } else {
    primaryPath = paths[0].getAttribute('d')
  }

  if(paths.length > 1) {
    if (paths[1].classList.contains('fa-secondary')) {
      secondaryPath = paths[1].getAttribute('d')
    } else {
      primaryPath = paths[1].getAttribute('d')
    }
  }

  let width, height;

  if('string' === typeof viewBox) {
    const viewBoxProps = viewBox.split(/\W/)
    width = Number.parseFloat(viewBoxProps[2])
    height = Number.parseFloat(viewBoxProps[3])
  }

  if(!Number.isFinite(width) || !Number.isFinite(height)) {
    return
  }

  const pathData = []

  if(secondaryPath) {
    pathData.push(secondaryPath)
  }

  if(primaryPath) {
    pathData.push(primaryPath)
  }

  const iconDefinition = toIconDefinition({iconName, prefix, width, height, pathData})

  if(!iconDefinition) return

  const iconLayer = {iconDefinition}

  const color = svg.getAttribute('color')

  if(color) {
    iconLayer.color = color
  }

  const transformJSON = replacement?.attributes?.transformJSON

  if(transformJSON) {
    const transform = transformJSON ? JSON.parse(transformJSON) : undefined
    if(transform) {
      iconLayer.transform = pick(transform, TRANSFORM_PROPS)
    }
  }

  for(const animation of ANIMATIONS) {
    const animationClass = `fa-${kebabCase(animation)}`
    if(svg.classList.contains(animationClass)){
      iconLayer[animation] = true
    }
  }

  return {iconLayers: [iconLayer]}
}

function InlineUI( { value, changeValue, contentRef, handleSelect } ) {
  const [attributes, setAttributes] = useState(deriveAttributes(value))
	const [isEditModalOpen, setIsEditModalOpen] = useState(false)

	const hasIcon = Array.isArray(attributes?.iconLayers) && attributes.iconLayers.length > 0

	let popoverAnchor = useAnchor( {
		editableContentElement: contentRef.current,
		settings
	} );

  const { width, height, x, y } = popoverAnchor.getBoundingClientRect() || {}

  /* When there's *only* a rich text icon in the block, useAnchor seems to get
   * confused and puts the Inline UI component way up on the far top left (0,0).
   * This is a workaround to hardcode the anchor in that case.
   */
  if ( 0 === width && 0 === height && 0 === x && 0 === y) {
    popoverAnchor = {
      contextElement: contentRef.current,
      getBoundingClientRect() {
        return contentRef.current.getBoundingClientRect()
      }
    }
  }

  const {color, fontSize} = window.getComputedStyle(contentRef.current)
  const context = {color, fontSize}

  return (
    <Popover
      placement="bottom"
      focusOnMount={false}
      anchor={popoverAnchor}
      className="block-editor-format-toolbar__font-awesome-rich-text-icon-popover"
    >
      <div>
        <button onClick={() => document.dispatchEvent(modalOpenEvent)}>
          Change Icon
        </button>
        <button onClick={() => setIsEditModalOpen(true)}>
          Style
        </button>

        {hasIcon && isEditModalOpen && (
          <Modal
            title="Add Icon Styling"
            onRequestClose={() => {
              changeValue(attributes)
              setIsEditModalOpen(false)
            }}
            className={`fawp-icon-styling-modal`}
          >
            <IconModifier
              attributes={attributes}
              setAttributes={setAttributes}
              IconChooserModal={IconChooserModal}
              context={context}
              prepareHandleSelect={() => handleSelect}
            />
          </Modal>
        )}
      </div>
    </Popover>
  );
}

function Edit(props) {
  const { value, onChange, contentRef } = props;

  const isFormatIconFocused = isFocused(value);
  /*
   * Deriving attributes:
   *
   * - color: color attr on svg
   * - animations: each class corresponds to a boolean.
   *
   * Via Power Transforms:
   * - size: will it be fa-4x? or the power transforms? probably power transforms.
   * - rotation: will it be fa-rotate? or power transforms?
   * - flip: will it be fa-flip-vertical or power transforms?
   */

  const handleFormatButtonClick = () => {
    document.dispatchEvent(modalOpenEvent);
  };

  const changeValue = (attributes) => {
    const wrapperProps = {
      className: FONT_AWESOME_RICH_TEXT_ICON_CLASS
    }

    const element = renderIcon(attributes, {
      wrapperElement: 'span',
      extraProps: { wrapperProps }
    })

    const html = renderToString(element)

    let iconValue = create({ html });

    // The object replacement text indicates where the icon should be rendered,
    // replacing that object replacement text. Without it, no SVG would be rendered.
    //
    // The zero-width space allows the insert caret to move around the icon
    // in a normal intuitive way, such as when moving across it with arrow keys.
    // It also allows for placing the caret at the end of the rich text value
    // when an icon SVG is at the end, and then backspacing to delete the icon.
    const zeroWidthSpaceIndex = iconValue.text.length;

    if(!attributes?.iconLayers) {
      // If don't yet have any icon layers, then this is the first, so this
      // extra character should be inserted.
      // If we're *changing* the icon, then we'll be only changing the replacement
      // formats below--but don't add additional zero-width space.
      iconValue = insert(
        iconValue,
        ZERO_WIDTH_SPACE,
        zeroWidthSpaceIndex,
        zeroWidthSpaceIndex,
      );
    }

    // Now that we've extended the value's text by a single character, we need to
    // fix up the replacements so that our object replacement format
    // is present at every index in the value that corresponds to the text that should
    // be replaced by our icon object.
    //
    // If we don't do this fixup, then we end up with misalignment of the object
    // replacement text and its corresponding replacement format in the resulting value.
    // This works fine when there's only one rich text icon in the value. But once
    // you add a second, or more, you get off-by-one errors, or worse.
    //
    // For example, suppose the `iconValue.text` ends up being two characters long, total,
    // with the first character being the object replacement character, and the second
    // being the zero width space. That works fine for the first icon insertion.
    // Suppose that first icon is inserted so that the replacement format and
    // the object replacement character are both at index 2. Then the zero width space
    // we add will be at index 3. No problem.
    //
    // Now suppose you add a second icon value later in the value, at index 7.
    // The object replacement character will end up at index 8, but the replacement
    // format object would be placed at index 7--off by one.
    //
    // The result is that the second icon will not render, because the block editor doesn't
    // find that the object replacement character's index corresponds to the index of
    // our replacmeent format.
    //
    // The solution is to make sure that our replacement format covers exactly the same
    // indices of content that correspond to the text being inserted.
    const replacement = iconValue.replacements[0];

    const transform = (attributes?.iconLayers || [])[0]?.transform
    if(transform) {
      // The transform is one attribute that we can't easily map forward and backward
      // to and from the rendered HTML, so when present, we store it as JSON in an attribute
      // on the wrapper element.
      replacement.attributes[FONT_AWESOME_RICH_TEXT_ICON_TRANSFORM_ATTR] = JSON.stringify(transform)
    }

    iconValue.replacements[iconValue.replacements.length - 1] = replacement;

    const insertStartIndex = value.start
    // If we already have an icon at this location, then we should replace it.
    // Otherwise, we're inserting a new one.
    const insertEndIndex = attributes?.iconLayers ? insertStartIndex + 1 : insertStartIndex

    const newValue = insert(value, iconValue, insertStartIndex, insertEndIndex);
    onChange(newValue);
  }

  const handleSelect = (event) => {
    if (!event?.detail) return;
    event.preventDefault();

    const iconDefinition = iconDefinitionFromIconChooserSelectionEvent(event);

    if (!iconDefinition) return;

    const existingAttributes = deriveAttributes(value)

    const existingIconLayer = (existingAttributes?.iconLayers || [])[0] || {}

    const iconLayer = {
      ...existingIconLayer,
      iconDefinition
    }

    const newAttributes = {
      iconLayers: [iconLayer],
    };

    changeValue(newAttributes, onChange)
  };

  return (
    <Fragment>
      <BlockControls>
        <ToolbarGroup>
          <ToolbarButton
              icon={faBrandIcon}
              title={title}
              onClick={handleFormatButtonClick}
              isActive={ isFormatIconFocused }
          />
        </ToolbarGroup>
      </BlockControls>
      <IconChooserModal onSubmit={handleSelect} openEvent={modalOpenEvent} />
      {isFormatIconFocused && (
        <InlineUI
          value={value}
          changeValue={changeValue}
          contentRef={contentRef}
          handleSelect={handleSelect}
        />
      )}
    </Fragment>
  );
}
