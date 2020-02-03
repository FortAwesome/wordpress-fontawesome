import React from 'react'
import ManageFontAwesomeVersionsSection from './ManageFontAwesomeVersionsSection'
import UnregisteredClientsView from './UnregisteredClientsView'
import V3DeprecationWarning from './V3DeprecationWarning'
import ConflictDetectionScannerSection from './ConflictDetectionScannerSection'
import { useSelector } from 'react-redux'

export default function TroubleshootTab() {
  const hasV3DeprecationWarning = useSelector(state => !!state.v3DeprecationWarning)
  const unregisteredClients = useSelector(state => state.unregisteredClients)

  return <div>
    { hasV3DeprecationWarning && <V3DeprecationWarning /> }
    <ConflictDetectionScannerSection />
    <ManageFontAwesomeVersionsSection />
    <UnregisteredClientsView clients={ unregisteredClients }/>
  </div>
}
