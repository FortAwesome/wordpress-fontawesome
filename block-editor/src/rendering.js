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

export function renderIcon(attributes, extraProps = {}) {
  const {wrapperProps, classNamesByLayer} = extraProps

  return (
    <span {...(wrapperProps || {})}>
      {attributes.iconLayers.map((layer, index) => {
        const { iconDefinition, ...rest } = layer;
        const classNamesForLayer = (classNamesByLayer || [])[index]

        return (
          <FontAwesomeIcon
            key={index}
            className={classNamesForLayer}
            icon={iconDefinition}
            {...rest}
          />
        );
      })}
    </span>
  );
}

export function renderBlock(blockProps, attributes) {
  const extraProps = {
    wrapperProps: blockProps,
    classNamesByLayer: []
  }

  return renderIcon(attributes, extraProps)
}
