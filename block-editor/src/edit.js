import { justifyCenter, justifyLeft, justifyRight } from '@wordpress/icons';
import { faBrush, faLayerGroup } from "@fortawesome/free-solid-svg-icons";
/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

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
  DropdownMenu,
  MenuGroup,
  Modal,
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

import { iconDefinitionFromIconChooserSelectionEvent } from "./iconDefinitions";

import { useAnchor } from "@wordpress/rich-text";

import { wpIconFromFaIconDefinition } from "./icons";

import {
  computeIconLayerCount,
  prepareParamsForUseBlock,
  renderIcon,
} from "./rendering";

import IconModifier from "./iconModifier";
import createCustomEvent from "./createCustomEvent";

const openIconChooserForAddLayerEvent = createCustomEvent();

const { IconChooserModal } = get(window, [
  GLOBAL_KEY,
  "iconChooser",
], {});

const modifyToolbarIcon = wpIconFromFaIconDefinition(faBrush);

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

  const { justification } = attributes || {}

  const [justificationDropdownMenuIcon, setJustificationDropdownMenuIcon] = useState(justifyCenter)

  const setJustification = (justification) => {
    let menuIcon
    if('left' === justification) {
      menuIcon = justifyLeft
    } else if ('right' === justification) {
      menuIcon = justifyRight
    } else {
      menuIcon = justifyCenter
    }

    setJustificationDropdownMenuIcon(menuIcon)
    setAttributes({ ...attributes, justification });
  }

  const prepareHandleSelect = (layerParams) => (event) => {
    const iconLayers = attributes?.iconLayers || [];

    const iconDefinition = iconDefinitionFromIconChooserSelectionEvent(event)

    if(!iconDefinition) return

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
      newIconLayers[replace] = layer;
    }

    setAttributes({ iconLayers: newIconLayers });
  };

  const iconLayerCount = computeIconLayerCount(attributes);

  const extraProps = {
    wrapperProps: useBlockProps(prepareParamsForUseBlock(attributes))
  }

  const [isEditModalOpen, setIsEditModalOpen] = useState(false)

  return iconLayerCount > 0
    ? (
      <Fragment>
        <BlockControls>
        <ToolbarGroup>
          <DropdownMenu
            controls={[
              {
                icon: justifyLeft,
                onClick: () => setJustification('left'),
                title: __('Justify Icon Left', 'font-awesome')
              },
              {
                icon: justifyCenter,
                onClick: () => setJustification('center'),
                title: __('Justify Icon Center', 'font-awesome')
              },
              {
                icon: justifyRight,
                onClick: () => setJustification('right'),
                title: __('Justify Icon Right', 'font-awesome')
              }
            ]}
            icon={justificationDropdownMenuIcon}
            label={__('Change Icon Justification', 'font-awesome')}
          />
        </ToolbarGroup>
        <ToolbarGroup>
          <ToolbarButton
            showTooltip
            onClick={() => setIsEditModalOpen(!isEditModalOpen)}
            aria-haspopup="true"
            aria-expanded={isEditModalOpen}
          label={__("Add Icon Styling")}
            icon={modifyToolbarIcon}
          />
        </ToolbarGroup>

        {isEditModalOpen && (
          <Modal
            title="Add Icon Styling"
            onRequestClose={() => setIsEditModalOpen(false)}
            className={`fawp-icon-styling-modal`}
          >
            <IconModifier
              attributes={attributes}
              setAttributes={setAttributes}
              IconChooserModal={IconChooserModal}
              prepareHandleSelect={prepareHandleSelect}
            />
          </Modal>
        )}
      </BlockControls>
        {renderIcon(attributes, { extraProps })}
    </Fragment>
  ) : (
    <Fragment>
      <Placeholder
        icon={
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M91.7 96C106.3 86.8 116 70.5 116 52C116 23.3 92.7 0 64 0S12 23.3 12 52c0 16.7 7.8 31.5 20 41l0 3 0 352 0 64 64 0 0-64 373.6 0c14.6 0 26.4-11.8 26.4-26.4c0-3.7-.8-7.3-2.3-10.7L432 272l61.7-138.9c1.5-3.4 2.3-7 2.3-10.7c0-14.6-11.8-26.4-26.4-26.4L91.7 96z" />
          </svg>
        }
        label="Add a Font Awesome Icon"
        instructions="Add an icon as a block element, and add styling to make it extra awesome!"
      >
        <IconChooserModal
          onSubmit={prepareHandleSelect({ append: true })}
          openEvent={openIconChooserForAddLayerEvent}
        />
        <Button
          variant="secondary"
          onClick={() => document.dispatchEvent(openIconChooserForAddLayerEvent)}>
            Choose Icon
        </Button>
        </Placeholder>
      </Fragment>
    );
}
