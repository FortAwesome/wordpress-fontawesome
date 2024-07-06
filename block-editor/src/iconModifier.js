import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus } from "@fortawesome/free-solid-svg-icons";
import buttonStyle from "./buttonStyle";

export default function (
  {
    attributes,
    setAttributes,
    IconChooserModal,
    prepareHandleSelect,
    openIconChooser,
  },
) {
  //const iconLayers = attributes.iconLayers || [];

  return (
    <div>
      single icon
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
