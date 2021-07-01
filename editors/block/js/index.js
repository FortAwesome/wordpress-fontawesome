import { IconChooserModal, MODAL_OPEN_EVENT } from '../../shared'

( function( wp ) {

	const {
    Fragment,
    Component
  } = wp.element

  const {
    SVG,
    Path,
    Modal
  } = wp.components

	const __ = wp.i18n.__
  const { insert, registerFormatType } = window.wp.richText
  const { RichTextToolbarButton } = window.wp.blockEditor

  const name = 'font-awesome/icon'
  const title = __('Font Awesome Icon')

  registerFormatType(name, {
    name,
    title: __( 'Font Awesome Icon' ),
    keywords: [ __( 'icon' ), __( 'font awesome' ) ],
    tagName: 'i',
    className: null,
    // if object is true, then the HTML rendered for this type will lack a closing tag.
    object: false,
    edit: class FontAwesomeIconEdit extends Component {
      constructor(props) {
        super( ...arguments )

        this.handleFormatButtonClick = this.handleFormatButtonClick.bind(this)
        this.handleSelect = this.handleSelect.bind(this)
      }

      handleFormatButtonClick() {
        document.dispatchEvent(MODAL_OPEN_EVENT)
      }

      handleSelect(event){
        const { value, onChange } = this.props
        // TODO: this would indicate an invalid event. Do we want some error handling here?
        if(!event.detail) return

        const {prefix, iconName} = event.detail

        onChange( insert( value, `[icon prefix="${prefix}" name="${iconName}"]` ) )
        /*
        const formatToInsert = {
          type: name,
          attributes: {
            'data-prefix': prefix,
            'data-icon-name': iconName,
            class: `${prefix} fa-${iconName}`
          }
        }

        const newValue = insertObject( value,  formatToInsert)
        onChange( newValue )
        */
      }

      render() {
        return (
          <Fragment>
            <RichTextToolbarButton
              icon={
                <SVG
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 448 512"
                  className="svg-inline--fa fa-font-awesome fa-w-14">
                  <Path
                    fill="currentColor"
                    d="M397.8 32H50.2C22.7 32 0 54.7 0 82.2v347.6C0 457.3 22.7 480 50.2 480h347.6c27.5 0 50.2-22.7 50.2-50.2V82.2c0-27.5-22.7-50.2-50.2-50.2zm-45.4 284.3c0 4.2-3.6 6-7.8 7.8-16.7 7.2-34.6 13.7-53.8 13.7-26.9 0-39.4-16.7-71.7-16.7-23.3 0-47.8 8.4-67.5 17.3-1.2.6-2.4.6-3.6 1.2V385c0 1.8 0 3.6-.6 4.8v1.2c-2.4 8.4-10.2 14.3-19.1 14.3-11.3 0-20.3-9-20.3-20.3V166.4c-7.8-6-13.1-15.5-13.1-26.3 0-18.5 14.9-33.5 33.5-33.5 18.5 0 33.5 14.9 33.5 33.5 0 10.8-4.8 20.3-13.1 26.3v18.5c1.8-.6 3.6-1.2 5.4-2.4 18.5-7.8 40.6-14.3 61.5-14.3 22.7 0 40.6 6 60.9 13.7 4.2 1.8 8.4 2.4 13.1 2.4 22.7 0 47.8-16.1 53.8-16.1 4.8 0 9 3.6 9 7.8v140.3z"
                  />
                </SVG>
              }
              title={ title }
              onClick={ this.handleFormatButtonClick }
              shortcutType="primary"
            />
            <IconChooserModal onSubmit={ this.handleSelect } />
          </Fragment>
        )
      }
    }
  })
} )(
	window.wp
)
