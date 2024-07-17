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
			className="block-editor-format-toolbar__fa-icon-format-popover"
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
  return `<svg class="svg-inline--fa fawp-fmt" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${width} ${height}">${pathsAsHTML(primaryPath, secondaryPath)}</svg>`
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
    // This is sort of bending over backwards. Here's why:
    //
    // We can see in the Gutenberg source code that it's currently just a single
    // character: U+FFFC, the object replacement character. So why not use it
    // directly here?
    //
    // Because it's not documented as part of the public API. So it's an implementation
    // detail that might change. (In fact, it seems to have changed in the past,
    // if memory serves.)
    //
    // This is a way to produce whatever text is used for object replacement,
    // using `insertObject()`, which *is* part of the RichText API.
    const emptyValue = create({text: ''})
    const objectValue = insertObject(emptyValue, {})

    const iconValue = create({html: asHTML(iconNormalized)})
    // The object replacement text indicates where the svg should be rendered.
    // Without it, no SVG would be rendered.
    // The zero-width space allows the insert caret to move around the icon
    // in a normal intuitive way, such as when moving across it with arrow keys.
    // It also allows for placing the caret at the end of the rich text value
    // when an icon SVG is at the end, and then backspacing to delete the icon.
    iconValue.text = `${objectValue.text}${ZERO_WIDTH_SPACE}`;

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
  tagName: 'svg',
  className: 'svg-inline--fa',
  contentEditable: false,
  attributes: {
    xmlns: 'xmlns',
    viewBox: 'viewBox',
    class: 'class'
  },
  edit: Edit,
};

registerFormatType(name, settings);
