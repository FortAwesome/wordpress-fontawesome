=== Font Awesome ===
Contributors: fontawesome, mlwilkerson, robmadole, frrrances, rachelbaker
Stable tag: 4.0.0-rc13
Tags: font, awesome, fontawesome, font-awesome, icon, svg, webfont
Requires at least: 4.7
Tested up to: 5.2.2
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The official way to use Font Awesome Free or Pro icons on your site, brought to you by the Font Awesome team.

== Description ==

The official way to use Font Awesome Free or Pro icons on your site, brought to you by the Font Awesome team.

= New Plugin, Replacing an Old Plugin =

This is a new, completely re-written plugin, tested with the latest WordPress and Font Awesome versions. It replaces the older plugin formerly occupying this space in the WordPress plugins directory, which was no longer being maintained. Many thanks to Rachel Baker and the team behind the former plugin for getting the original plugin started and allowing us to carry it forward.

= Features =

Our plugin lets you use: 

 * Free or Pro icons
 * The latest version of Font Awesome 5 (or a specific previous version)
 * SVG or Web Font to load icons
 * Font Awesome Version 4 syntax if you haven’t had a chance to update your code
 * A kit or the classic Font Awesome CDN

And, you also get a robust way to troubleshoot conflicting versions of Font Awesome loading on your site from other plugins or themes, and gives you tools to fix those conflicts. 


== Usage ==

**Install and enable the plugin**

**Pick some icons**
Find Font Awesome icons for your project in the [Icon Gallery](https://fontawesome.com/icons), or on the [cheatsheet](https://fontawesome.com/cheatsheet).


**Add icons to your pages and posts**
Once you set your plugin to use CDN or a kit, you add icons to your pages and posts with a shortcodes or HTML. Be sure to use the [latest icon names and classes](https://fontawesome.com/icons?d=gallery). 

When you use shortcodes, you add the name of the icon and a prefix, where [the prefix is the style of icon](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use) you want to use. Note that you don’t need to include the `fa-` part of the name. And if you don’t include any prefix, the style will default to Solid. 

The shortcode for an icon looks like this: 

`[icon name="stroopwafel"]`

`[icon name="stroopwafel" prefix="fal"]`

Or you can use basic HTML with [standard Font Awesome syntax](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use):

`<i class="fas fa-stroopwafel"></i>`

**Using Pro Icons and Features**
To enable Pro icons with the CDN, you will need to add your domain to the list allowed domains on your [CDN Settings page](https://fontawesome.com/account/cdn). To configure a kit, get your [API Token from your Font Awesome account page](https://fontawesome.com/account#api-tokens).


**Troubleshooting with the Plugin**
Font Awesome icons are popular, so lots of themes and plugins also load Font Awesome, and sometimes their version can conflict with yours. So we created a way to help you find and prevent those conflicting versions from affecting your icons: **The Conflict Detection Scanner**. 

If the plugin seems to be set up correctly and your icons still aren’t loading and you're not sure why, head over to the Troubleshoot tab, which has two parts: 

* _Detect Conflicts with Other Versions of Font Awesome_ - which lets you start the conflict detection scanner to find versions of Font Awesome loading on your site
* _Versions of Font Awesome Active on Your Site_ - which lists any other versions of Font Awesome being used on your site and lets you prevent conflicting versions from loading

Get more information about using the scanner for troubleshooting on the [WordPress page on Font Awesome](https://fontawesome.com/how-to-use/on-the-web/using-with/wordpress#troubleshooting).


= Configuring =

The plugin is set to serve Font Awesome Free icons as a Web Font via the Font Awesome CDN by default. You can change the CDN settings right in the plugin. In the simplest case, no additional configuration is required. 

You can get more information about all the available settings and troubleshooting on the [WordPress page on Font Awesome](https://fontawesome.com/how-to-use/on-the-web/using-with/wordpress).



= Upgrading from the Old Versions =

If you used the old plugin or are still using Version 3 of Font Awesome, we've tried to smooth the upgrade path for you by keeping `[icon]` shortcode compatibility for Font Awesome 3 names used with the old plugin. But we plan to remove version 3 naming support from this plugin soon so don't wait too long to update your code!


== See Also ==

The [README](https://github.com/FortAwesome/wordpress-fontawesome/blob/master/README.md) on GitHub has some more details for WordPress site owners and developers.

The [API docs](https://fortawesome.github.io/wordpress-fontawesome/) for developers.


== Frequently Asked Questions ==

You can get more information about using the plugin, details for available settings, and frequently asked questions on the [WordPress page on Font Awesome](https://fontawesome.com/how-to-use/on-the-web/using-with/wordpress).


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

= Access Font Awesome Plugin Settings =

Once you activate the Font Awesome plugin, you will see a top-level menu item for Font Awesome in your WordPress admin area, or you can click "Settings" on the plugin's entry on the Plugins page.


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

