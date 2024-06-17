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
import { InspectorControls, useBlockProps } from "@wordpress/block-editor";

import { Fragment, useState } from "@wordpress/element";
/**
 * Imports the necessary components that will be used to create
 * the user interface for the block's settings.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/panel/#panelbody
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/text-control/
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/toggle-control/
 */
import { Button, PanelBody, TextControl, ToggleControl } from "@wordpress/components";

/**
 * Imports the useEffect React Hook. This is used to set an attribute when the
 * block is loaded in the Editor.
 *
 * @see https://react.dev/reference/react/useEffect
 */
import { useEffect } from "react";

import get from 'lodash/get';

import { GLOBAL_KEY } from '../../admin/src/constants'

const { IconChooserModal, modalOpenEvent } = get(window, [GLOBAL_KEY, 'iconChooser'], {});

export function Edit({ attributes, setAttributes }) {
  const { iconName, prefix, primaryPath, secondaryPath, width, height, spin } = attributes;

  useEffect(() => {
    // Load the icon chooser if the icon has not yet been picked.
    if(!iconName || !prefix) {
      document.dispatchEvent(modalOpenEvent)
    }
  }, [iconName, prefix]);

  const handleSelect = (event) => {
    if(!event.detail) {
      return
    }

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

    setAttributes({
      iconName,
      prefix,
      width,
      height,
      primaryPath,
      secondaryPath,
      spin: false
    })
  }

  const isReady = width && height && (primaryPath || secondaryPath)

  const classes = ['svg-inline--fa']

  if(spin) {
    classes.push('fa-spin')
  }
        const blockProps = useBlockProps( {
            className: 'fa-icon',
        } );
  return (
    <Fragment>
      <IconChooserModal
        onSubmit={handleSelect}
      />
      <InspectorControls>
        <PanelBody title={__("Settings", "fa-icon-block")}>
          <p>Prefix: {prefix}</p>
          <p>Icon: {iconName}</p>
        </PanelBody>
      </InspectorControls>
      {isReady && <span {...blockProps}>
        <svg class={classes.join(' ')} viewBox={`0 0 ${width} ${height}`}>
          <path fill="currentColor" d={primaryPath}>&nbsp;</path>
        </svg>
      </span>}
    </Fragment>
  );
}
/*
          <ToggleControl
            label={__("spin", "fa-icon-block")}
            checked={spin}
            onChange={ () => setAttributes({spin: !spin}) }
          />
          <TextControl
            label={__("prefix", "fa-icon-block")}
            value={prefix}
            onChange={(value) => setAttributes({ prefix: value })}
          />
          <TextControl
            label={__("Icon Name", "fa-icon-block")}
            value={iconName}
            onChange={(value) => setAttributes({ iconName: value })}
          />
 * */
