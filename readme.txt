=== Font Awesome Official ===
Contributors: fontawesome, mlwilkerson, kemitchell, robmadole
Stable tag: 0.2.0
Tags: font, awesome, fontawesome, font-awesome, font-awesome-official, icon, svg, webfont
Requires at least: 4.7
Tested up to: 5.0
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds Font Awesome 5 icons to your WordPress site. Supports Font Awesome Pro. Resolves conflicts across many plugins or themes that use Font Awesome.

== Description ==

Adds Font Awesome 5 icons to your WordPress site. Supports Font Awesome Pro. Resolves conflicts across many plugins or themes that use Font Awesome.

See also the GitHub [README](https://github.com/FortAwesome/wordpress-fontawesome/README.md).

## Features

1. Supports both Font Awesome Free and Font Awesome Pro.

2. Provides easy configuration to enable the new SVG framework with extra features
like [Power Transforms](https://fontawesome.com/how-to-use/on-the-web/styling/power-transforms).

Easily spot and fix conflicts when using SVG would conflict with other plugins or themes
that require the classic Web Fonts & CSS method.

3. Loads icons from the fast Font Awesome Free CDN, or the Font Awesome Pro CDN for [Pro subscribers](https://fontawesome.com/pro).

4. Provides a "v4-shim" to [ease the upgrade from Font Awesome 4 to Font Awesome 5](https://fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4).

5. Developers: supports development of themes and plugins to use Font Awesome without run time conflicts.

Eliminate the headache of various plugins and themes trying to load multiple or incompatible versions of Font Awesome.
Using this plugin provides a common framework for managing Font Awesome dependencies. Rest easy that icons for your templates
will either load like you expect, or else warn the site owner gracefully with clear diagnostics and user-friendly guidance
to resolve conflicts.

6. Prevents "unregistered" themes or plugins from breaking your icons by loading multiple or incompatible versions.

== Installation ==

[Font Awesome Pro](https://fontawesome.com/pro) subscribers who want to enable Pro icons on their WordPress sites, must
first [add their allowed domains](https://fontawesome.com/account/domains) before enabling the "Use Pro" option on the
plugin's settings page.

== Changelog ==

= 0.2.0 =

* Re-implement admin settings page
* More graceful error handling
* Lots of back end code changes to support theme and plugin developers
  * Package plugin as a composer dependency
  * API Changes
  * Comprehensive API documentation
* Cache load specification unless client requirements change
* Improve handling of changing configurations as new plugins or themes are activated, de-activated or updated
* Lock working load specifications and only rebuild when new requirements are conflict-free

= 0.1.0 =

* Re-name identifier slug as font-awesome-official
* Load Font Awesome release version metadata from the fontawesome.com releases API

= 0.0.1 =

* Initial private beta

