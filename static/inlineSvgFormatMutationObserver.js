// This fixes the inline SVGs produced by the Format API, but it breaks
// those produced by the fa-icon block. This seems to have to do with
// differences between these two Gutenberg APIs and their rendering implementations.
// So we need to distinguish between these two different kinds of icon svg elements,
// such as with different class name, in order to apply these changes differently.
//
// It can't be loaded in Edit component of the block editor, because it must
// be loaded _inside_ the content iframe.
const REBUILD_SVG_VISITED_ATTR = "data-repaint-visited";
const ICON_FORMAT_CLASS = 'fa-icon-format';
const INLINE_SVG_FORMAT_WRAPPER_TAG_NAME = 'SPAN'

function maybeRebuildElement(el) {
  if (!el.getAttribute(REBUILD_SVG_VISITED_ATTR) || el.getAttribute('viewbox')) {
    el.setAttribute(REBUILD_SVG_VISITED_ATTR, true);
    el.outerHTML = el.outerHTML;
  }
}

function setupObserver() {
  // Select the node that will be observed for mutations
  const targetNode = document.body;

  // Options for the observer (which mutations to observe)
  const config = { attributes: false, childList: true, subtree: true };

  // Callback function to execute when mutations are observed
  const callback = (mutationList, observer) => {
    for (const mutation of mutationList) {
      for (const child of mutation.addedNodes) {
        if (
          child.tagName &&
          (
            (INLINE_SVG_FORMAT_WRAPPER_TAG_NAME.toUpperCase() === child.tagName.toUpperCase() && child.classList.contains(ICON_FORMAT_CLASS))
            ||
            ("SVG" == child.tagName.toUpperCase() && child?.parentElement?.classList?.contains(ICON_FORMAT_CLASS))
          )
        ) {
          maybeRebuildElement(child);
        }
      }
    }
  };

  // Create an observer instance linked to the callback function
  const observer = new MutationObserver(callback);

  // Start observing the target node for configured mutations
  observer.observe(targetNode, config);
}

function initialize() {
  for (
    const faSvg of document.querySelectorAll(
      `.${ICON_FORMAT_CLASS} svg.svg-inline--fa`,
    )
  ) {
    maybeRebuildElement(faSvg);
  }
  setupObserver();
}

const editorContentFrame = document.querySelector(".block-editor-iframe__body");

if (editorContentFrame) {
  if ('complete' === document.readyState) {
    initialize()
  } else {
    document.addEventListener("DOMContentLoaded", initialize);
  }
}
