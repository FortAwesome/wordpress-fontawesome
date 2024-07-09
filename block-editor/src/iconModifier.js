import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faBolt, faLayerGroup, faPlus, faPalette, faFilm } from "@fortawesome/free-solid-svg-icons";
import createCustomEvent from './createCustomEvent';
import { renderIcon, computeIconLayerCount } from './rendering';
import { select } from '@wordpress/data';
import { useState } from '@wordpress/element';
import classnames from 'classnames';

const NO_TAB = 0;
const STYLES_TAB = 1;
const ANIMATIONS_TAB = 2;
const LAYERS_TAB = 3;
const POWER_TRANSFORMS_TAB = 4;

const openIconChooserForAddLayerEvent = createCustomEvent()

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

  const isMultiLayer = iconLayers.length > 1;

  const { getSettings } = select('core/block-editor');

  // Get the editor settings
  const settings = getSettings();

  // Access the color palette
  const colorPalette = settings.colors;

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
        <div className="fa-icon-modifier-preview-controls">
          <button onClick={() => setSelectedTab(STYLES_TAB)}>
            <FontAwesomeIcon className="fa-icon-modifier-control" icon={faPalette}/>
          </button>
          <button onClick={() => setSelectedTab(ANIMATIONS_TAB)}>
            <FontAwesomeIcon className="fa-icon-modifier-control" icon={faFilm} />
          </button>
          <button onClick={() => setSelectedTab(POWER_TRANSFORMS_TAB)}>
            <FontAwesomeIcon className="fa-icon-modifier-control" icon={faBolt} />
          </button>
          {
            iconLayerCount === 1 &&
            <button onClick={openIconChooserToAddLayer}>
              <FontAwesomeIcon className="fa-icon-modifier-control" icon={faLayerGroup} />
            </button>
          }
        </div>
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
        layers
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
