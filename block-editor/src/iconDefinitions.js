import { isValid } from "./attributeValidation.js";

export function iconLayerAttributesToIconDefinitionsAndParams(attributes) {
  return (attributes?.iconLayers || []).reduce((acc, layer) => {
    //const { iconName, prefix, width, height, pathData } = attributes;
  }, {});
}

// Given block attributes, produce an IconDefinition.
export function toIconDefinition(attributes) {
  if (!isValid(attributes)) {
    return;
  }

  const { iconName, prefix, width, height, pathData } = attributes;

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
