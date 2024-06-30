import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus } from "@fortawesome/free-solid-svg-icons";

const buttonStyle = {
  border: "none",
  background: "unset",
  cursor: "pointer",
  textDecoration: "underline",
};

function IconLayer(
  {
    handleSelect,
    layer,
    layerIndex,
    IconChooserModal,
    openIconChooser,
    canMoveUp,
    canMoveDown,
    moveUp,
    moveDown,
  },
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
      </div>
    </>
  );
}

export default function (
  {
    attributes,
    setAttributes,
    IconChooserModal,
    prepareHandleSelect,
    openIconChooser,
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
            openIconChooser={openIconChooser}
            canMoveUp={isMultiLayer && index > 0}
            canMoveDown={isMultiLayer && index <= (iconLayers.length - 2)}
            moveUp={moveUp}
            moveDown={moveDown}
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
