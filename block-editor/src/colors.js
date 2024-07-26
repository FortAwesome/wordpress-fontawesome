import { NO_CUSTOM_VALUE, SELECTED_CLASS, CUSTOM_COLOR_TEXT } from './constants'
import { faBan } from '@fortawesome/free-solid-svg-icons'
import classnames from 'classnames'
import { __ } from '@wordpress/i18n'
import { useState } from '@wordpress/element'
import { Button, ColorPicker, Tooltip } from '@wordpress/components'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'

const NO_COLOR_TEXT = __('No Color', 'font-awesome')

export default ({ themeColors, onChange, attributes }) => {
  if (!Array.isArray(themeColors)) return
  const currentIconLayer = (attributes?.iconLayers || [])[0]
  if ('object' !== typeof currentIconLayer) return
  const currentColor = currentIconLayer?.color
  const currentColorIsCustom = !!currentColor && currentColor !== NO_CUSTOM_VALUE && !themeColors.find(({ color }) => color === currentColor)

  const [customColor, setCustomColor] = useState(NO_CUSTOM_VALUE)
  const [showCustomColorPicker, setShowCustomColorPicker] = useState(false)

  const setColor = ({ color, custom }) => {
    if (custom && !color) {
      // We're picking a custom color.
      setShowCustomColorPicker(true)
      return
    }

    if (custom && 'string' === typeof color) {
      // We've picked a custom color.
      setCustomColor(color)
    }

    if (!custom) {
      // We've picked a theme color.
      setCustomColor(NO_CUSTOM_VALUE)
      setShowCustomColorPicker(false)
    }

    onChange(color)
  }

  const customColorPickerDefaultValue = () => {
    if (currentColorIsCustom) {
      return currentColor
    }

    return '#000000'
  }

  const isColorSelected = ({ color, custom }) => {
    if (custom && currentColorIsCustom) {
      return true
    }

    if (!custom && color === currentColor) {
      return true
    }

    return false
  }

  return (
    <div className="fawp-color-settings">
      <Tooltip text={NO_COLOR_TEXT}>
        <div className="fawp-color-option-wrapper">
          <button
            aria-selected={isColorSelected({})}
            className={`${classnames({ [SELECTED_CLASS]: isColorSelected({}) })} fawp-button fawp-reset`}
            aria-label={NO_COLOR_TEXT}
            onClick={() => setColor({})}
          >
            <FontAwesomeIcon icon={faBan} />
          </button>
        </div>
      </Tooltip>
      {themeColors.map((color, index) => (
        <Tooltip
          key={index}
          text={color.name}
        >
          <div className="fawp-color-option-wrapper">
            <button
              aria-selected={isColorSelected({ color: color.color })}
              className={`${classnames({
                [SELECTED_CLASS]: isColorSelected({ color: color.color })
              })} fawp-button`}
              aria-label={color.name}
              style={{ backgroundColor: color.color }}
              onClick={() => setColor({ color: color.color })}
            >
              &nbsp;
            </button>
          </div>
        </Tooltip>
      ))}
      <Tooltip text={CUSTOM_COLOR_TEXT}>
        <div className="fawp-color-option-wrapper">
          <button
            aria-selected={isColorSelected({ custom: true })}
            className={`${classnames({
              [SELECTED_CLASS]: isColorSelected({ custom: true })
            })} fawp-button`}
            aria-label={CUSTOM_COLOR_TEXT}
            onClick={() => setColor({ custom: true })}
            style={{
              background: 'linear-gradient(to right, darkblue, lightgreen)'
            }}
          >
            &nbsp;
          </button>
        </div>
      </Tooltip>
      {showCustomColorPicker && (
        <div className="fawp-color-picker-wrapper">
          <ColorPicker
            defaultValue={customColorPickerDefaultValue()}
            onChange={(color) => setColor({ color, custom: true })}
          />
          <Button
            variant="secondary"
            onClick={() => setShowCustomColorPicker(false)}
          >
            {__('Close', 'font-awesome')}
          </Button>
        </div>
      )}
    </div>
  )
}
