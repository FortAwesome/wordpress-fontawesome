const REBUILD_SVG_VISITED_ATTR = "data-repaint-visited";

function maybeRebuildElement(el) {
  if (!el.getAttribute(REBUILD_SVG_VISITED_ATTR)) {
    el.setAttribute(REBUILD_SVG_VISITED_ATTR, true);
    el.outerHTML = el.outerHTML;
  }
}

function setupObserver() {
  // Select the node that will be observed for mutations
  const targetNode = document.body;

  // Options for the observer (which mutations to observe)
  const config = { attributes: true, childList: true, subtree: true };

  // Callback function to execute when mutations are observed
  const callback = (mutationList, observer) => {
    for (const mutation of mutationList) {
      for (const child of mutation.addedNodes) {
        if (
          child.tagName && "SVG" === child.tagName.toUpperCase()
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

const editorContentFrame = document.querySelector(".block-editor-iframe__body");

if (editorContentFrame) {
  document.addEventListener("DOMContentLoaded", () => {
    for (const faSvg of document.querySelectorAll("svg.svg-inline--fa")) {
      maybeRebuildElement(faSvg);
    }
    setupObserver();
  });
}
