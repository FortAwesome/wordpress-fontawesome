import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import buttonStyle from "./buttonStyle";
import createCustomEvent from './createCustomEvent';

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
  },
) {
  const { iconDefinition, ...rest } = layer;
  const openEvent = createCustomEvent()

  return (
    <>
      <IconChooserModal
        onSubmit={handleSelect}
        openEvent={openEvent}
      />
      <div>
        <FontAwesomeIcon
          fixedWidth
          icon={iconDefinition}
          {...rest}
        />
        <button style={buttonStyle} onClick={() => document.dispatchEvent(openEvent)}>
          change
        </button>
        {canMoveUp &&
          (
            <button style={buttonStyle} onClick={() => moveUp(layerIndex)}>
              up
            </button>
          )}
        {canMoveDown &&
          (
            <button style={buttonStyle} onClick={() => moveDown(layerIndex)}>
              down
            </button>
          )}
        <button style={buttonStyle} onClick={() => remove(layerIndex)}>
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

  const isMultiLayer = iconLayers.length > 1;

  return (
    <div>
      <>
        {iconLayers.map((layer, index) => (
          <IconLayer
            key={index}
            layerIndex={index}
            layer={layer}
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
          <IconChooserModal
            onSubmit={prepareHandleSelect({ append: true })}
            openEvent={openIconChooserForAddLayerEvent}
          />
          <button style={buttonStyle} onClick={() => document.dispatchEvent(openIconChooserForAddLayerEvent)}>
            <FontAwesomeIcon icon={faPlus} />
          </button>
          Add Layer
        </div>
      </>
    </div>
  );
}
