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
import { ColorPicker, ColorPalette, FontSizePicker, TabPanel, Tooltip } from '@wordpress/components';
import { __ } from '@wordpress/i18n'
import Colors from './colors'
import IconSizer from './iconSizer'
import { NO_CUSTOM_VALUE, SELECTED_CLASS, ANIMATIONS, ORIGINAL_SIZE } from './constants'

const STYLES_TAB_NAME = 'styling';
const ANIMATIONS_TAB_NAME = 'animations';

const SettingsTabPanel = ({onSelect, setSize, setColor, setAnimation, updateTransform, editorSettings, attributes}) => {
  const [customRotate, setCustomRotate] = useState(NO_CUSTOM_VALUE)
  const currentIconLayer = (attributes?.iconLayers || [])[0]
  if('object' !== typeof currentIconLayer) return
  const currentTransform = currentIconLayer?.transform
  const currentRotate = currentTransform?.rotate
  const currentSize = currentTransform?.size

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

  const hasNoFlip = () =>
    !currentTransform || (!currentTransform?.flipX && !currentTransform?.flipY)

  const flippedHorizontal = () => 
    currentTransform?.flipX && !currentTransform?.flipY

  const flippedVertical = () =>
    currentTransform?.flipY && !currentTransform?.flipX

  const flippedBoth = () =>
    currentTransform?.flipY && currentTransform?.flipX

  const isAnimationSelected = (animation) => {
    if('object' !== typeof currentIconLayer) return false

    if(!animation) {
      let foundAnimation = false

      for(const currentAnimation of ANIMATIONS) {
        if(currentIconLayer[animation]) {
          foundAnimation = true
          break
        }
      }

      return !foundAnimation
    }

    if('string' !== typeof animation) return false

    // Special case: spinReverse is modeled as a composite animation: both spin
    // and reverse. But we want the UI to reflect just one animation selection.
    // So we need to distinguish between spin and spinReverse.
    if('spinReverse' === animation) {
      return currentIconLayer[animation] && currentIconLayer['spin']
    } else if('spin' === animation) {
      return currentIconLayer['spin'] && !currentIconLayer['spinReverse']
    }

    return currentIconLayer[animation]
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
          }
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
              <IconSizer onChange={setSize}/>
            </div>
          </div>
          <div className="fa-icon-styling-tab-content icon-styling-flip">
            <div className="options-section-heading">
              {__("Flip", "font-awesome")}
            </div>
            <div className="styling-controls">
              <Tooltip text={__("Remove Flipping", "font-awesome")}>
                <button className={classnames({[SELECTED_CLASS]: hasNoFlip()})} className="reset" onClick={() => updateTransform({resetFlip: true})}>
                  <FontAwesomeIcon icon={faBan} />
                </button>
              </Tooltip>
              <Tooltip text={__("Flip Horizontal", "font-awesome")}>
                <button className={classnames({[SELECTED_CLASS]: flippedHorizontal()})} onClick={() => updateTransform({ toggleFlipX: true })}>
                  <FontAwesomeIcon icon={faReflectHorizontal} />
                </button>
              </Tooltip>
              <Tooltip text={__("Flip Vertical", "font-awesome")}>
                <button className={classnames({[SELECTED_CLASS]: flippedVertical()})} onClick={() => updateTransform({ toggleFlipY: true })}>
                  <FontAwesomeIcon icon={faReflectVertical} />
                </button>
              </Tooltip>
              <Tooltip text={__("Flip Both", "font-awesome")}>
                <button className={classnames({[SELECTED_CLASS]: flippedBoth()})} onClick={() => updateTransform({ toggleFlipX: true, toggleFlipY: true})}>
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
              <button className={classnames('animation-button', {[SELECTED_CLASS]: isAnimationSelected()})} className="reset" onClick={() => setAnimation(null)}>
                <FontAwesomeIcon icon={faBan} />{" "}
                {__("No Animation", "font-awesome")}
              </button>
              <button className={classnames('animation-button', {[SELECTED_CLASS]: isAnimationSelected('beat')})} onClick={() => setAnimation("beat")}>
                <FontAwesomeIcon icon={faHeart} /> {__("Beat", "font-awesome")}
              </button>
              <button className={classnames('animation-button', {[SELECTED_CLASS]: isAnimationSelected('beatFade')})} onClick={() => setAnimation("beatFade")}>
                <FontAwesomeIcon icon={faHeartHalfStroke} />{" "}
                {__("Beat Fade", "font-awesome")}
              </button>
              <button className={classnames('animation-button', {[SELECTED_CLASS]: isAnimationSelected('bounce')})} onClick={() => setAnimation("bounce")}>
                <FontAwesomeIcon icon={faCircle} />{" "}
                {__("Bounce", "font-awesome")}
              </button>
              <button className={classnames('animation-button', {[SELECTED_CLASS]: isAnimationSelected('fade')})} onClick={() => setAnimation("fade")}>
                <FontAwesomeIcon icon={faSlidersSimple} />{" "}
                {__("Fade", "font-awesome")}
              </button>
              <button className={classnames('animation-button', {[SELECTED_CLASS]: isAnimationSelected('flip')})} onClick={() => setAnimation("flip")}>
                <FontAwesomeIcon icon={faReflectHorizontal} />{" "}
                {__("Flip", "font-awesome")}
              </button>
              <button className={classnames('animation-button', {[SELECTED_CLASS]: isAnimationSelected('shake')})} onClick={() => setAnimation("shake")}>
                <FontAwesomeIcon icon={faBellRing} />{" "}
                {__("Shake", "font-awesome")}
              </button>
              <button className={classnames('animation-button', {[SELECTED_CLASS]: isAnimationSelected('spin')})} onClick={() => setAnimation("spin")}>
                <FontAwesomeIcon icon={faRotateRight} />{" "}
                {__("Spin", "font-awesome")}
              </button>
              <button className={classnames('animation-button', {[SELECTED_CLASS]: isAnimationSelected('spinReverse')})} onClick={() => setAnimation("spinReverse")}>
                <FontAwesomeIcon icon={faRotateLeft} />{" "}
                {__("Spin Reverse", "font-awesome")}
              </button>
              <button className={classnames('animation-button', {[SELECTED_CLASS]: isAnimationSelected('spinPulse')})} onClick={() => setAnimation("spinPulse")}>
                <FontAwesomeIcon icon={faRotateLeft} />{" "}
                {__("Spin Pulse", "font-awesome")}
              </button>
            </div>
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

  const setSize = (size) => {
    const newIconLayers = [...iconLayers];
    const style = newIconLayers[0]?.style || {}
    style.fontSize = size
    newIconLayers[0].style = style
    setAttributes({ iconLayers: newIconLayers });
  }

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

    const {resetFlip, toggleFlipX, toggleFlipY, rotate: rotateRaw, resetRotate, reset} = transformParams

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
          setSize={setSize}
          setAnimation={setAnimation}
        />
      </div>
    </div>
  );
}
