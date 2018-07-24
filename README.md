# wordpress-fontawesome

Official Font Awesome WordPress Plugin

> Font Awesome 5 Official WordPress Plugin (status: private beta)

<!-- toc -->

- [Description](#description)
- [Installation](#installation)
- [For End Users](#for-end-users)
  * [Usage: Standalone](#usage-simple-end-user-scenarios)
    * [Zero-configuration](#zero-configuration)
    * [SVG](#svg)
    * [Font Awesome Pro](#font-awesome-pro)
  * [Usage: With Plugins or Themes](#usage-with-plugins-or-themes)
    * [Dealing with Themes or Plugins That Try to Load Their Own Versions of Font Awesome](dealing-with-themes-or-plugins-that-try-to-load-their-own-versions-of-font-awesome)
- [For Developers](#for-developers)
  * [Action Reference](#action-reference)
  * [API Reference](#api-reference)
  * [Requirements Array](#requirements-array)

<!-- tocstop -->

# Description

Loads Font Awesome 5 Free or Pro on your WordPress site. Provides features for developers of themes and other plugins
to register their Font Awesome requirements with this plugin to ensure that a single, working version of Font Awesome
is loaded that works across all WordPress components. Optionally, block some themes or plugins from trying to load
their own versions of Font Awesome which might create conflicts and keep your icons from working correctly.

Supports both Free and Pro, optional use of version 4 compatibility (shims), pseudo-elements, and either the [Webfont
with CSS](https://fontawesome.com/how-to-use/on-the-web/setup/getting-started?using=web-fonts-with-css) or
[SVG with JavaScript](https://fontawesome.com/how-to-use/on-the-web/setup/getting-started?using=svg-with-js) method.

Loads Font Awesome from the official Font Awesome Free or Pro CDN.

## Installation

1. Download the [latest release](https://github.com/FortAwesome/wordpress-fontawesome/releases/latest) of `font-awesome.zip`
1. In the WordPress admin dashboard "Add Plugins" page, click "Upload Plugin" and upload that `font-awesome.zip`
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->Font Awesome screen to configure the plugin

# For End Users

## Usage: Standalone

Suppose you have no themes or plugins activated that use this Font Awesome plugin. It's just you, looking to
add icons to your WordPress site.

### Zero-configuration

Simply install and activate the plugin.
It will load sensible defaults for the latest version of Font Awesome 5 Free:
- Webfont with CSS method
- Version 4 compatibility (aka "v4shims")

Then just start adding Font Awesome HTML markup to your posts, pages, and templates.
Refer to our documentation for [basic usage](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use),
and for more fancy usage like [Stacked Icons](https://fontawesome.com/how-to-use/on-the-web/styling/stacking-icons).

Look up available icons in our searchable [Icon Gallery](https://fontawesome.com/icons)
or [Cheatsheet](https://fontawesome.com/cheatsheet).

The admin settings page for this plugin won't be very complicated in this scenario, since no other WordPress components
are using the plugin to provide icons. But that also means you can change the version and features settings to your
heart's content without creating in any conflicts with other components' requirements.

### SVG

Again, suppose there are no other components (plugins or theme) that depend upon this plugin to load Font Awesome.
It's just you, the web site owner, and you want to use SVG icons, and maybe some of the fancier features that come with them.

In the plugin's settings page, on the "Method" dropdown menu, select "svg" instead of "webfont". Save those changes.
That's it!

Now, your icons will render as SVG. You won't need to change any of the HTML markup (like the `<i>` tags you might have
already used under the webfont method).

You now can use some of the fancier features, like [Layering, Text, and Counters](https://fontawesome.com/how-to-use/on-the-web/styling/layering).

### Font Awesome Pro

Suppose you've purchased Font Awesome Pro. To enable those Pro icons on your web site, it's just two steps:

1. Login to your fontawesome.com account and go to the [Services](https://fontawesome.com/account/services) page.
   Add any web domains where you'll use the icons. This is a "white list". It tells our server that if the icons
   are being loaded from any of these web sites, it's OK to load them as long as your account is active.

2. Go to the plugin settings page and click the checkbox next to "Pro". Save that change.

That's it! Add Pro icons anywhere on your site.

## Usage: With Plugins or Themes

Suppose you've installed a theme called "Radiance" and a plugin called "Shuffle" and that each of them depend
on this plugin for their icons.

You don't do anything to configure them to work together. Rather, they use this plugin's API to register
their own requirements.

On the plugin's settings page, you can see in the "Current Requirements" section what Font Awesome
requirements Radiance and Shuffle have. If they have conflicting requirements, you'll see a simple
error message to help you diagnose and resolve the problem.

For example, suppose Radiance says it requires Font Awesome version 5.1.0 or later, but Shuffle
says it requires version 5.0.13. Well, we can't satisfy both, and we can't just load both
versions--one for each of them--because that would break all of your icons. You can only load one
version of Font Awesome at a time.

Instead, you'll see an error message that clearly shows which requirement
is causing a conflict. You might resolve the problem by doing any or all of the following:

1. Deactivate the Shuffle plugin
1. Choose a different theme
1. Contact the developers of Radiance or Shuffle to suggest that they change their requirements to
   reduce conflicts

While that might be a little bit of a hassle, at least it's clear and obvious and you know who to go to
to resolve the problem. Not like the lawless days when every plugin and theme tried to load its own version
of Font Awesome and everyone crossed their fingers hoping it just worked, and when it didn't,
you weren't sure why.

Now suppose that Radiance and Shuffle have compatible requirements, and that they make no
particular requirement about the method---i.e. they're content with either webfont or svg. Well, then,
if you as the web site owner prefer to use SVG, just make that selection and save those changes.
Your SVG requirement will satisfy Radiance, Shuffle, and your own preference. Anywhere that you
or those components place icons, they'll be rendered as SVG.

### Dealing with Themes or Plugins That Try to Load Their Own Versions of Font Awesome

Check the box next to "Remove Unregistered Clients" to try to stop other plugins or themes from loading
unregistered (and therefore conflicting) versions of Font Awesome.

There are lots of themes and plugins out there that use Font Awesome. Normally, they load their own
version. This works fine if they are the only component that uses Font Awesome, or if it just happens
to be the case _their_ version is the same as the version loaded by other plugins you may have
installed (but even then, your web site could end up loading multiple instances of the same version,
which is unnecessary, and bad for your web site's performance.)

Perhaps, one day, any plugin you'd want to use that depends on Font Awesome will be compatible with this plugin.
All your icon version compatibility problems would disappear. In the meantime, we can attempt to
stop those other themes or plugins from trying to load their own versions of Font Awesome,
while still allowing them to display their icons as expected. Since there are lots of ways to load Font Awesome,
there's no guarantee that our approach will work for discovering and stopping unregistered clients from
loading their own versions. But we can try, and most of the time, we expect it to succeed.

# For Developers

## Action Reference

| Action | Description |
| ----------- | ----------- |
| `font_awesome_requirements` | Called when the Font Awesome plugin expects clients to register their requirements. Normally, the culmination of the action hook is to call `FontAwesome()->register($requirements_array)` |
| `font_awesome_enqueued` | Called when version resolution succeeds, with up to one argument, an associative array indicating the final load specification: version, method (webfont vs. svg), version 4 compatibility, license (pro vs. free), pseudo-element support. This is how a theme or plugin can be notified whether Pro is enabled, for example. |
| `font_awesome_failed` | Called when version resolution fails, with up to one argument, an associate array indicating which conflicting requirement between which clients caused resolution to fail. |

## API Reference

| Method | Description |
| ------ | ----------- |
| `FontAwesome()` | returns the singleton instance for the plugin. All other function calls are methods invoked on this instance. |
| `register($requirements_array)` | call this from a client (plugin or theme) to register [requirements](#requirements-array).|
| `using_pro()` | returns `boolean` indicating whether Pro is enabled |
| `using_pseudo_elements()` | returns `boolean` indicating whether pseudo-element support is enabled |

## Requirements Array

The requirements array supplied to `register()` looks like this:
```php
array(
  "name"            => "plugin-name", // This is the only required attribute.
                                      // Ideally, it's the same as the theme or plugin slug.
  "version"         => "^5.0.0",      // A semver string. Uses composer/semver
  "method"          => "webfont",     // webfont | svg
  "v4shim"          => "require",     // require | forbid
  "pseudo-elements" => "require"      // require | forbid
);
```

### Notes on Requirement Attributes

- `v4shim`: There were major changes between Font Awesome 4 and Font Awesome 5, including some re-named icons.
  It's best to upgrade name references to the version 5 names, but to [ease the upgrade path](https://fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4),
  we also provide
  v4 shims which accept the v4 names and translate them into the equivalent v5 names. Shims for SVG with JavaScript
  have been available since `5.0.0` and shims for Web Font with CSS have been available since `5.1.0`.
  Specifiying `require` for this attribute will cause the loading of Font Awesome to fail unless loading the v4 shims
  would satisfy the requirements of all registered clients. Specify `forbid` to insist that the v4 shim should _not_
  be loaded by any client--normally you should mind your own business, though.

- `pseudo-elements`: [Pseudo-elements](https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements)
  are always intrinsically available when using the Web Font with CSS method.
  However, for the SVG with JavaScript method, additional functionality must be enabled. It's not a recommended
  approach, because the performance can be poor. _Really_ poor, in some cases. However, sometimes, it's necessary.

# Temporary Plugin Name Conflict

This plugin currently uses the same namespace as [this obsolete plugin](https://wordpress.org/plugins/font-awesome/)
in the WordPress Plugins Directory. This plugin has not yet been published in the plugins directory, but must
be installed manually or by uploading the zip file in this repository. It will not clash with that other plugin
unless you attempt to install that other plugin. However, after installing this
plugin--on the plugins page--WordPress may alert you that there is an update available.
If so, that's only because the update notifier is finding the obsolete plugin by the same
name in the directory and suggesting that it is a new version. Just ignore that "update available"
notification. Before we do a final release and publish this plugin to the plugins directory, we'll
be giving it a new name.

# Frequently Asked Questions

## Does the plugin support shortcodes?

Not yet. But [basic usage](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use)
with `<i>` tags is pretty straightforward.
