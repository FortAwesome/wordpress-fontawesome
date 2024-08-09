import React, { useState } from "react";
import { Modal } from "@wordpress/components";
import { FaIconChooser } from "@fortawesome/fa-icon-chooser-react";
import { __ } from "@wordpress/i18n";
import { GLOBAL_KEY } from "../../admin/src/constants";
import { get } from "lodash";
const createInterpolateElement = get(window, [
  GLOBAL_KEY,
  "createInterpolateElement",
]);

export default function (params) {
  const { kitToken, version, pro, handleQuery, getUrlText, settingsPageUrl } =
    params;

  return (props) => {
    const { onSubmit, openEvent } = props;
    const [isOpen, setOpen] = useState(false);

    document.addEventListener(openEvent.type, () => setOpen(true));

    const closeModal = () => setOpen(false);

    const submitAndCloseModal = (result) => {
      if ("function" === typeof onSubmit) {
        onSubmit(result);
      }
      closeModal();
    };

    const isProCdn = !!pro && !kitToken;

    return (
      <>
        {isOpen && (
          <Modal title="Add a Font Awesome Icon" onRequestClose={closeModal}>
            {isProCdn && (
              <div
                style={{
                  margin: "1em",
                  backgroundColor: "#FFD200",
                  padding: "1em",
                  borderRadius: ".5em",
                  fontSize: "15px",
                }}
              >
                {__(
                  "Looking for Pro icons and styles? You’ll need to use a kit. ",
                  "font-awesome",
                )}

                <a href={settingsPageUrl}>
                  {__("Go to Font Awesome Plugin Settings", "font-awesome")}
                </a>
              </div>
            )}
            <FaIconChooser
              version={version}
              kitToken={kitToken}
              handleQuery={handleQuery}
              getUrlText={getUrlText}
              onFinish={(result) => submitAndCloseModal(result)}
              searchInputPlaceholder={__(
                "Find icons by name, category, or keyword",
                "font-awesome",
              )}
            >
              <span slot="fatal-error-heading">
                {__("Well, this is awkward...", "font-awesome")}
              </span>
              <span slot="fatal-error-detail">
                {__(
                  "Something has gone horribly wrong. Check the console for additional error information.",
                  "font-awesome",
                )}
              </span>
              <span slot="start-view-heading">
                {__(
                  "Font Awesome is the web's most popular icon set, with tons of icons in a variety of styles.",
                  "font-awesome",
                )}
              </span>
              <span slot="start-view-detail">
                {createInterpolateElement(
                  __(
                    "Not sure where to start? Here are some favorites, or try a search for <strong>spinners</strong>, <strong>shopping</strong>, <strong>food</strong>, or <strong>whatever you're looking for</strong>.",
                    "font-awesome",
                  ),
                  {
                    strong: <strong />,
                  },
                )}
              </span>
              <span slot="search-field-label-free">
                {__(
                  "Search Font Awesome Free Icons in Version",
                  "font-awesome",
                )}
              </span>
              <span slot="search-field-label-pro">
                {__("Search Font Awesome Pro Icons in Version", "font-awesome")}
              </span>
              <span slot="searching-free">
                {__(
                  "You're searching Font Awesome Free icons in version",
                  "font-awesome",
                )}
              </span>
              <span slot="searching-pro">
                {__(
                  "You're searching Font Awesome Pro icons in version",
                  "font-awesome",
                )}
              </span>
              <span slot="kit-has-no-uploaded-icons">
                {__("This kit contains no uploaded icons.", "font-awesome")}
              </span>
              <span slot="no-search-results-heading">
                {__(
                  "Sorry, we couldn't find anything for that.",
                  "font-awesome",
                )}
              </span>
              <span slot="no-search-results-detail">
                {__("You might try a different search...", "font-awesome")}
              </span>
              <span slot="suggest-icon-upload">
                {createInterpolateElement(
                  __(
                    "Or <a>upload your own icon</a> to a Pro kit!",
                    "font-awesome",
                  ),
                  {
                    // eslint-disable-next-line jsx-a11y/anchor-has-content
                    a: (
                      <a
                        target="_blank"
                        rel="noopener noreferrer"
                        href="https://fontawesome.com/v5.15/how-to-use/on-the-web/using-kits/uploading-icons"
                      />
                    ),
                  },
                )}
              </span>
              <span slot="get-fontawesome-pro">
                {createInterpolateElement(
                  __(
                    "Or <a>use Font Awesome Pro</a> for more icons and styles!",
                    "font-awesome",
                  ),
                  {
                    // eslint-disable-next-line jsx-a11y/anchor-has-content
                    a: (
                      <a
                        target="_blank"
                        rel="noopener noreferrer"
                        href="https://fontawesome.com/"
                      />
                    ),
                  },
                )}
              </span>
              <span slot="initial-loading-view-heading">
                {__("Fetching icons", "font-awesome")}
              </span>
              <span slot="initial-loading-view-detail">
                {__("When this thing gets up to 88 mph...", "font-awesome")}
              </span>
            </FaIconChooser>
          </Modal>
        )}
      </>
    );
  };
}
