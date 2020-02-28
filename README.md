# wordpress-fontawesome

> Font Awesome 5 Official WordPress Package

This guide is for developers seeking to use `wordpress-fontawesome` as a package
within another WordPress plugin or theme.

Users of the Font Awesome plugin should consult the [plugin's description in the
WordPress plugin directory](https://wordpress.org/plugins/font-awesome/).

<!-- toc -->
# Contents

- [Description](#description)
- [Adding as a Composer Package](#adding-as-a-composer-package)
- [Installing as a Separate Plugin](#installing-as-a-separate-plugin)
- [API References](#api-references)
- [Usage in Pages, Posts, and Templates](#usage-in-pages-posts-and-templates)
    * [`<i>` tags](#i-tags)
    * [`[icon]` shortcode](#icon-shortcode)
    * [Avoid `:before` pseudo-elements](#avoid-before-pseudo-elements)
- [Detecting Configured Features](#detecting-configured-features)
- [What Gets Enqueued](#what-gets-enqueued)
    * [Use CDN](#use-cdn)
    * [Use a Kit](#use-a-kit)
- [Loading Efficiency and Subsetting](#loading-efficiency-and-subsetting)
    * [Long-term Disk Cache](#long-term-disk-cache)
    * [The Whole Internet Warms the Cache](#the-whole-internet-warms-the-cache)
    * [All Icons vs Subset in WordPress](#all-icons-vs-subset-in-wordpress)
    * [Pro Kits Do Auto-Subsetting](#pro-kits-do-auto-subsetting)
    * [How to Subset When You Know You Need To: Or, When Not To Use This Package](#how-to-subset-when-you-know-you-need-to-or-when-not-to-use-this-package)
- [How to Use Pro Icons](#how-to-use-pro-icons)
- [Examples](#examples)
- [Development](#development)

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

# Adding as a Composer Package

```bash
composer require fortawesome/wordpress-fontawesome
```

In your code, requiring this package's `index.php` will cause the version of
the package as bundled by your theme or plugin to be added to the list of
possible versions to be loaded by the `FontAwesome_Loader`. The loader coordinates
among potentially multiple uses of the plugin, ensuring that the latest available
version of the package is loaded and used at run time.

```php
require_once __DIR__ . '/vendor/fortawesome/wordpress-fontawesome/index.php';

# optional, for conveniece
use function FortAwesome\fa;
```

## Register Hooks

**Register an activation hook.** When your theme or plugin is activated,
it should invoke `FortAwesome\FontAwesome_Loader::initialize`.

This will ensure that Font Awesome is initialized, without interfering with any
existing Font Awesome configuration that may already exist from some other theme
or plugin's use of this package.

```php
register_activation_hook(
	__FILE__,
	'FortAwesome\FontAwesome_Loader::initialize'
);
```

**Register a deactivation hook.** When your theme or plugin is deactivated,
it should invoke `FortAwesome\FontAwesome_Loader::maybe_deactivate`.

This will ensure that the Font Awesome deactivation logic is run if your theme
or plugin is the last known client of Font Awesome. Otherwise, the state of the
database is left alone, for the sake of other themes or plugins.

```php
register_deactivation_hook(
	__FILE__,
	'FortAwesome\FontAwesome_Loader::maybe_deactivate'
);
```

**Register an uninstall hook.** When your theme or plugin is uninstalled, it
should invoke `FortAwesome\FontAwesome_Loader::maybe_uninstall`.

Similarly, this will ensure that the Font Awesome uninstall logic is run if your
theme or plugin is the last known client of Font Awesome. Otherwise, the state
of the database is left alone, for the sake of other themes or plugins.

```php
register_uninstall_hook(
	__FILE__,
	'FortAwesome\FontAwesome_Loader::maybe_uninstall'
);
```

**Register yourself as a client.**

You should register as a client of Font Awesome, even if you have no configuration
preferences to specify, because the Font Awesome Troubleshoot tab will show the
WP admin a listing of which plugins or themes are actively using Font Awesome,
what their preference are, and conflicts there may be.

Do no register any preferences if you don't really need to. It will be a better 
experience for the WP admin user if your theme or plugin can adapt without
complaint to whatever Font Awesome setup they configure.

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

# Installing as a Separate Plugin

This package is also available as a [plugin in the WordPress plugin directory](https://wordpress.org/plugins/font-awesome/).

You could instruct your users to install that plugin separately. Once activated,
using the [PHP API](https://fortawesome.github.io/wordpress-fontawesome/index.html)
works the same as if you had included this package via composer.

# API References

Here are some relevant APIs:
- [PHP API](https://fortawesome.github.io/wordpress-fontawesome/index.html): any theme or plugin developer probably needs this
- [GraphQL API](https://fontawesome.com/how-to-use/with-the-api): you may need this if you write code to query for metadata about icons, such as when building an icon chooser
- [JavaScript API](https://fontawesome.com/how-to-use/with-the-api): you may need this if you are working directly with the JavaScript objects, such as when for doing some custom SVG rendering in Gutenberg blocks
- [react-fontawesome component](https://github.com/FortAwesome/react-fontawesome): you might prefer this instead of doing low-level JS/SVG rendering

# Usage in Pages, Posts, and Templates

## `<i>` tags

Your templates can use standard `<i>` tags in the all the ways described in the
[Font Awesome usage guide](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use).

If Font Awesome is configured to use SVG technology, you can also use all of the
SVG-only features, like [Power Transforms](https://fontawesome.com/how-to-use/on-the-web/styling/power-transforms).

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

Font Awesome 5 does not use the same `font-family` as Font Awesome 4 did.
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

## The Whole Internet Warms the Cache

There are lots of web sites that use Font Awesome, and very often they do so
by simply loading `all.css` or `all.js`. When a browser loads that resource
for a specific version of Font Awesome on site A, and caches it, then it's already
cached when the same browser visits site B where the same resource is required.

In that case, even the first load of `all.css` for that browser's visit to site B
would already be loaded from the browser's disk cache.

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

In that case, then you might prefer to do a [custom installation](https://fontawesome.com/how-to-use/customizing-wordpress/intro/getting-started) _instead_ of using this plugin package.

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

# Examples

There are several clients in this GitHub repo that demonstrate how your code can use this package:

| Component | Description |
| --------- | ----------- |
| <span style="white-space:nowrap;">[`integrations/themes/theme-alpha`](https://github.com/FortAwesome/wordpress-fontawesome/tree/master/integrations/themes/theme-alpha)</span> | Theme accepts default requirements, but also conditionally uses Pro icons when available. It expects Font Awesome to be installed as a plugin by the site owner, rather than including it as a composer package. |
| <span style="white-space:nowrap;">[`integrations/plugins/plugin-beta`](https://github.com/FortAwesome/wordpress-fontawesome/tree/master/integrations/plugins/plugin-beta)</span> | Plugin requires version 4 compatibility, webfont technology, and a specific version. Uses some version 4 icon names. Assumes this package is already installed as a plugin. |
| <span style="white-space:nowrap;">[`integrations/plugins/plugin-sigma`](https://github.com/FortAwesome/wordpress-fontawesome/tree/master/integrations/plugins/plugin-sigma)</span> | A plugin that requires this package via composer. |

# Development
See [DEVELOPMENT.md](https://github.com/FortAwesome/wordpress-fontawesome/blob/master/DEVELOPMENT.md) for instructions on how you can set up a development environment to make contributions to this code base.


