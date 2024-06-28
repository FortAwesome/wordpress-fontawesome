import { faIcons, faLayerGroup } from "@fortawesome/free-solid-svg-icons";
/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

import { DOWN } from '@wordpress/keycodes';
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

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";

import { toIconDefinition } from "./iconDefinitions";

import { filterSelectionEvent, isValid } from "./attributeValidation";

import {
  useAnchor
} from "@wordpress/rich-text";

import { wpIconFromFaIconDefinition } from './icons'

const { IconChooserModal, modalOpenEvent } = get(window, [
  GLOBAL_KEY,
  "iconChooser",
], {});

const changeIconToolbarIcon = wpIconFromFaIconDefinition(faIcons)

const manageIconLayersToolbarIcon = wpIconFromFaIconDefinition(faLayerGroup)

export function Edit(props) {
  const {
    attributes,
    setAttributes,
    isSelected 
  } = props

  const handleSelect = (event) => {
    const filteredSelectionAttributes = filterSelectionEvent(event);

    if ("object" !== typeof filteredSelectionAttributes) {
      return;
    }

    setAttributes({
      ...filteredSelectionAttributes,
      spin: false,
      transform: null,
    });
  };

  const openIconChooser = () => {
    document.dispatchEvent(modalOpenEvent);
  };

  const svgElementClasses = classnames({
    "fa-spin": !!attributes.spin,
  });

  const blockProps = useBlockProps();

  const iconDefinition = toIconDefinition(attributes);

  // Please use ToolbarItem, ToolbarButton or ToolbarDropdownMenu
  return iconDefinition
    ? (
      <Fragment>
        <InspectorControls>
          <PanelBody title={__("Settings", "fa-icon-block")}>
            <p>
              <FontAwesomeIcon icon={iconDefinition} /> {iconDefinition.prefix}
              {" "}
              {iconDefinition.iconName}
            </p>
            <ToggleControl
              label={__("spin", "fa-icon-block")}
              checked={!!attributes.spin}
              onChange={() => setAttributes({ spin: !attributes.spin })}
            />
          </PanelBody>
        </InspectorControls>

        <BlockControls>
            <IconChooserModal
              onSubmit={handleSelect}
            />
            <ToolbarButton
              icon={changeIconToolbarIcon}
              onClick={openIconChooser}
              label={__("Change Icon")}
            />

          <Dropdown
			      popoverProps={ {
				      className: 'block-editor-fa-icon-layers__popover',
				      headerTitle: __( 'Add Icon Layer' ),
			      } }
			      renderToggle={ ( { isOpen, onToggle } ) => {
				      const openOnArrowDown = ( event ) => {
					      if ( ! isOpen && event.keyCode === DOWN ) {
						      event.preventDefault();
						      onToggle();
					      }
				      };
				      return (
					      <ToolbarButton
						      showTooltip
						      onClick={ onToggle }
						      aria-haspopup="true"
						      aria-expanded={ isOpen }
						      onKeyDown={ openOnArrowDown }
						      label={ __('Add Icon Layer') }
						      icon={ manageIconLayersToolbarIcon }
					      />
				      );
			      } }
			      renderContent={ () => (
				      <MenuGroup label={ __( 'Icon Layers' ) }>
					      <p>
						      { __(
							      'Add icon layers.'
						      ) }
					      </p>
				      </MenuGroup>
			      ) }
          />
        </BlockControls>

        <span {...blockProps}>
          <FontAwesomeIcon
            icon={iconDefinition}
            spin={!!attributes.spin}
          />
        </span>
      </Fragment>
    )
    : (
      <Fragment>
        <Placeholder>
          <IconChooserModal
            onSubmit={handleSelect}
          />
          <button onClick={openIconChooser}>
            Choose Icon
          </button>
        </Placeholder>
      </Fragment>
    );
}
