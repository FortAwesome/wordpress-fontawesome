# wordpress-fontawesome

> Font Awesome 5 Official WordPress Plugin

<!-- toc -->

- [Description](#description)
- [Installation](#installation)
- [For End Users](#for-end-users)
  * [Add Icons with Shortcodes or `<i>` Tags](#add-icons-with-shortcodes-or-i-tags)
    * [Additional Features with Additional Classes](#additional-features-with-additional-classes)
    * [Shortcode Limitations](#shortcode-limitations)
  * [Usage: Standalone](#usage-simple-end-user-scenarios)
    * [Zero-configuration](#zero-configuration)
    * [SVG](#svg)
    * [Font Awesome Pro](#font-awesome-pro)
  * [Usage: When Other Plugins or Themes also use this Font Awesome Plugin](#usage-when-other-plugins-or-themes-also-use-this-font-awesome-plugin)
    * [Dealing with Themes or Plugins That Try to Load Their Own Versions of Font Awesome](#dealing-with-themes-or-plugins-that-try-to-load-their-own-versions-of-font-awesome)
- [For Developers](#for-developers)
  * [Install as Composer Dependency](#install-as-composer-dependency)
  * [API Reference](#api-reference)
  * [What is Actually Loaded](#what-is-actually-loaded)
  * [Determining Available Versions](#determining-available-versions)
  * [Caching the Load Specification](#caching-the-load-specification)
  * [How to Ship Your Theme or Plugin To Work with Font Awesome](#how-to-ship-your-theme-or-plugin-to-work-with-font-awesome)
    * [Don't Ship Font Awesome Assets](#dont-ship-font-awesome-assets)
    * [Detect and Warn When the Font Awesome Plugin Version Doesn't Match Your Requirements](#detect-and-warn-when-the-font-awesome-plugin-version-doesnt-match-your-requirements)
  * [How to Make Pro Icons Available in Your Theme or Plugin](#how-to-make-pro-icons-available-in-your-theme-or-plugin)
  * [Examples](#examples)

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

## Installation

To install directly as a WordPress plugin:

Follow [installation instructions in the plugin directory](https://wordpress.org/plugins/font-awesome/#installation).

For instructions on adding this as a composer package to install with your theme or plugin,
see [Install as Composer Dependency](#install-as-composer-dependency))

# For End Users

## Add Icons with Shortcodes or <i> Tags

You can place an icon in a post, page, or widget using a shortcode:
```
[icon name="coffee"]
```

or straight HTML with an `<i>` tag:

```html
<i class="fas fa-coffee"></i>
```

Font Awesome 5 icon names and classes should be used.

When using HTML, you can access the full range of capabilities described on [fontawesome.com](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use).

When using shortcodes, the default style prefix is `fas`, Font Awesome _Solid_

You can specify a different style prefix like this:
 
```
[icon name="bell" prefix="far"]
```

The `far` prefix is for the Font Awesome _Regular_ style.

Notice that in the shortcode, the `name` is just the Font Awesome 5 _name_ of the icon, but when you use
the HTML `<i>` tag notation, you specify the icon in terms of its CSS class, which just means prepending the `fa-`.

So the _name_ of the icon is `bell`, but the CSS class is `fa-bell`.  

### Additional Features with Additional Classes

Many [Font Awesome features](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use) are available simply by additional additional CSS classes:
* size
* fixed-width
* rotation
* animation
* border
* ...and more

You can add any of those classes through the shortcode like this:

```
[icon name="coffee" class="fa-2x fa-rotate-180"]
``` 

This makes the coffee icon bigger, and upside down.

### Shortcode Limitations

For now, if you want to do even fancier things like...
* [masking](https://fontawesome.com/how-to-use/on-the-web/styling/masking)
* [layering](https://fontawesome.com/how-to-use/on-the-web/styling/layering)
* [power transforms](https://fontawesome.com/how-to-use/on-the-web/styling/power-transforms)

...you'll need to use straight HTML, as shown in the documentation on fontawesome.com.

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

You can get to the plugin's options page in WordPress admin by clicking "Font Awesome" under the "Settings" menu,
or clicking "Settings" on the plugin's entry in the list of plugins.

This options page won't be very complicated in this scenario, since no other WordPress components
are using the plugin. Therefore, you could change the version and features settings on the options page to your
heart's content without creating any conflicts with other components' requirements.

Consider a few configuration scenarios...

### SVG

Again, suppose there are no other components (plugins or theme) that depend upon this plugin to load Font Awesome.
It's just you, the web site owner, and you want to use SVG icons, and maybe some of the fancier features that come with them.

In the plugin's options page, on the "Method" dropdown menu, select "svg" instead of "webfont". Save those changes.
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

## Usage: When Other Plugins or Themes also use this Font Awesome Plugin

Suppose you've installed a theme called "Radiance" and a plugin called "Shuffle" and that each of them depend
on this plugin for their icons.

You don't need to do anything to configure them to work together. Rather, they use this plugin's API behind the scenes
to register their own requirements, like whether they require a specific version of Font Awesome, or particular
feature, like [pseudo-elements](https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements).

On the plugin's options page, you can see in the "Client Requirements" section what Font Awesome
requirements Radiance and Shuffle have. If they have conflicting requirements, you'll see a simple
error message to help you diagnose and resolve the problem.

For example, suppose Radiance says it requires Font Awesome version 5.1.0 or later, but Shuffle
says it requires version 5.0.13. Well, we can't satisfy both, and we can't just load both
versions--one for each of them--because that could cause strange behavior, like breaking some or all of your icons.
You can only load one version of Font Awesome at a time.

Instead, you'll see an error message that clearly shows which requirement
is causing a conflict. You might resolve the problem by doing any or all of the following:

1. Deactivate the Shuffle plugin
1. Choose a different theme
1. Contact the developers of Radiance or Shuffle to suggest that they change their requirements to
   reduce conflicts

While that might be a little bit of a hassle, at least it's clear and obvious and you know who to go to
to resolve the problem. Not like the lawless days when every plugin and theme tried to load its own version
of Font Awesome and everyone crossed their fingers hoping it just worked, and when it didn't,
weren't sure why.

Now suppose that Radiance and Shuffle have compatible requirements, and that they make no
particular requirement about the method---that is, they're content with either webfont or svg. Well, then,
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

## Install as Composer Dependency

Developers and ship this plugin as a dependency of their own plugins or themes. The advantage of doing so is to simplify
the installation of your component for your users. Those users do not need to separately install the Font Awesome plugin.

The plugin uses the Singleton pattern to ensure that only one instance is loaded at any given time. So multiple
themes and plugins that each ship the Font Awesome plugin as their own composer dependency can be activated together
and still only one instance of the Font Awesome plugin will be loaded. They'll all use that one.

An advantage of this approach is that you can be sure that the Font Awesome plugin will be there when your code needs
it, without creating conflicts with other plugins and themes, and you can avoid asking your users to install
the Font Awesome plugin separately.

One caveat with this approach is that it's possible that the version of the Font Awesome plugin that is active when
your code runs may not be the version you included in your composer bundle. It may be the version included in some
_other_ plugin's bundle, which happens to load before yours and takes the Singleton slot.

One way to handle this is to use `FontAwesome::PLUGIN_VERSION`, `satisfies()` and `satisfies_or_warn()` methods to react appropriately to unmet
plugin version requirements.

Unfortunately, there's no way to guarantee exactly what will be loaded at runtime: such is the nature of WordPress's
pluggable nature. The best we can do is to try and provide an API that gives both developers and site owners more
control and transparency into what's going on so that diagnosis and fixing of conflicts can be handled more
straightforwardly. And hopefully, this plugin helps those conflicts to occur far less often in the first place.

## API Reference

[See API docs](https://fortawesome.github.io/wordpress-fontawesome/index.html)

## What is Actually Loaded

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

## Determining Available Versions

We have made a REST API endpoint available on `fontawesome.com` which this plugin uses to retrieve up-to-date metadata about available releases.

## Caching the Load Specification

This plugin computes a [_load specification_](https://fortawesome.github.io/wordpress-fontawesome/classes/FontAwesome.html#method_load_spec), 
which is the set of version and configuration options that satisfy the requirements of all registered components.

To compute that requires retrieving the latest metadata about Font Awesome releases from a REST API on fontawesome.com
and reducing all of the requirements registered by all clients of this Font Awesome plugin.

We don't need to do all of that work on every page load. Once a load specification is computed, it will not change until
the web site owner changes options on the options page. When this plugin computes a successful load specification,
it stores it under an [options key](https://fortawesome.github.io/wordpress-fontawesome/classes/FontAwesome.html#constant_OPTIONS_KEY)
in the WordPress database and then re-uses that load specification for each page load. In that case, it will not fetch
metadata from fontawesome.com nor process the requirements from registered clients.

## How to Ship Your Theme or Plugin To Work with Font Awesome

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

### Don't Ship Font Awesome Assets

In any case, you would not ship any Font Awesome assets (no web font, CSS, JavaScript, or SVG files).
Rather, you'd rely on this plugin to load the correct assets from the appropriate CDN with the appropriate
configuration.

In the case of Font Awesome Pro, it would be a violation of the license terms to ship Pro assets, so that's
a no-go no  matter what. In the case of Font Awesome Free, while the license would support redistribution
of those assets in your plugin or theme, doing so would defeat one of the chief goals of this plugin:
to create a conflict-free experience of loading Font Awesome, both for developers and site owners.
If you ship and load your own Font Awesome assets, you might just end up being the bad citizen whose code
breaks other components.

### Detect and Warn When the Font Awesome Plugin Version Doesn't Match Your Requirements  

Remember there are two different versions that you care about:

1. The version of Font Awesome itself: the assets that this plugin is trying to load correctly into WordPress pages.

1. The version of this plugin.

When the API of the _plugin_ changes and your code expects a different version of this plugin than is active
at the time your code tries to use it, it could cause your code to break. So rather than assuming that the plugin
version active at runtime is the same as the version you were expecting, you can detect the version and react
appropriately. If your code needs to work in some alternate way, including maybe refusing to activate, you can
use `satisfies_or_warn()` to alert the site owner in the admin dashboard.

## How to Make Pro Icons Available in Your Theme or Plugin

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

## Examples

There are several clients in this GitHub repo that demonstrate how your code can use this plugin:

| Component | Description |
| --------- | ----------- |
| <span style="white-space:nowrap;">[`integrations/themes/theme-alpha`](https://github.com/FortAwesome/wordpress-fontawesome/tree/master/integrations/themes/theme-alpha)</span> | Theme accepts default requirements, but also reacts to the presence of Pro by using Pro icons in a template. |
| <span style="white-space:nowrap;">[`integrations/plugins/plugin-beta`](https://github.com/FortAwesome/wordpress-fontawesome/tree/master/integrations/plugins/plugin-beta)</span> | Plugin requires v4shim and a specific version. Uses some version 4 icon names. |
| <span style="white-space:nowrap;">[`integrations/plugins/plugin-sigma`](https://github.com/FortAwesome/wordpress-fontawesome/tree/master/integrations/plugins/plugin-sigma)</span> | Registered Client embedding Font Awesome as a composer dependency. When this plugin is activated, Font Awesome is implicitly activated, whether or not the Font Awesome plugin is directly installed or activated. |

See [DEVELOPMENT.md](https://github.com/FortAwesome/wordpress-fontawesome/blob/master/DEVELOPMENT.md) for instructions on how you can run a dockerized WordPress environment and experiment
with these examples.


