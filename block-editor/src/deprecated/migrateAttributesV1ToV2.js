export default function (attributes) {
  console.log('MIGRATING FROM', attributes)
  return {...attributes, abstract: []}
}
