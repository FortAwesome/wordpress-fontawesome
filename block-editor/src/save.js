/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from "@wordpress/block-editor";
import classnames from "classnames";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { isValid } from "./attributeValidation";
import { toIconDefinition } from "./iconDefinitions";
/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @param {Object} props            Properties passed to the function.
 * @param {Object} props.attributes Available block attributes.
 *
 * @return {Element} Element to render.
 */
export default function save({ attributes }) {
  if (!isValid(attributes)) {
    return null;
  }

  const iconLayerCount = Array.isArray(attributes.iconLayers)
    ? attributes.iconLayers.length
    : 0;

  const blockProps = useBlockProps({
    className: classnames({
      "fa-layers": iconLayerCount > 1,
    }),
  }).save();

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
