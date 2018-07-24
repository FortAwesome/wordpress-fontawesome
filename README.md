# Official Font Awesome WordPress Plugin

Loads Font Awesome 5 Free or Pro on your WordPress site. Provides features for developers of themes and other plugins
to register their Font Awesome requirements with this plugin to ensure that a single, working version of Font Awesome
is loaded that works across all WordPress components. Optionally, block some themes or plugins from trying to load
their own versions of Font Awesome which might create conflicts and keep your icons from working correctly.

Supports both Free and Pro, optional use of version 4 compatibility (shims), pseudo-elements, and either the [Webfont
with CSS](https://fontawesome.com/how-to-use/on-the-web/setup/getting-started?using=web-fonts-with-css) or
[SVG with JavaScript](https://fontawesome.com/how-to-use/on-the-web/setup/getting-started?using=svg-with-js) method.

Loads Font Awesome from the official Font Awesome Free or Pro CDN.

## Installation

1. Upload the plugin files to the `/wp-content/plugins/font-awesome` directory,
   or install the plugin zip file through the WordPress plugins screen directly (upload).
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->Font Awesome screen to configure the plugin

## Usage (Simple)

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

## Usage (With Plugins or Themes)

Suppose you've installed a theme called "Radiance" and a plugin called "Shuffle" and that each of them depend
on this plugin for their icons.

On the plugin's settings page, you can see in the "Current Requirements" section what Font Awesome
requirements Radiance and Shuffle have. If they have conflicting requirements, you'll see a simple
error message to help you diagnose and resolve the problem.

For example, suppose Radiance says it requires version Font Awesome version 5.1.0 or later, but Shuffle
says it requires version 5.0.13. Well, we can't satisfy both, and we can load both versions, because that
would break all of your icons. Instead, you'll see an error message that clearly shows which requirement
is causing a conflict. You might resolve the problem by doing any or all of the following:

1. Deactivating the Shuffle plugin
1. Choosing a different theme
1. Contacting the developers of Radiance or Shuffle to suggest that they change their requirements to
   reduce conflicts

While that might be a little bit of a hassle, at least it's clear and obvious and you know who to go to
to resolve the problem. Not like the lawless ancient days when every plugin and theme tried to load its own version
of Font Awesome and everyone crossed their fingers hoping it just worked, and when it didn't, you had no idea why.

Now suppose that Radiance and Shuffle have compatible requirements, and further suppose that they make no
requirement about the method---i.e. they're content with either webfont or svg. Well, then, if you as the
web site owner prefer to use SVG, just make that selection and save those changes. Your SVG requirement
will satisfy Radiance, Shuffle, and your own preference. Anywhere that you or those components place
icons, they'll be rendered as SVG.

# CAVEAT: Plugin Name Conflict

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

## How can I use Font Awesome Pro with this plugin?

1. Log in to your `fontawesome.com` account to add your web domain to your list of
[Pro CDN Domains](https://fontawesome.com/account/services). NOTE: make sure to include any domains you use for local
 development or staging. Each unique domain must be registered.
1. On the plugin's settings page, check the box to enable Pro.

## Does the plugin support shortcodes?

Not yet. But [basic usage](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use)
with <i> tags is pretty straightforward.

