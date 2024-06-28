import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import classnames from "classnames";

export function computeIconLayerCount(attributes) {
  return Array.isArray(attributes.iconLayers)
    ? attributes.iconLayers.length
    : 0;
}

export function prepareParamsForUseBlock(attributes) {
  const iconLayerCount = computeIconLayerCount(attributes);

  return {
    className: classnames({
      "fa-layers": iconLayerCount > 1,
    }),
  };
}

export function renderBlock(blockProps, attributes) {
  return (
    <span {...blockProps}>
      {attributes.iconLayers.map((layer, index) => {
        const { iconDefinition, ...rest } = layer;

        return (
          <FontAwesomeIcon
            key={index}
            icon={iconDefinition}
            {...rest}
          />
        );
      })}
    </span>
  );
}
