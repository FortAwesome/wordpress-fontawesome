import get from 'lodash/get'

export default function () {
  const reactVersion = get(
    window,
    '__Font_Awesome_Webpack_Externals__.React.version',
    ''
  )

  const [ reactMajor, reactMinor, ] = reactVersion.split('.')

  if(  +reactMajor < 16 || ( +reactMajor === 16 && +reactMinor < 9 ) ) {
    const { __, sprintf } = __Font_Awesome_Webpack_Externals__.i18n
    console.warn( sprintf( __('Font Awesome Plugin requires at least React 16.9.0 for some features. Your version of React is older: %1$s', 'font-awesome' ), reactVersion ) )
    return false
  }

  const { __experimentalCreateInterpolateElement, createInterpolateElement } = get(window, '__Font_Awesome_Webpack_Externals__.element', {})

  if( ! ( __experimentalCreateInterpolateElement || createInterpolateElement ) ) {
    const { __ } = __Font_Awesome_Webpack_Externals__.i18n
    console.warn( __('Font Awesome Plugin requires @wordpress/element version 2.10.0 or newer. It looks like you have an older version since the createInterpolateElement function is not available.', 'font-awesome' ) )
    return false
  }

  return true
}
