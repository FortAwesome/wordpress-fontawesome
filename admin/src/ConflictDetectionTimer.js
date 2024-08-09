import React, { useState, useEffect } from 'react'
import PropTypes from 'prop-types'
import { useSelector, useDispatch } from 'react-redux'
import sharedStyles from './App.module.css'
import { padStart, dropWhile } from 'lodash'
import { __, sprintf } from '@wordpress/i18n'

const SECONDS_PER_DAY = 60 * 60 * 24
const SECONDS_PER_HOUR = 60 * 60
const SECONDS_PER_MINUTE = 60

export function timerString(durationSeconds) {
  const days = Math.floor(durationSeconds / SECONDS_PER_DAY)
  const hours = Math.floor((durationSeconds - days * SECONDS_PER_DAY) / SECONDS_PER_HOUR)
  const minutes = Math.floor((durationSeconds - (days * SECONDS_PER_DAY + hours * SECONDS_PER_HOUR)) / SECONDS_PER_MINUTE)
  const seconds = durationSeconds - (days * SECONDS_PER_DAY + hours * SECONDS_PER_HOUR + minutes * SECONDS_PER_MINUTE)

  return dropWhile(
    [days, hours, minutes, seconds].reduce((acc, unit, index) => {
      if (0 === index && unit !== 0) {
        acc.push(unit.toString())
      } else {
        acc.push(padStart(unit.toString(), 2, '0'))
      }
      return acc
    }, []),
    (part) => part.match(/^[0]+$/)
  ).join(':')
}

function secondsRemaining(endTime) {
  const now = Math.floor(new Date() / 1000)
  const remaining = endTime - now

  return remaining < 0 ? 0 : remaining
}

export default function ConflictDetectionTimer({ addDescription, children }) {
  const detectConflictsUntil = useSelector((state) => state.detectConflictsUntil)
  const [timeRemaining, setTimer] = useState(secondsRemaining(detectConflictsUntil))
  const dispatch = useDispatch()

  useEffect(() => {
    let timeoutId = null

    if (secondsRemaining(detectConflictsUntil) > 0) {
      timeoutId = setTimeout(() => setTimer(secondsRemaining(detectConflictsUntil)), 1000)
    } else {
      setTimer(timerString(0))
      dispatch({
        type: 'CONFLICT_DETECTION_TIMER_EXPIRED'
      })
    }

    return () => timeoutId && clearTimeout(timeoutId)
  }, [detectConflictsUntil, timeRemaining, dispatch])

  return timeRemaining <= 0 ? null : (
    <span className={sharedStyles['conflict-detection-timer']}>
      {timerString(timeRemaining)}
      {!!addDescription &&
        (timeRemaining > 60
          ? /* translators: 1: space */
            sprintf(__('%1$sminutes left to browse your site for trouble', 'font-awesome'), ' ')
          : /* translators: 1: space */
            sprintf(__('%1$sseconds left to browse your site for trouble', 'font-awesome'), ' '))}
      {children}
    </span>
  )
}

ConflictDetectionTimer.propTypes = {
  addDescription: PropTypes.bool
}
