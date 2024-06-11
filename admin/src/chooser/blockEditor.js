import IconChooserModal from "./IconChooserModal";
import { buildShortCodeFromIconChooserResult } from "./shortcode";
import { Component, Fragment } from "@wordpress/element";
import { Path, SVG, ToolbarButton, ToolbarGroup } from "@wordpress/components";
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
import { dom } from "@fortawesome/fontawesome-svg-core";

const name = "font-awesome/icon";
const title = __("Font Awesome Icon");
const inlineSvgName = "font-awesome/fa-inline-svg";
const inlineSvgTitle = __("Font Awesome Inline SVG");
const inlineSvgPathName = "font-awesome/fa-inline-svg-path";
const inlineSvgPathTitle = __("Font Awesome Inline SVG Path");

export function setupBlockEditor(params) {
  const {
    modalOpenEvent,
    kitToken,
    version,
    pro,
    handleQuery,
    getUrlText,
    settingsPageUrl,
    activeObjectAttributes,
  } = params;

  class FontAwesomeIconEdit extends Component {
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
      const toolbarIcon = (
        <SVG
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 448 512"
          className="svg-inline--fa fa-font-awesome fa-w-14"
        >
          <Path
            fill="currentColor"
            d="M397.8 32H50.2C22.7 32 0 54.7 0 82.2v347.6C0 457.3 22.7 480 50.2 480h347.6c27.5 0 50.2-22.7 50.2-50.2V82.2c0-27.5-22.7-50.2-50.2-50.2zm-45.4 284.3c0 4.2-3.6 6-7.8 7.8-16.7 7.2-34.6 13.7-53.8 13.7-26.9 0-39.4-16.7-71.7-16.7-23.3 0-47.8 8.4-67.5 17.3-1.2.6-2.4.6-3.6 1.2V385c0 1.8 0 3.6-.6 4.8v1.2c-2.4 8.4-10.2 14.3-19.1 14.3-11.3 0-20.3-9-20.3-20.3V166.4c-7.8-6-13.1-15.5-13.1-26.3 0-18.5 14.9-33.5 33.5-33.5 18.5 0 33.5 14.9 33.5 33.5 0 10.8-4.8 20.3-13.1 26.3v18.5c1.8-.6 3.6-1.2 5.4-2.4 18.5-7.8 40.6-14.3 61.5-14.3 22.7 0 40.6 6 60.9 13.7 4.2 1.8 8.4 2.4 13.1 2.4 22.7 0 47.8-16.1 53.8-16.1 4.8 0 9 3.6 9 7.8v140.3z"
          />
        </SVG>
      );
      // The following would add a toolbar button.
      /*
          <BlockControls>
            <ToolbarGroup>
              <ToolbarButton
                icon={toolbarIcon}
                title={title}
                onClick={this.handleFormatButtonClick}
              >
              </ToolbarButton>
            </ToolbarGroup>
          </BlockControls>
      */
      return (
        <Fragment>
          <RichTextToolbarButton
            icon={toolbarIcon}
            title={title}
            onClick={this.handleFormatButtonClick}
          />
          <IconChooserModal
            modalOpenEvent={modalOpenEvent}
            kitToken={kitToken}
            version={version}
            pro={pro}
            settingsPageUrl={settingsPageUrl}
            handleQuery={handleQuery}
            onSubmit={this.handleSelect}
            getUrlText={getUrlText}
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
    edit: FontAwesomeIconEdit,
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
}
