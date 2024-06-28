import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";

export default function (blockProps, attributes) {
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
