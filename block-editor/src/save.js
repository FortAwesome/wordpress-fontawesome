/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from "@wordpress/block-editor";
import classnames from "classnames";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { isBlockValid } from "./attributeValidation";
import { toIconDefinition } from "./iconDefinitions";
import { prepareParamsForUseBlock, renderIcon } from "./rendering";
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
  if (!isBlockValid(attributes)) {
    return null;
  }

  const extraProps = {
    wrapperProps: useBlockProps.save(prepareParamsForUseBlock(attributes))
  };

  return renderIcon(attributes, extraProps);
}
