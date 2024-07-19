import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
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
import { ColorPalette, TabPanel, Tooltip } from '@wordpress/components';
import { __ } from '@wordpress/i18n'

const ORIGINAL_SIZE = 16
const NO_TAB = 0;
const STYLES_TAB = 1;
const STYLES_TAB_NAME = 'styles';
const ANIMATIONS_TAB = 2;
const ANIMATIONS_TAB_NAME = 'animations';
const POWER_TRANSFORMS_TAB = 4;
const POWER_TRANSFORMS_TAB_NAME = 'power-transforms';
export const ANIMATIONS = Object.freeze(['beat', 'beatFade', 'bounce', 'fade', 'flip', 'shake', 'spin', 'spinReverse', 'spinPulse'])

const SettingsTabPanel = ({onSelect}) => 
  <TabPanel
      className="fawp-icon-settings-tab-panel"
      activeClass="fawp-icon-settings-active-tab"
      onSelect={ onSelect }
      tabs={ [
          {
              name: STYLES_TAB_NAME,
              title: __('Styles', 'font-awesome'),
              className: `fawp-icon-settings-${STYLES_TAB_NAME}`,
          },
          {
              name: ANIMATIONS_TAB_NAME,
              title: __('Animations', 'font-awesome'),
              className: `fawp-icon-settings-${ANIMATIONS_TAB_NAME}`,
          },
          {
              name: POWER_TRANSFORMS_TAB_NAME,
              title: __('Power Transforms', 'font-awesome'),
              className: `fawp-icon-settings-${POWER_TRANSFORMS_TAB_NAME}`,
          },
      ] }
  >
      { ( tab ) => <p>This Tab! { tab.title }</p> }
  </TabPanel>

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

  const setSize = (size) => {
    const newIconLayers = [...iconLayers];
    newIconLayers[0].size = size
    setAttributes({ iconLayers: newIconLayers });
  }

  const setRotation = (rotation) => {
    const newIconLayers = [...iconLayers];
    newIconLayers[0].rotation = rotation
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

    const {grow, shrink, right, left, up, down, toggleFlipX, toggleFlipY, rotate: rotateRaw, resetRotate, reset} = transformParams

    if(Number.isFinite(grow) && grow > 0) {
      updates.size = (prevTransform.size || ORIGINAL_SIZE) + grow
    } else if(Number.isFinite(shrink) && shrink > 0) {
      updates.size = (prevTransform.size || ORIGINAL_SIZE) - shrink
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
      updates.flipX = !prevTransform?.flipX
    }

    if(toggleFlipY) {
      updates.flipY = !prevTransform?.flipY
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

    newIconLayers[0].transform = reset ? null : updatedTransform
    setAttributes({ iconLayers: newIconLayers });
  }

  const { getSettings } = select('core/block-editor');

  const settings = getSettings();

  return (
    <div className="fa-icon-modifier">
      <div className="fa-icon-modifier-preview-container">
        <div className="fa-icon-modifier-preview">
          {renderIcon(attributes)}
        </div>
        <div
          className={classnames("fa-icon-modifier-preview-controls")}
        >
          <SettingsTabPanel onSelect={setSelectedTab}/>
          <Tooltip text={__("Set style options", "font-awesome")}>
            <button
              onClick={() => setSelectedTab(STYLES_TAB)}
            >
              <FontAwesomeIcon
                className="fa-icon-modifier-control"
                icon={faPalette}
              />
            </button>
          </Tooltip>
          <Tooltip text={__("Set animation options", "font-awesome")}>
            <button
              onClick={() => setSelectedTab(ANIMATIONS_TAB)}
            >
              <FontAwesomeIcon
                className="fa-icon-modifier-control"
                icon={faFilm}
              />
            </button>
          </Tooltip>
          <Tooltip text={__("Set power transform options", "font-awesome")}>
            <button
              onClick={() => setSelectedTab(POWER_TRANSFORMS_TAB)}
            >
              <FontAwesomeIcon
                className="fa-icon-modifier-control"
                icon={faBolt}
              />
            </button>
          </Tooltip>
        </div>
      </div>
      {STYLES_TAB == selectedTab && (
        <div className="fa-icon-styling-tab-content-wrapper">
          <div className="fa-icon-styling-tab-content icon-styling-color">
            <div className="options-section-heading">
              {__("Color", "font-awesome")}
            </div>
            <div>
              <ColorPalette
                disableCustomColors
                colors={settings.colors}
                onChange={setColor}
              ></ColorPalette>
            </div>
          </div>
          <div className="fa-icon-styling-tab-content icon-styling-rotate">
            <div className="options-section-heading">
              {__("Rotation", "font-awesome")}
            </div>
            <div className="styling-controls">
              <Tooltip text={__("Remove Rotation", "font-awesome")}>
                <button className="reset" onClick={() => setRotation(null)}>
                  <FontAwesomeIcon icon={faBan} />
                </button>
              </Tooltip>
              <Tooltip text={__("Rotate 90deg to the right", "font-awesome")}>
                <button onClick={() => setRotation(90)}>90°</button>
              </Tooltip>
              <Tooltip text={__("Rotate 180deg to the right", "font-awesome")}>
                <button onClick={() => setRotation(180)}>180°</button>
              </Tooltip>
              <Tooltip text={__("Rotate 270deg to the right", "font-awesome")}>
                <button onClick={() => setRotation(270)}>270°</button>
              </Tooltip>
              <input
                type="number"
                placeholder={__("Custom...", "font-awesome")}
                onChange={(e) => setRotation(e.target.value)}
              />
            </div>
          </div>
          <div className="fa-icon-styling-tab-content icon-styling-size">
            <div className="options-section-heading">
              {__("Size", "font-awesome")}
            </div>
            <div className="styling-controls">
              <Tooltip text={__("Remove Sizing", "font-awesome")}>
                <button className="reset" onClick={() => setSize(null)}>
                  <FontAwesomeIcon icon={faBan} />
                </button>
              </Tooltip>
              <button onClick={() => setSize("2x")}>2x</button>
              <button onClick={() => setSize("4x")}>4x</button>
              <button onClick={() => setSize("6x")}>6x</button>
              <button onClick={() => setSize("8x")}>8x</button>
              <button onClick={() => setSize("10x")}>10x</button>
            </div>
          </div>
          <div className="fa-icon-styling-tab-content icon-styling-flip">
            <div className="options-section-heading">
              {__("Flip", "font-awesome")}
            </div>
            <div className="styling-controls">
              <Tooltip text={__("Remove Flipping", "font-awesome")}>
                <button className="reset" onClick={() => setFlip(null)}>
                  <FontAwesomeIcon icon={faBan} />
                </button>
              </Tooltip>
              <Tooltip text={__("Flip Horizontal", "font-awesome")}>
                <button onClick={() => setFlip("horizontal")}>
                  <FontAwesomeIcon icon={faReflectHorizontal} />
                </button>
              </Tooltip>
              <Tooltip text={__("Flip Vertical", "font-awesome")}>
                <button onClick={() => setFlip("vertical")}>
                  <FontAwesomeIcon icon={faReflectVertical} />
                </button>
              </Tooltip>
              <Tooltip text={__("Flip Both", "font-awesome")}>
                <button onClick={() => setFlip("both")}>
                  <FontAwesomeIcon icon={faReflectBoth} />
                </button>
              </Tooltip>
            </div>
          </div>
        </div>
      )}
      {ANIMATIONS_TAB == selectedTab && (
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
      )}
      {POWER_TRANSFORMS_TAB == selectedTab && (
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
      )}
    </div>
  );
}
