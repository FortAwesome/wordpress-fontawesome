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
