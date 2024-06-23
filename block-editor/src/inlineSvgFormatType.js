import { Component, Fragment } from "@wordpress/element";
import { Popover, ToolbarButton, ToolbarGroup } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import {
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
const { IconChooserModal, modalOpenEvent } = get(window, [
  GLOBAL_KEY,
  "iconChooser",
], {});

const name = "font-awesome/inline-icon";
const title = __("Font Awesome Icon");
const inlineSvgName = "font-awesome/fa-inline-svg";
const inlineSvgTitle = __("Font Awesome Inline SVG");
const inlineSvgPathName = "font-awesome/fa-inline-svg-path";
const inlineSvgPathTitle = __("Font Awesome Inline SVG Path");

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

class Edit extends Component {
  constructor(props) {
    super(...arguments);

    this.handleFormatButtonClick = this.handleFormatButtonClick.bind(this);
    this.handleSelect = this.handleSelect.bind(this);
  }

  handleFormatButtonClick() {
    document.dispatchEvent(modalOpenEvent);
  }

  handleSelect(event) {
    const { value, onChange } = this.props;
    // TODO: this would indicate an invalid event. Do we want some error handling here?
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

    let newStart = value.start;

    let newValue = insertObject(value, {
      type: inlineSvgPathName,
      attributes: {
        d: primaryPath,
        fill: "currentColor",
      },
    });

    if (secondaryPath) {
      newStart = value.start - 1;
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
        newStart,
        value.start,
      );
    }

    let objectCount = 0;
    primaryPath && objectCount++;
    secondaryPath && objectCount++;

    event.preventDefault();

    const wrapperIndex = newStart;

    for (let i = wrapperIndex; i < newStart + objectCount; i++) {
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

    onChange(newValue);
  }

  render() {
    const {
      contentRef,
      value,
      onChange
    } = this.props;

    const isFormatIconFocused = isFocused(value)

    return (
      <Fragment>
        <RichTextToolbarButton
          icon={faBrandIcon}
          title={title}
          onClick={this.handleFormatButtonClick}
        />
        <IconChooserModal
          onSubmit={this.handleSelect}
        />
        {isFormatIconFocused &&
        <InlineUI
            value={ value }
            onChange={ onChange }
            contentRef={ contentRef }
          />}
      </Fragment>
    );
  }
}

const mainSettings = {
  name,
  title,
  keywords: [__("icon"), __("awesome")],
  tagName: "span",
  className: "fa-icon-format",
  edit: Edit,
};

const inlineSvgSettings = {
  name: inlineSvgName,
  title: inlineSvgTitle,
  tagName: "svg",
  className: "svg-inline--fa",
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
  attributes: {
    className: "class",
    d: "d",
    fill: "fill",
  },
};

registerFormatType(inlineSvgName, inlineSvgSettings);
registerFormatType(inlineSvgPathName, inlineSvgPathSettings);
registerFormatType(name, mainSettings);
