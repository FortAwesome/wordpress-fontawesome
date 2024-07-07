const createCustomEvent = (name, details = {}) => {
  return new Event(name, {
    "bubbles": true,
    "cancelable": false,
    ...details
  });
}

export default createCustomEvent
