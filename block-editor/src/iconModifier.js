import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import buttonStyle from "./buttonStyle";
import createCustomEvent from './createCustomEvent'

export default function (
  {
    attributes,
    layerIndex,
    setAttributes,
    IconChooserModal,
    prepareHandleSelect
  },
) {
  const iconLayers = attributes.iconLayers || [];
  const layer = iconLayers[layerIndex];
  const { iconDefinition, ...rest } = layer;

  const handleSelectChange = prepareHandleSelect({ replace: layerIndex });
  const openIconChooserForChangeEvent = createCustomEvent()
  const openIconChooserForAddLayerEvent = createCustomEvent()

  return (
    <div>
      <div>
        <IconChooserModal
          onSubmit={handleSelectChange}
          openEvent={openIconChooserForChangeEvent}
        />
        <div>
          <FontAwesomeIcon
            fixedWidth
            icon={iconDefinition}
            {...rest}
          />
          <button style={buttonStyle} onClick={() => document.dispatchEvent(openIconChooserForChangeEvent)}>
            change
          </button>
        </div>
      </div>
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
    </div>
  );
}
