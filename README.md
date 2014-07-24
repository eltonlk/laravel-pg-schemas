# Laravel PGSchema

[![Code Climate](https://codeclimate.com/github/eltonlk/laravel-pg-schemas.png)](https://codeclimate.com/github/eltonlk/laravel-pg-schemas)

With this package you can create, switch and drop postgres schemas.

## Installation

Add the following to your `composer.json`:

    "eltonlk/laravel-pg-schemas": "dev-master"

Add to your app.php file in the services providers section.

    'providers' => array(
        ...

        'Eltonlk\LaravelPgSchemas\LaravelPgSchemasServiceProvider'
    )

## Usage

Assuming that you have your db configuration ready, meaning that
your default connection is 'pgsql' and your pgsql credentials
are setted in the usual way, you can use the next functions:

### Create new Schema

    PGSchema::create($schemaName);

### Switch to Schema

if switchTo is call without arguments, it switches to the public
schema (default)

    PGSchema::switchTo($schemaName);

### Drop Schema

    PGSchema::drop($schemaName);

### Migrate Schema

    PGSchema::migrate($schemaName);

You can also tell which database connection.

    PGSchema::migrate($schemaName, ['--database' => 'pgsql2']);
