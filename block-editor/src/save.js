/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

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
export default function save( { attributes } ) {
	const { width, height, primaryPath, secondaryPath, spin } = attributes;
  const isReady = width && height && (primaryPath || secondaryPath)

  if (!isReady) {
    return null
  }

  const classes = ['svg-inline--fa']

  if(spin) {
    classes.push('fa-spin')
  }

  return <span {...useBlockProps.save()}>
    <svg class={classes.join(' ')} viewBox={`0 0 ${width} ${height}`}>
      <path fill="currentColor" d={primaryPath}/>
    </svg>
  </span>
}
