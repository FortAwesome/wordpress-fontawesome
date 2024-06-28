export function filterSelectionEvent(selectionEvent) {
  if (!selectionEvent.detail) {
    console.error(
      __(
        "Font Awesome Icon: invalid icon chooser selection object.",
        "font-awesome",
      ),
    );
    return;
  }

  const { iconName, prefix, icon } = selectionEvent.detail;

  if ("string" !== typeof iconName) {
    console.error(
      __(
        "Font Awesome Icon: missing iconName in icon chooser selection.",
        "font-awesome",
      ),
    );
    return;
  }

  if ("string" !== typeof prefix) {
    console.error(
      __(
        "Font Awesome Icon: missing style prefix in icon chooser selection.",
        "font-awesome",
      ),
    );
    return;
  }

  if (!Array.isArray(icon) || icon.length < 4) {
    console.error(
      __(
        "Font Awesome Icon: invalid icon data in icon chooser selection.",
        "font-awesome",
      ),
    );
    return;
  }

  const width = icon[0];

  if (!Number.isInteger(width)) {
    console.error(
      __(
        "Font Awesome Icon: invalid width for chooser selection.",
        "font-awesome",
      ),
    );
    return;
  }

  const height = icon[1];

  if (!Number.isInteger(height)) {
    console.error(
      __(
        "Font Awesome Icon: invalid height for chooser selection.",
        "font-awesome",
      ),
    );
    return;
  }

  const rawPathData = icon[4];
  let pathData;

  if ("string" === typeof rawPathData) {
    // monotone icon, so the primary path is the only path.
    pathData = [rawPathData];
  } else if (Array.isArray(rawPathData)) {
    pathData = rawPathData;
  } else {
    console.error(
      __(
        "Font Awesome Icon: invalid icon path data for chooser selection.",
        "font-awesome",
      ),
    );
    return;
  }

  return {
    iconName,
    prefix,
    width,
    height,
    pathData,
  };
}

export function isValid({ iconName, prefix, width, height, pathData }) {
  return !!iconName &&
    !!prefix &&
    Number.isInteger(width) &&
    Number.isInteger(height) &&
    Array.isArray(pathData) &&
    pathData.length > 0;
}