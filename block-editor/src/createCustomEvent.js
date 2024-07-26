import generateRandomString from './generateRandomString'

export default function (name) {
  return new Event(name || `fontAwesomeIconChooser-${generateRandomString(16)}`, {
    bubbles: true,
    cancelable: false
  })
}
