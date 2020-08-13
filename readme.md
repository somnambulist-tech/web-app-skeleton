# Symfony Micro Service Starter Project

This is a skeleton project that pre-configures a Symfony 5+ project for use as a micro service.
This project is intended to be used in conjunction with: [Data Service](https://github.com/somnambulist-tech/data-service-skeleton)

The setup includes:

 * messenger
 * profiler
 * command/query/domain event buses
 * test helpers
 * docker configuration for app, redis cache/sessions and nginx containers
 * docker app container is configured without local mounts
 * shell scripts in `bin/` that call libs in docker
 * PHP container uses php-fpm as the application server
 * Mutagen via SyncIt with a default configuration
 * skeleton Auth component for authenticating users against a remote API
 
Assorted readme files are included for different parts of the service setup:

 * [Compiled Containers](readme-compiled-containers.md)
 * [Service Discovery](readme-service-discovery.md)
 * [Setting up Supervisor for Tasks](readme-supervisor-tasks.md)
 * [Testing](readme-testing.md)

See [Data Service](https://github.com/somnambulist-tech/data-service-skeleton) for the main infrastructure
services and data stores.

**Note:** this project requires configuring and setting up for you environment. It will not run out
of the box. For frontend assets, no build chain has been configured. You will need to setup node / yarn
and the other tools you need.

## Getting Started

If reading from the main GitHub repository, use the GitHub link to make a repository using this template
as a base in your GitHub space. Checkout the new project.

Otherwise: fork / download the latest ZIP file and create a new git repository.

Customise the base files as you see fit; change names, (especially the service names), config values etc
to suite your needs. Then: `docker-compose up -d` to start the docker environment in dev mode.
Be sure to read [Service Discovery](readme-service-discovery.md) to understand some of how the docker
environment is setup.

### Recommended First Steps

This project uses `App` and `example.dev` throughout. Your first step would be to change the base PHP
namespace (if desired). PhpStorms refactoring / renaming is highly recommended for this action.

The domain name is set in several places, it is strongly recommended to change this to something more
useful. The following files should be updated:

 * .env
 * docker-compose*.yml
 * src/Resources/docker/<env>/web/conf.d/default.conf

You should be sure to read [Compiled Containers](readme-compiled-containers.md).

#### Configured Services

The following docker services are pre-configured for development:

 * Redis Cache
 * Redis Sessions
 * PHP-FPM 7.4
 * nginx

Test config includes base services to run the environment, however API calls will need mocking
or recording for tests to be standalone.

Release / production defines the bare minimum, customise as needed.

#### Docker Service Names

The Docker container names will be prefixed by a project name defined in the `.env` file. This is
the constant `COMPOSE_PROJECT_NAME`. If you remove it, the current folder name will be used instead.
For example: you create a new project called "invoice-service", without setting the COMPOSE constant
the containers started via `docker-compose` will be prefixed with `invoice-service_`. If you have a
lot of docker projects, they may have similar folder names, so using this constant avoids collisions.

The second constant that needs setting is `APP_SERVICE_APP`. This is the name of the PHP application
container. By default this is `app`. It is strongly recommended to change this to something that is
more unique. If you do change this, be sure to change the container name in the `docker-compose*.yml`
files otherwise it will not be used. This name is used by SyncIt to resolve the application container
and by the `bin/dc-*` scripts.

#### DNS Resolution

See [data service](https://github.com/somnambulist-tech/data-service-skeleton) for DNS / Proxy info.

## Suggested Implementation Approach

This project works best as a client / customer facing web application that consumes the API services
developed via the [micro service skeleton](https://github.com/somnambulist-tech/micro-service-skeleton) project.

Depending on the type of site you are creating, the best approach is to group related functionality into
their own namespaces. This way you copy the default folder layout to `<name>` and have multiple sets
of Application, Delivery, Domain etc folders. See `Component` for an example.

You should implement whatever DTOs, models, commands / queries you need for the functionality you
need to implement. Using the CommandBus and QueryBus can help keep your code concise and clean.

When working with Symfony Forms: bind the forms to the Command you want to dispatch to the domain service.
This way you can have total control of the form fields, validation, order and then translate that to API
calls in the command handler. Remember: the view is not necessarily the same as the entity state and
typically is a reflection of a specific point of view of the domain at a particular point in time.

For accessing APIs any API Client library can be used to make it easier, for example: [somnambulist/api-client](https://github.com/somnambulist-tech/api-client).
This library allows decorating the ApiClient instance so that API calls can be recorded for test
cases. That allows the tests to run without needing the other services.

One thing to note is that this app will be making many HTTP API calls, so appropriate caching and
loading strategies should be used to minimise page load times - this is why there are 2 redis instances:
one for sessions and one for the main cache.

## Contributing

Contributions are welcome! Spot an error, want additional docs or something better explaining? Then
create a ticket on the project, or open a PR.
