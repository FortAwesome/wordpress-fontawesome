import { Component, Fragment } from "@wordpress/element";
import { ToolbarButton, ToolbarGroup } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import {
  create,
  insert,
  insertObject,
  registerFormatType,
} from "@wordpress/rich-text";
import {
  BlockControls,
  RichTextToolbarButton,
  useBlockProps,
} from "@wordpress/block-editor";
import get from 'lodash/get';
import blockIcon from './blockIcon' ;
import { GLOBAL_KEY } from '../../admin/src/constants'
const { IconChooserModal, modalOpenEvent } = get(window, [GLOBAL_KEY, 'iconChooser'], {});

const name = "font-awesome/icon";
const title = __("Font Awesome Icon");
const inlineSvgName = "font-awesome/fa-inline-svg";
const inlineSvgTitle = __("Font Awesome Inline SVG");
const inlineSvgPathName = "font-awesome/fa-inline-svg-path";
const inlineSvgPathTitle = __("Font Awesome Inline SVG Path");

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

    const { iconName, prefix } = event.detail;
    const icon = event.detail.icon || [];
    const width = icon[0];
    const height = icon[1];
    const pathData = icon[4];

    const isDuotone = Array.isArray(pathData);

    const primaryPath = isDuotone
      ? (Array.isArray(pathData) ? pathData[1] : "")
      : pathData;

    const secondaryPath = Array.isArray(pathData) ? pathData[0] : null;

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

    if (isDuotone && secondaryPath) {
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
    return (
      <Fragment>
        <RichTextToolbarButton
          icon={blockIcon}
          title={title}
          onClick={this.handleFormatButtonClick}
        />
        <IconChooserModal
          onSubmit={this.handleSelect}
        />
      </Fragment>
    );
  }
}

const mainSettings = {
  name,
  title,
  keywords: [__("icon"), __("awesome")],
  tagName: "span",
  className: "fa-icon",
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
