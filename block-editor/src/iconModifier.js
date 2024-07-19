import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { wpIconFromFaIconDefinition } from "./icons";
import {
  faReflectHorizontal,
  faReflectVertical,
  faReflectBoth,
  faHeartHalfStroke,
  faBellRing,
  faSlidersSimple,
  faExpand,
  faCompress,
  faRight,
  faLeft,
  faUp,
  faDown
} from "@fortawesome/pro-solid-svg-icons";
import {
  faBan,
  faBolt,
  faPlus,
  faPalette,
  faFilm,
  faHeart,
  faCircle,
  faRotateRight,
  faRotateLeft,
  faSpinner
} from "@fortawesome/free-solid-svg-icons";
import createCustomEvent from './createCustomEvent';
import { renderIcon } from './rendering';
import { select } from '@wordpress/data';
import { useState } from '@wordpress/element';
import classnames from 'classnames';
import { ColorPicker, ColorPalette, TabPanel, Tooltip } from '@wordpress/components';
import { __ } from '@wordpress/i18n'

const ORIGINAL_SIZE = 16
const NO_TAB = 0;
const STYLES_TAB = 1;
const STYLES_TAB_NAME = 'styling';
const ANIMATIONS_TAB = 2;
const ANIMATIONS_TAB_NAME = 'animations';
const POWER_TRANSFORMS_TAB = 4;
const POWER_TRANSFORMS_TAB_NAME = 'power-transforms';
export const ANIMATIONS = Object.freeze(['beat', 'beatFade', 'bounce', 'fade', 'flip', 'shake', 'spin', 'spinReverse', 'spinPulse'])
const NO_CUSTOM_VALUE = ''
const SELECTED_CLASS = 'fawp-selected'
const NO_COLOR_TEXT = __('No Color', 'font-awesome')
const CUSTOM_COLOR_TEXT = __('Custom Color', 'font-awesome')

const Colors = ({themeColors, onChange, attributes}) => {
  if(!Array.isArray(themeColors)) return
  const currentIconLayer = (attributes?.iconLayers || [])[0]
  if('object' !== typeof currentIconLayer) return
  const currentColor = currentIconLayer?.color
  const [customColor, setCustomColor] = useState(NO_CUSTOM_VALUE)
  const [showCustomColorPicker, setShowCustomColorPicker] = useState(false)

  const setColor = ({color, custom}) => {
    if(custom && !color) {
      // We're picking a custom color.
      setShowCustomColorPicker(true)
      return
    }

    if(custom && 'string' === typeof color) {
      // We've picked a custom color.
      setCustomColor(color)
    }

    if(!custom) {
      // We've picked a theme color.
      setCustomColor(NO_CUSTOM_VALUE)
    }

    setShowCustomColorPicker(false)
    onChange(color)
  }

  const isColorSelected = ({color, custom}) =>
    (custom && customColor !== NO_CUSTOM_VALUE)
    || (color === currentColor)

  return <div className="fawp-color-settings">
    <Tooltip text={NO_COLOR_TEXT}>
      <button
          aria-selected={isColorSelected({})}
          className={classnames({[SELECTED_CLASS]: isColorSelected({})})}
          aria-label={NO_COLOR_TEXT}
          onClick={() => setColor({})}>
          <FontAwesomeIcon icon={faBan} />
      </button>
    </Tooltip>
  {
    themeColors.map((color, index) => 
      <Tooltip key={index} text={color.name}>
        <button
            aria-selected={isColorSelected(color.color)}
            className={classnames({[SELECTED_CLASS]: isColorSelected({color: color.color})})}
            aria-label={color.name}
            style={{backgroundColor: color.color}}
            onClick={() => setColor({color: color.color})}>
            &nbsp;
        </button>
      </Tooltip>
    )
  }
    <Tooltip text={CUSTOM_COLOR_TEXT}>
      <button
          aria-selected={isColorSelected({custom: true})}
          className={classnames({[SELECTED_CLASS]: isColorSelected({custom: true})})}
          aria-label={CUSTOM_COLOR_TEXT}
          onClick={() => setColor({custom: true})}
          style={{background: 'linear-gradient(to right, darkblue, lightgreen)'}}>
          &nbsp;
      </button>
    </Tooltip>
    {
      showCustomColorPicker &&
        <ColorPicker onChange={(color) => setColor({color, custom: true})}/>
    }
  </div>
}

const SettingsTabPanel = ({onSelect, setColor, setAnimation, updateTransform, editorSettings, attributes}) => {
  const [customRotate, setCustomRotate] = useState(NO_CUSTOM_VALUE)
  const currentIconLayer = (attributes?.iconLayers || [])[0]
  if('object' !== typeof currentIconLayer) return
  const currentRotate = currentIconLayer?.transform?.rotate
  const currentSize = currentIconLayer?.transform?.size

  const resetRotate = () => {
    updateTransform({resetRotate: true})
    setCustomRotate(NO_CUSTOM_VALUE)
  }

  const setRotate = ({rotate, custom}) => {
    if(custom) {
      const rotateFloat = Number.parseFloat(rotate);
      if(Number.isFinite(rotateFloat)) {
        updateTransform({rotate: rotateFloat})
        setCustomRotate(rotateFloat)
      }
    } else {
      if(Number.isFinite(rotate)) {
        updateTransform({rotate})
      }
      setCustomRotate(NO_CUSTOM_VALUE)
    }
  }

  const rotateSelectionClass = (val) => {
    if('custom' === val && customRotate) {
      return SELECTED_CLASS
    } else if(Number.isFinite(val) && val === currentRotate) {
      return SELECTED_CLASS
    }
  }

  const isSizeSelected = (size) => {
    if(!Number.isFinite(size) && !Number.isFinite(currentSize)) {
      // No size is selected.
      return true
    }

    if(!Number.isFinite(size)) return false

    const multipliedSize = size * ORIGINAL_SIZE 

    return multipliedSize === currentSize
  }

  return <TabPanel
      className="fawp-icon-settings-tab-panel"
      activeClass="fawp-icon-settings-active-tab"
      onSelect={ onSelect }
      tabs={ [
          {
              name: STYLES_TAB_NAME,
              icon: wpIconFromFaIconDefinition(faPalette),
              title: __('Add Styling', 'font-awesome'),
              className: `fawp-icon-settings-${STYLES_TAB_NAME}`,
          },
          {
              name: ANIMATIONS_TAB_NAME,
              icon: wpIconFromFaIconDefinition(faFilm),
              title: __('Add Animation', 'font-awesome'),
              className: `fawp-icon-settings-${ANIMATIONS_TAB_NAME}`,
          },
          {
              name: POWER_TRANSFORMS_TAB_NAME,
              icon: wpIconFromFaIconDefinition(faBolt),
              title: __('Power Transforms', 'font-awesome'),
              className: `fawp-icon-settings-${POWER_TRANSFORMS_TAB_NAME}`,
          },
      ] }
  >
    { ( tab ) => {
      if(STYLES_TAB_NAME == tab.name) return (
        <div className="fa-icon-styling-tab-content-wrapper">
          <div className="fa-icon-styling-tab-content icon-styling-color">
            <div className="options-section-heading">
              {__("Color", "font-awesome")}
            </div>
            <div>
              <Colors
                themeColors={editorSettings.colors}
                onChange={setColor}
                attributes={attributes}
              />
            </div>
          </div>
          <div className="fa-icon-styling-tab-content icon-styling-rotate">
            <div className="options-section-heading">
              {__("Rotation", "font-awesome")}
            </div>
            <div className="styling-controls">
              <Tooltip text={__("Remove Rotation", "font-awesome")}>
                <button className={rotateSelectionClass()} className="reset" onClick={resetRotate}>
                  <FontAwesomeIcon icon={faBan} />
                </button>
              </Tooltip>
              <Tooltip text={__("Rotate 90deg to the right", "font-awesome")}>
                <button className={rotateSelectionClass(90)} onClick={() => setRotate({rotate: 90})}>90°</button>
              </Tooltip>
              <Tooltip text={__("Rotate 180deg to the right", "font-awesome")}>
                <button className={rotateSelectionClass(180)} onClick={() => setRotate({rotate: 180})}>180°</button>
              </Tooltip>
              <Tooltip text={__("Rotate 270deg to the right", "font-awesome")}>
                <button className={rotateSelectionClass(270)} onClick={() => setRotate({rotate: 270})}>270°</button>
              </Tooltip>
              <input
                className={rotateSelectionClass('custom')}
                type="number"
                placeholder={__("Custom...", "font-awesome")}
                value={customRotate}
                onChange={(e) => setRotate({rotate: e.target.value, custom: true})}
              />
            </div>
          </div>
          <div className="fa-icon-styling-tab-content icon-styling-size">
            <div className="options-section-heading">
              {__("Size", "font-awesome")}
            </div>
            <div className="styling-controls">
              <Tooltip text={__("Remove Sizing", "font-awesome")}>
                <button className={classnames("reset", "size-button", {[SELECTED_CLASS]: isSizeSelected()})} onClick={() => updateTransform({resetSize: true})}>
                  <FontAwesomeIcon icon={faBan} />
                </button>
              </Tooltip>
              <button className={classnames('size-button', {[SELECTED_CLASS]: isSizeSelected(2)})} onClick={() => updateTransform({growTimes: 2})}>2x</button>
              <button className={classnames('size-button', {[SELECTED_CLASS]: isSizeSelected(4)})} onClick={() => updateTransform({growTimes: 4})}>4x</button>
              <button className={classnames('size-button', {[SELECTED_CLASS]: isSizeSelected(6)})} onClick={() => updateTransform({growTimes: 6})}>6x</button>
              <button className={classnames('size-button', {[SELECTED_CLASS]: isSizeSelected(8)})} onClick={() => updateTransform({growTimes: 8})}>8x</button>
              <button className={classnames('size-button', {[SELECTED_CLASS]: isSizeSelected(10)})} onClick={() => updateTransform({growTimes: 10})}>10x</button>
            </div>
          </div>
          <div className="fa-icon-styling-tab-content icon-styling-flip">
            <div className="options-section-heading">
              {__("Flip", "font-awesome")}
            </div>
            <div className="styling-controls">
              <Tooltip text={__("Remove Flipping", "font-awesome")}>
                <button className="reset" onClick={() => updateTransform({resetFlip: true})}>
                  <FontAwesomeIcon icon={faBan} />
                </button>
              </Tooltip>
              <Tooltip text={__("Flip Horizontal", "font-awesome")}>
                <button onClick={() => updateTransform({ toggleFlipX: true })}>
                  <FontAwesomeIcon icon={faReflectHorizontal} />
                </button>
              </Tooltip>
              <Tooltip text={__("Flip Vertical", "font-awesome")}>
                <button onClick={() => updateTransform({ toggleFlipY: true })}>
                  <FontAwesomeIcon icon={faReflectVertical} />
                </button>
              </Tooltip>
              <Tooltip text={__("Flip Both", "font-awesome")}>
                <button onClick={() => updateTransform({ toggleFlipX: true, toggleFlipY: true})}>
                  <FontAwesomeIcon icon={faReflectBoth} />
                </button>
              </Tooltip>
            </div>
          </div>
        </div>
      )

      if(ANIMATIONS_TAB_NAME == tab.name) return (
        <div className="fa-icon-animations-tab-content-wrapper">
          <div className="fa-icon-animations-tab-content icon-animations">
            <div className="options-section-heading">
              {__("Animate", "font-awesome")}
            </div>
            <div className="animation-controls">
              <button className="reset" onClick={() => setAnimation(null)}>
                <FontAwesomeIcon icon={faBan} />{" "}
                {__("No Animation", "font-awesome")}
              </button>
              <button onClick={() => setAnimation("beat")}>
                <FontAwesomeIcon icon={faHeart} /> {__("Beat", "font-awesome")}
              </button>
              <button onClick={() => setAnimation("beatFade")}>
                <FontAwesomeIcon icon={faHeartHalfStroke} />{" "}
                {__("Beat Fade", "font-awesome")}
              </button>
              <button onClick={() => setAnimation("bounce")}>
                <FontAwesomeIcon icon={faCircle} />{" "}
                {__("Bounce", "font-awesome")}
              </button>
              <button onClick={() => setAnimation("fade")}>
                <FontAwesomeIcon icon={faSlidersSimple} />{" "}
                {__("Fade", "font-awesome")}
              </button>
              <button onClick={() => setAnimation("flip")}>
                <FontAwesomeIcon icon={faReflectHorizontal} />{" "}
                {__("Flip", "font-awesome")}
              </button>
              <button onClick={() => setAnimation("shake")}>
                <FontAwesomeIcon icon={faBellRing} />{" "}
                {__("Shake", "font-awesome")}
              </button>
              <button onClick={() => setAnimation("spin")}>
                <FontAwesomeIcon icon={faRotateRight} />{" "}
                {__("Spin", "font-awesome")}
              </button>
              <button onClick={() => setAnimation("spinReverse")}>
                <FontAwesomeIcon icon={faRotateLeft} />{" "}
                {__("Spin Reverse", "font-awesome")}
              </button>
              <button onClick={() => setAnimation("spinPulse")}>
                <FontAwesomeIcon icon={faRotateLeft} />{" "}
                {__("Spin Pulse", "font-awesome")}
              </button>
            </div>
          </div>
        </div>
      )

      if(POWER_TRANSFORMS_TAB_NAME == tab.name) return (
        <div className="fa-icon-modifier-power-transforms">
          <div className="options-section-heading">
            {__("Power Transforms", "font-awesome")}
          </div>

          <Tooltip text={__("Reset Transform", "font-awesome")}>
            <button onClick={() => updateTransform({ reset: true })}>
              <FontAwesomeIcon icon={faBan} />
            </button>
          </Tooltip>
          <Tooltip text={__("Grow", "font-awesome")}>
            <button onClick={() => updateTransform({ grow: 1 })}>
              <FontAwesomeIcon icon={faExpand} />
            </button>
          </Tooltip>
          <Tooltip text={__("Shrink", "font-awesome")}>
            <button onClick={() => updateTransform({ shrink: 1 })}>
              <FontAwesomeIcon icon={faCompress} />
            </button>
          </Tooltip>
          <Tooltip text={__("Move Right", "font-awesome")}>
            <button onClick={() => updateTransform({ right: 1 })}>
              <FontAwesomeIcon icon={faRight} />
            </button>
          </Tooltip>
          <Tooltip text={__("Move Left", "font-awesome")}>
            <button onClick={() => updateTransform({ left: 1 })}>
              <FontAwesomeIcon icon={faLeft} />
            </button>
          </Tooltip>
          <Tooltip text={__("Move Up", "font-awesome")}>
            <button onClick={() => updateTransform({ up: 1 })}>
              <FontAwesomeIcon icon={faUp} />
            </button>
          </Tooltip>
          <Tooltip text={__("Move Down", "font-awesome")}>
            <button onClick={() => updateTransform({ down: 1 })}>
              <FontAwesomeIcon icon={faDown} />
            </button>
          </Tooltip>
          <Tooltip text={__("Toggle Flip Horizontal", "font-awesome")}>
            <button onClick={() => updateTransform({ toggleFlipX: true })}>
              <FontAwesomeIcon icon={faReflectHorizontal} />
            </button>
          </Tooltip>
          <Tooltip text={__("Toggle Flip Vertical", "font-awesome")}>
            <button onClick={() => updateTransform({ toggleFlipY: true })}>
              <FontAwesomeIcon icon={faReflectVertical} />
            </button>
          </Tooltip>
          <div>
            <Tooltip text={__("Remove Rotation", "font-awesome")}>
              <button onClick={() => updateTransform({ resetRotate: true })}>
                <FontAwesomeIcon icon={faBan} />
              </button>
            </Tooltip>
            <Tooltip text={__("Rotate 90deg to the right", "font-awesome")}>
              <button onClick={() => updateTransform({ rotate: 90 })}>
                90°
              </button>
            </Tooltip>
            <Tooltip text={__("Rotate 180deg to the right", "font-awesome")}>
              <button onClick={() => updateTransform({ rotate: 180 })}>
                180°
              </button>
            </Tooltip>
            <Tooltip text={__("Rotate 270deg to the right", "font-awesome")}>
              <button onClick={() => updateTransform({ rotate: 270 })}>
                270°
              </button>
            </Tooltip>
            <input
              type="number"
              placeholder={__("Custom...", "font-awesome")}
              onChange={(e) => updateTransform({ rotate: e.target.value })}
            />
          </div>
        </div>
      )
    }
    }
  </TabPanel>
}

export default function (
  {
    attributes,
    setAttributes,
    IconChooserModal,
    prepareHandleSelect
  },
) {
  const iconLayers = attributes.iconLayers || [];
  const [ selectedTab, setSelectedTab ] = useState(STYLES_TAB_NAME)

  const setColor = (color) => {
    const newIconLayers = [...iconLayers];
    newIconLayers[0].color = color
    setAttributes({ iconLayers: newIconLayers });
  }

  const setFlip = (flip) => {
    const newIconLayers = [...iconLayers];
    newIconLayers[0].flip = flip
    setAttributes({ iconLayers: newIconLayers });
  }

  const setAnimation = (animation) => {
    const newIconLayers = [...iconLayers];
    for(const currentAnimation of ANIMATIONS) {
      // Turn off every animation, except the one being currently set.
      newIconLayers[0][currentAnimation] = animation === currentAnimation
    }

    // Special case: when setting spinReverse, spin must also be set.
    if('spinReverse' === animation) {
      newIconLayers[0].spin = true
    }

    setAttributes({ iconLayers: newIconLayers });
  }

  const updateTransform = (transformParams) => {
    const newIconLayers = [...iconLayers];
    const prevTransform =  (newIconLayers[0]?.transform || {})

    const updates = {}

    const {resetSize, grow, growTimes, shrink, right, left, up, down, resetFlip, toggleFlipX, toggleFlipY, rotate: rotateRaw, resetRotate, reset} = transformParams

    if(Number.isFinite(grow) && grow > 0) {
      updates.size = (prevTransform.size || ORIGINAL_SIZE) + grow
    } else if(Number.isFinite(growTimes) && growTimes > 0) {
      updates.size = ORIGINAL_SIZE * growTimes
    }

    if(Number.isFinite(right) && right > 0) {
      updates.x = (prevTransform.x || 0) + right
    } else if(Number.isFinite(left) && left > 0) {
      updates.x = (prevTransform.x || 0) - left
    }

    if(Number.isFinite(up) && up > 0) {
      updates.y = (prevTransform.y || 0) - up
    } else if(Number.isFinite(down) && down > 0) {
      updates.y = (prevTransform.y || 0) + down
    }

    if(toggleFlipX) {
      updates.flipX = true
    }

    if(toggleFlipY) {
      updates.flipY = true
    }

    const rotate = parseInt(rotateRaw)

    if(Number.isFinite(rotate)) {
      updates.rotate = rotate
    }

    const updatedTransform = {
      ...prevTransform,
      ...updates
    }

    if(resetRotate && updatedTransform.hasOwnProperty('rotate')) {
      delete updatedTransform.rotate
    }

    if(resetSize) {
      delete updatedTransform.size
    }

    if(resetFlip) {
      delete updatedTransform.flipX
      delete updatedTransform.flipY
    }

    newIconLayers[0].transform = reset ? null : updatedTransform
    setAttributes({ iconLayers: newIconLayers });
  }

  const { getSettings } = select('core/block-editor');

  const editorSettings = getSettings();

  return (
    <div className="fa-icon-modifier">
      <div className="fa-icon-modifier-preview-container">
        <div className="fa-icon-modifier-preview">
          {renderIcon(attributes)}
        </div>
      </div>
      <div
        className={classnames("fa-icon-modifier-preview-controls")}
      >
        <SettingsTabPanel
          attributes={attributes}
          onSelect={setSelectedTab}
          editorSettings={editorSettings}
          updateTransform={updateTransform}
          setColor={setColor}
        />
      </div>
    </div>
  );
}
