import { ORIGINAL_SIZE } from './constants'
import { useState } from '@wordpress/element'
import { RangeControl, SelectControl } from '@wordpress/components'

const MAX_EM = 24
const MAX_PX = 120
const INITIAL_POSITION_EM = 1
const INITIAL_POSITION_PX = ORIGINAL_SIZE
const VALID_UNITS = ['px', 'em']
const STEP_EM = 0.125
const STEP_PX = 1

export default () => {
  const [units, setUnits] = useState('em')
  const [value, setValue] = useState(INITIAL_POSITION_EM)
  const [max, setMax] = useState(MAX_EM)
  const [initialPosition, setInitialPosition] = useState(INITIAL_POSITION_EM)
  const [step, setStep] = useState(STEP_EM)

  const unitsOptions = () => {
    return VALID_UNITS.map(u => ({label: u, value: u}))
  }

  const switchUnits = (newUnits) => {
    if ('px' === newUnits) {
      if ('em' === units) {
        setValue(ORIGINAL_SIZE * value)
      }

      setMax(MAX_PX)
      setStep(STEP_PX)
      setInitialPosition(INITIAL_POSITION_PX)
    }

    if ('em' === newUnits) {
      if ('px' === units) {
        setValue(value / ORIGINAL_SIZE)
      }

      setMax(MAX_EM)
      setStep(STEP_EM)
      setInitialPosition(INITIAL_POSITION_EM)
    }

    setUnits(newUnits)
  }

  return <div className="fawp-icon-sizer"><RangeControl
    initialPosition={initialPosition}
    min={0}
    max={max}
    value={value}
    allowReset={true}
    step={step}
    onChange={setValue}
  /><SelectControl
      options={unitsOptions()}
      size="small"
      value={units}
      variant="minimal"
      onChange={switchUnits}
    /></div>
}
