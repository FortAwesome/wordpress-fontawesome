# wordpress-fontawesome

> Font Awesome 6 Official WordPress Package

This guide is for developers seeking to use `wordpress-fontawesome` as a package
in a WordPress plugin or theme.

WordPress users should consult the [plugin's description in the
WordPress plugin directory](https://wordpress.org/plugins/font-awesome/) for guidance on using Font Awesome in WordPress.

<!-- toc -->
# Contents

- [wordpress-fontawesome](#wordpress-fontawesome)
- [Contents](#contents)
- [Description](#description)
- [Why Use a Package?](#why-use-a-package)
  - [Compatibility and Troubleshooting](#compatibility-and-troubleshooting)
  - [Enabling Font Awesome Pro](#enabling-font-awesome-pro)
  - [Staying Current](#staying-current)
  - [Icon Search](#icon-search)
  - [Future Features](#future-features)
- [Adding as a Composer Package](#adding-as-a-composer-package)
  - [Register your code as a client](#register-your-code-as-a-client)
  - [Register Hooks for Initialization and Cleanup](#register-hooks-for-initialization-and-cleanup)
    - [Activation](#activation)
    - [Deactivation](#deactivation)
    - [Uninstallation](#uninstallation)
- [Installing as a Separate Plugin](#installing-as-a-separate-plugin)
- [API References](#api-references)
- [Usage in Pages, Posts, and Templates](#usage-in-pages-posts-and-templates)
  - [`<i>` tags](#i-tags)
  - [`[icon]` shortcode](#icon-shortcode)
  - [Avoid `:before` pseudo-elements](#avoid-before-pseudo-elements)
- [Usage in Gutenberg (Blocks)](#usage-in-gutenberg-blocks)
  - [`i2svg` auto-replaces `<i>` elements with `<svg>` elements](#i2svg-auto-replaces-i-elements-with-svg-elements)
  - [Font Awesome might be configured for Web Font](#font-awesome-might-be-configured-for-web-font)
  - [`<i>` elements should work under both SVG and Web Font configurations](#i-elements-should-work-under-both-svg-and-web-font-configurations)
  - [Insisting on SVG technology](#insisting-on-svg-technology)
  - [Using the JavaScript API directly instead of `<i>` tags](#using-the-javascript-api-directly-instead-of-i-tags)
  - [Using `react-fontawesome`](#using-react-fontawesome)
  - [Font Awesome CSS Required](#font-awesome-css-required)
- [Detecting Configured Features](#detecting-configured-features)
- [What Gets Enqueued](#what-gets-enqueued)
  - [Use CDN](#use-cdn)
  - [Use a Kit](#use-a-kit)
- [Loading Efficiency and Subsetting](#loading-efficiency-and-subsetting)
  - [Long-term Disk Cache](#long-term-disk-cache)
  - [All Icons vs Subset in WordPress](#all-icons-vs-subset-in-wordpress)
  - [Pro Kits Do Auto-Subsetting](#pro-kits-do-auto-subsetting)
  - [How to Subset When You Know You Need To: Or, When Not To Use This Package](#how-to-subset-when-you-know-you-need-to-or-when-not-to-use-this-package)
- [How to Make Pro Icons Available in Your Icon Chooser](#how-to-make-pro-icons-available-in-your-icon-chooser)
- [Query the Font Awesome GraphQL API](#query-the-font-awesome-graphql-api)
  - [public scope queries on api.fontawesome.com](#public-scope-queries-on-apifontawesomecom)
  - [querying fields with non-public scopes](#querying-fields-with-non-public-scopes)
- [Examples](#examples)
- [Contributing Development to this Package](#contributing-development-to-this-package)

<!-- tocstop -->

# Description

This package adds to your plugin or theme the following abilities:

- use Font Awesome SVG, Web Font, Free or Pro, with version 4 compatibility, loading from the Font Awesome CDN.
- use Font Awesome Kits
- an `[icon]` shortcode
- detection and resolution of Font Awesome version conflicts introduced by other
    themes or plugins
- coordination of configuration preferences by any number of plugins or theme that
    may be using this package on the same WordPress site.
- management of Font Awesome account authorization via API Token
- management of Font Awesome releases metadata (available versions and related metadata)
- Font Awesome GraphQL API queries authorized by the site owner's API Token

# Why Use a Package?

If you're a WordPress developer, then you already know how to use `wp_enqueue_style`
or `wp_enqueue_script` to load assets like Font Awesome. So why take a dependency
on another package to do that for you?

## Compatibility and Troubleshooting

Because Font Awesome is so popular among themes and plugins, and because it's
so easy for a developer to enqueue the Font Awesome assets, it's become a jungle
out there for our users.

Some WordPress site owners have been known to have a theme and three different
plugins installed, each trying to load its own self-hosted version of Font Awesome:
- mixing version 4 or 5 with version 6
- mixing SVG with Web Font
- sometimes even Font Awesome version 3

This package provides sophisticated conflict detection, resolution, and error reporting,
empowering our users to solve their compatibility problems quickly.

## Enabling Font Awesome Pro

Also, back when many themes and plugins began including Font Awesome, there was
no Pro version. Now there is, and there's a constant stream of new icons, styles,
and features being added.

Font Awesome Pro subscribers should be able to use
their Pro goodies in your theme or plugin. But since Font Awesome's licensing
doesn't allow you to distribute Font Awesome Pro, you'd have to
rely on the user to do some kind of setup on their end to enable it.
Why reinvent that wheel?

And even if you do, you'd still have those compatibility problems with other
themes and plugins, which you may be making even worse by giving the user yet
another way to add another conflicting version of Font Awesome to their WordPress site.

## Staying Current

Some WordPress developers have solvd the Pro problem by not shipping the
Font Awesome _assets_, but shipping the Pro _metadata_ to drive their icon choosers.
That locks you into whatever version of Font Awesome Pro you happened snapshot
when you release. But again, there's a constant flow of new icons and features
being added to Font Awesome Pro. Font Awesome Pro subscribers love having access
to those new icons when they come out, so let's help them stay current.

This package allows the user to manage the version of Font Awesome, while giving
you, the developer, runtime access to all metadata for whatever version the user
chooses.

## Icon Search

Power-up those icon choosers with integrated Algolia search--the same icon search
that powers the [Icon Gallery on fontawesome.com](https://fontawesome.com/icons).
With 7,000+ icons and growing,
search makes _finding_ the right icon--by name, category, or conceptual similarity--much
easier for users. Why re-invent that wheel?

## Future Features

We can't say much right now, but there some big stuff coming to Font Awesome Pro
that will only be accessible through an authenticated Font Awesome account.

You could manage everything related to authorizing Font Awesome accounts to access
those features (which your users are definitely going to want to use on their
WordPress sites!) But again, why re-invent that wheel?

# Adding as a Composer Package

```bash
composer require fortawesome/wordpress-fontawesome
```

In your code, requiring this package's `index.php` will cause the version of
the package as bundled by your theme or plugin to be added to the list of
possible versions to be loaded by the `FontAwesome_Loader`. The loader coordinates
among potentially multiple installations of the plugin, ensuring that the latest available
version of the package is loaded and used at run time.

```php
require_once __DIR__ . '/vendor/fortawesome/wordpress-fontawesome/index.php';

# optional, for conveniece
use function FortAwesome\fa;
```

## Register your code as a client

You should register your code as a client of Font Awesome, even if you have no configuration
preferences to specify, because the Font Awesome Troubleshoot tab will show the
WP admin a listing of which plugins or themes are actively using Font Awesome,
what their preferences are, and what conflicts there may be.

Do not register any preferences if you don't really need to. It will be a better
experience for the WP admin user if your theme or plugin can adapt to their changes
of Font Awesome preferences without complaint from your code.

[See the API documentation](https://fortawesome.github.io/wordpress-fontawesome/index.html) for the preferences schema.

```php
add_action(
    'font_awesome_preferences',
    function() {
        fa()->register(
            array(
                'name' => 'plugin foo'
                // other preferences would be registered here
            )
        );
    }
);
```

## Register Hooks for Initialization and Cleanup

There are basic principles for initialization and cleanup that apply in either case,
but the implementation details will vary depending on whether you're building a theme
or a plugin.

### Activation

When your theme or plugin is activated, it should invoke `FortAwesome\FontAwesome_Loader::initialize`.

This will ensure that Font Awesome is initialized without interfering with any
existing Font Awesome configuration that may already be present from some other theme's
or plugin's use of this package. In other words `initialize()` can be called multiple times,
but subsequent invocations will not overwrite or reset prior saved settings.

**Plugin Activation**

Your plugin code should do something like this:

```php
register_activation_hook(
	__FILE__,
	'FortAwesome\FontAwesome_Loader::initialize'
);
```

**Theme Activation**

Your theme code should do something like this:

```php
add_action('after_switch_theme', 'FortAwesome\FontAwesome_Loader::initialize');
```

### Deactivation

When your theme or plugin is deactivated,
it should invoke `FortAwesome\FontAwesome_Loader::maybe_deactivate`.

This will ensure that the Font Awesome deactivation logic is run if your theme
or plugin is the last known client of Font Awesome. Otherwise, the state of the
database is left alone, for the sake of any remaining Font Awesome clients.

Plugins have a specific deactivation hook that is separate from an uninstall hook.
There are different things to clean up in each case.

Themes don't have the same lifecyle hooks as plugins. In _your_ theme, you might
want to handle deactivation and uninstallation differently than the examples below,
but these will get the job done.

**Plugin Deactivation**

Your plugin code should do something like this:

```php
register_deactivation_hook(
	__FILE__,
	'FortAwesome\FontAwesome_Loader::maybe_deactivate'
);
```

**Theme Deactivation**

A theme is deactivated when some other theme is activated instead. At that time,
the `switch_theme` action is fired. This is an opportunity for your theme to run
_both_ the deactivation _and_ uninstallation logic.
Both should probably be run from that one callback, since there's no separate, subsequent uninstall
hook for themes as there is for plugins.

(NOTE: if you're a theme developer who knows a better pattern for us to use here, please open
an issue on this repo with a suggestion.)

```php
add_action('switch_theme', function() {
	FortAwesome\FontAwesome_Loader::maybe_deactivate();
	FortAwesome\FontAwesome_Loader::maybe_uninstall();
});
```

### Uninstallation

When your theme or plugin is uninstalled, it
should invoke `FortAwesome\FontAwesome_Loader::maybe_uninstall`.

Similarly, this will ensure that the Font Awesome uninstall logic is run if your
theme or plugin is the last known client of Font Awesome. Otherwise, the state
of the database is left alone, for the sake of other themes or plugins.

**Plugin Uninstall**

Your code should do something like this:

```php
register_uninstall_hook(
	__FILE__,
	'FortAwesome\FontAwesome_Loader::maybe_uninstall'
);
```

**Theme Uninstall**

There's no hook for themes that's analogous to the `register_uninstall_hook` for plugins.
For themes, our last chance to run uninstall logic is on the `switch_theme` action hook,
as noted above under _Theme Deactivation_.

# Installing as a Separate Plugin

This package is also available as a [plugin in the WordPress plugin directory](https://wordpress.org/plugins/font-awesome/).

You could instruct your users to install that plugin separately. Once activated,
using the [PHP API](https://fortawesome.github.io/wordpress-fontawesome/index.html)
works the same as if you had included this package via composer.

# API References

Here are some relevant APIs:
- [PHP API](https://fortawesome.github.io/wordpress-fontawesome/index.html): any theme or plugin developer probably needs this
- [GraphQL API](https://fontawesome.com/docs/apis/graphql/get-started): you may need this if you write code to query for metadata about icons, such as when building an icon chooser
- [JavaScript API](https://fontawesome.com/docs/apis/javascript/get-started): you may need this if you are working directly with the JavaScript objects, such as when for doing some custom SVG rendering in Gutenberg blocks
- [react-fontawesome component](https://github.com/FortAwesome/react-fontawesome): you might prefer this instead of doing low-level JS/SVG rendering

# Usage in Pages, Posts, and Templates

## `<i>` tags

Your templates can use standard `<i>` tags in the all the ways described in the
[Font Awesome quick start](https://fontawesome.com/docs/web/setup/get-started).

If Font Awesome is configured to use SVG technology, you can also use all of the
SVG-only features, like [Power Transforms](https://fontawesome.com/docs/web/style/power-transform).

## `[icon]` shortcode

`[icon name="stroopwafel" prefix="fal"]`

The `name` attribute is just the name of the icon, not the CSS class name.

The `prefix` attribute defaults to `fas`, but must be specified for other styles.

## Avoid `:before` pseudo-elements

Many themes and plugins use CSS Pseudo-elements to do things like adding icons
`:before` the `<li>` elements in menus.

This was a common practice for users of Font Awesome 4 and earlier and tends to
work fine as long as the `font-family` in your CSS rules is known and never changes,
and as long as the Font Awesome technology is always CSS with Web Font, and not
SVG.

You should not make any of those assumptions. It's one of the most causes of
"my icons are broken" when WordPress users attempt to change the version of
Font Awesome loaded on their site.

Font Awesome 5 & 6 do not use the same `font-family` as Font Awesome 4 did.
It uses _multiple_ different `font-family` values that vary by icon style.

Also, while pseudo-elements perform nicely with CSS and Web Font technology,
getting them to work with the SVG technology requires a lot of extra processing
that can cause significant performance problems in the browser. It's really only
provided as an accommodation when pseudo-elements can't be avoided. This is why
pseudo-elements are _not_ enabled by default when configured for SVG technology.

Your plugin can register a _preference_ for Web Font technology or pseudo-elements,
if you must. But the WordPress site owner ultimately _determines_ the configuration
of Font Awesome. They may have to negotiate the requirements of multiple plugins
or themes, some of which may not be playing nice. It can be a difficult
balancing act.

Ease their pain by using a flexible and maximally compatible approach in your code.

Simply using `<i>` tags or `[icon]` shortcodes avoids the potential compatibility
or performance problems that come with pseudo-elements.

# Usage in Gutenberg (Blocks)

There are several ways one might incorporate Font Awesome icons in Gutenberg development.

Here are some considerations for you as you determine your approach:

## `i2svg` auto-replaces `<i>` elements with `<svg>` elements

The [default configuration](https://fontawesome.com/docs/apis/javascript/configuration) of the SVG with JavaScript technology that is loaded by this
package, whether via CDN or Kit, is `autoReplaceSvg: true`. This means that:

1. When the DOM loads, any `<i>` tags that look like Font Awesome icons are replaced with their correspoding `<svg>` elements.
1. Any time the DOM is mutated to insert an `<i>` element dynamically, that `<i>` element is also replaced with its corresponding `<svg>`.

So, if your Gutenberg code renders icons as `<i>` tags, and the active Font Awesome
technology is SVG, then your rendered `<i>` tags will be immediately replaced
with `<svg>` elements. That may or may not be what you want.

If the `autoReplaceSvg` behavior is not what you want, you should not disable it
if there's any chance that other themes, plugins or content creators may be relying
on it. Instead, consider one of the alternatives to `<i>` tags below.

## Font Awesome might be configured for Web Font

The WordPress admin may have enabled Web Font technology instead of SVG.

This is not necessarily a problem, as long as your Gutenberg code is only rendering
icons `<i>` elements anyway, and you're not using any SVG-only features like
[Power Transforms](https://fontawesome.com/docs/web/style/power-transform), or [Text, Layers, or Counters](https://fontawesome.com/docs/web/style/layer).

It just means that your rendred `<i>` elements will remain `<i>` elements in the
DOM and not replaced by `<svg>` elements.

The Web Font technology does not
_replace_ the `<i>` elements, it matches their CSS classes with the appropriate
glyph lookups in the associated web fonts loaded by the Font Awesome CSS.

## `<i>` elements should work under both SVG and Web Font configurations

This point can be inferred from the previous two. If your Gutenberg code works
by rendering `<i>` elements, it would be best to ensure that it works equally
well when Font Awesome is configured either for SVG or Web Font.

## Insisting on SVG technology

You could make it an error to run your code with Font Awesome technology as Web Font.
If you know that your code absolutely must have the SVG with JavaScript technology
to work properly, you could detect the presence of that feature and have your
code respond accordingly.

In the WordPress server PHP code, you can call `fa()->technology()` and expect
it to return `"svg"`.

In the browser, the [Font Awesome JavaScript API](https://fontawesome.com/docs/apis/javascript/get-started#in-the-browser) will be present on the global `FontAwesome`
object only when SVG with JavaScript is loaded.

You should also register a preference for SVG in your `font_awesome_preferences`
action hook:

```php
add_action(
	'font_awesome_preferences',
	function() {
		fa()->register(
			array(
                'name'       => 'plugin foo',
                'technology' => 'svg'
			)
		);
	}
);
```

This approach comes at the cost of limiting compatibility, though. It either limits
when your code can run, or it creates a potential mutual exclusion
with other themes or plugins that work better with Web Font technology.

Generally, our goal is to maximize compatibility and thus minimize pain for the
WordPress user.

## Using the JavaScript API directly instead of `<i>` tags

If `all.js` is loaded, and it is when `fa()->technology() === "svg"` and
`fa()->using_kit()` is `false`, then the `IconDefinition` objects for all icons
in the installed version of Font Awesome may be looked up
with [`findIconDefinition()`](https://fontawesome.com/docs/apis/javascript/methods#findicondefinition-params).

If `fa()->pro()` is also `true` then the `fal` style prefix will also be available.
So the following
would get the `IconDefinition` object for the `coffee` icon in the Light style.

```javascript
const faLightCoffee = FontAwesome.findIconDefinition({ prefix: 'fal', iconName: 'coffee' })
```

The `faLightCoffee` object can then be used with [`icon()`](), for example, to get
an html rendering of the icon as an `<svg>` element:

```javascript
FontAwesome.icon(faLightCoffee).html
```

would produce something like:

```html
[
  '<svg data-prefix="fal" data-icon="coffee" class="svg-inline--fa fa-coffee fa-w-18"  ...>...</svg>
]
```

This html could be stored directly as page content.

Or an abstract object could be generated that you could use to create your own
DOM elements or store in the attributes of your Block:

```javascript
FontAwesome.icon(faLightCoffee).abstract
```

would produce something like:

```javascript
[
  {
    "tag": "svg",
    "attributes": {
      "aria-hidden": "true",
      "focusable": "false",
      "data-prefix": "fal",
      "data-icon": "coffee",
      "class": "svg-inline--fa fa-coffee fa-w-18",
      "role": "img",
      "xmlns": "http://www.w3.org/2000/svg",
      "viewBox": "0 0 512 512"
    },
    "children": [
      {
        "tag": "path",
        "attributes": {
          "fill": "currentColor",
          "d": "M517.9...64z"
        }
      }
    ]
  }
]
```

## Using `react-fontawesome`

[`react-fontawesome`](https://github.com/FortAwesome/react-fontawesome) is another alternative to `<i>` tags.

When you already have an `IconDefinition` object, it's easy:

```javascript
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
// ...
const lightCoffeeComponent = <FontAwesomeIcon icon={ faLightCoffee } />
```

## Font Awesome CSS Required

While icons may be pre-rendered as HTML or rendered as DOM objects using abstracts,
as in the above examples, they still depend upon the [Font Awesome CSS](https://fontawesome.com/docs/apis/javascript/methods#dom-css)
being inserted into the DOM separately.

This is done automatically when the SVG with JavaScript technology is loaded via
CDN or Kit. However, there's currently no built-in way to ensure that the
Font Awesome CSS is inserted when Font Awesome is configured for Web Font technology.

The workarounds risk compatibility problems with other clients, and one of
the main goals of this package is to solve such compatibility problems.

**Workaround 1: bundle the `fontawesome-svg-core` npm**

```bash
npm install --save @fortawesome/fontawesome-svg-core
```

```javascript
import { dom } from '@fortawesome/fontawesome-svg-core'

if ( !window.FontAwesome ) {
    dom.insertCss(dom.css())
}
```

If your bundler does tree-shaking, then this should result in a pretty slim
addition to your bundle--mostly the CSS content itself.

This approach is also susceptible to problems caused by differences in Font Awesome
versions between the version of that npm package and the version used for generating
the abstract with its classes.

**Workaround 2: fetch the CSS appropriate for the version**

Get the Font Awesome version currently loaded: `fa()->version()`.

Fetch the required CSS from the CDN, replacing
the version number appropriately and set its contents as the text of a new
`<style>` node, like this:

```javascript
fetch('https://use.fontawesome.com/releases/v5.12.1/css/svg-with-js.css')
.then(response => response.ok ? response.text() : null)
.then(css => {
    if( css ) {
        const faCssStyle = document.createElement('STYLE')
        faCssStyle.appendChild(document.createTextNode(css))
        document.head.appendChild(faCssStyle)
    } else {
        // handle error
    }
})
.catch(error => {
    // handle error
})
```

You might also query the DOM first to make sure some other similar CSS hasn't
already been added before adding this to the DOM yourself.

# Detecting Configured Features

You may you want to use features like Power Transforms that are only available when
SVG technology is configured, or icon styles like Duotone that are only available
when Font Awesome Pro is configured, or some icons that are only available
in newer releases of Font Awesome. You can detect those configurations
using accessor methods on the `FontAwesome` instance from your PHP code.

The `FortAwesome\fa` function provides convenient access to the `FontAwesome`
singleton instance. The following examples assume that you've done a
`use function FortAwesome\fa;`

- `fa()->technology()` (svg or webfont)
- `fa()->pro()` (boolean)
- `fa()->pseudo_elements()` (boolean)
- `fa()->v4_compatibility()` (boolean)
- `fa()-version()` ("latest" or something concrete like "5.12.0")

You can use these accessors when or after the `font_awesome_enqueued` action
hook has been been triggered.

Refer to the [PHP API documentation](https://fortawesome.github.io/wordpress-fontawesome/index.html)
for details on these accessors and any others that be available.

# What Gets Enqueued

What gets enqueued depends upon whether the WordPress site owner has configured
Font Awesome to use the CDN or Kits. (A bit of a misnomer, since kits are loaded from
CDN as well, just differently.)

## Use CDN

A number of `<script>` or `<link>` resources are loaded, depending whether the
site owner configures for SVG or Web Font technology, and enables version 4
compatibility.

- main resource: `all.js` (SVG) or `all.css` (Web Font)
- v4 compatibility shims : `v4-shims.js` (SVG) or `v4-shims.css` (Web Font)
    These shims are what version 4 icon classes to version 5 equivalents

Some additional inline resources may be added, depending on configuration:
- an inline `<script>` is added to enable pseudo-element support when SVG technology is configured.
- an inline `<style>` is added to enable additional v4 compatibility support: shimming the v4 `font-family` name

If conflict detection is enabled, an additional `<script>` is enqueued that loads
the conflict detector from the CDN.

## Use a Kit

When configured to use a kit, only the kit's loader `<script>` is enqueued.
While the conflict scanner is enabled, an additional inline `<script>` is added
to configure the conflict detector _within_ the kit.

The kit loader script subsequently handles the insertion of various `<script>`
or `<link>` elements, based on the kit's configuration, but that all happens
outside of WordPress semantics. As far as WordPress is concerned, it's just a
single `wp_enqueue_script` on the kit loader.

# Loading Efficiency and Subsetting

## Long-term Disk Cache

The URLs loaded from the Font Awesome CDN are specific to a given release, so
their contents don't change, and therefore, they can be long-term cached in
the browser.

For example, suppose Font Awesome is configured for Free Web Font, version 5.12.1,
then this will be the main resource loaded:

`https://use.fontawesome.com/releases/v5.12.1/css/all.css`

It's loaded as 56KB over the network, but on subsequent loads, it does not
hit the network but loads from the browser's disk cache.

(The CSS also causes the underlying webfont files to be loaded. The story is the
same, subsequent loads will normally use the browser's disk cache and not use
the network.)

## All Icons vs Subset in WordPress

Given the large and growing number of icons availble in Font Awesome, it's
natural to ask whether one might be able to load only the subset actually used.

In the WordPress ecosystem, though, it's common for site owners to install
more than one theme or plugin that each uses Font Awesome icons, and tries
to load its own version of Font Awesome. This causes conflicts across those
various themes or plugins when activated on the same WordPress site.

A primary goal of this plugin package is to ease the pain for site owners to get
those themes and plugins working with a single loaded version of Font Awesome
that works for all concerned. And especially if it's a Font Awesome Pro user,
they should be able to use Pro icons in their pages and posts, even while other
installed plugins only use Free icons from version 4.

In that case where the site owner, their theme, and any number of installed
plugins each use Font Awesome icons directly, it would be very difficult to
determine what minimal subset could be created that would include all of the
icons required by any of those clients.

Simply making all of them available for a given version of Font Awesome allows
for every client to be satisfied.

## Pro Kits Do Auto-Subsetting

Font Awesome Pro Kits (but not Free kits) have some built-in loading optimization
that results in fewer resources being loaded, only as they are required
by the browser.

Again, those resources will normally be long-term cached in the browser and
loaded from the browser's disk cache on subsequent loads.

**Pro SVG** Kits are super-optimized. They auto-subset icon-by-icon. If a given
web site only used one icon out of the 7,000+ in Font Awesome Pro, then only that
one single icon would be fetched--except on subsequent loads when it would probably
be pulled from disk cache.

## How to Subset When You Know You Need To: Or, When Not To Use This Package

Suppose you're in a situation like this:

- you are a developer
- you're also the WordPress site owner
- you control what themes or plugins are active on that site now and in the future
- you are comfortable working directly in source code to manage which version and technology of Font Awesome is loaded
- in the event that you do encounter an unexpected conflict, you are comfortable with investigating the WordPress resource queue and/or inspecting the browser DOM to identify and resolve the problem
- the advantages of creating a subset are more important to you than the advantages of loading `all.css` or `all.js` from the Font Awesome CDN, or loading via Kit

In that case, then you might prefer to do a [manual installation](https://fontawesome.com/docs/web/use-with/wordpress/install-manually/) _instead_ of using this plugin package.

You could either load exactly the resources you want from the Font Awesome CDN,
or you could create your own subset of resources to load locally from your WordPress
server or from your own CDN.

# How to Make Pro Icons Available in Your Icon Chooser

Font Awesome's Pro icon licensing does not allow theme or plugin vendors to
_distribute_ Font Awesome Pro to their users. However, if your user has enabled
Font Awesome Pro on their WordPress site, then you can provide whatever functionality
you like to aid the user's use of those Pro icons.

Some ways you could accomplish this:

1. In your marketing materials, make it clear that your product enables a design experience with a Font Awesome Pro installation provided by the user
1. Using this package, register a preference for pro in your `font_awesome_preferences` action hook.
   This will remind the user in the Font Awesome settings UI that your product
   wants Pro to be enabled.
1. Your code could detect that `fa()->pro()` is false and post an admin notice or other messaging in your own WordPress admin UI.

Once the site owner enables Pro, `fa()->pro()` will be `true` and your code can
then rely on the presence of Font Awesome Pro for the version indicated by
`fa()->version()`.

(See the [PHP API docs](https://fortawesome.github.io/wordpress-fontawesome/index.html) for how to resolve the symbolic
`"latest"` version as a concrete version like `"5.12.0"`.)

# Query the Font Awesome GraphQL API

The Font Awesome [GraphQL API](https://fontawesome.com/docs/apis/graphql/get-started) allows you to query and search icon metadata.

See also documentation in PHP API on the [`FontAwesome::query()`](https://fortawesome.github.io/wordpress-fontawesome/classes/FortAwesome.FontAwesome.html#method_query) method.

## public scope queries on api.fontawesome.com

When you only need to query public fields, you can issue queries directly
against `api.fontawesome.com`.

You could paste this into your browser's JavaScript console right now and get
a list of all icon names in the 5.12.0 release:

```javascript
fetch(
  'https://api.fontawesome.com',
  {
    method: 'POST',
    body: 'query { release(version:"5.12.0") { icons { id } } }'
  }
)
.then(response => response.ok ? response.json() : null)
.then(json => console.log(json))
.catch(e => console.error(e))
```

## querying fields with non-public scopes

Queries that include field selections on fields requiring scopes more
privileged than public require authorization with a Font Awesome account-holder's
API Token.

There are some current and future Font Awesome features that require
higher privileged scopes.

Currently, to query the kits on an account requires an API Token with the `kits_read`
scope. Normally, a plugin or theme you develop probably wouldn't need that particular
information, but it will serve as an example for how authorized queries can be issued
through the API REST controller provided by this package.

The following examples assume that you're using the `apiFetch()` available
on the global `wp` object in Gutenberg, or that you're using an `apiFetch()` that you've
bundled and imported from [`@wordpress/api-fetch`](https://developer.wordpress.org/block-editor/packages/packages-api-fetch/),
and configured it with an appopriate [REST root URL](https://developer.wordpress.org/reference/functions/rest_url/))
and [nonce](https://developer.wordpress.org/reference/functions/wp_create_nonce/).

If you open your browser to a window in Gutenberg, such as on a new post, you
could copy and paste these samples into the JavaScript console as-is.

First, for comparison, here's the same all-public query like we issued above,
but this time through the Font Awesome REST API endpoint:

```javascript
wp.apiFetch( {
    path: '/font-awesome/v1/api',
    method: 'POST',
    body: 'query { release(version:"5.12.0") { icons { id } } }'
} ).then( res => {
    console.log( res );
} )
```

Now this query requires no extra authentication work on your part, yet it
allows you to issue a query that is authorized by the WordPress site owner's
API Token, if configured:

```javascript
wp.apiFetch( {
    path: '/font-awesome/v1/api',
    method: 'POST',
    body: 'query { me { kits { token name } } }'
} ).then( res => {
    console.log( res );
} )
```

# Examples

There are several clients in this GitHub repo that demonstrate how your code can use this package:

| Component | Description |
| --------- | ----------- |
| <span style="white-space:nowrap;">[`integrations/themes/theme-alpha`](https://github.com/FortAwesome/wordpress-fontawesome/tree/master/integrations/themes/theme-alpha)</span> | Theme accepts default requirements, but also conditionally uses Pro icons when available. It expects Font Awesome to be installed as a plugin by the site owner, rather than including it as a composer package. |
| <span style="white-space:nowrap;">[`integrations/plugins/plugin-beta`](https://github.com/FortAwesome/wordpress-fontawesome/tree/master/integrations/plugins/plugin-beta)</span> | Plugin requires version 4 compatibility, webfont technology, and a specific version. Uses some version 4 icon names. Assumes this package is already installed as a plugin. |
| <span style="white-space:nowrap;">[`integrations/plugins/plugin-sigma`](https://github.com/FortAwesome/wordpress-fontawesome/tree/master/integrations/plugins/plugin-sigma)</span> | A plugin that requires this package via composer. |

# Contributing Development to this Package
See [DEVELOPMENT.md](https://github.com/FortAwesome/wordpress-fontawesome/blob/master/DEVELOPMENT.md) for instructions on how you can set up a development environment to make contributions.
