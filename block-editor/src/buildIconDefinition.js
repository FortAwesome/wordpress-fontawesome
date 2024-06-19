import { isValid } from "./attributeValidation.js";

export default function (attributes) {
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
