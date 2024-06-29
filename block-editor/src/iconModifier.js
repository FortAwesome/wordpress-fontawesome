import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus } from "@fortawesome/free-solid-svg-icons";

const buttonStyle = { border: "none", background: "unset" };

function IconLayer(
  { handleSelect, layer, layerIndex, IconChooserModal, openIconChooser },
) {
  const { iconDefinition, ...rest } = layer;

  return (
    <>
      <IconChooserModal
        onSubmit={handleSelect}
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
    </>
  );
}

export default function (
  { attributes, IconChooserModal, prepareHandleSelect, openIconChooser },
) {
  const iconLayers = attributes.iconLayers || [];

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
            openIconChooser={openIconChooser}
          />
        ))}
        <div>
          <IconChooserModal
            onSubmit={prepareHandleSelect({ append: true })}
          />
          <button style={buttonStyle} onClick={openIconChooser}>
            <FontAwesomeIcon icon={faPlus} />
          </button>
          Add Layer
        </div>
      </>
    </div>
  );
}
