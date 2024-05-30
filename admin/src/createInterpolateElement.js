import { __experimentalCreateInterpolateElement, createInterpolateElement as stableCreateInterpolateElement } from '@wordpress/element'

const createInterpolateElement = stableCreateInterpolateElement || __experimentalCreateInterpolateElement

export default createInterpolateElement
