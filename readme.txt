=== Font Awesome ===
Contributors: fontawesome, mlwilkerson, robmadole, rachelbaker
Stable tag: 3.2.1
Tags: font, awesome, fontawesome, font-awesome, icon, svg, webfont
Requires at least: 4.7
Tested up to: 5.0
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds Font Awesome 5 icons to your WordPress site. Supports Font Awesome Pro. Resolves conflicts across many plugins or themes that use Font Awesome.

== Description ==

Adds Font Awesome 5 icons to your WordPress site. Supports Font Awesome Pro. Resolves conflicts across many plugins or themes that use Font Awesome.
This is the official plugin from the Font Awesome team.

## New Plugin, Replacing an Old Plugin

It is a new, completely re-written plugin, tested with the latest WordPress and Font Awesome versions. It replaces
the older plugin formerly occupying this space in the WordPress plugins directory, which was no longer being maintained.
Thanks to Rachel Baker and the team behind the former plugin for getting something started and allowing us to carry it forward.

We've built in some magic to help users of the old plugin experience a smooth upgrade path. We think you'll love
Font Awesome 5!

## Features

1. Supports both Font Awesome Free and Font Awesome Pro.

2. Gets new icon updates directly from fontawesome.com right when they're released, ready to add to your site as soon
as you like. New icons are released regularly.

3. Provides easy configuration to enable the new SVG framework with extra features
like [Power Transforms](https://fontawesome.com/how-to-use/on-the-web/styling/power-transforms).

Easily spot and fix conflicts when using SVG would conflict with other plugins or themes
that require the classic Web Fonts & CSS method.

4. Loads icons from the fast Font Awesome Free CDN, or the Font Awesome Pro CDN for [Pro subscribers](https://fontawesome.com/pro).

5. Provides a "v4-shim" to [ease the upgrade from Font Awesome 4 to Font Awesome 5](https://fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4).

6. Developers: supports development of themes and plugins to use Font Awesome without run time conflicts.

Eliminate the headache of various plugins and themes trying to load multiple or incompatible versions of Font Awesome.
Using this plugin provides a common framework for managing Font Awesome dependencies. Rest easy that icons for your templates
will either load like you expect, or else warn the site owner gracefully with clear diagnostics and user-friendly guidance
to resolve conflicts.

7. Prevents "unregistered" themes or plugins from breaking your icons by loading multiple or incompatible versions.

## Upgrading

If you've been a user of previous versions of this plugin, you'll eventually need to update your `[icon]` shortcodes
to use Font Awesome 5 names instead of the out-dated Font Awesome 3 names that old plugin loaded.

We've tried to smooth the upgrade path for you by keeping that shortcode compatible with Font Awesome 3 names
you're used to, while magically transforming them into their Font Awesome 5 equivalents on the fly. You'll still need to
change your icon shortcodes in pages, posts, and templates. But our upgrade magic gives you some cushion to take a more
leisurely pace. We plan to remove version 3 naming support, and the magic, from this plugin in upcoming releases,
though, so don't wait too long!

## See also

The [README](https://github.com/FortAwesome/wordpress-fontawesome/README.md) on GitHub has some more details for
WordPress site owners and developers.

== Installation ==

[Font Awesome Pro](https://fontawesome.com/pro) subscribers who want to enable Pro icons on their WordPress sites, must
first [add their allowed domains](https://fontawesome.com/account/domains) before enabling the "Use Pro" option on the
plugin's settings page.

== Changelog ==

= 4.0.0-alpha1 =

* Add admin settings page
* Lots of back end code changes to support theme and plugin developers
  * Package plugin as a composer dependency
  * API Changes
  * Comprehensive API documentation for developers
* Cache load specification unless client requirements change
* Handle changing configurations as new plugins or themes are activated, de-activated or updated
* Lock working load specifications and only rebuild when new requirements are conflict-free
* Load Font Awesome release version metadata from the fontawesome.com releases API

= 3.2.1 =

* Last stable version of the old plugin

