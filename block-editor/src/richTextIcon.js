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
//import { addFilter } from '@wordpress/hooks'

export const INLINE_SVG_FORMAT_WRAPPER_TAG_NAME = 'span'

const { IconChooserModal } = get(window, [
  GLOBAL_KEY,
  "iconChooser",
], {});

const name = "font-awesome/rich-text-icon";
const title = __("Font Awesome Icon");

const modalOpenEvent = createCustomEvent()

function isFocused(value) {
  if(!Array.isArray(value.formats) || !Number.isInteger(value.start)) {
    return false
  }

  const formats = value.formats[value.start]

  if(!Array.isArray(formats)) {
    return false
  }

  return !!formats.find(({type: type}) => type === name)
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

  console.log('VALUE', value)
  const isFormatIconFocused = isFocused(value)

  const handleFormatButtonClick = () => {
    document.dispatchEvent(modalOpenEvent);
  }

  const handleSelect = (event) => {
    if (!event.detail) return;

    const iconNormalized = normalizeIconDefinition(event.detail)

    if (!iconNormalized) return;

    event.preventDefault();

    const iconValue = create({html: asHTML(iconNormalized)})

    console.log('ICON_VALUE', iconValue)
    const newValue = insert(value, iconValue)
    console.log('NEW_VALUE', newValue)

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
  edit: Edit,
};

registerFormatType(name, settings);
