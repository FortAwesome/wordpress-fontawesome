import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faBolt, faLayerGroup, faPlus, faPalette, faFilm } from "@fortawesome/free-solid-svg-icons";
import createCustomEvent from './createCustomEvent';
import { renderIcon, computeIconLayerCount } from './rendering';
import { select } from '@wordpress/data';
import { useState } from '@wordpress/element';
import classnames from 'classnames';
import { Tooltip } from '@wordpress/components';
import { __ } from '@wordpress/i18n'

const NO_TAB = 0;
const STYLES_TAB = 1;
const ANIMATIONS_TAB = 2;
const LAYERS_TAB = 3;
const POWER_TRANSFORMS_TAB = 4;

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
          <FontAwesomeIcon
            fixedWidth
            icon={iconDefinition}
            {...rest}
          />
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
  const [ selectedLayerIndex, setSelectedLayerIndex ] = useState(iconLayerCount > 1 ? 0 : null)
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

  /*
  const subpanelTooltipText = (messageWhenActive) => {
    if(Number.isInteger(selectedLayerIndex) || iconLayerCount === 1) {
      return messageWhenActive
    } else {
      return __("Select a layer to set these options", "font-awesome")
    }
  }
  */

  const isMultiLayer = iconLayers.length > 1;

  const { getSettings } = select('core/block-editor');

  // Get the editor settings
  const settings = getSettings();

  // Access the color palette
  const colorPalette = settings.colors;

  const optionsControlsDisabled = !(Number.isInteger(selectedLayerIndex) || iconLayerCount === 1)

  //console.log('Theme Color Palette:', colorPalette);
  const extraProps = {}

  if(iconLayerCount > 1) {
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
              <button disabled={!Number.isInteger(selectedLayerIndex)} onClick={() => setSelectedTab(STYLES_TAB)}>
                <FontAwesomeIcon className="fa-icon-modifier-control" icon={faPalette}/>
              </button>
            </Tooltip>
            <Tooltip text={__("Set animation options", "font-awesome")}>
              <button disabled={!Number.isInteger(selectedLayerIndex)} onClick={() => setSelectedTab(ANIMATIONS_TAB)}>
                <FontAwesomeIcon className="fa-icon-modifier-control" icon={faFilm} />
              </button>
            </Tooltip>
            <Tooltip text={__("Set power transform options", "font-awesome")}>
              <button disabled={!Number.isInteger(selectedLayerIndex)} onClick={() => setSelectedTab(POWER_TRANSFORMS_TAB)}>
                <FontAwesomeIcon className="fa-icon-modifier-control" icon={faBolt} />
              </button>
            </Tooltip>
            {
              iconLayerCount === 1 &&
              <button onClick={openIconChooserToAddLayer}>
                <FontAwesomeIcon className="fa-icon-modifier-control" icon={faLayerGroup} />
              </button>
            }
          </div>
        </OptionalTooltip>
      </div>
      {
        (STYLES_TAB == selectedTab) && <div className="fa-icon-modifier-styles">
          styles
        </div>
      }
      {
        ANIMATIONS_TAB == selectedTab && <div className="fa-icon-modifier-animation">
          animation
        </div>
      }
      {
        POWER_TRANSFORMS_TAB == selectedTab && <div className="fa-icon-modifier-power-transforms">
          power transforms
        </div>
      }
      {
        iconLayerCount > 1 && <div className="fa-icon-modifier-layers">
        <div className="layers-section-heading">Layers</div>
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
