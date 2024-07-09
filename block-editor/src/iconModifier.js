import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faReflectHorizontal, faReflectVertical, faReflectBoth, faHeartHalfStroke, faBellRing, faSlidersSimple } from "@fortawesome/pro-solid-svg-icons";
import { faBan, faBolt, faLayerGroup, faPlus, faPalette, faFilm, faHeart, faCircle, faRotateRight, faRotateLeft, faSpinner } from "@fortawesome/free-solid-svg-icons";
import createCustomEvent from './createCustomEvent';
import { renderIcon, computeIconLayerCount } from './rendering';
import { select } from '@wordpress/data';
import { useState } from '@wordpress/element';
import classnames from 'classnames';
import { ColorPalette, Tooltip } from '@wordpress/components';
import { __ } from '@wordpress/i18n'

const NO_TAB = 0;
const STYLES_TAB = 1;
const ANIMATIONS_TAB = 2;
const LAYERS_TAB = 3;
const POWER_TRANSFORMS_TAB = 4;
const ANIMATIONS = Object.freeze(['beat', 'beatFade', 'bounce', 'fade', 'flip', 'shake', 'spin', 'spinReverse', 'spinPulse'])

const openIconChooserForAddLayerEvent = createCustomEvent()

function OptionalTooltip({ enabled, text, children }) {
  return enabled
  ? <Tooltip text={text}>
  {children}
  </Tooltip>
  : <>
      {children}
  </>
}

function IconLayer(
  {
    handleSelect,
    layer,
    layerIndex,
    IconChooserModal,
    canMoveUp,
    canMoveDown,
    moveUp,
    moveDown,
    remove,
    selectLayer,
    selectedLayerIndex,
    clearLayerSelection
  },
) {
  const { iconDefinition, ...rest } = layer;
  const openEvent = createCustomEvent()

  const handleLayerSelection = () => {
    if(layerIndex === selectedLayerIndex) {
      clearLayerSelection()
    } else {
      selectLayer(layerIndex)
    }
  }

  return (
    <>
      <IconChooserModal
        onSubmit={handleSelect}
        openEvent={openEvent}
      />
      <div>
        <button className={classnames({'selected-layer': layerIndex === selectedLayerIndex})} onClick={handleLayerSelection}>
          {
            renderIcon({iconLayers: [{iconDefinition, fixedWidth: true, ...rest}]})
          }
        </button>
        <button onClick={() => document.dispatchEvent(openEvent)}>
          change
        </button>
        {canMoveUp &&
          (
            <button onClick={() => moveUp(layerIndex)}>
              up
            </button>
          )}
        {canMoveDown &&
          (
            <button onClick={() => moveDown(layerIndex)}>
              down
            </button>
          )}
        <button onClick={() => remove(layerIndex)}>
          remove
        </button>
      </div>
    </>
  );
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
  const iconLayerCount = computeIconLayerCount(attributes)
  const isMultiLayer = iconLayerCount > 1;
  const [ selectedLayerIndex, setSelectedLayerIndex ] = useState(isMultiLayer ? null : 0)
  const [ selectedTab, setSelectedTab ] = useState(NO_TAB)

  const moveUp = (curIndex) => {
    const newIconLayers = [...iconLayers];

    const prevIndex = curIndex - 1;
    const tmp = newIconLayers[prevIndex];
    newIconLayers[prevIndex] = newIconLayers[curIndex];
    newIconLayers[curIndex] = tmp;

    setAttributes({ iconLayers: newIconLayers });
  };

  const moveDown = (curIndex) => {
    const newIconLayers = [...iconLayers];

    const nextIndex = curIndex + 1;
    const tmp = newIconLayers[nextIndex];
    newIconLayers[nextIndex] = newIconLayers[curIndex];
    newIconLayers[curIndex] = tmp;

    setAttributes({ iconLayers: newIconLayers });
  };

  const removeLayer = (curIndex) => {
    const newIconLayers = [...iconLayers];
    newIconLayers.splice(curIndex, 1);
    if(newIconLayers.length === 1) {
      setSelectedLayerIndex(0)
    }
    setAttributes({ iconLayers: newIconLayers });
  };

  const openIconChooserToAddLayer = () => {
    document.dispatchEvent(openIconChooserForAddLayerEvent)
  }

  const selectLayer = (layerIndex) => {
    setSelectedLayerIndex(layerIndex)
  }

  const clearLayerSelection = () => {
    setSelectedLayerIndex(null)
  }

  const setColor = (color) => {
    const newIconLayers = [...iconLayers];
    newIconLayers[selectedLayerIndex].color = color
    setAttributes({ iconLayers: newIconLayers });
  }

  const setSize = (size) => {
    const newIconLayers = [...iconLayers];
    newIconLayers[selectedLayerIndex].size = size
    setAttributes({ iconLayers: newIconLayers });
  }

  const setRotation = (rotation) => {
    const newIconLayers = [...iconLayers];
    newIconLayers[selectedLayerIndex].rotation = rotation
    setAttributes({ iconLayers: newIconLayers });
  }

  const setFlip = (flip) => {
    const newIconLayers = [...iconLayers];
    newIconLayers[selectedLayerIndex].flip = flip
    setAttributes({ iconLayers: newIconLayers });
  }

  const setAnimation = (animation) => {
    const newIconLayers = [...iconLayers];
    for(const currentAnimation of ANIMATIONS) {
      // Turn off every animation, except the one being currently set.
      newIconLayers[selectedLayerIndex][currentAnimation] = animation === currentAnimation
    }

    // Special case: when setting spinReverse, spin must also be set.
    if('spinReverse' === animation) {
      newIconLayers[selectedLayerIndex].spin = true
    }

    setAttributes({ iconLayers: newIconLayers });
  }

  const { getSettings } = select('core/block-editor');

  const settings = getSettings();

  const optionsControlsDisabled = !Number.isInteger(selectedLayerIndex)

  const extraProps = {}

  if(isMultiLayer) {
    extraProps.wrapperProps = {className: 'fa-layers'}
  }

  if(Number.isInteger(selectedLayerIndex)) {
    extraProps.classNamesByLayer = []
    extraProps.classNamesByLayer[selectedLayerIndex] = 'selected-layer'
  }

  return (
    <div className="fa-icon-modifier">
      <div className="fa-icon-modifier-preview-container">
        <div className="fa-icon-modifier-preview">
          {renderIcon(attributes, extraProps)}
        </div>
        <OptionalTooltip enabled={optionsControlsDisabled} text={__("Select a layer to set these options", "font-awesome")}>
          <div className={classnames('fa-icon-modifier-preview-controls', {'options-controls-disabled': optionsControlsDisabled})}>
            <Tooltip text={__("Set style options", "font-awesome")}>
              <button disabled={optionsControlsDisabled} onClick={() => setSelectedTab(STYLES_TAB)}>
                <FontAwesomeIcon className="fa-icon-modifier-control" icon={faPalette}/>
              </button>
            </Tooltip>
            <Tooltip text={__("Set animation options", "font-awesome")}>
              <button disabled={optionsControlsDisabled} onClick={() => setSelectedTab(ANIMATIONS_TAB)}>
                <FontAwesomeIcon className="fa-icon-modifier-control" icon={faFilm} />
              </button>
            </Tooltip>
            <Tooltip text={__("Set power transform options", "font-awesome")}>
              <button disabled={optionsControlsDisabled} onClick={() => setSelectedTab(POWER_TRANSFORMS_TAB)}>
                <FontAwesomeIcon className="fa-icon-modifier-control" icon={faBolt} />
              </button>
            </Tooltip>
            {
              iconLayerCount === 1 &&
              <Tooltip text={__("Add a layer", "font-awesome")}>
                <button onClick={openIconChooserToAddLayer}>
                  <FontAwesomeIcon className="fa-icon-modifier-control" icon={faLayerGroup} />
                </button>
              </Tooltip>
            }
          </div>
        </OptionalTooltip>
      </div>
      {
        (STYLES_TAB == selectedTab) && <div className="fa-icon-modifier-styles">
          <div>
            <div className="options-section-heading">{__("Color", "font-awesome")}</div>
            <div>
              <ColorPalette colors={settings.colors} onChange={setColor}></ColorPalette>
            </div>
          </div>
          <div>
            <div className="options-section-heading">{__("Rotation", "font-awesome")}</div>
            <div>
              <Tooltip text={__("Remove Rotation", "font-awesome")}>
                <button onClick={() => setRotation(null)}>
                  <FontAwesomeIcon icon={faBan}/>
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
              <input type="number" placeholder={__("Custom...", "font-awesome")} onChange={(e) => setRotation(e.target.value)}/>
            </div>
          </div>
          <div>
            <div className="options-section-heading">{__("Size", "font-awesome")}</div>
            <div>
              <button onClick={() => setSize('2xs')}>2xs</button>
              <button onClick={() => setSize('xs')}>2xs</button>
              <Tooltip text={__("Remove Sizing", "font-awesome")}>
                <button onClick={() => setSize(null)}>
                  <FontAwesomeIcon icon={faBan}/>
                </button>
              </Tooltip>
              <button onClick={() => setSize('lg')}>2xs</button>
              <button onClick={() => setSize('xl')}>2xs</button>
              <button onClick={() => setSize('2xl')}>2xs</button>
            </div>
          </div>
          <div>
            <div className="options-section-heading">{__("Flip", "font-awesome")}</div>
            <div>
              <Tooltip text={__("Remove Flipping", "font-awesome")}>
                <button onClick={() => setFlip(null)}>
                  <FontAwesomeIcon icon={faBan}/>
                </button>
              </Tooltip>
              <Tooltip text={__("Flip Horizontal", "font-awesome")}>
                <button onClick={() => setFlip('horizontal')}>
                  <FontAwesomeIcon icon={faReflectHorizontal}/>
                </button>
              </Tooltip>
              <Tooltip text={__("Flip Vertical", "font-awesome")}>
                <button onClick={() => setFlip('vertical')}>
                  <FontAwesomeIcon icon={faReflectVertical}/>
                </button>
              </Tooltip>
              <Tooltip text={__("Flip Both", "font-awesome")}>
                <button onClick={() => setFlip('both')}>
                  <FontAwesomeIcon icon={faReflectBoth}/>
                </button>
              </Tooltip>
            </div>
          </div>
        </div>
      }
      {
        ANIMATIONS_TAB == selectedTab && <div className="fa-icon-modifier-animation">
          <div className="options-section-heading">{__("Animate", "font-awesome")}</div>
          <button onClick={() => setAnimation(null)}>
            <FontAwesomeIcon icon={faBan}/> {__("No Animation", "font-awesome")}
          </button>
          <button onClick={() => setAnimation('beat')}>
            <FontAwesomeIcon icon={faHeart}/> {__("Beat", "font-awesome")}
          </button>
          <button onClick={() => setAnimation('beatFade')}>
            <FontAwesomeIcon icon={faHeartHalfStroke}/> {__("Beat Fade", "font-awesome")}
          </button>
          <button onClick={() => setAnimation('bounce')}>
            <FontAwesomeIcon icon={faCircle}/> {__("Bounce", "font-awesome")}
          </button>
          <button onClick={() => setAnimation('fade')}>
            <FontAwesomeIcon icon={faSlidersSimple}/> {__("Fade", "font-awesome")}
          </button>
          <button onClick={() => setAnimation('flip')}>
            <FontAwesomeIcon icon={faReflectHorizontal}/> {__("Flip", "font-awesome")}
          </button>
          <button onClick={() => setAnimation('shake')}>
            <FontAwesomeIcon icon={faBellRing}/> {__("Shake", "font-awesome")}
          </button>
          <button onClick={() => setAnimation('spin')}>
            <FontAwesomeIcon icon={faRotateRight}/> {__("Spin", "font-awesome")}
          </button>
          <button onClick={() => setAnimation('spinReverse')}>
            <FontAwesomeIcon icon={faRotateLeft}/> {__("Spin Reverse", "font-awesome")}
          </button>
          <button onClick={() => setAnimation('spinPulse')}>
            <FontAwesomeIcon icon={faRotateLeft}/> {__("Spin Pulse", "font-awesome")}
          </button>
        </div>
      }
      {
        POWER_TRANSFORMS_TAB == selectedTab && <div className="fa-icon-modifier-power-transforms">
          <div className="options-section-heading">{__("Power Transforms", "font-awesome")}</div>
        </div>
      }
      {
        isMultiLayer && <div className="fa-icon-modifier-layers">
        <div className="options-section-heading">{__("Layers", "font-awesome")}</div>
        {iconLayers.map((layer, index) => (
          <IconLayer
            key={index}
            layerIndex={index}
            layer={layer}
            selectLayer={selectLayer}
            clearLayerSelection={clearLayerSelection}
            selectedLayerIndex={selectedLayerIndex}
            handleSelect={prepareHandleSelect({ replace: index })}
            IconChooserModal={IconChooserModal}
            canMoveUp={isMultiLayer && index > 0}
            canMoveDown={isMultiLayer && index <= (iconLayers.length - 2)}
            moveUp={moveUp}
            moveDown={moveDown}
            remove={removeLayer}
          />
        ))}
          <div>
            <button onClick={openIconChooserToAddLayer}>
              <FontAwesomeIcon icon={faPlus} />
            </button>
            Add Layer
          </div>
        </div>
      }
      <IconChooserModal
        onSubmit={prepareHandleSelect({ append: true })}
        openEvent={openIconChooserForAddLayerEvent}
      />
    </div>
  );
}
