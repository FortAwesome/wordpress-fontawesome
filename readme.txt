=== Font Awesome ===
Contributors: mlwilkerson
Tags: font, awesome, fontawesome, icon, svg
Requires at least: 4.9.6
Tested up to: 4.9.6
Requires PHP: 7.2.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Loads Font Awesome 5 Free or Pro, managing version resolution across multiple client themes or plugins.

== Description ==

Loads Font Awesome 5 Free or Pro on your WordPress site. Provides features for developers of themes and other plugins
to register their Font Awesome requirements with this plugin to ensure that a single, working version of Font Awesome
is loaded that works across all WordPress components. Optionally, block some themes or plugins from trying to load
their own versions of Font Awesome which might create conflicts and keep your icons from working correctly.

Supports both Free and Pro, option use of version 4 compatibility (shims), pseudo-elements, and either the [Webfont
with CSS](https://fontawesome.com/how-to-use/on-the-web/setup/getting-started?using=web-fonts-with-css) or
[SVG with JavaScript](https://fontawesome.com/how-to-use/on-the-web/setup/getting-started?using=svg-with-js) method.

Loads Font Awesome from the official Font Awesome Free or Pro CDN.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/font-awesome` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->Font Awesome screen to configure the plugin

== Frequently Asked Questions ==

= How can I use Font Awesome Pro with this plugin? =

1. Log in to your `fontawesome.com` account to add your web domain to your list of
[Pro CDN Domains](https://fontawesome.com/account/services). NOTE: make sure to include any domains you use for local
 development or staging. Each unique domain must be registered.
1. On the plugin's settings page, check the box to enable Pro.

== Changelog ==

= 0.0.1 =
* Initial private beta.

