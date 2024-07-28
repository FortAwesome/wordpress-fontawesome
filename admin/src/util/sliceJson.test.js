import sliceJson from './sliceJson'

describe('sliceJson', () => {
  test('it works', () => {
    const json = '{"alpha":42}'
    const result = sliceJson(json)

    expect(result).toEqual(
      expect.objectContaining({
        start: 0,
        json,
        trimmed: '',
        parsed: expect.objectContaining(JSON.parse(json))
      })
    )
  })

  test('when invalid content precedes json object', () => {
    const trimmed = 'foobar '
    const json = '{"alpha":42}'
    const content = `${trimmed}${json}`
    const result = sliceJson(content)

    expect(result).toEqual(
      expect.objectContaining({
        start: 7,
        json,
        trimmed,
        parsed: expect.objectContaining(JSON.parse(json))
      })
    )
  })

  test('when invalid content precedes json array', () => {
    const trimmed = 'foobar '
    const json = '[1,2,3]'
    const content = `${trimmed}${json}`
    const result = sliceJson(content)

    expect(result).toEqual(
      expect.objectContaining({
        start: 7,
        json,
        trimmed,
        parsed: expect.objectContaining(JSON.parse(json))
      })
    )
  })

  test('when invalid content with brackets and braces precedes json object', () => {
    const trimmed = 'foobar[42] baz{blue}'
    const json = '{"alpha":42}'
    const content = `${trimmed}${json}`
    const result = sliceJson(content)

    expect(result).toEqual(
      expect.objectContaining({
        start: 20,
        json,
        trimmed,
        parsed: expect.objectContaining(JSON.parse(json))
      })
    )
  })

  test('when invalid content with brackets and braces precedes json array', () => {
    const trimmed = 'foobar[42] baz{blue}'
    const json = '[1,2,3]'
    const content = `${trimmed}${json}`
    const result = sliceJson(content)

    expect(result).toEqual(
      expect.objectContaining({
        start: 20,
        json,
        trimmed,
        parsed: expect.objectContaining(JSON.parse(json))
      })
    )
  })

  test('when invalid content comes before and after valid json', () => {
    const invalid = 'foobar[42] baz{blue}'
    const json = '[1,2,3]'
    const content = `${invalid}${json}${invalid}`
    const result = sliceJson(content)

    expect(result).toBeNull()
  })

  test('when no valid json is found', () => {
    const invalid = 'foobar[42] baz{blue}'
    const result = sliceJson(invalid)

    expect(result).toBeNull()
  })
})
