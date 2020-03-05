# Development

> Font Awesome 5 Official WordPress Plugin DEVELOPMENT

<!-- toc -->

- [Introduction](#introduction)
- [Development Setup](#development-setup)
- [Run phpunit](#run-phpunit)
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
- [Configure PhpStorm 2018.1.5 for debugging](#configure-phpstorm-201815-for-debugging)

<!-- tocstop -->

# Introduction

This repo provides a multi-dimensional Docker-based development environment to help developers work with the `font-awesome`
plugin under a variety of conditions: WordPress version tags `4.9.8` and `latest`,
crossed with `development` and `integration`.

The `development` option mounts this plugin code as a read-write volume inside a container, and also
sets up the environment for the React admin app to do hot module loading through the webpack dev server.

The `integration` option does _not_ mount this plugin code in the container. Instead, it expects you
to install the plugin. You could do so by uploading a zip file on the Add New Plugin page in
WordPress admin: build a zip using `composer dist` or by downloading one from the [plugin's WordPress
plugin directory entry](https://wordpress.org/plugins/font-awesome/). Or you could install directly
from the WordPress plugin directory by searching for plugins by author "fontawesome".

Both options mount the test integrations found under `integrations/` so those themes or plugins can be
activated to help with testing and exploring interaction with the plugin at run time.

# Development Setup

## 0. Install PHP

Most of our PHP code will run inside a Docker container under the version of PHP installed within that container.
However, some of the tools for building or running composer will run outside of the container, in the host environment,
so you'll need a workable version of PHP installed in your host environment.

If you can run `$ php --version` and it shows a PHP version that's 7.1 or later, that should be good enough.

Otherwise, install php in a way appropriate to your host environment. On macOS, use:

`$ brew install php`

### asdf is a nightmare for PHP

While Font Awesome's development environments normally use asdf to help standardize runtime configurations, getting
the PHP plugin for asdf to work successfully on macOS is probably not worth it at this time. The original plugin
has apparently [been abandoned](https://github.com/odarriba/asdf-php#why-using-this-plug-in), and the maintainer of the
current plugin doesn't use it any longer, and thinks that it's ["near to a nightmare"](https://github.com/odarriba/asdf-php/issues/8#issuecomment-362911209)
on macOS.

## 1. Make sure Docker is installed

## 2. Build any number of docker _images_ for the environments you want

Run `bin/build-docker-images` with one or more version tags corresponding to
Dockerfiles in `docker/`.

For example, to build two images:
```bash
$ bin/build-docker-images 4.9.8 latest
```

Once you build these, you won't need to rebuild them unless something changes in the underlying
image dependencies. For a historic WordPress release like `4.9.8` that may never occur.

For `latest`, this could happen if you see that the [`wordpress:latest` tag on Docker Hub](https://hub.docker.com/_/wordpress)
is updated. When a new version of WordPress is released, it can take a little while before a new Docker image
is available for it. So in this development environment, `latest` refers primarily to the the `wordpress:latest`
image on DockerHub, not always as current as the latest WordPress release.

Each image is a pre-requisite for its corresponding container environment.
So if you want to be able to run `bin/dev latest`, you have to first make sure you've built the underlying
docker image with `bin/build-docker-images latest`. 

_BEWARE_: there's one place where this difference in "latest" might shoot us in the foot:
The `docker/install-wp-tests-docker.sh` script runs during the image build process to
install the core WordPress testing files that are important for our `phpunit` test run to work.
It takes a _WordPress_ version tag as an argument. So when the WordPress "latest" version (say `5.0.1`)
and the DockerHub "latest" version are temporarily out of sync, you could be in a state where
the WordPress `5.0.0` (in our example) is running, but with tests tagged for WordPress `5.0.1` are 
installed. Probably this won't cause a real problem, but beware.

## 3. set up .env.local

In the top-level of this repo, create a plain text file called `.env.local` that has at least
the following in it:

```bash
WP_ADMIN_EMAIL=foo@example.com
```

Replace `foo@example.com` with a real email address where you can receive admin messages
from this local install of WordPress, if it sends any (it tends not to). 

This file is not checked into git. It's listed in `.gitignore`.

### Font Awesome Internal Extra steps

Designers and developers internal to Font Awesome can also run local instances of
the Font Awesome, Font Awesome API, and kit edge apps.

1. make sure the `devenv` is up to date
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

## 4. Add the wp.test host name

On Unix-like OSes, such as Mac OS, you do this by editing your `/etc/hosts` file
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

This table shows the matrix for running each container environment:

| version tag  | development | integration |
| --- | --- | --- |
| 4.9.8 | `$ bin/dev 4.9.8` | `$ bin/integration 4.9.8` |
| latest | `$ bin/dev latest` | `$ bin/integration latest` |

Run one of these from the top-level directory that contains the `docker-compose.yml` config file.

Leave it running in one terminal window and do the rest of the workflow in some other terminal windows.

*Setup Required*

At this point, everything is running, but when it's the first time you've run it (or since you
cleared the docker data volume), WordPress has not yet been setup. There's a script for that below.

*Stopping the Environment*
 
When you're ready to stop this environment, use `CTRL-C` in that terminal window where it's running.

*Restarting*

To bring back up the same environment later, just run the same `bin/dev` or `bin/integration` command.

*Start a Different Environment*

To run a _different_ environment, you'll need to first make sure the containers from one environment
are stopped, before starting a new environment. This because the port numbers used for web and db are
the same regardless of environment, so you can only have one running at a time.

*Stop an Environment's Containers*

You can make sure all containers are stopped like this:

```bash
$ docker-compose down
```

You could also be a little more ninja-ish and use `docker ps` to find the running containers you know
you want to stop, find the container ID for each, and then for each one do `docker container stop <container_id>`.

## 6. install composer (PHP package manager)

On Mac OS X, it can be installed via `brew install composer`

## 7. update composer dependencies

From the top-level directory that contains `composer.json`:

```
composer install
```

## 8. OPTIONAL: start the admin React app's development build (in development)

In one terminal window, `cd admin`, and then:

  (a) `yarn`

  (b) `yarn start` to fire up webpack development server, if you want to run in development mode with
      hot module reloading and such.
      This will start up another web server that serves up the assets for the React app separately from
      the WordPress site, so leave it running while you develop.

## 9. OPTIONAL: If you have an older version of Docker or one that doesn't support host.docker.internal

The local dev environment here is configured to use [host.docker.internal](https://docs.docker.com/docker-for-mac/networking/), which will work with Docker for Mac Desktop and some other versions of Docker.

It's what allows processes running inside the container to access services running
on ports in the host environment.

If you don't have `host.docker.internal` support for some reason, you could set up
a loopback address with the following IP from your host OS.
On Mac OS the command might look like this:

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

## 10. run `bin/setup`

This does the initial WordPress admin setup that happens first on any freshly installed WordPress
site. We're just doing it from the command line with the script to be quick and convenient.

It also adds some configs to `wp-config.php` for debugging: `WP_DEBUG`, `WP_DEBUG_LOG`, `WP_DEBUG_DISPLAY`.

By default, it will use the container named `com.fontawesome.wordpress-latest-dev`, which will be the container made from the `latest` image.

You can use a `-c <container_id>` argument to connect to run the command against a different container. This pattern is consistent across most of the scripts under `bin/`, such as `bin/wp` and `bin/php`.

After setup completes, WordPress is ready and initialized in the docker container and reachable at [http://wp.test:8765](http://wp.test:8765).

You can login to the admin dashboard at [http://wp.test:8765/wp-admin](http://wp.test:8765/wp-admin) with admin username and password as found in `.env`.

## 11. OPTIONAL: configure debugging

```bash
bin/configure-debugging
```

This will setup debugging configuration in `wp-config.php` inside the container
and will also install several plugins to power the debug bar available from the
upper right hand nav bar when logged into WordPress as admin.

## 12. Install and/or Activate the Font Awesome plugin

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

# Run phpunit

```bash
$ bin/phpunit
```

This runs `phpunit` in the default docker container. It's just a docker wrapper around the normal `phpunit` command,
so you can pass any normal `phpunit` command line arguments you might like.

To run the loader tests, use this alternate test config:

```bash
$ bin/phpunit -c phpunit-loader.xml.dist
```

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

If you do something accidentally to modify the wordpress container and put it into a weird state
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

4. Update the version in `admin/package.json`

5. Wait on changing the "Stable Tag" in `readme.txt` until after we've made the changes in the `svn` repo below.

6. Build the API docs

- make sure you have `graphviz` installed (on mac OS, you can do this with `brew install graphviz`)
- run `composer cleandocs` if you want to make sure that you're building from scratch
- run `composer install --dev` to install the dev-only phpDocumentor package 
- run `composer docs` to build the docs into the `docs/` directory

  This command will incrementally rebuild docs with any updates you make to the phpDoc
  in the source code files.
 
  See also: [Run a Local Docs Server](#run-a-local-docs-server)

  *WARNING*: look at the output from this docs command and make sure there are no
  instances of parse errors. Also manually inspect the output in `docs/` to ensure
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

Load up the `integration` WordPress environment in this repo (see above for how to do that).

Install the Font Awesome plugin from the admin dashboard by uploading the `font-awesome.zip` file
that was created in the previous step.

- activate and deactivate the plugin: expect no errors
    - use wp-cli to ensure that the `font-awesome-releases` _site_ transient has been deleted
    - the `font-awesome` option should remain
- delete/uninstall: expect no errors
    - use wp-cli to ensure that the `font-awesome` option has been deleted
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
    - deactivate all of those integration testing plugins and activate `plugin-epsilon`: expect a fatal error admin notice in the admin UI, but it should not crash WordPress or throw an exception with stack trace in the browser.  
- deactivate `plugin-gamma` and try several of those things again (without its garbage data in the API responses)
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
- ( If you know how to properly test with `plugin-sigma`--it's more complicated--go for it. )
- verify that we're not overriding `window._` (lodash), `window.React` (or any other [relevant globals](https://make.wordpress.org/core/2018/12/06/javascript-packages-and-interoperability-in-5-0-and-beyond/)). See also [this forum topic](https://wordpress.org/support/topic/lodash-overrides-window-_-underscore-js-variable/).

9. Check out and update the plugin svn repo into `wp-svn` (the scripts expect to find a subdirectory with exactly that name in that location)

To check it out initially:

```bash
svn co https://plugins.svn.wordpress.org/font-awesome wp-svn
```

If you've already checked it out, make sure it's up to date:

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

If you want to preview the built docs with a web server, you can run `composer docsrv` and then
point a web browser at `http://localhost:3000`. Composer has a default `process-timeout` of 300
seconds, so if you leave `docsrv` running for a while, composer will kill it and orphan
the node process. On macOS, you can find that process id with the shell command:
 ```
 lsof -t -i :3000
 ```
You'll probably just need to `kill` that `pid` and re-launch it.
Or to avoid the timeout hassle, just do:
```bash
cd docsrv
yarn
node index.js
```

# Special Notes on plugin-sigma

`plugin-sigma` demonstrates how a third-party plugin developer could include this Font Awesome plugin as a composer
dependency. In this scenario, the WordPress site admin does not need to separately install the Font Awesome plugin.

In order to activate it you must first run `composer install --prefer-dist` from the 
`integrations/plugins/plugin-sigma` directory.

# Remote Debugging with VSCode

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
