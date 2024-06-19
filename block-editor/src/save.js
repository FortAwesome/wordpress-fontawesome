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
import buildIconDefinition from "./buildIconDefinition";
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

  const iconDefinition = buildIconDefinition(attributes);

  const svgElementClasses = classnames({
    "fa-spin": !!attributes.spin,
  });

  return (
    <span {...useBlockProps.save()}>
      <FontAwesomeIcon icon={iconDefinition} />
    </span>
  );
}
