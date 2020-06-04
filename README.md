# Oddin Web Interface

## How to run

Define the environment variables described in `docker-compose.yml`, following the Docker Compose requirements. You can either define in a `.env` file on root, or set the values in `docker-compose.override.yml`, or even better, use the [local-environment](https://github.com/oddin-org/local-environment)

Remember that WS_URL should point to a service which have the same API as our default [Web Service](https://github.com/oddin-org/local-environment), you can choose to use [API Sprout](https://github.com/danielgtaylor/apisprout), [Mountebank](http://www.mbtest.org/), [Hock](https://github.com/mmalecki/hock), etc.

After you've everything set-up, access the application through a port on your host machinge that you bound to `3000` on `docker-compose.override.yml`, or access `oddin.localhost` when using the *local-environment*
