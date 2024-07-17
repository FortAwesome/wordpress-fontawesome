// export function iconLayerAttributesToIconDefinitionsAndParams(attributes) {
//   return (attributes?.iconLayers || []).reduce((acc, layer) => {
//     //const { iconName, prefix, width, height, pathData } = attributes;
//   }, {});
// }
import { filterSelectionEvent } from "./attributeValidation";

export function toIconDefinition({ iconName, prefix, width, height, pathData }) {
  if (!iconName || !prefix || !Number.isInteger(width) || !Number.isInteger(height) || !Array.isArray(pathData)) {
    return
  }

  const convertedPathData = pathData.length > 1 ? pathData : pathData[0];

  return {
    iconName,
    prefix,
    icon: [
      width,
      height,
      , // ligatures
      , // unicode
      convertedPathData,
    ],
  };
}

// Given an IconDefinition, produce a structure that is ready for use in
// constructing an SVG.
export function normalizeIconDefinition({ iconName, prefix, icon }) {
  if ("string" !== typeof iconName) {
    return;
  }

  if ("string" !== typeof prefix) {
    return;
  }

  if (!Array.isArray(icon) || icon.length < 5) {
    return;
  }

  const [
    width,
    height,
    , // ligatures
    , // unicode
    pathData,
  ] = icon;

  const isDuotone = Array.isArray(pathData);

  const primaryPath = isDuotone
    ? (Array.isArray(pathData) ? pathData[1] : "")
    : pathData;

  const secondaryPath = Array.isArray(pathData) ? pathData[0] : null;

  return {
    iconName,
    prefix,
    width,
    height,
    isDuotone,
    primaryPath,
    secondaryPath,
  };
}

export function iconDefinitionFromIconChooserSelectionEvent(event) {
  const filteredSelectionAttributes = filterSelectionEvent(event);

  if ("object" !== typeof filteredSelectionAttributes) {
    return;
  }

  return toIconDefinition(filteredSelectionAttributes)
}
