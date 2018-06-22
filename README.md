# First-time Setup for Development
1. Make sure Docker is installed
2. docker-compose up
3. create a .env.email file with an admin email address WordPress can use:

```
WP_ADMIN_EMAIL=some_real_address@example.com
```

4. install composer (PHP package manager)

On Mac OS X, it can be installed via `brew install composer`

5. update composer dependencies: `composer install`

6. run `./bin/setup`

This does the initial admin setup that happens first on any freshly installed WordPress
site. Just doing it from the command line for convenience.

WordPress is now ready and initialized in the docker container and reachable at localhost:8000
with admin username and password as found in `.env`.

To access the WP Admin dashboard, go to `http://localhost:8000/wp-admin`.

# Reset WordPress Docker Environment and Remove Data Volume

`./bin/clean`

This will kill and remove docker containers and delete the data volume.

# Use wp-cli with the Dockerized WordPress Instance

`./bin/wp`

# Activate and Deactivate Plugin from Command Line

`./bin/wp plugin activate font-awesome`

`./bin/wp plugin deactivate font-awesome`

It can also be managed on the WP Admin Interface on the Plugins page

# Activate Integration Test Plugin and Theme

There's a `plugin-beta` and a `theme-alpha` that each are clients of this `font-awesome` plugin.
They are not involved in the unit test suite at all. But when you're playing with the with localhost:8000,
you'll probably want to activate these to see something happen.

They can be activated from WP Admin Dashboard as any Plugin or Theme would be, or from the command line:

`./bin/wp plugin activate plugin-beta`

`./bin/wp theme activate theme-alpha`

# Run phpunit

`./bin/phpunit`

# Set a boolean config in wp-config.php

`./bin/set-wp-config WP_DEBUG true`

# Some Debug Logging Related Configs

Turn on debug logging, in general. Without it, the other `WP_DEBUG_` configs don't matter:

`./bin/set-wp-config WP_DEBUG true`

Send debug logging to the log file, which will be found at `wp-content/debug.log`, and written to by calls to `error_log()`:

`./bin/set-wp-config WP_DEBUG_LOG true`

Display debug logging in the browser:

`./bin/set-wp-config WP_DEBUG_DISPLAY true`

More on debugging on WordPress:

https://codex.wordpress.org/Debugging_in_WordPress

# Development Roadmap

- Test that it works no matter the order in which plugins are loaded.

- Add diagnostic output to Admin settings page that shows what other attempts to load Font Awesome may have
  happened outside of our control and which probably produce runtime conflicts.

- Populate lists like "versions available" from a REST endpoint yet to be built.
