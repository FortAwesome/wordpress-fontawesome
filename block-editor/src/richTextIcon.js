import { Component, Fragment } from "@wordpress/element";
import { Popover, ToolbarButton, ToolbarGroup } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import {
  applyFormat,
  create,
  insert,
  insertObject,
  registerFormatType,
  useAnchor
} from "@wordpress/rich-text";
import {
  BlockControls,
  RichTextToolbarButton,
  useBlockProps,
} from "@wordpress/block-editor";
import get from "lodash/get";
import { faBrandIcon } from './icons';
import { GLOBAL_KEY } from "../../admin/src/constants";
import { normalizeIconDefinition } from './iconDefinitions'
import createCustomEvent from './createCustomEvent'
export const ZERO_WIDTH_SPACE = '\u200b';
const FONT_AWESOME_RICH_TEXT_ICON_CLASS = 'wp-font-awesome-rich-text-icon';

const { IconChooserModal } = get(window, [
  GLOBAL_KEY,
  "iconChooser",
], {});

const name = "font-awesome/rich-text-icon";
const title = __("Font Awesome Icon");

const modalOpenEvent = createCustomEvent()

function isFocused(value) {
  if(!Array.isArray(value.replacements) || !Number.isInteger(value.start)) {
    return false
  }
  const replacement = value.replacements[value.start]
  return replacement?.type === name
}

function InlineUI( { value, onChange, contentRef } ) {
	const popoverAnchor = useAnchor( {
		editableContentElement: contentRef.current,
	} );

	return (
		<Popover
			placement="bottom"
			focusOnMount={ false }
			anchor={ popoverAnchor }
			className="block-editor-format-toolbar__font-awesome-rich-text-icon-popover"
		>
		  <div>
		    <p>
		    TODO: Add some inline UI capabilities here. Note that "Change Icon" currently
		    inserts an additional one. That should be fixed.
		    </p>
		    <button onClick={() => document.dispatchEvent(modalOpenEvent)}>Change Icon</button>
		  </div>
		</Popover>
	);
}

function pathsAsHTML(primaryPath, secondaryPath) {
  const secondary = secondaryPath ? `<path class="fa-secondary" d="${secondaryPath}"/>` : ''
  const primary = primaryPath ? `<path ${secondaryPath ? 'class="fa-primary"' : ''} d="${primaryPath}"/>` : ''
  return `${secondary}${primary}`
}

function asHTML({width, height, primaryPath, secondaryPath}) {
  return `<span class="${FONT_AWESOME_RICH_TEXT_ICON_CLASS}"><svg class="svg-inline--fa" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${width} ${height}">${pathsAsHTML(primaryPath, secondaryPath)}</svg></span>`
}

function Edit(props) {
  const { value, onChange, contentRef } = props;

  const isFormatIconFocused = isFocused(value)

  const handleFormatButtonClick = () => {
    document.dispatchEvent(modalOpenEvent);
  }

  const handleSelect = (event) => {
    if (!event.detail) return;

    const iconNormalized = normalizeIconDefinition(event.detail)

    if (!iconNormalized) return;

    event.preventDefault();

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
    const emptyValue = create({text: ''})
    const objectValue = insertObject(emptyValue, {})

    let iconValue = create({html: asHTML(iconNormalized)})

    // The object replacement text indicates where the icon should be rendered,
    // replacing that object replacement text. Without it, no SVG would be rendered.
    //
    // The zero-width space allows the insert caret to move around the icon
    // in a normal intuitive way, such as when moving across it with arrow keys.
    // It also allows for placing the caret at the end of the rich text value
    // when an icon SVG is at the end, and then backspacing to delete the icon.
    const zeroWidthSpaceIndex = iconValue.text.length
    iconValue = insert(iconValue, ZERO_WIDTH_SPACE, zeroWidthSpaceIndex, zeroWidthSpaceIndex)

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
    const replacement = iconValue.replacements[0]
    iconValue.replacements[iconValue.replacements.length - 1] = replacement

    const newValue = insert(value, iconValue)
    onChange(newValue);
  }

  return (
    <Fragment>
      <RichTextToolbarButton
        icon={faBrandIcon}
        title={title}
        onClick={handleFormatButtonClick}
      />
      <IconChooserModal
        onSubmit={handleSelect}
        openEvent={modalOpenEvent}
      />
      {isFormatIconFocused &&
      <InlineUI
          value={ value }
          onChange={ onChange }
          contentRef={ contentRef }
        />}
    </Fragment>
  )
}

const settings = {
  name,
  title,
  keywords: [__("icon"), __("awesome")],
  tagName: 'span',
  className: FONT_AWESOME_RICH_TEXT_ICON_CLASS,
  contentEditable: false,
  edit: Edit,
};

registerFormatType(name, settings);
