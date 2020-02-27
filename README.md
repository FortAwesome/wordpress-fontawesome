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
- [API Reference](#api-reference)
- [Usage in Templates or Blocks](#usage-in-templates-or-blocks)
- [Usage in Pages, Posts, and Templates](#usage-in-pages-posts-and-templates)
    * [`<i>` tags](#i-tags)
    * [`[icon]` shortcode](#icon-shortcode)
    * [Avoid `:before` pseudo-elements](#avoid-before-pseudo-elements)
- [What is Actually Enqueued](#what-is-actually-enqueued)
- [Determining Available Versions](#determining-available-versions)
- [Caching the Load Specification](#caching-the-load-specification)
- [How to Ship Your Theme or Plugin To Work with Font Awesome](#how-to-ship-your-theme-or-plugin-to-work-with-font-awesome)
    * [Don't Ship Font Awesome Assets](#dont-ship-font-awesome-assets)
    * [Detect and Warn When the Font Awesome Plugin Version Doesn't Match Your Requirements](#detect-and-warn-when-the-font-awesome-plugin-version-doesnt-match-your-requirements)
- [How to Make Pro Icons Available in Your Theme or Plugin](#how-to-make-pro-icons-available-in-your-theme-or-plugin)
- [Examples](#examples)

<!-- tocstop -->

# Description

This package adds to your plugin or theme the following abilities:

- use Font Awesome SVG, Web Font, Free or Pro, with version 4 compatibility from
    loading from the Font Awesome CDN.
- use Font Awesome Kits
- an `[icon]` shortcode
- detection and resolution of Font Awesome version conflicts introduced by other
    themes or plugins
- coordination of configuration preferences by any number of plugins or theme that
    may be using this package on the same WordPress site.
- management of Font Account access via API Token
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

# API Reference

[See API docs](https://fortawesome.github.io/wordpress-fontawesome/index.html)

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

Refer to the [API documentation](https://fortawesome.github.io/wordpress-fontawesome/index.html)
for details on these accessors and any others that be available. 

# What is Actually Enqueued

What is enqueued depends upon whether the WordPress site owner has configured
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





In this version, all loading happens via the official Font Awesome Free CDN (`use.fontawesome.com`) or
Pro CDN (`pro.fontawesome.com`). No icon assets are bundled with this plugin.

So the end result of this plugin's work is the enqueuing of a stylesheet or script, resulting in the appropriate
`<link>` or `<script>` tag in the `<head>`.

Once a particular version and method is resolved, we load the `all.js` or `all.css` for that version, either
Free or Pro. This is the _simplest_, but normally not the most efficient. It would be more efficient
to load only the icon styles that the web site actually uses. Or it could potentially be made even more efficient
with some additional subsetting functionality. For this initial prototype version, though, we're not
focusing on optimizing efficiency, but on the basic loading and version settlement paradigm across various clients.
If this direction seems good, it would make sense to at least allow particular styles to be loaded.

# Determining Available Versions

We have made a REST API endpoint available on `fontawesome.com` which this plugin uses to retrieve up-to-date metadata about available releases.

# Caching the Load Specification

This plugin computes a _load specification_, 
which is the set of version and configuration options that satisfy the requirements of all registered clients, including
the WordPress site owner via the options page and any themes or plugins that depend on this Font Awesome plugin.

To compute that requires retrieving the latest metadata about Font Awesome releases from a REST API on fontawesome.com
and reducing all of the requirements registered by all clients of this Font Awesome plugin.

We don't need to do all of that work on every page load. Once a load specification is computed, it will not change until
the web site owner changes options on the options page. When this plugin computes a successful load specification,
it stores it under an [options key](https://fortawesome.github.io/wordpress-fontawesome/classes/FontAwesome.html#constant_OPTIONS_KEY)
in the WordPress database and then re-uses that load specification for each page load. In that case, it will not fetch
metadata from fontawesome.com nor process the requirements from registered clients.

# How to Ship Your Theme or Plugin To Work with Font Awesome

You have two options:

1. Peer Dependency

You would instruct your users to install this Font Awesome plugin separately when they install yours.
Your code would expect this plugin to be installed and active. It would register its requirements, receive
the action hook indicating successful load and confirmation of the final load specification. To place icons
in your templates, use `<i>` tags [like normal](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use).

2. Composer Dependency

In your composer project directory:

`composer require fortawesome/wordpress-fontawesome`

In your plugin code, just require the plugin's entrypoint module, such as this:

```php
require_once trailingslashit(__DIR__) . 'vendor/fortawesome/wordpress-fontawesome/font-awesome.php';
```

Then you can access the `FontAwesome` class for class constants like `FontAwesome::PLUGIN_VERSION`, or
get an instance of the plugin with `fa()`.

## Don't Ship Font Awesome Assets

In any case, you would not ship any Font Awesome assets (no web font, CSS, JavaScript, or SVG files).
Rather, you'd rely on this plugin to load the correct assets from the appropriate CDN with the appropriate
configuration.

In the case of Font Awesome Pro, it would be a violation of the license terms to ship Pro assets, so that's
a no-go no  matter what. In the case of Font Awesome Free, while the license would support redistribution
of those assets in your plugin or theme, doing so would defeat one of the chief goals of this plugin:
to create a conflict-free experience of loading Font Awesome, both for developers and site owners.
If you ship and load your own Font Awesome assets, you might just end up being the bad citizen whose code
breaks other components.

# How to Make Pro Icons Available in Your Theme or Plugin

Rather than _you_ supplying the Pro icons, it's your customer who _enables_ Pro icons by setting up their
Pro accounts and configuring this Font Awesome plugin to indicate that Pro is enabled. Your code can then
respond to the presence of Pro and use Pro icons.

If you insist on having Pro icons available at runtime, you'd need to insist that your customers purchase
a Font Awesome Pro license, install this plugin, and enable their Pro account for use with it.

In the event that the customer has not enabled Pro, your code would have to use only Free icons.
Any Pro icons would fail to load correctly. This may mean designing your code to work with Free icons
as a baseline, and then using Pro icons only when available.

Give us feedback about this to help us get the story right. For example, do you need to have a way to
_require_ Pro (like `v4shim` can be `require`d) so that you can count on it being there at runtime,
instead of designing for both alternatives, Free and Pro?

# Examples

There are several clients in this GitHub repo that demonstrate how your code can use this plugin:

| Component | Description |
| --------- | ----------- |
| <span style="white-space:nowrap;">[`integrations/themes/theme-alpha`](https://github.com/FortAwesome/wordpress-fontawesome/tree/master/integrations/themes/theme-alpha)</span> | Theme accepts default requirements, but also reacts to the presence of Pro by using Pro icons in a template. |
| <span style="white-space:nowrap;">[`integrations/plugins/plugin-beta`](https://github.com/FortAwesome/wordpress-fontawesome/tree/master/integrations/plugins/plugin-beta)</span> | Plugin requires v4shim and a specific version. Uses some version 4 icon names. |
| <span style="white-space:nowrap;">[`integrations/plugins/plugin-sigma`](https://github.com/FortAwesome/wordpress-fontawesome/tree/master/integrations/plugins/plugin-sigma)</span> | Registered Client embedding Font Awesome as a composer dependency. When this plugin is activated, Font Awesome is implicitly activated, whether or not the Font Awesome plugin is directly installed or activated. |

See [DEVELOPMENT.md](https://github.com/FortAwesome/wordpress-fontawesome/blob/master/DEVELOPMENT.md) for instructions on how you can run a dockerized WordPress environment and experiment
with these examples.


