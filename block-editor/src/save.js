import { useBlockProps } from '@wordpress/block-editor'
import { isBlockValid } from './attributeValidation'
import { prepareParamsForUseBlock, renderIcon } from './rendering'

export default function save({ attributes }) {
  if (!isBlockValid(attributes)) {
    return null
  }

  const extraProps = {
    wrapperProps: useBlockProps.save(prepareParamsForUseBlock(attributes))
  }

  return renderIcon(attributes, { extraProps })
}
