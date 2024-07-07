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
  const openEventChangeLayer = createCustomEvent(`fontAwesomeIconChooserOpen-changeLayer-${layerIndex}`, {
    replace: layerIndex
  })
  const openEventAddLayer = createCustomEvent('fontAwesomeIconChooserOpen-addLayer', {
    append: true
  })

  return (
    <div>
      <div>
        <IconChooserModal
          onSubmit={handleSelectChange}
          openEvent={openEventChangeLayer}
        />
        <div>
          <FontAwesomeIcon
            fixedWidth
            icon={iconDefinition}
            {...rest}
          />
          <button style={buttonStyle} onClick={() => document.dispatchEvent(openEventChangeLayer)}>
            change
          </button>
        </div>
      </div>
      <div>
        <IconChooserModal
          onSubmit={prepareHandleSelect({ append: true })}
          openEvent={openEventAddLayer}
        />
        <button style={buttonStyle} onClick={() => document.dispatchEvent(openEventAddLayer)}>
          <FontAwesomeIcon icon={faPlus} />
        </button>
        Add Layer
      </div>
    </div>
  );
}
