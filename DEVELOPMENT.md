# First-time Setup for Development
1. Make sure Docker is installed

2. `bin/prepare`

This creates a customized docker image tagged `wordpress-fontawesome-dev` locally to be used
for the wordpress container. It may take a while to build the first time, but once it's built,
it doesn't need to be rebuilt with this script unless the `Dockerfile` changes.

3. `docker-compose up`

Run this from the top-level directory that contains the `docker-compose.yml` config file.

Leave this running in one terminal window and do the rest of this in some other terminal windows.

This runs the docker compose configuration that brings up the containers running wordpress and mysql.
It will all be configured automatically for you with the scripts below.

4. create a .env.email file in the root of the repository with an admin email address WordPress can use:

```
WP_ADMIN_EMAIL=some_real_address@example.com
```

5. install composer (PHP package manager)

On Mac OS X, it can be installed via `brew install composer`

6. update composer dependencies from the `font-awesome` directory

```
composer install
```

7. Build our plugin's admin UI React app

This is necessary before loading our plugin's admin page in WordPress because the assets for the
React app are not checked in to this repo—they must be built. There are two options for building:

In one terminal window, `cd admin`, and then:

  (a) `yarn`

  (b) Development mode: `yarn start` to fire up webpack development server, if you want to run in development mode with
      hot module reloading and such (which is probably what you should be doing if you're developing).
      This will start up another web server that serves up the assets for the React app separately from
      the WordPress site, so leave it running while you develop.

  (c) Production mode: You can also use `yarn build` to build production optimized assets into the `admin/build`
      directory. In order to get the WordPress plugin to load these, you also need to temporarily change
      the `FONTAWESOME_ENV` variable in `.env` to something other than "development", or just remove it.
      Change that setting before trying to load the plugin admin page in your browser.
      (But don't commit that change, because we want the default environment to remain "development")

8. Configure a loopback network address so the docker container can talk to your docker host

One way to set that up on your host is (on Mac OS):

`sudo ifconfig lo0 alias 169.254.254.254`

Context:

With our current configuration, the docker container in which the wordpress server runs may need to access
your host OS for a couple of things:

- PHP debugging port
- Webpack dev server port for React hot module reloading

The normal paradigm for Docker is not to allow the containers to access the host's network. That's generally
appropriate, given Docker's goals to create a clean, isolated, and secure environment.
However, we kinda know what we're doing here, and it's only for development purposes on our local development
machines, so it's reasonable to set up a loopback address on the host that will allow the containers to
reach the host network for the purposes listed above. (I know, there are less [hacky ways](https://docs.docker.com/docker-for-mac/networking/#use-cases-and-workarounds) to do this,
and we need to clean up this part of the environment setup at some point. But this works on Mac OS where
some of the simpler methods do not. NOTE: on non-Mac host OSes the command line comparable to
the `ifconfig` command above may be different. Read your man pages or something.)

The result will be a line is added to the `/etc/hosts` in the container that assigns the hostname `dockerhost`
to that IP Address, and that's the address used by the Apache config, for example, for proxying some requests
over to the webpack dev server running on `http://dockerhost:3030`.

If you need to change which loopback IP address is used for some reason, it's configured in `docker-compose.yml`.

(TODO: change configuration to use [`host.docker.internal`](https://docs.docker.com/docker-for-mac/networking/#use-cases-and-workarounds) for Mac OS and the equivalent for other host OSes)

9. run `bin/setup`

This does the initial WordPress admin setup that happens first on any freshly installed WordPress
site. We're just doing it from the command line with the script to be quick and convenient.

It also adds some configs to `wp-config.php` for debugging: `WP_DEBUG`, `WP_DEBUG_LOG`, `WP_DEBUG_DISPLAY`.

WordPress is now ready and initialized in the docker container and reachable at localhost:8080
with admin username and password as found in `.env`.

10. Login to the WordPress admin dashboard and activate the Font Awesome plugin

To access the WP Admin dashboard, go to `http://localhost:8080/wp-admin`.

After activating the plugin you can access the Font Awesome admin page here:
`http://localhost:8080/wp-admin/options-general.php?page=font-awesome`

Or you'll find it linked on the left sidebar under Settings.

# Reset WordPress Docker Environment and Remove Data Volume

`./bin/clean`

This will kill and remove docker containers and delete the data volume.

If you do something accidentally to modify the wordpress container and put it into a weird state
somehow, or even if you just want to re-initialize the whole WordPress environment (i.e. the app and the mysql db),
this is how you can do it. Run `bin/clean` and then fire up a fresh environment with `docker-compose up`.

# Use wp-cli with the Dockerized WordPress Instance

`./bin/wp`

The WP-CLI is helpful for a variety of WordPress tasks and diagnostics, you can run the WP-CLI
within a docker container that accesses the containerized wordpress instance using this script,
passing arguments to it just like you would the normal `wp` command-line. This is just a dockerizing wrapper.

# Activate and Deactivate Plugin from Command Line

`./bin/wp plugin activate font-awesome`

`./bin/wp plugin deactivate font-awesome`

It can also be managed on the WP Admin Interface on the Plugins page

# Activate Integration Test Plugins and Theme

There's a `plugin-beta` and a `theme-alpha` that each are clients of this `font-awesome` plugin.
They are not involved in the unit test suite at all. But when you're playing with the with localhost:8080,
you'll probably want to activate these to see something happen.

They can be activated from WP Admin Dashboard as any Plugin or Theme would be, or from the command line:

`./bin/wp plugin activate plugin-beta`

`./bin/wp theme activate theme-alpha`

# To Cut a Release

1. Update the Changelog at the end of readme.txt

2. Update the plugin version in the header comments of `font-awesome.php`

3. Update the plugin version const in `includes/class-fontawesome.php`

4. Update "Stable Tag" in readme.txt to set it to the same version, assuming we're going to be making a new tag for release

5. Build the API docs

- make sure you have `graphviz` installed (on mac OS, you can do this with `brew install graphviz`)
- run `composer cleandocs` if you want to make sure that you're building from scratch
- run `composer install --dev` to install the dev-only phpDocumentor package 
- run `composer docs` to build the docs into the `docs/` directory

  This command will incrementally rebuild docs with any updates you make to the phpDoc
  in the source code files.
 
  See also: [Run a Local Docs Server](#run-a-local-docs-server)

- `git add docs` to stage them for commit (and eventually commit them) 

6. Build production admin app and WordPress distribution layout into `wp-dist` 

```bash
$ composer dist
```

This will delete the `vendor` directory, and previous build assets, and will re-install
the composer bundle in production mode (`--no-dev --prefer-dist`) and produce the following:

`wp-dist/`: the contents of this directory should be move into the svn repo for the WordPress plugin
that will be published through the WordPress plugins directory.

`font-awesome.zip`: a zip file of the contents of `wp-dist` with path names fixed up.
This zip file can be distributed as a download for the WordPress plugin and used for installing
the plugin by "upload" in the WordPress admin dashboard.

`admin/build`: production build of the admin UI React app. This need to be committed so that it
can be included in the composer package (which is really just a pull of this repo)  

7. `git add` and `git commit` all that would have been changed so far:

- `docs/`
- `admin/build`
- `font-awesome.php`
- `includes/font-awesome.php`
- `readme.txt`

8. `git push` to GitHub remote

Release commits can be pushed directly to `master`, if there are several commits, push to a topic branch and squash/merge
them into `master`.

9. Create a GitHub release that references that new commit

10. Check out the plugin svn repo into `wp-svn`

From the root of this git repo:

```bash
svn co https://plugins.svn.wordpress.org/font-awesome wp-svn
```

11. Copy plugin directory assets and wp-dist layout into `wp-svn/trunk`

```bash
$ composer dist2trunk
```

12. Create the new svn tag

(Suppose our new version being tagged for release, the version written as the Stable Tag into readme.txt and the
other various locations above.)

```bash
$ cd wp-svn
$ svn add trunk/*
$ svn cp trunk tags/42.1.2 
```

13. Add and check in the changes to svn.

The `svn ci` is what publishes the plugin code to the WordPress plugins directory.

```bash
$ svn ci -m 'Release 42.1.2'
```

You may need to add username and password options on this command if you're not otherwise authenticated to svn.

[See also tips on using SVN with WordPress Plugins](https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion/#editing-existing-files).

## Run a Local Docs Server

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

## Special Notes on plugin-sigma

`plugin-sigma` demonstrates how a third-party plugin developer could include this Font Awesome plugin as a composer
dependency. In this scenario, the WordPress site admin does not need to separately install the Font Awesome plugin.

In order to activate it you must first run `composer install --prefer-dist` from the 
`integrations/plugins/plugin-sigma` directory.

# Run phpunit

`./bin/phpunit`

This runs `phpunit` in the docker container. It's just a docker wrapper around the normal `phpunit` command,
so you can pass any normal `phpunit` command line arguments you might like. Given no arguments, the default
is just to run the whole test suite.

# Set a boolean config in wp-config.php

`./bin/set-wp-config WP_DEBUG true`

(Though this particular config is already set automatically in `bin/setup`.)

# Configure PhpStorm 2018.1.5 for debugging in the container

This is pretty advanced, and also not necessary for development—it's just a nice toolset to have available.
So beware: your mileage may vary.

1. Add a CLI interpreter

Preferences -> Languages & Frameworks -> PHP

![add cli interpreter](images/create_cli_interpreter_before.png)

Add a new CLI interpreter with Docker Compose. We'll call it `wordpress-fontawesome-debug`.

![configure cli interpeter](images/configure_cli_interpreter.png)

* Enter `./docker-compose.yml` for the configuration file.
* Service: `wordpress`
* PHP Executable: php
* Debugger extension: xdebug.so
* Configuration options:
  * xdebug.remote_enable=1
  * xdebug.remote_host=docker.for.mac.localhost
  * xdebug.remote_port=9000
  * xdebug.remote_mode=jit

2. Configure Debugging

The defaults may be fine, but the key is to uncheck the option circled in the screenshot.

[See also](https://intellij-support.jetbrains.com/hc/en-us/community/posts/360000229624-Setting-up-xDebug-with-PHPUnit-using-Docker-for-Mac-and-PHPStorm)

![configure debugging](images/configure_debugging.png)

3. Configure Test Framework

Our test framework is PHPUnit, and it will run "remotely", because it's in a Docker container.

![create test framework](images/create_test_framework.png)

![configure test framework](images/configure_test_framework.png)

* CLI Interpreter: select the one we created previously.
* Path mappings: these should be auto-populated, based on the `docker-compose.yml` being used by our CLI interpreter. If not, then look at the `docker-compose.yml`
  to guide you in setting up path mappings. For example, your host directory `/Users/you/repos/wordpress-fontawesome/font-awesome` should map to container
  directory `/var/www/html/wp-content/plugins/font-awesome`.
* Path to phpunit.phar: this should be the full path _inside_ the container.
* Default configuration file and Default bootstrap file: these are also full paths _inside_ the container.


4. Create Run and Test Configurations

(Menu) Run -> Edit Configurations...

For running and debugging tests:

![test run configuration](images/test_configuration.png)

This is where you can configure which tests run when you invoke this test runner. You could create more than one test configuration
for conveniently running different test groups. In this pictured configuration, we're just using the test configuration file that
  we previously configured for use by the Test Framework.

To run that run configuration, you can select it here (red arrow) and then either run it normally or run it under debugging (green arrows):

![run test configuration](images/run_test_configuration.png)

## Gotcha: `wordpress-fontawesome_phpstorm_helpers_1` container fails to start

It may throw an error like "network \<some_big_hex_value\> not found".

This happens, apparently, when _after_ you initially set up this configuration, you change the network id for the Docker Compose compose container.
And this could happen if you ran `docker-compose down` or ran the local `bin/clean`. These tear down the network as well as the container.
But PhpStorm creates a `php_helper` container and associates it wih this network. So if you remove the network, it will fail miserably.

A solution is just to remove that container and then try again in PhpStorm. It will just recreate that helper container and  associate it with the
new `docker-compose` network.

There's more than one way to delete that container, but one way is to find the container's name and run:
* `docker container stop wordpress-fontawesome_phpstorm_helpers_1`
* `docker container rm wordpress-fontawesome_phpstorm_helpers_1`

