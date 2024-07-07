import { faIcons, faLayerGroup } from "@fortawesome/free-solid-svg-icons";
/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

import { DOWN } from "@wordpress/keycodes";
/**
 * Imports the InspectorControls component, which is used to wrap
 * the block's custom controls that will appear in in the Settings
 * Sidebar when the block is selected.
 *
 * Also imports the React hook that is used to mark the block wrapper
 * element. It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#inspectorcontrols
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
  BlockControls,
  InspectorControls,
  useBlockProps,
} from "@wordpress/block-editor";

import { Fragment, useRef, useState } from "@wordpress/element";
/**
 * Imports the necessary components that will be used to create
 * the user interface for the block's settings.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/panel/#panelbody
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/text-control/
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/toggle-control/
 */
import {
  Button,
  Dropdown,
  MenuGroup,
  PanelBody,
  Placeholder,
  Popover,
  TextControl,
  ToggleControl,
  Toolbar,
  ToolbarButton,
  ToolbarGroup,
} from "@wordpress/components";

/**
 * Imports the useEffect React Hook. This is used to set an attribute when the
 * block is loaded in the Editor.
 *
 * @see https://react.dev/reference/react/useEffect
 */
import { useEffect } from "react";

import classnames from "classnames";
import get from "lodash/get";

import { GLOBAL_KEY } from "../../admin/src/constants";

import { toIconDefinition } from "./iconDefinitions";

import { filterSelectionEvent, isValid } from "./attributeValidation";

import { useAnchor } from "@wordpress/rich-text";

import { wpIconFromFaIconDefinition } from "./icons";

import {
  computeIconLayerCount,
  prepareParamsForUseBlock,
  renderBlock,
} from "./rendering";

import IconLayersModifier from "./iconLayersModifier";
import IconModifier from "./iconModifier";

const { IconChooserModal, modalOpenEvent } = get(window, [
  GLOBAL_KEY,
  "iconChooser",
], {});

const modifyToolbarIcon = wpIconFromFaIconDefinition(faIcons);

const defaultStylingParams = {
  spin: false,
  transform: null,
};

export function Edit(props) {
  const {
    attributes,
    setAttributes,
    isSelected,
  } = props;

  const prepareHandleSelect = (layerParams) => (event) => {
    const filteredSelectionAttributes = filterSelectionEvent(event);

    if ("object" !== typeof filteredSelectionAttributes) {
      return;
    }

    const iconLayers = attributes?.iconLayers || [];

    const iconDefinition = toIconDefinition(filteredSelectionAttributes);

    const layer = {
      iconDefinition,
      ...defaultStylingParams,
    };

    const newIconLayers = [...iconLayers];
    const { replace, append } = layerParams;

    if (append) {
      newIconLayers.push(layer);
    } else if (
      Number.isInteger(replace) &&
      replace < iconLayers.length
    ) {
      newIconLayers[layerReplacementIndex] = layer;
    }

    setAttributes({ iconLayers: newIconLayers });
  };

  const openIconChooser = () => {
    document.dispatchEvent(modalOpenEvent);
  };

  const iconLayerCount = computeIconLayerCount(attributes);

  const blockProps = useBlockProps(prepareParamsForUseBlock(attributes));

  return iconLayerCount > 0
    ? (
      <Fragment>
        <BlockControls>
          <Dropdown
            popoverProps={{
              className: "block-editor-fa-icon-edit__popover",
              headerTitle: __("Edit Icon"),
            }}
            renderToggle={({ isOpen, onToggle }) => {
              const openOnArrowDown = (event) => {
                if (!isOpen && event.keyCode === DOWN) {
                  event.preventDefault();
                  onToggle();
                }
              };
              return (
                <ToolbarButton
                  showTooltip
                  onClick={onToggle}
                  aria-haspopup="true"
                  aria-expanded={isOpen}
                  onKeyDown={openOnArrowDown}
                  label={__("Edit Icon")}
                  icon={modifyToolbarIcon}
                />
              );
            }}
            renderContent={() => (
              <MenuGroup label={__("Edit Icon")}>
                {iconLayerCount > 1
                  ? (
                    <IconLayersModifier
                      attributes={attributes}
                      setAttributes={setAttributes}
                      IconChooserModal={IconChooserModal}
                      prepareHandleSelect={prepareHandleSelect}
                      openIconChooser={openIconChooser}
                    />
                  )
                  : (
                    <IconModifier
                      attributes={attributes}
                      layerIndex={0}
                      setAttributes={setAttributes}
                      IconChooserModal={IconChooserModal}
                      prepareHandleSelect={prepareHandleSelect}
                      openIconChooser={openIconChooser}
                    />
                  )}
              </MenuGroup>
            )}
          />
        </BlockControls>
        {renderBlock(blockProps, attributes)}
      </Fragment>
    )
    : (
      <Fragment>
        <Placeholder>
          <IconChooserModal
            onSubmit={prepareHandleSelect({ append: true })}
          />
          <button onClick={openIconChooser}>
            Choose Icon
          </button>
        </Placeholder>
      </Fragment>
    );
}
