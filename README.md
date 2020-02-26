# wordpress-fontawesome

> Font Awesome 5 Official WordPress Plugin

<!-- toc -->

- [Description](#description)
- [Install as Composer Dependency](#install-as-composer-dependency)
- [API Reference](#api-reference)
- [What is Actually Loaded](#what-is-actually-loaded)
- [Determining Available Versions](#determining-available-versions)
- [Caching the Load Specification](#caching-the-load-specification)
- [How to Ship Your Theme or Plugin To Work with Font Awesome](#how-to-ship-your-theme-or-plugin-to-work-with-font-awesome)
    * [Don't Ship Font Awesome Assets](#dont-ship-font-awesome-assets)
    * [Detect and Warn When the Font Awesome Plugin Version Doesn't Match Your Requirements](#detect-and-warn-when-the-font-awesome-plugin-version-doesnt-match-your-requirements)
- [How to Make Pro Icons Available in Your Theme or Plugin](#how-to-make-pro-icons-available-in-your-theme-or-plugin)
- [Examples](#examples)

<!-- tocstop -->

# Description

Loads Font Awesome 5 Free or Pro on your WordPress site. Provides features for developers of themes and other plugins
to register their Font Awesome requirements with this plugin to ensure that a single, working version of Font Awesome
is loaded that works across all WordPress components. Optionally, block some themes or plugins from trying to load
their own versions of Font Awesome which might create conflicts and keep your icons from working correctly.

May be installed by WordPress site owners as a normal WordPress plugin, or shipped by developers as a composer
dependency in their vendor bundles.

Supports both Free and Pro, optional use of version 4 compatibility (shims), pseudo-elements, and either the Webfont
with CSS or SVG with Javascript method. The [Start page on fontawesome.com](https://fontawesome.com/start) describes
the differences.

Loads Font Awesome from the official Font Awesome Free or Pro CDN.


# Install as Composer Dependency

Developers can ship this plugin as a dependency of their own plugins or themes. The advantage of doing so is to simplify
the installation of your component for your users. Those users do not need to separately install the Font Awesome plugin.

The plugin uses the Singleton pattern to ensure that only one instance is loaded at any given time. So multiple
themes and plugins that each ship the Font Awesome plugin as their own composer dependency can be activated together
and still only one instance of the Font Awesome plugin will be loaded. They'll all use that one.

An advantage of this approach is that you can be sure that the Font Awesome plugin will be there when your code needs
it, without creating conflicts with other plugins and themes, and you can avoid asking your users to install
the Font Awesome plugin separately.

One caveat with this approach is that it's possible that the version of the Font Awesome plugin that is active when
your code runs may not be the version you included in your composer bundle. It may be the version included in some
_other_ plugin's bundle.

The `FontAwesome_Loader` class ensures that the plugin code with the latest semantic version wins.

# API Reference

[See API docs](https://fortawesome.github.io/wordpress-fontawesome/index.html)

# What is Actually Loaded

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


