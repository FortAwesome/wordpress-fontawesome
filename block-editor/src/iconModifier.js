import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import buttonStyle from "./buttonStyle";

export default function (
  {
    attributes,
    layerIndex,
    setAttributes,
    IconChooserModal,
    prepareHandleSelect,
    openIconChooser,
  },
) {
  const iconLayers = attributes.iconLayers || [];
  const layer = iconLayers[layerIndex];
  const { iconDefinition, ...rest } = layer;

  const handleSelectChange = prepareHandleSelect({ replace: layerIndex });

  return (
    <div>
      <div>
        <IconChooserModal
          onSubmit={handleSelectChange}
        />
        <div>
          <FontAwesomeIcon
            fixedWidth
            icon={iconDefinition}
            {...rest}
          />
          <button style={buttonStyle} onClick={openIconChooser}>
            change
          </button>
        </div>
      </div>
      <div>
        <IconChooserModal
          onSubmit={prepareHandleSelect({ append: true })}
        />
        <button style={buttonStyle} onClick={openIconChooser}>
          <FontAwesomeIcon icon={faPlus} />
        </button>
        Add Layer
      </div>
    </div>
  );
}
