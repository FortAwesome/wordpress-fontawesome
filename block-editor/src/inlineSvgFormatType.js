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

const name = "font-awesome/inline-icon";
const title = __("Font Awesome Icon");
const inlineSvgName = "font-awesome/fa-inline-svg";
const inlineSvgTitle = __("Font Awesome Inline SVG");
const inlineSvgPathName = "font-awesome/fa-inline-svg-path";
const inlineSvgPathTitle = __("Font Awesome Inline SVG Path");

const modalOpenEvent = createCustomEvent()

export const ZWNBSP = '\ufeff';

function insertObjectAlt( value, formatToInsert, startIndex, endIndex ) {
	const valueToInsert = {
		formats: [ , ],
		replacements: [ formatToInsert ],
		text: ZWNBSP,
	};

	return insert( value, valueToInsert, startIndex, endIndex );
}

function filterGetSaveElement(element, blockType, attributes) {
  //console.log('SAVE type', blockType)
  if('core/paragraph' === blockType.name) {
    console.log('FILTER_ELEMENT', element)
    //console.log('FILTER_ATTRS', attributes)
  }
  return element
}

function filterGetBlockAttributes(element, blockType, attributes) {
  console.log('ATTR type', blockType.name)
  if('core/paragraph' === blockType.name) {
    console.log('GET_BLOCK_ATTRS_ELEMENT', element)
    console.log('GET_BLOCK_ATTRS_ATTRS', attributes)
  }
  return element
}

//addFilter('blocks.getSaveElement', 'font-awesome/icon', filterGetSaveElement, 10)
//addFilter('blocks.getBlockAttributes', 'font-awesome/icon', filterGetBlockAttributes, 10)

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

  const createSvgDomElement = ({width, height, primaryPath, secondaryPath}) => {
    const svg = document.createElementNS("http://www.w3.org/2000/svg", 'SVG')
    svg.setAttribute('viewBox', `0 0 ${width} ${height}`)
    if(secondaryPath) {
      const path = document.createElementNS("http://www.w3.org/2000/svg", 'PATH')
      path.setAttribute('d', secondaryPath)
      path.setAttribute('class', 'fa-secondary')
      path.appendChild(document.createTextNode('x'))
      svg.appendChild(path)
    }

    if(primaryPath) {
      const path = document.createElementNS("http://www.w3.org/2000/svg", 'PATH')
      path.setAttribute('d', primaryPath)
      if(secondaryPath) {
        path.setAttribute('class', 'fa-primary')
      }
      path.appendChild(document.createTextNode('y'))
      svg.appendChild(path)
    }
    console.log('DOM_ELEMENT', svg)
    return svg
  }

  const handleSelect = (event) => {
    if (!event.detail) return;

    const iconNormalized = normalizeIconDefinition(event.detail)

    if (!iconNormalized) return;

    const {
      iconName,
      width,
      height,
      primaryPath,
      secondaryPath
    } = iconNormalized


    const svgElementWrapper = {
      type: inlineSvgName,
      attributes: {
        xmlns: "http://www.w3.org/2000/svg",
        viewBox: `0 0 ${width} ${height}`,
      },
    };

    const originalStart = value.start;
    //console.log("ORIG_VALUE", value)

    // const svgValue = create({element: createSvgDomElement(iconNormalized)})
    // console.log("SVG_VALUE", svgValue)
    // const newValue = insert(value, svgValue)
    //const newReplacements = value.replacements.slice()

    let newValue = {...value}

    if(primaryPath) {
      newValue = insertObject(newValue, {
        type: inlineSvgPathName,
        attributes: {
          d: primaryPath,
          fill: "currentColor",
        }
      })
      /*
      newReplacements[ value.start ] = {
        type: inlineSvgPathName,
        attributes: {
          d: primaryPath,
          fill: "currentColor",
        }
      }
      */
    }

    if(secondaryPath) {
      newValue = insertObject(newValue, {
        type: inlineSvgPathName,
        attributes: {
          d: secondaryPath,
          fill: "currentColor",
          className: "fa-secondary"
        }
      })
      /*
      newReplacements[ value.start ] = {
        type: inlineSvgPathName,
        attributes: {
          d: secondaryPath,
          fill: "currentColor",
        }
      }
      */
    }

    let objectCount = 0;
    primaryPath && objectCount++;
    secondaryPath && objectCount++;

    const formatStartIndex = objectCount > 1 ? value.start - 1 : value.start
    console.log("ORIG_VALUE", value)
    console.log("NEW_VALUE_CANDATE", newValue)

    //newValue = applyFormat(newValue, svgElementWrapper, formatStartIndex, value.start)
    newValue.formats[value.start] = [svgElementWrapper]

    if(secondaryPath) {
      newValue.formats[value.start + 1] = [svgElementWrapper]
    }

    /*
    let newValue = insertObject(value, {
      type: inlineSvgPathName,
      attributes: {
        d: primaryPath,
        fill: "currentColor",
      },
    });
    */
    //console.log("NEW_VALUE_PRIMARY", newValue)

    /*
    if (secondaryPath) {
      //newStart = value.start - 1;
      newValue = insertObject(
        newValue,
        {
          type: inlineSvgPathName,
          attributes: {
            d: secondaryPath,
            fill: "currentColor",
            className: "fa-secondary",
          },
        },
        originalStart,
        originalStart
        //newStart,
        //value.start,
      );

      //console.log("NEW_VALUE_SECONDARY", newValue)
    }
    */

    // let objectCount = 0;
    // primaryPath && objectCount++;
    // secondaryPath && objectCount++;

    event.preventDefault();

    /*
    const wrapperIndex = originalStart;

    for (let i = wrapperIndex; i < originalStart + objectCount; i++) {
      if (Array.isArray(newValue.formats[i])) {
        // then wrap the outer <span> around the <svg>
        newValue.formats[i].push({ type: name });
        // wrap the <svg> around any <path> elements.
        newValue.formats[i].push(svgElementWrapper);
      } else {
        newValue.formats[i] = [
          { type: name },
          svgElementWrapper,
        ];
      }
    }
    */

    newValue = insert(value, create({html: asHTML(iconNormalized)}))

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

const mainSettings = {
  name,
  title,
  keywords: [__("icon"), __("awesome")],
  tagName: INLINE_SVG_FORMAT_WRAPPER_TAG_NAME,
  //contentEditable: false,
  className: "fa-icon-format",
  edit: Edit,
};

const inlineSvgSettings = {
  name: inlineSvgName,
  title: inlineSvgTitle,
  tagName: "svg",
  className: "svg-inline--fa",
//  contentEditable: false,
  attributes: {
    xmlns: "xmlns",
    viewBox: "viewBox",
  },
};

const inlineSvgPathSettings = {
  name: inlineSvgPathName,
  title: inlineSvgPathTitle,
  tagName: "path",
  className: null,
//  contentEditable: false,
  attributes: {
    className: "class",
    d: "d",
    fill: "fill",
  },
};

registerFormatType(inlineSvgName, inlineSvgSettings);
registerFormatType(inlineSvgPathName, inlineSvgPathSettings);
registerFormatType(name, mainSettings);
