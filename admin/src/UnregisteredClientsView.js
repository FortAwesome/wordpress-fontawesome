import React from 'react'
import { useSelector, useDispatch } from 'react-redux'
import { updatePendingBlocklist, updatePendingUnregisteredClientsForDeletion } from './store/actions'
import { blocklistSelector } from './store/reducers'
import styles from './UnregisteredClientsView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faCheckSquare, faThumbsUp } from '@fortawesome/free-solid-svg-icons'
import { faSquare } from '@fortawesome/free-regular-svg-icons'
import get from 'lodash-es/get'
import truncate from 'lodash-es/truncate'
import size from 'lodash-es/size'
import isEqual from 'lodash-es/isEqual'
import sortedUnique from 'lodash-es/sortedUniq'
import difference from 'lodash-es/difference'
import { __ } from '@wordpress/i18n'
import createInterpolateElement from './createInterpolateElement'

function excerpt(content) {
  if (!!content) {
    return truncate(content, { length: 100 })
  } else {
    return null
  }
}

export default function UnregisteredClientsView() {
  const dispatch = useDispatch()
  const unregisteredClients = useSelector((state) => state.unregisteredClients)
  const savedBlocklist = useSelector((state) => blocklistSelector(state))
  const blocklist = useSelector((state) => {
    if (null !== state.blocklistUpdateStatus.pending) {
      return state.blocklistUpdateStatus.pending
    } else {
      return savedBlocklist
    }
  })
  const deleteList = useSelector((state) => state.unregisteredClientsDeletionStatus.pending)
  const detectedUnregisteredClients = size(Object.keys(unregisteredClients)) > 0
  const allDetectedConflictsSelectedForBlocking = isEqual(Object.keys(unregisteredClients).sort(), [...(blocklist || [])].sort())
  const allDetectedConflictsSelectedForRemoval = isEqual(Object.keys(unregisteredClients).sort(), [...(deleteList || [])].sort())
  const allDetectedConflicts = Object.keys(unregisteredClients)

  function isCheckedForBlocking(md5) {
    return !!blocklist.find((x) => x === md5)
  }

  function isCheckedForRemoval(md5) {
    return !!deleteList.find((x) => x === md5)
  }

  function changeCheckForRemoval(md5, allDetectedConflicts) {
    const newDeleteList =
      'all' === md5
        ? allDetectedConflictsSelectedForRemoval
          ? [] // uncheck them all
          : allDetectedConflicts // check them all
        : isCheckedForRemoval(md5)
        ? deleteList.filter((x) => x !== md5)
        : [...deleteList, md5]

    dispatch(updatePendingUnregisteredClientsForDeletion(newDeleteList))
  }

  function changeCheckForBlocking(md5, allDetectedConflicts) {
    const newBlocklist =
      'all' === md5
        ? allDetectedConflictsSelectedForBlocking
          ? [] // uncheck them all
          : allDetectedConflicts // check them all
        : isCheckedForBlocking(md5)
        ? blocklist.filter((x) => x !== md5)
        : [...blocklist, md5]

    const orig = sortedUnique(savedBlocklist)
    const updated = sortedUnique(newBlocklist)

    if (orig.length === updated.length && 0 === size(difference(orig, updated)) && 0 === size(difference(updated, orig))) {
      dispatch(updatePendingBlocklist(null))
    } else {
      dispatch(updatePendingBlocklist(newBlocklist))
    }
  }

  return (
    <div className={classnames(styles['unregistered-clients'], { [styles['none-detected']]: !detectedUnregisteredClients })}>
      <h3 className={sharedStyles['section-title']}>{__('Other themes or plugins', 'font-awesome')}</h3>
      {detectedUnregisteredClients ? (
        <div>
          <p className={sharedStyles['explanation']}>
            {__(
              "Below is the list of other versions of Font Awesome from active plugins or themes that are loading on your site. Check off any that you would like to block from loading. Normally this just blocks the conflicting version of Font Awesome and doesn't affect the other functions of the plugin, but you should verify your site works as expected. If you think you've fixed a found conflict, you can clear it from the table.",
              'font-awesome'
            )}
          </p>
          <table className={classnames('widefat', 'striped')}>
            <thead>
              <tr className={sharedStyles['table-header']}>
                <th>
                  <div className={styles['column-label']}>{__('Block', 'font-awesome')}</div>
                  {size(allDetectedConflicts) > 1 && (
                    <div className={styles['block-all-container']}>
                      <input
                        id="block_all_detected_conflicts"
                        name="block_all_detected_conflicts"
                        type="checkbox"
                        value="all"
                        checked={allDetectedConflictsSelectedForBlocking}
                        onChange={() => changeCheckForBlocking('all', allDetectedConflicts)}
                        className={classnames(sharedStyles['sr-only'], sharedStyles['input-checkbox-custom'])}
                      />
                      <label
                        htmlFor="block_all_detected_conflicts"
                        className={styles['checkbox-label']}
                      >
                        <span className={sharedStyles['relative']}>
                          <FontAwesomeIcon
                            icon={faCheckSquare}
                            className={sharedStyles['checked-icon']}
                            size="lg"
                            fixedWidth
                          />
                          <FontAwesomeIcon
                            icon={faSquare}
                            className={sharedStyles['unchecked-icon']}
                            size="lg"
                            fixedWidth
                          />
                        </span>
                        {__('All', 'font-awesome')}
                      </label>
                    </div>
                  )}
                </th>
                <th>
                  <span className={styles['column-label']}>{__('Type', 'font-awesome')}</span>
                </th>
                <th>
                  <span className={styles['column-label']}>{__('URL', 'font-awesome')}</span>
                </th>
                <th>
                  <div className={styles['column-label']}>{__('Clear', 'font-awesome')}</div>
                  {size(allDetectedConflicts) > 1 && (
                    <div className={styles['remove-all-container']}>
                      <input
                        id="remove_all_detected_conflicts"
                        name="remove_all_detected_conflicts"
                        type="checkbox"
                        value="all"
                        checked={allDetectedConflictsSelectedForRemoval}
                        onChange={() => changeCheckForRemoval('all', allDetectedConflicts)}
                        className={classnames(sharedStyles['sr-only'], sharedStyles['input-checkbox-custom'])}
                      />
                      <label
                        htmlFor="remove_all_detected_conflicts"
                        className={styles['checkbox-label']}
                      >
                        <span className={sharedStyles['relative']}>
                          <FontAwesomeIcon
                            icon={faCheckSquare}
                            className={sharedStyles['checked-icon']}
                            size="lg"
                            fixedWidth
                          />
                          <FontAwesomeIcon
                            icon={faSquare}
                            className={sharedStyles['unchecked-icon']}
                            size="lg"
                            fixedWidth
                          />
                        </span>
                        {__('All', 'font-awesome')}
                      </label>
                    </div>
                  )}
                </th>
              </tr>
            </thead>
            <tbody>
              {allDetectedConflicts.map((md5) => (
                <tr key={md5}>
                  <td>
                    <input
                      id={`block_${md5}`}
                      name={`block_${md5}`}
                      type="checkbox"
                      value={md5}
                      checked={isCheckedForBlocking(md5)}
                      onChange={() => changeCheckForBlocking(md5)}
                      className={classnames(sharedStyles['sr-only'], sharedStyles['input-checkbox-custom'])}
                    />
                    <label
                      htmlFor={`block_${md5}`}
                      className={styles['checkbox-label']}
                    >
                      <span className={sharedStyles['relative']}>
                        <FontAwesomeIcon
                          icon={faCheckSquare}
                          className={sharedStyles['checked-icon']}
                          size="lg"
                          fixedWidth
                        />
                        <FontAwesomeIcon
                          icon={faSquare}
                          className={sharedStyles['unchecked-icon']}
                          size="lg"
                          fixedWidth
                        />
                      </span>
                    </label>
                  </td>
                  <td>{get(unregisteredClients[md5], 'tagName', 'unknown').toLowerCase()}</td>
                  <td>
                    {unregisteredClients[md5].src ||
                      unregisteredClients[md5].href ||
                      createInterpolateElement(__('<em>in page source. </em><excerpt/>', 'font-awesome'), {
                        em: <em />,
                        excerpt: ((content) =>
                          content ? (
                            <>
                              File starts with: <code>{content}</code>
                            </>
                          ) : (
                            ''
                          ))(excerpt(get(unregisteredClients[md5], 'innerText')))
                      })}
                  </td>
                  <td>
                    <input
                      id={`remove_${md5}`}
                      name={`remove_${md5}`}
                      type="checkbox"
                      value={md5}
                      checked={isCheckedForRemoval(md5)}
                      onChange={() => changeCheckForRemoval(md5)}
                      className={classnames(sharedStyles['sr-only'], sharedStyles['input-checkbox-custom'])}
                    />
                    <label
                      htmlFor={`remove_${md5}`}
                      className={styles['checkbox-label']}
                    >
                      <span className={sharedStyles['relative']}>
                        <FontAwesomeIcon
                          icon={faCheckSquare}
                          className={sharedStyles['checked-icon']}
                          size="lg"
                          fixedWidth
                        />
                        <FontAwesomeIcon
                          icon={faSquare}
                          className={sharedStyles['unchecked-icon']}
                          size="lg"
                          fixedWidth
                        />
                      </span>
                    </label>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      ) : (
        <div className={classnames(sharedStyles['explanation'], sharedStyles['flex'], sharedStyles['flex-row'])}>
          <div>
            <FontAwesomeIcon
              icon={faThumbsUp}
              size="lg"
            />
          </div>
          <div className={sharedStyles['space-left']}>{__("We haven't detected any plugins or themes trying to load Font Awesome.", 'font-awesome')}</div>
        </div>
      )}
    </div>
  )
}
