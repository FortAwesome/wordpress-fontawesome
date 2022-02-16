# Development

> Font Awesome 6 Official WordPress Plugin DEVELOPMENT

<!-- toc -->

- [Introduction](#introduction)
- [Development Setup](#development-setup)
- [Optional Development Setup Steps](#optional-development-setup-steps)
- [Run tests with phpunit](#run-tests-with-phpunit)
  * [Pass arguments to phpunit](#pass-arguments-to-phpunit)
- [Use wp-cli within your Docker environment](#use-wp-cli-within-your-docker-environment)
- [Run anything else within your Docker environment](#run-anything-else-within-your-docker-environment)
  * [Run a shell insider your Docker environment](#run-a-shell-inside-your-docker-environment)
- [Set a boolean config in `wp-config.php`](#set-a-boolean-config-in-wp-configphp)
- [Reset WordPress Docker Environment and Remove Data Volumes](#reset-wordpress-docker-environment-and-remove-data-volumes)
- [Inspecting and Re-setting Plugin States](#inspecting-and-re-setting-plugin-states)
  * [Main Options](#main-options)
  * [Releases Metadata Transient](#releases-metadata-transient)
  * [V3 Deprecation Warning](#v3-deprecation-warning)
- [Cut a Release](#cut-a-release)
- [Run a Local Docs Server](#run-a-local-docs-server)
- [Special Notes on plugin-sigma](#special-notes-on-plugin-sigma)
- [Remote Debugging with VSCode](#remote-debugging-with-vscode)
- [Redis Cache Setup](#redis-cache-setup)
- [Analyze Webpack Bundle](#analyze-webpack-bundle)

<!-- tocstop -->

# Introduction

This repo provides a multi-dimensional Docker-based development environment to help developers work with the `font-awesome`
plugin under a variety of conditions: WordPress version tags `4.9` and `latest`,
crossed with `development` and `integration`.

The `development` option mounts this plugin code as a read-write volume inside a container and sets up composer
to install any development dependencies inside the container.

The `integration` option does _not_ mount this plugin code in the container. Instead, it expects you
to install the plugin. You could do so by uploading a zip file on the Add New Plugin page in
WordPress admin: build a zip using `composer dist` or by downloading one from the [plugin's WordPress
plugin directory entry](https://wordpress.org/plugins/font-awesome/). Or you could install directly
from the WordPress plugin directory by searching for plugins by author "fontawesome".

Both options mount the test integrations found under `integrations/` so those themes or plugins can be
activated to help with testing and exploring interaction with the plugin at run time.

# Development Setup

## 0. TLDR

First time:

```
bin/build-docker-images
```

Each time, leave running in one terminal, and CTRL-C to stop:

```
bin/dev
```

First time, after `bin/dev` is running, in a separate terminal:

```
bin/setup
```

### When modifying JavaScript/CSS assets under `admin/`

First time:

```
cd admin
npm install
```

Each time:
```
cd admin
npm run start
```

Leave that running in a separate terminal.

## 1. Make sure Docker is installed

## 2. Install Node.js

Preferably your host environment will run the version of Node.js that's indicated in the `.tool-versions` file in this repo.

That's the version that we'd normally install via `asdf`.

You can install it however you'd normally install node.

<details>
<summary>Installing via asdf</summary>
Font Awesome development normally uses [`asdf`](https://asdf-vm.com/) for managing versions of various environments like Node.js.

[ASDF Get Started Guide](https://asdf-vm.com/guide/getting-started.html#_1-install-dependencies)

If you don't already have the version of nodejs mentioned in `.tool-versions`, and you've already installed `asdf`, then from this repo's directory, do:

```
export NODEJS_CHECK_SIGNATURES=no
asdf plugin-add nodejs
asdf install nodejs
```
</details>

## 2. Build any number of docker _images_ for the environments you want

Run `bin/build-docker-images` with one or more version tags corresponding to
Dockerfiles in `docker/`.

For example, to build two images:
```bash
$ bin/build-docker-images 4.9 latest
```

Once you build these, you won't need to rebuild them unless something changes in the underlying
image dependencies.

Each image is a pre-requisite for its corresponding container environment.
So if you want to be able to run `bin/dev latest`, you have to first make sure you've built the underlying
docker image with `bin/build-docker-images latest`.

<details>
<summary>Which versions are available in containers?</summary>
Look in the `docker/` subdirectory for any `Dockerfile-*`. Each corresponds to an image that can be build with the `bin/build-docker-images` script. And the `docker-compose.yml` file will define one or two containers using each image: `dev`, and sometimes also `integration`.
</details>

<details>
<summary>What actual WordPress version is latest?</summary>
For `latest`, this could happen if you see that the [`wordpress:latest` tag on Docker Hub](https://hub.docker.com/_/wordpress)
is updated. When a new version of WordPress is released, it can take a little while before a new Docker image
is available for it. So in this development environment, `latest` refers primarily to the the `wordpress:latest`
image on DockerHub, not always as current as the latest WordPress release.
</details>

<details>
<summary>Heads Up: version of WordPress vs. version of WordPress test suite</summary>
_BEWARE_: there's one place where this difference in "latest" might shoot us in the foot:
The `docker/install-wp-tests-docker.sh` script runs during the image build process to
install the core WordPress testing files that are important for our `phpunit` test run to work.
It takes a _WordPress_ version tag as an argument. So when the WordPress "latest" version (say `5.0.1`)
and the DockerHub "latest" version are temporarily out of sync, you could be in a state where
the WordPress `5.0.0` (in our example) is running, but with tests tagged for WordPress `5.0.1` are
installed. Probably this won't cause a real problem, but beware.
</details>

## 3. Set up .env.local

In the top-level of this repo, create a plain text file called `.env.local` that has at least
the following in it:

```bash
WP_ADMIN_EMAIL=foo@example.com
```

Replace `foo@example.com` with a real email address where you can receive admin messages
from this local install of WordPress, if it sends any (it tends not to).

This file is not checked into git. It's listed in `.gitignore`.


## 4. Add the wp.test host name

On Unix-like OSes, such as macOS, you do this by editing your `/etc/hosts` file
and adding a line like this:

```
127.0.0.1 wp.test
```

## 5. Run an environment (one at a time)

`latest` is the default, so these two are equivalent:

```bash
$ bin/dev latest
```

```bash
$ bin/dev
```

This table shows some of the available containers and environments, for example. There are several more:

| version tag  | development | integration |
| --- | --- | --- |
| latest | `$ bin/dev latest` | `$ bin/integration latest` |
| 4.9 | `$ bin/dev 4.9` | `$ bin/integration 4.9` |
| php7.2 | `$ bin/dev php7.2` | - |
| php8.0 | `$ bin/dev php8.0` | - |

<details>
<summary>About container version numbers</summary>
When the container has just a version number like "4.9", that's the WordPress version. To see what php
version is running in there, check `php --version` within that container. When the container version has
a php version like `php7.2`, this is a container intended especially for running the phpunit test suite
against that version of php. You can see what version of WordPress is used in that container usually by
looking at the `FROM` directive on the top line of the corresponding `Dockerfile`.

There are Docker image and container versions set up for most minor point releases of php and key milestone
releases of WordPress for local testing. Not all of these appear in the GitHub Actions test matrix.
</details>

Run one of these from the top-level directory that contains the `docker-compose.yml` config file.

Leave it running in one terminal window and do the rest of the workflow in some other terminal windows.

*Setup Required*

At this point, everything is running, but when it's the first time you've run it (or since you
cleared the docker data volume), WordPress has not yet been set up. See the `bin/setup` script for that below.

<details>
<summary>Stopping the Environment</summary>

When you're ready to stop this environment, use `CTRL-C` in that terminal window where it's running.
</details>

<details>
<summary>Restarting</summary>

To bring back up the same environment later, just run the same `bin/dev` or `bin/integration` command.
</details>

<details>
<summary>Start a Different Environment</summary>

To run a _different_ environment, you'll need to first make sure the containers from one environment
are stopped, before starting a new environment. This because the port numbers used for web and db are
the same regardless of environment, so you can only have one running at a time.
</details>

<details>
<summary>Stop an Environment's Containers</summary>

You can make sure all containers are stopped like this:

```bash
$ docker-compose down
```

You could also be a little more ninja-ish and use `docker ps` to find the running containers you know
you want to stop, find the container ID for each, and then for each one do `docker container stop <container_id>`.
</details>

## 6. Run `bin/setup`

After starting a fresh container, WordPress needs to be set up. This setup is not required when stopping and restarting a container that's already been set up.

If you're running the default `latest` `dev` container, just do this in a separate terminal window:

```
bin/setup
```

Once it succeeds, WordPress is up and running and ready to start doing stuff.

<details>
<summary>connecting to the running WordPress instance</summary>
After setup completes, WordPress is ready and initialized in the docker container and reachable at [http://wp.test:8765](http://wp.test:8765).

You can login to the admin dashboard at [http://wp.test:8765/wp-admin](http://wp.test:8765/wp-admin) with admin username and password as found in `.env`.
</details>
<details>

<summary>what is this set up?</summary>
This does the initial WordPress admin setup that happens first on any freshly installed WordPress
site. We're just doing it from the command line with the script to be quick and convenient.
</details>

<details>
<summary>setting up non-default containers</summary>
By default, it will use the container named `com.fontawesome.wordpress-latest-dev`, which will be the container made from the `latest` image.

You can use a `-c <container_id>` argument to connect to run the command against a different container. This pattern is consistent across most of the scripts under `bin/`, such as `bin/wp` and `bin/php`.
</details>

## 7. Start the admin React app's development build (in development)

If you're doing development and making changes to JavaScript or CSS assets that are in the React admin app, you should keep webpack running while you're working:

In a separate terminal window, `cd admin`, and then:

  (a) `npm install`

  (b) `npm run start` to fire up webpack.

<details>
<summary>What is webpack doing? And how do I refresh to see my changes?</summary>
This uses `wp-scripts` (webpack under the hood) to build the static assets under
`admin/build`. There's no webpack dev server. Webpack will watch the JavaScript and CSS source files, notice changes to them, and rebuild those static assets on the fly. However, it won't trigger a reload
in the browser automatically. Just refresh your browser page to load the re-built assets after making a change.
</details>

## Optional Development Setup Steps
<details>
<summary>Multisite Setup</summary>

Maybe this whole development environment should be adjusted to work with multisite "out of the box".
But for now, you have to bend over backwards.

We still have phpunit tests that can run locally and are configured to run in CI. So there will
still be test coverage of the important multisite cases, even if you don't do this setup. But if
you want to manually explore how the plugin works within the multisite context, then here's how
you'd do it. (And this is only for the `latest` container.)

[Here's a guide](https://wordpress.org/support/article/create-a-network/) for how to set up a WordPress network (aka multisite). The following summarizes.

1. add some subdomain hosts like `alpha.wp.test` and `beta.wp.test` to your `/etc/hosts`
1. change the `WP_DOMAIN` env var in `.env` temporarily to be `wp.test:80`

    (because WordPress multisite won't access ports like `wp.test:8765`)
1. change the `docker-compose.yml` configuration for the service you intend to run, like `wordpress-latest-dev` to override the default `ports`, making it use port 80 both inside and outside the container.

    ```
     ports:
       - "80:80"
    ```
1. After running the service in the normal way, shell into it and modify `/var/www/html/wp-config.php` to define `WP_ALLOW_MULTISITE` as `true`
1. Go the `wp-admin` dashboard, look for Tools->Network Setup
1. Set it up for subdomain use
1. copy the new `defines` it gives you into `wp-config.php`
1. update the `/var/www/html/.htaccess` inside the running container with the configuration stuff that WordPress admin console tells you to use.
1. Reload the `wp-admin` dashboard and find that you now go to "My Sites" from the top nav bar.

    Under "My Sites", go to Network Admin -> Sites.
    Create the sub-sites, like `alpha.wp.test` and `beta.wp.test`

That's it.

Now, if you're using a `-dev` container, you've already got the Font Awesome plugin mounted (i.e. installed) under Plugins and you can activate it network-wide from the Network Admin plugins page. Or you could activate site-by-site within each of their site-specific Plugins pages.
</details>

<details>
<summary>Redis Cache Extra Steps</summary>

If you know that you'll be installing the WP Redis plugin to test behavior with caching,
then you'll need to add at least the following environment variable to `.env.local` as well:

```bash
CACHE_HOST=host.docker.internal
```

This assumes that your version of Docker supports the `host.docker.internal`
special host name to route from the container to the host. If you have some
other configuration, you should set it accordingly here.

The following are optional:
```bash
CACHE_PORT=1111 # default: 6379
CACHE_AUTH=1111 # default: 12345
CACHE_DB=1111 # default: 0
```
</details>

<details>
<summary>Font Awesome Internal Extra steps</summary>

Designers and developers internal to Font Awesome can also run local instances of
the Font Awesome, Font Awesome API, and kit edge apps.

1. make sure the `devenv` is up-to-date
1. in the `devenv` repo, run `bin/dev-wordpress`
1. add entries for the following to your `.env.local` (replacing the URLs with the appropriate ones if they change)
    ```bash
    FONTAWESOME_API_URL=http://host.docker.internal:4543
    FONTAWESOME_KIT_LOADER_BASE_URL=https://fa.test:4243
    ```

    *Heads Up!* make sure to use `host.docker.internal` in that API URL, because
    the WordPress server needs to be able to reach the API server from inside the docker container.
    That KIT_LOADER_BASE one needs to be `fa.test` because this is a URL that the
    browser (running in the host) will need to reach.
1. run `bin/dev` in the `fontawesome` repo if you need to do things with kit configs or API Tokens
</details>

<details>
<summary>Install PHP in Your Host Environment</summary>
You normally will not need to install PHP in your host environment, because the
container system is designed to run specific versions php within each container.

So for most of your dev workflows, it doesn't matter what version of php, if any, you have installed in your local host environment. There are no workflows that require you to have php installed in your host environment. So this is only if you know you why you want to run some stuff--maybe phpcs code sniffing--from within the host environment.

### Install the same PHP as the WordPress image

If you don't have any other reason to prefer what version of php is installed and active on your host system,
it may be easiest to install the same version that's used inside the WordPress docker container.

For the `wordpress:latest` image (which you're probably doing to be using mostly), you could determine that version of php like this:

```
$ docker run --rm wordpress:latest php --version
```

As of WordPress 5.8.3, the `wordpress:latest` image uses php 7.4.27, even though the latest
available PHP is currently 8.1.1.

To install PHP 7.4 via brew:

```
$ brew install php@7.4
```

Dealing with managing multiple versions of php via homebrew is an exercise left to the reader ;-)

### asdf is a nightmare for PHP

While Font Awesome's development environments normally use asdf to help standardize runtime configurations, getting
the PHP plugin for asdf to work successfully on macOS is probably not worth it at this time. The original plugin
has apparently [been abandoned](https://github.com/odarriba/asdf-php#why-using-this-plug-in), and the maintainer of the
current plugin doesn't use it any longer, and thinks that it's ["near to a nightmare"](https://github.com/odarriba/asdf-php/issues/8#issuecomment-362911209)
on macOS.

### Multiple Versions of PHP and version-specific composer.json files

There are multiple variations of composer.json files in this repo, each corresponding to different versions of php.
Our GitHub Actions configuration runs the automated tests across a matrix of different versions of php that
that this plugin should support. Some of the dependencies in composer.json are sensitive to the version of php
in use. So when we run tests against, say, php 5.6, we run with the php 5.6 specific composer.json, like this:

```
$ COMPOSER=composer-php5.6.json composer install
```

That's how you can specify a particular composer config file, instead of the default one called `composer.json`.

The default `composer.json` and `composer.lock` files are intended to match the environment of the `wordpress:latest` docker image
at any given point in time. As of WordPress 5.8.3 being `latest`, the image has php 7.4.

So if you have installed php `8.1` on your host system and you just run `composer install` or `composer update`, you may see
various compatibility problems, since it will use `composer.json` by default. Only do that with a version of php that matches what's in the `wordpress:latest` image.

Thefore, when executing `composer` commands in your local host development environment, or in GitHub Actions,
make sure that composer is using the version of composer.json that corresponds to the active version
of php in that environment.

The containers for each version of php have the `COMPOSER` environment variable appropriately so that, within a given container, you can just run `composer` and it will inherit that env var and use the appropriate composer config file. (These are set in the `.env` and `docker-compose.yml` declarations.)

</details>
<details>
<summary>Install composer (PHP package manager)</summary>
Again, just as you would normally never need to install PHP in your host environment, you probably don't need to install `composer` in your host environment. For normal workflows in this repo, running composer--using the configuration set up within each php-version-specific container--is preferable.

But if you know why you need, and you're on macOS, it can be installed via homebrew:
```
brew install composer
```
</details>

<details>
<summary>The WordPress 4 compat bundle</summary>
For older versions of WordPress, we build and load this separate "compat-js" bundle. It includes some WordPress dependencies that are available at runtime on newer versions of WordPress, but which this plugin provides itself when it detects that
it's being loaded on older versions of WordPress.

This bundle will probably not change very much, so it may not be necessary to rebuild at all.
If you're doing development work only in WordPress 5, you can skip this altogether.

If you do need to update what's in this bundle, though, then you just build another
static production build like this:

```
$ cd compat-js
$ npm install
$ npm run build
```

This will create `compat-js/build/compat.js`, which the plugin looks for and
enqueues automatically when it detects that it's running under WordPress 4.
</details>

<details>
<summary>If you have an older version of Docker or one that doesn't support host.docker.internal</summary>

The local dev environment here is configured to use [host.docker.internal](https://docs.docker.com/docker-for-mac/networking/), which will work with Docker for Mac Desktop and some other versions of Docker.

It's what allows processes running inside the container to access services running
on ports in the host environment.

If you don't have `host.docker.internal` support for some reason, you could set up
a loopback address with the following IP from your host OS.
On macOS the command might look like this:

`sudo ifconfig lo0 alias 169.254.254.254`

The `docker-compose.yml` adds a hostname called `dockerhost` that resolves to that
IP address.

Now search through the various config and source files in this repo where
`host.docker.internal` appears and change them to `dockerhost`. Don't commit that
change, since it's just a temporary change for your local development environment.

Here are some of the operations that require the container to talk back to the host:

- PHP debugging port via remote xdebug
- Webpack dev server port for React hot module reloading
- Font Awesome GraphQL API (when running that service locally)
</details>

<details>
<summary>configure debugging</summary>

```bash
bin/configure-debugging
```

This will set up debugging configuration in `wp-config.php` inside the container
and will also install several plugins to power the debug bar available from the
upper right-hand nav bar when logged into WordPress as admin.
</details>

<details>
<summary>Install and/or Activate the Font Awesome plugin (only in integration environment)</summary>

If you're running the `bin/dev` environment, you'll find in the admin dashboard that the
Font Awesome is already installed, because the source code in this repo is mounted as a volume
inside the container. You can activate or deactivate the plugin, but you'll find that if you try
to uninstall it, it seems to wipe out the plugin's code from the working directory of this repo.
So, probably don't do that.

If you're running the `bin/integration` environment, install via zip archive upload or directly
from the WordPress plugins directory. [See above](#development) for more details.

After activating the plugin you can access the Font Awesome admin page here:
`http://wp.test:8765/wp-admin/options-general.php?page=font-awesome`

Or you'll find it linked on the left sidebar under Settings.
</details>

# Run tests with phpunit

PHPUnit will be run within a given container, specific to some version of php.

This also means that the `composer` bundle must be built within that container first:

```bash
bin/composer install
bin/phpunit
```

This runs `phpunit` in the default docker container. It's just a docker wrapper around the normal `phpunit` command,
so you can pass any normal `phpunit` command line arguments you might like.

You can skip `compose install` for subsequent `composer` or `phpunit` unit commands within that particular container,
unless the corresponding composer config changes.

<details>
<summary>Example in a non-default container</summary>
Suppose you want to run the tests against php 7.1, and you've build the corresponding `php7.1` image and started its
dev container:

```bash
bin/composer -c com.fontawesome.wordpress-php7.1-dev install
bin/phpunit -c com.fontawesome.wordpress-php7.1-dev
```

</details>
<details>
<summary>Run loader tests</summary>
To run the loader tests, use this alternate test config. And because of how they run, each should be run separately,
for example, using a `--filter`:

```bash
bin/phpunit --config phpunit-loader.xml.dist --filter FontAwesomeLoaderTestLifecycle
```
</details>

<details>
<summary>Run multisite tests without network admin</summary>
This would simulate the multisite environment, but where actions like activation or deactivation of the plugin
are initiated from within a particular site's dashboard, rather than from the network dashboard.

```bash
bin/phpunit --config phpunit-multisite.xml.dist
```
</details>

<details>
<summary>Run multisite tests as network admin</summary>
This would simulate the multisite environment where actions like activation or deactivation of the plugin
are initiated from the network admin dashboard.

```bash
bin/phpunit --config phpunit-multisite-network-admin.xml.dist
```
</details>

<details>
<summary>filter which tests to run</summary>
The `bin/phpunit` script will pass through command-line arguments to `phpunit` within the container. So you can do something this:

```bash
bin/phpunit --filter EnqueueTest
```

When specifying a container with `-c`, to add additional command-line arguments, you also need to add `--` like this:

```bash
bin/phpunit -c com.fontawesome.wordpress-php7.1-dev -- --filter EnqueueTest
```

Everything before the `--` are the options do the `bin/phpunit` script, and everything after the `--` are what get passed through 
to the `phpunit` command inside the container.
</details>

# Use WP-CLI within your Docker environment

For example,

```bash
$ bin/wp plugin list
```

This will run `wp` inside the default container and list plugins.

To run this under a different container, provide the container's name or id with `-c`:

```bash
$ bin/wp -c 193d46dcb77b plugin list
```

Everything about the command line is the same as you'd normally use for `wp`, except the first
option must be `-c <container_id_name>`

# Run anything else within your Docker environment

```bash
$ bin/env <command_line>
```

This is a wrapper that just executes `<command_line>` inside the specified running container.

Again, use `-c <container_id_name>` to specify a non-default docker container.

## Run a shell inside your Docker environment

```bash
$ bin/env bash
```
# Set a boolean config in wp-config.php

```bash
bin/set-wp-config WP_DEBUG true
```

(Though this particular config is already set automatically in `bin/setup`.)

# Reset WordPress Docker Environment and Remove Data Volumes

```bash
$ bin/clean
```

This will kill and remove docker containers and delete their data volumes.

It will also try to clean up helper containers created by PhpStorm, if you're using that IDE.

If you do something accidentally to modify the Wordpress container and put it into a weird state
somehow, or even if you just want to re-initialize the whole WordPress environment (i.e. the app and the mysql db),
this is how you can do it.

This doesn't remove the docker _images_, just the containers and their data volumes.
So you won't have to rebuild images after a `clean`. But also, if what you're trying to do is
remove those images, you'll need to use `docker image rm <image_id>`.

After a `bin/clean`, you'll need to run a new environment again, such as `bin/dev` and also
re-run setup, like `bin/setup`.

# Inspecting and Re-setting Plugin States

This plugin's behavior depends upon a few different states that are stored in the WordPress database.

## Main Options

The main state is stored under an options key: `font-awesome`.

Inspect it:

```bash
$ bin/wp option get font-awesome
```

Remove it:

```bash
$ bin/wp option delete font-awesome
```

## Releases Metadata Transient

When the plugin retrieves releases metadata from `https://fontawesome.com/api/releases` it caches the results
as a long-lived WordPress transient: `font-awesome-releases`.

(We use set_site_transient() for these, to support multi-site mode, so you have to
use the `--network` switch on the following commands. Otherwise, it's like they
aren't there at all.)

Inspect it:

```bash
$ bin/wp transient get font-awesome-releases --network
```

Remove it:

```bash
$ bin/wp transient delete font-awesome-releases --network
```

## V3 Deprecation Warning

Temporarily, this plugin supports Font Awesome version 3 icon names, but also warns that their use is
deprecated. Finally, it allows the site owner to "snooze" the deprecation warning. The state of that
detection or snoozing is stored in an expiring transient: `font-awesome-v3-deprecation-data`.

Inspect it:

```bash
$ bin/wp transient get font-awesome-v3-deprecation-data
```

Remove it:

```bash
$ bin/wp transient delete font-awesome-v3-deprecation-data
```

# Cut a Release

1. Update the Changelog at the end of readme.txt

2. Update the plugin version in the header comments of `index.php`

3. Update the plugin version const in `includes/class-fontawesome.php`

4. Update the versions in `admin/package.json` and `compat-js/package.json`

5. Wait on changing the "Stable Tag" in `readme.txt` until after we've made the changes in the `svn` repo below.

6. Build the API docs

- run `composer cleandocs` if you want to make sure that you're building from scratch
- run `bin/phpdoc` to build the docs into the `docs/` directory

  See also: [Run a Local Docs Server](#run-a-local-docs-server)

  *WARNING*: look at the output from this docs command and make sure there are no
  instances of parse errors. Also, manually inspect the output in `docs/` to ensure
  that the expected classes are documented there, especially the main class with API
  documentation: `FontAwesome`.

  For reasons not yet understood, sometimes the phpdocumentor parser chokes.

- `git add docs` to stage them for commit (and eventually commit them)

7. Build production admin app and WordPress distribution layout into `wp-dist`

```bash
$ composer dist
```

This will delete the previous build assets and produce the following:

`wp-dist/`: the contents of this directory should be moved into the svn repo for the WordPress plugin
that will be published through the WordPress plugins directory.

`font-awesome.zip`: a zip file of the contents of `wp-dist` with path names fixed up.
This zip file can be distributed as a download for the WordPress plugin and used for installing
the plugin by "upload" in the WordPress admin dashboard.

`admin/build`: production build of the admin UI React app. This need to be committed so that it
can be included in the composer package (which is really just a pull of this repo)

8. Run through some manual acceptance testing

**WordPress 4.7, 4.8, 4.9**

For each of these 4.x environments, run and setup the corresponding integration container, like:
```
bin/integration 4.7
bin/setup -c com.fontawesome.wordpress-4.7-integration
```

Install and activate the Font Awesome plugin from the admin dashboard by uploading the `font-awesome.zip` file
that was created in the previous step.

Run through the following, with the JavaScript console open, looking for any warnings or errors:

1. Load the plugin settings page.
1. Change from Web Font to SVG and save.
1. Create a new post (which will be in the Classic Editor)
1. Click the "Add Font Awesome" button
1. Search for something, and click to insert an icon from the results

**WordPress 5.0**

Setup the integration environment as above, but also do the following editor
integration tests intead:

1. Install the Classic Editor plugin
1. Create a post with the Classic Editor
1. Click the "Add Font Awesome" media button
1. Search for something, and click to insert an icon from the results
1. Create a new post, switching to the Gutenberg / Block Editor
1. Expect to see a compatibility warning that the Icon Chooser is not enabled,
    but otherwise expect the Block Editor to function normally

**WordPress 5.4**

Setup the integration environment as above. Do the same tests as on 5.0, but also
expect the Icon Chooser to be enabled within the Block Editor:

1. Create a post with the Block Editor
1. Activate the Icon Chooser
1. Search for something, and click to insert an icon from the results

**WordPress latest**

Again, fire up and setup the integration container for `latest`:
```
bin/integration
bin/setup
```

...and install the plugin via the newly built `font-awesome.zip` file.

- activate and deactivate the plugin: expect no errors
    - upon deactivation, site transients like `font-awesome-last-used-release` should be deleted
    - options like `font-awesome` or `font-awesome-releases` should remain upon deactivation
    - verify these via db query, such as, from within the container:
        ```
        $ wp --allow-root db query 'select option_id, option_name from wp_options where option_name like "%awesome%";'
        ```
- delete/uninstall: expect no errors
    - use wp-cli or db query to ensure that the `font-awesome` option has been deleted
    - use wp-cli or db query to ensure that transients have been deleted
- with Use CDN settings
    - activate `theme-alpha`, `plugin-beta`, `plugin-delta`, `plugin-eta`, `plugin-gamma`, and `plugin-zeta`
    - expect to see all of their preferences listed on the Troubleshoot page
      - Especially, look for `plugin-gamma` and `plugin-delta` outputs in all three contexts: front end, admin, login
    - run the conflict scanner and then expect to see the versions from `plugin-gamma` and `plugin-delta` to be listed
        on detected conflicts in the Troubleshoot tab
    - block plugin-gamma's version (css) and expect it to be blocked, but not plugin-delta's version (js)
    - delete the blocked plugin-gamma version. expect that to work, and then see its css load again after visiting another page.
    - change settings on the Use CDN settings tab to enable Pro. Theme alpha should show pro icon(s).
    - change change settings on the Use CDN settings table to use SVG technology. Expect to see a preference warning from `plugin-beta`.
        - switch to the Troublehsoot tab and expect to see the `plugin-beta` warning indicated on the table.
    - view the site: expect to see all of those integration plugins doing their thing with no missing icons
    - deactivate all of those integration testing plugins and activate `plugin-epsilon`
        - expect an error notice after the preference check when changing preferences in the Use CDN view.
        - expect to see an error object in the JSON response of the REST request to the `config` endpoint
            when saving changes.
        - it should not crash WordPress or throw an exception with stack trace in the browser
- with Use a Kit
    - Add a real API Token from a real fontawesome.com account
    - Select a kit that uses svg tech
    - Make sure you see a preference conflict with beta-plugin (it wants webfont)
    - Change the kit's settings on fontawesome.come (webfont to svg)
    - Refresh kit settings on the plugin settings page
        - expect to see the kit settings to be updated and the
          conflict with plugin-beta to be resolved
    - Remove all detected conflicts on the Troubleshoot tab
    - Re-run the conflict detector (plugin-gamma and plugin-delta should both be active)
    - make sure the conflict scanner detects the same conflicts
      now when using a kit as it did when we used CDN.
- Use the Icon Chooser
    - Insert an icon into a post using the Icon Chooser from the block editor
    - Install the Classic Editor plugin and insert an icon into a post using the Icon Chooser from the classic editor
    - On a post editing page with the Classic Editor, open the JavaScript console and check the following:
        - `!!wp.editor.mediaUpload` should be `false` (because we should not be loading `wp-editor`, aka `@wordpress/editor` here. [See forum topic.](https://wordpress.org/support/topic/plugin-conflicts-with-rankmath/))
        - `!!wp.blockEditor` should be `false` for the same reason (`wp-block-editor` aka `@wordpress/block-editor`)
        - `!!wp.blocks` should be `false` for the same reason (`wp-block` aka `@wordpress/blocks`)
        - (TODO: we should add automated testing for these regression tests.)
    - Ideally, do each of the both under all of the following conditions:
        1. Use with CDN, Free
        1. Use with CDN, Pro (expect a UI message in the Icon Chooser notifying that Pro icons are only available in the Icon Chooser for Pro _Kits_)
        1. Use with Kit, Free
        1. Use with Kit, Pro (expect to see all styles and Pro icons)
    - Spin up a separate WordPress 4.7 container, install the plugin in that, and insert an icon into a post using the Icon Chooser in the classic editor
- If you know how to properly test with `plugin-sigma`--it's more complicated--go for it.
- Verify that we're not overriding `window._` (lodash), `window.React` (or any other [relevant globals](https://make.wordpress.org/core/2018/12/06/javascript-packages-and-interoperability-in-5-0-and-beyond/)).
    - This can be done in the block editor:
        1. create a new post in the block editor
        1. open the browser's JavaScript console
        1. look at the value of the globals: `window._.VERSION` and `window.React.version`. They should be the same as whatever this version of WordPress ships with--not the versions that may be used in our admin JS bundle, if different.
    - To be more comprehensive, check it also in each of the following scenarios:
        1. When running the Conflict Detector
        1. On the admin settings page

    - See also [this forum topic](https://wordpress.org/support/topic/lodash-overrides-window-_-underscore-js-variable/).
        **HEADS UP!** This tricky issue has come up, been fixed, and regressed more than once. So
        this investigation is especially important any time the JavaScript build
        process is adjusted. Reason: if code splitting is being used in the JavaScript build, then _any_
        chunk that's loaded could possibly introduce this problem.

        Currently (as of plugin v4.0.2), the webpack config uses `babel-plugin-lodash` to
        rewrite lodash imports throughout the whole codebase (and we're including `node_modules` in that)
        in order to convert any thing like:

        ```
        import { get } from 'lodash'
        ```

        to something like:

        ```
        import get from 'lodash/get'
        ```

        which avoids the `lodash.js` module import that is responsible for the global assignment side
        effect (at least in the current version of lodash!)

        Other components in the WordPress ecosystem may depend on the particular, globally available
        version of lodash that ships in WordPress Core. So the impact of this bug
        regressing will be that this plugin causes some other plugin or theme to break.
        In the past, this has included Visual Composer, or themes based on the popular
        starter theme [Underscores](https://underscores.me/).
- **Test loader lifecycle scenarios involving composer packages**
    - under `integrations/plugins/plugin-sigma` and `integrations/themes/theme-mu`, make sure the `composer.json` in each case points to a relevant version of this repo's composer package (a particular development branch on GitHub, for example)
    - make sure that `composer update` has been run recently to ensure that those components load the version of the package that you intend to be testing
    - use the `bin/integration` environment for these tests
    - copy the `font-awesome.zip` (resulting from `composer dist`) into the container:

        `docker cp font-awesome.zip com.fontawesome.wordpress-latest-integration:/tmp`

    - Start with the Font Awesome plugin _not_ installed or activated
        - make sure the following returns empty to start:
            - `bin/wp -c com.fontawesome.wordpress-latest-integration option get font-awesome`

                This retrieves the main `font-awesome` option from the wpdb, which would be created upon initialization and only removed upon _uninstall_

            - `bin/wp -c com.fontawesome.wordpress-latest-integration option get font-awesome-releases`
            - `bin/wp -c com.fontawesome.wordpress-latest-integration transient get font-awesome-last-used-release --network`
        - If there's stuff there and you haven't activated anything yet, then it's leftover from prior db container state. An easy way to start from scratch:
            1. kill the currently running container
            1. `bin/clean` will put you back into a clean state
            1. `bin/integration`, and once that's up, `bin/setup -c com.fontawesome.wordpress-latest-integration`
    - Activate plugin-sigma and expect it to initialize the db settings (plugin-sigma uses the wordpress-fontawesome composer package)
        - `bin/wp -c com.fontawesome.wordpress-latest-integration plugin activate plugin-sigma`
        - `bin/wp -c com.fontawesome.wordpress-latest-integration option get font-awesome`

            This should now show the initial/default state of the main option

        - `bin/wp -c com.fontawesome.wordpress-latest-integration option get font-awesome-releases`

            This should now show a bunch of metadata about FA releases

        - `bin/wp -c com.fontawesome.wordpress-latest-integration transient get font-awesome-last-used-release --network`

            This should now just the slice of release metadata for the currently configured release

    - Activate theme-mu and expect no errors
        `bin/wp -c com.fontawesome.wordpress-latest-integration theme activate theme-mu`

        (theme-mu uses the wordpress-fontawesome composer package also)

    - Deactivate theme-mu by activating some other theme. In this case, we expect no db changes, because the loader should see that plugin-sigma is still active. Afterward, the querying the `font-awesome` option and `font-awesome-releases` transient should continue to show the same truthy, non-empty results as before.
        - `bin/wp -c com.fontawesome.wordpress-latest-integration theme activate theme-alpha`

        (or any other available theme)

        - `bin/wp -c com.fontawesome.wordpress-latest-integration option get font-awesome`
        - `bin/wp -c com.fontawesome.wordpress-latest-integration transient get font-awesome-last-used-release --network`
    - Deactivate plugin-sigma and expect that the `font-awesome` option remains, but the `font-awesome-last-used-release` transient is removed:
        - `bin/wp -c com.fontawesome.wordpress-latest-integration plugin deactivate plugin-sigma`
        - `bin/wp -c com.fontawesome.wordpress-latest-integration option get font-awesome`

            This should be non-empty/truthy.

        - `bin/wp -c com.fontawesome.wordpress-latest-integration transient get font-awesome-last-used-release --network`

            This should be empty/falsy.

    - Install and activate the plugin directly, using the zip file we copied into the container above:
        - `docker exec -w /var/www/html com.fontawesome.wordpress-latest-integration wp plugin install /tmp/font-awesome.zip --activate --allow-root`

            (Using a direct `docker exec` command here instead of the `bin/wp` so we can run it as the root user inside the container)

        - `bin/wp -c com.fontawesome.wordpress-latest-integration transient get font-awesome-last-used-release --network`
            This should again be non-empty/truthy.
            Of course the `font-awesome` option should still be truthy.
    - Deactivate _and_ uninstall the Font Awesome plugin and expect that the `font-awesome` option is now gone as well:
        - `bin/wp -c com.fontawesome.wordpress-latest-integration plugin deactivate font-awesome`
        - `bin/wp -c com.fontawesome.wordpress-latest-integration transient get font-awesome-last-used-release --network`

            This should now be empty.

        - `bin/wp -c com.fontawesome.wordpress-latest-integration plugin uninstall font-awesome`

        - `bin/wp -c com.fontawesome.wordpress-latest-integration option get font-awesome`
        - `bin/wp -c com.fontawesome.wordpress-latest-integration option get font-awesome-releases`

            These should now be empty as well.

    - Activate theme-mu, expect all data to be initialized:
        - `bin/wp -c com.fontawesome.wordpress-latest-integration theme activate theme-mu`
        - `bin/wp -c com.fontawesome.wordpress-latest-integration transient get font-awesome-last-used-release --network`

            This should again be non-empty/truthy.

        - `bin/wp -c com.fontawesome.wordpress-latest-integration option get font-awesome`

            This should be non-empty/truthy.

    - Finally, deactivate theme-mu by activating another theme. This should cause _both_ the deactivate _and_ uninstall logic to be triggered, because it's the last client of Font Awesome, and it's a theme (apparently themes don't have separate deactivation and uninstall logic like plugins have).
        - `bin/wp -c com.fontawesome.wordpress-latest-integration theme activate theme-alpha`
        - `bin/wp -c com.fontawesome.wordpress-latest-integration option get font-awesome`

            This should be empty.

        - `bin/wp -c com.fontawesome.wordpress-latest-integration transient get font-awesome-last-used-release --network`

            This should be empty.

9. Check out and update the plugin svn repo into `wp-svn` (the scripts expect to find a subdirectory with exactly that name in that location)

To check it out initially:

```bash
svn co https://plugins.svn.wordpress.org/font-awesome wp-svn
```

If you've already checked it out, make sure it's up-to-date:

```bash
$ cd wp-svn
$ svn up
$ cd ..
```

10. Copy plugin directory assets and wp-dist layout into `wp-svn/trunk`

```bash
$ composer dist2trunk
```

This script will just `rm *` anything under `wp-svn/trunk/*` and `wp-svn/assets/*` to make sure that if the new dist
layout changes the file list from the previous release, or if there are changes to the list of files in `wp-svn/assets`,
they will show up as file changes when you do `svn stat`.

11. Make sure the svn trunk makes sense with respect to added or removed files

```bash
$ cd wp-svn
$ svn stat
```

If there are files with `!` status, that indicates they no longer exist and you should do `svn delete` on each of them.

You can do `svn delete` on lots of files with that status at once like this:

```bash
$ svn stat | grep '^\!' | sed 's/^\![\ ]*trunk/trunk/' | xargs svn delete
```

If there are files with `?` status, that indicates they are being added and you should do `svn add` on each of them.

You can do `svn add` on lots of files with that status at once like this:

```bash
svn stat | grep '^\?' | sed 's/^\?[\ ]*trunk/trunk/' | xargs svn add
```

Pay attention to files under either `wp-svn/assets` or `wp-svn/trunk`.

For example, every time the admin client is rebuilt and the bundle content changes, the hashes on the bundle file names
change. So you'll end up removing the old ones and adding the new ones.

If there's an editor dotfile or other directory that should be ignored by `svn`, you can do something like this:

```bash
$ svn propset svn:ignore .idea .
```

12. Check in the new trunk

Make sure that the `Stable Tag` in `wp-svn/trunk/readme.txt` still reflects the _previous_ release at this point.
It should point to the previous release that has a subdirectory under `tags/`.

(Suppose `42.1.2` is the new version we're releasing. Change it in the examples to use real release version numbers.)

`svn ci` is what publishes the plugin code to the WordPress plugins directory, making it public.

```bash
$ svn ci -m 'Update trunk for release 42.1.2'
```

If you're not already authenticated to `svn`, add the `--username` option to `svn ci` and it will prompt you for your
password. After the first `svn ci` caches the credentials, you probably won't need to include `--username`.

[See also tips on using SVN with WordPress Plugins](https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion/#editing-existing-files).

13. Create the new svn release tag

First, make sure `svn stat` is clean. We want to make sure that the trunk is all committed and clean before we take a
snapshot of it for the release tag.

This will snapshot `trunk` as a new release tag. Replace the example tag name with the real release tag name.

```bash
$ svn cp trunk tags/42.1.2
```

14. Update `Stable tag` and `Tested up to` tags in `readme.txt`

We've now got three copies of `readme.txt` that should all be updated with new tag values:

- `wp-svn/trunk/readme.txt`
- `wp-svn/tags/<new_tag_name>/readme.txt`
- `readme.txt` (in the git repo)

15. Check in the latest changes to svn.

(Again, use the real version number)

From the `wp-svn` dir:

```bash
$ svn ci -m 'Release 42.1.2'
```

16. `git add` and `git commit` all that would have been changed so far:

- `docs/`
- `admin/build`
- `index.php`
- `includes/class-fontawesome.php`
- `admin/package.json`
- `readme.txt`

17. `git push` to GitHub remote

Single release commits can be pushed directly to `master`. If there are several commits, push to a topic branch and squash/merge
them into `master` as a single commit.

18. Create a GitHub release that tags that new release commit

# Run a Local Docs Server

If you want to preview the built docs with a web server, first build the docs:
```
bin/phpdoc
```

Then go into the `docsrv` directory and run the doc server:
```
cd docsrv
npm install
node index.js
```

Point a web browser at `http://localhost:3000`.

# Special Notes on plugin-sigma

`plugin-sigma` demonstrates how a third-party plugin developer could include this Font Awesome plugin as a composer
dependency. In this scenario, the WordPress site admin does not need to separately install the Font Awesome plugin.

In order to activate it you must first run `composer install --prefer-dist` from the
`integrations/plugins/plugin-sigma` directory.

# Remote Debugging with VSCode

(Only the "latest" WordPress docker image has the xdebug extension. Hack `Dockerfile-4.9` if you need it in the 4.9 image as well.)

1. Install the PHP Debug (Felix Becker) extension in VSCode
1. Restart VSCode
1. Click the debug tab (looks like a crossed-out bug icon)
1. Add configuration...
1. Select PHP
1. It will show you a default `launch.json` file that includes a "Listen for XDebug. Our container is configured to run XDebug on port 9000, so double-check that this is the port set up there. It should be the default.
1. Add to that "Listen for XDebug" section, the following:
    ```json
    "pathMappings": {
      "/var/www/html/wp-content/plugins/font-awesome": "${workspaceRoot}"
    }
    ```

# Redis Cache Setup

1. Make sure you've set the `CACHE_HOST` and `CACHE_PORT` environment variables
    in `.env.local` (see above).
1. Run the `bin/redis-setup` script from the root of this repo:

   This example uses a non-default container option with `-c`.

    ```bash
    bin/redis-setup -c com.fontawesome.wordpress-latest-integration
    ```

    If successful, it will show the results of `wp redis info`. The `wp-redis`
    plugin provides additional WP-CLI commands. You can run them like this:

    ```bash
    bin/wp -c com.fontawesome.wordpress-latest-integration -- redis info
    ```

    Or if using the default dev container, just:
    ```bash
    bin/wp redis info
    ```
1. The `bin/cache-show` script might help
1. You're on your own (for now) to make sure the cache is flushed or otherwise
   doesn't interfere with your expectations when you switch environments.

# Update WordPress to a Forthcoming Release

1. Download the zip

For example, download the latest on the 5.4 branch:

```
https://wordpress.org/nightly-builds/wordpress-5.4-latest.zip
```

1. Copy it into the docker container

```bash
docker cp ~/Downloads/wordpress-5.4-latest.zip com.fontawesome.wordpress-latest-dev:/tmp/
```

1. Shell into the container as root

```bash
bin/env /bin/bash
```

1. update with `wp core update`

```bash
wp --allow-root core update --version=5.4 /tmp/wordpress-5.4-latest.zip
```

# Analyze Webpack Bundle

The webpack configs for both `admin/` and `compat-js/` include the `BundleAnalyzerPlugin`,
which produces a corresponding `webpack-stats.html` file in the corresponding
directory on each build.

Just open that html file in a web browser to see the analysis of what's actually
in the bundle.

# Setup Multisite

See [guide here](https://wordpress.org/support/article/create-a-network/)

1. `bin/wp config set WP_ALLOW_MULTISITE true`

## Hack for Running Network Uninstall in Development Mode

```
wp --allow-root eval 'require_once "wp-content/plugins/font-awesome/includes/class-fontawesome-deactivator.php"; use FortAwesome\FontAwesome_Deactivator; define("WP_NETWORK_ADMIN", true); FontAwesome_Deactivator::uninstall();'
```
