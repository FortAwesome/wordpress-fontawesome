import React, { useState } from 'react'
import { useSelector } from 'react-redux'
import { padStart, dropWhile } from 'lodash'

const SECONDS_PER_DAY = 60 * 60 * 24
const SECONDS_PER_HOUR = 60 * 60
const SECONDS_PER_MINUTE = 60

export function timerString(durationSeconds) {
  const days = Math.floor(durationSeconds / SECONDS_PER_DAY)
  const hours = Math.floor((durationSeconds - (days * SECONDS_PER_DAY)) / SECONDS_PER_HOUR)
  const minutes = Math.floor((durationSeconds - (days * SECONDS_PER_DAY + hours * SECONDS_PER_HOUR)) / SECONDS_PER_MINUTE)
  const seconds = durationSeconds - (days * SECONDS_PER_DAY + hours * SECONDS_PER_HOUR + minutes * SECONDS_PER_MINUTE)

  return dropWhile(
    [days, hours, minutes, seconds].reduce((acc, unit, index) => {
      if(0 === index && unit !== 0){
        acc.push(unit.toString())
      } else {
        acc.push(padStart(unit.toString(), 2, '0'))
      }
      return acc
    }, []),
    part => part.match(/^[0]+$/)
  ).join(':')
}

function secondsRemaining(endTime) {
  const now = Math.floor((new Date()).valueOf() / 1000)
  const remaining = endTime - now

  return remaining < 0 ? 0 : remaining
}

export default function ConflictDetectionTimer() {
  const detectConflictsUntil = useSelector(state => state.detectConflictsUntil)
  const [timeRemaining, setTimer] = useState(timerString(secondsRemaining(detectConflictsUntil)))

  function runTimer() {
    setTimeout(
      () => {
        const remaining = secondsRemaining(detectConflictsUntil)
        setTimer(timerString(remaining))

        if( remaining > 0 ) {
          runTimer()
        }
      },
      1000
    )
  }

  return <span className="conflict-detection-timer">{ timeRemaining }</span>
}
