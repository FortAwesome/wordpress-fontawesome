# First-time Setup for Development
1. Make sure Docker is installed
2. docker-compose up
3. create a .env.email file with an admin email address WordPress can use:

```
WP_ADMIN_EMAIL=some_real_address@example.com
```

4. run `./bin/setup`

WordPress is now ready and initialized in the docker container and reachable at localhost:8000
with admin username and password as found in `.env`.

# Reset WordPress Docker Environment and Remove Data Volume

`./bin/clean`

This will kill and remove docker containers and delete the data volume.

# Use wp-cli with the Dockerized WordPress Instance

`./bin/wp`

# Activate and Deactivate Plugin

`./bin/wp plugin activate font-awesome-plumbing`

`./bin/wp plugin deactivate font-awesome-plumbing`

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

- Establish the best way to load this plugin and prescribe how dependent
  themes and plugins should verify that it is active and register their requirements of it.

- Test that it works no matter the order in which plugins are loaded.
