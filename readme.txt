=== Font Awesome ===
Contributors: fontawesome, mlwilkerson, robmadole, rachelbaker
Stable tag: 4.0.0-rc13
Tags: font, awesome, fontawesome, font-awesome, icon, svg, webfont
Requires at least: 4.7
Tested up to: 5.2.2
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds Font Awesome 5 icons to your WordPress site. Supports Font Awesome Pro. Resolves conflicts across many plugins or themes that use Font Awesome.

== Description ==

Adds Font Awesome 5 icons to your WordPress site. Supports Font Awesome Pro. Resolves conflicts across many plugins or themes that use Font Awesome.

This is the official plugin from the Font Awesome team.

= New Plugin, Replacing an Old Plugin =

This is a new, completely re-written plugin, tested with the latest WordPress and Font Awesome versions. It replaces the older plugin formerly occupying this space in the WordPress plugins directory, which was no longer being maintained.

Thanks to Rachel Baker and the team behind the former plugin for getting something started and allowing us to carry it forward.

We've built in some magic to help users of the old plugin experience a smooth upgrade path. We think you'll love Font Awesome 5!

= Features =

1. Supports both Font Awesome Free and Font Awesome Pro.

2. Gets new icon updates directly from fontawesome.com right when they're released, ready to add to your site as soon as you like. New icons are released regularly.

3. Provides easy configuration to enable the new SVG framework with extra features like [Power Transforms](https://fontawesome.com/how-to-use/on-the-web/styling/power-transforms).

  Easily spot and fix conflicts when using SVG would conflict with other plugins or themes that require the classic Web Fonts & CSS method.

4. Loads icons from the fast Font Awesome Free CDN, or the Font Awesome Pro CDN for [Pro subscribers](https://fontawesome.com/pro).

5. Provides a "v4-shim" to [ease the upgrade from Font Awesome 4 to Font Awesome 5](https://fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4).

6. Developers: supports development of themes and plugins to use Font Awesome without run time conflicts.

  Eliminate the headache of various plugins and themes trying to load multiple or incompatible versions of Font Awesome.

  Using this plugin provides a common framework for managing Font Awesome dependencies. Rest easy that icons for your templates will either load like you expect, or else warn the site owner gracefully with clear diagnostics and user-friendly guidance to resolve conflicts.

  See also: [API docs](https://fortawesome.github.io/wordpress-fontawesome/)

7. Prevents "unregistered" themes or plugins from breaking your icons by loading multiple or incompatible versions.

== Usage ==

Find icons for your version of Font Awesome in the [Icon Gallery](https://fontawesome.com/icons), or on the [cheatsheet](https://fontawesome.com/cheatsheet).

*HTML*

The stroopwafel icon in the Solid (fas) style:

`<i class="fas fa-stroopwafel"></i>`

[All Font Awesome features](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use) are available when using HTML, including advanced features only available using the SVG with JavaScript, such as [Power Transforms](https://fontawesome.com/how-to-use/on-the-web/styling/power-transforms).

You can enable SVG in the admin settings page.

Notice that we use the icon's CSS class here, `fa-stroopwafel`, rather than its plain name.

*Shortcode*

`[icon name="stroopwafel"]`

Notice we're just using the _name_ of the icon here (`stroopwafel`), as you'd find in the [Icon Gallery](https://fontawesome.com/icons), not its CSS class (`fa-stroopwafel`).

By default, the `fas` style prefix (for the Solid style) will be used. To specify a different prefix, use the `prefix` attribute. This shows the same icon in the Light style (`fal`), available in Font Awesome Pro.

`[icon name="stroopwafel" prefix="fal"]`

= Configuring =

Activating this plugin will use a default configuration that loads the latest available version of Font Awesome using the webfont method from the Font Awesome Free CDN. In the simplest case, no additional configuration is required.

Here's what you can currently configure on the admin settings page:

- Version

  New releases of Font Awesome may include changes to the framework, or new icons. Framework changes might include fixes or enhancements to the JavaScript that runs in the browser to render SVG icons, for example.

  Once we release a new version of Font Awesome, a simple re-load of this plugin's admin page will show that new version being available in the version dropdown. Select the new version and save your settings.

  If for some reason you know you need to lock your Font Awesome version back to some other version that's available in the dropdown, just select it and save the settings.

- Method

  Options: `svg` or `webfont`

  Font Awesome 5 is available via two different implementation methods: Webfont with CSS, or SVG with JavaScript. If you're not sure of the difference, or don't know why you'd need to use SVG, then sticking with the default webfont method is probably easiest.

  There are some extra features available only in SVG/JS, though, like [Power Transforms](https://fontawesome.com/how-to-use/on-the-web/styling/power-transforms).

- Pseudo-elements (`::before`)

  Options: `require` or `forbid`

  [CSS Pseudo-elements](https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements) are a way to use CSS to add icons to a page when you can't otherwise control the page's content. You define a rule in your CSS with `::before`.

  Because pseudo-elements is just a feature of CSS, they work implicitly when you're using Font Awesome via the webfont method.

  However, it requires a little extra magic to get pseudo-elements working with SVG/JS. Sometimes, the performance trade-off isn't worth it. So when using SVG/JS, pseudo-elements are _not_ enabled by default, but you (or another client) can still `require` them. If you (or another client) feel sure that enabling pseudo-elements with SVG would be a disaster, then `forbid` can also be chosen to prevent said disaster.

- Version 4 Compatibility (aka "v4shims")

  Options: `require` or `forbid`

  There are quite a few icon name changes, and some changes in icon style, that occurred between Font Awesome major versions 4 and 5. It's best to update them to the version 5 names whenever possible. But to ease the upgrade path, version 4 shims are available.

  These are enabled by default, but can be disabled by selecting `forbid`.

- Use Pro

  [Font Awesome Pro](https://fontawesome.com/pro) gets you lots more icons, services, and support, and a steady stream of new icons when you have an active subscription. One of those Pro services is our Pro CDN. To load Font Awesome from the Pro CDN, including all the Pro icons, check "Use Pro" on the admin settings page.

  You'll need to first make sure you've configured your [allowed CDN domains in your fontawesome.com account settings](https://fontawesome.com/account/cdn).

- Remove Unregistered Clients

  "Unregistered clients" include any themes or plugins that attempt to load their own versions of Font Awesome using the normal means of loading JavaScripts or stylesheets in WordPress.

  If this plugin detects them, it will display them on the admin settings page. Checking the box to "Remove unregistered clients" just blocks their attempt to load a conflicting version of Font Awesome but does not otherwise interfere with their functioning. Most of the time, the version _you_ want to load will work just fine for them. So this option is intended to both _allow_ those unregistered clients to continue working as intended, while stopping them from breaking the rest of your icons.

  But, your mileage may vary. Since those clients haven't registered their requirements with this plugin, we can't be sure what they really require in order to work as intended. You could enable this option and then view the outputs of those clients. If they seem to look as expected, great. If not, try enabling the v4shims in case the unregistered client expects to be able to use version 4 icon names.

= Understanding Many Clients with Various Requirements =

Our hope is that other themes and plugins will use this framework to register their Font Awesome requirements, to ensure that icons are working across all of your posts and pages, including content from those themes or plugins.

On the admin settings page, you'll see the list of clients that have registered Font Awesome requirements. Think of yourself, the web site owner, as one of those clients. You set your Font Awesome requirements using the admin settings page. Any other clients--plugins or themes--use our API (under the hood) to register their requirements. You'll see all of them show up on the admin settings page, giving you a dashboard overview of what everyone's up to.

This plugin loads a version and configuration of Font Awesome that is conflict-free across all client requirements. Unless those requirements include a version constraint, it loads the latest available by default. So you can change the configuration options from the admin settings page to your heart's content, as long as you don't introduce conflicts with other clients' requirements. If you're the only client, then the world is your oyster.

For example, if you install a plugin that requires the svg method, then as long as you have that other plugin activated, you won't be able to require the webfont method without introducing a conflict between _your_ requirements and that other plugin's requirements. It's gotta be one or the other. If you try it, you'll be presented with a warning and some clear diagnostics in the admin settings page. And, by the way, it won't break the icons on your site if you try something and it introduces a conflict. This plugin will only lock and load a conflict-free configuration. Any conflicts are reported for you to troubleshoot on the admin settings page.

## Upgrading from the Old Plugin

If you've been a user of previous versions of this plugin, you'll eventually need to update your `[icon]` shortcodes to use Font Awesome 5 names instead of the out-dated Font Awesome 3 names used with the old plugin.

We've tried to smooth the upgrade path for you by keeping that shortcode compatible with Font Awesome 3 names you're used to, while magically transforming them into their Font Awesome 5 equivalents on the fly. You'll still need to change your icon shortcodes in pages, posts, and templates. But our upgrade magic gives you some cushion to take a more leisurely pace. We plan to remove version 3 naming support, and the magic, from this plugin in upcoming releases, though, so don't wait too long!

Note that this automatic translation of version 3 icon names to version 5 icon names will only occur where you've used the `[icon]` shortcode. If you've directly used `<i>` tags to reference version 3 icons, like `<i class="icon-calendar"></i>`, you'll need to manually revise those to use version 5 names.

== See Also ==

The [README](https://github.com/FortAwesome/wordpress-fontawesome/blob/master/README.md) on GitHub has some more details for WordPress site owners and developers.

The [API docs](https://fortawesome.github.io/wordpress-fontawesome/) for developers.

== Upgrade Notice ==

= 4.0.0-rc1 =

New plugin, replacing the old one. Font Awesome 3 icon names are being phased out, with a gradual upgrade path.

== Installation ==

= From the Plugins Directory in WordPress Admin =

From the "Add Plugins" page in WordPress admin:

1. Search the plugins directory by `author: fontawesome`

2. Click "Install" on this plugin in the search results

3. Click "Activate"

= Installing a Zip Archive =

1. Click Download on this plugin's directory entry to get the `.zip` file

2. On the "Add Plugins" page in WordPress admin, click "Upload Plugin" and choose that `.zip` file

= Access Font Awesome Settings =

Find the Font Awesome admin settings page either under the "Settings" menu on the left navigation panel in WordPress admin, or click "Settings" on the plugin's entry in the list of plugins on the "Plugins" page.

= Additional Setup for Font Awesome Pro =

[Font Awesome Pro](https://fontawesome.com/pro) subscribers who want to enable Pro icons on their WordPress sites, must first [add their allowed domains](https://fontawesome.com/account/domains) before enabling the "Use Pro" option on the plugin's settings page.

== Changelog ==

= 4.0.0-rc13 =

* Improve diagnostic output for unhandled errors.

= 4.0.0-rc12 =

* Bug fix: Fix loading of admin page assets when removal of unregistered clients is enabled. This bug has been
  hiding under a rock for a while. rc11 turned over the rock, and this bug scurried out.

= 4.0.0-rc11 =

* Bug fix: enqueue Font Awesome assets in admin and login areas, not just in the front end

= 4.0.0-rc10 =

* Attempt to fix a problem where the admin settings is sometimes being confused by unexpected output from the WordPress
  server. This condition has been reported when certain other plugins are active, and (possibly) when PHP output
  buffering works differently than this plugin expects.

= 4.0.0-rc9 =

* Enhance Font Awesome version 4 compatibility: add shimming of the version 4 font-family to enable version 4
  icons defined as pseudo-elements to be rendered via the version of Font Awesome 5 loaded by this plugin.

* Add warnings to the admin UI to indicate that using svg and pseudo-elements may result in slow performance,
  and that svg with pseudo-elements and version 4 compatibility is not supported at all.

= 4.0.0-rc8 =

* Remove dependence on third party libraries, eliminating a class of potential conflicts with other plugins.

* Breaking changes to the API used by theme and plugin developers (no breaking changes for WordPress site owners).
  See [commit log](https://github.com/FortAwesome/wordpress-fontawesome/commit/80f973b4a0f6ac09cbb4dc3ecc1ae2964ef01d32)

= 4.0.0-rc7 =

* Fix detection and removal of unregistered clients by changing the internal resource name this plugin uses to enqueue its resource.
  Change it to something unlikely to be used by other themes or plugins.

= 4.0.0-rc6 =

* Fix error when updating options on admin page: handle null releaseProviderStatus in cases where the release provider
  does not have to make a network request to update release metadata.

= 4.0.0-rc5 =

* Remove tilde character from JavaScript filenames to avoid violating some URL security rules

= 4.0.0-rc4 =

* Cache releases data in the WordPress database to reduce the number of server-side network requests.

* Ensure that releases data are always loaded fresh from fontawesome.com when loading the admin
  settings page so site owners can see when new versions are available.

* Add more specific error message on admin dashboard in the event that the WordPress server is not able to
  reach fontawesome.com in order to get an initial set of available releases data.

= 4.0.0-rc3 =

* Add missing v3 shim file

= 4.0.0-rc2 =

* Fix handling of v3 deprecation warnings in admin settings page

= 4.0.0-rc1 =

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

