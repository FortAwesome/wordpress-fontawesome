import { justifyCenter, justifyLeft, justifyRight } from '@wordpress/icons'
import { faBrush } from '@fortawesome/free-solid-svg-icons'
import { __ } from '@wordpress/i18n'
import { BlockControls, useBlockProps } from '@wordpress/block-editor'
import { Fragment, useState } from '@wordpress/element'
import { Button, ToolbarDropdownMenu, Modal, Placeholder, ToolbarButton, ToolbarGroup } from '@wordpress/components'
import { get } from 'lodash'
import { GLOBAL_KEY } from '../../admin/src/constants'
import { iconDefinitionFromIconChooserSelectionEvent } from './iconDefinitions'
import { wpIconFromFaIconDefinition } from './icons'
import { computeIconLayerCount, prepareParamsForUseBlock, renderIcon } from './rendering'
import IconModifier from './iconModifier'
import createCustomEvent from './createCustomEvent'

const { IconChooserModal } = get(window, [GLOBAL_KEY, 'iconChooser'], {})
const modifyToolbarIcon = wpIconFromFaIconDefinition(faBrush)
const defaultStylingParams = {
  spin: false,
  transform: null
}

export function Edit(props) {
  const { attributes, setAttributes } = props

  const iconChooserOpenEvent = createCustomEvent()

  const [justificationDropdownMenuIcon, setJustificationDropdownMenuIcon] = useState(justifyCenter)

  const setJustification = (justification) => {
    let menuIcon
    if ('left' === justification) {
      menuIcon = justifyLeft
    } else if ('right' === justification) {
      menuIcon = justifyRight
    } else {
      menuIcon = justifyCenter
    }

    setJustificationDropdownMenuIcon(menuIcon)
    setAttributes({ ...attributes, justification })
  }

  const prepareHandleSelect = (layerParams) => (event) => {
    const iconLayers = attributes?.iconLayers || []

    const iconDefinition = iconDefinitionFromIconChooserSelectionEvent(event)

    if (!iconDefinition) return

    const { replace, append } = layerParams

    const newIconLayers = [...iconLayers]

    if (append) {
      const layer = {
        iconDefinition,
        ...defaultStylingParams
      }

      newIconLayers.push(layer)
    } else if (Number.isInteger(replace) && replace < iconLayers.length) {
      const oldLayer = iconLayers[replace] || {}
      const newLayer = {...oldLayer, iconDefinition }
      newIconLayers[replace] = newLayer
    }

    setAttributes({ iconLayers: newIconLayers })
  }

  const iconLayerCount = computeIconLayerCount(attributes)

  const extraProps = {
    wrapperProps: useBlockProps(prepareParamsForUseBlock(attributes))
  }

  const [isEditModalOpen, setIsEditModalOpen] = useState(false)

  return iconLayerCount > 0 ? (
    <Fragment>
      <BlockControls>
        <ToolbarGroup>
          <ToolbarDropdownMenu
            controls={[
              {
                icon: justifyLeft,
                onClick: () => setJustification('left'),
                title: __('Justify Icon Left', 'font-awesome')
              },
              {
                icon: justifyCenter,
                onClick: () => setJustification('center'),
                title: __('Justify Icon Center', 'font-awesome')
              },
              {
                icon: justifyRight,
                onClick: () => setJustification('right'),
                title: __('Justify Icon Right', 'font-awesome')
              }
            ]}
            icon={justificationDropdownMenuIcon}
            label={__('Change Icon Justification', 'font-awesome')}
          />
        </ToolbarGroup>
        <ToolbarGroup>
          <ToolbarButton
            showTooltip
            onClick={() => setIsEditModalOpen(!isEditModalOpen)}
            aria-haspopup="true"
            aria-expanded={isEditModalOpen}
            label={__('Add Icon Styling')}
            icon={modifyToolbarIcon}
          />
        </ToolbarGroup>

        {isEditModalOpen && (
          <Modal
            title={__('Add Icon Styling', 'font-awesome')}
            onRequestClose={() => setIsEditModalOpen(false)}
            className="fawp-icon-styling-modal"
          >
            <IconModifier
              attributes={attributes}
              setAttributes={setAttributes}
              IconChooserModal={IconChooserModal}
              handleSelect={prepareHandleSelect({ replace: 0 })}
              iconChooserOpenEvent={iconChooserOpenEvent}
            />
          </Modal>
        )}
      </BlockControls>
      {renderIcon(attributes, { extraProps })}
    </Fragment>
  ) : (
    <Fragment>
      <Placeholder
        icon={
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
          >
            <path d="M91.7 96C106.3 86.8 116 70.5 116 52C116 23.3 92.7 0 64 0S12 23.3 12 52c0 16.7 7.8 31.5 20 41l0 3 0 352 0 64 64 0 0-64 373.6 0c14.6 0 26.4-11.8 26.4-26.4c0-3.7-.8-7.3-2.3-10.7L432 272l61.7-138.9c1.5-3.4 2.3-7 2.3-10.7c0-14.6-11.8-26.4-26.4-26.4L91.7 96z" />
          </svg>
        }
        label={__('Add a Font Awesome Icon', 'font-awesome')}
        instructions={__('Add an icon as a block element, and add styling to make it extra awesome!', 'font-awesome')}
      >
        <IconChooserModal
          onSubmit={prepareHandleSelect({ append: true })}
          openEvent={iconChooserOpenEvent}
        />
        <Button
          variant="secondary"
          onClick={() => document.dispatchEvent(iconChooserOpenEvent)}
        >
          {__('Choose Icon', 'font-awesome')}
        </Button>
      </Placeholder>
    </Fragment>
  )
}
