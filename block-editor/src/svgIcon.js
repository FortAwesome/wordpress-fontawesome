import classnames from 'classnames'

export default function({ extraClasses, width, height, primaryPath }) {
  const classes = classnames('svg-inline--fa', extraClasses)

  return (
    <svg
      className={classes}
      viewBox={`0 0 ${width} ${height}`}
    >
      <path
        fill="currentColor"
        d={primaryPath}
      />
    </svg>
  )
}
